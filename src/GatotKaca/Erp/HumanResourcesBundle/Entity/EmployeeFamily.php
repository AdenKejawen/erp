<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/EmployeeFamily.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Family
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "trs_employee_family")
 **/
class EmployeeFamily
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Employee", inversedBy = "family")
     * @ORM\JoinColumn(name = "mtr_employee_id", referencedColumnName = "id")
     **/
    protected $employee;

    /**
     * 1 = PARENT
     * 2 = SPOUSE
     * 3 = SIBLING
     * 4 = CHILDREN
     *
     * @ORM\Column(name = "`relation`", type = "integer", nullable = true)
     **/
    protected $relation;

    /**
     * @ORM\Column(name = "`fname`", type = "string", length = 27, nullable = true)
     **/
    protected $first_name;

    /**
     * @ORM\Column(name = "`lname`", type = "string", length = 27, nullable = true)
     **/
    protected $last_name;

    /**
     * @ORM\Column(name = "`bod`", type = "date", nullable = true)
     **/
    protected $bod;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Education", inversedBy = "family")
     * @ORM\JoinColumn(name = "sys_education_id", referencedColumnName = "id")
     **/
    protected $education;

    /**
     * @ORM\Column(name = "`institute`", type = "string", length = 77, nullable = true)
     **/
    protected $institute;

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
        $this->institute = '';
        $this->created   = new \DateTime();
        $this->updated   = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string         $id
     * @return EmployeeFamily
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
     * Set relation
     *
     * @param  integer        $relation
     * @return EmployeeFamily
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * Get relation
     *
     * @return integer
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Set first_name
     *
     * @param  string         $firstName
     * @return EmployeeFamily
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param  string         $lastName
     * @return EmployeeFamily
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set bod
     *
     * @param  \DateTime      $bod
     * @return EmployeeFamily
     */
    public function setBod($bod)
    {
        $this->bod = $bod;

        return $this;
    }

    /**
     * Get bod
     *
     * @return \DateTime
     */
    public function getBod()
    {
        return $this->bod;
    }

    /**
     * Set institute
     *
     * @param  string         $institute
     * @return EmployeeFamily
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
     * Set created
     *
     * @param  \DateTime      $created
     * @return EmployeeFamily
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
     * @param  string         $createdBy
     * @return EmployeeFamily
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
     * @param  \DateTime      $updated
     * @return EmployeeFamily
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
     * @param  string         $updatedBy
     * @return EmployeeFamily
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
     * @return EmployeeFamily
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
     * @return EmployeeFamily
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
}
