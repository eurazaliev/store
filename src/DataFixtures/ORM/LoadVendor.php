<?php
namespace App\DataFixtures\ORM;

use App\Entity\Vendor;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//class Fixtures extends Fixture
class LoadVendor extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$vendor = new Vendor();
		$vendor
			->setName('HPE')
			->setPermit(0)
			->setMemo('Hewlett Packard Ent')
			->setCountryId($this->getReference('country'));
		$manager->persist($vendor);
		
		$vendor2 = new Vendor();
		$vendor2
			->setName('Microsoft')
			->setPermit(0)
			->setMemo('MS Corp')
			->setCountryId($this->getReference('country2'));
		$manager->persist($vendor2);
		
		$vendor3 = new Vendor();
		$vendor3
			->setName('Депо')
			->setPermit(1)
			->setMemo('Депо компутерз')
			->setCountryId($this->getReference('country3'));
		$manager->persist($vendor3);
		$manager->flush();		

		$this->addReference('vendor1', $vendor);
		$this->addReference('vendor2', $vendor2);
		$this->addReference('vendor3', $vendor3);

	}
	public function getDependencies()
	{
	    return array(
		LoadCountry::class,
		);
	}

}
