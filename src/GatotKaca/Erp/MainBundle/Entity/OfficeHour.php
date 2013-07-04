<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/OfficeHour.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_officehour")
 **/
class OfficeHour
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 40, nullable = true)
     */
    protected $name;

    /**
     * @ORM\Column(name = "`time_in`", type = "time", nullable = true)
     **/
    protected $time_in;

    /**
     * @ORM\Column(name = "`time_out`", type = "time", nullable = true)
     **/
    protected $time_out;

    /**
     * @ORM\Column(name = "`status`", type = "boolean", nullable = true)
     **/
    protected $status;

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

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy = "shift")
     **/
    protected $employee;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance", mappedBy = "shift")
     **/
    protected $attendance;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment", mappedBy = "office_hour")
     **/
    protected $shiftment;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
        $this->status  = true;
    }

    /**
     * Set id
     *
     * @param  string     $id
     * @return OfficeHour
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
     * @param  string     $name
     * @return OfficeHour
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
     * Set time_in
     *
     * @param  \DateTime  $timeIn
     * @return OfficeHour
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
     * @return OfficeHour
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
     * Set status
     *
     * @param  boolean    $status
     * @return OfficeHour
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created
     *
     * @param  \DateTime  $created
     * @return OfficeHour
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
     * @return OfficeHour
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
     * @return OfficeHour
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
     * @return OfficeHour
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
     * Add employee
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     * @return OfficeHour
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
     * Add attendance
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance $attendance
     * @return OfficeHour
     */
    public function addAttendance(\GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance $attendance)
    {
        $this->attendance[] = $attendance;

        return $this;
    }

    /**
     * Remove attendance
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance $attendance
     */
    public function removeAttendance(\GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance $attendance)
    {
        $this->attendance->removeElement($attendance);
    }

    /**
     * Get attendance
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttendance()
    {
        return $this->attendance;
    }

    /**
     * Add shiftment
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment $shiftment
     * @return OfficeHour
     */
    public function addShiftment(\GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment $shiftment)
    {
        $this->shiftment[] = $shiftment;

        return $this;
    }

    /**
     * Remove shiftment
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment $shiftment
     */
    public function removeShiftment(\GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment $shiftment)
    {
        $this->shiftment->removeElement($shiftment);
    }

    /**
     * Get shiftment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShiftment()
    {
        return $this->shiftment;
    }
}
