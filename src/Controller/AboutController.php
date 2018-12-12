<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
{

    /**
    * @Route("/about", name="about")
    */
    public function index()
    {
	return $this->render('about.html.twig');
    }

}


?>
