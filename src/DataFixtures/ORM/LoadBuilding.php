<?php
namespace App\DataFixtures\ORM;

use App\Entity\Building;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

//class Fixtures extends Fixture
class LoadBuilding extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$building = new Building();
		$building
			->setName('Hot Lake')
			->setCity('Paris')
			->setAddress('Gurnet st. 45')
			->setMemo('Hot Lake Business Center');
		$manager->persist($building);
		
		$building2 = new Building();
		$building2
			->setName('Vem 9')
			->setCity('Horf')
			->setAddress('Beaver sq. 43/4')
			->setMemo('Sofrware development dept');

		$manager->persist($building2);
		
		$building3 = new Building();
		$building3
			->setName('Sales Center')
			->setCity('Hederberg')
			->setAddress('Red lights st. 119')
			->setMemo('Sales Department');
		$manager->persist($building3);
		$manager->flush();		

		$this->addReference('building', $building);
		$this->addReference('building2', $building2);
		$this->addReference('building3', $building3);

	}

}
