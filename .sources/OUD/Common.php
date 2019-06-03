<?php
// Definieëren van verbindingsparameters als constants.
define("host", "localhost");
define("username", "root");
define("password", "");
define("dbname", "debieb");

function sqlquery($query)
{// Voert een sqlquery uit op de database

    // Report mode instellen zodat er gebruik gemaakt kan worden van een try & catch
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Verbinding maken
        $conn = mysqli_connect(host, username, password, dbname);
        // Query uitvoeren
        $result = mysqli_query($conn, $query);
        // Resultaat van query als uitvoer van de functie zodat deze gebruikt kan worden in de code die de functie aanroept.
        // Verbinding sluiten
        mysqli_close($conn);
        return $result;
    }
    catch (mysqli_sql_exception $e) {
        //Foutmeldingen afvangen met catch zodat deze gebruikt kan worden in de code die de functie aanroept.
        return mysqli_error($conn);
    }
};
?>