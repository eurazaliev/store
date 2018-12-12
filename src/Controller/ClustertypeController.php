<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Clustertype;
use App\Form\ClustertypeType;

class ClustertypeController extends Controller
{

    /**
    * @Route("/clustertype", name="clustertype_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$clustertypes = $em->getRepository(Clustertype::class)->findAll();
	return $this->render('clustertype/list.html.twig', [
	    'clustertypes' => $clustertypes
	]);
    }

    public function newAction()
    {
        $clustertype = new Clustertype();
        $form = $this->createForm(ClustertypeType::class, $clustertype);
        return $this->render('clustertype/form.html.twig', array(
            'clustertype' => $clustertype,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/clustertype_create", name="clustertype_create")
    */
    public function createAction(Request $request)
    {

        $clustertype  = new Clustertype();
        $form    = $this->createForm(ClustertypeType::class, $clustertype);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($clustertype);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('clustertype_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('clustertype_list'));
    }    
    /**
    * @Route("/clustertype_delete/{id}", name="clustertype_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $clustertype = $em->getRepository(Clustertype::class)->find($id);
        try {
        if ($clustertype) {
        $em->remove($clustertype);
        $em->flush();
        $message = "Deleted ". $clustertype->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('clustertype_list'));
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
    	return $this->redirect($this->generateUrl('clustertype_list'));
    }

    /**
     * @Route("/clustertype_edit/{id}", name="clustertype_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $clustertype = $em->getRepository(Clustertype::class)->find($id);
        if ($clustertype) {
        $form = $this->createForm(ClustertypeType::class, $clustertype);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($clustertype);
            $em->flush();
            $message = "Edited ". $clustertype->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('clustertype_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('clustertype/form_update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $clustertype->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('clustertype_list'));
        }
    }    
}


?>
