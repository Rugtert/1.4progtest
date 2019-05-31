<?php
include "./templates/Header.php"; //CSS en HTML Header.
//require "./functies/Common.php"; //bevat algemene functies die op meerdere plaatsen gebruikt kunnen worden.
require "./functies/Common_PDO.php"; //bevat algemene functies die op meerdere plaatsen gebruikt kunnen worden.
?>

<?php
# onderstaande functies zijn toegevoegd om aan de toetseisen te voldoen. Ze worden niet in het programma gebruikt maar worden wel door een unittest geslingerd.
Function HoeLangDuurtHetOmDeMaanTeBereiken($Snelheid = NULL)
{
    //Afstanden
    $MinDistanceToEarth = "363104"; // Minimale afstand tot de maan in kilometers
    $AverageMoonDistanceToEarth = "385000"; //Gemiddelde afstand tot de maan in kilometers
    $MaxDistanceToEarth = "405696"; //maximale afstand tot de maan in kilometers

    //Snelheden
    $AverageHumanWalkingSpeed = "4"; //Gemiddelde wandelsnelheid van een mens in kilometers per uur
    $A16MaxSpeed = "130"; //maximun snelheid op de A16 in kilometers per uur
    $UsainBoltMaxSpeed = "44.72"; // Zo snel rent Usain Bolt in kilometers per uur
    $Voyager1MaxSpeed = "62140"; // Zo snel gaat Voyager 1 in kilometers per uur

    if (is_numeric($Snelheid)) {
        //Berekeningen
        $MinTime = round(($MinDistanceToEarth / $Snelheid), 2);
        $AvgTime = round($AverageMoonDistanceToEarth / $Snelheid, 2);
        $MaxTime = round($MaxDistanceToEarth / $Snelheid, 2);
        Return "Tijd om de maan te bereiken als deze het dichst bij staat: $MinTime uur. Tijd om de maan te bereiken als deze het verste weg is: $MaxTime uur. Gemiddelde tijd om de maan te bereiken: $AvgTime uur.";
    } Else {
        //Berekeningen
        $MinTimeAverageWalkingSpeed = $MinDistanceToEarth / $AverageHumanWalkingSpeed;
        $AvgTimeAverageWalkingSpeed = $AverageMoonDistanceToEarth / $AverageHumanWalkingSpeed;
        $MaxTimeAverageWalkingSpeed = $MaxDistanceToEarth / $AverageHumanWalkingSpeed;

        $MinTimeA16MaxSpeed = $MinDistanceToEarth / $A16MaxSpeed;
        $AvgTimeA16MaxSpeed = $AverageMoonDistanceToEarth / $A16MaxSpeed;
        $MaxTimeA16MaxSpeed = $MaxDistanceToEarth / $A16MaxSpeed;

        $MinTimeUsainBoltMaxSpeed = $MinDistanceToEarth / $UsainBoltMaxSpeed;
        $AvgTimeUsainBoltMaxSpeed = $AverageMoonDistanceToEarth / $UsainBoltMaxSpeed;
        $MaxTimeUsainBoltMaxSpeed = $MaxDistanceToEarth / $UsainBoltMaxSpeed;

        $MinTimeVoyager1MaxSpeed = $MinDistanceToEarth / $Voyager1MaxSpeed;
        $AvgTimeVoyager1MaxSpeed = $AverageMoonDistanceToEarth / $Voyager1MaxSpeed;
        $MaxTimeVoyager1MaxSpeed = $MaxDistanceToEarth / $Voyager1MaxSpeed;

        Return "Minimale afstand: Wandelend; $MinTimeAverageWalkingSpeed uur, Als de a16 naar de maan ging; $MinTimeA16MaxSpeed uur, Als Usain Bolt naar de maan zou rennen; $MinTimeUsainBoltMaxSpeed uur , Als Voyager1 met de huidige snelheid langs zou komen; $MinTimeVoyager1MaxSpeed uur.
               Gemiddelde afstand: Wandelend; $AvgTimeAverageWalkingSpeed uur, Als de a16 naar de maan ging; $AvgTimeA16MaxSpeed uur, Als Usain Bolt naar de maan zou rennen; $AvgTimeUsainBoltMaxSpeed uur, Als Voyager1 met de huidige snelheid langs zou komen; $AvgTimeVoyager1MaxSpeed uur.
               Maximale afstand: Wandelend; $MaxTimeAverageWalkingSpeed uur, Als de a16 naar de maan ging; $MaxTimeA16MaxSpeed uur, Als Usain Bolt naar de maan zou rennen; $MaxTimeUsainBoltMaxSpeed uur, Als Voyager1 met de huidige snelheid langs zou komen; $MaxTimeVoyager1MaxSpeed uur.";
    }
};
?>

