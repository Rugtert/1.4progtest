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
        $Lid_nr = $_POST["Lid_nr"];

        //Verbinden met mysql
        $conn = mysqli_connect($host, $username, $password, $dbname);
        
        //Als de variabele $conn leeg is wordt het uitvoeren gestopt en de foutmelding naar de browser gestuurd.
	    if (!$conn) {
	    	die("Connection failed: " . mysqli_connect_error());
        };

        //SQL query maken
        $sql = "UPDATE lid SET Voornaam = \"$Voornaam\", Voorvoegsel = \"$Voorvoegsel\", Achternaam = \"$Achternaam\", Straatnaam = \"$Straatnaam\", Huisnummer = \"$Huisnummer\", Woonplaats = \"$Woonplaats\", Postcode = \"$Postcode\", Telefoonnummer = \"$Telefoonnummer\", Emailadres = \"$Emailadres\", Geboortedatum = \"$Geboortedatum\" WHERE Lid_nr = \"$Lid_nr\"";
        //SQL query uitvoeren
        mysqli_query($conn, $sql);
        
        //Als de SQL query een foutmelding registreert 
        if (mysqli_error($conn)) {
            echo "Er is iets fout gegaan bij het aanpassen van het lid. Zie onderstaande foutmelding.<br>";
            Echo mysqli_error($conn);
            die;
        }
    die("<p class=\"text-center\">Lid aangepast! <a href=\"./Leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
    }
    if (isset($_GET['Lid_nr'])) {
        $conn = mysqli_connect($host, $username, $password, $dbname);
	    // Check connection
	    if (!$conn) {
	    	die("Connection failed: " . mysqli_connect_error());
        };
        
        $sql = "SELECT * FROM lid WHERE lid_nr = $_GET[Lid_nr]";
        $result = mysqli_query($conn, $sql);
        
	    if (mysqli_num_rows($result) < 1) {
	       	die("no results");
        };
        $user = mysqli_fetch_assoc($result);
        //var_dump($user); //De-commenteer omm te kijken wat er in de array $user zit
    }
    else {
        Echo "Something went wrong";
        exit;
    };
?>
<form method = "post">
<div class="container-fluid"
  <div class="form-group">
    <?php 
        foreach ($user as $key => $value) : 
    ?> 
    <label for="<?php echo $key;?>"><?php echo $key;?></label>
    <?php
    if ($key == 'Lid_nr'){
        echo "<input type=\"text\" class=\"form-control\" id=\"$key\" name=\"$key\" value=\"$value\" readonly>";
    } 
    Else {
        echo "<input type=\"text\" class=\"form-control\" id=\"$key\" name=\"$key\" value=\"$value\">";
    }
    ?>
    <br>
    <?php endforeach;?>
    <div class="row">
        <div class="col">
            <input type="submit" class="btn btn-primary mb-2" Name="submit" Value="Lidgegevens aanpassen">
            <a href="./Leden.php" class="btn btn-primary mb-2">Annuleren</a>
        </div>
    </div>

  </div>
</div>
</form>
<?php include "./templates/footer.php"; ?>