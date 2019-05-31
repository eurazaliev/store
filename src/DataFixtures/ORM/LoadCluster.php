<?php
namespace App\DataFixtures\ORM;

use App\Entity\Cluster;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//class Fixtures extends Fixture
class LoadCluster extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$cluster = new Cluster();
		$cluster
			->setName('HA')
			->setMemo('High Available Cluster')
			->setProjectId($this->getReference('project'))
			->setClustertypeId($this->getReference('clustertype'));
		$manager->persist($cluster);
		
		$cluster2 = new Cluster();
		$cluster2
			->setName('TEST')
			->setMemo('Test cluster')
			->setProjectId($this->getReference('project2'))
			->setClustertypeId($this->getReference('clustertype2'));
		$manager->persist($cluster2);
		
		$cluster3 = new Cluster();
		$cluster3
			->setName('Secondary')
			->setMemo('Disaster recover cluster')
			->setProjectId($this->getReference('project3'))
			->setClustertypeId($this->getReference('clustertype3'));

		$manager->persist($cluster3);
		$manager->flush();		

		$this->addReference('cluster', $cluster);
		$this->addReference('cluster2', $cluster2);
		$this->addReference('cluster3', $cluster3);

	}
	public function getDependencies()
	{
	    return array(
		LoadProject::class,
		LoadClustertype::class,
		);
	}

}
