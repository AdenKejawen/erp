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
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Career
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "mtr_employee")
 **/
class Employee
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Company", inversedBy = "employee")
     * @ORM\JoinColumn(name = "sys_company_id", referencedColumnName = "id")
     **/
    protected $company;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Department", inversedBy = "employee")
     * @ORM\JoinColumn(name = "sys_department_id", referencedColumnName = "id")
     **/
    protected $department;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\JobTitle", inversedBy = "employee")
     * @ORM\JoinColumn(name = "sys_jobtitle_id", referencedColumnName = "id")
     **/
    protected $job_title;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\JobStatus", inversedBy = "employee")
     * @ORM\JoinColumn(name = "sys_jobstatus_id", referencedColumnName = "id")
     **/
    protected $job_status;

    /**
     * @ORM\OneToMany(targetEntity = "Employee", mappedBy="supervisor")
     **/
    protected $child;

    /**
     * @ORM\ManyToOne(targetEntity = "Employee", inversedBy = "child")
     * @ORM\JoinColumn(name = "supervisor", referencedColumnName = "id")
     */
    protected $supervisor;

    /**
     * @ORM\Column(name = "`code`", type = "string", length = 17, unique = true, nullable = true)
     **/
    protected $code;

    /**
     * @ORM\Column(name = "`photo`", type = "string", length = 255, nullable = true)
     **/
    protected $photo;

    /**
     * @ORM\Column(name = "`idcard`", type = "string", length = 27, unique = true, nullable = true)
     **/
    protected $id_card;

    /**
     * @ORM\Column(name = "`fname`", type = "string", length = 33, nullable = true)
     **/
    protected $first_name;

    /**
     * @ORM\Column(name = "`lname`", type = "string", length = 33, nullable = true)
     **/
    protected $last_name;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\UtilitiesBundle\Entity\User", inversedBy = "employee")
     * @ORM\JoinColumn(name = "utl_user_id", referencedColumnName = "id")
     **/
    protected $username;

    /**
     * @ORM\Column(name = "`gender`", type = "integer", length = 1, nullable = true)
     *
     * - 1 = male
     * - 2 = female
     **/
    protected $gender;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\District", inversedBy = "employee_bod_place")
     * @ORM\JoinColumn(name = "bod_place", referencedColumnName = "id")
     **/
    protected $bod_place;

    /**
     * @ORM\Column(name = "`bod`", type = "date", nullable = true)
     **/
    protected $bod;

    /**
     * @ORM\Column(name = "`address`", type = "string", length = 255, nullable = true)
     **/
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\District", inversedBy = "employee")
     * @ORM\JoinColumn(name = "district", referencedColumnName = "id")
     **/
    protected $district_address;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Province", inversedBy = "employee")
     * @ORM\JoinColumn(name = "province", referencedColumnName = "id")
     **/
    protected $province_address;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Country", inversedBy = "employee_country")
     * @ORM\JoinColumn(name = "country", referencedColumnName = "id")
     **/
    protected $country_address;

    /**
     * @ORM\Column(name = "`postalcode`", type = "string", length = 7, nullable = true)
     **/
    protected $postal_code;

    /**
     * @ORM\Column(name = "`phone`", type = "string", length = 12, nullable = true)
     **/
    protected $phone;

    /**
     * @ORM\Column(name = "`email`", type = "string", length = 27, nullable = true)
     **/
    protected $email;

    /**
     * @ORM\Column(name = "`mailaddress`", type = "string", length = 255, nullable = true)
     **/
    protected $mail_address;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Country", inversedBy = "employee_citizen")
     * @ORM\JoinColumn(name = "citizen", referencedColumnName = "id")
     **/
    protected $citizen;

    /**
     * @ORM\Column(name = "`blood_type`", type = "string", length = 2, nullable = true)
     **/
    protected $blood_type;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\Religion", inversedBy = "employee")
     * @ORM\JoinColumn(name = "religion", referencedColumnName = "id")
     **/
    protected $religion;

    /**
     * @ORM\Column(name = "`marital_status`", type = "integer", length = 1, nullable = true)
     *
     * - 1 = single
     * - 2 = married
     * - 3 = divorced
     **/
    protected $marital_status;

    /**
     * @ORM\Column(name = "`hire`", type = "date", nullable = true)
     **/
    protected $hire_date;

    /**
     * @ORM\Column(name = "`expire`", type = "date", nullable = true)
     **/
    protected $contract_expire;

    /**
     * @ORM\Column(name = "`tax`", type = "string", length = 27, nullable = true)
     **/
    protected $tax_account;

    /**
     * @ORM\Column(name = "`bank`", type = "string", length = 27, nullable = true)
     **/
    protected $bank_account;

    /**
     * @ORM\ManyToOne(targetEntity = "GatotKaca\Erp\MainBundle\Entity\OfficeHour", inversedBy = "employee")
     * @ORM\JoinColumn(name = "sys_officehour_id", referencedColumnName = "id")
     **/
    protected $shift;

    /**
     * @ORM\Column(name = "`isfixed`", type = "boolean", nullable = true)
     **/
    protected $is_fixed_shift;

    /**
     * @ORM\Column(name = "`isovertime`", type = "boolean", nullable = true)
     **/
    protected $is_over_time;

    /**
     * @ORM\Column(name = "`is_manual_overtime`", type = "boolean", nullable = true)
     **/
    protected $is_manual_over_time;

    /**
     * @ORM\Column(name = "`status`", type = "boolean", nullable = true)
     *
     * true  = active
     * false = resign
     **/
    protected $status;

    /**
     * @ORM\Column(name = "`effective`", type = "date", nullable = true)
     **/
    protected $resign_date;

    /**
     * @ORM\Column(name = "`reason`", type = "string", length = 255, nullable = true)
     **/
    protected $resign_reason;

    /**
     * @ORM\Column(name = "`is_resign`", type = "boolean", nullable = true)
     * Temporary Resign Status
     **/
    protected $is_resign;

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
     * @ORM\OneToMany(targetEntity = "Attendance", mappedBy = "employee")
     **/
    protected $attendance;

    /**
     * @ORM\OneToMany(targetEntity = "EmployeeEducation", mappedBy = "employee")
     **/
    protected $education;

    /**
     * @ORM\OneToMany(targetEntity = "EmployeeExperience", mappedBy = "employee")
     **/
    protected $experience;

    /**
     * @ORM\OneToMany(targetEntity = "EmployeeFamily", mappedBy = "employee")
     **/
    protected $family;

    /**
     * @ORM\OneToMany(targetEntity = "EmployeeLanguage", mappedBy = "employee")
     **/
    protected $language;

    /**
     * @ORM\OneToMany(targetEntity = "EmployeeOrganitation", mappedBy = "employee")
     **/
    protected $organitation;

    /**
     * @ORM\OneToMany(targetEntity = "Overtime", mappedBy = "employee")
     **/
    protected $overtime;

    /**
     * @ORM\OneToMany(targetEntity = "Overtime", mappedBy = "approved_by")
     **/
    protected $overtime_approved_by;

    /**
     * @ORM\OneToMany(targetEntity = "Shiftment", mappedBy = "employee")
     **/
    protected $shiftment;

    /**
     * @ORM\OneToMany(targetEntity = "EmployeeTraining", mappedBy = "employee")
     **/
    protected $training;

    /**
     * @ORM\OneToMany(targetEntity = "Career", mappedBy = "employee")
     **/
    protected $career;

    /**
     * @ORM\OneToMany(targetEntity = "Career", mappedBy = "old_supervisor")
     **/
    protected $career_old_supervisor;

    /**
     * @ORM\OneToMany(targetEntity = "Career", mappedBy = "new_supervisor")
     **/
    protected $career_new_supervisor;

    public function __construct()
    {
        $this->status  = true;
        $this->is_fixed_shift = true;
        $this->is_overtime    = false;
        $this->is_resign      = false;
        $this->is_manual_over_time = false;
        $this->expire  = new \DateTime('1970-01-01');
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string   $id
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
     * @param  string   $code
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
     * @param  string   $photo
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
     * Set id_card
     *
     * @param  string   $idCard
     * @return Employee
     */
    public function setIdCard($idCard)
    {
        $this->id_card = $idCard;

        return $this;
    }

    /**
     * Get id_card
     *
     * @return string
     */
    public function getIdCard()
    {
        return $this->id_card;
    }

    /**
     * Set first_name
     *
     * @param  string   $firstName
     * @return Employee
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param  string   $lastName
     * @return Employee
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set gender
     *
     * @param  integer  $gender
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
     * @param  \DateTime $bod
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
     * @param  string   $address
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
     * Set postal_code
     *
     * @param  string   $postalCode
     * @return Employee
     */
    public function setPostalCode($postalCode)
    {
        $this->postal_code = $postalCode;

        return $this;
    }

    /**
     * Get postal_code
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * Set phone
     *
     * @param  string   $phone
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
     * @param  string   $email
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
     * Set mail_address
     *
     * @param  string   $mailAddress
     * @return Employee
     */
    public function setMailAddress($mailAddress)
    {
        $this->mail_address = $mailAddress;

        return $this;
    }

    /**
     * Get mail_address
     *
     * @return string
     */
    public function getMailAddress()
    {
        return $this->mail_address;
    }

    /**
     * Set blood_type
     *
     * @param  string   $bloodType
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
     * @param  integer  $maritalStatus
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
     * Set hire_date
     *
     * @param  \DateTime $hireDate
     * @return Employee
     */
    public function setHireDate($hireDate)
    {
        $this->hire_date = $hireDate;

        return $this;
    }

    /**
     * Get hire_date
     *
     * @return \DateTime
     */
    public function getHireDate()
    {
        return $this->hire_date;
    }

    /**
     * Set contract_expire
     *
     * @param  \DateTime $contractExpire
     * @return Employee
     */
    public function setContractExpire($contractExpire)
    {
        $this->contract_expire = $contractExpire;

        return $this;
    }

    /**
     * Get contract_expire
     *
     * @return \DateTime
     */
    public function getContractExpire()
    {
        return $this->contract_expire;
    }

    /**
     * Set tax_account
     *
     * @param  string   $taxAccount
     * @return Employee
     */
    public function setTaxAccount($taxAccount)
    {
        $this->tax_account = $taxAccount;

        return $this;
    }

    /**
     * Get tax_account
     *
     * @return string
     */
    public function getTaxAccount()
    {
        return $this->tax_account;
    }

    /**
     * Set bank_account
     *
     * @param  string   $bankAccount
     * @return Employee
     */
    public function setBankAccount($bankAccount)
    {
        $this->bank_account = $bankAccount;

        return $this;
    }

    /**
     * Get bank_account
     *
     * @return string
     */
    public function getBankAccount()
    {
        return $this->bank_account;
    }

    /**
     * Set is_fixed_shift
     *
     * @param  boolean  $isFixedShift
     * @return Employee
     */
    public function setIsFixedShift($isFixedShift)
    {
        $this->is_fixed_shift = $isFixedShift;

        return $this;
    }

    /**
     * Get is_fixed_shift
     *
     * @return boolean
     */
    public function getIsFixedShift()
    {
        return $this->is_fixed_shift;
    }

    /**
     * Set is_over_time
     *
     * @param  boolean  $isOverTime
     * @return Employee
     */
    public function setIsOverTime($isOverTime)
    {
        $this->is_over_time = $isOverTime;

        return $this;
    }

    /**
     * Get is_over_time
     *
     * @return boolean
     */
    public function getIsOverTime()
    {
        return $this->is_over_time;
    }

    /**
     * Set is_manual_over_time
     *
     * @param  boolean  $isManualOverTime
     * @return Employee
     */
    public function setIsManualOverTime($isManualOverTime)
    {
        $this->is_manual_over_time = $isManualOverTime;

        return $this;
    }

    /**
     * Get is_manual_over_time
     *
     * @return boolean
     */
    public function getIsManualOverTime()
    {
        return $this->is_manual_over_time;
    }

    /**
     * Set status
     *
     * @param  boolean  $status
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
     * Set resign_date
     *
     * @param  \DateTime $resignDate
     * @return Employee
     */
    public function setResignDate($resignDate)
    {
        $this->resign_date = $resignDate;

        return $this;
    }

    /**
     * Get resign_date
     *
     * @return \DateTime
     */
    public function getResignDate()
    {
        return $this->resign_date;
    }

    /**
     * Set resign_reason
     *
     * @param  string   $resignReason
     * @return Employee
     */
    public function setResignReason($resignReason)
    {
        $this->resign_reason = $resignReason;

        return $this;
    }

    /**
     * Get resign_reason
     *
     * @return string
     */
    public function getResignReason()
    {
        return $this->resign_reason;
    }

    /**
     * Set is_resign
     *
     * @param  boolean  $isResign
     * @return Employee
     */
    public function setIsResign($isResign)
    {
        $this->is_resign = $isResign;

        return $this;
    }

    /**
     * Get is_resign
     *
     * @return boolean
     */
    public function getIsResign()
    {
        return $this->is_resign;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
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
     * Set created_by
     *
     * @param  string   $createdBy
     * @return Employee
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
     * Set updated_by
     *
     * @param  string   $updatedBy
     * @return Employee
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
     * Set company
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Company $company
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\Department $department
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
     * Set job_title
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\JobTitle $jobTitle
     * @return Employee
     */
    public function setJobTitle(\GatotKaca\Erp\MainBundle\Entity\JobTitle $jobTitle = null)
    {
        $this->job_title = $jobTitle;

        return $this;
    }

    /**
     * Get job_title
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobTitle
     */
    public function getJobTitle()
    {
        return $this->job_title;
    }

    /**
     * Set job_status
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\JobStatus $jobStatus
     * @return Employee
     */
    public function setJobStatus(\GatotKaca\Erp\MainBundle\Entity\JobStatus $jobStatus = null)
    {
        $this->job_status = $jobStatus;

        return $this;
    }

    /**
     * Get job_status
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\JobStatus
     */
    public function getJobStatus()
    {
        return $this->job_status;
    }

    /**
     * Add child
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $child
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $supervisor
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
     * @param  \GatotKaca\Erp\UtilitiesBundle\Entity\User $username
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\District $bodPlace
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\District $districtAddress
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\Province $provinceAddress
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
     * Set country_address
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Country $countryAddress
     * @return Employee
     */
    public function setCountryAddress(\GatotKaca\Erp\MainBundle\Entity\Country $countryAddress = null)
    {
        $this->country_address = $countryAddress;

        return $this;
    }

    /**
     * Get country_address
     *
     * @return \GatotKaca\Erp\MainBundle\Entity\Country
     */
    public function getCountryAddress()
    {
        return $this->country_address;
    }

    /**
     * Set citizen
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\Country $citizen
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\Religion $religion
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
     * @param  \GatotKaca\Erp\MainBundle\Entity\OfficeHour $shift
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance $attendance
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation $education
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeExperience $experience
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily $family
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage $language
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOrganitation $organitation
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime $overtime
     * @return Employee
     */
    public function addOvertime(\GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime $overtime)
    {
        $this->overtime[] = $overtime;

        return $this;
    }

    /**
     * Remove overtime
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime $overtime
     */
    public function removeOvertime(\GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime $overtime)
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
     * Add overtime_approved_by
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime $overtimeApprovedBy
     * @return Employee
     */
    public function addOvertimeApprovedBy(\GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime $overtimeApprovedBy)
    {
        $this->overtime_approved_by[] = $overtimeApprovedBy;

        return $this;
    }

    /**
     * Remove overtime_approved_by
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime $overtimeApprovedBy
     */
    public function removeOvertimeApprovedBy(\GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime $overtimeApprovedBy)
    {
        $this->overtime_approved_by->removeElement($overtimeApprovedBy);
    }

    /**
     * Get overtime_approved_by
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOvertimeApprovedBy()
    {
        return $this->overtime_approved_by;
    }

    /**
     * Add shiftment
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment $shiftment
     * @return Employee
     */
    public function addShiftment(\GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment $shiftment)
    {
        $this->shiftment[] = $shiftment;

        return $this;
    }

    /**
     * Remove shiftment
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment $shiftment
     */
    public function removeShiftment(\GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment $shiftment)
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining $training
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $career
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerOldSupervisor
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
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Career $careerNewSupervisor
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
