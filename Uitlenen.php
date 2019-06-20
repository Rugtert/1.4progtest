<?php include "./Templates/Header.php";
include_once "./functies/Common.php" ?>

<?php //SQL Queries
$UitleenQuery = $pdo->prepare('INSERT INTO Lening (
                    Boek_nr, 
                    Lid_nr
            )
            VALUES (
                    :Boek_nr,
                    :Lid_nr
                    )
            ');
if (isset($_GET["Boek_nr"])) {
    $UitTeLenenBook = $pdo->query(
        "SELECT Exemplaar.Boek_nr, b.titel, b.isbn FROM exemplaar 
    JOIN boek b on exemplaar.ISBN = b.ISBN 
    WHERE Boek_nr = $_GET[Boek_nr]"
    )->fetch();
}
?>

<?php //$_POST Acties
If (isset($_POST['Uitlenen']) or isset($_GET["Boek_nr"])) {
    $Algeleend = $pdo->query("select count(Lid_nr) AS Aantal from lening where Boek_nr = $_REQUEST[Boek_nr] AND (lening.Uitleentijdstip IS NOT NULL AND (lening.Inleverdatum > CURDATE() OR lening.Inleverdatum IS NULL))")->fetch();
    if ($Algeleend["Aantal"]  > 0) {
        Die("Dit boek is al uitgeleend");} Elseif (!isset($_GET["Boek_nr"])) {
        $UitleenQuery->execute(array(
            ":Boek_nr" => $_POST["Boek_nr"],
            ":Lid_nr" => $_POST["Lid_nr"]
        ));
        $result = $pdo->query("Select * from lening where Uitleentijdstip = (Select max(Uitleentijdstip) from lening)")->fetch();
        echo "<h1 class='confirmation'>Het boek met Boek_nr " . $result["Boek_nr"] . " is uitgeleend aan het lid met nummer " . $result["Lid_nr"] . " op tijdstip " . $result["Uitleentijdstip"];
        die();
    }
}
$Leden = $pdo->query("SELECT * FROM lid")->fetchAll();

?>
<div class="container-fluid">
    <h1> Uitlenen boek_nr: <?php echo $UitTeLenenBook["Boek_nr"]; ?>, Titel: <?php echo $UitTeLenenBook["titel"]; ?>, ISBN: <?php echo $UitTeLenenBook["isbn"]; ?></h1>
    <div class="container-fluid">
        <div class="table">
            <table id="leden" class="table table-striped table-hover">
                <thead>
                <tr>
                    <?php echo TableHeaderWriter(array("Lid nummer","Naam","Adres","Geboortedatum","Aan dit lid uitlenen"))?>
                <tr>
                    <?php for ($i = 0; $i <= 3; $i++) {// 7 zoekveldjes
                        echo TableHeaderWriter(array("<input type=\"text\" id=\"Invoer$i\" onkeyup=\"LidFilters($i)\" placeholder=\"Zoeken...\">"));
                    } ?>
                    <th><!--Uitleenknop--></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($Leden as $Lid) :// Loop door elk resultaat uit de array $Leden. Zet de lidgegevens in een tabel.
                    ?>
                    <form method="post" action="Uitlenen.php">
                        <tr>
                            <input type="hidden" name="Lid_nr" Value="<?php echo $Lid['Lid_nr']; ?>">
                            <input type="hidden" name="Boek_nr" Value="<?php echo $_GET['Boek_nr']; ?>">
                            <td><?php echo $Lid["Lid_nr"]; ?></td>
                            <td><?php
                                if (!empty($Lid["Voorvoegsel"])) { // Als $Lid["Voorvoegsel"] niet leeg is wordt de naam incl voorvoegsel ingevuld
                                    echo $Lid["Voornaam"] . " " . $Lid["Voorvoegsel"] . " " . $Lid["Achternaam"];
                                } else {
                                    echo $Lid["Voornaam"] . " " . $Lid["Achternaam"]; // En anders niet.
                                }
                                ?>
                            </td>
                            <td><?php echo $Lid['Straatnaam'] . " " . $Lid['Huisnummer'] . ", " . $Lid['Postcode'] . " " . $Lid['Woonplaats'] ?></td>
                            <td><?php echo $Lid["Geboortedatum"] ?></td>
                            <td><input type="submit" class="btn btn-success" name="Uitlenen" value="Uitlenen"></td>
                        </tr>
                    </form>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



    <script>
        function LidFilters(col) {
            // Variabelen
            let input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("Invoer" + col);
            filter = input.value.toUpperCase();
            table = document.getElementById("leden");
            tr = table.getElementsByTagName("tr");

            // Controleert of er cellen zijn die de tekenreeks van variabele "filter" bevatten.
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[col];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>