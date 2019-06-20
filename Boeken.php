<?php
require_once "./functies/Boeken_Functies.php"; // Bevat functies specifiek voor deze pagina
include_once "./templates/Header.php"; //CSS en HTML Header.
?>
<?PHP //SQL Query's

//Vraagt de boektitels, auteurs van de boeken, onderwerp(en) van de boeken, en de uitleenstatus op.
$Boeken = $pdo->query("SELECT
    boek.Titel,
    boek.ISBN,
    a.Voornaam,
    a.Voorvoegsel,
    a.Achternaam,
    o.Naam,
    GROUP_CONCAT(distinct o.Naam SEPARATOR ', ') AS Onderwerp,
    count(distinct e.Boek_nr)  AS \"Aantal boeken\"
    FROM boek
         INNER JOIN exemplaar e on boek.ISBN = e.ISBN
         INNER JOIN auteur a on boek.Auteur_nr = a.Auteur_nr
         INNER JOIN bibliotheek b on e.Bibliotheek_nr = b.Bibliotheek_nr
         INNER JOIN boek_onderwerp bo on boek.ISBN = bo.ISBN
         INNER JOIN onderwerp o on bo.NUR_CODE = o.NUR_Code
         LEFT JOIN lening l on e.Boek_nr = l.Boek_nr
    GROUP BY boek.ISBN")->fetchAll();

?>
    <div class="container-fluid">
        <div class="table-responsive">
            <table id="Boeken" class="table table-striped table-hover">
                <thead>
                <tr>
                    <!-- Maken van de tabelheaders-->
                    <?php echo TableHeaderWriter(array("Titel", "ISBN", "Auteur", "Onderwerp", "Aantal Boeken", "")); ?>

                </tr>
                <tr>
                    <!--Aanmaken zoekvelden -->
                    <?php for ($i = 0; $i <= 4; $i++) {
                        echo TableHeaderWriter(array("<input type=\"text\" id=\"Invoer$i\" onkeyup=\"BoekFilters($i)\" placeholder=\"Zoeken...\">"));
                    }
                    ?>
                    <th><!--Exemplaarknop--></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($Boeken as $Boek) :// Loop door elk resultaat uit de array $Boeken en zet de lidgegevens in een tabel.
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
                        <td><a href="#Exemplaren<?php echo $Boek["ISBN"]; ?>" class="btn btn-primary" data-toggle="modal" style="display: block" data-target="#Exemplaren<?php echo $Boek["ISBN"]; ?>">Exemplaren</a></td> <!-- opent popup met een
                    overzicht van de exemplaren -->
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Maken van een popup met exemplaaroverzicht-->
<?php foreach ($Boeken as $Boek) : ?>
    <div id="Exemplaren<?php echo $Boek['ISBN']; ?>" class="modal fade">
        <div class="modal-dialog modal-1100px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Exemplaren van boek <?php echo $Boek["Titel"]; ?></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="leden" class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <?php echo TableHeaderWriter(array("Boeknummer", "Aanschafdatum", "Aanschafprijs", "Boetetarief", "Uitleengrondslag", "Bibliotheek", "Uitgeverij", "Uitgeleend", "")); ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php //Tabel met exemplaargegevens maken
                            foreach ((GetExemplarenByISBN($Boek['ISBN'], $pdo)) as $Exemplaar) : ?>
                                <tr>
                                    <td><?php echo $Exemplaar['Boek_nr'] ?></td>
                                    <td><?php echo $Exemplaar['Aanschafdatum'] ?></td>
                                    <td><?php echo $Exemplaar['Aanschafprijs'] ?></td>
                                    <td><?php echo $Exemplaar['Boetetarief'] ?></td>
                                    <td><?php echo $Exemplaar['Uitleengrondslag'] ?></td>
                                    <td><?php echo $Exemplaar['Bibliotheek'] ?></td>
                                    <td><?php echo $Exemplaar['Uitgeverij'] ?></td>
                                    <td><?php if ($Exemplaar['uitgeleend'] == 1) {
                                            echo "ja";
                                        } else {
                                            echo "nee";
                                        } ?></td>
                                    <td><a href="Uitlenen.php?Boek_nr=<?php echo $Exemplaar['Boek_nr'] ?>" class="btn btn-primary" style="display: block">Uitlenen</a></td>
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
        function BoekFilters(col) { // Voegt filter-functionaliteit toe aan de tabel Boeken.
            // Variabelen
            let input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("Invoer" + col);
            filter = input.value.toUpperCase();
            table = document.getElementById("Boeken");
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