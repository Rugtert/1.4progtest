<html>

<head>
<title>Fourbuttons</title>
</head>

<body>

<?php

$connectie = mysqli_connect('localhost','root','','databaseconnect');

// Gebruik $a en $b als operanden; $uitkomst als resultaat

// Bepaal de waarde van $a en $b
$a = $_POST['CustomerNumber'] ;
$b = $_POST['CustomerName'] ;
$c = $_POST['Customeraddress'] ;
$d = $_POST['CustomerZipCode'] ;
$e = $_POST['CustomerPlace'] ;
$f = $_POST['CustomerEmail'] ;
$g = $_POST['CustomerPwd'] ;

if (isset($_POST['Create'])) {

	$ingevoegd = mysqli_query($connectie,"INSERT INTO customer(Customernumber, Customername,
	      Customeraddress, Customerzipcode, Customerplace, Customeremail, Customerpwd)
		  VALUES ('$a','$b','$c','$d','$e','$f','$g')");
		echo "Customer has been created" ;

}
elseif (isset($_POST['Read'])) {

	$resultaat = mysqli_query($connectie, "SELECT * FROM customer;");
    while ($record = mysqli_fetch_assoc($resultaat))
    {
        //echo $record["Customernumber"] . " = " . $a . "->" . $record["Customername"];
		//echo "</br>";

		if($record["Customernumber"] === $a)
			$b = $record["Customername"];
			$c = $record["Customeraddress"];
			$d = $record["Customerzipcode"];
			$e = $record["Customerplace"];
			$f = $record["Customeremail"];
			$g = $record["Customerpwd"];
    }
	if (strlen($b) < 2)
		$b = "Niet gevonden";


}
elseif (isset($_POST['Update'])) {

	$Update = mysqli_query($connectie, "UPDATE customer SET Customernumber = '$a', Customername = '$b' WHERE customernumber = $a");
	echo "Customer has been updated" ;
}

elseif (isset($_POST['Delete'])) {

	$Delete = mysqli_query($connectie, "DELETE FROM customer WHERE customernumber = $a");
	echo "Customer is deleted" ;
}


?>

<form action=fourbuttons.php method="post">

Customernumber: <input type="text" name="CustomerNumber" value="<?php echo $a; ?>"/>
<br/>
Customername: <input type="text" name="CustomerName" value="<?php echo $b; ?>"/>
<br/>
Customeraddress: <input type="text" name="Customeraddress" value="<?php echo $c; ?>"/>
<br/>
Customerzipcode: <input type="text" name="CustomerZipCode" value="<?php echo $d; ?>"/>
<br/>
Customerplace: <input type="text" name="CustomerPlace" value="<?php echo $e; ?>"/>
<br/>
Customeremail: <input type="text" name="CustomerEmail" value="<?php echo $f; ?>"/>
<br/>
Customerpwd: <input type="text" name="CustomerPwd" value="<?php echo $g; ?>"/>
<br/><br/>

<br/><br/>
<input type="submit" name="Create" value="Create"/>
<input type="submit" name="Read" value="Read"/>
<input type="submit" name="Update" value="Update"/>
<input type="submit" name="Delete" value="Delete"/>

</form>

</body>
</html>
