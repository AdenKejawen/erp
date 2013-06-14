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
class Country{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\Column(type = "string", length = 3, nullable = true)
	 **/
	protected $code;

	/**
	 * @ORM\Column(type = "string", length = 99, nullable = true)
	 **/
	protected $name;

	/**
	 * @ORM\Column(type = "string", length = 5, nullable = true)
	 **/
	protected $phonecode;

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
	 * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy="citizen")
	 **/
	protected $employee_citizen;

	/**
	 * @ORM\OneToMany(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy="country")
	 **/
	protected $employee_country;

	/**
	 * @ORM\OneToMany(targetEntity="Province", mappedBy="country")
	 **/
	protected $province;

	public function __construct(){
		$this->created	= new \DateTime();
		$this->updated	= new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
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
     * @param string $code
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
     * @param string $name
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
     * Set phonecode
     *
     * @param string $phonecode
     * @return Country
     */
    public function setPhonecode($phonecode)
    {
        $this->phonecode = $phonecode;
    
        return $this;
    }

    /**
     * Get phonecode
     *
     * @return string 
     */
    public function getPhonecode()
    {
        return $this->phonecode;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
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
     * Set createdby
     *
     * @param string $createdby
     * @return Country
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
     * Set updatedby
     *
     * @param string $updatedby
     * @return Country
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
     * Add employee_citizen
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCitizen
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
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employeeCountry
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
     * @param \GatotKaca\Erp\MainBundle\Entity\Province $province
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