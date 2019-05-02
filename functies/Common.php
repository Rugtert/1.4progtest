
<?php
    function sqlquery ($query){
        // Voert een sqlquery uit op de database
        // Verbinding maken
        /* activate reporting */
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "debieb";
        
        try {
            $conn = mysqli_connect($host, $username, $password, $dbname);
            $sql = $query;
            $result = mysqli_query($conn, $sql);
            return $result;
            mysqli_close($conn);
        }
        catch (mysqli_sql_exception $e) {
            //echo $e;
            if (mysqli_errno($conn) == "1451") { echo "er zijn nog afhankelijkheden.";}
            echo mysqli_errno($conn);
            die;
        }

        /* Als de SQL query een foutmelding registreert stop dan met uitvoeren
        if (mysqli_error($conn)) {
            die("Er is iets fout gegaan bij het opvragen van de leden. Zie onderstaande foutmelding.<br>" . mysqli_error($conn));
        }
        // Resultaat teruggeven en verbinding sluiten*/
    }
?>