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
			->setName('DataCenter')
			->setMemo('Main datacenter')
			->setBuildingId($this->getReference('building'));
		$manager->persist($room);
		
		$room2 = new Room();
		$room2
			->setName('Room #21')
			->setMemo('Second floor server room')
			->setBuildingId($this->getReference('building2'));
		$manager->persist($room2);
		
		$room3 = new Room();
		$room3
			->setName('B17')
			->setMemo('Secondary Datacenter')
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
