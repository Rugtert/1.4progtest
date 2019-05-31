<?php
// Definieëren van verbindingsparameters als constanten.
define("host", "localhost");
define("username", "root");
define("password", "");
define("dbname", "debieb");

$dsn = "mysql:host=".host.";dbname=".dbname.";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, username, password, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

?>
