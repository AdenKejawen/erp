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
class Attendance
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Employee", inversedBy = "attendance")
     * @ORM\JoinColumn(name = "mtr_employee_id", referencedColumnName = "id")
     **/
    protected $employee;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\OfficeHour", inversedBy = "attendance")
     * @ORM\JoinColumn(name = "sys_officehour_id", referencedColumnName = "id")
     **/
    protected $shift;

    /**
     * @ORM\Column(name = "`att_date`", type = "date", nullable = true)
     **/
    protected $date;

    /**
     * @ORM\Column(name = "`time_in`", type = "time", nullable = true)
     **/
    protected $time_in;

    /**
     * @ORM\Column(name = "`time_out`", type = "time", nullable = true)
     **/
    protected $time_out;

    /**
     * @ORM\Column(name = "`late`", type = "time", nullable = true)
     **/
    protected $late;

    /**
     * @ORM\Column(name = "`loyal`", type = "time", nullable = true)
     **/
    protected $loyal;

    /**
     * @ORM\Column(name = "`ismiss`", type = "boolean", nullable = true)
     **/
    protected $is_miss;

    /**
     * @ORM\Column(name = "`miss`", type = "string", length = 7, nullable = true)
     *
     * - PERMIT
     * - SICK
     * - SKIP
     * - IN
     * - OFF
     **/
    protected $miss;

    /**
     * @ORM\Column(name = "`description`", type = "string", length = 255, nullable = true)
     **/
    protected $description;

    /**
     * @ORM\Column(name = "`created`", type = "datetime")
     **/
    protected $created;

    /**
     * @ORM\Column(name = "`createdby`", type = "string", length = 40)
     **/
    protected $created_by;

    /**
     * @ORM\Column(name = "`updated`", type = "datetime")
     **/
    protected $updated;

    /**
     * @ORM\Column(name = "`updatedby`", type = "string", length = 40)
     **/
    protected $updated_by;

    public function __construct()
    {
        $datetime       = new \DateTime(date('Y-m-d H:i:s', strtotime(date('Y-m-d').' 00:00:00')));
        $this->is_miss  = false;
        $this->miss     = 'SKIP';
        $this->description  = '';
        $this->late     = $datetime;
        $this->loyal    = $datetime;
        $this->time_in  = $datetime;
        $this->time_out = $datetime;
        $this->created  = new \DateTime();
        $this->updated  = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string     $id
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
     * Set date
     *
     * @param  \DateTime  $date
     * @return Attendance
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
     * Set time_in
     *
     * @param  \DateTime  $timeIn
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
     * @param  \DateTime  $timeOut
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
     * @param  \DateTime  $late
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
     * @param  \DateTime  $loyal
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
     * Set is_miss
     *
     * @param  boolean    $isMiss
     * @return Attendance
     */
    public function setIsMiss($isMiss)
    {
        $this->is_miss = $isMiss;

        return $this;
    }

    /**
     * Get is_miss
     *
     * @return boolean
     */
    public function getIsMiss()
    {
        return $this->is_miss;
    }

    /**
     * Set miss
     *
     * @param  string     $miss
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
     * @param  string     $description
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
     * @param  \DateTime  $created
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
     * Set created_by
     *
     * @param  string     $createdBy
     * @return Attendance
     */
    public function setCreatedBy($createdBy)
    {
        $this->created_by = $createdBy;

        return $this;
    }

    /**
     * Get created_by
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set updated
     *
     * @param  \DateTime  $updated
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
     * Set updated_by
     *
     * @param  string     $updatedBy
     * @return Attendance
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updated_by = $updatedBy;

        return $this;
    }

    /**
     * Get updated_by
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Set employee
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\OfficeHour $shift
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
