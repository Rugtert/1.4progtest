<?php include "./templates/header.php"; ?>
<?php 
    require "./functies/common.php";

    if (isset($_GET['Lid_nr'])) {
        $result = sqlquery("DELETE FROM lid WHERE lid_nr = $_GET[Lid_nr]");
    }
    die("<p class=\"text-center\">Lid verwijderd! <a href=\"./Leden.php\" class=\"btn btn-primary mb-2\">Terug naar de ledenpagina</a></p>");
?>

<?php include "./templates/footer.php"; ?>