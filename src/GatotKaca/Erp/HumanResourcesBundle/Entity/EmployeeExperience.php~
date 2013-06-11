<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/EmployeeExperience.php
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
 * @ORM\Table(name = "trs_employee_experience")
 **/
class EmployeeExperience{
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", inversedBy="employee")
	 * @ORM\JoinColumn(name="mtr_employee_id", referencedColumnName="id")
	 **/
	protected $employee;
	
	/**
	 * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $company;
	
	/**
     * @ORM\Column(type = "string", length = 77, nullable = true)
     **/
	protected $jobtitle;
	
	/**
	 * @ORM\Column(type = "string", length = 77, nullable = true)
	 **/
	protected $reason;
	
	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $exp_start;
	
	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $exp_end;
	
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
        $this->reason   = '';
		$this->created	= new \DateTime();
		$this->updated	= new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return EmployeeExperience
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
     * Set company
     *
     * @param string $company
     * @return EmployeeExperience
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set jobtitle
     *
     * @param string $jobtitle
     * @return EmployeeExperience
     */
    public function setJobtitle($jobtitle)
    {
        $this->jobtitle = $jobtitle;
    
        return $this;
    }

    /**
     * Get jobtitle
     *
     * @return string 
     */
    public function getJobtitle()
    {
        return $this->jobtitle;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return EmployeeExperience
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    
        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set exp_start
     *
     * @param \DateTime $expStart
     * @return EmployeeExperience
     */
    public function setExpStart($expStart)
    {
        $this->exp_start = $expStart;
    
        return $this;
    }

    /**
     * Get exp_start
     *
     * @return \DateTime 
     */
    public function getExpStart()
    {
        return $this->exp_start;
    }

    /**
     * Set exp_end
     *
     * @param \DateTime $expEnd
     * @return EmployeeExperience
     */
    public function setExpEnd($expEnd)
    {
        $this->exp_end = $expEnd;
    
        return $this;
    }

    /**
     * Get exp_end
     *
     * @return \DateTime 
     */
    public function getExpEnd()
    {
        return $this->exp_end;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EmployeeExperience
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
     * @return EmployeeExperience
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
     * @return EmployeeExperience
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
     * @return EmployeeExperience
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
     * @return EmployeeExperience
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
}