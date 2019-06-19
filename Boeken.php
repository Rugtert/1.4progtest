<?php
require "./functies/Boeken_Functies.php"; // Bevat functies specifiek voor deze pagina
include "./templates/Header.php"; //CSS en HTML Header.
?>

<div class="container-fluid">
    <div class="table-responsive">
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
                <th><?php //Exemplaarknop ?></th>
            </tr>
            <tr>
                <?php for ($i = 0; $i <= 4; $i++) {
                    echo "<th><input type=\"text\" id=\"Input$i\" onkeyup=\"BoekFilters($i)\" placeholder=\"Zoeken...\"></th>";
                }
                ?>
                <th><?php //Exemplaarknop ?></th>
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
                    <td><a href="#Exemplaren<?php echo $Boek["ISBN"]; ?>" class="btn btn-primary" data-toggle="modal" data-target="#Exemplaren<?php echo $Boek["ISBN"]; ?>">Exemplaren</a></td>
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
                            <th></th>
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
                                <td><a href="Uitlenen.php?Boek_nr=<?php echo $Exemplaar['Boek_nr']?>" class="btn btn-primary">Uitlenen</a></td>
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
        function BoekFilters(col) { // Voegt filterfunctionaliteit toe aan de tabel Boeken.
            // Variabelen
            let input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("Input" + col);
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