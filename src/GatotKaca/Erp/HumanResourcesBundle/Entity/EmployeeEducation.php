<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/EmployeeEducation.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\MainBundle\Entity\Education
 * - GatotKaca\Erp\MainBundle\Entity\District
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "trs_employee_education")
 **/
class EmployeeEducation
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Employee", inversedBy = "education")
     * @ORM\JoinColumn(name = "mtr_employee_id", referencedColumnName = "id")
     **/
    protected $employee;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Education", inversedBy = "employee_education")
     * @ORM\JoinColumn(name = "sys_education_id", referencedColumnName = "id")
     **/
    protected $education;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 77, nullable = true)
     **/
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\District", inversedBy = "employee_education")
     * @ORM\JoinColumn(name = "sys_district_id", referencedColumnName = "id")
     **/
    protected $district;

    /**
     * @ORM\Column(name = "`specialist`", type = "string", length = 40, nullable = true)
     **/
    protected $specialist;

    /**
     * @ORM\Column(name = "`edu_start`", type = "date", nullable = true)
     **/
    protected $start;

    /**
     * @ORM\Column(name = "`edu_end`", type = "date", nullable = true)
     **/
    protected $end;

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
        $this->specialist = '';
        $this->created    = new \DateTime();
        $this->updated    = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string            $id
     * @return EmployeeEducation
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
     * @param  string            $name
     * @return EmployeeEducation
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
     * Set specialist
     *
     * @param  string            $specialist
     * @return EmployeeEducation
     */
    public function setSpecialist($specialist)
    {
        $this->specialist = $specialist;

        return $this;
    }

    /**
     * Get specialist
     *
     * @return string
     */
    public function getSpecialist()
    {
        return $this->specialist;
    }

    /**
     * Set start
     *
     * @param  \DateTime         $start
     * @return EmployeeEducation
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param  \DateTime         $end
     * @return EmployeeEducation
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set created
     *
     * @param  \DateTime         $created
     * @return EmployeeEducation
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
     * @param  string            $createdBy
     * @return EmployeeEducation
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
     * @param  \DateTime         $updated
     * @return EmployeeEducation
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
     * @param  string            $updatedBy
     * @return EmployeeEducation
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
     * @return EmployeeEducation
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
     * Set education
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Education $education
     * @return EmployeeEducation
     */
    public function setEducation(\GatotKaca\Erp\MainBundle\Entity\Education $education = null)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Education
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set district
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\District $district
     * @return EmployeeEducation
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
