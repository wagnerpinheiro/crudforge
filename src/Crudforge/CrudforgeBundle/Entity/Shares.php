<?php

namespace Crudforge\CrudforgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Shares
 *
 * @ORM\Table(name="crudforge_shares")
 * @ORM\Entity(repositoryClass="Crudforge\CrudforgeBundle\Entity\SharesRepository")
 */
class Shares
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
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="my_shares")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Document", inversedBy="shares")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $document;

    /**
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="others_shares")
     * @ORM\JoinColumn(name="user_shared_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user_shared;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="view_perm", type="boolean")
     */
    private $view_perm;

    /**
     * @var boolean
     *
     * @ORM\Column(name="edit_perm", type="boolean")
     */
    private $edit_perm;

    /**
     * @var boolean
     *
     * @ORM\Column(name="create_perm", type="boolean")
     */
    private $create_perm;

    /**
     * @var boolean
     *
     * @ORM\Column(name="delete_perm", type="boolean")
     */
    private $delete_perm;


    

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
     * Set email
     *
     * @param string $email
     * @return Shares
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set view_perm
     *
     * @param boolean $viewPerm
     * @return Shares
     */
    public function setViewPerm($viewPerm)
    {
        $this->view_perm = $viewPerm;
    
        return $this;
    }

    /**
     * Get view_perm
     *
     * @return boolean 
     */
    public function getViewPerm()
    {
        return $this->view_perm;
    }

    /**
     * Set edit_perm
     *
     * @param boolean $editPerm
     * @return Shares
     */
    public function setEditPerm($editPerm)
    {
        $this->edit_perm = $editPerm;
    
        return $this;
    }

    /**
     * Get edit_perm
     *
     * @return boolean 
     */
    public function getEditPerm()
    {
        return $this->edit_perm;
    }

    /**
     * Set create_perm
     *
     * @param boolean $createPerm
     * @return Shares
     */
    public function setCreatePerm($createPerm)
    {
        $this->create_perm = $createPerm;
    
        return $this;
    }

    /**
     * Get create_perm
     *
     * @return boolean 
     */
    public function getCreatePerm()
    {
        return $this->create_perm;
    }

    /**
     * Set delete_perm
     *
     * @param boolean $deletePerm
     * @return Shares
     */
    public function setDeletePerm($deletePerm)
    {
        $this->delete_perm = $deletePerm;
    
        return $this;
    }

    /**
     * Get delete_perm
     *
     * @return boolean 
     */
    public function getDeletePerm()
    {
        return $this->delete_perm;
    }

    /**
     * Set user
     *
     * @param \Crudforge\CrudforgeBundle\Entity\Users $user
     * @return Shares
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
     * Set document
     *
     * @param \Crudforge\CrudforgeBundle\Entity\Document $document
     * @return Shares
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
     * Set user_shared
     *
     * @param \Crudforge\CrudforgeBundle\Entity\Users $userShared
     * @return Shares
     */
    public function setUserShared(\Crudforge\CrudforgeBundle\Entity\Users $userShared = null)
    {
        $this->user_shared = $userShared;
    
        return $this;
    }

    /**
     * Get user_shared
     *
     * @return \Crudforge\CrudforgeBundle\Entity\Users 
     */
    public function getUserShared()
    {
        return $this->user_shared;
    }
}