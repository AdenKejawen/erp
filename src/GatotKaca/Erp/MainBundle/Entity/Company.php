<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/Company.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping : GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_company")
 **/
class Company
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Company", mappedBy="parent")
     **/
    protected $child;

    /**
     * @ORM\ManyToOne(targetEntity = "Company", inversedBy = "child")
     * @ORM\JoinColumn(name = "parent_id", referencedColumnName = "id")
     */
    protected $parent;

    /**
     * @ORM\Column(name = "`code`", type = "string", length = 7, unique = true, nullable = true)
     **/
    protected $code;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 77, nullable = true)
     **/
    protected $name;

    /**
     * @ORM\Column(name = "`workday_start`", type = "integer", length = 1, nullable = true)
     **/
    protected $work_day_start;

    /**
     * @ORM\Column(name = "`workday_end`", type = "integer", length = 1, nullable = true)
     **/
    protected $work_day_end;

    /**
     * @ORM\Column(name = "`isfixed`", type = "boolean", nullable = true)
     **/
    protected $is_fixed;

    /**
     * @ORM\Column(name = "`istimebase`", type = "boolean", nullable = true)
     **/
    protected $is_time_base;

     /**
     * @ORM\Column(name = "`officehour`", type = "time", nullable = true)
     **/
    protected $office_hour;

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
     * @ORM\OneToMany(targetEntity = "CompanyDepartment", mappedBy = "company")
     **/
    protected $department;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy = "company")
     **/
    protected $employee;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Career", mappedBy = "old_company")
     **/
    protected $career_old_company;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Career", mappedBy = "new_company")
     **/
    protected $career_new_company;

    public function __construct()
    {
        $this->status   = true;
        $this->is_fixed = true;
        $this->created  = new \DateTime();
        $this->updated  = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string  $id
     * @return Company
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
     * Set code
     *
     * @param  string  $code
     * @return Company
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return Company
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
     * Set work_day_start
     *
     * @param  integer $workDayStart
     * @return Company
     */
    public function setWorkDayStart($workDayStart)
    {
        $this->work_day_start = $workDayStart;

        return $this;
    }

    /**
     * Get work_day_start
     *
     * @return integer
     */
    public function getWorkDayStart()
    {
        return $this->work_day_start;
    }

    /**
     * Set work_day_end
     *
     * @param  integer $workDayEnd
     * @return Company
     */
    public function setWorkDayEnd($workDayEnd)
    {
        $this->work_day_end = $workDayEnd;

        return $this;
    }

    /**
     * Get work_day_end
     *
     * @return integer
     */
    public function getWorkDayEnd()
    {
        return $this->work_day_end;
    }

    /**
     * Set is_fixed
     *
     * @param  boolean $isFixed
     * @return Company
     */
    public function setIsFixed($isFixed)
    {
        $this->is_fixed = $isFixed;

        return $this;
    }

    /**
     * Get is_fixed
     *
     * @return boolean
     */
    public function getIsFixed()
    {
        return $this->is_fixed;
    }

    /**
     * Set is_time_base
     *
     * @param  boolean $isTimeBase
     * @return Company
     */
    public function setIsTimeBase($isTimeBase)
    {
        $this->is_time_base = $isTimeBase;

        return $this;
    }

    /**
     * Get is_time_base
     *
     * @return boolean
     */
    public function getIsTimeBase()
    {
        return $this->is_time_base;
    }

    /**
     * Set office_hour
     *
     * @param  \DateTime $officeHour
     * @return Company
     */
    public function setOfficeHour($officeHour)
    {
        $this->office_hour = $officeHour;

        return $this;
    }

    /**
     * Get office_hour
     *
     * @return \DateTime
     */
    public function getOfficeHour()
    {
        return $this->office_hour;
    }

    /**
     * Set status
     *
     * @param  boolean $status
     * @return Company
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
     * @param  \DateTime $created
     * @return Company
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
     * @param  string  $createdBy
     * @return Company
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
     * @param  \DateTime $updated
     * @return Company
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
     * @param  string  $updatedBy
     * @return Company
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
     * Add child
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Company $child
     * @return Company
     */
    public function addChild(\GatotKaca\Erp\MainBundle\Entity\Company $child)
    {
        $this->child[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Company $child
     */
    public function removeChild(\GatotKaca\Erp\MainBundle\Entity\Company $child)
    {
        $this->child->removeElement($child);
    }

    /**
     * Get child
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Set parent
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Company $parent
     * @return Company
     */
    public function setParent(\GatotKaca\Erp\MainBundle\Entity\Company $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Company
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add department
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\CompanyDepartment $department
     * @return Company
     */
    public function addDepartment(\GatotKaca\Erp\MainBundle\Entity\CompanyDepartment $department)
    {
        $this->department[] = $department;

        return $this;
    }

    /**
     * Remove department
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\CompanyDepartment $department
     */
    public function removeDepartment(\GatotKaca\Erp\MainBundle\Entity\CompanyDepartment $department)
    {
        $this->department->removeElement($department);
    }

    /**
     * Get department
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Add employee
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     * @return Company
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
     * Add career_old_company
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldCompany
     * @return Company
     */
    public function addCareerOldCompany(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldCompany)
    {
        $this->career_old_company[] = $careerOldCompany;

        return $this;
    }

    /**
     * Remove career_old_company
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldCompany
     */
    public function removeCareerOldCompany(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldCompany)
    {
        $this->career_old_company->removeElement($careerOldCompany);
    }

    /**
     * Get career_old_company
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCareerOldCompany()
    {
        return $this->career_old_company;
    }

    /**
     * Add career_new_company
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewCompany
     * @return Company
     */
    public function addCareerNewCompany(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewCompany)
    {
        $this->career_new_company[] = $careerNewCompany;

        return $this;
    }

    /**
     * Remove career_new_company
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewCompany
     */
    public function removeCareerNewCompany(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewCompany)
    {
        $this->career_new_company->removeElement($careerNewCompany);
    }

    /**
     * Get career_new_company
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCareerNewCompany()
    {
        return $this->career_new_company;
    }
}
