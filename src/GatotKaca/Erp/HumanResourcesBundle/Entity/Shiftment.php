<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/Shiftment.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\OfficeHour
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "trs_employee_shift")
 **/
class Shiftment{
    /**
     * @ORM\Id
     * @ORM\Column(type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="shiftment")
     * @ORM\JoinColumn(name="mtr_employee_id", referencedColumnName="id")
     **/
    protected $employee;

    /**
     * @ORM\Column(type = "date", nullable = true)
     **/
    protected $shift_date;

    /**
     * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\OfficeHour", inversedBy="shiftment")
     * @ORM\JoinColumn(name="sys_officehour_id", referencedColumnName="id")
     **/
    protected $officehour;

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
        $this->created  = new \DateTime();
        $this->updated  = new \DateTime();
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Shiftment
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
     * Set shift_date
     *
     * @param \DateTime $shiftDate
     * @return Shiftment
     */
    public function setShiftDate($shiftDate)
    {
        $this->shift_date = $shiftDate;

        return $this;
    }

    /**
     * Get shift_date
     *
     * @return \DateTime
     */
    public function getShiftDate()
    {
        return $this->shift_date;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Shiftment
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
     * @return Shiftment
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
     * @return Shiftment
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
     * @return Shiftment
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
     * @return Shiftment
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
     * Set officehour
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\OfficeHour $officehour
     * @return Shiftment
     */
    public function setOfficehour(\GatotKaca\Erp\MainBundle\Entity\OfficeHour $officehour = null)
    {
        $this->officehour = $officehour;

        return $this;
    }

    /**
     * Get officehour
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\OfficeHour
     */
    public function getOfficehour()
    {
        return $this->officehour;
    }
}