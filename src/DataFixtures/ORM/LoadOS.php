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
			->setPlatformID($this->getReference('platform1'))
			->setVendorID($this->getReference('vendor1'))
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

		$os4 = new Os();
		$os4
			->setName('Linux Centos')
			->setVersion('7.2')
			->setPlatformID($this->getReference('platform3'))
			->setVendorID($this->getReference('vendor1'))
			->setLanguageID($this->getReference('language2'))
			->setMemo('');
		$manager->persist($os4);

		$os5 = new Os();
		$os5
			->setName('Windows server')
			->setVersion('2012 R2')
			->setPlatformID($this->getReference('platform1'))
			->setVendorID($this->getReference('vendor2'))
			->setLanguageID($this->getReference('language3'))
			->setMemo('');
		$manager->persist($os5);


		$manager->flush();		

		$this->addReference('os1', $os);
		$this->addReference('os2', $os2);
		$this->addReference('os3', $os3);
		$this->addReference('os4', $os4);
		$this->addReference('os5', $os5);

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
