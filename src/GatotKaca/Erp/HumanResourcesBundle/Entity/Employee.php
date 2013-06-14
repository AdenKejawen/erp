<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Entity/Employee.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\MainBundle\Entity\Department
 * - GatotKaca\Erp\UtilitiesBundle\Entity\User
 * - GatotKaca\Erp\MainBundle\Entity\District
 * - GatotKaca\Erp\MainBundle\Entity\Province
 * - GatotKaca\Erp\MainBundle\Entity\Country
 * - GatotKaca\Erp\MainBundle\Entity\Religion
 * - GatotKaca\Erp\MainBundle\Entity\OfficeHour
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOvertime
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Career
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "mtr_employee")
 **/
class Employee{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Company", inversedBy="employee")
	 * @ORM\JoinColumn(name="sys_company_id", referencedColumnName="id")
	 **/
	protected $company;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Department", inversedBy="employee")
	 * @ORM\JoinColumn(name="sys_department_id", referencedColumnName="id")
	 **/
	protected $department;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\JobTitle", inversedBy="employee")
	 * @ORM\JoinColumn(name="sys_jobtitle_id", referencedColumnName="id")
	 **/
	protected $jobtitle;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\JobStatus", inversedBy="employee")
	 * @ORM\JoinColumn(name="sys_jobstatus_id", referencedColumnName="id")
	 **/
	protected $jobstatus;

