<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
	public function indexAction($page) {
		$em = $this->getDoctrine()->getManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		$categories_repo = $em->getRepository("BlogBundle:Category");
		//$entries = $entries_repo->AllEntries();
		$pageSize = 2;
		$entries = $entries_repo->PaginateEntries($pageSize, $page);
		$totalItems = count($entries);
		$pagecount = ceil($totalItems / $pageSize);
		$categories = $categories_repo->AllCategories();
		return $this->render('BlogBundle:BlogData:MainBlog.html.twig', array("entries" => $entries,
			'categories' => $categories,
			'totalitems' => $totalItems,
			'pagecount' => $pagecount,
			'page' => $page));
	}

	public function langAction(Request $request) {

		return $this->redirectToRoute("blog_homepage");
	}
}
