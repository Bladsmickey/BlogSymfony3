<?php
// src/BlogBundle/Repositories/EntryRepository.php
namespace BlogBundle\Repositories;

use BlogBundle\Entity\Entry;
use BlogBundle\Entity\EntryTag;
use BlogBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class EntryRepository extends EntityRepository {

	public Function saveEntryTag($tags, $id) {
		$em = $this->getEntityManager();
		$tags_repo = $em->getRepository("BlogBundle:Tag");
		$entry_repo = $em->getRepository("BlogBundle:Entry");

		$tags = explode(",", $tags);
		foreach ($tags as $tag) {
			$tag_exist = $tags_repo->findOneBy(array("name" => $tag));
			if (count($tag_exist) == 0) {
				$tag_save = new Tag();
				$tag_save->setName($tag);
				$tag_save->setDescription($tag);
				$em->persist($tag_save);
				$flush = $em->flush();
			}
			$tag_obj = $tags_repo->findOneBy(array("name" => $tag));
			$entry_obj = $entry_repo->find($id);
			$entrytag = new EntryTag();
			$entrytag->setEntry($entry_obj);
			$entrytag->setTag($tag_obj);
			$em->persist($entrytag);
			$flush = $em->flush();
		}

	}

	public function FindEntry($id) {
		$em = $this->getEntityManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		return $entries = $entries_repo->find($id);
	}

	public function AllEntries() {
		$em = $this->getEntityManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		return $entries = $entries_repo->findAll();
	}

	public function PaginateEntries($pageSize = 2, $currentPage = 1) {
		$em = $this->getEntityManager();
		$dql = "SELECT e FROM \BlogBundle\Entity\Entry e ORDER BY e.id DESC";
		$query = $em->createQuery($dql)
			->setFirstResult($pageSize * ($currentPage - 1))
			->setMaxResults($pageSize);
		return $paginator = new Paginator($query, $fetchJoinCollection = true);
	}

	public function PaginateEntriesCategories($category, $pageSize = 2, $currentPage = 1) {
		$em = $this->getEntityManager();
		$dql = "SELECT e FROM \BlogBundle\Entity\Entry e WHERE e.category = :category ORDER BY e.id DESC";
		$query = $em->createQuery($dql)
			->setParameter("category", $category)
			->setFirstResult($pageSize * ($currentPage - 1))
			->setMaxResults($pageSize);
		return $paginator = new Paginator($query, $fetchJoinCollection = true);
	}

	public function SaveEntry($formdata, $user) {
		$em = $this->getEntityManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		$entry = new Entry();
		$entry->setTitle($formdata->get('title')->getData());
		$entry->setContent($formdata->get('content')->getData());
		$entry->setStatus($formdata->get('status')->getData());
		$file = $formdata['image']->getData();
		if ($file != null && !empty($file)) {
			$ext = $file->guessExtension();
			$file_name = time() . "." . $ext;
			$file->move("upload", $file_name);
			$entry->setImage($file_name);
		}
		$entry->setUser($user);
		$entry->setCategory($formdata->get('category')->getData());
		$em->persist($entry);
		$flush = $em->flush();
		$tags = $formdata->get('tags')->getData();
		$id = $entry->getId();
		$guardartags = $entries_repo->saveEntryTag($tags, $id);
		return $flush;
	}

	public function DeleteEntry($id) {
		$em = $this->getEntityManager();
		$entry_repo = $em->getRepository("BlogBundle:Entry");
		$entry_tag_repo = $em->getRepository("BlogBundle:EntryTag");
		$entry_tag_obj = $entry_tag_repo->findByEntry($id);
		if (count($entry_tag_obj) > 0) {
			foreach ($entry_tag_obj as $obj) {
				$em->remove($obj);
				$flush_tag_entry = $em->flush();
			}
		} else {
			$flush_tag_entry = true;
		}
		if ($flush_tag_entry) {
			$entry_obj = $entry_repo->find($id);
			$em->remove($entry_obj);
			$flush = $em->flush();
			return $flush;
		} else {
			return $flush_tag_entry;
		}}

	public function updateEntry($id, $formdata, $user, $original_image) {
		$em = $this->getEntityManager();
		$entry_repo = $em->getRepository("BlogBundle:Entry");
		$tags = $formdata->get('tags')->getData();
		if (isset($tags)) {
			/* Eliminar Tags Asociadas */
			$entry_tag_repo = $em->getRepository("BlogBundle:EntryTag");
			$entry_tag_obj = $entry_tag_repo->findByEntry($id);
			if (count($entry_tag_obj) > 0) {
				foreach ($entry_tag_obj as $obj) {
					$em->remove($obj);
					$flush_tag_entry = $em->flush();
				}
			}
			$guardartags = $entry_repo->saveEntryTag($tags, $id);
		}
		/*Fin*/
		$entry = $entry_repo->find($id);
		$entry->setTitle($formdata->get('title')->getData());
		$entry->setContent($formdata->get('content')->getData());
		$entry->setStatus($formdata->get('status')->getData());
		$file = $formdata->get('image')->getData();
		if ($file != null && !empty($file)) {
			$ext = $file->guessExtension();
			$file_name = time() . "." . $ext;
			$file->move("upload", $file_name);
			$entry->setImage($file_name);
		} else {
			$entry->setImage($original_image);
		}
		$entry->setUser($user);
		$entry->setCategory($formdata->get('category')->getData());
		$em->persist($entry);
		$flush = $em->flush();
		return $flush;
	}
}