<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/JobTitle.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\MainBundle\Entity\JobLevel
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_jobtitle")
 **/
class JobTitle
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity = "JobTitle", mappedBy = "parent")
     **/
    protected $child;

    /**
     * @ORM\ManyToOne(targetEntity = "JobTitle", inversedBy = "child")
     * @ORM\JoinColumn(name = "parent_id", referencedColumnName = "id")
     */
    protected $parent;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 77, nullable = true)
     **/
    protected $name;

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
     * @ORM\ManyToOne(targetEntity ="JobLevel", inversedBy = "jobtitle")
     * @ORM\JoinColumn(name ="sys_joblevel_id", referencedColumnName = "id")
     */
    protected $level;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy = "job_title")
     **/
    protected $employee;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Career", mappedBy = "old_job_title")
     **/
    protected $career_old_job_title;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Career", mappedBy = "new_job_title")
     **/
    protected $career_new_job_title;

    public function __construct()
    {
        $this->status  = true;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string   $id
     * @return JobTitle
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
     * @param  string   $name
     * @return JobTitle
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
     * Set status
     *
     * @param  boolean  $status
     * @return JobTitle
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
     * @return JobTitle
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
     * @param  string   $createdBy
     * @return JobTitle
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
     * @return JobTitle
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
     * @param  string   $updatedBy
     * @return JobTitle
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\JobTitle $child
     * @return JobTitle
     */
    public function addChild(\GatotKaca\Erp\MainBundle\Entity\JobTitle $child)
    {
        $this->child[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\JobTitle $child
     */
    public function removeChild(\GatotKaca\Erp\MainBundle\Entity\JobTitle $child)
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\JobTitle $parent
     * @return JobTitle
     */
    public function setParent(\GatotKaca\Erp\MainBundle\Entity\JobTitle $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobTitle
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set level
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\JobLevel $level
     * @return JobTitle
     */
    public function setLevel(\GatotKaca\Erp\MainBundle\Entity\JobLevel $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobLevel
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Add employee
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     * @return JobTitle
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
     * Add career_old_job_title
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldJobTitle
     * @return JobTitle
     */
    public function addCareerOldJobTitle(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldJobTitle)
    {
        $this->career_old_job_title[] = $careerOldJobTitle;

        return $this;
    }

    /**
     * Remove career_old_job_title
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldJobTitle
     */
    public function removeCareerOldJobTitle(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldJobTitle)
    {
        $this->career_old_job_title->removeElement($careerOldJobTitle);
    }

    /**
     * Get career_old_job_title
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCareerOldJobTitle()
    {
        return $this->career_old_job_title;
    }

    /**
     * Add career_new_job_title
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewJobTitle
     * @return JobTitle
     */
    public function addCareerNewJobTitle(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewJobTitle)
    {
        $this->career_new_job_title[] = $careerNewJobTitle;

        return $this;
    }

    /**
     * Remove career_new_job_title
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewJobTitle
     */
    public function removeCareerNewJobTitle(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewJobTitle)
    {
        $this->career_new_job_title->removeElement($careerNewJobTitle);
    }

    /**
     * Get career_new_job_title
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCareerNewJobTitle()
    {
        return $this->career_new_job_title;
    }
}
