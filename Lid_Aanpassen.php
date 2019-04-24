<?php include "./templates/header.php"; ?>
<?php 
    require "./config/configsql.php";

    if (isset($_GET['lid_nr'])) {
        $conn = mysqli_connect($host, $username, $password, $dbname);
	    // Check connection
	    if (!$conn) {
	    	die("Connection failed: " . mysqli_connect_error());
        };
        
        $sql = "SELECT * FROM lid WHERE lid_nr = $_GET[lid_nr]";
        $result = mysqli_query($conn, $sql);
        
	    if (mysqli_num_rows($result) < 1) {
	       	die("no results");
        };
        $user = mysqli_fetch_assoc($result);
    }
    else {
        Echo "Something went wrong";
        exit;
    };
?>
<div class="container-fluid">
    <div class="table-responsive">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2><b>Aanpassen lid <?php//$row = mysqli_fetch_assoc($result); echo $row["voornaam"];?></b></h2>
				</div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <?php foreach ($user as $key => $value) : ?>
                    <?php echo "<th>$key </th>" ; ?>
                    <?php endforeach;?>

                </tr>
            </thead>
            <tbody>
            <?php
			?>
<?php /*<div class="container">
        <div class="table-wrapper">
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
                        <th>Voornaam</th>
						<th>Achternaam</th>
                        <th>straatnaam</th>
                        <th>huisnummer</th>
                        <th>woonplaats</th>
                        <th>postcode</th>
                        <th>emailadres</th>
                    </tr>
                </thead>
                <tbody>

<?php
//verwerken formulier
    if (isset($_POST['submit'])) {
        Require "./config/configsql.php";
        $conn = mysqli_connect($host, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "UPDATE lid SET voornaam = $_POST[voornaam] achternaam = $_POST[achternaam] straatnaam = $_POST[straatnaam] huisnummer = $_POST[huisnummer] woonplaats = $_POST[woonplaats] postcode = $_POST[postcode] emailadres = $_POST[emailadres] 
                WHERE lid_nr = $_POST[lid_nr]";
        echo $sql;
    }
?>
<?php
//Input formulier
Require "./config/configsql.php";
    $lid_nr = $_POST['lid_nr'];
    // Create connection
    $conn = mysqli_connect($host, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT lid_nr,voorletter,voornaam,voorvoegsel,achternaam,straatnaam,huisnummer,huisnummertoevoeging,woonplaats,postcode,telefoonnummer,emailadres,geboortedatum FROM lid 
            WHERE lid_nr = $lid_nr";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $row = mysqli_fetch_assoc($result) ;
            $lid_nr                 = $row["lid_nr"];
            $voornaam               = $row["voornaam"];
            $achternaam             = $row["achternaam"];
            $straatnaam             = $row["straatnaam"];
            $huisnummer             = $row["huisnummer"];
            $woonplaats             = $row["woonplaats"];
            $postcode               = $row["postcode"];
            $emailadres             = $row["emailadres"];
            $geboortedatum          = $row["geboortedatum"];
            //$Voorletter             = $row["voorletter"];
            //$voorvoegsel            = $row["voorvoegsel"];
            //$telefoonnummer         = $row["telefoonnummer"];
            //$huisnummertoevoeging   = $row["huisnummertoevoeging"];
            "<form method=\"post\">";
            echo "<tr>" . "
                    <td><input type=\"text\" Name=\"lid_nr\" Value=\"" . $lid_nr. "\"readonly size=\"4\"></td>
                    <td><input type=\"text\" Name=\"voornaam\" Value=\"" . $voornaam. "\" size=\"14\"></td>
                    <td><input type=\"text\" Name=\"achternaam\" Value=\"" . $achternaam. "\" size=\"14\"></td>
                    <td><input type=\"text\" Name=\"straatnaam\" Value=\"" . $straatnaam. "\" size=\"14\"></td>
                    <td><input type=\"text\" Name=\"huisnummer\" Value=\"" . $huisnummer. "\" size=\"4\"></td>
                    <td><input type=\"text\" Name=\"woonplaats\" Value=\"" . $woonplaats. "\" size=\"14\"></td>
                    <td><input type=\"text\" Name=\"postcode\" Value=\"" . $postcode. "\" size=\"6\"></td>
                    <td><input type=\"text\" Name=\"emailadres\" Value=\"" . $emailadres. "\" size=\"14\"></td>
                </tr></table>
                <input type=\"submit\" Name=\"submit\" Value=\"Lidgegevens aanpassen\">
                </form>";
        
    }
    else {
        echo "0 results";
    }

    mysqli_close($conn);
?>
<?php include "./templates/footer.php"; ?>*/?>