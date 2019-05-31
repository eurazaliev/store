<?php
namespace App\DataFixtures\ORM;

use App\Entity\Language;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

//class Fixtures extends Fixture
class LoadLanguage extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$language = new Language();
		$language
			->setName('FIN')
			->setMemo('Finnish');
		$manager->persist($language);
		
		$language2 = new Language();
		$language2
			->setName('ENG')
			->setMemo('English');
		$manager->persist($language2);
		
		$language3 = new Language();
		$language3
			->setName('CN')
			->setMemo('China');
		$manager->persist($language3);
		$manager->flush();		

		$this->addReference('language', $language);
		$this->addReference('language2', $language2);
		$this->addReference('language3', $language3);

	}
	public function getDependencies()
	{
	    return array(
		LoadCountry::class,
		);
	}

}
