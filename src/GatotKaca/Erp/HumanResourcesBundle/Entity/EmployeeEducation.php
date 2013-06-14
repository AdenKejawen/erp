<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/EmployeeEducation.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\MainBundle\Entity\Education
 * - GatotKaca\Erp\MainBundle\Entity\District
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "trs_employee_education")
 **/
class EmployeeEducation{
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Employee", inversedBy="education")
	 * @ORM\JoinColumn(name="mtr_employee_id", referencedColumnName="id")
	 **/
	protected $employee;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Education", inversedBy="employee_education")
	 * @ORM\JoinColumn(name="sys_education_id", referencedColumnName="id")
	 **/
	protected $education;

	/**
	 * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $name;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\District", inversedBy="employee_education")
	 * @ORM\JoinColumn(name="sys_district_id", referencedColumnName="id")
	 **/
	protected $district;

	/**
	 * @ORM\Column(type = "string", length = 40, nullable = true)
	 **/
	protected $specialist;

	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $edu_start;

	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $edu_end;

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
		$this->specialist = '';
		$this->created    = new \DateTime();
		$this->updated    = new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return EmployeeEducation
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
     * @return EmployeeEducation
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
     * Set specialist
     *
     * @param string $specialist
     * @return EmployeeEducation
     */
    public function setSpecialist($specialist)
    {
        $this->specialist = $specialist;
    
        return $this;
    }

    /**
     * Get specialist
     *
     * @return string 
     */
    public function getSpecialist()
    {
        return $this->specialist;
    }

    /**
     * Set edu_start
     *
     * @param \DateTime $eduStart
     * @return EmployeeEducation
     */
    public function setEduStart($eduStart)
    {
        $this->edu_start = $eduStart;
    
        return $this;
    }

    /**
     * Get edu_start
     *
     * @return \DateTime 
     */
    public function getEduStart()
    {
        return $this->edu_start;
    }

    /**
     * Set edu_end
     *
     * @param \DateTime $eduEnd
     * @return EmployeeEducation
     */
    public function setEduEnd($eduEnd)
    {
        $this->edu_end = $eduEnd;
    
        return $this;
    }

    /**
     * Get edu_end
     *
     * @return \DateTime 
     */
    public function getEduEnd()
    {
        return $this->edu_end;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EmployeeEducation
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
     * @return EmployeeEducation
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
     * @return EmployeeEducation
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
     * @return EmployeeEducation
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
     * @return EmployeeEducation
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
     * @return EmployeeEducation
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

    /**
     * Set district
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\District $district
     * @return EmployeeEducation
     */
    public function setDistrict(\GatotKaca\Erp\MainBundle\Entity\District $district = null)
    {
        $this->district = $district;
    
        return $this;
    }

    /**
     * Get district
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
    }
}