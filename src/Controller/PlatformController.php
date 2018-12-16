<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Platform;
use App\Form\PlatformType;

class PlatformController extends Controller
{

    /**
    * @Route("/platform", name="platform_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$platforms = $em->getRepository(Platform::class)->findAll();
        $entity = Platform::getEntity();
	return $this->render('platform/list.html.twig', [
            'entity' => $entity,
	    'platforms' => $platforms
	]);
    }

    public function newAction()
    {
        $platform = new Platform();
        $form = $this->createForm(PlatformType::class, $platform);
        return $this->render('platform/form.html.twig', array(
            'platform' => $platform,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/platform_create", name="platform_create")
    */
    public function createAction(Request $request)
    {

        $platform  = new Platform();
        $form    = $this->createForm(PlatformType::class, $platform);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($platform);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('platform_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('platform_list'));
    }    
    /**
    * @Route("/platform_delete/{id}", name="platform_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $platform = $em->getRepository(Platform::class)->find($id);
        try {
        if ($platform) {
        $em->remove($platform);
        $em->flush();
        $message = "Deleted ". $platform->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('platform_list'));
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
    	return $this->redirect($this->generateUrl('platform_list'));
    }

    /**
     * @Route("/platform_edit/{id}", name="platform_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $platform = $em->getRepository(Platform::class)->find($id);
        if ($platform) {
        $form = $this->createForm(PlatformType::class, $platform);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($platform);
            $em->flush();
            $message = "Edited ". $platform->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('platform_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('platform/form_update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $platform->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('platform_list'));
        }
    }    
}


?>
