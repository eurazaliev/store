<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Form\ProjectType;

class ProjectController extends Controller
{

    /**
    * @Route("/project", name="project_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$projects = $em->getRepository(Project::class)->findAll();
	return $this->render('project/list.html.twig', [
	    'projects' => $projects
	]);
    }

    public function newAction()
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        return $this->render('project/form.html.twig', array(
            'project' => $project,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/project_create", name="project_create")
    */
    public function createAction(Request $request)
    {

        $project  = new Project();
        $form    = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($project);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('project_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('project_list'));
    }    
    /**
    * @Route("/project_delete/{id}", name="project_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $project = $em->getRepository(Project::class)->find($id);
        try {
        if ($project) {
        $em->remove($project);
        $em->flush();
        $message = "Deleted ". $project->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('project_list'));
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
    	return $this->redirect($this->generateUrl('project_list'));
    }

    /**
     * @Route("/project_edit/{id}", name="project_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Project::class)->find($id);
        if ($project) {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($project);
            $em->flush();
            $message = "Edited ". $project->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('project_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('project/form_update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $project->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('project_list'));
        }
    }    
}


?>
