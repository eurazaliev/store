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
			->setName('Главный офис')
			->setCity('Default City')
			->setAddress('Невский, 45')
			->setMemo('Тут все');
		$manager->persist($building);
		
		$building2 = new Building();
		$building2
			->setName('Второй офис')
			->setCity('Default City')
			->setAddress('Проспект, 45')
			->setMemo('Тут бэкофис');

		$manager->persist($building2);
		
		$building3 = new Building();
		$building3
			->setName('Офис продаж')
			->setCity('City Москва')
			->setAddress('Красная площадь, 45')
			->setMemo('Тут продают');
		$manager->persist($building3);
		$manager->flush();		

		$this->addReference('building', $building);
		$this->addReference('building2', $building2);
		$this->addReference('building3', $building3);

	}

}
