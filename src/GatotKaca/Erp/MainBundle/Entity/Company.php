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
class Company{

    /**
     * @ORM\Id
     * @ORM\Column(type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Company", mappedBy="parent")
     **/
    protected $child;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="child")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @ORM\Column(type = "string", length = 7, unique = true, nullable = true)
     **/
    protected $code;

    /**
     * @ORM\Column(type = "string", length = 77, nullable = true)
     **/
    protected $name;

    /**
     * @ORM\Column(type = "integer", length = 1, nullable = true)
     **/
    Protected $workday_start;

    /**
     * @ORM\Column(type = "integer", length = 1, nullable = true)
     **/
    protected $workday_end;

    /**
     * @ORM\Column(type = "boolean", nullable = true)
     **/
    protected $isfixed;

    /**
     * @ORM\Column(type = "boolean", nullable = true)
     **/
    protected $istimebase;

     /**
     * @ORM\Column(type = "time", nullable = true)
     **/
    protected $officehour;

    /**
     * @ORM\Column(type = "boolean", nullable = true)
     **/
    protected $status;

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

    /**
     * @ORM\OneToMany(targetEntity="CompanyDepartment", mappedBy="company")
     **/
    protected $department;

    /**
     * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy="company")
     **/
    protected $employee;

    /**
     * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Career", mappedBy="old_company")
     **/
    protected $career_old_company;

    /**
     * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Career", mappedBy="new_company")
     **/
    protected $career_new_company;

    public function __construct(){
        $this->status   = TRUE;
        $this->isfixed  = TRUE;
        $this->created  = new \DateTime();
        $this->updated  = new \DateTime();
    }

    /**
     * Set id
     *
     * @param string $id
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
     * @param string $code
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
     * @param string $name
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
     * Set workday_start
     *
     * @param integer $workdayStart
     * @return Company
     */
    public function setWorkdayStart($workdayStart)
    {
        $this->workday_start = $workdayStart;

        return $this;
    }

    /**
     * Get workday_start
     *
     * @return integer
     */
    public function getWorkdayStart()
    {
        return $this->workday_start;
    }

    /**
     * Set workday_end
     *
     * @param integer $workdayEnd
     * @return Company
     */
    public function setWorkdayEnd($workdayEnd)
    {
        $this->workday_end = $workdayEnd;

        return $this;
    }

    /**
     * Get workday_end
     *
     * @return integer
     */
    public function getWorkdayEnd()
    {
        return $this->workday_end;
    }

    /**
     * Set isfixed
     *
     * @param boolean $isfixed
     * @return Company
     */
    public function setIsfixed($isfixed)
    {
        $this->isfixed = $isfixed;

        return $this;
    }

    /**
     * Get isfixed
     *
     * @return boolean
     */
    public function getIsfixed()
    {
        return $this->isfixed;
    }

    /**
     * Set status
     *
     * @param boolean $status
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
     * @param \DateTime $created
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
     * Set createdby
     *
     * @param string $createdby
     * @return Company
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
     * Set updatedby
     *
     * @param string $updatedby
     * @return Company
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
     * Add child
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Company $child
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
     * @param \GatotKaca\Erp\MainBundle\Entity\Company $parent
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
     * @param \GatotKaca\Erp\MainBundle\Entity\CompanyDepartment $department
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
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
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
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldCompany
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
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewCompany
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

    /**
     * Set istimebase
     *
     * @param boolean $istimebase
     * @return Company
     */
    public function setIstimebase($istimebase)
    {
        $this->istimebase = $istimebase;
    
        return $this;
    }

    /**
     * Get istimebase
     *
     * @return boolean 
     */
    public function getIstimebase()
    {
        return $this->istimebase;
    }

    /**
     * Set officehour
     *
     * @param \DateTime $officehour
     * @return Company
     */
    public function setOfficehour($officehour)
    {
        $this->officehour = $officehour;
    
        return $this;
    }

    /**
     * Get officehour
     *
     * @return \DateTime 
     */
    public function getOfficehour()
    {
        return $this->officehour;
    }
}