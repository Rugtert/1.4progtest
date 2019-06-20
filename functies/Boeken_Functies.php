<?php
require_once "./functies/Common.php"; //bevat algemene functies die op meerdere plaatsen gebruikt kunnen worden.


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
    EXISTS(select * where (l.Uitleentijdstip IS NOT NULL AND (l.Inleverdatum > CURDATE() OR l.Inleverdatum IS NULL))) AS uitgeleend
from exemplaar
         INNER JOIN uitgeverij u on exemplaar.Uitgeverij_nr = u.Uitgeverij_nr
         INNER JOIN bibliotheek b on exemplaar.Bibliotheek_nr = b.Bibliotheek_nr
         LEFT JOIN lening l on exemplaar.Boek_nr = l.Boek_nr
    where exemplaar.ISBN = $ISBN")->fetchAll();
    return $Exemplaren;
}

?>