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
use BlogBundle\Entity\Entry;
use BlogBundle\Form\EntryType;

class DefaultController extends Controller
{
		private $session;

	public function __construct(){

		$this->session = new Session();

	} 
    public function indexAction(Request $request)
    {
	$em = $this->getDoctrine()->getManager();
	$entries_repo = $em->getRepository("BlogBundle:Entry");
	$entries = $entries_repo->findAll();
      return $this->render('BlogBundle:BlogData:MainBlog.html.twig', array());
    }



    public function addTagAction(Request $request)
    {
    	$tag = new Tag();
    	$form = $this->createForm(TagType::class, $tag);
    	$form->handleRequest($request);
    	if($form->isSubmitted()){
    		if($form->isValid()){
    			$em = $this->getDoctrine()->getManager();
    			$tag_repo = $em->getRepository("BlogBundle:Tag");
    			$tag = $tag_repo->findOneBy(array("name"=>$form->get('name')->getData()));
    	    		if(count($tag) == 0){
    	    			$tag = new Tag();
    	    		    $tag->setName($form->get('name')->getData());
    	    		    $tag->setDescription($form->get('description')->getData());
    	    		    $em = $this->getDoctrine()->getManager();
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

   		$em = $this->getDoctrine()->getManager();
    	$tags_repo = $em->getRepository("BlogBundle:Tag");
    	$tags = $tags_repo->findAll();

        return $this->render('BlogBundle:BlogData:addTag.html.twig', array(
        	"tags"=> $tags,
        	"form"=>$form->createView()
        	));
    }

    public function deleteTagAction($id){
    	$em = $this->getDoctrine()->getManager();
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
    			$em = $this->getDoctrine()->getManager();
    			$category_repo = $em->getRepository("BlogBundle:Category");
    			$category = $category_repo->findOneBy(array("name"=>$form->get('name')->getData()));
    	    		if(count($category) == 0){
    	    			$category = new Category();
    	    		    $category->setName($form->get('name')->getData());
    	    		    $category->setDescription($form->get('description')->getData());
    	    		    $em = $this->getDoctrine()->getManager();
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

   		$em = $this->getDoctrine()->getManager();
    	$categories_repo = $em->getRepository("BlogBundle:Category");
    	$categories = $categories_repo->findAll();

        return $this->render('BlogBundle:BlogData:addCategory.html.twig', array(
        	"categories"=> $categories,
        	"form"=>$form->createView()
        	));
    }

    public function deleteCategoryAction($id){
    	$em = $this->getDoctrine()->getManager();
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

        public function editCategoryAction(Request $request, $id){
    	$em = $this->getDoctrine()->getManager();
    	$category_repo = $em->getRepository("BlogBundle:Category");
    	$category = $category_repo->find($id);
    	$form = $this->createForm(CategoryType::class, $category);
    	 $form->handleRequest($request);
    	if($form->isSubmitted()){
    		if($form->isValid()){
    		    $category->setName($form->get('name')->getData());
    		    $category->setDescription($form->get('description')->getData());
    		    $em = $this->getDoctrine()->getManager();
    		    $em->persist($category);
    		    $flush = $em->flush();
    		    $status = (($flush) ? "Categoria no actualizada" : "Categoria actualizada");
    	    	
    	     }else{
    	    	$status = "Formulario Invalido";
    	    }
			$this->session->getFlashBag()->add("session", $status);
    	    }

    	$em = $this->getDoctrine()->getManager();
    	$categories_repo = $em->getRepository("BlogBundle:Category");
    	$categories = $categories_repo->findAll();

    	return $this->render('BlogBundle:BlogData:addCategory.html.twig', array(
    		"form" => $form->createView(),
    		"categories" => $categories,
    		));
    }

        public function addEntryAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entries_repo = $em->getRepository("BlogBundle:Entry");
    	$entry = new Entry();
    	$form = $this->createForm(EntryType::class, $entry);
    	$form->handleRequest($request);
    	if($form->isSubmitted()){
    		if($form->isValid()){
    			$saved_data = $entries_repo->SaveEntry($form, $this->getUser());

    			$status = (($saved_data != null) ? "Entrada no agregada" : "Entrada agregada");
    	     }else{
    	    	$status = "Formulario Invalido";
    	    }
			$this->session->getFlashBag()->add("session", $status);
    	    }
    	$entries = $entries_repo->findAll();
        return $this->render('BlogBundle:BlogData:addEntry.html.twig', array(
        	"entries"=> $entries,
        	"form"=>$form->createView()
        	));
    }

    public function deleteEntryAction($id){
    	$em = $this->getDoctrine()->getManager();
    	$entries_repo = $em->getRepository("BlogBundle:Entry");
    	$flush = $entries_repo->DeleteEntry($form, $this->getUser());
    	$status = (($flush) ? "Entrada no Eliminda" : "Entrada eliminada");
    	$this->session->getFlashBag()->add("session", $status);
    	return $this->redirectToRoute("addentry");
    }

    public function editEntryAction(Request $request, $id){
    	$em = $this->getDoctrine()->getManager();
    	$entries_repo = $em->getRepository("BlogBundle:Entry");
    	$entry = $entries_repo->findEntry($id);
    	$form = $this->createForm(EntryType::class, $entry);
    	$form->handleRequest($request);
    	if($form->isSubmitted()){
    		if($form->isValid()){ 
    			$flush = $entries_repo->updateEntry($id, $form, $this->getUser());
    			$status = (($flush) ? "Entrada no Actualizada" : "Entrada Actualizada");
    		}else{
    			$status = "Formulario Invalido";
    		}
    		$this->session->getFlashBag()->add("session", $status);
    	}
    	$entries = $entries_repo->findAll();
        return $this->render('BlogBundle:BlogData:addEntry.html.twig', array(
        	"entries"=> $entries,
        	"form"=>$form->createView()
        	));
    }
}
