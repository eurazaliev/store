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
//
/**
  * Выборка случайного элемента с учетом веса
  *
  * @param array $values индексный массив элементов
  * @param array $weights индексный массив соответствующих весов  
  * @return mixed выбранный элемент  
  */ 
       private function weighted_random_simple ( $values, $weights ) 
        {
           $total = array_sum( $weights );
           $n = 0;
           $num = mt_rand( 1, $total );
           foreach ( $values as $i => $value )
                {
                         $n += $weights[$i];
                         if ( $n >= $num )
                         {
                                      return $values[$i];
                          }     
                 } 
         }


       private function createMemo($words = 3)
        {
           $minlen = 5;
           $maxlen = 10;
           $num = rand(1,$words);
           $newWord = null;
           $out = null;
           $glas = ["a","e","i","y","o","u"];
           $soglas = ["b","c","d","f","g","h","j","k","l","m","n","p","q","r","s","t","v","x","w","z"];

	   for ($j=0; $j<$num; $j++)
	   {
              $wordlen = rand(1,6);
              $newWord = null;
              for ($i=0; $i <$wordlen/2 ; $i++) { 
                        $ng = rand(0, count($glas) - 1);
                        $nsg = rand(0, count($soglas) - 1);
                        $newWord .= $glas[$ng].$soglas[$nsg];
              }
           if ($j===0) {
               $newWord = ucfirst($newWord); 
           }
           if ($words>1) {
               $newWord = ' ' . $newWord;
           }
           $out = $out .  $newWord;
           }

//     

           return($out);
        }
//

        private function createServer()
        {
                $servernames = array(
                'Srv',
                'PHP',
                'Node',
                'Ceph',
                'PgSQL',
                'Apache',
                'NGINX',
                'Server',
                'Mail',
                'Web',
                'SQL',
                'SRV',
                'KVM'
                );
                $deviders = array(
                (rand ( 1 , 127 )),
                '-',
                '.');
                $rand_names = array_rand($servernames, 2);
                $rand_deviders = array_rand($deviders);
                //
                $servername = ($servernames[$rand_names[0]] . $deviders[$rand_deviders] . $this->createMemo(1));
                $IsVm = rand(0,1);
                $memories = array (2,4,8,16,32,64,128);
                $memWeights = array(10,15,32,15,12,10,6);
                $Mem = $this->weighted_random_simple($memories, $memWeights);
                $cpus = array (1,2,4,8,16);
                $cpuWeights = array(15,30,25,20,10);
                $Cpu = $this->weighted_random_simple($cpus, $cpuWeights);
                $Hdd = rand(150,600);
                $OnOff = rand(0,1);
                $Ipaddr = (rand(2,254).".".rand(2,254).".".rand(2,254).".".rand(2,254));
                //
                $clusters = array($this->getReference('cluster'),$this->getReference('cluster2'),$this->getReference('cluster3'));
                $rand_cluster = array_rand($clusters,1);
                $ClusterID = $clusters[$rand_cluster];
                //
                $oses = array($this->getReference('os1'),$this->getReference('os2'),$this->getReference('os3'), $this->getReference('os4'), $this->getReference('os5'));
                $rand_os = array_rand($oses);
                $OSID = $oses[$rand_os];
            
                return [
                    'servername' => $servername,
	            'IsVm' => $IsVm,
	            'Mem' => $Mem,
	            'Cpu' => $Cpu,
	            'Hdd' => $Hdd,
	            'OnOff' => $OnOff,
	            'Ipaddr' => $Ipaddr,
	            'ClusterID' => $ClusterID,
	            'OSID' => $OSID
	        ];
//                return (array_rand($servernames, 1));// . array_rand($servernames, 1));// . rand ( 1 , 127 ));

        }
	public function load(ObjectManager $manager)
	{
                for ($i = 1; $i <= 50; $i++)
                {

                $server = new Server();
                $values = $this->createServer();
		$server
			->setName($values['servername'])
			->setIsVm($values['IsVm'])
			->setMem($values['Mem'])
			->setCpu($values['Cpu'])
			->setHdd($values['Hdd'])
			->setStateOnOff($values['OnOff'])
			->setIpaddr($values['Ipaddr'])
			->setMemo($this->createMemo())
			->setClusterId($values['ClusterID'])
			->setOsId($values['OSID']);
		$manager->persist($server);
                $manager->flush();
                $refname = 'server'.$i;
		$this->addReference($refname, $server);
                }
/*		
		$server2 = new Server();
                $values = $this->createServer();
		$server2
			->setName($values['servername'])
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
                $values = $this->createServer();
		$server3
			->setName($values['servername'])
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
*/
	}
	public function getDependencies()
	{
	    return array(
		LoadOS::class,
		LoadCluster::class,		
		
		);
	}

}
