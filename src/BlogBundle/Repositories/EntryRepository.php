<?php
// src/BlogBundle/Repositories/EntryRepository.php
namespace BlogBundle\Repositories;

use BlogBundle\Entity\Entry;
use BlogBundle\Entity\EntryTag;
use BlogBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;

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
		$em = $this->getDoctrine()->getManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		return $entries = $entries_repo->findAll();
	}

	public function SaveEntry($formdata, $user) {
		$em = $this->getEntityManager();
		$entries_repo = $em->getRepository("BlogBundle:Entry");
		$entry = new Entry();
		$entry->setTitle($formdata->get('title')->getData());
		$entry->setContent($formdata->get('content')->getData());
		$entry->setStatus($formdata->get('status')->getData());
		$file = $formdata['image']->getData();
		$ext = $file->guessExtension();
		$file_name = time() . "." . $ext;
		$file->move("upload", $file_name);
		$entry->setImage($file_name);
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

	public function updateEntry($id, $formdata, $user) {
		$em = $this->getEntityManager();
		$entry_repo = $em->getRepository("BlogBundle:Entry");
		$entry = $entry_repo->find($id);
		$entry->setTitle($formdata->get('title')->getData());
		$entry->setContent($formdata->get('content')->getData());
		$entry->setStatus($formdata->get('status')->getData());
		$file = $formdata['image']->getData();
		$ext = $file->guessExtension();
		$file_name = time() . "." . $ext;
		$file->move("upload", $file_name);
		$entry->setImage($file_name);
		$entry->setUser($user);
		$entry->setCategory($formdata->get('category')->getData());
		$em->persist($entry);
		$flush = $em->flush();
		return $flush;
	}
}