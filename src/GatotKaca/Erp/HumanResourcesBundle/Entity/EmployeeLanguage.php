<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/EmployeeLanguage.php
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
 * @ORM\Table(name = "trs_employee_language")
 **/
class EmployeeLanguage
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Employee", inversedBy = "language")
     * @ORM\JoinColumn(name = "mtr_employee_id", referencedColumnName = "id")
     **/
    protected $employee;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Language", inversedBy = "employee")
     * @ORM\JoinColumn(name = "sys_language_id", referencedColumnName = "id")
     **/
    protected $language;

    /**
     * 1 = EXCELLENT
     * 2 = GOOD
     * 3 = FAIR
     *
     * @ORM\Column(name = "`spoken`", type = "integer", nullable = true)
     **/
    protected $spoken;

    /**
     * 1 = EXCELLENT
     * 2 = GOOD
     * 3 = FAIR
     *
     * @ORM\Column(name = "`writen`", type = "integer", nullable = true)
     **/
    protected $writen;

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
     * @return EmployeeLanguage
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
     * Set spoken
     *
     * @param  integer          $spoken
     * @return EmployeeLanguage
     */
    public function setSpoken($spoken)
    {
        $this->spoken = $spoken;

        return $this;
    }

    /**
     * Get spoken
     *
     * @return integer
     */
    public function getSpoken()
    {
        return $this->spoken;
    }

    /**
     * Set writen
     *
     * @param  integer          $writen
     * @return EmployeeLanguage
     */
    public function setWriten($writen)
    {
        $this->writen = $writen;

        return $this;
    }

    /**
     * Get writen
     *
     * @return integer
     */
    public function getWriten()
    {
        return $this->writen;
    }

    /**
     * Set created
     *
     * @param  \DateTime        $created
     * @return EmployeeLanguage
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
     * @return EmployeeLanguage
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
     * @return EmployeeLanguage
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
     * @return EmployeeLanguage
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
     * @return EmployeeLanguage
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
     * Set language
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Language $language
     * @return EmployeeLanguage
     */
    public function setLanguage(\GatotKaca\Erp\MainBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
