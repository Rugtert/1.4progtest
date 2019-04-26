<?php include "./templates/header.php"; ?>
<?php 
    require "./config/configsql.php"; //Bevat variabelen om met SQL te kunnen verbinden.

    if (isset($_GET['Lid_nr'])) {
        $conn = mysqli_connect($host, $username, $password, $dbname);
	    // Check connection
	    if (!$conn) {
	    	die("Connection failed: " . mysqli_connect_error());
        }
        
        $sql = "DELETE FROM lid WHERE lid_nr = $_GET[Lid_nr]";
        $result = mysqli_query($conn, $sql);

        if (mysqli_error($conn)) {
            echo "<p class=\"text-center\">Er is iets fout gegaan bij het aanmaken van het lid. Zie onderstaande foutmelding.<br>" . mysqli_error($conn) . "</p>";
            //Echo mysqli_error($conn);
            die;
        }
    }
    else {
        Echo "Something went wrong";
        exit;
    }
    die("<p class=\"text-center\">Lid verwijderd! <a href=\"./Leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
?>

<?php include "./templates/footer.php"; ?>