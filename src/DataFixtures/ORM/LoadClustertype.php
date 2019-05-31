<?php
namespace App\DataFixtures\ORM;

use App\Entity\Clustertype;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

//class Fixtures extends Fixture
class LoadClustertype extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$clustertype = new Clustertype();
		$clustertype
			->setName('BTSoft')
			->setMemo('BT sotfware cluster solution');
		$manager->persist($clustertype);
		
		$clustertype2 = new Clustertype();
		$clustertype2
			->setName('VIRT-B')
			->setMemo('Cloud virtual machines');
		$manager->persist($clustertype2);
		
		$clustertype3 = new Clustertype();
		$clustertype3
			->setName('KVM')
			->setMemo('Lunux');
		$manager->persist($clustertype3);
		$manager->flush();		

		$this->addReference('clustertype', $clustertype);
		$this->addReference('clustertype2', $clustertype2);
		$this->addReference('clustertype3', $clustertype3);

	}
}
