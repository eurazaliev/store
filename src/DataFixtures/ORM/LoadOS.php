<?php
namespace App\DataFixtures\ORM;

use App\Entity\Os;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

//class Fixtures extends Fixture
class LoadOS extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$os = new Os();
		$os
			->setName('HP UX')
			->setVersion('11.1')
			->setPlatformID($this->getReference('platform'))
			->setVendorID($this->getReference('vendor'))
			->setLanguageID($this->getReference('language'))
			->setMemo('');
		$manager->persist($os);
		
		$os2 = new Os();
		$os2
			->setName('Windows Server')
			->setVersion('2016')
			->setPlatformID($this->getReference('platform2'))
			->setVendorID($this->getReference('vendor2'))
			->setLanguageID($this->getReference('language2'))
			->setMemo('');
		$manager->persist($os2);
		
		$os3 = new Os();
		$os3
			->setName('ROSA ENTERPRISE LINUX SERVER')
			->setVersion('7')
			->setPlatformID($this->getReference('platform3'))
			->setVendorID($this->getReference('vendor3'))
			->setLanguageID($this->getReference('language3'))
			->setMemo('');
		$manager->persist($os3);
		$manager->flush();		

		$this->addReference('os', $os);
		$this->addReference('os2', $os2);
		$this->addReference('os3', $os3);

	}
	public function getDependencies()
	{
	    return array(
		LoadPlatform::class,
		LoadLanguage::class,
		LoadVendor::class,
	);
	}

}
