<?php
// src/BlogBundle/Repositories/TagRepository.php
namespace BlogBundle\Repositories;

use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository {

	public function FindTag($id) {
		$em = $this->getEntityManager();
		$tag_repo = $em->getRepository("BlogBundle:Tag");
		return $tag = $tag_repo->find($id);
	}

	public function AllTags() {
		$em = $this->getEntityManager();
		$tag_repo = $em->getRepository("BlogBundle:Tag");
		return $tags = $tag_repo->findAll();
	}

	public function SaveTag($formdata) {
		$em = $this->getEntityManager();
		$tag_repo = $em->getRepository("BlogBundle:Tag");
		$tag = new Tag();
		$tag->setName($form->get('name')->getData());
		$tag->setDescription($form->get('description')->getData());
		$em->persist($tag);
		$flush = $em->flush();
		return $flush;
	}

	public function DeleteTag($id) {
		$em = $this->getEntityManager();
		$tag_repo = $em->getRepository("BlogBundle:Tag");
		$tag = $tag_repo->FindTag($id);
		$em->remove($tag);
		$flush = $em->flush();
		return $flush;
	}

	public function updateCategory($id, $formdata) {
		$em = $this->getEntityManager();
		$tag_repo = $em->getRepository("BlogBundle:Tag");
		$category = $category_repo->find($id);
		$category->setName($formdata->get('name')->getData());
		$category->setDescription($formdata->get('description')->getData());
		$em->persist($category);
		$flush = $em->flush();
		return $flush;
	}
}