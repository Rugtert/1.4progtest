
<?php
    function sqlquery ($query){
        // Voert een sqlquery uit op de database

        // Report mode instellen zodat er gebruik gemaakt kan worden van een try & catch
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Variabelen voor de verbinding declareren
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "debieb";
        
        try {
            // Verbinding maken
            $conn = mysqli_connect($host, $username, $password, $dbname);
            // Query uitvoeren
            $result = mysqli_query($conn, $query);
            return $result;
            //verbinding sluiten
            mysqli_close($conn);
        }
        //Foutmeldingen afvangen met een catch zodat deze gebruikt kan worden in de code die de functie aanroept.
        catch (mysqli_sql_exception $e) {
            return mysqli_errno($conn);
            die;
        }
    }
?>