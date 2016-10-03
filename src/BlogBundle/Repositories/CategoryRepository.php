<?php
// src/BlogBundle/Repositories/EntryRepository.php
namespace BlogBundle\Repositories;

use Doctrine\ORM\EntityRepository;
use BlogBundle\Entity\Category;

class CategoryRepository extends EntityRepository
{

	public function FindCategory($id){
		$em = $this->getEntityManager();
    	$categories_repo = $em->getRepository("BlogBundle:Category");
    	return $category = $categories_repo->find($id);
	}

	public function AllCategories(){
		$em = $this->getEntityManager();
    	$categories_repo = $em->getRepository("BlogBundle:Category");
    	return $categories = $categories_repo->findAll();
	}

    public function SaveCategory($formdata)
    {
    	$em = $this->getEntityManager();
        $category_repo = $em->getRepository("BlogBundle:Category");
        $category = new Category();
        $category->setName($formdata->get('name')->getData());
        $category->setDescription($formdata->get('description')->getData());
        $em->persist($category);
        $flush = $em->flush();
	    return $flush;
    }

    public function DeleteCategory($id){
    	$em = $this->getEntityManager();
    	$category_repo = $em->getRepository("BlogBundle:Category");
        $category = $category_repo->FindCategory($id);
    	$em->remove($category);
        $flush = $em->flush();
        return $flush;
    }

    public function updateCategory($id, $formdata){
        $em = $this->getEntityManager();
        $category_repo = $em->getRepository("BlogBundle:Category");
        $category = $category_repo->find($id);
        $category->setName($formdata->get('name')->getData());
        $category->setDescription($formdata->get('description')->getData());
        $em->persist($category);
        $flush = $em->flush();
	    return $flush;
    	}
}