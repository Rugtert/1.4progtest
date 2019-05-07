<?php include "./templates/header.php"; ?>

<?php 
    require "./functies/common.php";
    if (isset($_POST['submit'])){ //Als $_POST['submit'] ingesteld is, voer onderstaande code uit.
        //$_POST variabelen omzetten naar normale variabelen zodat deze makkelijker gebruikt kunnen worden in de SQL statement
        $Voornaam = $_POST["Voornaam"];
        $Voorvoegsel = $_POST["Voorvoegsel"];
        $Achternaam = $_POST["Achternaam"];
        $Straatnaam = $_POST["Straatnaam"];
        $Huisnummer = $_POST["Huisnummer"];
        $Woonplaats = $_POST["Woonplaats"];
        $Postcode = $_POST["Postcode"];
        $Telefoonnummer = $_POST["Telefoonnummer"];
        $Emailadres = $_POST["Emailadres"];
        $Geboortedatum = $_POST["Geboortedatum"];

        //functie sqlquery uitvoeren om gegevens uit de database op te vragen
        sqlquery ("INSERT INTO lid (Voornaam, Voorvoegsel, Achternaam, Straatnaam, Huisnummer, Woonplaats, Postcode, Telefoonnummer, Emailadres, Geboortedatum) 
                    VALUES (\"$Voornaam\", \"$Voorvoegsel\", \"$Achternaam\", \"$Straatnaam\", \"$Huisnummer\", \"$Woonplaats\", \"$Postcode\", \"$Telefoonnummer\", \"$Emailadres\", \"$Geboortedatum\")");
        die("<p class=\"text-center\">Lid toegevoegd! <a href=\"./Leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
	}
	$result = sqlquery ("SELECT * FROM lid");
	$user = mysqli_fetch_assoc($result);
?> 

<form method = "post">
<div class="container-fluid">
  <div class="form-group">
    <?php foreach ($user as $key => $value) : ?>
	<?php
	if ($key == 'Lid_nr'){
    } 
    Else {
		echo "<label for=\"<?php echo $key;?>\">$key</label>";
        echo "<input type=\"text\" class=\"form-control\" id=\"$key\" name=\"$key\" value=\"\">";
    }
    ?>
    <br>
    <?php endforeach;?>
    <div class="row">
        <div class="col">
            <input type="submit" class="btn btn-primary mb-2" Name="submit" Value="Lid aanmaken">
            <a href="./Leden.php" class="btn btn-primary mb-2">Annuleren</a>
        </div>
    </div>
  </div>
</div>
</form>
<?php include "./templates/footer.php"; ?>