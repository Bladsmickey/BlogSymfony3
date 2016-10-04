<?php

namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entry
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Entry {
/**
 * @var \DateTime
 *
 *
 * @ORM\Column(name="created", type="datetime", nullable=false)
 */
	private $created;

/**
 * @var \DateTime
 *
 *
 * @ORM\Column(name="updated", type="datetime", nullable=false)
 */
	private $updated;

/**
 * @var \DateTime
 *
 *
 * @ORM\Column(name="deleted", type="datetime", nullable=false)
 */
	private $deleted;
	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var string
	 */
	private $status;

	/**
	 * @var string
	 */
	private $image;

	/**
	 * @var \BlogBundle\Entity\Users
	 */
	private $user;

	/**
	 * @var \BlogBundle\Entity\Categories
	 */
	private $category;

	protected $entryTag;

	public function __construct() {
		$this->entryTag = new ArrayCollection();
	}
/**
 * Triggered on insert
 *
 * @ORM\PrePersist
 */
	public function onPrePersist() {
		$this->created = new \DateTime("now");
		$this->updated = new \DateTime("now");
	}

/**
 * Triggered on update
 *
 * @ORM\PreUpdate
 */
	public function onPreUpdate() {
		$this->updated = new \DateTime("now");
	}

/**
 * Triggered on update
 *
 * @ORM\PreRemove
 */
	public function onPreRemove() {
		$this->deleted = new \DateTime("now");
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @return \DateTime
	 */
	public function setCreated($createdAt) {
		$this->created = $createdAt;
		return $this;
	}

	/**
	 * Get Updated
	 *
	 * @return \DateTime
	 */
	public function getUpdated() {
		return $this->updated;
	}

	/**
	 * @return \DateTime
	 */
	public function setUpdated($updatedAt) {
		$this->updated = $updatedAt;
		return $this;
	}

	/**
	 * Get Deleted
	 *
	 * @return \DateTime
	 */
	public function getDeleted() {
		return $this->deleted;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return Entry
	 */
	public function setTitle($title) {
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Set content
	 *
	 * @param string $content
	 * @return Entry
	 */
	public function setContent($content) {
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Set status
	 *
	 * @param string $status
	 * @return Entry
	 */
	public function setStatus($status) {
		$this->status = $status;

		return $this;
	}

	/**
	 * Get status
	 *
	 * @return string
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Set image
	 *
	 * @param string $image
	 * @return Entry
	 */
	public function setImage($image) {
		$this->image = $image;

		return $this;
	}

	/**
	 * Get image
	 *
	 * @return string
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Set user
	 *
	 * @param \BlogBundle\Entity\Users $user
	 * @return Entry
	 */
	public function setUser(\BlogBundle\Entity\User $user = null) {
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return \BlogBundle\Entity\Users
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Set category
	 *
	 * @param \BlogBundle\Entity\Category $category
	 * @return Entry
	 */
	public function setCategory(\BlogBundle\Entity\Category $category = null) {
		$this->category = $category;

		return $this;
	}

	/**
	 * Get category
	 *
	 * @return \BlogBundle\Entity\Categories
	 */
	public function getCategory() {
		return $this->category;
	}

	public function getEntryTag() {
		return $this->entryTag;
	}
}
