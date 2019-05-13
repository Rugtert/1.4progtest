<?php include "./templates/header.php"; ?>
<?php
	//bevat algemene functies die op meerdere plaatsen gebruikt worden.
	require "./functies/common.php";
	
	function GetArrayLedenMetGeleendeBoeken () { //vind de leden die nog boeken geleend hebben.
		$LedenMetGeleendeBoeken = array();
		$LedenMetGeleendeBoekenQuery = sqlquery("SELECT DISTINCT Lid_nr FROM lening WHERE inleverdatum IS NULL");
		foreach ($LedenMetGeleendeBoekenQuery as $lidnr) { array_push($LedenMetGeleendeBoeken, $lidnr['Lid_nr']);};
		return $LedenMetGeleendeBoeken;
	}

	function GetBoekenOpDitMomentGeleendDoorLid ($Lid_nr) { // vind de boeken die een lid ($Lid_nr) op dit moment geleend heeft (Inleverdatum IS NULL).
		$BoekenOpDitMomentGeleendDoorLid = sqlquery(
			"SELECT lening.Boek_nr,boek.Titel, boek.ISBN FROM lening 
			JOIN exemplaar on lening.boek_nr = exemplaar.boek_nr
			JOIN Boek on exemplaar.ISBN = Boek.isbn
			WHERE lid_nr = $Lid_nr
			AND Inleverdatum IS NULL"
		);
		return $BoekenOpDitMomentGeleendDoorLid;
	}

	function GetTableKeys ($table) {
		$Keys = array_keys(mysqli_fetch_assoc(sqlquery("SELECT * FROM $table")));
		return $Keys;
	}

	function LidToevoegen () { // Voegt een lid toe met waarden uit $_POST.
		$lid = sqlquery (
			"INSERT INTO lid (
				Voornaam, 
				Voorvoegsel, 
				Achternaam, 
				Straatnaam, 
				Huisnummer, 
				Woonplaats, 
				Postcode, 
				Telefoonnummer, 
				Emailadres, 
				Geboortedatum) 
			VALUES (
				\"$_POST[Voornaam]\", 
				\"$_POST[Voorvoegsel]\", 
				\"$_POST[Achternaam]\", 
				\"$_POST[Straatnaam]\", 
				\"$_POST[Huisnummer]\", 
				\"$_POST[Woonplaats]\", 
				\"$_POST[Postcode]\", 
				\"$_POST[Telefoonnummer]\", 
				\"$_POST[Emailadres]\", 
				\"$_POST[Geboortedatum]\")"
		);
		return $lid;
	}
	
	function LidAanpassen () { // Past een lid aan met de waarden uit $_POST.
		$lid = sqlquery (
			"UPDATE Lid SET 
			Voornaam = \"$_POST[Voornaam]\", 
			Achternaam = \"$_POST[Achternaam]\", 
			Straatnaam = \"$_POST[Straatnaam]\",
			Huisnummer = \"$_POST[Huisnummer]\", 
			Woonplaats = \"$_POST[Woonplaats]\", 
			Postcode = \"$_POST[Postcode]\", 
			Telefoonnummer = \"$_POST[Telefoonnummer]\", 
			Emailadres = \"$_POST[Emailadres]\", 
			Geboortedatum = \"$_POST[Geboortedatum]\" 
			WHERE Lid_nr = $_POST[Lid_nr]"
		);
		return $lid;
	}

	function LidVerwijderen () { // Past een lid toe met de waarden uit $_POST.
		$lid = sqlquery (
			"DELETE FROM lid WHERE lid_nr = $_POST[Lid_nr]"
		);
		return $lid;
	}
?>

<?php
	if(isset($_POST['Toevoegen'])) {
		// Voegt een lid toe met de gegevens uit $_POST
		$lid = LidToevoegen();
		if ($lid != 1) {
			echo "<p class=\"text-center\"><h2>er is iets foutgegaan tijdens het toevoegen van het lid. Foutmelding: $lid</h2></p>";
		}
	}
?>

<?php

	//Als $_POST['Aanpassen'] ingevuld is wordt code uitgevoerd dat het lid aanpast met de variabelen uit de array $_POST
	if (isset($_POST['Aanpassen'])) {
		$lid = LidAanpassen();
		if ($lid != 1) {
			echo "<p class=\"text-center\"><h2>er is iets foutgegaan tijdens het aanpassen van het lid. Foutmelding: $lid</h2></p>";
		}
	}