<?php //functies

function GetArrayLedenMetGeleendeBoeken()
{ //vind de leden die nog boeken geleend hebben.
    global $pdo;
    $LedenMetGeleendeBoeken = array();
    $LedenMetGeleendeBoekenQuery = $pdo->query("SELECT DISTINCT Lid_nr FROM lening WHERE inleverdatum IS NULL");
    foreach ($LedenMetGeleendeBoekenQuery as $lidnr) {
        array_push($LedenMetGeleendeBoeken, $lidnr['Lid_nr']);
    };
    return $LedenMetGeleendeBoeken;
}

function GetBoekenOpDitMomentGeleendDoorLid()
{ // vind de boeken die een lid op dit moment geleend heeft (Inleverdatum IS NULL). Geeft het mysqli resultaat terug bij een geslaagde bewerking en de mysqli foutmelding bij een mislukte bewerking.
    global $pdo;
    $BoekenOpDitMomentGeleendDoorLid = $pdo->query(
        "SELECT lid_nr, lening.Boek_nr,boek.Titel, boek.ISBN FROM lening 
			JOIN exemplaar on lening.boek_nr = exemplaar.boek_nr
			JOIN Boek on exemplaar.ISBN = Boek.isbn
			WHERE Inleverdatum IS NULL"
    );
    return $BoekenOpDitMomentGeleendDoorLid;
}

function GetTableKeys($table)
{//Pakt de kolomnamen van een MySQL table ($table)
    global $pdo;
    $GetTableKeysStatement = $pdo->prepare("DESCRIBE $table");
    $GetTableKeysStatement->execute();
    $Keys = $GetTableKeysStatement->fetchall(PDO::FETCH_COLUMN);
    return $Keys;
}

function GetOpenstaandeBoeteBedragenVanLid($lening, $Lid_nr)
{ // Vind de openstaande boetes van een lid en telt ze bij elkaar op. Het eindresultaat ($boetetotaal) is het totaal van de boetes.
    $boetetotaal = 0;
    Foreach ($lening as $boete) {
        if ($boete['Lid_nr'] == $Lid_nr) {
            Try {
                $BoeteTellingStart = new DateTime($boete["Uitleentijdstip"]); // maakt een datetime object aan met de waarde van $boete["uitleentijdstip"]
                $BoeteTellingStart->add(new DateInterval("P" . $boete["Uitleengrondslag"] . "D")); //Voegt de uitleengrondslag ($boete["uitleengrondslag"]) toe aan het datetime object "$BoeteTellingStart". Interval met een periode (P) van
            }
            Catch (Exception $e) {
                echo $e->GetMessage();
                exit(1);
            }
            // $boete["uitleengrondslag"] dagen (D))
            $Today = new DateTime('now'); // Huidige tijdstip om "vandaag" te bepalen
            $Interval = date_diff($BoeteTellingStart, $Today); // het tijdsverschil tussen de waarden BoeteTellingStart en Today

            $boetetotaal += ($Interval->format("%a") * round($boete["Boetetarief"], 2)); // Multipliceert (*) $interval met $boete["boetetarief"] en telt het resultaat op bij $boetetotaal.

        }
    };
    return $boetetotaal;
}

