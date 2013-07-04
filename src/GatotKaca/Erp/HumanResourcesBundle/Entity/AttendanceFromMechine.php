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
class AttendanceFromMechine
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     **/
    protected $id;

    /**
     * @ORM\Column(name = "`employee`", type = "string", length = 17, nullable = true)
     **/
    protected $employee;

    /**
     * @ORM\Column(name = "`att_date`", type = "date", nullable = true)
     **/
    protected $date;

    /**
     * @ORM\Column(name = "`time`", type = "time", nullable = true)
     **/
    protected $time;

    /**
     * Tidak akan pernah di update
     *
     * @ORM\Column(name = "`created`", type = "datetime")
     **/
    protected $created;

    public function __construct()
    {
        $this->created = new \DateTime();
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
     * @param  string                $employee
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
     * Set date
     *
     * @param  \DateTime             $date
     * @return AttendanceFromMechine
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param  \DateTime             $time
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
     * @param  \DateTime             $created
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
