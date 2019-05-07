<?php include "./templates/header.php"; ?>
<?php
	require "./functies/common.php";
	$result = sqlquery('SELECT Lid_nr, Voornaam, Voorvoegsel, Achternaam, Straatnaam, Huisnummer, Woonplaats, Postcode, Telefoonnummer, Emailadres, Geboortedatum FROM lid ORDER BY Lid_nr');
	if (isset($_POST['Verwijderen'])) {
		$Heeftnogleningen = sqlquery("SELECT Lid_nr,lening.Boek_nr,boek.Titel, boek.ISBN FROM lening 
                                JOIN exemplaar on lening.boek_nr = exemplaar.boek_nr
                                JOIN Boek on exemplaar.ISBN = Boek.isbn
                                WHERE lid_nr = $_POST[Lid_nr]");
    	if (($Heeftnogleningen->num_rows) > "0"){?>
    	    <div class="container">
    	        <div class="table-responsive">
    	            <div class="table-title">
    	                <div class="row">
    	                    <div class="col-sm-12">
    	                        <h2><b>Het lid heeft onderstaande boeken nog geleend! Weet je zeker dat je dit lid wilt verwijderen?</b></h2>
    	                    </div>
    	                </div>
    	            </div>
    	            <table class="table table-striped table-hover">
    	                <thead>
    	                    <tr>
    	                        <th>Lidnummer</th>
    	                        <th>Boek nummer</th>
    	                        <th>Titel</th>
    	                        <th>ISBN</th>
    	                    </tr>
    	                </thead>
    	                <tbody>
    	                <?php
    	                    // output data of each row
    	                    foreach ($Heeftnogleningen as $row) :
    	                ?>
    	                <tr>
    	                    <td><?php echo $row["Lid_nr"];?></td>
    	                    <td><?php echo $row["Boek_nr"]?></td>
    	                    <td><?php echo $row["Titel"]?></td>
    	                    <td><?php echo $row["ISBN"]?></td>
    	                </tr>
    	                <?php 
    	                    endforeach;
    	                ?>
    	                </tbody>
    	            </table>
    	            <form method="post">
    	            	<a href="leden2.php?>" class = "btn btn-primary mb-2">Annuleren</a>
						<input name="Verwijderen" type="hidden" value="verwijderen" class = "btn btn-danger">
						<input name="Lid_nr" type="hidden" value="<?php echo $_POST['Lid_nr']?> " class = "btn btn-danger">
    	            	<input name="verwijderen2" type="submit" value="verwijderen" class = "btn btn-danger">
    	            </form>
    	            <?php if(isset($_POST['verwijderen2'])){
    	                    $result = sqlquery("DELETE FROM lid WHERE lid_nr = $_POST[Lid_nr]");
    	                    if ($result !=1) {
								Echo "er is iets fout gegaan bij het verwijderen. Foutcode: $result";
							}
    	                    Else {
								die("<p class=\"text-center\"><h2>Lid verwijderd!</h2> <a href=\"./Leden2.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
							}
    	                }?>
    	        </div>
    	    </div>
	<?php 
		}
		Else{
				$result = sqlquery("DELETE FROM lid WHERE lid_nr = $_POST[Lid_nr]");
				if ($result !=1) {
					Echo "er is iets fout gegaan bij het verwijderen. Foutcode: $result"; die;
				}
			   	Else {
					   die("<p class=\"text-center\"><h2>Lid verwijderd!</h2> <a href=\"./Leden2.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
					}
   		}
	}
Else {
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
                <div id="Verwijderlid<?php echo $row['Lid_nr']?>" class="modal">
	            	<div class="modal-dialog">
	            		<div class="modal-content">
	            			<form method="post" action="./leden2.php">
	            				<div class="modal-header">						
	            					<h4 class="modal-title">Weet je zeker dat je lid nummer <?php echo $row['Lid_nr']?> met naam <?php echo $row['Voornaam'] . " " . $row['Voorvoegsel'] . " " . $row['Achternaam']?> wilt verwijderen?</h4>
	            				</div>
	            				<div class="modal-footer">
	            					<input type="button" class="btn btn-primary mb-2" data-dismiss="modal" value="Annuleren">
									<input type="hidden" name="Lid_nr" value=<?php echo $row['Lid_nr'] ?>>
	            					<input type="Submit" class="btn btn-danger" name="Verwijderen" value="Verwijderen">
	            				</div>
	            			</form>
	            		</div>
	            	</div>
	            </div>
				<td></td>
				<td><a href="Lid_aanpassen.php?Lid_nr=<?php echo $row["Lid_nr"];?>" class = "btn btn-primary mb-2">Aanpassen</a></td>
				<td><a href="#Verwijderlid<?php echo $row["Lid_nr"];?>" class = "btn btn-danger" data-toggle="modal" data-target="#Verwijderlid<?php echo $row["Lid_nr"];?>">Verwijderen</a></td>
			</tr>
			<?php endforeach ?>
            </tbody>
        </table>
    </div>
	<a href="./Lid_aanmaken.php" class="btn btn-primary mb-2">Nieuw lid aanmaken</a>
	<a href="./index.html" class="btn btn-primary mb-2">Terug naar de hoofdpagina</a>
</div>
<?php } ?>
<?php include "./Templates/footer.php"; ?>