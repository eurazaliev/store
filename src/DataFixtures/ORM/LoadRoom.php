<?php
namespace App\DataFixtures\ORM;

use App\Entity\Room;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

//class Fixtures extends Fixture
class LoadRoom extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$room = new Room();
		$room
			->setName('127')
			->setMemo('Второй этаж')
			->setBuildingId($this->getReference('building'));
		$manager->persist($room);
		
		$room2 = new Room();
		$room2
			->setName('Гардероб')
			->setMemo('Разденься')
			->setBuildingId($this->getReference('building2'));
		$manager->persist($room2);
		
		$room3 = new Room();
		$room3
			->setName('345а')
			->setMemo('Переговорная')
			->setBuildingId($this->getReference('building3'));
		$manager->persist($room3);
		$manager->flush();		

		$this->addReference('room', $room);
		$this->addReference('room2', $room2);
		$this->addReference('room3', $room3);

	}
	public function getDependencies()
	{
	    return array(
		LoadBuilding::class,
		);
	}

}
