<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Tag;
use BlogBundle\Form\TagType;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
		private $session;

	public function __construct(){

		$this->session = new Session();

	} 
    public function indexAction(Request $request)
    {
      return $this->render('BlogBundle:Default:layout.html.twig', array());
    }



    public function addTagAction(Request $request)
    {
    	$tag = new Tag();
    	$form = $this->createForm(TagType::class, $tag);
    	$form->handleRequest($request);
    	if($form->isSubmitted()){
    		if($form->isValid()){
    			$em = $this->getDoctrine()->getEntityManager();
    			$tag_repo = $em->getRepository("BlogBundle:Tag");
    			$tag = $tag_repo->findOneBy(array("name"=>$form->get('name')->getData()));
    	    		if(count($tag) == 0){
    	    			$tag = new Tag();
    	    		    $tag->setName($form->get('name')->getData());
    	    		    $tag->setDescription($form->get('description')->getData());
    	    		    $em = $this->getDoctrine()->getEntityManager();
    	    		    $em->persist($tag);
    	    		    $flush = $em->flush();
    	    		    	if($flush != null){
    	    		    	    $status = "Tag no agregada";
    	    		    	 }else{
    	    		    	    $status = "Tag agregada";
    	    		    	    	}
    	    		 }else{
    	    		    $status = "Tag existente";	
    	    		    }
    	     }else{
    	    	$status = "Formulario Invalido";
    	    }
			$this->session->getFlashBag()->add("session", $status);
    	    }

   		$em = $this->getDoctrine()->getEntityManager();
    	$tags_repo = $em->getRepository("BlogBundle:Tag");
    	$tags = $tags_repo->findAll();

        return $this->render('BlogBundle:BlogData:addTag.html.twig', array(
        	"tags"=> $tags,
        	"form"=>$form->createView()
        	));
    }
}
