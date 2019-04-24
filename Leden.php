<?php include "./templates/header.php"; ?>
    <div class="container">
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
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
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
						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								echo "<tr><td>". $row["lid_nr"]. "</td>" . "<td>" . $row["voornaam"]. "</td>" . "<td>" . $row["achternaam"]. "</td>" . 
									"<td>" . "
									<form action=Lid_Aanpassen.php method=\"post\">
										<input type=\"Hidden\" Name=\"lid_nr\" Value=" . $row["lid_nr"] . ">
										<input type=\"Submit\" Value=\"Aanpassen\">
									</form>
									</td>	
									<td>
									<form action=Lid_Verwijderen.php method=\"post\">
										<input type=\"Hidden\" Name=\"lid_nr\" Value=" . $row["lid_nr"] . ">
										<input type=\"Submit\" Value=\"Verwijderen\">
									</form>	
									</td>
								</tr>";
							};
							mysqli_close($conn);
							} else {
								echo "0 results";
							}
						?>
                </tbody>
            </table>
        </div>
    </div>
<?php include "./Templates/footer.php"; ?>