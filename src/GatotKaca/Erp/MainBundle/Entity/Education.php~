<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/Education.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 * 
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_education")
 **/
class Education{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;
	
	/**
	 * @ORM\Column(type = "integer", length = 2, unique = true, nullable = true)
	 **/
	protected $level;
	
	/**
	 * @ORM\Column(type = "string", length = 17, nullable = true)
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
	 * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation", mappedBy="education")
	 **/
	protected $employee;
	
	/**
	 * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily", mappedBy="education")
	 **/
	protected $family;
	
	public function __construct(){
		$this->status	= TRUE;
		$this->created	= new \DateTime();
		$this->updated	= new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return Education
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
     * Set level
     *
     * @param integer $level
     * @return Education
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Education
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
     * Set created
     *
     * @param \DateTime $created
     * @return Education
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
     * Set status
     *
     * @param boolean $status
     * @return Education
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
     * Set createdby
     *
     * @param string $createdby
     * @return Education
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
     * @return Education
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
     * @return Education
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
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employee
     * @return Education
     */
    public function addEmployee(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employee)
    {
        $this->employee[] = $employee;
    
        return $this;
    }

    /**
     * Remove employee
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employee
     */
    public function removeEmployee(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employee)
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

    /**
     * Add family
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family
     * @return Education
     */
    public function addFamily(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family)
    {
        $this->family[] = $family;
    
        return $this;
    }

    /**
     * Remove family
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family
     */
    public function removeFamily(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family)
    {
        $this->family->removeElement($family);
    }

    /**
     * Get family
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFamily()
    {
        return $this->family;
    }
}