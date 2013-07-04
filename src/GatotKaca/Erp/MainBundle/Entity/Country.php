<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/Country.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\MainBundle\Entity\Province
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_country")
 **/
class Country
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\Column(name = "`code`", type = "string", length = 3, nullable = true)
     **/
    protected $code;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 99, nullable = true)
     **/
    protected $name;

    /**
     * @ORM\Column(name = "`phonecode`", type = "string", length = 5, nullable = true)
     **/
    protected $phone_code;

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
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy = "citizen")
     **/
    protected $employee_citizen;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy = "country_address")
     **/
    protected $employee_country;

    /**
     * @ORM\OneToMany(targetEntity = "Province", mappedBy = "country")
     **/
    protected $province;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string  $id
     * @return Country
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
     * @return Country
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
     * @return Country
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
     * Set phone_code
     *
     * @param  string  $phoneCode
     * @return Country
     */
    public function setPhoneCode($phoneCode)
    {
        $this->phone_code = $phoneCode;

        return $this;
    }

    /**
     * Get phone_code
     *
     * @return string
     */
    public function getPhoneCode()
    {
        return $this->phone_code;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return Country
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
     * @return Country
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
     * @return Country
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
     * @return Country
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
     * Add employee_citizen
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCitizen
     * @return Country
     */
    public function addEmployeeCitizen(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCitizen)
    {
        $this->employee_citizen[] = $employeeCitizen;

        return $this;
    }

    /**
     * Remove employee_citizen
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCitizen
     */
    public function removeEmployeeCitizen(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCitizen)
    {
        $this->employee_citizen->removeElement($employeeCitizen);
    }

    /**
     * Get employee_citizen
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployeeCitizen()
    {
        return $this->employee_citizen;
    }

    /**
     * Add employee_country
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCountry
     * @return Country
     */
    public function addEmployeeCountry(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCountry)
    {
        $this->employee_country[] = $employeeCountry;

        return $this;
    }

    /**
     * Remove employee_country
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCountry
     */
    public function removeEmployeeCountry(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCountry)
    {
        $this->employee_country->removeElement($employeeCountry);
    }

    /**
     * Get employee_country
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployeeCountry()
    {
        return $this->employee_country;
    }

    /**
     * Add province
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Province $province
     * @return Country
     */
    public function addProvince(\GatotKaca\Erp\MainBundle\Entity\Province $province)
    {
        $this->province[] = $province;

        return $this;
    }

    /**
     * Remove province
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Province $province
     */
    public function removeProvince(\GatotKaca\Erp\MainBundle\Entity\Province $province)
    {
        $this->province->removeElement($province);
    }

    /**
     * Get province
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProvince()
    {
        return $this->province;
    }
}
