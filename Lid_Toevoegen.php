<?php include "./templates/header.php"; ?>
    <h2>Lid Toevoegen</h2>
    <form method="post">
    	<label for="voornaam">First Name</label>
    	<input type="text" name="voornaam" id="voornaam">
    	<label for="achternaam">Last Name</label>
    	<input type="text" name="achternaam" id="achternaam">
    	<label for="Emailadres">Emailadres Address</label>
    	<input type="text" name="Emailadres" id="Emailadres">
    	<label for="age">Age</label>
    	<input type="text" name="age" id="age">
    	<label for="location">Location</label>
    	<input type="text" name="location" id="location">
    	<input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.html">Terug naar de startpagina</a>

    <?php include "./templates/footer.php"; ?>