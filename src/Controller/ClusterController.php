<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cluster;
use App\Form\ClusterType;

class ClusterController extends Controller
{

    /**
    * @Route("/cluster", name="cluster_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$clusters = $em->getRepository(Cluster::class)->findAll();
	$entity = Cluster::getEntity();
	return $this->render('cluster/list.html.twig', [
	    'clusters' => $clusters,
	    'entity' => $entity
	]);
    }

    public function newAction()
    {
        $cluster = new Cluster();
        $form = $this->createForm(ClusterType::class, $cluster);
        return $this->render('cluster/form.html.twig', array(
            'cluster' => $cluster,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/cluster_create", name="cluster_create")
    */
    public function createAction(Request $request)
    {

        $cluster  = new Cluster();
        $form    = $this->createForm(ClusterType::class, $cluster);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($cluster);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('cluster_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('cluster_list'));
    }    
    /**
    * @Route("/cluster_delete/{id}", name="cluster_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $cluster = $em->getRepository(Cluster::class)->find($id);
        try {
        if ($cluster) {
        $em->remove($cluster);
        $em->flush();
        $message = "Deleted ". $cluster->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('cluster_list'));
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
    	return $this->redirect($this->generateUrl('cluster_list'));
    }

    /**
     * @Route("/cluster_edit/{id}", name="cluster_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cluster = $em->getRepository(Cluster::class)->find($id);
        if ($cluster) {
        $form = $this->createForm(ClusterType::class, $cluster);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($cluster);
            $em->flush();
            $message = "Edited ". $cluster->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('cluster_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('cluster/form_update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $cluster->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('cluster_list'));
        }
    }    
}


?>
