<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Building;
use App\Form\BuildingType;

class BuildingController extends Controller
{

    /**
    * @Route("/building", name="building_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$buildings = $em->getRepository(Building::class)->findAll();
        $entity = Building::getEntity();
	                    
	return $this->render('building/list.html.twig', [
            'entity' => $entity,
	    'buildings' => $buildings
	]);
    }

    public function newAction()
    {
        $building = new Building();
        $form = $this->createForm(BuildingType::class, $building);
        return $this->render('building/create.html.twig', array(
            'building' => $building,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/building_create", name="building_create")
    */
    public function createAction(Request $request)
    {

        $building  = new Building();
        $form    = $this->createForm(BuildingType::class, $building);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($building);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('building_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('building_list'));
    }    
    /**
    * @Route("/building_delete/{id}", name="building_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $building = $em->getRepository(Building::class)->find($id);
        try {
        if ($building) {
        $em->remove($building);
        $em->flush();
        $message = "Deleted ". $building->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('building_list'));
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
    	return $this->redirect($this->generateUrl('building_list'));
    }

    /**
     * @Route("/building_edit/{id}", name="building_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $building = $em->getRepository(Building::class)->find($id);
        if ($building) {
        $form = $this->createForm(BuildingType::class, $building);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($building);
            $em->flush();
            $message = "Edited ". $building->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('building_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('building/update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $building->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('building_list'));
        }
    }    
}


?>
