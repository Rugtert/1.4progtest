<html>
    <body>
        <strong>
            <?php
                $hw = "hallo wereld!";
                echo $hw . "<BR>";
                echo strtoupper ($hw);
                echo "$hw";
                $sZin = "Dit is een zin. dit is een tweede zin. Dit is een derde.";
                echo strpos ($sZin, "dit") . "<br>";
                echo strrpos ($sZin, "dit") . "<br>";
                echo stripos ($sZin, "dit") . "<br>";
                echo strripos ($sZin, "dit") . "<br>";
                $nPlek = strpos ($sZin, "dit");
                echo substr ($sZin, $nPlek);
                $ngetal = 11;
                $ngetal2 = 4;
                $nPlus = $ngetal + $ngetal2;
                $nmin = $ngetal - $ngetal2;
                $nkeer = $ngetal * $ngetal2;
                $ndelen = $ngetal / $ngetal2;
                $nmod = $ngetal % $ngetal2;
                $nmacht = $ngetal ** $ngetal2;
                echo $nPlus . "<BR>" . $nmin . "<BR>" . $nkeer  . "<BR>" . $ndelen  . "<BR>" . $nmod . "<BR>" . $nmacht . "<BR>";
                $getal = 28/3;
                echo floatval ($getal) ;
                echo $getal;
                $kort = 4.3785e-2;
                $lang = 4.3785e-5;
                echo $kort . " " . $lang . "<br>";
                echo number_format ( $lang, 100) . "<br>";
                $prijs = 4.3785354235E3;
                echo "De prijs is &euro; " . number_format ($prijs, 90, ",", ".") . "<BR>";
                echo round ($prijs,90)
            ?>
        </strong>
    <body>
</html>