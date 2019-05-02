<?php include "./templates/header.php"; ?>
<?php
	require "./functies/common.php";
	$result = sqlquery('SELECT boek.ISBN, Boek.Titel, Druk, onderwerp.naam as "Onderwerp", Seriedeelnr, auteur.voornaam, auteur.achternaam, serie.titel as "titel van serie" FROM boek
                JOIN auteur on boek.Auteur_nr = auteur.Auteur_nr
                left JOIN serie on boek.Serie_nr = serie.Serie_nr
                JOIN boek_onderwerp on boek.isbn = boek_onderwerp.ISBN
                JOIN onderwerp on boek_onderwerp.NUR_CODE = onderwerp.NUR_Code');
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
                    <th>ISBN</th>
                    <th>Naam</th>
					<th>Druk</th>
                    <th>Onderwerp</th>
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
				<td><?php echo $row["ISBN"];?></td>
				<td><?php echo $row["Titel"]?></td>
				<td><?php echo $row['Druk']?></td>
				<td><?php echo $row["Onderwerp"]?></td>
				<td><?php echo $row["voornaam"] . " " . $row["achternaam"]?></td>
				<td><?php echo $row["titel van serie"]?></td>
				<td><?php echo $row["Seriedeelnr"]?></td>
				<td><a href="Boek_verwijderen.php?Lid_nr="<?php echo $row["ISBN"];?> class="btn btn-primary mb-2">Verwijderen</a></td>
				
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
