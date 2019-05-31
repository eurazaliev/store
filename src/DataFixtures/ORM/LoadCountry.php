<?php
namespace App\DataFixtures\ORM;

use App\Entity\Country;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

//class Fixtures extends Fixture
class LoadCountry extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$country = new Country();
		$country
			->setName('Finland')
			->setSactions(0)
			->setMemo('FIN');
		$manager->persist($country);
		
		$country2 = new Country();
		$country2
			->setName('China')
			->setSactions(0)
			->setMemo('C');
		$manager->persist($country2);
		
		$country3 = new Country();
		$country3
			->setName('GER')
			->setSactions(1)
			->setMemo('Germany');
		$manager->persist($country3);
		$manager->flush();		

		$this->addReference('country', $country);
		$this->addReference('country2', $country2);
		$this->addReference('country3', $country3);

	}

}
