<?php

namespace Crudforge\CrudforgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Document
 *
 * @ORM\Table(name="crudforge_documents")
 * @ORM\Entity
 */
class Document
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
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="documents")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Fields", mappedBy="document")
     */
    protected $fields;

    public function __construct(){
        $this->fields = new ArrayCollection();
    }

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
     * @return Document
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
     * Set user
     *
     * @param \Crudforge\CrudforgeBundle\Entity\Users $user
     * @return Document
     */
    public function setUser(\Crudforge\CrudforgeBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Crudforge\CrudforgeBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add fields
     *
     * @param \Crudforge\CrudforgeBundle\Entity\Fields $fields
     * @return Document
     */
    public function addField(\Crudforge\CrudforgeBundle\Entity\Fields $fields)
    {
        $this->fields[] = $fields;

        return $this;
    }

    /**
     * Remove fields
     *
     * @param \Crudforge\CrudforgeBundle\Entity\Fields $fields
     */
    public function removeField(\Crudforge\CrudforgeBundle\Entity\Fields $fields)
    {
        $this->fields->removeElement($fields);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFields()
    {
        return $this->fields;
    }
}