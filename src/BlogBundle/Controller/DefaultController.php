<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        /*$em = $this->getDoctrine()->getEntityManager();
        $entry_repo = $em->getRepository("BlogBundle:Entry");
        $entries = $entry_repo->findAll();

        foreach ($entries as $entry) {
            echo "Titulo: ".$entry->getTitle()."<br/>";
            echo "Categoria: ".$entry->getCategory()->getName()."<br/>";
            echo "Creado por: ".$entry->getUser()->getName()."<br/>";
             $tags = $entry->getEntryTag();
             echo "Tags: ";
             foreach ($tags as $tag) {
                 echo $tag->getTag()->getName().", ";
             }
            echo "<hr/>";
        }
        die();*/

        $em = $this->getDoctrine()->getEntityManager();
        $tag_repo = $em->getRepository("BlogBundle:Tag");
        $tags = $tag_repo->findAll();

        foreach ($tags as $tag) {
            echo "Tag: ".$tag->getName()."<br/>";
             $entrytags = $tag->getEntryTag();
             foreach ($entrytags as $entry) {
                 echo $entry->getEntry()->getTitle().", ";
             }
            echo "<hr/>";
        }
        die();

        return null;
    }
}
