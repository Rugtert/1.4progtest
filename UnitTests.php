<?php
include './functies/Common.php';
Include './functies/Leden_Functies.php';


class UnitTests extends PHPUnit\Framework\TestCase
{

    /** @test */
    public function testMoonTime()// Test de functie "HoeLangDuurtHetOmDeMaanTeBereiken".
    {
        $result = HoeLangDuurtHetOmDeMaanTeBereiken(10.1);
        $this->assertEquals("Tijd om de maan te bereiken als deze het dichst bij staat: 35950.89 uur. Tijd om de maan te bereiken als deze het verste weg is: 40167.92 uur. Gemiddelde tijd om de maan te bereiken: 38118.81 uur.", $result);
    }
    /**
     * @dataProvider boeteProvider
     */
    public function testBoeteBerekening($a, $b, $expected)// test de boeteberekening door een mysqli regel na te maken waarbij het boek 2 dagen te laat is en deze te voeren aan de functie "GetOpenstaandeBoeteBedragenVanLid".
    {
        $lening[0] = array( // Deze array bootst een mysql resultaat na dat gebruikt wordt in de functie.
            'Lid_nr' => '1',
            'Boetetarief' => $a,
            'Uitleengrondslag' => '14',
            'Uitleentijdstip' => (date('Y-m-d',strtotime("-$b days")))  //16 dagen geleden zodat het verschil tussen uitleentijdstip en uitleengrondslag een waarde van 2 dagen geeft ($interval in de functie).
        );
        $Lid_nr = 1;
        $Result = GetOpenstaandeBoeteBedragenVanLid($lening,$Lid_nr);
        $this->assertEquals($expected, $Result); //verwacht wordt boetetarief * dagen te laat (= $interval, in dit geval 2) dus 8.78 * 2 = 17.56
    }
    public function boeteProvider() {
        return [
            [8.78, 16, 17.56],
            [8, 16, 16],
            [100000, 14, 0],
            [1000000000, 16, 2000000000],
            [8.78, 56, 368.76],
            [8.78, 56, 368] // Geeft een fout
        ];
    }
    /** @test */
    public function testReadabilityOfRequiredFiles() // Test of de bestanden die nodig zijn voor voor de werking van het programma leesbaar zijn
    {
        $this->assertFileIsReadable("./functies/Common.php");
        $this->assertFileIsReadable("./Templates/Header.php");
        $this->assertFileIsReadable("./Templates/Footer.php");
    }
    /** @test */
    public function testSQLFunction() // Test de functie sqlquery door een query voor de versie van mysql uit te voeren (data onafhankelijk) en te controleren of het resultaat de key "Version_Name" heeft.
    {
        $result = sqlquery("SELECT @@VERSION AS Version_Name  ");
        $array = mysqli_fetch_assoc($result); //mysqli_result object omzetten naar een array
        $this->assertArrayHasKey("Version_Name", $array);

    }
}
