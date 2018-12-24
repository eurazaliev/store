<?php 
use App\Entity\Country;
class CountryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
        
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCreate()
    {
        $name = "Венгрия";
        $memo = "Мадьяры";

        $country = new Country();

        $this->expectException(TypeError::class);
	$country->setName(null);
        $country->setSactions('sdgf');

        //        $this->assertFalse($country->validate(['name']));

        $country->setName($name);
        $country->setMemo($memo);
/*        $this->assertFalse($country->validate(['name']));
        $country->setName('davert');
        $this->assertTrue($country->validate(['name']));
*/
        $country->save();

    }
}
