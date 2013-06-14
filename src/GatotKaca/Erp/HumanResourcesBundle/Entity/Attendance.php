<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/Attendance.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\MainBundle\Entity\OfficeHour
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "trs_employee_attendance")
 **/
class Attendance{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Employee", inversedBy="attendance")
	 * @ORM\JoinColumn(name="mtr_employee_id", referencedColumnName="id")
	 **/
	protected $employee;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\OfficeHour", inversedBy="attendance")
	 * @ORM\JoinColumn(name="sys_officehour_id", referencedColumnName="id")
	 **/
	protected $shift;

	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $att_date;

	/**
	 * @ORM\Column(type = "time", nullable = true)
	 **/
	protected $time_in;

	/**
	 * @ORM\Column(type = "time", nullable = true)
	 **/
	protected $time_out;

	/**
	 * @ORM\Column(type = "time", nullable = true)
	 **/
	protected $late;

	/**
	 * @ORM\Column(type = "time", nullable = true)
	 **/
	protected $loyal;

	/**
	 * @ORM\Column(type = "boolean", nullable = true)
	 **/
	protected $ismiss;

	/**
	 * @ORM\Column(type = "string", length = 7, nullable = true)
	 *
	 * - PERMIT
	 * - SICK
	 * - SKIP
	 * - IN
	 * - OFF
	 **/
	protected $miss;

	/**
	 * @ORM\Column(type = "string", length = 255, nullable = true)
	 **/
	protected $description;

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
		$datetime		= new \DateTime(date('Y-m-d H:i:s', strtotime(date('Y-m-d').' 00:00:00')));
		$this->ismiss	= FALSE;
		$this->miss		= 'SKIP';
		$this->description	= '';
		$this->late		= $datetime;
		$this->loyal	= $datetime;
		$this->time_in	= $datetime;
		$this->time_out	= $datetime;
		$this->created	= new \DateTime();
		$this->updated	= new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return Attendance
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
     * Set att_date
     *
     * @param \DateTime $attDate
     * @return Attendance
     */
    public function setAttDate($attDate)
    {
        $this->att_date = $attDate;
    
        return $this;
    }

    /**
     * Get att_date
     *
     * @return \DateTime 
     */
    public function getAttDate()
    {
        return $this->att_date;
    }

    /**
     * Set time_in
     *
     * @param \DateTime $timeIn
     * @return Attendance
     */
    public function setTimeIn($timeIn)
    {
        $this->time_in = $timeIn;
    
        return $this;
    }

    /**
     * Get time_in
     *
     * @return \DateTime 
     */
    public function getTimeIn()
    {
        return $this->time_in;
    }

    /**
     * Set time_out
     *
     * @param \DateTime $timeOut
     * @return Attendance
     */
    public function setTimeOut($timeOut)
    {
        $this->time_out = $timeOut;
    
        return $this;
    }

    /**
     * Get time_out
     *
     * @return \DateTime 
     */
    public function getTimeOut()
    {
        return $this->time_out;
    }

    /**
     * Set late
     *
     * @param \DateTime $late
     * @return Attendance
     */
    public function setLate($late)
    {
        $this->late = $late;
    
        return $this;
    }

    /**
     * Get late
     *
     * @return \DateTime 
     */
    public function getLate()
    {
        return $this->late;
    }

    /**
     * Set loyal
     *
     * @param \DateTime $loyal
     * @return Attendance
     */
    public function setLoyal($loyal)
    {
        $this->loyal = $loyal;
    
        return $this;
    }

    /**
     * Get loyal
     *
     * @return \DateTime 
     */
    public function getLoyal()
    {
        return $this->loyal;
    }

    /**
     * Set ismiss
     *
     * @param boolean $ismiss
     * @return Attendance
     */
    public function setIsmiss($ismiss)
    {
        $this->ismiss = $ismiss;
    
        return $this;
    }

    /**
     * Get ismiss
     *
     * @return boolean 
     */
    public function getIsmiss()
    {
        return $this->ismiss;
    }

    /**
     * Set miss
     *
     * @param string $miss
     * @return Attendance
     */
    public function setMiss($miss)
    {
        $this->miss = $miss;
    
        return $this;
    }

    /**
     * Get miss
     *
     * @return string 
     */
    public function getMiss()
    {
        return $this->miss;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Attendance
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Attendance
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
     * @return Attendance
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
     * @return Attendance
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
     * @return Attendance
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
     * @return Attendance
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
     * Set shift
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\OfficeHour $shift
     * @return Attendance
     */
    public function setShift(\GatotKaca\Erp\MainBundle\Entity\OfficeHour $shift = null)
    {
        $this->shift = $shift;
    
        return $this;
    }

    /**
     * Get shift
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\OfficeHour 
     */
    public function getShift()
    {
        return $this->shift;
    }
}