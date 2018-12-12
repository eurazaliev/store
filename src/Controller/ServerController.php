<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Server;
use App\Form\ServerType;

class ServerController extends Controller
{

    /**
    * @Route("/server", name="server_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$servers = $em->getRepository(Server::class)->findAll();
	return $this->render('server/list.html.twig', [
	    'servers' => $servers
	]);
    }

    public function newAction()
    {
        $server = new Server();
        $form = $this->createForm(ServerType::class, $server);
        return $this->render('server/form.html.twig', array(
            'server' => $server,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/server_create", name="server_create")
    */
    public function createAction(Request $request)
    {

        $server  = new Server();
        $form    = $this->createForm(ServerType::class, $server);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($server);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('server_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('server_list'));
    }    
    /**
    * @Route("/server_delete/{id}", name="server_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $server = $em->getRepository(Server::class)->find($id);
        try {
        if ($server) {
        $em->remove($server);
        $em->flush();
        $message = "Deleted ". $server->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('server_list'));
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
    	return $this->redirect($this->generateUrl('server_list'));
    }

    /**
     * @Route("/server_edit/{id}", name="server_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $server = $em->getRepository(Server::class)->find($id);
        if ($server) {
        $form = $this->createForm(ServerType::class, $server);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($server);
            $em->flush();
            $message = "Edited ". $server->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('server_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('server/form_update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $server->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('server_list'));
        }
    }    
}


?>