<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/District.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\MainBundle\Entity\Province
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_district")
 **/
class District{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Province", inversedBy="district")
	 * @ORM\JoinColumn(name="sys_province_id", referencedColumnName="id")
	 **/
	protected $province;

	/**
	 * @ORM\Column(type = "string", length = 7, nullable = true)
	 **/
	protected $code;

	/**
	 * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $name;

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
	 * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy="district_address")
	 **/
	protected $employee;

    /**
     * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy="bod_place")
     **/
    protected $employee_bod_place;

	/**
	 * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation", mappedBy="district")
	 **/
	protected $employee_education;

	/**
	 * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining", mappedBy="district")
	 **/
	protected $training;

	public function __construct(){
		$this->created	= new \DateTime();
		$this->updated	= new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return District
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
     * Set code
     *
     * @param string $code
     * @return District
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return District
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
     * @return District
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
     * @return District
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
     * @return District
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
     * @return District
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
     * Set province
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Province $province
     * @return District
     */
    public function setProvince(\GatotKaca\Erp\MainBundle\Entity\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Add employee
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     * @return District
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
     * Add employee_bod_place
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeBodPlace
     * @return District
     */
    public function addEmployeeBodPlace(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeBodPlace)
    {
        $this->employee_bod_place[] = $employeeBodPlace;

        return $this;
    }

    /**
     * Remove employee_bod_place
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeBodPlace
     */
    public function removeEmployeeBodPlace(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeBodPlace)
    {
        $this->employee_bod_place->removeElement($employeeBodPlace);
    }

    /**
     * Get employee_bod_place
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployeeBodPlace()
    {
        return $this->employee_bod_place;
    }

    /**
     * Add employee_education
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employeeEducation
     * @return District
     */
    public function addEmployeeEducation(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employeeEducation)
    {
        $this->employee_education[] = $employeeEducation;

        return $this;
    }

    /**
     * Remove employee_education
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employeeEducation
     */
    public function removeEmployeeEducation(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employeeEducation)
    {
        $this->employee_education->removeElement($employeeEducation);
    }

    /**
     * Get employee_education
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployeeEducation()
    {
        return $this->employee_education;
    }

    /**
     * Add training
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining $training
     * @return District
     */
    public function addTraining(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining $training)
    {
        $this->training[] = $training;

        return $this;
    }

    /**
     * Remove training
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining $training
     */
    public function removeTraining(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining $training)
    {
        $this->training->removeElement($training);
    }

    /**
     * Get training
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTraining()
    {
        return $this->training;
    }
}