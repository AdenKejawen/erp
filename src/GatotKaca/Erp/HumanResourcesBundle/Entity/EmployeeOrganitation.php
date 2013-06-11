<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/EmployeeOrganitation.php
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
 * @ORM\Table(name = "trs_employee_organitation")
 **/
class EmployeeOrganitation{
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", inversedBy="employee")
	 * @ORM\JoinColumn(name="mtr_employee_id", referencedColumnName="id")
	 **/
	protected $employee;

    /**
     * @ORM\Column(type = "date", nullable = true)
     **/
    protected $org_start;
    
    /**
     * @ORM\Column(type = "date", nullable = true)
     **/
    protected $org_end;

    /**
     * @ORM\Column(type = "string", length = 77, nullable = true)
     **/
    protected $categories;

    /**
     * @ORM\Column(type = "string", length = 77, nullable = true)
     **/
    protected $position;

    /**
     * @ORM\Column(type = "string", length = 77, nullable = true)
     **/
    protected $name;

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
     * @return EmployeeOrganitation
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
     * Set org_start
     *
     * @param \DateTime $orgStart
     * @return EmployeeOrganitation
     */
    public function setOrgStart($orgStart)
    {
        $this->org_start = $orgStart;
    
        return $this;
    }

    /**
     * Get org_start
     *
     * @return \DateTime 
     */
    public function getOrgStart()
    {
        return $this->org_start;
    }

    /**
     * Set org_end
     *
     * @param \DateTime $orgEnd
     * @return EmployeeOrganitation
     */
    public function setOrgEnd($orgEnd)
    {
        $this->org_end = $orgEnd;
    
        return $this;
    }

    /**
     * Get org_end
     *
     * @return \DateTime 
     */
    public function getOrgEnd()
    {
        return $this->org_end;
    }

    /**
     * Set categories
     *
     * @param string $categories
     * @return EmployeeOrganitation
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    
        return $this;
    }

    /**
     * Get categories
     *
     * @return string 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return EmployeeOrganitation
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return EmployeeOrganitation
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
     * @param \DateTime $created
     * @return EmployeeOrganitation
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
     * @return EmployeeOrganitation
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
     * @return EmployeeOrganitation
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
     * @return EmployeeOrganitation
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
     * @return EmployeeOrganitation
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
}