    /**
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="supervisor")
     **/
    protected $child;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="child")
     * @ORM\JoinColumn(name="supervisor", referencedColumnName="id")
     */
    protected $supervisor;

	/**
	 * @ORM\Column(type = "string", length = 17, unique = true, nullable = true)
	 **/
	protected $code;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = true)
     **/
    protected $photo;

	/**
	 * @ORM\Column(type = "string", length = 27, unique = true, nullable = true)
	 **/
	protected $idcard;

	/**
	 * @ORM\Column(type = "string", length = 33, nullable = true)
	 **/
	protected $fname;

	/**
	 * @ORM\Column(type = "string", length = 33, nullable = true)
	 **/
	protected $lname;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\UtilitiesBundle\Entity\User", inversedBy="employee")
	 * @ORM\JoinColumn(name="utl_user_id", referencedColumnName="id")
	 **/
	protected $username;

	/**
	 * @ORM\Column(type = "integer", length = 1, nullable = true)
	 *
	 * - 1 = male
	 * - 2 = female
	 **/
	protected $gender;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\District", inversedBy="employee_bod_place")
	 * @ORM\JoinColumn(name="bod_place", referencedColumnName="id")
	 **/
	protected $bod_place;

	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $bod;

	/**
	 * @ORM\Column(type = "string", length = 255, nullable = true)
	 **/
	protected $address;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\District", inversedBy="employee")
	 * @ORM\JoinColumn(name="district", referencedColumnName="id")
	 **/
	protected $district_address;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Province", inversedBy="employee")
	 * @ORM\JoinColumn(name="province", referencedColumnName="id")
	 **/
	protected $province_address;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Country", inversedBy="employee_country")
	 * @ORM\JoinColumn(name="country", referencedColumnName="id")
	 **/
	protected $country;

    /**
     * @ORM\Column(type = "string", length = 7, nullable = true)
     **/
    protected $postalcode;

    /**
     * @ORM\Column(type = "string", length = 12, nullable = true)
     **/
    protected $phone;

    /**
     * @ORM\Column(type = "string", length = 27, nullable = true)
     **/
    protected $email;

    /**
     * @ORM\Column(type = "string", length = 255, nullable = true)
     **/
    protected $mailaddress;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Country", inversedBy="employee_citizen")
	 * @ORM\JoinColumn(name="citizen", referencedColumnName="id")
	 **/
	protected $citizen;

	/**
	 * @ORM\Column(type = "string", length = 2, nullable = true)
	 **/
	protected $blood_type;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\Religion", inversedBy="employee")
	 * @ORM\JoinColumn(name="religion", referencedColumnName="id")
	 **/
	protected $religion;

	/**
	 * @ORM\Column(type = "integer", length = 1, nullable = true)
	 *
	 * - 1 = single
	 * - 2 = married
	 * - 3 = divorced
	 **/
	protected $marital_status;

	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $hire;

	/**
	 * @ORM\Column(type = "date", nullable = true)
	 **/
	protected $expire;

	/**
	 * @ORM\Column(type = "string", length = 27, nullable = true)
	 **/
	protected $tax;

	/**
	 * @ORM\Column(type = "string", length = 27, nullable = true)
	 **/
	protected $bank;

	/**
	 * @ORM\ManyToOne(targetEntity="GatotKaca\Erp\MainBundle\Entity\OfficeHour", inversedBy="employee")
	 * @ORM\JoinColumn(name="sys_officehour_id", referencedColumnName="id")
	 **/
	protected $shift;

	/**
	 * @ORM\Column(type = "boolean", nullable = true)
	 **/
	protected $isfixed;

    /**
     * @ORM\Column(type = "boolean", nullable = true)
     **/
    protected $isovertime;

    /**
     * @ORM\Column(type = "boolean", nullable = true)
     **/
    protected $ismanualovertime;

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
	 * @ORM\OneToMany(targetEntity="Attendance", mappedBy="employee")
	 **/
	protected $attendance;

	/**
	 * @ORM\OneToMany(targetEntity="EmployeeEducation", mappedBy="employee")
	 **/
	protected $education;

    /**
     * @ORM\OneToMany(targetEntity="EmployeeExperience", mappedBy="employee")
     **/
    protected $experience;

	/**
	 * @ORM\OneToMany(targetEntity="EmployeeFamily", mappedBy="employee")
	 **/
	protected $family;

    /**
     * @ORM\OneToMany(targetEntity="EmployeeLanguage", mappedBy="employee")
     **/
    protected $language;

    /**
     * @ORM\OneToMany(targetEntity="EmployeeOrganitation", mappedBy="employee")
     **/
    protected $organitation;

    /**
     * @ORM\OneToMany(targetEntity="EmployeeOvertime", mappedBy="employee")
     **/
    protected $overtime;

    /**
     * @ORM\OneToMany(targetEntity="EmployeeOvertime", mappedBy="approvedby")
     **/
    protected $overtime_approvedby;

    /**
     * @ORM\OneToMany(targetEntity="EmployeeShiftment", mappedBy="employee")
     **/
    protected $shiftment;

    /**
     * @ORM\OneToMany(targetEntity="EmployeeTraining", mappedBy="employee")
     **/
    protected $training;

    /**
     * @ORM\OneToMany(targetEntity="Career", mappedBy="employee")
     **/
    protected $career;

    /**
     * @ORM\OneToMany(targetEntity="Career", mappedBy="old_supervisor")
     **/
    protected $career_old_supervisor;

    /**
     * @ORM\OneToMany(targetEntity="Career", mappedBy="new_supervisor")
     **/
    protected $career_new_supervisor;

	public function __construct(){
		$this->status     = TRUE;
		$this->isfixed    = TRUE;
        $this->isovertime = FALSE;
        $this->ismanualovertime = FALSE;
		$this->expire     = new \DateTime('1970-01-01');
		$this->created    = new \DateTime();
		$this->updated    = new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return Employee
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
     * @return Employee
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
     * Set photo
     *
     * @param string $photo
     * @return Employee
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    
        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set idcard
     *
     * @param string $idcard
     * @return Employee
     */
    public function setIdcard($idcard)
    {
        $this->idcard = $idcard;
    
        return $this;
    }

    /**
     * Get idcard
     *
     * @return string 
     */
    public function getIdcard()
    {
        return $this->idcard;
    }

    /**
     * Set fname
     *
     * @param string $fname
     * @return Employee
     */
    public function setFname($fname)
    {
        $this->fname = $fname;
    
        return $this;
    }

    /**
     * Get fname
     *
     * @return string 
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     * @return Employee
     */
    public function setLname($lname)
    {
        $this->lname = $lname;
    
        return $this;
    }

    /**
     * Get lname
     *
     * @return string 
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     * @return Employee
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return integer 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set bod
     *
     * @param \DateTime $bod
     * @return Employee
     */
    public function setBod($bod)
    {
        $this->bod = $bod;
    
        return $this;
    }

    /**
     * Get bod
     *
     * @return \DateTime 
     */
    public function getBod()
    {
        return $this->bod;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Employee
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postalcode
     *
     * @param string $postalcode
     * @return Employee
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
    
        return $this;
    }

    /**
     * Get postalcode
     *
     * @return string 
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Employee
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Employee
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mailaddress
     *
     * @param string $mailaddress
     * @return Employee
     */
    public function setMailaddress($mailaddress)
    {
        $this->mailaddress = $mailaddress;
    
        return $this;
    }

    /**
     * Get mailaddress
     *
     * @return string 
     */
    public function getMailaddress()
    {
        return $this->mailaddress;
    }

    /**
     * Set blood_type
     *
     * @param string $bloodType
     * @return Employee
     */
    public function setBloodType($bloodType)
    {
        $this->blood_type = $bloodType;
    
        return $this;
    }

    /**
     * Get blood_type
     *
     * @return string 
     */
    public function getBloodType()
    {
        return $this->blood_type;
    }

    /**
     * Set marital_status
     *
     * @param integer $maritalStatus
     * @return Employee
     */
    public function setMaritalStatus($maritalStatus)
    {
        $this->marital_status = $maritalStatus;
    
        return $this;
    }

    /**
     * Get marital_status
     *
     * @return integer 
     */
    public function getMaritalStatus()
    {
        return $this->marital_status;
    }

    /**
     * Set hire
     *
     * @param \DateTime $hire
     * @return Employee
     */
    public function setHire($hire)
    {
        $this->hire = $hire;
    
        return $this;
    }

    /**
     * Get hire
     *
     * @return \DateTime 
     */
    public function getHire()
    {
        return $this->hire;
    }

    /**
     * Set expire
     *
     * @param \DateTime $expire
     * @return Employee
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;
    
        return $this;
    }

    /**
     * Get expire
     *
     * @return \DateTime 
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Set tax
     *
     * @param string $tax
     * @return Employee
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    
        return $this;
    }

    /**
     * Get tax
     *
     * @return string 
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set bank
     *
     * @param string $bank
     * @return Employee
     */
    public function setBank($bank)
    {
        $this->bank = $bank;
    
        return $this;
    }

    /**
     * Get bank
     *
     * @return string 
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set isfixed
     *
     * @param boolean $isfixed
     * @return Employee
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
     * Set isovertime
     *
     * @param boolean $isovertime
     * @return Employee
     */
    public function setIsovertime($isovertime)
    {
        $this->isovertime = $isovertime;
    
        return $this;
    }

    /**
     * Get isovertime
     *
     * @return boolean 
     */
    public function getIsovertime()
    {
        return $this->isovertime;
    }

    /**
     * Set ismanualovertime
     *
     * @param boolean $ismanualovertime
     * @return Employee
     */
    public function setIsmanualovertime($ismanualovertime)
    {
        $this->ismanualovertime = $ismanualovertime;
    
        return $this;
    }

    /**
     * Get ismanualovertime
     *
     * @return boolean 
     */
    public function getIsmanualovertime()
    {
        return $this->ismanualovertime;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * Set company
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Company $company
     * @return Employee
     */
    public function setCompany(\GatotKaca\Erp\MainBundle\Entity\Company $company = null)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set department
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Department $department
     * @return Employee
     */
    public function setDepartment(\GatotKaca\Erp\MainBundle\Entity\Department $department = null)
    {
        $this->department = $department;
    
        return $this;
    }

    /**
     * Get department
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Department 
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set jobtitle
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\JobTitle $jobtitle
     * @return Employee
     */
    public function setJobtitle(\GatotKaca\Erp\MainBundle\Entity\JobTitle $jobtitle = null)
    {
        $this->jobtitle = $jobtitle;
    
        return $this;
    }

    /**
     * Get jobtitle
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobTitle 
     */
    public function getJobtitle()
    {
        return $this->jobtitle;
    }

    /**
     * Set jobstatus
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\JobStatus $jobstatus
     * @return Employee
     */
    public function setJobstatus(\GatotKaca\Erp\MainBundle\Entity\JobStatus $jobstatus = null)
    {
        $this->jobstatus = $jobstatus;
    
        return $this;
    }

    /**
     * Get jobstatus
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobStatus 
     */
    public function getJobstatus()
    {
        return $this->jobstatus;
    }

    /**
     * Add child
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $child
     * @return Employee
     */
    public function addChild(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $child)
    {
        $this->child[] = $child;
    
        return $this;
    }

    /**
     * Remove child
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $child
     */
    public function removeChild(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $child)
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
     * Set supervisor
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $supervisor
     * @return Employee
     */
    public function setSupervisor(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $supervisor = null)
    {
        $this->supervisor = $supervisor;
    
        return $this;
    }

    /**
     * Get supervisor
     *
     * @return \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee 
     */
    public function getSupervisor()
    {
        return $this->supervisor;
    }

    /**
     * Set username
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\User $username
     * @return Employee
     */
    public function setUsername(\GatotKaca\Erp\UtilitiesBundle\Entity\User $username = null)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return \GatotKaca\Erp\UtilitiesBundle\Entity\User 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set bod_place
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\District $bodPlace
     * @return Employee
     */
    public function setBodPlace(\GatotKaca\Erp\MainBundle\Entity\District $bodPlace = null)
    {
        $this->bod_place = $bodPlace;
    
        return $this;
    }

    /**
     * Get bod_place
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\District 
     */
    public function getBodPlace()
    {
        return $this->bod_place;
    }

    /**
     * Set district_address
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\District $districtAddress
     * @return Employee
     */
    public function setDistrictAddress(\GatotKaca\Erp\MainBundle\Entity\District $districtAddress = null)
    {
        $this->district_address = $districtAddress;
    
        return $this;
    }

    /**
     * Get district_address
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\District 
     */
    public function getDistrictAddress()
    {
        return $this->district_address;
    }

    /**
     * Set province_address
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Province $provinceAddress
     * @return Employee
     */
    public function setProvinceAddress(\GatotKaca\Erp\MainBundle\Entity\Province $provinceAddress = null)
    {
        $this->province_address = $provinceAddress;
    
        return $this;
    }

    /**
     * Get province_address
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Province 
     */
    public function getProvinceAddress()
    {
        return $this->province_address;
    }

    /**
     * Set country
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Country $country
     * @return Employee
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
     * Set citizen
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Country $citizen
     * @return Employee
     */
    public function setCitizen(\GatotKaca\Erp\MainBundle\Entity\Country $citizen = null)
    {
        $this->citizen = $citizen;
    
        return $this;
    }

    /**
     * Get citizen
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Country 
     */
    public function getCitizen()
    {
        return $this->citizen;
    }

    /**
     * Set religion
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\Religion $religion
     * @return Employee
     */
    public function setReligion(\GatotKaca\Erp\MainBundle\Entity\Religion $religion = null)
    {
        $this->religion = $religion;
    
        return $this;
    }

    /**
     * Get religion
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Religion 
     */
    public function getReligion()
    {
        return $this->religion;
    }

    /**
     * Set shift
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\OfficeHour $shift
     * @return Employee
     */
    public function setShift(\GatotKaca\Erp\MainBundle\Entity\OfficeHour $shift = null)
    {
        $this->shift = $shift;
    
        return $this;
    }

    /**
     * Get shift
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\OfficeHour 
     */
    public function getShift()
    {
        return $this->shift;
    }

    /**
     * Add attendance
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance $attendance
     * @return Employee
     */
    public function addAttendance(\GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance $attendance)
    {
        $this->attendance[] = $attendance;
    
        return $this;
    }

    /**
     * Remove attendance
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance $attendance
     */
    public function removeAttendance(\GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance $attendance)
    {
        $this->attendance->removeElement($attendance);
    }

    /**
     * Get attendance
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAttendance()
    {
        return $this->attendance;
    }

    /**
     * Add education
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $education
     * @return Employee
     */
    public function addEducation(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $education)
    {
        $this->education[] = $education;
    
        return $this;
    }

    /**
     * Remove education
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $education
     */
    public function removeEducation(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $education)
    {
        $this->education->removeElement($education);
    }

    /**
     * Get education
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Add experience
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeExperience $experience
     * @return Employee
     */
    public function addExperience(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeExperience $experience)
    {
        $this->experience[] = $experience;
    
        return $this;
    }

    /**
     * Remove experience
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeExperience $experience
     */
    public function removeExperience(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeExperience $experience)
    {
        $this->experience->removeElement($experience);
    }

    /**
     * Get experience
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Add family
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family
     * @return Employee
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

    /**
     * Add language
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage $language
     * @return Employee
     */
    public function addLanguage(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage $language)
    {
        $this->language[] = $language;
    
        return $this;
    }

    /**
     * Remove language
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage $language
     */
    public function removeLanguage(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage $language)
    {
        $this->language->removeElement($language);
    }

    /**
     * Get language
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Add organitation
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOrganitation $organitation
     * @return Employee
     */
    public function addOrganitation(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOrganitation $organitation)
    {
        $this->organitation[] = $organitation;
    
        return $this;
    }

    /**
     * Remove organitation
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOrganitation $organitation
     */
    public function removeOrganitation(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOrganitation $organitation)
    {
        $this->organitation->removeElement($organitation);
    }

    /**
     * Get organitation
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrganitation()
    {
        return $this->organitation;
    }

    /**
     * Add overtime
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOvertime $overtime
     * @return Employee
     */
    public function addOvertime(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOvertime $overtime)
    {
        $this->overtime[] = $overtime;
    
        return $this;
    }

    /**
     * Remove overtime
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOvertime $overtime
     */
    public function removeOvertime(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOvertime $overtime)
    {
        $this->overtime->removeElement($overtime);
    }

    /**
     * Get overtime
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOvertime()
    {
        return $this->overtime;
    }

    /**
     * Add overtime_approvedby
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOvertime $overtimeApprovedby
     * @return Employee
     */
    public function addOvertimeApprovedby(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOvertime $overtimeApprovedby)
    {
        $this->overtime_approvedby[] = $overtimeApprovedby;
    
        return $this;
    }

    /**
     * Remove overtime_approvedby
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOvertime $overtimeApprovedby
     */
    public function removeOvertimeApprovedby(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOvertime $overtimeApprovedby)
    {
        $this->overtime_approvedby->removeElement($overtimeApprovedby);
    }

    /**
     * Get overtime_approvedby
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOvertimeApprovedby()
    {
        return $this->overtime_approvedby;
    }

    /**
     * Add shiftment
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeShiftment $shiftment
     * @return Employee
     */
    public function addShiftment(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeShiftment $shiftment)
    {
        $this->shiftment[] = $shiftment;
    
        return $this;
    }

    /**
     * Remove shiftment
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeShiftment $shiftment
     */
    public function removeShiftment(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeShiftment $shiftment)
    {
        $this->shiftment->removeElement($shiftment);
    }

    /**
     * Get shiftment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShiftment()
    {
        return $this->shiftment;
    }

    /**
     * Add training
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining $training
     * @return Employee
     */
    public function addTraining(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining $training)
    {
        $this->training[] = $training;
    
        return $this;
    }

    /**
     * Remove training
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining $training
     */
    public function removeTraining(\GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining $training)
    {
        $this->training->removeElement($training);
    }

    /**
     * Get training
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * Add career
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $career
     * @return Employee
     */
    public function addCareer(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $career)
    {
        $this->career[] = $career;
    
        return $this;
    }

    /**
     * Remove career
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $career
     */
    public function removeCareer(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $career)
    {
        $this->career->removeElement($career);
    }

    /**
     * Get career
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCareer()
    {
        return $this->career;
    }

    /**
     * Add career_old_supervisor
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldSupervisor
     * @return Employee
     */
    public function addCareerOldSupervisor(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldSupervisor)
    {
        $this->career_old_supervisor[] = $careerOldSupervisor;
    
        return $this;
    }

    /**
     * Remove career_old_supervisor
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldSupervisor
     */
    public function removeCareerOldSupervisor(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldSupervisor)
    {
        $this->career_old_supervisor->removeElement($careerOldSupervisor);
    }

    /**
     * Get career_old_supervisor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCareerOldSupervisor()
    {
        return $this->career_old_supervisor;
    }

    /**
     * Add career_new_supervisor
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewSupervisor
     * @return Employee
     */
    public function addCareerNewSupervisor(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewSupervisor)
    {
        $this->career_new_supervisor[] = $careerNewSupervisor;
    
        return $this;
    }

    /**
     * Remove career_new_supervisor
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewSupervisor
     */
    public function removeCareerNewSupervisor(\GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewSupervisor)
    {
        $this->career_new_supervisor->removeElement($careerNewSupervisor);
    }

    /**
     * Get career_new_supervisor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCareerNewSupervisor()
    {
        return $this->career_new_supervisor;
    }
}