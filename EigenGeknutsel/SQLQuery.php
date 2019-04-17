<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "debieb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT lid_nr, voornaam, achternaam FROM lid WHERE Voornaam = \"Guy\"";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "lid_nr: " . $row["lid_nr"]. " - Naam: " . $row["voornaam"]. " " . $row["achternaam"]. "<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>