?>

<?php
	//Als $_POST['Verwijderen'] ingevuld is wordt code uitgevoerd dat het lid aanpast met de variabelen uit de array $_POST
	if (isset($_POST['Verwijderen'])) {
		$result = LidVerwijderen();
    	if ($result !=1) {
			Echo "<p class=\"text-center\"><h2>er is iets foutgegaan tijdens het verwijderen van het lid. Foutmelding: $lid</h2></p>";
		}
	}
?>

<?php
	//vraagt leden op uit de tabel "lid" en plaatst ze in de variabele $Leden
	$Leden = sqlquery("SELECT * FROM lid");
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
					foreach ($Leden as $Lid) :// Loop door elk resultaat uit de array $Leden. Zet de lidgegevens in een tabel.
				?>
					<tr>
						<td><?php echo $Lid["Lid_nr"];?></td>
						<td><?php 
								if (!empty($Lid["Voorvoegsel"])) {echo $Lid["Voornaam"] . " " . $Lid["Voorvoegsel"] . " " . $Lid["Achternaam"];}
								else {echo $Lid["Voornaam"] . " " . $Lid["Achternaam"];}
							?>
						</td>
						<td><?php echo $Lid['Straatnaam'] . " " . $Lid['Huisnummer'] . ", " . $Lid['Postcode'] . " " . $Lid['Woonplaats']?></td>
						<td><?php echo $Lid["Telefoonnummer"]?></td>
						<td><?php echo $Lid["Emailadres"]?></td>
            		    <td><?php echo $Lid["Geboortedatum"]?></td>
						<?php //Verwijst naar het dialoogvenster "Aanpassenlid<Lid_nr>" ?>
						<td><a href="#Aanpassenlid<?php echo $Lid["Lid_nr"];?>" class = "btn btn-primary" data-toggle="modal" data-target="#Aanpassenlid<?php echo $Lid["Lid_nr"];?>">Aanpassen</a></td>
						<td><a href="#Verwijderenlid<?php echo $Lid["Lid_nr"];?>" class = "btn btn-danger" data-toggle="modal" data-target="#Verwijderenlid<?php echo $Lid["Lid_nr"];?>">Verwijderen</a></td>	
					</tr>
				<?php endforeach ;?>
            </tbody>
        </table>
    </div>
	<a href="#Toevoegenlid" class = "btn btn-success" data-toggle="modal" data-target="#Toevoegenlid">Nieuw lid aanmaken</a>
	<a href="./index.html" class="btn btn-primary">Terug naar de hoofdpagina</a>
</div>
<?php 	/*Maakt het dialoogvenster "Toevoegenlid" aan.
		Dit dialoogvenster geeft de waarde $_POST[Toevoegen] mee als op de "toevoegen" knop in het dialoogvenster geklikt wordt. 
		De waarde $_POST[Toevoegen] wordt gebruikt om te controleren of het toevoegen uitgevoerd moet worden.
		$key wordt als label en naam voor het inputveld gebruikt.
		*/
?>
<?php 
	$keys = GetTableKeys("Lid"); // Zet de kolomnamen (keys) van de tabel "Lid" in de array $keys
?>
	<div id="Toevoegenlid" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="./leden.php">
					<div class="modal-header">						
						<h4 class="modal-title">Lid Toevoegen</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">	
						<?php 
							foreach ($keys as $key) : //foreach blok dat de velden aanmaakt.
							if ($key == "Lid_nr") {} //Lid nummer is een Auto-Increment waarde in de database en wordt dus niet meegenomen of invulbaar gemaakt.
							Else {
						?>
						<div class="form-group">
							<label><?php echo $key?></label>
							<input type="text" name="<?php echo $key?>" class="form-control">
						</div>
						<?php } endforeach?>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-primary" data-dismiss="modal" value="Annuleren">
						<input type="submit" class="btn btn-success" name="Toevoegen" value="Toevoegen">
					</div>
				</form>
			</div>
		</div>
	</div>

