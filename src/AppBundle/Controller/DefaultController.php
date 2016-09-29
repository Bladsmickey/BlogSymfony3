<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getEntityManager();
        $entry_repo = $em->getRepository("BlogBundle:Entry");
        $entries = $entry_repo->findAll();

        foreach ($entries as $entry) {
            echo $entry->getTitle()."</br>";
            echo $entry->getCategory()->getName()."</br>";
            echo $entry->getUser()->getName()."</br>";
            $tags = $entry->getEntryTag();
            foreach ($tags as $tag) {
                echo $tag->getTag()->getName().", ";
            }
            echo "</hr>";
        }
        die();
    }
}
