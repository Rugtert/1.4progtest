<?php include "./templates/header.php"; ?>
<?php
require "./functies/common.php";
$result = sqlquery('SELECT count(exemplaar.Boek_nr) AS "aantal exemplaren", boek.ISBN, Boek.Titel, Druk, Seriedeelnr, auteur.voornaam, auteur.achternaam, serie.titel as "titel van serie" FROM boek
							LEFT JOIN auteur on boek.Auteur_nr = auteur.Auteur_nr
							left JOIN serie on boek.Serie_nr = serie.Serie_nr
							LEFT JOIN exemplaar on boek.ISBN = exemplaar.ISBN
							GROUP BY Boek.ISBN');
?>

<div class="container-fluid">
    <div class="table-responsive">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2><b>Overzicht Boeken</b></h2>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Aantal Exemplaren</th>
                <th>ISBN</th>
                <th>Naam</th>
                <th>Druk</th>
                <th>Auteur</th>
                <th>Titel van serie</th>
                <th>Deel van serie</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            // output data of each row
            foreach ($result as $row) :
                ?>
                <tr>
                    <td><?php echo $row["aantal exemplaren"]; ?></td>
                    <td><?php echo $row["ISBN"] ?></td>
                    <td><?php echo $row['Titel'] ?></td>
                    <td><?php echo $row["Druk"] ?></td>
                    <td><?php echo $row["voornaam"] . " " . $row["achternaam"] ?></td>
                    <td><?php echo $row["titel van serie"] ?></td>
                    <td><?php echo $row["Seriedeelnr"] ?></td>
                    <td><a href="#Details<?php echo $row["ISBN"]; ?>" class="btn btn-primary mb2"
                           data-toggle="modal" data-target="#Details<?php echo $row["ISBN"]; ?>">Details</a>
                    </td>

                </tr>
            <?php
            endforeach;
            ?>
            </tbody>
        </table>
    </div>
    <a href="./Boek_aanmaken.php" class="btn btn-primary mb-2">Nieuw boek aanmaken</a>
    <a href="./index.html" class="btn btn-primary mb-2">Terug naar de hoofdpagina</a>
</div>
<?php
    foreach ($result as $Boek) :
    ?>
    <div id="Details<?php echo $Boek['ISBN']; ?>" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="./boeken.php">
                    <div class="modal-header">
                        <h4 class="modal-title">Aanpassen boek: <?php echo $Boek['ISBN']; ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($Boek as $key => $value) :?>
                                <div class="form-group">
                                    <label><?php echo "$key" ?></label>
                                    <input type="text" class="form-control" name="<?php echo "$key" ?>"
                                           value="<?php echo "$value" ?>">
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
endforeach;
?>

<?php include "./Templates/footer.php"; ?>
