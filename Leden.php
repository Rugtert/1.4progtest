<?php include "./templates/header.php"; ?>
<?php
	//bevat algemene functies die op meerdere plaatsen gebruikt worden.
	require "./functies/common.php";

	//vind de gebruikers die nog boeken geleend hebben. Wordt later gebruikt
	$Heeftnogleningen = array();
	$HeeftNogLeningenQuery = sqlquery("SELECT DISTINCT Lid_nr FROM lening");
	foreach ($HeeftNogLeningenQuery as $lidnr) { array_push($Heeftnogleningen, $lidnr['Lid_nr']);}

?>

<?php
	if(isset($_POST['Toevoegen'])) {
		// Future use
		$lid = sqlquery ("INSERT INTO lid (Voornaam, Voorvoegsel, Achternaam, Straatnaam, Huisnummer, Woonplaats, Postcode, Telefoonnummer, Emailadres, Geboortedatum) 
			VALUES (\"$_POST[Voornaam]\", \"$_POST[Voorvoegsel]\", \"$_POST[Achternaam]\", \"$_POST[Straatnaam]\", \"$_POST[Huisnummer]\", \"$_POST[Woonplaats]\", \"$_POST[Postcode]\", \"$_POST[Telefoonnummer]\", \"$_POST[Emailadres]\", \"$_POST[Geboortedatum]\")");
			if ($lid != 1) {
				echo "<p class=\"text-center\"><h2>er is iets foutgegaan tijdens het aanpassen van het lid. Foutcode: $lid</h2></p>";
			}
	}
?>

<?php

	//Als $_POST['Aanpassen'] ingevuld is wordt code uitgevoerd dat het lid aanpast met de variabelen uit de array $_POST
	if (isset($_POST['Aanpassen'])) {
		$lid = sqlquery("UPDATE Lid SET Voornaam = \"$_POST[Voornaam]\", Achternaam = \"$_POST[Achternaam]\", Straatnaam = \"$_POST[Straatnaam]\", Huisnummer = \"$_POST[Huisnummer]\", Woonplaats = \"$_POST[Woonplaats]\", Postcode = \"$_POST[Postcode]\", Telefoonnummer = \"$_POST[Telefoonnummer]\", Emailadres = \"$_POST[Emailadres]\", Geboortedatum = \"$_POST[Geboortedatum]\" WHERE Lid_nr = $_POST[Lid_nr]");
		//var_dump($lid);
		if ($lid == 1) {
			//echo "<p class=\"text-center\"><h2>Het lid is aangepast. De pagina moet opnieuw geladen worden om het resultaat te tonen.</h2> <a href=\"./leden.php\" class=\"btn btn-primary mb-2\">Pagina vernieuwen</a></p>";
		}
		else {
			echo "er is iets foutgegaan tijdens het aanpassen van het lid. Foutcode: $lid";
			mysqli_errno($lid);
		}
	}
	if (isset($_POST['VerwijderlidMetGeleendeBoeken'])) {
		Echo $_POST;
	}
	//Als $_POST['Verwijderen'] ingevuld is wordt code uitgevoerd dat het lid aanpast met de variabelen uit de array $_POST
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
    	            	<a href="leden.php?>" class = "btn btn-primary mb-2">Annuleren</a>
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
								echo "<p class=\"text-center\"><h2>Lid verwijderd!</h2> <a href=\"./leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>";
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
					   //echo "<p class=\"text-center\"><h2>Lid verwijderd!</h2> <a href=\"./leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>";
					}
   		}
	}
?>

<?php
	//vraagt leden op uit de tabel "lid" en plaatst ze in de variabele $result
	$result = sqlquery("SELECT * FROM lid");
	//var_dump($result);
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
						<th><?php //aanpasknop ?></th>
						<th><?php //verwijderknop ?></th>
	                </tr>
	            </thead>
	            <tbody>
					<?php
						$Lidnummers = array(); // wordt gebruikt om de leden die nog geleende boeken hebben op te slaan en later doorheen te itereren.
						
						foreach ($result as $row) :// Loop door elk resultaat uit de array $result. Zet de lidgegevens in een tabel.

						array_push($Lidnummers, $row['Lid_nr'])
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
							<?php //Verwijst naar het dialoogvenster "Aanpassenlid<Lid_nr>" ?>
							<td><a href="#Aanpassenlid<?php echo $row["Lid_nr"];?>" class = "btn btn-primary mb-2" data-toggle="modal" data-target="#Aanpassenlid<?php echo $row["Lid_nr"];?>">Aanpassen</a></td>
							<td><a href="#Verwijderenlid<?php echo $row["Lid_nr"];?>" class = "btn btn-danger" data-toggle="modal" data-target="#Verwijderenlid<?php echo $row["Lid_nr"];?>">Verwijderen</a></td>	

							<form method="post" action="./leden.php">
								<input type="hidden" name="Lid_nr" value=<?php echo $row['Lid_nr'] ?>>
		        		    	<td><input type="Submit" class="btn btn-danger" name="Verwijderen" value="Verwijderen - oud"></td>
							</form>
						</tr>

					<?php endforeach ;?>
	            </tbody>
	        </table>
	    </div>
		<a href="#Toevoegenlid" class = "btn btn-primary mb-2" data-toggle="modal" data-target="#Toevoegenlid">Nieuw lid aanmaken</a>
		<a href="./index.html" class="btn btn-primary mb-2">Terug naar de hoofdpagina</a>
	</div>
