<?php include "./templates/header.php"; ?>


<?php
Require "./config/configsql.php";
    //function liddetails
    #$servername = "localhost";
    #$username = "root";
    #$password = "";
    #$dbname = "debieb";
    $lid_nr = $_POST['lid_nr'];
    echo "$lid_nr" ;
    // Create connection
    $conn = mysqli_connect($host, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT Lid_nr,Voorletter,voornaam,voorvoegsel,achternaam,straatnaam,huisnummer,huisnummertoevoeging,woonplaats,postcode,telefoonnummer,emailadres,geboortedatum FROM lid 
            WHERE lid_nr = $lid_nr";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            "<form> ";
        }
    } else {
        echo "0 results";
    }

    mysqli_close($conn);
?>
<?php include "./templates/footer.php"; ?>