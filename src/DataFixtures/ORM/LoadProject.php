<?php
namespace App\DataFixtures\ORM;

use App\Entity\Project;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

//class Fixtures extends Fixture
class LoadProject extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$project = new Project();
		$project
			->setName('Billing2')
			->setMemo('New billing system development');
		$manager->persist($project);
		
		$project2 = new Project();
		$project2
			->setName('VIRT')
			->setMemo('Virtualization platform version 3.1');
		$manager->persist($project2);
		
		$project3 = new Project();
		$project3
			->setName('HA')
			->setMemo('High Available software cluster');
		$manager->persist($project3);
		$manager->flush();		

		$this->addReference('project', $project);
		$this->addReference('project2', $project2);
		$this->addReference('project3', $project3);

	}
}
