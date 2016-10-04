<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Entry;
use BlogBundle\Form\EntryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class EntriesController extends Controller {
	private $session;

	public function __construct() {

		$this->session = new Session();

	}
	public function indexAction($page) {
		$em = $this->getDoctrine()->getManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		$entries = $entries_repo->PaginateEntries(2, $page);
		dump($entries);die();
		return $this->render('BlogBundle:BlogData:MainBlog.html.twig', array("entries" => $entries));
	}

	public function addEntryAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		$entry = new Entry();
		$form = $this->createForm(EntryType::class, $entry);
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				$saved_data = $entries_repo->SaveEntry($form, $this->getUser());
				$status = (($saved_data != null) ? "Entrada no agregada" : "Entrada agregada");
			} else {
				$status = "Formulario Invalido";
			}
			$this->session->getFlashBag()->add("session", $status);
		}
		$entries = $entries_repo->AllEntries();
		return $this->render('BlogBundle:BlogData:addEntry.html.twig', array(
			"entries" => $entries,
			"form" => $form->createView(),
		));
	}

	public function deleteEntryAction($id) {
		$em = $this->getDoctrine()->getManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		$flush = $entries_repo->DeleteEntry($form, $this->getUser());
		$status = (($flush) ? "Entrada no Eliminda" : "Entrada eliminada");
		$this->session->getFlashBag()->add("session", $status);
		return $this->redirectToRoute("addentry");
	}

	public function editEntryAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		$entry = $entries_repo->findEntry($id);
		$form = $this->createForm(EntryType::class, $entry);
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				$flush = $entries_repo->updateEntry($id, $form, $this->getUser());
				$status = (($flush) ? "Entrada no Actualizada" : "Entrada Actualizada");
			} else {
				$status = "Formulario Invalido";
			}
			$this->session->getFlashBag()->add("session", $status);
		}
		$entries = $entries_repo->AllEntries();
		return $this->render('BlogBundle:BlogData:addEntry.html.twig', array(
			"entries" => $entries,
			"form" => $form->createView(),
		));
	}
}
