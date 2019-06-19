<?php
require_once "./functies/Common.php";
# onderstaande functie is toegevoegd om aan de toetseisen te voldoen. Ze worden niet in het programma gebruikt maar worden wel door een unittest geslingerd.
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

    if (is_numeric($Snelheid)) {//Berekeningen bij gebruik van ee numerieke waarde in $Snelheid
        $MinTime = round(($MinDistanceToEarth / $Snelheid), 2);
        $AvgTime = round($AverageMoonDistanceToEarth / $Snelheid, 2);
        $MaxTime = round($MaxDistanceToEarth / $Snelheid, 2);
        Return "Tijd om de maan te bereiken als deze het dichst bij staat: $MinTime uur. Tijd om de maan te bereiken als deze het verste weg is: $MaxTime uur. Gemiddelde tijd om de maan te bereiken: $AvgTime uur.";
    } Else {// Berekeningen met standaard feitjes bij het ontbreken van numerieke waarde in $Snelheid.
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
}

;
?>

<?php // Functies

function GetArrayLedenMetGeleendeBoeken($pdo)
{ //vind de leden die nog boeken geleend hebben.
    $LedenMetGeleendeBoeken = array();
    $LedenMetGeleendeBoekenQuery = $pdo->query("SELECT DISTINCT Lid_nr FROM lening WHERE inleverdatum IS NULL");
    foreach ($LedenMetGeleendeBoekenQuery as $lidnr) {
        array_push($LedenMetGeleendeBoeken, $lidnr['Lid_nr']);
    };
    return $LedenMetGeleendeBoeken;
}

function GetBoekenOpDitMomentGeleend($pdo)
{ // vind de boeken die een lid op dit moment geleend heeft (Inleverdatum IS NULL). Geeft het mysqli resultaat terug bij een geslaagde bewerking en de mysqli foutmelding bij een mislukte bewerking.
    $BoekenOpDitMomentGeleendDoorLid = $pdo->query(
        "SELECT lid_nr, lening.Boek_nr,boek.Titel, boek.ISBN FROM lening 
			JOIN exemplaar on lening.boek_nr = exemplaar.boek_nr
			JOIN Boek on exemplaar.ISBN = Boek.isbn
			WHERE Inleverdatum IS NULL"
    );
    return $BoekenOpDitMomentGeleendDoorLid;
}

function GetTableKeys($table, $pdo)
{ // Pakt de kolomnamen van een MySQL table ($table)
    #global $pdo;
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
            } Catch (Exception $e) {
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