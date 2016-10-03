<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Tag;
use BlogBundle\Form\TagType;
use Symfony\Component\HttpFoundation\Session\Session;

class TagController extends Controller
{
		private $session;

	public function __construct(){

		$this->session = new Session();

	} 

    public function addTagAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tags_repo = $em->getRepository("BlogBundle:Tag");
    	$form = $this->createForm(TagType::class, new Tag());
    	$form->handleRequest($request);
    	if($form->isSubmitted()){
    		if($form->isValid()){
    			$tag = $tags_repo->findOneBy(array("name"=>$form->get('name')->getData()));
    	    	if(count($tag) == 0){
    	    		 $flush = $tag_repo->SaveTag($form);
    	    		 $status = (($saved_data != null) ? "Tag no agregada" : "Tag agregada");
    	    	}else{
    	    		 $status = "Tag existente";	
    	    	}
    	     }else{
    	    	$status = "Formulario Invalido";
    	    }
			$this->session->getFlashBag()->add("session", $status);
    	    }
    	   $tags = $tags_repo->findAll();

        return $this->render('BlogBundle:BlogData:addTag.html.twig', array(
        	"tags"=> $tags,
        	"form"=>$form->createView()));
    }

    public function deleteTagAction($id){
    	$em = $this->getDoctrine()->getManager();
    	$tag_repo = $em->getRepository("BlogBundle:Tag");
    	$tag = $tag_repo->find($id);
    	if(count($tag->getentryTag())==0){
    	    $flush = $tag_repo->DeleteTag($id);
    	    $status = (($flush) ? "Tag no Elimindo" : "Tag eliminado");
    	}else{
    		$status = "Existen entradas que dependen de esta etiqueta, no se pudo eliminar";
    	    }
    	$this->session->getFlashBag()->add("session", $status);
    	return $this->redirectToRoute("addtag");
    }
}
