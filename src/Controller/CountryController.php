<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Country;
use App\Form\CountryType;

class CountryController extends Controller
{

    /**
    * @Route("/country", name="country_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$countries = $em->getRepository(Country::class)->findAll();
	return $this->render('country/country_list.html.twig', [
	    'countries' => $countries
	]);
    }

    public function newAction()
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        return $this->render('country/form.html.twig', array(
            'country' => $country,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/country_create", name="country_create")
    */
    public function createAction(Request $request)
    {

        $country  = new Country();
        $form    = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($country);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('country_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('country_list'));
    }    
    /**
    * @Route("/country_delete/{id}", name="country_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $country = $em->getRepository(Country::class)->find($id);
        try {
        if ($country) {
        $em->remove($country);
        $em->flush();
        $message = "Deleted ". $country->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('country_list'));
        }
        else {
	    $this->addFlash('danger', "$id not found");
        
        }
        }
	catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}
    	catch (\Doctrine\ORM\ORMException $e) {
	    $this->addFlash('danger', $e->getMessage());
    	}
    	return $this->redirect($this->generateUrl('country_list'));
    }

    /**
     * @Route("/country_edit/{id}", name="country_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $country = $em->getRepository(Country::class)->find($id);
        if ($country) {
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($country);
            $em->flush();
            $message = "Edited ". $country->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('country_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('country/form_update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $country->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('country_list'));
        }
    }    
}


?>
