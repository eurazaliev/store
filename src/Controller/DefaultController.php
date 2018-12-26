<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Server;

use Ob\HighchartsBundle\Highcharts\Highchart;


class DefaultController extends AbstractController
{

    /**
    * @Route("/", name="home")
    */
    public function index()
    {
        $countServers = $this->getDoctrine()->getRepository(Server::class)->findCount(); 
        $memoriesValues = $this->getDoctrine()->getRepository(Server::class)->findDistinctValuesInField('mem');
        $mems = array();
        $memorySize = null;
        foreach ($memoriesValues as $memorySize)
        {
            $mS = $memorySize[1];
            $mems[] = array (($mS . "Gb"), round((($this->getDoctrine()->getRepository(Server::class)->findCountFields('mem',$mS)))/$countServers*100));
        }
        //готовим график CPU
        $cpusValues = $this->getDoctrine()->getRepository(Server::class)->findDistinctValuesInField('cpu');
        $cpus = array();
        $cpuSize = null;
        foreach ($cpusValues as $cpuSize)
        {
            $cores = $cpuSize[1];
            $cpus[] = array (("Ядер " . $cores), round((($this->getDoctrine()->getRepository(Server::class)->findCountFields('cpu',$cores)))/$countServers*100));
        }
       //данные получены

        return $this->render('index.html.twig', [
            'mems' => $mems,
            'chart' => $this->drawPie ($mems, '% серверов','Распределение серверов в разрезе установленной памяти', 'memchart'),
            'chart1' => $this->drawPie ($cpus, '% серверов','Распределение серверов в разрезе ядер процессора', 'cpuchart'),            
        ]);
    }
    private function drawPie ($data, $name, $title, $chartname)
    {
        $ob = new Highchart();
//        $ob->chart->renderTo('piechart');
        $ob->chart->renderTo($chartname);
        $ob->title->text($title);
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
/*        $data = array(
            array('Firefox', 45.0),
            array('IE', 26.8),
            array('Chrome', 12.8),
            array('Safari', 8.5),
            array('Opera', 6.2),
            array('Others', 0.7),
        );
*/
    return $ob->series(array(array('type' => 'pie','name' => $name, 'data' => $data)));    
    }


}


?>
