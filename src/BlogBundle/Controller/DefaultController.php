<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
	$em = $this->getDoctrine()->getManager();
	$entries_repo = $em->getRepository("BlogBundle:Entry");
	$entries = $entries_repo->findAll();
      return $this->render('BlogBundle:BlogData:MainBlog.html.twig', array("entries"=>$entries));
    }
}
