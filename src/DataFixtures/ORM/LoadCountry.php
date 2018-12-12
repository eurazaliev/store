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
			->setName('Россия')
			->setSactions(0)
			->setMemo('Россия, великая наша держава!');
		$manager->persist($country);
		
		$country2 = new Country();
		$country2
			->setName('Китай')
			->setSactions(0)
			->setMemo('Китайцы');
		$manager->persist($country2);
		
		$country3 = new Country();
		$country3
			->setName('Великобритания')
			->setSactions(1)
			->setMemo('Британцы ну там англичане, шотландцы ирландцы и все такие');
		$manager->persist($country3);
		$manager->flush();		

		$this->addReference('country', $country);
		$this->addReference('country2', $country2);
		$this->addReference('country3', $country3);

	}

}