<?php 	/* #######AANPASSEN#######Maakt het dialoogvenster "Aanpassenlid<Lid_nr> aan.
		Dit dialoogvenster geeft de waarde $_POST[Aanpassen] mee als op de "Aanpassen" knop in het dialoogvenster geklikt wordt. 
		De waarde $_POST[Aanpassen] wordt gebruikt om te controleren of het aanpassen uitgevoerd moet worden.
		De lidgegevens worden gevuld door een foreach loop die alle kolomnamen in de variabele $key zet en alle waarden in de variabele $value zet.
		$key wordt als label en naam voor het inputveld gebruikt. $value wordt als standaardwaarde meegegeven aan het inputveld.
		*/
	
	$keys = array_keys(mysqli_fetch_assoc(sqlquery("SELECT * FROM LID")));// Zet de kolomnamen (keys) van de tabel LID in array $keys
?>
	<!-- Edit Modal HTML -->
	<div id="Toevoegenlid" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="./leden.php">
					<div class="modal-header">						
						<h4 class="modal-title">Lid Toevoegen</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">	
						<?php foreach ($keys as $key) : 
							if ($key == "Lid_nr") {}
							Else {?>
						<div class="form-group">
							<label><?php echo $key?></label>
							<input type="text" name="<?php echo $key?>" class="form-control">
						</div>
						<?php } endforeach?>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info" name="Toevoegen" value="Toevoegen">
					</div>
				</form>
			</div>
		</div>
	</div>

<?php foreach ($result as $row) : ?>
	<!-- Edit Modal HTML -->
	<div id="Aanpassenlid<?php echo $row['Lid_nr'];?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="./leden.php">
					<div class="modal-header">						
						<h4 class="modal-title">Aanpassen lid <?php echo $row['Lid_nr'];?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
					<?php foreach ($row as $key => $value) : 
						if ($key == 'Lid_nr') {
					?>
							<input type="hidden" class="form-control" name="<?php echo "$key"?>" value="<?php echo "$value"?>">
					<?php 
						}
						else {
					?>
						<div class="form-group">
							<label><?php echo "$key"?></label>
							<input type="text" class="form-control" name="<?php echo "$key"?>" value="<?php echo "$value"?>">
						</div>
					<?php } endforeach ?>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info" name="Aanpassen" value="Aanpassen">
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endforeach ?>


<?php foreach ($result as $row) { ?>
	<!-- Edit Modal HTML -->
	<div id="Verwijderenlid<?php echo $row['Lid_nr'];?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<?php if (in_array($row['Lid_nr'], $Heeftnogleningen)) { ?>
				<form method="post" action="./leden.php">
					<div class="modal-header">						
						<h4 class="modal-title">Verwijderen lid <?php echo $row['Lid_nr'];?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<table class="table table-striped table-hover">
    	                	<thead>
    	                    <tr>
    	                        <th>Boek nummer</th>
    	                        <th>Titel</th>
    	                        <th>ISBN</th>
    	                    </tr>
    	                	</thead>
    	                	<tbody>
							<?php $LidLening = sqlquery("	SELECT lening.Boek_nr,boek.Titel, boek.ISBN FROM lening 
															JOIN exemplaar on lening.boek_nr = exemplaar.boek_nr
															JOIN Boek on exemplaar.ISBN = Boek.isbn
															WHERE lid_nr =  $row[Lid_nr]");
								foreach ($LidLening as $lening) : 
							?>
								<tr>
									<td><?php echo $lening['Boek_nr']?></td>
									<td><?php echo $lening['Titel']?></td>
									<td><?php echo $lening['ISBN']?></td>
								</tr>
							<?php endforeach ?>
							</tbody>
    	            	</table>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info" name="Aanpassen" value="Aanpassen">
					</div>
				</form>
				<? } else {
					bla;
				} ?>
			</div>
		</div>
	</div>

<?php }}?>

<?php include "./Templates/footer.php"; ?>