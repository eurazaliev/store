<?php
namespace App\DataFixtures\ORM;

use App\Entity\Platform;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

//class Fixtures extends Fixture
class LoadPlatform extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$platform = new Platform();
		$platform
			->setName('x86')
			->setMemo('32 bit');
		$manager->persist($platform);
		
		$platform2 = new Platform();
		$platform2
			->setName('x64')
			->setMemo('64 bit');
		$manager->persist($platform2);
		
		$platform3 = new Platform();
		$platform3
			->setName('Beta')
			->setMemo('FGB Beta processor type');
		$manager->persist($platform3);
		$manager->flush();		

		$this->addReference('platform1', $platform);
		$this->addReference('platform2', $platform2);
		$this->addReference('platform3', $platform3);

	}
}
