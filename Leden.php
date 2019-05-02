<?php include "./templates/header.php"; ?>
<?php
	require "./functies/common.php";
	$result = sqlquery('SELECT Lid_nr, Voornaam, Voorvoegsel, Achternaam, Straatnaam, Huisnummer, Woonplaats, Postcode, Telefoonnummer, Emailadres, Geboortedatum FROM lid ORDER BY Lid_nr');
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
					<th></th>
					<th></th>
                </tr>
            </thead>
            <tbody>
			<?php
				// output data of each row
				foreach ($result as $row) :
			?>
			<tr>
				<td><?php echo $row["Lid_nr"];?></td>
				<td><?php if (!empty($row["Voorvoegsel"])) {echo $row["Voornaam"] . " " . $row["Voorvoegsel"] . " " . $row["Achternaam"];}
							else {echo $row["Voornaam"] . " " . $row["Achternaam"];}?></td>
				<td><?php echo $row['Straatnaam'] . " " . $row['Huisnummer'] . ", " . $row['Postcode'] . " " . $row['Woonplaats']?></td>
				<td><?php echo $row["Telefoonnummer"]?></td>
				<td><?php echo $row["Emailadres"]?></td>
				<td><?php echo $row["Geboortedatum"]?></td>
				<td></td>
				<td></td>
				<td><a href="Lid_aanpassen.php?Lid_nr=<?php echo $row["Lid_nr"];?>" class = "btn btn-primary mb-2">Aanpassen</a></td>
				<td><a href="Lid_Verwijderen.php?Lid_nr=<?php echo $row["Lid_nr"];?>" class = "btn btn-primary mb-2">Verwijderen</a></td>
			</tr>
			<?php endforeach ?>
            </tbody>
        </table>
    </div>
	<a href="./Lid_aanmaken.php" class="btn btn-primary mb-2">Nieuw lid aanmaken</a>
	<a href="./index.html" class="btn btn-primary mb-2">Terug naar de hoofdpagina</a>
</div>
<?php include "./Templates/footer.php"; ?>