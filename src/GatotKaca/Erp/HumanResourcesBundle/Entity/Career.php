<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/Career.php
 * Author    : Muhammad Surya Ikhsanudin
 * License   : Protected
 * Email     : mutofiyah@gmail.com
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
 * @ORM\Table(name = "trs_employee_career")
 **/
class Career
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Employee", inversedBy = "career")
     * @ORM\JoinColumn(name = "mtr_employee_id", referencedColumnName = "id")
     **/
    protected $employee;

    /**
     * @ORM\Column(name = "`refno`", type = "string", length = 27, nullable = true)
     **/
    protected $reference_number;

    /**
     * @ORM\Column(name = "`promote`", type = "date", nullable = true)
     **/
    protected $promote_date;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Company", inversedBy = "career_old_company")
     * @ORM\JoinColumn(name = "old_company", referencedColumnName = "id")
     **/
    protected $old_company;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Company", inversedBy = "career_new_company")
     * @ORM\JoinColumn(name = "new_company", referencedColumnName = "id")
     **/
    protected $new_company;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\JobTitle", inversedBy = "career_old_job_title")
     * @ORM\JoinColumn(name = "old_jobtitle", referencedColumnName = "id")
     **/
    protected $old_job_title;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\JobTitle", inversedBy = "career_new_job_title")
     * @ORM\JoinColumn(name = "new_jobtitle", referencedColumnName = "id")
     **/
    protected $new_job_title;

    /**
     * @ORM\ManyToOne(targetEntity = "Employee", inversedBy = "career_old_supervisor")
     * @ORM\JoinColumn(name = "old_supervisor", referencedColumnName = "id")
     **/
    protected $old_supervisor;

    /**
     * @ORM\ManyToOne(targetEntity = "Employee", inversedBy = "career_new_supervisor")
     * @ORM\JoinColumn(name = "new_supervisor", referencedColumnName = "id")
     **/
    protected $new_supervisor;

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
     * @param  string $id
     * @return Career
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
     * Set reference_number
     *
     * @param  string $referenceNumber
     * @return Career
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->reference_number = $referenceNumber;

        return $this;
    }

    /**
     * Get reference_number
     *
     * @return string
     */
    public function getReferenceNumber()
    {
        return $this->reference_number;
    }

    /**
     * Set promote_date
     *
     * @param  \DateTime $promoteDate
     * @return Career
     */
    public function setPromoteDate($promoteDate)
    {
        $this->promote_date = $promoteDate;

        return $this;
    }

    /**
     * Get promote_date
     *
     * @return \DateTime
     */
    public function getPromoteDate()
    {
        return $this->promote_date;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return Career
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
     * @param  string $createdBy
     * @return Career
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
     * @return Career
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
     * @param  string $updatedBy
     * @return Career
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
     * @return Career
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
     * Set old_company
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Company $oldCompany
     * @return Career
     */
    public function setOldCompany(\GatotKaca\Erp\MainBundle\Entity\Company $oldCompany = null)
    {
        $this->old_company = $oldCompany;

        return $this;
    }

    /**
     * Get old_company
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Company
     */
    public function getOldCompany()
    {
        return $this->old_company;
    }

    /**
     * Set new_company
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Company $newCompany
     * @return Career
     */
    public function setNewCompany(\GatotKaca\Erp\MainBundle\Entity\Company $newCompany = null)
    {
        $this->new_company = $newCompany;

        return $this;
    }

    /**
     * Get new_company
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Company
     */
    public function getNewCompany()
    {
        return $this->new_company;
    }

    /**
     * Set old_job_title
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\JobTitle $oldJobTitle
     * @return Career
     */
    public function setOldJobTitle(\GatotKaca\Erp\MainBundle\Entity\JobTitle $oldJobTitle = null)
    {
        $this->old_job_title = $oldJobTitle;

        return $this;
    }

    /**
     * Get old_job_title
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobTitle
     */
    public function getOldJobTitle()
    {
        return $this->old_job_title;
    }

    /**
     * Set new_job_title
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\JobTitle $newJobTitle
     * @return Career
     */
    public function setNewJobTitle(\GatotKaca\Erp\MainBundle\Entity\JobTitle $newJobTitle = null)
    {
        $this->new_job_title = $newJobTitle;

        return $this;
    }

    /**
     * Get new_job_title
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobTitle
     */
    public function getNewJobTitle()
    {
        return $this->new_job_title;
    }

    /**
     * Set old_supervisor
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $oldSupervisor
     * @return Career
     */
    public function setOldSupervisor(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $oldSupervisor = null)
    {
        $this->old_supervisor = $oldSupervisor;

        return $this;
    }

    /**
     * Get old_supervisor
     *
     * @return \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
     */
    public function getOldSupervisor()
    {
        return $this->old_supervisor;
    }

    /**
     * Set new_supervisor
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $newSupervisor
     * @return Career
     */
    public function setNewSupervisor(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $newSupervisor = null)
    {
        $this->new_supervisor = $newSupervisor;

        return $this;
    }

    /**
     * Get new_supervisor
     *
     * @return \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
     */
    public function getNewSupervisor()
    {
        return $this->new_supervisor;
    }
}
