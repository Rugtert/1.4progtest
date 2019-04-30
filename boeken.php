<?php include "./templates/header.php"; ?>

<?php 
    require "./config/configsql.php"; //Bevat variabelen om met SQL te kunnen verbinden.	
	//SQL verbinding maken
    $conn = mysqli_connect($host, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
    };
	
	$sql = "SELECT * FROM boek";
    $result = mysqli_query($conn, $sql);
    if (mysqli_error($conn)) {
		echo "Er is iets fout gegaan bij het opvragen van de basisgegevens. Zie onderstaande foutmelding.<br>";
		Echo mysqli_error($conn);
		die;
	};
    $user = mysqli_fetch_all($result);
    var_dump ($user);
?> 

<form method = "post">
<div class="container-fluid"
  <div class="form-group">
    <?php foreach ($user as $key => $value) : 
        var_dump ($key);
        var_dump ($value);?>
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