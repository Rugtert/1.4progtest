<?php
//function liddetails
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "debieb";
$Voornaam = $_POST['Voornaam'];
$Titel = $_POST['Titel'];

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT lid.lid_nr, voornaam, achternaam, boek.titel FROM lid 
        JOIN LENING on lid.lid_nr = lening.lid_nr
        JOIN EXEMPLAAR on lening.boek_nr = exemplaar.boek_nr
        JOIN BOEK on exemplaar.isbn = boek.isbn
        WHERE Voornaam = \"$Voornaam\" AND boek.titel = \"$Titel\"";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "lid_nr: " . $row["lid_nr"]. " - Naam: " . $row["voornaam"]. " " . $row["achternaam"]." ". "geleend boek:". $row["titel"]."<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>