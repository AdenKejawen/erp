<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/Education.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_education")
 **/
class Education
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\Column(name = "`level`", type = "integer", length = 2, unique = true, nullable = true)
     **/
    protected $level;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 17, nullable = true)
     **/
    protected $name;

    /**
     * @ORM\Column(name = "`status`", type = "boolean")
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
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation", mappedBy = "education")
     **/
    protected $employee_education;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily", mappedBy = "education")
     **/
    protected $family;

    public function __construct()
    {
        $this->status  = true;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string    $id
     * @return Education
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
     * Set level
     *
     * @param  integer   $level
     * @return Education
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set name
     *
     * @param  string    $name
     * @return Education
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
     * @param  boolean   $status
     * @return Education
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
     * @return Education
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
     * @param  string    $createdBy
     * @return Education
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
     * @return Education
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
     * @param  string    $updatedBy
     * @return Education
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
     * Add employee_education
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employeeEducation
     * @return Education
     */
    public function addEmployeeEducation(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employeeEducation)
    {
        $this->employee_education[] = $employeeEducation;

        return $this;
    }

    /**
     * Remove employee_education
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employeeEducation
     */
    public function removeEmployeeEducation(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $employeeEducation)
    {
        $this->employee_education->removeElement($employeeEducation);
    }

    /**
     * Get employee_education
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployeeEducation()
    {
        return $this->employee_education;
    }

    /**
     * Add family
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family
     * @return Education
     */
    public function addFamily(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family)
    {
        $this->family[] = $family;

        return $this;
    }

    /**
     * Remove family
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family
     */
    public function removeFamily(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family)
    {
        $this->family->removeElement($family);
    }

    /**
     * Get family
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFamily()
    {
        return $this->family;
    }
}
