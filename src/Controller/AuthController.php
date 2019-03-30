<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Server;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Doctrine\Common\Annotations\AnnotationReader;


//class AuthController extends AbstractController
class AuthController extends Controller

{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');
        
        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $em->persist($user);
        $em->flush();
        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }
    public function api(Request $request)
    {
        //return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
        $em = $this->getDoctrine()->getManager();
	$serversQuery = $em->getRepository(Server::class)->findAll();
//        foreach ($serversQuery as $server)
//        {
//            $servers[] = ['id' => $server->getId(), 'name' => $server->getName()];
//        }
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $normalizer->setCircularReferenceLimit(5);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getName();
        });
        $normalizers = array($normalizer);//new ObjectNormalizer());
        $serializer = new Serializer ($normalizers, $encoders);
        
        
        $paginator  = $this->get('knp_paginator');
        $servers = $paginator->paginate(
             $serversQuery,
             $request->query->getInt('page', 1),
             5
        );
        
        $jsonContent = $serializer->serialize($servers, 'json', ['groups' => 'forapi']);//, [
//            'circular_reference_handler' => function ($object) {
//                return $object->getId();
//            }
//        ]);
        return new Response($jsonContent);

    }
}

