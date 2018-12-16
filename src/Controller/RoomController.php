<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Room;
use App\Form\RoomType;

class RoomController extends Controller
{

    /**
    * @Route("/room", name="room_list")
    */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
	$rooms = $em->getRepository(Room::class)->findAll();
        $entity = Room::getEntity();
	return $this->render('room/list.html.twig', [
            'entity' => $entity,
	    'rooms' => $rooms
	]);
    }

    public function newAction()
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        return $this->render('room/create.html.twig', array(
            'room' => $room,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/room_create", name="room_create")
    */
    public function createAction(Request $request)
    {

        $room  = new Room();
        $form    = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($room);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('room_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('room_list'));
    }    
    /**
    * @Route("/room_delete/{id}", name="room_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $room = $em->getRepository(Room::class)->find($id);
        try {
        if ($room) {
        $em->remove($room);
        $em->flush();
        $message = "Deleted ". $room->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('room_list'));
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
    	return $this->redirect($this->generateUrl('room_list'));
    }

    /**
     * @Route("/room_edit/{id}", name="room_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $room = $em->getRepository(Room::class)->find($id);
        if ($room) {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($room);
            $em->flush();
            $message = "Edited ". $room->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('room_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('room/update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $room->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('room_list'));
        }
    }    
}


?>
