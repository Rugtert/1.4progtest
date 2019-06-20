<?php
include_once "./templates/Header.php"; //CSS en HTML Header.
require_once "./functies/Common.php"; // Bevat algemene functies die op meerdere plaatsen gebruikt kunnen worden.
require_once "./functies/Leden_Functies.php" // Bevat functies specifiek voor deze pagina
?>


<?php //SQL Prepared Statements

//Lid aanpassen in de database.
$LidAanpassenQuery = $pdo->prepare("Update Lid SET 
               Voornaam = :Voornaam, 
               Voorvoegsel = :Voorvoegsel,
               Achternaam = :Achternaam,
               Straatnaam = :Straatnaam,
               Huisnummer = :Huisnummer,
               Woonplaats = :Woonplaats,
               Postcode = :Postcode,
               Telefoonnummer = :Telefoonnummer,
               Emailadres = :Emailadres,
               Geboortedatum = :Geboortedatum 
             Where Lid_nr = :Lid_nr");

//Lid toevoegen aan de database.
$LidToevoegenQuery = $pdo->prepare('INSERT INTO Lid (
               Voornaam, 
               Voorvoegsel,
               Achternaam,
               Straatnaam,
               Huisnummer,
               Woonplaats,
               Postcode,
               Telefoonnummer,
               Emailadres,
               Geboortedatum 
            )
            VALUES (
			    :Voornaam, 
                :Voorvoegsel,
                :Achternaam,
                :Straatnaam,
                :Huisnummer,
                :Woonplaats,
                :Postcode,
                :Telefoonnummer,
                :Emailadres,
                :Geboortedatum)');

//Lid verwijderen uit de database.
$LidVerwijderenQuery = $pdo->prepare('DELETE FROM Lid WHERE Lid_nr = :Lid_nr')
?>

<?php // $_POST acties
if (isset($_POST['Toevoegen'])) {// Voegt een lid toe met de gegevens uit $_POST als $_POST['Toevoegen'] bestaat.
    $LidToevoegenQuery->execute(array(
        ":Voornaam" => $_POST["Voornaam"],
        ":Voorvoegsel" => $_POST["Voorvoegsel"],
        ":Achternaam" => $_POST["Achternaam"],
        ":Straatnaam" => $_POST["Straatnaam"],
        ":Huisnummer" => $_POST["Huisnummer"],
        ":Woonplaats" => $_POST["Woonplaats"],
        ":Postcode" => $_POST["Postcode"],
        ":Telefoonnummer" => $_POST["Telefoonnummer"],
        ":Emailadres" => $_POST["Emailadres"],
        ":Geboortedatum" => $_POST["Geboortedatum"]
    ));
    echo "";
}

if (isset($_POST['Aanpassen'])) {// Als $_POST['Aanpassen'] ingevuld is wordt het lid $_POST['Lid_nr'] aanpast met de variabelen uit de array $_POST
    $LidAanpassenQuery->execute(array(
            ":Voornaam" => $_POST["Voornaam"],
            ":Voorvoegsel" => $_POST["Voorvoegsel"],
            ":Achternaam" => $_POST["Achternaam"],
            ":Straatnaam" => $_POST["Straatnaam"],
            ":Huisnummer" => $_POST["Huisnummer"],
            ":Woonplaats" => $_POST["Woonplaats"],
            ":Postcode" => $_POST["Postcode"],
            ":Telefoonnummer" => $_POST["Telefoonnummer"],
            ":Emailadres" => $_POST["Emailadres"],
            ":Geboortedatum" => $_POST["Geboortedatum"],
            ":Lid_nr" => $_POST["Lid_nr"])
    );
}


if (isset($_POST['Verwijderen'])) {// Als $_POST['Verwijderen'] ingevuld is wordt het lid $_POST['Lid_nr'] verwijderd.
    $LidVerwijderenQuery->execute(array(":Lid_nr" => $_POST["Lid_nr"]));
}
?>

<?php
//vraagt leden op uit de tabel "lid" en plaatst ze in de variabele $Leden. Dit wordt gebruikt om de gegevens van de leden in te vullen.
$Leden = $pdo->query("SELECT * FROM lid")->fetchAll();

//Vraagt leden op met uitgeleende boeken. Wordt gebruikt om de functie GetOpenstaandeBoeteBedragenVanLid van Lid_nr's te voorzien.
$lening = $pdo->query(
    "SELECT Lid_nr, Boetetarief,Uitleengrondslag,Uitleentijdstip FROM exemplaar 
			INNER JOIN Lening ON exemplaar.Boek_nr = lening.Boek_nr
			WHERE lening.Inleverdatum IS NULL")->fetchAll();
?>
    <div class="container-fluid">
        <div class="table">
            <table id="leden" class="table table-striped table-hover">
                <thead>
                <tr>
                    <!--Header maken met de functie TableHeaderWriter (zie /fucnties/Leden_Functies.php)-->
                    <?php echo TableHeaderWriter(array("Lid Nummer","Naam","Adres","Telefoonnummer","Emailadres","Geboortedatum","Openstaande boete","","<a href=\"#Toevoegenlid\" class=\"btn btn-success\" data-toggle=\"modal\" data-target=\"#Toevoegenlid\" style=\"display: block\" >Aanmaken</a>"));?>
                </tr>
                <tr>
                    <?php for ($i = 0; $i <= 6; $i++) {// 7 zoekveldjes maken met de functie TableHeaderWriter. LidFilters($i) voert de javascript functie "LidFilters" onderaan de pagina uit.
                        echo TableHeaderWriter(array("<input type=\"text\" id=\"Invoer$i\" onkeyup=\"LidFilters($i)\" placeholder=\"Zoeken...\">"));
                    }
                    echo TableHeaderWriter(array("",""));?>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($Leden as $Lid) :// Loop door elk resultaat uit de array $Leden. Zet de lidgegevens in een tabel.
                    ?>
                    <tr>
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
                        <td><?php echo $Lid["Telefoonnummer"] ?></td>
                        <td><?php echo $Lid["Emailadres"] ?></td>
                        <td><?php echo $Lid["Geboortedatum"] ?></td>
                        <td><?php echo "&euro;" . GetOpenstaandeBoeteBedragenVanLid($lening, $Lid["Lid_nr"]); //Berekent en vult de boetebedragen in ?></td>
                        <!-- Aanpasknop, verwijst naar div id Aanpassenlid$Lid["Lid_nr"] -->
                        <td><a href="#Aanpassenlid<?php echo $Lid["Lid_nr"]; ?>" class="btn btn-primary" style="display: block" data-toggle="modal" data-target="#Aanpassenlid<?php echo $Lid["Lid_nr"]; ?>">Aanpassen</a></td>
                        <!-- Verwijderknop, verwijst naar div id Verwijderenlid$Lid["Lid_nr"] -->
                        <td><a href="#Verwijderenlid<?php echo $Lid["Lid_nr"]; ?>" class="btn btn-danger" style="display: block" data-toggle="modal" data-target="#Verwijderenlid<?php echo $Lid["Lid_nr"]; ?>">Verwijderen</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
/*Maakt het dialoogvenster "Toevoegenlid" aan.
Dit dialoogvenster geeft de waarde $_POST[Toevoegen] mee als op de "toevoegen" knop in het dialoogvenster geklikt wordt.
De waarde $_POST[Toevoegen] wordt gebruikt om te controleren of het toevoegen uitgevoerd moet worden.
$key wordt als label en naam voor het inputveld gebruikt.
*/
$keys = GetTableKeys("Lid", $pdo); // Zet de kolomnamen (keys) van de tabel "Lid" in de array $keys met behulp van de functie "GetTableKeys".
?>
    <div id="Toevoegenlid" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="Leden.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Lid Toevoegen</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php
                        foreach ($keys as $key) : // Formulier aanmaken
                            ?>
                            <div class="form-group">
                                <?php if ($key == 'Lid_nr') {// Lid nummer is een Auto-Increment waarde in de database en wordt dus niet meegenomen of invulbaar gemaakt.
                                } elseif ($key == "Geboortedatum") {
                                    echo "<label>$key<br><input type=\"date\" class=\"form-control\" name=\"$key\"></label>";//label en invoerveld. ↓ = etc...
                                } elseif ($key == "Voorletter") {
                                    echo "<label>$key<br><input type=\"text\" class=\"form-control\" name=\"$key\" maxlength=\"1\"></label>";
                                } elseif ($key == "Huisnummer") {
                                    echo "<label>$key<br><input type=\"Number\" class=\"form - control\" name=\"$key\" min=\"0\" max=\"99999\"></label>";
                                } elseif ($key == "Postcode") {
                                    echo "<label>$key<br><input type=\"Text\" class=\"form - control\" name=\"$key\" maxlength=\"6\"></label>";
                                } elseif ($key == "Postcode") {
                                    echo "<label>$key<br><input type=\"Text\" class=\"form - control\" name=\"$key\" maxlength=\"6\"></label>";
                                } elseif ($key == "Telefoonnummer") {
                                    echo "<label>$key<br><input type=\"Text\" class=\"form - control\" name=\"$key\" maxlength=\"10\"></label>";
                                } elseif ($key == "Emailadres") {
                                    echo "<label>$key<br><input type=\"email\" class=\"form - control\" name=\"$key\" maxlength=\"255\"></label>";
                                } else {
                                    echo "<label>$key<br><input type=\"text\" class=\"form - control\" name=\"$key\"></label>";
                                } ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-primary" data-dismiss="modal" value="Annuleren">
                        <input type="submit" class="btn btn-success" name="Toevoegen" value="Toevoegen">
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
/*Maakt het dialoogvenster "Aanpassenlid" aan.
Dit dialoogvenster geeft de waarde $_POST[Aanpassen] mee als op de "Aanpassen" knop in het dialoogvenster geklikt wordt.
De waarde $_POST[Aanpassen] wordt gebruikt om te controleren of het Aanpassen uitgevoerd moet worden.
$key wordt als label en naam voor het inputveld gebruikt. $value is de huidige waarde in uit de database.
*/
foreach ($Leden as $Lid) :
    ?>
    <div id="Aanpassenlid<?php echo $Lid['Lid_nr']; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="Leden.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Aanpassen lid <?php echo $Lid['Lid_nr']; ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php
                        foreach ($Lid as $key => $value) : //Formulier aanmaken
                            ?>
                            <div class="form-group">
                                <?php if ($key == 'Lid_nr') {//Lid_nr wordt een readonly field zodat deze niet aanpasbaar is maar wel meegenomen wordt in $_POST.
                                    Echo "<label>$key<br><input type=\"text\" class=\"form-control\" name=\"$key\" value=\"$value\" readonly></label>"; //label en invoerveld. ↓ = etc...
                                } elseif ($key == "Geboortedatum") {
                                    echo "<label>$key<br><input type=\"date\" class=\"form-control\" name=\"$key\" value=\"$value\"></label>";
                                } elseif ($key == "Voorletter") {
                                    echo "<label>$key<br><input type=\"text\" class=\"form-control\" name=\"$key\" value=\"$value\" maxlength=\"1\"></label>";
                                } elseif ($key == "Huisnummer") {
                                    echo "<label>$key<br><input type=\"Number\" class=\"form-control\" name=\"$key\" value=\"$value\" min=\"0\" max=\"99999\"></label>";
                                } elseif ($key == "Postcode") {
                                    echo "<label>$key<br><input type=\"Text\" class=\"form-control\" name=\"$key\" value=\"$value\" maxlength=\"6\"></label>";
                                } elseif ($key == "Postcode") {
                                    echo "<label>$key<br><input type=\"Text\" class=\"form-control\" name=\"$key\" value=\"$value\" maxlength=\"6\"></label>";
                                } elseif ($key == "Telefoonnummer") {
                                    echo "<label>$key<br><input type=\"Text\" class=\"form-control\" name=\"$key\" value=\"$value\" maxlength=\"10\"></label>";
                                } elseif ($key == "Emailadres") {
                                    echo "<label>$key<br><input type=\"email\" class=\"form-control\" name=\"$key\" value=\"$value\" maxlength=\"255\"></label>";
                                } else {
                                    echo "<label>$key<br><input type=\"text\" class=\"form-control\" name=\"$key\" value=\"$value\"></label>";
                                } ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-primary" data-dismiss="modal" value="Annuleren">
                        <input type="submit" class="btn btn-success" name="Aanpassen" value="Aanpassen">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
endforeach
?>

<?php /*Maakt het dialoogvenster "Verwijderenenlid" aan.
		Dit dialoogvenster geeft de waarde $_POST[Aanpassen] mee als op de "Aanpassen" knop in het dialoogvenster geklikt wordt.
		De waarde $_POST[Aanpassen] wordt gebruikt om te controleren of het Aanpassen uitgevoerd moet worden.
		$key wordt als label en naam voor het inputveld gebruikt.
		*/
$LedenMetGeleendeBoeken = GetArrayLedenMetGeleendeBoeken($pdo); // Controleert of een lid nog boeken heeft geleend
foreach ($Leden as $Lid) :
    ?>
    <div id="Verwijderenlid<?php echo $Lid['Lid_nr']; ?>" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php if (in_array($Lid['Lid_nr'], $LedenMetGeleendeBoeken)) { // Formulier wordt met een alternatieve titel en een tabel gemaakt als het Lid_nr voorkomt in $LedenMetGeleendeBoeken.?>
                    <form method="post" action="Leden.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Het lid heeft onderstaande boeken nog geleend! Weet je zeker dat je lid <?php echo $Lid['Lid_nr']; ?> wilt verwijderen?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <div class="table-title">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h2><b>Overzicht Boeken</b></h2>
                                        </div>
                                    </div>
                                </div>
                                <table id="leden" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <?php echo TableHeaderWriter(array("Boek Nummer","Titel","ISBN"));?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ((GetBoekenOpDitMomentGeleend($pdo)) as $GeleendBoek) : // Geleende boeken in tabel plaatsen
                                        if ($GeleendBoek["lid_nr"] == $Lid["Lid_nr"]) { // Voert alleen onderstaande regels uit als de huidige rij van de array $Geleendboek een lidnummer bevat dat matcht met $Lid['Lid_nr'].?>
                                            <tr>
                                                <td><?php echo $GeleendBoek['Boek_nr'] ?></td>
                                                <td><?php echo $GeleendBoek['Titel'] ?></td>
                                                <td><?php echo $GeleendBoek['ISBN'] ?></td>
                                            </tr>
                                        <?php } endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="Lid_nr" Value="<?php echo $Lid['Lid_nr']; ?>">
                            <input type="button" class="btn btn-primary" data-dismiss="modal" value="Annuleren">
                            <input type="submit" class="btn btn-danger" name="Verwijderen" value="Verwijderen">
                        </div>
                    </form>
                <?php } else { ?>
                    <form method="post" action="Leden.php">
                        <div class="modal-header">
                            <h4 class="modal-title"> Weet je zeker dat je lid nummer <?php echo $Lid['Lid_nr']; ?> wilt verwijderen?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="Lid_nr" Value="<?php echo $Lid['Lid_nr']; ?>">
                            <input type="button" class="btn btn-primary" data-dismiss="modal" value="Annuleren">
                            <input type="submit" class="btn btn-danger" name="Verwijderen" value="Verwijderen">
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
endforeach
?>
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
<?php include "./Templates/footer.php"; ?>