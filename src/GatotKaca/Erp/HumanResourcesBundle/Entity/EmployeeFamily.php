<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/EmployeeFamily.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Family
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "trs_employee_family")
 **/
class EmployeeFamily{
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Employee", inversedBy="family")
	 * @ORM\JoinColumn(name="mtr_employee_id", referencedColumnName="id")
	 **/
	protected $employee;

	/**
	 * 1 = PARENT
	 * 2 = SPOUSE
	 * 3 = SIBLING
	 * 4 = CHILDREN
	 *
	 * @ORM\Column(type = "integer", nullable = true)
	 **/
	protected $relation;

	/**
	 * @ORM\Column(type = "string", length = 27, nullable = true)
	 **/
	protected $fname;

	/**
	 * @ORM\Column(type = "string", length = 27, nullable = true)
	 **/
	protected $lname;

	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $born;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Education", inversedBy="family")
	 * @ORM\JoinColumn(name="sys_education_id", referencedColumnName="id")
	 **/
	protected $education;

	/**
	 * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $institute;

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
		$this->institute  = '';
		$this->created    = new \DateTime();
		$this->updated    = new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return EmployeeFamily
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
     * Set relation
     *
     * @param integer $relation
     * @return EmployeeFamily
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;
    
        return $this;
    }

    /**
     * Get relation
     *
     * @return integer 
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Set fname
     *
     * @param string $fname
     * @return EmployeeFamily
     */
    public function setFname($fname)
    {
        $this->fname = $fname;
    
        return $this;
    }

    /**
     * Get fname
     *
     * @return string 
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     * @return EmployeeFamily
     */
    public function setLname($lname)
    {
        $this->lname = $lname;
    
        return $this;
    }

    /**
     * Get lname
     *
     * @return string 
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set born
     *
     * @param \DateTime $born
     * @return EmployeeFamily
     */
    public function setBorn($born)
    {
        $this->born = $born;
    
        return $this;
    }

    /**
     * Get born
     *
     * @return \DateTime 
     */
    public function getBorn()
    {
        return $this->born;
    }

    /**
     * Set institute
     *
     * @param string $institute
     * @return EmployeeFamily
     */
    public function setInstitute($institute)
    {
        $this->institute = $institute;
    
        return $this;
    }

    /**
     * Get institute
     *
     * @return string 
     */
    public function getInstitute()
    {
        return $this->institute;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EmployeeFamily
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
     * @return EmployeeFamily
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
     * @return EmployeeFamily
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
     * @return EmployeeFamily
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
     * Set employee
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     * @return EmployeeFamily
     */
    public function setEmployee(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;
    
        return $this;
    }

    /**
     * Get employee
     *
     * @return \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee 
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set education
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Education $education
     * @return EmployeeFamily
     */
    public function setEducation(\GatotKaca\Erp\MainBundle\Entity\Education $education = null)
    {
        $this->education = $education;
    
        return $this;
    }

    /**
     * Get education
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Education 
     */
    public function getEducation()
    {
        return $this->education;
    }
}