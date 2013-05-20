<?php

namespace Crudforge\CrudforgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fields
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Fields
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=40)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=10)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="length", type="integer", length=10)
     */
    private $length;

    /**
     * @var integer
     *
     * @ORM\Column(name="scale", type="integer", length=10)
     */
    private $scale;

    /**
     * @ORM\ManyToOne(targetEntity="Document", inversedBy="fields")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     */
    protected $document;

    public function __toString(){
        return $this->getName();
    }


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
     * Set name
     *
     * @param string $name
     * @return Fields
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Fields
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set document
     *
     * @param \Crudforge\CrudforgeBundle\Entity\Document $document
     * @return Fields
     */
    public function setDocument(\Crudforge\CrudforgeBundle\Entity\Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \Crudforge\CrudforgeBundle\Entity\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set length
     *
     * @param integer $length
     * @return Fields
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set scale
     *
     * @param integer $scale
     * @return Fields
     */
    public function setScale($scale)
    {
        $this->scale = $scale;

        return $this;
    }

    /**
     * Get scale
     *
     * @return integer
     */
    public function getScale()
    {
        return $this->scale;
    }
}