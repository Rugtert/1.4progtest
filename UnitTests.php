<?php
Include 'Leden.php';

class UnitTests extends PHPUnit\Framework\TestCase
{
    /** @test */
    public function TestBoeteBerekening()// test de boeteberekening door een mysqli regel na te maken waarbij het boek 2 dagen te laat is en deze te voeren aan de functie "GetOpenstaandeBoeteBedragenVanLid".
    {
        $lening[1] = array( // Deze array bootst een mysqli resultaat na dat gebruikt wordt in de functie.
            'Lid_nr' => '1',
            'Boetetarief' => '8.78',
            'Uitleengrondslag' => '14',
            'Uitleentijdstip' => (date('Y-m-d',strtotime("-16 days")))  //16 dagen geleden zodat het verschil tussen uitleentijdstip en uitleengrondslag een waarde van 2 dagen geeft ($interval in de functie).
        );
        $Lid_nr = 1;
        $Result = GetOpenstaandeBoeteBedragenVanLid($lening,$Lid_nr);
        $this->assertEquals(17.56, $Result); //verwacht wordt boetetarief * dagen te laat (= $interval, in dit geval 2) dus 8.78 * 2 = 17.56
    }
    /** @test */
    public function TestLidToevoegen()// test de boeteberekening door een mysqli regel na te maken waarbij het boek 2 dagen te laat is en deze te voeren aan de functie "GetOpenstaandeBoeteBedragenVanLid".
    {

    }
}