<?php	/*Maakt het dialoogvenster "Aanpassenlid" aan.
		Dit dialoogvenster geeft de waarde $_POST[Aanpassen] mee als op de "Aanpassen" knop in het dialoogvenster geklikt wordt. 
		De waarde $_POST[Aanpassen] wordt gebruikt om te controleren of het Aanpassen uitgevoerd moet worden.
		$key wordt als label en naam voor het inputveld gebruikt.
		*/
?>
<?php 
	foreach ($Leden as $Lid) : 
?>
	<div id="Aanpassenlid<?php echo $Lid['Lid_nr'];?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="post" action="./leden.php">
					<div class="modal-header">						
						<h4 class="modal-title">Aanpassen lid <?php echo $Lid['Lid_nr'];?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
					<?php 
						foreach ($Lid as $key => $value) : 
						if ($key == 'Lid_nr') {//Lid_nr wordt een hidden field zodat deze niet aanpasbaar is maar wel meegenomen wordt in de $_POST.
					?>		<input type="hidden" class="form-control" name="<?php echo "$key"?>" value="<?php echo "$value"?>">
					<?php
						}
						else {
					?>		<div class="form-group">
								<label><?php echo "$key"?></label>
								<input type="text" class="form-control" name="<?php echo "$key"?>" value="<?php echo "$value"?>">
							</div>
					<?php } endforeach ?>
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
	endforeach 
?>


<?php	/*Maakt het dialoogvenster "Verwijderenenlid" aan.
		Dit dialoogvenster geeft de waarde $_POST[Aanpassen] mee als op de "Aanpassen" knop in het dialoogvenster geklikt wordt. 
		De waarde $_POST[Aanpassen] wordt gebruikt om te controleren of het Aanpassen uitgevoerd moet worden.
		$key wordt als label en naam voor het inputveld gebruikt.
		*/
?>
<?php 
	$LedenMetGeleendeBoeken = GetArrayLedenMetGeleendeBoeken(); // Dialoogvenster "verwijderlid" wordt anders ingevuld als het lid nog boeken heeft geleend.
	foreach ($Leden as $Lid) : 
?>
		<div id="Verwijderenlid<?php echo $Lid['Lid_nr'];?>" class="modal fade">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<?php if (in_array($Lid['Lid_nr'], $LedenMetGeleendeBoeken)) { ?>
						<form method="post" action="./leden.php">
							<div class="modal-header">						
								<h4 class="modal-title">Het lid heeft onderstaande boeken nog geleend! Weet je zeker dat je lid <?php echo $Lid['Lid_nr'];?> wilt verwijderen?</h4>
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
									<?php 
										$BoekenOpDitMomentGeleendDoorLid = GetBoekenOpDitMomentGeleendDoorLid ("$Lid[Lid_nr]"); // Vind de boeken die het lid geleend heeft waar de inleverdatum niet is ingevuld
										foreach ($BoekenOpDitMomentGeleendDoorLid as $GeleendBoek) : 
									?>
										<tr>
											<td><?php echo $GeleendBoek['Boek_nr']?></td>
											<td><?php echo $GeleendBoek['Titel']?></td>
											<td><?php echo $GeleendBoek['ISBN']?></td>
										</tr>
									<?php endforeach ?>
									</tbody>
    		        	    	</table>
							</div>
							<div class="modal-footer">
								<input type="hidden" name="Lid_nr" Value="<?php echo $Lid['Lid_nr'];?>">
								<input type="button" class="btn btn-primary" data-dismiss="modal" value="Annuleren">
								<input type="submit" class="btn btn-danger" name="Verwijderen" value="Verwijderen">
							</div>
						</form>
					<?php } 
					else { ?>
					<form method="post" action="./leden.php">
						<div class="modal-header">						
							<h4 class="modal-title"> Weet je zeker dat je  lid nummer <?php echo $Lid['Lid_nr'];?> wilt verwijderen?</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="Lid_nr" Value="<?php echo $Lid['Lid_nr'];?>">
							<input type="button" class="btn btn-primary" data-dismiss="modal" value="Annuleren">
							<input type="submit" class="btn btn-danger" name="Verwijderen" value="Verwijderen">
						</div>
					</form>
				<?php	} ?>
				</div>
			</div>
		</div>
<?php 
	endforeach 
?>

<?php include "./Templates/footer.php"; ?>