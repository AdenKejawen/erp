<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/Province.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 * - GatotKaca\Erp\MainBundle\Entity\Country
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_province")
 **/
class Province
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Country", inversedBy = "province")
     * @ORM\JoinColumn(name = "sys_country_id", referencedColumnName = "id")
     **/
    protected $country;

    /**
     * @ORM\Column(name = "`code`", type = "string", length = 33, nullable = true)
     **/
    protected $code;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 77, nullable = true)
     **/
    protected $name;

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
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy = "province_address")
     **/
    protected $employee;

    /**
     * @ORM\OneToMany(targetEntity = "District", mappedBy = "province")
     **/
    protected $district;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string   $id
     * @return Province
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
     * @param  string   $code
     * @return Province
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
     * @param  string   $name
     * @return Province
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
     * Set created
     *
     * @param  \DateTime $created
     * @return Province
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
     * @return Province
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
     * @return Province
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
     * @return Province
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
     * Set country
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Country $country
     * @return Province
     */
    public function setCountry(\GatotKaca\Erp\MainBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add employee
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     * @return Province
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
     * Add district
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\District $district
     * @return Province
     */
    public function addDistrict(\GatotKaca\Erp\MainBundle\Entity\District $district)
    {
        $this->district[] = $district;

        return $this;
    }

    /**
     * Remove district
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\District $district
     */
    public function removeDistrict(\GatotKaca\Erp\MainBundle\Entity\District $district)
    {
        $this->district->removeElement($district);
    }

    /**
     * Get district
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDistrict()
    {
        return $this->district;
    }
}
