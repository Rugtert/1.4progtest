<?php include "./templates/header.php"; ?>
<?php
	require "./config/configsql.php";
	// Create connection
	$conn = mysqli_connect($host, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	};
	$sql = "SELECT lid.lid_nr, voornaam, achternaam FROM lid";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) < 1) {
		die("no results");
	};
?>
<div class="container-fluid">
    <div class="table-responsive">
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
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
			<?php
				// output data of each row
				foreach ($result as $row) :
			?>
			<tr>
				<td><?php echo $row["lid_nr"];?></td>
				<td><?php echo $row["voornaam"];?></td>
				<td><?php echo $row["achternaam"];?></td> 
				<td><a href="Lid_aanpassen.php?lid_nr=<?php echo $row["lid_nr"];?>">Aanpassen</a></td>
			</tr>
			<?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "./Templates/footer.php"; ?>