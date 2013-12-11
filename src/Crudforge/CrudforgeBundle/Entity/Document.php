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
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=60)
     */
    private $route;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="entity", type="string", length=60)
     */
    private $entity;    
    

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
    
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Shares", mappedBy="document")
     */
    protected $shares;

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
        $this->name = ucwords(strtolower($name));
        
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

    /**
     * Add shares
     *
     * @param \Crudforge\CrudforgeBundle\Entity\Shares $shares
     * @return Document
     */
    public function addShare(\Crudforge\CrudforgeBundle\Entity\Shares $shares)
    {
        $this->shares[] = $shares;
    
        return $this;
    }

    /**
     * Remove shares
     *
     * @param \Crudforge\CrudforgeBundle\Entity\Shares $shares
     */
    public function removeShare(\Crudforge\CrudforgeBundle\Entity\Shares $shares)
    {
        $this->shares->removeElement($shares);
    }

    /**
     * Get shares
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShares()
    {
        return $this->shares;
    }
    
    public function setProperEntity(){
        $name = trim(ucwords(strtolower($this->getUser()->getUsername() . ' ' . $this->name)));
        $name = preg_replace('/[^a-z0-9_]/i', '', $name);        
        $this->entity = $name;
        return $this;
    }
    
    public function setProperRoute(){
        $user = strtolower($this->getUser()->getUsername());
        $crud = trim(strtolower($this->name));
        $crud = preg_replace('/[^a-z0-9_]/i', '', $crud);        
        $this->route = ($user . '_' . $crud);
        return $this;
    }
    
   
    

    /**
     * Set route
     *
     * @param string $route
     * @return Document
     */
    public function setRoute($route)
    {
        $this->route = $route;
    
        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set entity
     *
     * @param string $entity
     * @return Document
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    
        return $this;
    }

    /**
     * Get entity
     *
     * @return string 
     */
    public function getEntity()
    {
        return $this->entity;
    }
}