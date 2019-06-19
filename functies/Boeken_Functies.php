<?php 
require "./functies/Common.php"; //bevat algemene functies die op meerdere plaatsen gebruikt kunnen worden.

$Boeken = $pdo->query("SELECT
       boek.Titel,
       boek.ISBN,
       a.Voornaam,
       a.Voorvoegsel,
       a.Achternaam,
       GROUP_CONCAT(distinct o.Naam SEPARATOR ', ') AS \"Onderwerp\",
       count(e.Boek_nr)  AS \"Aantal boeken\"
FROM boek
INNER JOIN exemplaar e on boek.ISBN = e.ISBN
INNER JOIN auteur a on boek.Auteur_nr = a.Auteur_nr
INNER JOIN bibliotheek b on e.Bibliotheek_nr = b.Bibliotheek_nr
INNER JOIN boek_onderwerp bo on boek.ISBN = bo.ISBN
INNER JOIN onderwerp o on bo.NUR_CODE = o.NUR_Code
LEFT JOIN lening l on e.Boek_nr = l.Boek_nr
GROUP BY boek.ISBN")->fetchAll();

Function GetExemplarenByISBN($ISBN, $pdo)
{
    $Exemplaren = $pdo->query("SELECT
       exemplaar.Boek_nr,
       exemplaar.Aanschafdatum,
       exemplaar.Aanschafprijs,
       exemplaar.Boetetarief,
       exemplaar.Uitleengrondslag,
       b.Naam AS Bibliotheek,
       u.naam AS Uitgeverij
    from exemplaar
    INNER JOIN uitgeverij u on exemplaar.Uitgeverij_nr = u.Uitgeverij_nr
    INNER JOIN bibliotheek b on exemplaar.Bibliotheek_nr = b.Bibliotheek_nr
    where exemplaar.ISBN = $ISBN")->fetchAll();
    return $Exemplaren;
}

?>