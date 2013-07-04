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
class EmployeeTraining
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Employee", inversedBy = "training")
     * @ORM\JoinColumn(name = "mtr_employee_id", referencedColumnName = "id")
     **/
    protected $employee;

    /**
     * @ORM\Column(name = "`skill`", type = "string", length = 77, nullable = true)
     **/
    protected $skill;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 77, nullable = true)
     **/
    protected $name;

    /**
     * @ORM\Column(name = "`institute`", type = "string", length = 77, nullable = true)
     **/
    protected $institute;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\District", inversedBy = "training")
     * @ORM\JoinColumn(name = "sys_district_id", referencedColumnName = "id")
     **/
    protected $district;

    /**
     * @ORM\Column(name = "`training_start`", type = "date", nullable = true)
     **/
    protected $start;

    /**
     * @ORM\Column(name = "`training_end`", type = "date", nullable = true)
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
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string           $id
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
     * @param  string           $skill
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
     * @param  string           $name
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
     * @param  string           $institute
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
     * Set start
     *
     * @param  \DateTime        $start
     * @return EmployeeTraining
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
     * @param  \DateTime        $end
     * @return EmployeeTraining
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
     * @param  \DateTime        $created
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
     * Set created_by
     *
     * @param  string           $createdBy
     * @return EmployeeTraining
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
     * @param  \DateTime        $updated
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
     * Set updated_by
     *
     * @param  string           $updatedBy
     * @return EmployeeTraining
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\District $district
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
