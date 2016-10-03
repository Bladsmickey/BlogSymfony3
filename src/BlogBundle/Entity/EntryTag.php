<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntryTag
 */
class EntryTag
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BlogBundle\Entity\Entry
     */
    private $entry;

    /**
     * @var \BlogBundle\Entity\Tag
     */
    private $tag;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set entry
     *
     * @param \BlogBundle\Entity\Entry $entry
     * @return EntryTag
     */
    public function setEntry(\BlogBundle\Entity\Entry $entry = null)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return \BlogBundle\Entity\Entry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set tag
     *
     * @param \BlogBundle\Entity\Tag $tag
     * @return EntryTag
     */
    public function setTag(\BlogBundle\Entity\Tag $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \BlogBundle\Entity\Tag 
     */
    public function getTag()
    {
        return $this->tag;
    }
}
