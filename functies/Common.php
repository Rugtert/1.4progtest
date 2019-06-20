<?php
// Definieëren van verbindingsparameters als constanten.
define("host", "localhost");
define("username", "root");
define("password", "");
define("dbname", "debieb");


$dsn = "mysql:host=" . host . ";dbname=" . dbname . ";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, username, password, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

function TableHeaderWriter(array $HeaderNames)
{// Neemt een array en geeft voor elke waarde in de array <th>waarde</th> terug op een nieuwe regel (\n)
    $return = array();
    for ($i = 0; $i < count($HeaderNames); $i++) {
        array_push($return, "<th>$HeaderNames[$i]</th>");
    }
    return implode("\n", $return);
}

function sqlquery($query)
{// Voert een sqlquery uit op de database. Dit staat hier alleen nog voor de mysql unittest "TestSQLFunction".

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
    } catch (mysqli_sql_exception $e) {
        //Foutmeldingen afvangen met catch zodat deze gebruikt kan worden in de code die de functie aanroept.
        return mysqli_error($conn);
    }
}

?>
