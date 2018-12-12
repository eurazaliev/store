<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Vendor;
use App\Form\VendorType;

class VendorController extends Controller
{

    /**
    * @Route("/vendor", name="vendor_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$vendors = $em->getRepository(Vendor::class)->findAll();
	return $this->render('vendor/list.html.twig', [
	    'vendors' => $vendors
	]);
    }

    public function newAction()
    {
        $vendor = new Vendor();
        $form = $this->createForm(VendorType::class, $vendor);
        return $this->render('vendor/form.html.twig', array(
            'vendor' => $vendor,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/vendor_create", name="vendor_create")
    */
    public function createAction(Request $request)
    {

        $vendor  = new Vendor();
        $form    = $this->createForm(VendorType::class, $vendor);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($vendor);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('vendor_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('vendor_list'));
    }    
    /**
    * @Route("/vendor_delete/{id}", name="vendor_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $vendor = $em->getRepository(Vendor::class)->find($id);
        try {
        if ($vendor) {
        $em->remove($vendor);
        $em->flush();
        $message = "Deleted ". $vendor->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('vendor_list'));
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
    	return $this->redirect($this->generateUrl('vendor_list'));
    }

    /**
     * @Route("/vendor_edit/{id}", name="vendor_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $vendor = $em->getRepository(Vendor::class)->find($id);
        if ($vendor) {
        $form = $this->createForm(VendorType::class, $vendor);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($vendor);
            $em->flush();
            $message = "Edited ". $vendor->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('vendor_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('vendor/form_update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $vendor->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('vendor_list'));
        }
    }    
}


?>
