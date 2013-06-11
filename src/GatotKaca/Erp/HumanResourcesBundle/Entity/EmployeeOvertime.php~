<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/EmployeeOvertime.php
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
 * @ORM\Table(name = "trs_employee_overtime")
 **/
class EmployeeOvertime{
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
     * @ORM\Column(type = "date", nullable = true)
     **/
    protected $ot_date;

    /**
     * @ORM\Column(type = "string", length = 77, nullable = true)
     **/
    protected $jobdesc;

    /**
     * @ORM\Column(type = "time", nullable = true)
     **/
    protected $ot_start;

    /**
     * @ORM\Column(type = "time", nullable = true)
     **/
    protected $ot_end;

    /**
     * @ORM\Column(type = "boolean", nullable = true)
     **/
    protected $isholiday;

    /**
     * Desc : 0 => Upapproved, 1 => Approved, 2 => Canceled
     * @ORM\Column(type = "integer", nullable = true)
     **/
    protected $isapprove;

    /**
     * @ORM\Column(type = "boolean", nullable = true)
     **/
    protected $isexpire;

    /**
     * @ORM\Column(type = "decimal", precision = 5,  scale = 2, nullable = true)
     * Overtime dalam menit
     **/
    protected $ot_real;
	
    /**
     * @ORM\Column(type = "datetime", nullable = true)
     **/
    protected $approved;
    
    /**
     * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", inversedBy="approvedby")
     * @ORM\JoinColumn(name="approvedby", referencedColumnName="id")
     **/
    protected $approvedby;

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
        $this->created      = new \DateTime();
        $this->updated      = new \DateTime();
        $this->isapprove    = 0;
        $this->isexpire     = FALSE;
	}

    /**
     * Set id
     *
     * @param string $id
     * @return EmployeeOvertime
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
     * Set ot_date
     *
     * @param \DateTime $otDate
     * @return EmployeeOvertime
     */
    public function setOtDate($otDate)
    {
        $this->ot_date = $otDate;
    
        return $this;
    }

    /**
     * Get ot_date
     *
     * @return \DateTime 
     */
    public function getOtDate()
    {
        return $this->ot_date;
    }

    /**
     * Set jobdesc
     *
     * @param string $jobdesc
     * @return EmployeeOvertime
     */
    public function setJobdesc($jobdesc)
    {
        $this->jobdesc = $jobdesc;
    
        return $this;
    }

    /**
     * Get jobdesc
     *
     * @return string 
     */
    public function getJobdesc()
    {
        return $this->jobdesc;
    }

    /**
     * Set ot_start
     *
     * @param \DateTime $otStart
     * @return EmployeeOvertime
     */
    public function setOtStart($otStart)
    {
        $this->ot_start = $otStart;
    
        return $this;
    }

    /**
     * Get ot_start
     *
     * @return \DateTime 
     */
    public function getOtStart()
    {
        return $this->ot_start;
    }

    /**
     * Set ot_end
     *
     * @param \DateTime $otEnd
     * @return EmployeeOvertime
     */
    public function setOtEnd($otEnd)
    {
        $this->ot_end = $otEnd;
    
        return $this;
    }

    /**
     * Get ot_end
     *
     * @return \DateTime 
     */
    public function getOtEnd()
    {
        return $this->ot_end;
    }

    /**
     * Set isholiday
     *
     * @param boolean $isholiday
     * @return EmployeeOvertime
     */
    public function setIsholiday($isholiday)
    {
        $this->isholiday = $isholiday;
    
        return $this;
    }

    /**
     * Get isholiday
     *
     * @return boolean 
     */
    public function getIsholiday()
    {
        return $this->isholiday;
    }

    /**
     * Set isapprove
     *
     * @param boolean $isapprove
     * @return EmployeeOvertime
     */
    public function setIsapprove($isapprove)
    {
        $this->isapprove = $isapprove;
    
        return $this;
    }

    /**
     * Get isapprove
     *
     * @return boolean 
     */
    public function getIsapprove()
    {
        return $this->isapprove;
    }

    /**
     * Set ot_real
     *
     * @param integer $otReal
     * @return EmployeeOvertime
     */
    public function setOtReal($otReal)
    {
        $this->ot_real = $otReal;
    
        return $this;
    }

    /**
     * Get ot_real
     *
     * @return integer 
     */
    public function getOtReal()
    {
        return $this->ot_real;
    }

    /**
     * Set approved
     *
     * @param \DateTime $approved
     * @return EmployeeOvertime
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    
        return $this;
    }

    /**
     * Get approved
     *
     * @return \DateTime 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EmployeeOvertime
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
     * @return EmployeeOvertime
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
     * @return EmployeeOvertime
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
     * @return EmployeeOvertime
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
     * @return EmployeeOvertime
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
     * Set approvedby
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $approvedby
     * @return EmployeeOvertime
     */
    public function setApprovedby(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $approvedby = null)
    {
        $this->approvedby = $approvedby;
    
        return $this;
    }

    /**
     * Get approvedby
     *
     * @return \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee 
     */
    public function getApprovedby()
    {
        return $this->approvedby;
    }

    /**
     * Set isexpire
     *
     * @param boolean $isexpire
     * @return EmployeeOvertime
     */
    public function setIsexpire($isexpire)
    {
        $this->isexpire = $isexpire;
    
        return $this;
    }

    /**
     * Get isexpire
     *
     * @return boolean 
     */
    public function getIsexpire()
    {
        return $this->isexpire;
    }
}