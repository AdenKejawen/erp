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
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "mtr_attendancemechine")
 **/
class AttendanceFromMechine{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "integer")
	 * @ORM\GeneratedValue(strategy = "AUTO")
	 **/
	protected $id;
	
	/**
	 * @ORM\Column(type = "string", length = 17, nullable = true)
	 **/
	protected $employee;
	
	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $att_date;
	
	/**
	 * @ORM\Column(type = "time", nullable = true)
	 **/
	protected $time;
	
	/**
	 * Tidak akan pernah di update
	 * 
	 * @ORM\Column(type = "datetime")
	 **/
	protected $created;
	
	public function __construct(){
		$this->created	= new \DateTime();
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set employee
     *
     * @param string $employee
     * @return AttendanceFromMechine
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    
        return $this;
    }

    /**
     * Get employee
     *
     * @return string 
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set att_date
     *
     * @param \DateTime $attDate
     * @return AttendanceFromMechine
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
     * Set time
     *
     * @param \DateTime $time
     * @return AttendanceFromMechine
     */
    public function setTime($time)
    {
        $this->time = $time;
    
        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return AttendanceFromMechine
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
}