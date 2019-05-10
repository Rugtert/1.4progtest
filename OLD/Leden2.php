<?php include "./templates/header.php"; ?>
<?php
	//bevat algemene functies die op meerdere plaatsen gebruikt worden.
	require "./functies/common.php";
?>

<?php
	//Als $_POST['Aanpassen'] ingevuld is wordt code uitgevoerd dat het lid aanpast met de variabelen uit de array $_POST
	if (isset($_POST['Aanpassen'])) {
		$lid = sqlquery("UPDATE Lid SET Voornaam = \"$_POST[Voornaam]\", Achternaam = \"$_POST[Achternaam]\", Straatnaam = \"$_POST[Straatnaam]\", Huisnummer = \"$_POST[Huisnummer]\", Woonplaats = \"$_POST[Woonplaats]\", Postcode = \"$_POST[Postcode]\", Telefoonnummer = \"$_POST[Telefoonnummer]\", Emailadres = \"$_POST[Emailadres]\", Geboortedatum = \"$_POST[Geboortedatum]\" WHERE Lid_nr = $_POST[Lid_nr]");
		//var_dump($lid);
		if ($lid == 1) {
			echo "<p class=\"text-center\"><h2>Het lid is aangepast. De pagina moet opnieuw geladen worden om het resultaat te tonen.</h2> <a href=\"./leden.php\" class=\"btn btn-primary mb-2\">Pagina vernieuwen</a></p>";
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
	if(isset($_POST['Toevoegen'])) {
		// Future use
		$lid = sqlquery ("INSERT INTO lid (Voornaam, Voorvoegsel, Achternaam, Straatnaam, Huisnummer, Woonplaats, Postcode, Telefoonnummer, Emailadres, Geboortedatum) 
			VALUES (\"$_POST[Voornaam]\", \"$_POST[Voorvoegsel]\", \"$_POST[Achternaam]\", \"$_POST[Straatnaam]\", \"$_POST[Huisnummer]\", \"$_POST[Woonplaats]\", \"$_POST[Postcode]\", \"$_POST[Telefoonnummer]\", \"$_POST[Emailadres]\", \"$_POST[Geboortedatum]\")");
			if ($lid == 1) {
				Echo "<p class=\"text-center\"><h2>Het lid is toegevoegd. De pagina moet opnieuw geladen worden om het resultaat te tonen.</h2> <a href=\"./leden.php\" class=\"btn btn-primary mb-2\">Pagina vernieuwen</a></p>";
			}
			else {
				echo "er is iets foutgegaan tijdens het aanpassen van het lid. Foutcode: $lid";
				mysqli_errno($lid);
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
						$LedenMetGeleendeBoeken = array(); // wordt gebruikt om de leden die nog geleende boeken hebben op te slaan en later doorheen te itereren.
						
						foreach ($result as $row) :// Loop door elk resultaat uit de array $result. Zet de lidgegevens in een tabel.
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
							
							<?php 
								$Heeftnogleningen = sqlquery("SELECT Lid_nr,lening.Boek_nr,boek.Titel, boek.ISBN FROM lening 
                                JOIN exemplaar on lening.boek_nr = exemplaar.boek_nr
                                JOIN Boek on exemplaar.ISBN = Boek.isbn
                                WHERE lid_nr = $row[Lid_nr]");
    							if (($Heeftnogleningen->num_rows) > "0"){
									array_push($LedenMetGeleendeBoeken, $row['Lid_nr']);
							?>
								
								<td><a href="#VerwijderlidMetGeleendeBoeken<?php echo $row['Lid_nr']?>" class = "btn btn-danger" data-toggle="modal" data-target="#VerwijderlidMetGeleendeBoeken<?php echo $row["Lid_nr"];?>">Verwijderen</a></td>
								<?php //var_dump($row) ?>
								
							<?php }
								Else {
								//Verwijst naar het dialoogvenster "Verwijderlid<Lid_nr>" ?>
								<td><a href="#Verwijderlid<?php echo $row["Lid_nr"];?>" class = "btn btn-danger" data-toggle="modal" data-target="#Verwijderlid<?php echo $row["Lid_nr"];?>">Verwijderen</a></td>
								<?php } ?>
							
							<?php 	/* maakt het dialoogvenster "verwijderlid<Lid_nr>" aan. 
									Dit dialoogvenster geeft de waarde $_POST[Lid_nr] en $_POST[Verwijderen] mee als op de Verwijderknop geklikt wordt.
									$_POST[Verwijderen] wordt gebruikt om te controleren of het verwijderen uitgevoerd moet worden. 
									$_POST[Lid_nr] wordt gebruikt om aan te geven welk lid verwijderd moet worden. */?>
							<div id="Verwijderlid<?php echo $row['Lid_nr']?>" class="modal">
		        		    	<div class="modal-dialog">
		        		    		<div class="modal-content">
		        		    			<form method="post" action="./leden.php">
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


							<?php 	/* Maakt het dialoogvenster "Aanpassenlid<Lid_nr> aan.
									Dit dialoogvenster geeft de waarde $_POST[Aanpassen] mee als op de "Aanpassen" knop in het dialoogvenster geklikt wordt. 
									De waarde $_POST[Aanpassen] wordt gebruikt om te controleren of het aanpassen uitgevoerd moet worden.
									De lidgegevens worden gevuld door een foreach loop die alle kolomnamen in de variabele $key zet en alle waarden in de variabele $value zet.
									$key wordt als label en naam voor het inputveld gebruikt. $value wordt als standaardwaarde meegegeven aan het inputveld.
									*/?>
							<div id="Aanpassenlid<?php echo $row['Lid_nr']?>" class="modal">
		        		    	<div class="modal-dialog">
		        		    		<div class="modal-content">
		        		    			<form method="post" action="./leden.php">
		        		    				<div class="modal-header">						
		        		    					<h4 class="modal-title">Aanpassen lid nummer <?php echo $row['Lid_nr']?></h4>
		        		    				</div>
											<div class="modal-body">
												<?php foreach ($row as $key => $value) :
													if ($key == "Lid_nr") {?>
													<div class="form-group">
														<input type="hidden" class="form-control" name=<?php echo $key ?> value=<?php echo $value ?>>
													</div>
													<?php }
													else { ?>
													<div class="form-group">
														<label><?php echo $key ?></label>
														<input type="text" class="form-control" name=<?php echo $key ?> value=<?php echo $value ?>>
													</div>
													<?php } ?>
												<?php endforeach ?>
		        		    				<div class="modal-footer">
		        		    					<input type="button" class="btn btn-primary mb-2" data-dismiss="modal" value="Annuleren">
		        		    					<input type="Submit" class="btn btn-primary mb-2" name="Aanpassen" value="Aanpassen">
		        		    				</div>
		        		    			</form>
		        		    		</div>
		        		    	</div>
		        		    </div>
						</tr>

					<?php endforeach ?>
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
		
		// Zet de kolomnamen (keys) van de tabel LID in array $keys
		$keys = array_keys(mysqli_fetch_assoc(sqlquery("SELECT * FROM LID")));
		
		//foreach ($result as $row) {//$keys = mysqli_fetch_assoc($rij);
		//$fields = (mysqli_fetch_fields($result));
		//var_dump($keys);
		//foreach ($keys as $key) {var_dump($key);}
?>
		<div id="Toevoegenlid" class="modal">
   			<div class="modal-dialog" style="max-width: 8000px">
   				<div class="modal-content">
   					<form method="post" action="./leden.php">
   						<div class="modal-header">						
   							<h4 class="modal-title">Aanmaken lid</h4>
   						</div>
						<div class="modal-body">
							<?php foreach ($keys as $key) :
								if ($key == "Lid_nr") {}
								else { ?>
								<div class="form-group">
									<label><?php echo $key ?></label>
									<input type="text" class="form-control" name=<?php echo $key ?> value="">
								</div>
								<?php } ?>
							<?php endforeach ?>
   						<div class="modal-footer">
   							<input type="button" class="btn btn-primary mb-2" data-dismiss="modal" value="Annuleren">
   							<input type="Submit" class="btn btn-primary mb-2" name="Toevoegen" value="Toevoegen">
   						</div>
   					</form>
   				</div>
   			</div>
		</div>



	<?php 
		var_dump($LedenMetGeleendeBoeken);
		foreach ($LedenMetGeleendeBoeken as $lidMetGeleendeBoeken) : 
		$Heeftnogleningen = sqlquery("SELECT Lid_nr,lening.Boek_nr,boek.Titel, boek.ISBN FROM lening 
		JOIN exemplaar on lening.boek_nr = exemplaar.boek_nr
		JOIN Boek on exemplaar.ISBN = Boek.isbn
		WHERE lid_nr = $lidMetGeleendeBoeken");
		var_dump($lidMetGeleendeBoeken);
		var_dump($Heeftnogleningen);
		echo "$lidMetGeleendeBoeken";
	?>
		<div id="VerwijderlidMetGeleendeBoeken<?php echo $lidMetGeleendeBoeken?>" class="modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<form method="post" action="./leden.php">
						<div class="modal-header">						
							<h4 class="modal-title"></h4>
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
		</div>

<?php endforeach ?>
<?php include "./Templates/footer.php"; ?>