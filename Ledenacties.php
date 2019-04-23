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
                        define ('servername', "localhost");
                        define ('username', "root");
                        define ('password', "");
                        define ('dbname', "debieb");
                        // Create connection
                        $conn = mysqli_connect(servername, username, password, dbname);
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
								/*<a href=\"#editEmployeeModal\" class=\"edit\" data-toggle=\"modal\"><i class=\"material-icons\" data-toggle=\"tooltip\" title=\"Edit\">&#xE254;</i></a>
								  <a href=\"#deleteEmployeeModal\" class=\"delete\" data-toggle=\"modal\"><i class=\"material-icons\" data-toggle=\"tooltip\" title=\"Delete\">&#xE872;</i></a>
									<tr>
									<td>
										<span class="custom-checkbox">
											<input type="checkbox" id="checkbox2" name="options[]" value="1">
											<label for="checkbox2"></label>
										</span>
									</td>
                        			<td>Dominique Perrier</td>
                        			<td>dominiqueperrier@mail.com</td>
									<td>Obere Str. 57, Berlin, Germany</td>
                        			<td>(313) 555-5735</td>
                        			<td>
                        			    <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                        			    <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        			</td>
								*/
							} else {
								echo "0 results";
							}
						?>
                </tbody>
            </table>
        </div>
    </div>
	<!-- Edit Modal HTML -->
	<div id="addEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">						
						<h4 class="modal-title">Add Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" required>
						</div>					
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
	<div id="editEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">						
						<h4 class="modal-title">Wijzig Lid</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Achternaam</label>
							<input type="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Address</label>
							<textarea class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" required>
						</div>					
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info" value="Save">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">						
						<h4 class="modal-title">Delete Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<p>Are you sure you want to delete these Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
<?php include "./Templates/footer.php"; ?>