<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/EmployeeTraining.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "trs_employee_training")
 **/
class EmployeeTraining{
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Employee", inversedBy="training")
	 * @ORM\JoinColumn(name="mtr_employee_id", referencedColumnName="id")
	 **/
	protected $employee;

	/**
     * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $skill;

	/**
	 * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $name;

	/**
	 * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $institute;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\District", inversedBy="training")
	 * @ORM\JoinColumn(name="sys_district_id", referencedColumnName="id")
	 **/
	protected $district;

	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $training_start;

	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $training_end;

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
		$this->created	= new \DateTime();
		$this->updated	= new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return EmployeeTraining
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
     * Set skill
     *
     * @param string $skill
     * @return EmployeeTraining
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
    
        return $this;
    }

    /**
     * Get skill
     *
     * @return string 
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return EmployeeTraining
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
     * Set institute
     *
     * @param string $institute
     * @return EmployeeTraining
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
     * Set training_start
     *
     * @param \DateTime $trainingStart
     * @return EmployeeTraining
     */
    public function setTrainingStart($trainingStart)
    {
        $this->training_start = $trainingStart;
    
        return $this;
    }

    /**
     * Get training_start
     *
     * @return \DateTime 
     */
    public function getTrainingStart()
    {
        return $this->training_start;
    }

    /**
     * Set training_end
     *
     * @param \DateTime $trainingEnd
     * @return EmployeeTraining
     */
    public function setTrainingEnd($trainingEnd)
    {
        $this->training_end = $trainingEnd;
    
        return $this;
    }

    /**
     * Get training_end
     *
     * @return \DateTime 
     */
    public function getTrainingEnd()
    {
        return $this->training_end;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EmployeeTraining
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
     * @return EmployeeTraining
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
     * @return EmployeeTraining
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
     * @return EmployeeTraining
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
     * @return EmployeeTraining
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
     * Set district
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\District $district
     * @return EmployeeTraining
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