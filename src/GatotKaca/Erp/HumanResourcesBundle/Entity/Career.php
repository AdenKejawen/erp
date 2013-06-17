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
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Family
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "trs_employee_career")
 **/
class Career{
    /**
     * @ORM\Id
     * @ORM\Column(type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="career")
     * @ORM\JoinColumn(name="mtr_employee_id", referencedColumnName="id")
     **/
    protected $employee;

    /**
     * @ORM\Column(type = "string", length = 27)
     **/
    protected $refno;

    /**
     * @ORM\Column(type = "date")
     **/
    protected $promote;

    /**
     * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Company", inversedBy="career_old_company")
     * @ORM\JoinColumn(name="old_company", referencedColumnName="id")
     **/
    protected $old_company;

    /**
     * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Company", inversedBy="career_new_company")
     * @ORM\JoinColumn(name="new_company", referencedColumnName="id")
     **/
    protected $new_company;

    /**
     * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\JobTitle", inversedBy="career_old_jobtitle")
     * @ORM\JoinColumn(name="old_jobtitle", referencedColumnName="id")
     **/
    protected $old_jobtitle;

    /**
     * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\JobTitle", inversedBy="career_new_jobtitle")
     * @ORM\JoinColumn(name="new_jobtitle", referencedColumnName="id")
     **/
    protected $new_jobtitle;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="career_old_supervisor")
     * @ORM\JoinColumn(name="old_supervisor", referencedColumnName="id")
     **/
    protected $old_supervisor;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="career_new_supervisor")
     * @ORM\JoinColumn(name="new_supervisor", referencedColumnName="id")
     **/
    protected $new_supervisor;

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
        $this->created    = new \DateTime();
        $this->updated    = new \DateTime();
    }

    /**
     * Set id
     *
     * @param string $id
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
     * Set refno
     *
     * @param string $refno
     * @return Career
     */
    public function setRefno($refno)
    {
        $this->refno = $refno;

        return $this;
    }

    /**
     * Get refno
     *
     * @return string
     */
    public function getRefno()
    {
        return $this->refno;
    }

    /**
     * Set promote
     *
     * @param \DateTime $promote
     * @return Career
     */
    public function setPromote($promote)
    {
        $this->promote = $promote;

        return $this;
    }

    /**
     * Get promote
     *
     * @return \DateTime
     */
    public function getPromote()
    {
        return $this->promote;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
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
     * Set createdby
     *
     * @param string $createdby
     * @return Career
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
     * Set updatedby
     *
     * @param string $updatedby
     * @return Career
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
     * @param \GatotKaca\Erp\MainBundle\Entity\Company $oldCompany
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
     * @param \GatotKaca\Erp\MainBundle\Entity\Company $newCompany
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
     * Set old_jobtitle
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\JobTitle $oldJobtitle
     * @return Career
     */
    public function setOldJobtitle(\GatotKaca\Erp\MainBundle\Entity\JobTitle $oldJobtitle = null)
    {
        $this->old_jobtitle = $oldJobtitle;

        return $this;
    }

    /**
     * Get old_jobtitle
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobTitle
     */
    public function getOldJobtitle()
    {
        return $this->old_jobtitle;
    }

    /**
     * Set new_jobtitle
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\JobTitle $newJobtitle
     * @return Career
     */
    public function setNewJobtitle(\GatotKaca\Erp\MainBundle\Entity\JobTitle $newJobtitle = null)
    {
        $this->new_jobtitle = $newJobtitle;

        return $this;
    }

    /**
     * Get new_jobtitle
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobTitle
     */
    public function getNewJobtitle()
    {
        return $this->new_jobtitle;
    }

    /**
     * Set old_supervisor
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $oldSupervisor
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
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $newSupervisor
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
