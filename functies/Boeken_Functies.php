<?php
require_once "./functies/Common.php"; //bevat algemene functies die op meerdere plaatsen gebruikt kunnen worden.

//Vraagt de exemplaargegevens op die bij het opgegeven ISBN horen alsmede de bibliotheek waar het boek toe behoort en de uitgeverij die het boek heeft geleverd. De uitleenstatus kijkt of het boek is ingeleverd en geeft waarde 1 als dit zo is (mits
// in de verleden tijd) en waarde 0 als dit niet zo is. Deze query was een draak om te maken, als je tips hebt om hem te verbeteren/versimpelen hoor ik ze graag......
Function GetExemplarenByISBN($ISBN, $pdo)
{
    $Exemplaren = $pdo->query("SELECT
    exemplaar.Boek_nr,
    exemplaar.Aanschafdatum,
    exemplaar.Aanschafprijs,
    exemplaar.Boetetarief,
    exemplaar.Uitleengrondslag,
    b.Naam AS Bibliotheek,
    u.naam AS Uitgeverij,
    EXISTS(select * from lening  where (lening.Boek_nr = exemplaar.Boek_nr AND (lening.Inleverdatum > CURDATE() OR lening.Inleverdatum IS NULL)) GROUP BY exemplaar.Boek_nr) AS uitgeleend
from exemplaar
         INNER JOIN uitgeverij u on exemplaar.Uitgeverij_nr = u.Uitgeverij_nr
         INNER JOIN bibliotheek b on exemplaar.Bibliotheek_nr = b.Bibliotheek_nr
where exemplaar.ISBN = $ISBN
GROUP BY Boek_nr")->fetchAll();
    return $Exemplaren;
}

?>