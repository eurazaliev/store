<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\OS;
use App\Form\OSType;

class OSController extends Controller
{

    /**
    * @Route("/os", name="os_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$oss = $em->getRepository(OS::class)->findAll();
        $entity = OS::getEntity();
	return $this->render('os/list.html.twig', [
            'entity' => $entity,
	    'oss' => $oss
	]);
    }

    public function newAction()
    {
        $os = new OS();
        $form = $this->createForm(OSType::class, $os);
        return $this->render('os/form.html.twig', array(
            'os' => $os,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/os_create", name="os_create")
    */
    public function createAction(Request $request)
    {

        $os  = new OS();
        $form    = $this->createForm(OSType::class, $os);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($os);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('os_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('os_list'));
    }    
    /**
    * @Route("/os_delete/{id}", name="os_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $os = $em->getRepository(OS::class)->find($id);
        try {
        if ($os) {
        $em->remove($os);
        $em->flush();
        $message = "Deleted ". $os->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('os_list'));
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
    	return $this->redirect($this->generateUrl('os_list'));
    }

    /**
     * @Route("/os_edit/{id}", name="os_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $os = $em->getRepository(OS::class)->find($id);
        if ($os) {
        $form = $this->createForm(OSType::class, $os);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($os);
            $em->flush();
            $message = "Edited ". $os->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('os_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('os/form_update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $os->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('os_list'));
        }
    }    
}


?>
