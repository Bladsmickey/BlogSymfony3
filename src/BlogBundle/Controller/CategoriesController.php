<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Category;
use BlogBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CategoriesController extends Controller {
	private $session;

	public function __construct() {

		$this->session = new Session();

	}

	public function indexCategoryAction($category, $page) {

		$em = $this->getDoctrine()->getManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		$categories_repo = $em->getRepository("BlogBundle:Category");
		//$entries = $entries_repo->AllEntries();
		$pageSize = 2;
		$entries = $entries_repo->PaginateEntriesCategories($category, $pageSize, $page);
		$totalItems = count($entries);
		$pagecount = ceil($totalItems / $pageSize);
		$categories = $categories_repo->AllCategories();
		return $this->render('BlogBundle:BlogData:MainBlog.html.twig', array(
			'entries' => $entries,
			'categories' => $categories,
			'totalitems' => $totalItems,
			'pagecount' => $pagecount,
			'page' => $page));

	}

	/* Inicio controlador de categorias*/
	public function addCategoryAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		$category_repo = $em->getRepository("BlogBundle:Category");
		$category = new Category();
		$form = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				$category = $category_repo->findOneBy(array("name" => $form->get('name')->getData()));
				if (count($category) == 0) {
					$flush = $category_repo->SaveCategory($form);
					$status = (($flush) ? "Categoria no creada" : "Categoria Creada");
				} else {
					$status = "Categoria existente";
				}
			} else {
				$status = "Formulario Invalido";
			}
			$this->session->getFlashBag()->add("session", $status);
		}

		$categories = $category_repo->AllCategories();
		return $this->render('BlogBundle:BlogData:addCategory.html.twig', array(
			"categories" => $categories,
			"form" => $form->createView(),
		));
	}

	public function deleteCategoryAction($id) {
		$em = $this->getDoctrine()->getManager();
		$category_repo = $em->getRepository("BlogBundle:Category");
		$category = $category_repo->FindCategory($id);
		if (count($category->getEntries()) == 0) {
			$flush = $category_repo->DeleteCategory($id);
			$status = (($flush) ? "Categoria no Eliminada" : "Categoria eliminada");
		} else {
			$status = "Existen entradas que dependen de esta categoria, no se pudo eliminar";
		}
		$this->session->getFlashBag()->add("session", $status);
		return $this->redirectToRoute("addcategory");
	}

	public function editCategoryAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$category_repo = $em->getRepository("BlogBundle:Category");
		$category = $category_repo->FindCategory($id);
		$form = $this->createForm(CategoryType::class, $category);
		/*Handle del request*/
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				$flush = $category_repo->updateCategory($id, $form);
				$status = (($flush) ? "Categoria no actualizada" : "Categoria actualizada");
			} else {
				$status = "Formulario Invalido";
			}
			$this->session->getFlashBag()->add("session", $status);
		}

		/* Fin del handle */
		$categories = $category_repo->AllCategories();
		return $this->render('BlogBundle:BlogData:addCategory.html.twig', array(
			"form" => $form->createView(),
			"categories" => $categories,
		));
	}
}
