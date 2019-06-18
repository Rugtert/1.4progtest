<?php
include "./templates/Header.php"; //CSS en HTML Header.
require "./functies/Common.php"; //bevat algemene functies die op meerdere plaatsen gebruikt kunnen worden.
?>
<?php

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
<div class="container-fluid">
    <div class="table-responsive">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2><b>Overzicht boeken</b></h2>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
        <table id="Boeken" class="table table-striped table-hover">
            <thead>
            <tr>
                <?php for ($i = 0; $i <= 4; $i++) {
                    switch ($i) {
                        case 0:
                            $Placeholder = "Titel";
                            break;
                        case 1:
                            $Placeholder = "ISBN";
                            break;
                        case 2:
                            $Placeholder = "Auteur";
                            break;
                        case 3:
                            $Placeholder = "Onderwerp";
                            break;
                        case 4:
                            $Placeholder = "Aantal Boeken";
                            break;
                    }
                    echo "<th>$Placeholder</th>";
                }
                ?>
                <th><?php //aanpasknop ?></th>
                <th><?php //Exemplaarknop ?></th>
            </tr>
            <tr>
                <?php for ($i = 0; $i <= 4; $i++) {
                    echo "<th><input type=\"text\" id=\"myInput$i\" onkeyup=\"BoekFilters($i)\" placeholder=\"Zoeken...\"></th>";
                }
                ?>
                <th><?php //Exemplaarknop ?></th>
                <th><?php // ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($Boeken as $Boek) :// Loop door elk resultaat uit de array $Leden. Zet de lidgegevens in een tabel.
                ?>
                <tr>
                    <td><?php echo $Boek["Titel"] ?></td>
                    <td><?php echo $Boek["ISBN"] ?></td>
                    <td><?php
                        if (!empty($Boek["Voorvoegsel"])) {
                            echo $Boek["Voornaam"] . " " . $Boek["Voorvoegsel"] . " " . $Boek["Achternaam"];
                        } else {
                            echo $Boek["Voornaam"] . " " . $Boek["Achternaam"];
                        }
                        ?></td>
                    <td><?php echo $Boek["Onderwerp"] ?></td>
                    <td><?php echo $Boek["Aantal boeken"] ?></td>
                    <td><a href="#Exemplaren<?php echo $Boek["ISBN"]; ?>" class="btn btn-primary"
                           data-toggle="modal"
                           data-target="#Exemplaren<?php echo $Boek["ISBN"]; ?>">Exemplaren</a></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php foreach ($Boeken as $Boek) : ?>
<div id="Exemplaren<?php echo $Boek['ISBN']; ?>" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Exemplaren van boek <?php echo $Boek["Titel"]; ?></h2>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body-lg">
                <div class="table-responsive">
                    <table id="leden" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Boek nummer</th>
                            <th>Aanschafdatum</th>
                            <th>Aanschafprijs</th>
                            <th>Boetetarief</th>
                            <th>Uitleengrondslag</th>
                            <th>Bibliotheek</th>
                            <th>Uitgeverij</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ((GetExemplarenByISBN($Boek['ISBN'], $pdo)) as $Exemplaar) : ?>
                            <tr>
                                <td><?php echo $Exemplaar['Boek_nr'] ?></td>
                                <td><?php echo $Exemplaar['Aanschafdatum'] ?></td>
                                <td><?php echo $Exemplaar['Aanschafprijs'] ?></td>
                                <td><?php echo $Exemplaar['Boetetarief'] ?></td>
                                <td><?php echo $Exemplaar['Uitleengrondslag'] ?></td>
                                <td><?php echo $Exemplaar['Bibliotheek'] ?></td>
                                <td><?php echo $Exemplaar['Uitgeverij'] ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" data-dismiss="modal" value="Annuleren">
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
    endforeach
    ?>
    <script>
        function BoekFilters(col) {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput" + col);
            filter = input.value.toUpperCase();
            table = document.getElementById("Boeken");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
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