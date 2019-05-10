<?php include "./templates/header.php"; ?>
<?php 
    require "./functies/common.php";
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
        //SQL query maken
        sqlquery ("UPDATE Lid SET Voornaam = \"$Voornaam\", Voorvoegsel = \"$Voorvoegsel\", Achternaam = \"$Achternaam\", Straatnaam = \"$Straatnaam\", Huisnummer = \"$Huisnummer\", Woonplaats = \"$Woonplaats\", Postcode = \"$Postcode\", Telefoonnummer = \"$Telefoonnummer\", Emailadres = \"$Emailadres\", Geboortedatum = \"$Geboortedatum\" WHERE Lid_nr = \"$Lid_nr\"");
        die("<p class=\"text-center\">Lid aangepast! <a href=\"./Leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
    }
    if (isset($_GET['Lid_nr'])) {

        $result = sqlquery ("SELECT * FROM lid WHERE lid_nr = $_GET[Lid_nr]");
        
	    if (mysqli_num_rows($result) != 1) {
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