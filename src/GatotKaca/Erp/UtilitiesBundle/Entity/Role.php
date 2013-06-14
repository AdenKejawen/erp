<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Entity/Module.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup
 * - GatotKaca\Erp\UtilitiesBundle\Entity\Module
 **/

namespace GatotKaca\Erp\UtilitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "utl_role")
 */
class Role{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="UserGroup", inversedBy="role")
	 * @ORM\JoinColumn(name="utl_group_id", referencedColumnName="id")
	 **/
	protected $group;

	/**
	 * @ORM\ManyToOne(targetEntity="Module", inversedBy="role")
	 * @ORM\JoinColumn(name="utl_module_id", referencedColumnName="id")
	 **/
	protected $module;

	/**
	 * @ORM\Column(type = "boolean", nullable = true)
	 **/
	protected $view;

	/**
	 * @ORM\Column(type = "boolean", nullable = true)
	 **/
	protected $modif;

	/**
	 * @ORM\Column(type = "boolean", nullable = true)
	 **/
	protected $delete;

	/**
	 * @ORM\Column(type = "datetime")
	 **/
	protected $created;

	/**
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $createdby;

	/**
	 * @ORM\Column(type = "datetime")
	 **/
	protected $updated;

	/**
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $updatedby;

	public function __construct(){
		$this->view	      = FALSE;
		$this->modif      = FALSE;
		$this->delete     = FALSE;
		$this->created    = new \DateTime();
		$this->updated    = new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return Role
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set view
     *
     * @param boolean $view
     * @return Role
     */
    public function setView($view)
    {
        $this->view = $view;
    
        return $this;
    }

    /**
     * Get view
     *
     * @return boolean 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set modif
     *
     * @param boolean $modif
     * @return Role
     */
    public function setModif($modif)
    {
        $this->modif = $modif;
    
        return $this;
    }

    /**
     * Get modif
     *
     * @return boolean 
     */
    public function getModif()
    {
        return $this->modif;
    }

    /**
     * Set delete
     *
     * @param boolean $delete
     * @return Role
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;
    
        return $this;
    }

    /**
     * Get delete
     *
     * @return boolean 
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Role
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set createdby
     *
     * @param string $createdby
     * @return Role
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;
    
        return $this;
    }

    /**
     * Get createdby
     *
     * @return string 
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Role
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updatedby
     *
     * @param string $updatedby
     * @return Role
     */
    public function setUpdatedby($updatedby)
    {
        $this->updatedby = $updatedby;
    
        return $this;
    }

    /**
     * Get updatedby
     *
     * @return string 
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }

    /**
     * Set group
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup $group
     * @return Role
     */
    public function setGroup(\GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup $group = null)
    {
        $this->group = $group;
    
        return $this;
    }

    /**
     * Get group
     *
     * @return \GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set module
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\Module $module
     * @return Role
     */
    public function setModule(\GatotKaca\Erp\UtilitiesBundle\Entity\Module $module = null)
    {
        $this->module = $module;
    
        return $this;
    }

    /**
     * Get module
     *
     * @return \GatotKaca\Erp\UtilitiesBundle\Entity\Module 
     */
    public function getModule()
    {
        return $this->module;
    }
}