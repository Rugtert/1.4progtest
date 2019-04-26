<?php include "./templates/header.php"; ?>
<?php 
    require "./config/configsql.php"; //Bevat variabelen om met SQL te kunnen verbinden.
    if (isset($_POST['submit'])){ //Als $_POST['submit'] ingesteld is, voer onderstaande code uit.
        
        //$_POST variabelen omzetten naar normale variabelen zodat deze gebruikt kunnen worden in de SQL statement
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

        //Verbinden met mysql
        $conn = mysqli_connect($host, $username, $password, $dbname);
        
        //Als de variabele $conn leeg is wordt het uitvoeren gestopt en de foutmelding naar de browser gestuurd.
	    if (!$conn) {
	    	die("Connection failed: " . mysqli_connect_error());
        };

        //SQL query maken
        $sql = "INSERT INTO lid (Voornaam, Voorvoegsel, Achternaam, Straatnaam, Huisnummer, Woonplaats, Postcode, Telefoonnummer, Emailadres, Geboortedatum) 
        VALUES (\"$Voornaam\", \"$Voorvoegsel\", \"$Achternaam\", \"$Straatnaam\", \"$Huisnummer\", \"$Woonplaats\", \"$Postcode\", \"$Telefoonnummer\", \"$Emailadres\", \"$Geboortedatum\")";
        //SQL query uitvoeren
        mysqli_query($conn, $sql);
        
        //Als de SQL query een foutmelding registreert 
        if (mysqli_error($conn)) {
            echo "<p class=\"text-center\">Er is iets fout gegaan bij het aanmaken van het lid. Zie onderstaande foutmelding.<br>" . mysqli_error($conn) . "</p>";
            //Echo mysqli_error($conn);
            die;
        }
    die("<p class=\"text-center\">Lid toegevoegd! <a href=\"./Leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
	}
	
	//SQL verbinding maken
    $conn = mysqli_connect($host, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
    };
	
	$sql = "SELECT * FROM lid";
    $result = mysqli_query($conn, $sql);
    if (mysqli_error($conn)) {
		echo "Er is iets fout gegaan bij het opvragen van de basisgegevens. Zie onderstaande foutmelding.<br>";
		Echo mysqli_error($conn);
		die;
	};
	$user = mysqli_fetch_assoc($result);
	echo mysqli_use_result($conn);
?> 
<form method = "post">
<div class="container-fluid"
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