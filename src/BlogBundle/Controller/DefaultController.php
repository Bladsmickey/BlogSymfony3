<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Tag;
use BlogBundle\Form\TagType;
use BlogBundle\Entity\Category;
use BlogBundle\Form\CategoryType;
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

    public function deleteTagAction($id){
    	$em = $this->getDoctrine()->getEntityManager();
    	$tag_repo = $em->getRepository("BlogBundle:Tag");
    	$tag = $tag_repo->find($id);
    	if(count($tag->getentryTag())==0){
    		$em->remove($tag);
    	    $flush = $em->flush();
    	    $status = (($flush) ? "Tag no Elimindo" : "Tag eliminado");
    	}else{
    			$status = "Existen entradas que dependen de esta etiqueta, no se pudo eliminar";
    	    	}
    	$this->session->getFlashBag()->add("session", $status);
    	return $this->redirectToRoute("addtag");
    }

    /* Inicio controlador de categorias*/


    public function addCategoryAction(Request $request)
    {
    	$category = new Category();
    	$form = $this->createForm(CategoryType::class, $category);
    	$form->handleRequest($request);
    	if($form->isSubmitted()){
    		if($form->isValid()){
    			$em = $this->getDoctrine()->getEntityManager();
    			$category_repo = $em->getRepository("BlogBundle:Category");
    			$category = $category_repo->findOneBy(array("name"=>$form->get('name')->getData()));
    	    		if(count($category) == 0){
    	    			$category = new Category();
    	    		    $category->setName($form->get('name')->getData());
    	    		    $category->setDescription($form->get('description')->getData());
    	    		    $em = $this->getDoctrine()->getEntityManager();
    	    		    $em->persist($category);
    	    		    $flush = $em->flush();
    	    		    	if($flush != null){
    	    		    	    $status = "Categoria no agregada";
    	    		    	 }else{
    	    		    	    $status = "Categoria agregada";
    	    		    	    	}
    	    		 }else{
    	    		    $status = "Categoria existente";	
    	    		    }
    	     }else{
    	    	$status = "Formulario Invalido";
    	    }
			$this->session->getFlashBag()->add("session", $status);
    	    }

   		$em = $this->getDoctrine()->getEntityManager();
    	$categories_repo = $em->getRepository("BlogBundle:Category");
    	$categories = $categories_repo->findAll();

        return $this->render('BlogBundle:BlogData:addCategory.html.twig', array(
        	"categories"=> $categories,
        	"form"=>$form->createView()
        	));
    }

    public function deleteCategoryAction($id){
    	$em = $this->getDoctrine()->getEntityManager();
    	$category_repo = $em->getRepository("BlogBundle:Category");
    	$category = $category_repo->find($id);
    	if(count($category->getEntries())==0){
    		$em->remove($category);
    	    $flush = $em->flush();
    	    $status = (($flush) ? "Categoria no Eliminada" : "Categoria eliminada");
    	}else{
    			$status = "Existen entradas que dependen de esta categoria, no se pudo eliminar";
    	    	}
    	$this->session->getFlashBag()->add("session", $status);
    	return $this->redirectToRoute("addcategory");
    }
}
