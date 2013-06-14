<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/JobTitle.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\MainBundle\Entity\JobLevel
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_jobtitle")
 **/
class JobTitle{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="JobTitle", mappedBy="parent")
	 **/
	protected $child;

	/**
	 * @ORM\ManyToOne(targetEntity="JobTitle", inversedBy="child")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
	 */
	protected $parent;

	/**
	 * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $name;

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
	 * @ORM\ManyToOne(targetEntity="JobLevel", inversedBy="jobtitle")
	 * @ORM\JoinColumn(name="sys_joblevel_id", referencedColumnName="id")
	 */
	protected $level;

	/**
	 * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy="jobtitle")
	 **/
	protected $employee;

    /**
     * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Career", mappedBy="old_jobtitle")
     **/
    protected $career_old_jobtitle;

    /**
     * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Career", mappedBy="new_jobtitle")
     **/
    protected $career_new_jobtitle;

	public function __construct(){
		$this->status	= TRUE;
		$this->created	= new \DateTime();
		$this->updated	= new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return JobTitle
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
     * @return JobTitle
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
     * @return JobTitle
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
     * @return JobTitle
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
     * @return JobTitle
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
     * @return JobTitle
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
     * @return JobTitle
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
     * @param \GatotKaca\Erp\MainBundle\Entity\JobTitle $child
     * @return JobTitle
     */
    public function addChild(\GatotKaca\Erp\MainBundle\Entity\JobTitle $child)
    {
        $this->child[] = $child;
    
        return $this;
    }

    /**
     * Remove child
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\JobTitle $child
     */
    public function removeChild(\GatotKaca\Erp\MainBundle\Entity\JobTitle $child)
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
     * @param \GatotKaca\Erp\MainBundle\Entity\JobTitle $parent
     * @return JobTitle
     */
    public function setParent(\GatotKaca\Erp\MainBundle\Entity\JobTitle $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobTitle 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set level
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\JobLevel $level
     * @return JobTitle
     */
    public function setLevel(\GatotKaca\Erp\MainBundle\Entity\JobLevel $level = null)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobLevel 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Add employee
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     * @return JobTitle
     */
    public function addEmployee(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee)
    {
        $this->employee[] = $employee;
    
        return $this;
    }

    /**
     * Remove employee
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     */
    public function removeEmployee(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee)
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
     * Add career_old_jobtitle
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldJobtitle
     * @return JobTitle
     */
    public function addCareerOldJobtitle(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldJobtitle)
    {
        $this->career_old_jobtitle[] = $careerOldJobtitle;
    
        return $this;
    }

    /**
     * Remove career_old_jobtitle
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldJobtitle
     */
    public function removeCareerOldJobtitle(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldJobtitle)
    {
        $this->career_old_jobtitle->removeElement($careerOldJobtitle);
    }

    /**
     * Get career_old_jobtitle
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCareerOldJobtitle()
    {
        return $this->career_old_jobtitle;
    }

    /**
     * Add career_new_jobtitle
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewJobtitle
     * @return JobTitle
     */
    public function addCareerNewJobtitle(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewJobtitle)
    {
        $this->career_new_jobtitle[] = $careerNewJobtitle;
    
        return $this;
    }

    /**
     * Remove career_new_jobtitle
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewJobtitle
     */
    public function removeCareerNewJobtitle(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewJobtitle)
    {
        $this->career_new_jobtitle->removeElement($careerNewJobtitle);
    }

    /**
     * Get career_new_jobtitle
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCareerNewJobtitle()
    {
        return $this->career_new_jobtitle;
    }
}