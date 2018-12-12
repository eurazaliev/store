<?php
namespace App\DataFixtures\ORM;

use App\Entity\Server;
//use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//class Fixtures extends Fixture
class LoadServer extends Fixture implements DependentFixtureInterface
{
	public function __construct() 
	{
	echo "Loading ...";
	}
	public function load(ObjectManager $manager)
	{
		$server = new Server();
		$server
			->setName('Contoso-01')
			->setIsVm(0)
			->setMem(2)
			->setCpu(4)
			->setHdd(54)
			->setStateOnOff(1)
			->setIpaddr('89.22.53.4')
			->setMemo('Site 1 main server')
			->setClusterId($this->getReference('cluster'))
			->setOsId($this->getReference('os'));
		$manager->persist($server);
		
		$server2 = new Server();
		$server2
			->setName('Acme.clouds')
			->setIsVm(1)
			->setMem(4)
			->setCpu(2)
			->setHdd(154)
			->setStateOnOff(1)
			->setIpaddr('94.22.353.24')
			->setMemo('Site 2 server')
			->setClusterId($this->getReference('cluster2'))
			->setOsId($this->getReference('os2'));

		$manager->persist($server2);
		
		$server3 = new Server();
		$server3
			->setName('mailserver')
			->setIsVm(1)
			->setMem(8)
			->setCpu(6)
			->setHdd(1254)
			->setStateOnOff(1)
			->setIpaddr('189.222.153.44')
			->setMemo('No shutdown')
			->setClusterId($this->getReference('cluster3'))
			->setOsId($this->getReference('os3'));

		$manager->persist($server3);
		$manager->flush();		

		$this->addReference('server', $server);
		$this->addReference('server2', $server2);
		$this->addReference('server3', $server3);

	}
	public function getDependencies()
	{
	    return array(
		LoadOS::class,
		LoadCluster::class,		
		
		);
	}

}
