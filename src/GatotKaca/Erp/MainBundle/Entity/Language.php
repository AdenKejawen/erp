<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/Language.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 * 
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_language")
 **/
class Language{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;
	
	/**
	 * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $name;

	/**
     * @ORM\Column(type = "boolean")
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
	 * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage", mappedBy="language")
	 **/
	protected $employee;

	public function __construct(){
		$this->status	= TRUE;
		$this->created	= new \DateTime();
		$this->updated	= new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return Language
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
     * @return Language
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
     * Set status
     *
     * @param boolean $status
     * @return Language
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
     * @return Language
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
     * @return Language
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
     * @return Language
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
     * @return Language
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
     * Add employee
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage $employee
     * @return Language
     */
    public function addEmployee(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage $employee)
    {
        $this->employee[] = $employee;
    
        return $this;
    }

    /**
     * Remove employee
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage $employee
     */
    public function removeEmployee(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage $employee)
    {
        $this->employee->removeElement($employee);
    }

    /**
     * Get employee
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}