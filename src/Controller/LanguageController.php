<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Language;
use App\Form\LanguageType;

class LanguageController extends Controller
{

    /**
    * @Route("/language", name="language_list")
    */
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$languages = $em->getRepository(Language::class)->findAll();
	return $this->render('language/list.html.twig', [
	    'languages' => $languages
	]);
    }

    public function newAction()
    {
        $language = new Language();
        $form = $this->createForm(LanguageType::class, $language);
        return $this->render('language/form.html.twig', array(
            'language' => $language,
            'form'   => $form->createView()
        ));
    }

    /**
    * @Route("/language_create", name="language_create")
    */
    public function createAction(Request $request)
    {

        $language  = new Language();
        $form    = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

	try {
        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($language);
            $em->flush();
            $this->addFlash('success', 'Done');
            return $this->redirect($this->generateUrl('language_list'));
        }
        else {
    	    $this->addFlash('danger', "Error in form");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	$this->addFlash('danger', $e->getMessage());
	}
	return $this->redirect($this->generateUrl('language_list'));
    }    
    /**
    * @Route("/language_delete/{id}", name="language_delete")
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()
            ->getManager();
        $language = $em->getRepository(Language::class)->find($id);
        try {
        if ($language) {
        $em->remove($language);
        $em->flush();
        $message = "Deleted ". $language->getName();
        $this->addFlash('success', $message);
        return $this->redirect($this->generateUrl('language_list'));
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
    	return $this->redirect($this->generateUrl('language_list'));
    }

    /**
     * @Route("/language_edit/{id}", name="language_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $language = $em->getRepository(Language::class)->find($id);
        if ($language) {
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);
	try {
        if ($form->isSubmitted() && $form->isValid()) {

//	    $em->persist($language);
            $em->flush();
            $message = "Edited ". $language->getName();
            $this->addFlash('success', $message);

            return $this->redirectToRoute('language_list');
        }
        elseif($form->isSubmitted()<>FALSE)
        {
	    $this->addFlash('danger', "Error edit");
        }
        }
        catch (\Doctrine\DBAL\DBALException $e){
	    $this->addFlash('danger', $e->getMessage());
    	}

        return $this->render('language/form_update.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'name' => $language->getName()
        ]);
        }
        else {
	    $this->addFlash('danger', "$id not found");        
	    return $this->redirect($this->generateUrl('language_list'));
        }
    }    
}


?>
