
<?php
	//bevat algemene functies die op meerdere plaatsen gebruikt worden.
	require "./functies/common.php";
    $lening = sqlquery(
        "SELECT Lid_nr, Boetetarief,Uitleengrondslag,Uitleentijdstip FROM exemplaar 
        JOIN Lening 
        WHERE lening.Inleverdatum IS NULL"
    );
    $boetetotaal = 0;
    Foreach ($lening as $boete){
        $uitleendatum = new DateTime($boete["Uitleentijdstip"]);
        $uitleendatum->add(new DateInterval("P" . $boete["Uitleengrondslag"] . "D")); //intval met een periode (P) van $boete["uitleengrondslag"] dagen (D))
        //echo date_format($uitleendatum, "Y-m-d");
        $today = new DateTime('now');
        $interval = date_diff($uitleendatum, $today);
        if ($interval->format("%a") > 0){
            $boetefloat = round($boete["Boetetarief"],2);
            $boetetotaal += ($interval->format("%a") * round($boete["Boetetarief"],2));
        }
    };
return $boetetotaal;
?>