?>
<?php //SQL Statements
$LidAanpassenQuery = $pdo->prepare('Update Lid SET 
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
             Where Lid_nr = :Lid_nr');

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

$LidVerwijderenQuery = $pdo->prepare('DELETE FROM Lid WHERE Lid_nr = :Lid_nr')
?>

<?php // $_POST acties
if (isset($_POST['Toevoegen'])) {
    // Voegt een lid toe met de gegevens uit $_POST als $_POST['Toevoegen'] bestaat
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
}
?>

<?php

//Als $_POST['Aanpassen'] ingevuld is wordt code uitgevoerd dat het lid aanpast met de variabelen uit de array $_POST
if (isset($_POST['Aanpassen'])) {
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
?>

<?php
//Als $_POST['Verwijderen'] ingevuld is wordt code uitgevoerd dat het lid aanpast met de variabelen uit de array $_POST
if (isset($_POST['Verwijderen'])) {
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
        <div class="table-responsive">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><b>Overzicht leden</b></h2>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Lid nummer</th>
                    <th>Naam</th>
                    <th>Adres</th>
                    <th>Telefoonnummer</th>
                    <th>Emailadres</th>
                    <th>Geboortedatum</th>
                    <th>Openstaande Boete</th>
                    <th><?php //aanpasknop ?></th>
                    <th><?php //verwijderknop ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($Leden as $Lid) :// Loop door elk resultaat uit de array $Leden. Zet de lidgegevens in een tabel.
                    ?>
                    <tr>
                        <td><?php echo $Lid["Lid_nr"]; ?></td>
                        <td><?php
                            if (!empty($Lid["Voorvoegsel"])) {
                                echo $Lid["Voornaam"] . " " . $Lid["Voorvoegsel"] . " " . $Lid["Achternaam"];
                            } else {
                                echo $Lid["Voornaam"] . " " . $Lid["Achternaam"];
                            }
                            ?>
                        </td>
                        <td><?php echo $Lid['Straatnaam'] . " " . $Lid['Huisnummer'] . ", " . $Lid['Postcode'] . " " . $Lid['Woonplaats'] ?></td>
                        <td><?php echo $Lid["Telefoonnummer"] ?></td>
                        <td><?php echo $Lid["Emailadres"] ?></td>
                        <td><?php echo $Lid["Geboortedatum"] ?></td>
                        <td><?php echo "&euro;" . GetOpenstaandeBoeteBedragenVanLid($lening, $Lid["Lid_nr"]); ?></td>
                        <?php //Verwijst naar het dialoogvenster "Aanpassenlid<Lid_nr>"
                        ?>
                        <td><a href="#Aanpassenlid<?php echo $Lid["Lid_nr"]; ?>" class="btn btn-primary"
                               data-toggle="modal"
                               data-target="#Aanpassenlid<?php echo $Lid["Lid_nr"]; ?>">Aanpassen</a></td>
                        <td><a href="#Verwijderenlid<?php echo $Lid["Lid_nr"]; ?>" class="btn btn-danger"
                               data-toggle="modal" data-target="#Verwijderenlid<?php echo $Lid["Lid_nr"]; ?>">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="#Toevoegenlid" class="btn btn-success" data-toggle="modal" data-target="#Toevoegenlid">Nieuw lid
            aanmaken</a>
    </div>
<?php
/*Maakt het dialoogvenster "Toevoegenlid" aan.
Dit dialoogvenster geeft de waarde $_POST[Toevoegen] mee als op de "toevoegen" knop in het dialoogvenster geklikt wordt.
De waarde $_POST[Toevoegen] wordt gebruikt om te controleren of het toevoegen uitgevoerd moet worden.
$key wordt als label en naam voor het inputveld gebruikt.
*/
$keys = GetTableKeys("Lid"); // Zet de kolomnamen (keys) van de tabel "Lid" in de array $keys met behulp van de functie "GetTableKeys"
?>
    <div id="Toevoegenlid" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="./Leden_PDO.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Lid Toevoegen</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php
                        foreach ($keys as $key) : //foreach blok dat de velden aanmaakt.
                            ?>
                            <div class="form-group">
                                <?php if ($key == 'Lid_nr') {//Lid nummer is een Auto-Increment waarde in de database en wordt dus niet meegenomen of invulbaar gemaakt.?>
                                <?php } elseif ($key == "Geboortedatum") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="date" class="form-control" name="<?php echo "$key" ?>">
                                    </label>
                                <?php } elseif ($key == "Voorletter") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="text" class="form-control" name="<?php echo "$key" ?>" maxlength="1">
                                    </label>
                                <?php } elseif ($key == "Huisnummer") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="Number" class="form-control" name="<?php echo "$key" ?>" min="0" max="99999">
                                    </label>
                                <?php } elseif ($key == "Postcode") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="Text" class="form-control" name="<?php echo "$key" ?>" maxlength="6">
                                    </label>
                                <?php } elseif ($key == "Postcode") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="Text" class="form-control" name="<?php echo "$key" ?>" maxlength="6">
                                    </label>
                                <?php } elseif ($key == "Telefoonnummer") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="Text" class="form-control" name="<?php echo "$key" ?>" maxlength="10">
                                    </label>
                                <?php } elseif ($key == "Emailadres") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="email" class="form-control" name="<?php echo "$key" ?>" maxlength="255">
                                    </label>
                                <?php } else { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="text" class="form-control" name="<?php echo "$key" ?>">
                                    </label>
                                <?php } ?>
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
$key wordt als label en naam voor het inputveld gebruikt.
*/
foreach ($Leden as $Lid) :
    ?>
    <div id="Aanpassenlid<?php echo $Lid['Lid_nr']; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="./Leden_PDO.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Aanpassen lid <?php echo $Lid['Lid_nr']; ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php
                        foreach ($Lid as $key => $value) :
                            ?>
                            <div class="form-group">
                                <?php if ($key == 'Lid_nr') {//Lid_nr wordt een hidden field zodat deze niet aanpasbaar is maar wel meegenomen wordt in de $_POST.?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="text" class="form-control" name="<?php echo "$key" ?>" value="<?php echo "$value" ?>" readonly>
                                    </label>
                                <?php } elseif ($key == "Geboortedatum") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="date" class="form-control" name="<?php echo "$key" ?>" value="<?php echo "$value" ?>">
                                    </label>
                                <?php } elseif ($key == "Voorletter") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="text" class="form-control" name="<?php echo "$key" ?>" value="<?php echo "$value" ?>" maxlength="1">
                                    </label>
                                <?php } elseif ($key == "Huisnummer") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="Number" class="form-control" name="<?php echo "$key" ?>" value="<?php echo "$value" ?>" min="0" max="99999">
                                    </label>
                                <?php } elseif ($key == "Postcode") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="Text" class="form-control" name="<?php echo "$key" ?>" value="<?php echo "$value" ?>" maxlength="6">
                                    </label>
                                <?php } elseif ($key == "Postcode") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="Text" class="form-control" name="<?php echo "$key" ?>" value="<?php echo "$value" ?>" maxlength="6">
                                    </label>
                                <?php } elseif ($key == "Telefoonnummer") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="Text" class="form-control" name="<?php echo "$key" ?>" value="<?php echo "$value" ?>" maxlength="10">
                                    </label>
                                <?php } elseif ($key == "Emailadres") { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="email" class="form-control" name="<?php echo "$key" ?>" value="<?php echo "$value" ?>" maxlength="255">
                                    </label>
                                <?php } else { ?>
                                    <label>
                                        <?php echo $key ?>
                                        <input type="text" class="form-control" name="<?php echo "$key" ?>" value="<?php echo "$value" ?>">
                                    </label>
                                <?php } ?>
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
$LedenMetGeleendeBoeken = GetArrayLedenMetGeleendeBoeken(); // Dialoogvenster "verwijderlid" wordt op een andere manier ingevuld als het lid nog boeken heeft geleend.
foreach ($Leden as $Lid) :
    ?>
    <div id="Verwijderenlid<?php echo $Lid['Lid_nr']; ?>" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php if (in_array($Lid['Lid_nr'], $LedenMetGeleendeBoeken)) { ?>
                    <form method="post" action="./Leden_PDO.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Het lid heeft onderstaande boeken nog geleend! Weet je zeker dat je
                                lid <?php echo $Lid['Lid_nr']; ?> wilt verwijderen?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Boek nummer</th>
                                    <th>Titel</th>
                                    <th>ISBN</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ((GetBoekenOpDitMomentGeleendDoorLid()) as $GeleendBoek) : // functie vraagt alle geleende boeken op en wordt door de foreach in de array $GeleendBoek geplaatst
                                    if ($GeleendBoek["lid_nr"] == $Lid["Lid_nr"]) { // voert alleen onderstaande regels uit als de huidige rij van de array $Geleendboek een lidnummer bevat dat matcht met $Lid['Lid_nr'].
                                        ?>
                                        <tr>
                                            <td><?php echo $GeleendBoek['Boek_nr'] ?></td>
                                            <td><?php echo $GeleendBoek['Titel'] ?></td>
                                            <td><?php echo $GeleendBoek['ISBN'] ?></td>
                                        </tr>
                                    <?php } endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="Lid_nr" Value="<?php echo $Lid['Lid_nr']; ?>">
                            <input type="button" class="btn btn-primary" data-dismiss="modal" value="Annuleren">
                            <input type="submit" class="btn btn-danger" name="Verwijderen" value="Verwijderen">
                        </div>
                    </form>
                <?php } else { ?>
                    <form method="post" action="./Leden_PDO.php">
                        <div class="modal-header">
                            <h4 class="modal-title"> Weet je zeker dat je lid nummer <?php echo $Lid['Lid_nr']; ?> wilt
                                verwijderen?</h4>
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

<?php include "./Templates/footer.php"; ?>