<?php include "./Templates/Header.php";
include_once "./functies/Common.php" ?>

<?php //SQL Query's
// Wordt gebruikt om boeken uit te lenen.
$UitleenQuery = $pdo->prepare('INSERT INTO Lening (
                    Boek_nr, 
                    Lid_nr
            )
            VALUES (
                    :Boek_nr,
                    :Lid_nr
                    )
            ');
if (isset($_GET["Boek_nr"])) { //opvragen van de boekgegevens als $_Get["Boek_nr"] bestaat. Wordt gebruikt om informatie over het uit te lenen boek te tonen.
    $UitTeLenenBook = $pdo->query(
        "SELECT Exemplaar.Boek_nr, b.titel, b.isbn FROM exemplaar 
    JOIN boek b on exemplaar.ISBN = b.ISBN 
    WHERE Boek_nr = $_GET[Boek_nr]"
    )->fetch();
}
?>

<?php //$_POST Acties
If (isset($_POST['Uitlenen']) or isset($_GET["Boek_nr"])) { // Controleert of een boek uitgeleend kan worden als $_POST['Uitlenen'] of $_GET["Boek_nr"] ingesteld zijn
    $Algeleend = $pdo->query( // Vraagt de hoeveelheid geleende boeken met het boek_nr $_REQUEST[Boek_nr} op waar het uitleentijdstip niet ontbreekt en de inleverdatum niet ingevuld of in de toekomst is.
        "select count(Lid_nr) AS Aantal, Lid_nr, Boek_nr 
                        from lening 
                        where Boek_nr = $_REQUEST[Boek_nr] AND (lening.Uitleentijdstip IS NOT NULL AND (lening.Inleverdatum > CURDATE() OR lening.Inleverdatum IS NULL))")->fetch();
    if ($Algeleend["Aantal"] > 0) { // Conditie = 0 als het boek op dit moment niet is uitgeleend. Executie van code stopt met het maken van een waarschuwingsschermpje als het aantal > 0 is
        Die("<div class=\"card warn\">
            <div class=\"card-header\">
                <h2>Waarschuwing</h2>
            </div>
            <div class=\"card-body\">
                <p>Boek nummer " . $Algeleend["Boek_nr"] . " is al uitgeleend aan lid met lidnummer " . $Algeleend["Lid_nr"] . "</p>
            </div>
        </div>");
    } Elseif (!isset($_GET["Boek_nr"])) {// Conditie = 0 als het boek op dit moment niet is uitgeleend.
        $UitleenQuery->execute(array( //Boek uitlenen.
            ":Boek_nr" => $_POST["Boek_nr"],
            ":Lid_nr" => $_POST["Lid_nr"]
        ));
        $result = $pdo->query("Select * from lening where Uitleentijdstip = (Select max(Uitleentijdstip) from lening)")->fetch(); // Laatst aangemaakte Uitlening opvragen om te bevestigen dat het uitlenen is gelukt.
        die( // Executie van code stopt met het aanmaken van een informatieschermpje dat de bewerking bevestigd
            "<div class=\"card info\">
            <div class=\"card-header\">
                <h2>Informatie</h2>
            </div>
            <div class=\"card-body\">
                <p>Het boek met Boek_nr " . $result["Boek_nr"] . " is uitgeleend aan het lid met nummer " . $result["Lid_nr"] . " op tijdstip " . $result["Uitleentijdstip"] . "</p>                
            </div>
        </div>");
    }
}
$Leden = $pdo->query("SELECT * FROM lid")->fetchAll(); // Leden opvragen zodat een lid om aan uit te lenen kan worden geselecteerd.

?>
<div class="container-fluid">
    <h1 class="BigMessage"> Uitlenen boek_nr: <?php echo $UitTeLenenBook["Boek_nr"]; ?>, Titel: <?php echo $UitTeLenenBook["titel"]; ?>, ISBN: <?php echo $UitTeLenenBook["isbn"]; ?></h1>
    <div class="container-fluid">
        <div class="table">
            <table id="leden" class="table table-striped table-hover">
                <thead>
                <tr>
                    <?php echo TableHeaderWriter(array("Lid nummer", "Naam", "Adres", "Geboortedatum", "Aan dit lid uitlenen")) ?>
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
                            <td style="text-align: center;"><?php echo $Lid["Lid_nr"]; ?></td>
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
    function LidFilters(col) { // Voegt filter-functionaliteit toe aan de tabel leden
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
<?php include "./Templates/Footer.php"; ?>