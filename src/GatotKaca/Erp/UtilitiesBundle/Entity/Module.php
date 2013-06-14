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
 * Mapping Relation :
 * - GatotKaca\Erp\UtilitiesBundle\Entity\Role
 **/

namespace GatotKaca\Erp\UtilitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "utl_module")
 **/
class Module{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="Module", mappedBy="parent")
	 **/
	protected $child;

	/**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="child")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     */
 	protected $parent;

	/**
	 * @ORM\Column(type = "string", length = 27, nullable = true)
	 **/
	protected $name;

	/**
	 * @ORM\Column(type = "string", length = 27, nullable = true)
	 **/
	protected $selector;

	/**
	 * @ORM\Column(type = "string", length = 75, nullable = true)
	 **/
	protected $icon;

	/**
	 * @ORM\Column(type = "string", length = 255, nullable = true)
	 **/
	protected $url;

	/**
	 * @ORM\Column(type = "integer", nullable = true)
	 **/
	protected $menu_order;

	/**
	 * @ORM\Column(type = "boolean", nullable = true)
	 **/
	protected $status;

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

	/**
	* @ORM\OneToMany(targetEntity="Role", mappedBy="module")
	**/
	protected $role;

	public function __construct(){
		$this->selector   = 'root';
		$this->url        = 'root';
		$this->status     = TRUE;
		$this->created    = new \DateTime();
		$this->updated    = new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return Module
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
     * Set name
     *
     * @param string $name
     * @return Module
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
     * Set selector
     *
     * @param string $selector
     * @return Module
     */
    public function setSelector($selector)
    {
        $this->selector = $selector;
    
        return $this;
    }

    /**
     * Get selector
     *
     * @return string 
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return Module
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    
        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Module
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set menu_order
     *
     * @param integer $menuOrder
     * @return Module
     */
    public function setMenuOrder($menuOrder)
    {
        $this->menu_order = $menuOrder;
    
        return $this;
    }

    /**
     * Get menu_order
     *
     * @return integer 
     */
    public function getMenuOrder()
    {
        return $this->menu_order;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Module
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Module
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
     * @return Module
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
     * @return Module
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
     * @return Module
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
     * Add child
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\Module $child
     * @return Module
     */
    public function addChild(\GatotKaca\Erp\UtilitiesBundle\Entity\Module $child)
    {
        $this->child[] = $child;
    
        return $this;
    }

    /**
     * Remove child
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\Module $child
     */
    public function removeChild(\GatotKaca\Erp\UtilitiesBundle\Entity\Module $child)
    {
        $this->child->removeElement($child);
    }

    /**
     * Get child
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Set parent
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\Module $parent
     * @return Module
     */
    public function setParent(\GatotKaca\Erp\UtilitiesBundle\Entity\Module $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \GatotKaca\Erp\UtilitiesBundle\Entity\Module 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add role
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\Role $role
     * @return Module
     */
    public function addRole(\GatotKaca\Erp\UtilitiesBundle\Entity\Role $role)
    {
        $this->role[] = $role;
    
        return $this;
    }

    /**
     * Remove role
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\Role $role
     */
    public function removeRole(\GatotKaca\Erp\UtilitiesBundle\Entity\Role $role)
    {
        $this->role->removeElement($role);
    }

    /**
     * Get role
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRole()
    {
        return $this->role;
    }
}