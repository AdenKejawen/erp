<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Model/EmployeeModel.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Model;

use GatotKaca\Erp\UtilitiesBundle\Entity\User;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use GatotKaca\Erp\HumanResourcesBundle\Entity\Employee;
use GatotKaca\Erp\HumanResourcesBundle\Entity\Shiftment;
use GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeEducation;
use GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeFamily;
use GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeExperience;
use GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeTraining;
use GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeLanguage;
use GatotKaca\Erp\HumanResourcesBundle\Entity\EmployeeOrganitation;
use GatotKaca\Erp\HumanResourcesBundle\Entity\Career;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\DBAL\LockMode;

class EmployeeModel extends BaseModel
{
    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param Helper        $helper
     **/
    public function __construct(\Doctrine\ORM\EntityManager $entityManager, \GatotKaca\Core\Helper\Helper $helper)
    {
        parent::__construct($entityManager, $helper);
    }

    /**
     * Untuk mendapatkan list employee berdasarkan limit
     *
     * @param  integer $start
     * @param  integer $limit
     * @return array   result
     **/
    public function getList($keyword, $start = 0, $limit = 25, $isfixed = true)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND e.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND (e.status = false OR e.is_resign = true)";
        }
        if (!$isfixed) {
            $extra  .= " AND e.is_fixed_shift = false";
        }
        $start  = ($keyword == '') ? $start : 0;
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "e.id AS employee_id,
                e.code AS employee_code,
                e.first_name AS employee_fname,
                e.last_name AS employee_lname,
                TO_CHAR(e.resign_date, '{$this->getHelper()->getSession()->get('date_format_text')}') AS resign_date,
                e.resign_reason AS resign_reason,
                c.id AS employee_company,
                c.name AS employee_companyname,
                jt.id AS employee_jobtitle,
                jt.name AS employee_jobtitlename,
                sp.id AS employee_supervisor,
                sp.first_name AS employee_supervisorfname,
                sp.last_name AS employee_supervisorlname"
            )
            ->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
            ->leftJoin('GatotKacaErpMainBundle:Company', 'c', 'WITH', 'e.company = c.id')
            ->leftJoin('GatotKacaErpMainBundle:JobTitle', 'jt', 'WITH', 'e.job_title = jt.id')
            ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'sp', 'WITH', 'e.supervisor = sp.id')
            ->where("(e.first_name LIKE :name OR e.last_name LIKE :name) {$extra}")
            ->setParameter('name', "%{$keyword}%")
            ->orderBy('e.first_name', 'ASC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get employee from {$start} to {$limit}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total employee
     *
     * @param  string  $keyword
     * @param  integer $limit
     * @return integer $total
     **/
    public function countTotal($keyword, $limit, $isfixed = true)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND e.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND (e.status = false OR e.is_resign = true)";
        }
        if (!$isfixed) {
            $extra  .= " AND e.is_fixed_shift = false";
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e.id AS employee_id');
        $qb->from('GatotKacaErpHumanResourcesBundle:Employee', 'e');
        $qb->where("(e.first_name LIKE :fname OR e.last_name LIKE :lname) {$extra}");
        $qb->setParameter('fname', "%{$keyword}%");
        $qb->setParameter('lname', "%{$keyword}%");
        if ($keyword != '') {
            $qb->setFirstResult(0);
            $qb->setMaxResults($limit);
        };
        $query  = $qb->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan group employee
     *
     * @return object group
     **/
    private function getGroup()
    {
        return $this->getEntityManager()
            ->getRepository('GatotKacaErpUtilitiesBundle:UserGroup')
            ->find($this->getHelper()->getModelManager($this->getEntityManager())->getSetting()->get('default_group'));
    }

    /**
     * Untuk mengecek employee yang terdaftar
     *
     * @param string username
     * @return boolean
     **/
    private function isExist($criteria = 'employee', $value = '')
    {
        $key    = strtolower($criteria);
        $bundle = 'GatotKacaErpHumanResourcesBundle:Employee';
        if ($key == 'username') {
            $criteria   = 'name';
            $bundle     = 'GatotKacaErpUtilitiesBundle:User';
        } else {
            $criteria   = 'code';
        }
        $exist  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u.id AS id')
            ->from($bundle, 'u')
            ->where("u.{$criteria} = :{$key}")
            ->setParameter($key, $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        if ($exist) {//apakah ditemukan ? return true : return false

            return true;
        } else {
            return false;
        }
    }

    /**
     * Untuk menyimpan data employee ke database
     *
     * @param mixed input
     **/
    public function save($input, $profile)
    {
        $username   = strtoupper($input->employee_username);
        $employee   = new Employee();
        $user       = new User();
        if ($this->isExist('username', $username) && (!isset($input->employee_id) || $input->employee_id == '')) {//Tambah karyawan baru tapi username sudah terdaftar
            $this->setAction("create");
            $this->setMessage("Username is exist");
            $this->setModelLog($this->getMessage());

            return false;
        } elseif ($this->isExist('employee', $input->employee_code) && (!isset($input->employee_id) || $input->employee_id == '')) {//Tambah karyawan baru tapi code karyawan sudah terdaftar
            $this->setAction("create");
            $this->setMessage("Employee Code is exist");
            $this->setModelLog($this->getMessage());

            return false;
        } elseif (isset($input->employee_id) && $input->employee_id != '') {//Edit karyawan
            $this->setAction("modify");
            $employee   = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->find($input->employee_id);
            $user       = $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:User')->findOneBy(array('name' => $username));
            if ($profile !== null) {
                $employee->setPhoto($profile);
            }
        } else {//Tambah karyawan
            $this->setAction("create");
            $salt   = $this->getHelper()->getSalt(123);
            $user->setId($this->getHelper()->getUniqueId());
            $user->setName($username);
            $user->setSalt($salt);
            $user->setPass($this->getHelper()->hashPassword(123, $salt));
            $user->setGroup($this->getGroup());
            $this->setEntityLog($user);
            $employee->setId($this->getHelper()->getUniqueId());
            $employee->setUsername($user);
            $employee->setPhoto(is_null($profile) ? 'default.png' : $profile);
        }
        $supervisor = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->find($input->employee_supervisor);
        if ($supervisor) {
            $employee->setSupervisor($supervisor);
        }
        $employee->setCompany($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Company', $input->employee_company));
        $employee->setDepartment($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Department', $input->employee_department));
        $employee->setCode($input->employee_code);
        $employee->setIdCard($input->employee_idcard);
        $employee->setFirstName(strtoupper($input->employee_fname));
        $employee->setLastName(strtoupper($input->employee_lname));
        $employee->setHireDate(new \DateTime($input->employee_start));
        $employee->setGender($input->employee_gender);
        $employee->setCitizen($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Country', $input->employee_citizen));
        $employee->setBodPlace($this->getEntityManager()->getReference('GatotKacaErpMainBundle:District', $input->employee_bodplace));
        $employee->setBod(new \DateTime($input->employee_bod));
        $employee->setReligion($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Religion', $input->employee_religion));
        $employee->setJobTitle($this->getEntityManager()->getReference('GatotKacaErpMainBundle:JobTitle', $input->employee_jobtitle));
        $employee->setJobStatus($this->getEntityManager()->getReference('GatotKacaErpMainBundle:JobStatus', $input->employee_jobstatus));
        $employee->setMaritalStatus($input->employee_maritalstatus);
        $employee->setBloodType($input->employee_bloodtype);
        $employee->setShift($this->getEntityManager()->getReference('GatotKacaErpMainBundle:OfficeHour', $input->employee_officehour));
        $employee->setIsFixedShift(isset($input->isfixed_officehour));
        $employee->setIsOverTime(isset($input->employee_overtime));
        $employee->setIsManualOverTime(isset($input->employee_manualovertime));
        $employee->setAddress(strtoupper($input->employee_address));
        $employee->setMailAddress(strtoupper($input->employee_mailaddress));
        $district   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:District')->find($input->employee_disctrict);
        if ($district) {
            $employee->setDistrictAddress($district);
        }
        $province   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Province')->find($input->employee_province);
        if ($province) {
            $employee->setProvinceAddress($province);
        }
        $country    = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Country')->find($input->employee_country);
        if ($country) {
            $employee->setCountryAddress($country);
        }
        $employee->setPostalCode($input->employee_postalcode);
        $employee->setPhone($input->employee_phone);
        $employee->setEmail($input->employee_email);
        $employee->setContractExpire(new \DateTime($input->employee_end));
        $employee->setTaxAccount($input->employee_tax);
        $employee->setBankAccount($input->employee_bank);
        //Simpan karyawan
        $this->setEntityLog($employee);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->persist($employee);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($user, LockMode::PESSIMISTIC_READ);
            $this->getEntityManager()->lock($employee, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee with id {$employee->getId()}");

            return $employee->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk mendapatkan data employee by criteria
     *
     * @param string criteria
     * @param string value
     **/
    public function getBy($criteria, $value)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "e.id AS employee_id,
                c.id AS employee_company,
                c.name AS employee_companyname,
                d.id AS employee_department,
                d.name AS employee_departmentname,
                e.code AS employee_code,
                e.photo AS employee_photo,
                e.id_card AS employee_idcard,
                e.first_name AS employee_fname,
                e.last_name AS employee_lname,
                e.postal_code AS employee_postalcode,
                e.phone AS employee_phone,
                e.email AS employee_email,
                sp.id AS employee_supervisor,
                e.mail_address AS employee_mailaddress,
                TO_CHAR(e.hire_date, '{$this->getHelper()->getSession()->get('date_format_text')}') AS employee_start,
                jt.id AS employee_jobtitle,
                jt.name AS employee_jobtitlename,
                js.id AS employee_jobstatus,
                js.name AS employee_jobstatusname,
                js.is_permanent AS employee_ispermanent,
                jl.level AS employee_level,
                TO_CHAR(e.contract_expire, '{$this->getHelper()->getSession()->get('date_format_text')}') AS employee_end,
                u.name AS employee_username,
                e.gender AS employee_gender,
                cz.id AS employee_citizen,
                cz.name AS employee_citizenname,
                bp.id AS employee_bodplace,
                bp.name AS employee_bodplacename,
                TO_CHAR(e.bod, '{$this->getHelper()->getSession()->get('date_format_text')}') AS employee_bod,
                r.id AS employee_religion,
                r.name AS employee_religionname,
                e.marital_status AS employee_maritalstatus,
                e.blood_type AS employee_bloodtype,
                e.address AS employee_address,
                da.id AS employee_daddress,
                pa.id AS employee_paddress,
                ca.id AS employee_country,
                ca.name AS employee_countryname,
                e.tax_account AS employee_tax,
                e.bank_account AS employee_bank,
                oh.id AS employee_officehour,
                oh.name AS employee_officehourname,
                e.is_fixed_shift AS isfixed_officehour,
                e.is_over_time AS employee_overtime,
                e.is_manual_over_time AS employee_manualovertime,
                TO_CHAR(e.resign_date, '{$this->getHelper()->getSession()->get('date_format_text')}') AS resign_date,
                e.resign_reason AS resign_reason,
                ed.name AS employee_lasteducation,
                CASE
                WHEN
                    ef.relation = 4
                THEN
                    COUNT(ef.relation)
                ELSE
                    0
                END
                AS employee_numberofchildren"
            )
            ->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
            ->leftJoin('GatotKacaErpUtilitiesBundle:User', 'u', 'WITH', 'e.username = u.id')
            ->leftJoin('GatotKacaErpMainBundle:Company', 'c', 'WITH', 'e.company = c.id')
            ->leftJoin('GatotKacaErpMainBundle:Department', 'd', 'WITH', 'e.department = d.id')
            ->leftJoin('GatotKacaErpMainBundle:Country', 'cz', 'WITH', 'e.citizen = cz.id')
            ->leftJoin('GatotKacaErpMainBundle:District', 'bp', 'WITH', 'e.bod_place = bp.id')
            ->leftJoin('GatotKacaErpMainBundle:Religion', 'r', 'WITH', 'e.religion = r.id')
            ->leftJoin('GatotKacaErpMainBundle:District', 'da', 'WITH', 'e.district_address = da.id')
            ->leftJoin('GatotKacaErpMainBundle:Province', 'pa', 'WITH', 'e.province_address = pa.id')
            ->leftJoin('GatotKacaErpMainBundle:Country', 'ca', 'WITH', 'e.country_address = ca.id')
            ->leftJoin('GatotKacaErpMainBundle:OfficeHour', 'oh', 'WITH', 'e.shift = oh.id')
            ->leftJoin('GatotKacaErpMainBundle:JobTitle', 'jt', 'WITH', 'e.job_title = jt.id')
            ->leftJoin('GatotKacaErpMainBundle:JobLevel', 'jl', 'WITH', 'jt.level = jl.id')
            ->leftJoin('GatotKacaErpMainBundle:JobStatus', 'js', 'WITH', 'e.job_status = js.id')
            ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'sp', 'WITH', 'e.supervisor = sp.id')
            ->leftJoin('GatotKacaErpHumanResourcesBundle:EmployeeEducation', 'ee', 'WITH', 'e.id = ee.employee')
            ->leftJoin('GatotKacaErpMainBundle:Education', 'ed', 'WITH', 'ee.education = ed.id')
            ->leftJoin('GatotKacaErpHumanResourcesBundle:EmployeeFamily', 'ef', 'WITH', 'e.id = ef.employee')
            ->where("e.{$criteria} = :{$criteria}")
            ->groupBy(
                "e.id,
                c.id,
                d.id,
                sp.id,
                jt.id,
                js.id,
                jl.level,
                u.name,
                cz.id,
                bp.id,
                e.bod,
                r.id,
                da.id,
                pa.id,
                ca.id,
                oh.id,
                ed.name,
                ef.relation,
                ed.level"
            )
            ->addOrderBy('ed.level', 'ASC')
            ->addOrderBy('ef.relation', 'DESC')
            ->setMaxResults(1)
            ->setParameter($criteria, $value)
            ->getQuery();
        $this->setModelLog("get employee {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan employee berdasarkan job level
     *
     * @param  integer $start
     * @param  integer $limit
     * @return array   result
     **/
    public function getByJobLevel($jobtitle)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "e.id AS employee_id,
                e.code AS employee_code,
                e.first_name AS employee_fname,
                e.last_name AS employee_lname,
                jp.name AS employee_jobtitle"
            )
            ->from('GatotKacaErpMainBundle:JobTitle', 'jt')
            ->innerJoin('GatotKacaErpMainBundle:JobTitle', 'jp', 'WITH', 'jt.parent = jp.id')
            ->innerJoin('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'jp.id = e.job_title')
            ->where("jt.id = :jobtitle AND e.status = true")
            ->orderBy('jt.name', 'ASC')
            ->setParameter('jobtitle', $jobtitle)
            ->getQuery();
        $this->setModelLog("get employee with jobtitle {$jobtitle}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan shiftment berdasarkan criteria dan value
     *
     * @param  string   $criteria
     * @param  string   $value
     * @param  datetime $from
     * @param  datetime $to
     * @return array    $result
     **/
    public function getShiftmentBy($criteria, $value, $from = '', $to = '', $start = 0, $limit = 25)
    {
        $extra  = '';
        if ($from !== null && $from != '') {
            $extra  .= " AND es.shift_date BETWEEN '{$from}' AND '{$to}'";
        } elseif ($from === null) {
            $date   = new \DateTime();
            $days   = cal_days_in_month(CAL_GREGORIAN, $date->format('m'), $date->format('Y'));
            $extra  .= " AND es.shift_date BETWEEN '{$date->format('Y-m-')}1 00:00:00' AND '{$date->format('Y-m-')}{$days} 23:59:59'";
        }
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "es.id AS shift_id,
                TO_CHAR(es.shift_date, '{$this->getHelper()->getSession()->get('date_format_text')}') AS shift_date,
                oh.id AS shift_ohid,
                TO_CHAR(oh.time_in, 'HH24:MI:SS') AS shift_ohin,
                TO_CHAR(oh.time_out, 'HH24:MI:SS') AS shift_ohout"
            )
            ->from('GatotKacaErpHumanResourcesBundle:Shiftment', 'es')
            ->innerJoin('GatotKacaErpMainBundle:OfficeHour', 'oh', 'WITH', 'es.officehour = oh.id')
            ->where("es.{$criteria} = :{$criteria}{$extra}")
            ->orderBy('es.shift_date', 'ASC')
            ->setParameter($criteria, $value)
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get shiftment with {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total shiftment berdasarkan criteria dan value
     *
     * @param  string   $criteria
     * @param  string   $value
     * @param  datetime $from
     * @param  datetime $to
     * @return integer  total
     **/
    public function countShiftmentBy($criteria, $value, $from = '', $to = '')
    {
        $extra  = '';
        if ($from !== null && $from != '') {
            $extra  .= " AND es.shift_date BETWEEN '{$from}' AND '{$to}'";
        } elseif ($from === null) {
            $date   = new \DateTime();
            $days   = cal_days_in_month(CAL_GREGORIAN, $date->format('m'), $date->format('Y'));
            $extra  .= " AND es.shift_date BETWEEN '{$date->format('Y-m-')}1 00:00:00' AND '{$date->format('Y-m-')}{$days} 23:59:59'";
        }
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('es.id AS shift_id')
            ->from('GatotKacaErpHumanResourcesBundle:Shiftment', 'es')
            ->where("es.{$criteria} = :{$criteria}{$extra}")
            ->setParameter($criteria, $value)
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan education berdasarkan criteria dan value
     *
     * @param  string $criteria
     * @param  string $value
     * @return array  $result
     **/
    public function getEducationBy($criteria, $value, $start = 0, $limit = 25)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "ee.id AS education_id,
                e.id AS education_lid,
                e.name AS education_lname,
                e.level AS education_level,
                d.id AS education_district,
                d.name AS education_districtname,
                ee.name AS education_name,
                ee.specialist AS education_specialist,
                TO_CHAR(ee.start, 'YYYY') AS education_start,
                TO_CHAR(ee.end, 'YYYY') AS education_end"
            )
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeEducation', 'ee')
            ->leftJoin('GatotKacaErpMainBundle:Education', 'e', 'WITH', 'ee.education = e.id')
            ->leftJoin('GatotKacaErpMainBundle:District', 'd', 'WITH', 'ee.district = d.id')
            ->where("ee.{$criteria} = :{$criteria}")
            ->orderBy('e.level', 'ASC')
            ->setParameter($criteria, $value)
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get education with {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total education
     *
     * @param  string  $criteria
     * @param  string  $value
     * @return integer total
     **/
    public function countEducationBy($criteria, $value)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('ee.id AS education_id')
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeEducation', 'ee')
            ->where("ee.{$criteria} = :{$criteria}")
            ->setParameter($criteria, $value)
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan family berdasarkan criteria dan value
     *
     * @param  string $criteria
     * @param  string $value
     * @return array  $result
     **/
    public function getFamilyBy($criteria, $value, $start = 0, $limit = 25)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "ef.id AS family_id,
                ef.relation AS family_level,
                ef.first_name AS family_fname,
                ef.last_name AS family_lname,
                TO_CHAR(ef.bod, '{$this->getHelper()->getSession()->get('date_format_text')}') AS family_born,
                e.id AS family_education,
                e.name AS family_educationname,
                ef.institute AS family_institute"
            )
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeFamily', 'ef')
            ->leftJoin('GatotKacaErpMainBundle:Education', 'e', 'WITH', 'ef.education = e.id')
            ->where("ef.{$criteria} = :{$criteria}")
            ->orderBy('ef.relation', 'ASC')
            ->setParameter($criteria, $value)
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get family with {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total family
     *
     * @param  string  $criteria
     * @param  string  $value
     * @return integer total
     **/
    public function countFamilyBy($criteria, $value)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('ef.id AS family_i')
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeFamily', 'ef')
            ->where("ef.{$criteria} = :{$criteria}")
            ->setParameter($criteria, $value)
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan training berdasarkan criteria dan value
     *
     * @param  string $criteria
     * @param  string $value
     * @return array  $result
     **/
    public function getTrainingBy($criteria, $value, $start = 0, $limit = 25)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "et.id AS training_id,
                et.name AS training_name,
                d.name AS training_district,
                TO_CHAR(et.start, '{$this->getHelper()->getSession()->get('date_format_text')}') AS training_start,
                TO_CHAR(et.end, '{$this->getHelper()->getSession()->get('date_format_text')}') AS training_end,
                et.skill AS training_skill,
                et.institute AS training_institute"
            )
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeTraining', 'et')
            ->leftJoin('GatotKacaErpMainBundle:District', 'd', 'WITH', 'et.district = d.id')
            ->where("et.{$criteria} = :{$criteria}")
            ->orderBy('et.start', 'DESC')
            ->setParameter($criteria, $value)
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get training with {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total training
     *
     * @param  string  $criteria
     * @param  string  $value
     * @return integer total
     **/
    public function countTrainingBy($criteria, $value)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('et.id AS training_id')
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeTraining', 'et')
            ->where("et.{$criteria} = :{$criteria}")
            ->setParameter($criteria, $value)
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan experience berdasarkan criteria dan value
     *
     * @param  string $criteria
     * @param  string $value
     * @return array  $result
     **/
    public function getExperienceBy($criteria, $value, $start = 0, $limit = 25)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "ee.id AS experience_id,
                ee.company AS experience_company,
                ee.reason AS experience_reason,
                TO_CHAR(ee.start, '{$this->getHelper()->getSession()->get('date_format_text')}') AS experience_start,
                TO_CHAR(ee.end, '{$this->getHelper()->getSession()->get('date_format_text')}') AS experience_end,
                ee.job_title AS experience_jobtitle"
            )
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeExperience', 'ee')
            ->where("ee.{$criteria} = :{$criteria}")
            ->orderBy('ee.start', 'DESC')
            ->setParameter($criteria, $value)
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get experience with {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total experience
     *
     * @param  string  $criteria
     * @param  string  $value
     * @return integer total
     **/
    public function countExperienceBy($criteria, $value)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('ee.id AS experience_id')
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeExperience', 'ee')
            ->where("ee.{$criteria} = :{$criteria}")
            ->setParameter($criteria, $value)
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan language berdasarkan criteria dan value
     *
     * @param  string $criteria
     * @param  string $value
     * @return array  $result
     **/
    public function getLanguageBy($criteria, $value, $start = 0, $limit = 25)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'el.id AS language_id,
                l.id AS language_lid,
                l.name AS language_lname,
                el.spoken AS language_spoken,
                el.writen AS language_writen'
            )
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeLanguage', 'el')
            ->leftJoin('GatotKacaErpMainBundle:Language', 'l', 'WITH', 'el.language = l.id')
            ->where("el.{$criteria} = :{$criteria}")
            ->orderBy('l.name', 'DESC')
            ->setParameter($criteria, $value)
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get language with {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total language
     *
     * @param  string  $criteria
     * @param  string  $value
     * @return integer total
     **/
    public function countLanguageBy($criteria, $value)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('el.id AS language_id')
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeLanguage', 'el')
            ->where("el.{$criteria} = :{$criteria}")
            ->setParameter($criteria, $value)
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan org berdasarkan criteria dan value
     *
     * @param  string $criteria
     * @param  string $value
     * @return array  $result
     **/
    public function getOrganitationBy($criteria, $value, $start = 0, $limit = 25)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "eo.id AS org_id,
                TO_CHAR(eo.start, '{$this->getHelper()->getSession()->get('date_format_text')}') AS org_start,
                TO_CHAR(eo.end, '{$this->getHelper()->getSession()->get('date_format_text')}') AS org_end,
                eo.categories AS org_categories,
                eo.position AS org_position,
                eo.name AS org_name"
            )
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeOrganitation', 'eo')
            ->where("eo.{$criteria} = :{$criteria}")
            ->orderBy('eo.name', 'DESC')
            ->setParameter($criteria, $value)
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get organitation with {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total org
     *
     * @param  string  $criteria
     * @param  string  $value
     * @return integer total
     **/
    public function countOrganitationBy($criteria, $value)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('eo.id AS org_id')
            ->from('GatotKacaErpHumanResourcesBundle:EmployeeOrganitation', 'eo')
            ->where("eo.{$criteria} = :{$criteria}")
            ->setParameter($criteria, $value)
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan career berdasarkan criteria dan value
     *
     * @param  string $criteria
     * @param  string $value
     * @return array  $result
     **/
    public function getCareerBy($criteria, $value, $start = 0, $limit = 25)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "ec.id AS career_id,
                TO_CHAR(ec.promote_date, '{$this->getHelper()->getSession()->get('date_format_text')}') AS career_date,
                ec.reference_number AS career_refno,
                co.id AS employee_company,
                co.name AS employee_companyname,
                cn.id AS new_companyid,
                cn.name AS new_companyname,
                jo.id AS employee_jobtitle,
                jo.name AS employee_jobtitlename,
                jn.id AS new_jobtitleid,
                jn.name AS new_jobtitlename,
                eo.id AS employee_supervisor,
                eo.first_name AS employee_supervisorfname,
                eo.last_name AS employee_supervisorlname,
                en.id AS new_supervisor,
                en.first_name AS new_supervisorfname,
                en.last_name AS new_supervisorlname"
            )
            ->from('GatotKacaErpHumanResourcesBundle:Career', 'ec')
            ->leftJoin('GatotKacaErpMainBundle:Company', 'co', 'WITH', 'ec.old_company = co.id')
            ->leftJoin('GatotKacaErpMainBundle:Company', 'cn', 'WITH', 'ec.new_company = cn.id')
            ->leftJoin('GatotKacaErpMainBundle:JobTitle', 'jo', 'WITH', 'ec.old_job_title = jo.id')
            ->leftJoin('GatotKacaErpMainBundle:JobTitle', 'jn', 'WITH', 'ec.new_job_title = jn.id')
            ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'eo', 'WITH', 'ec.old_supervisor = eo.id')
            ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'en', 'WITH', 'ec.new_supervisor = en.id')
            ->where("ec.{$criteria} = :{$criteria}")
            ->orderBy('ec.promote_date', 'DESC')
            ->setParameter($criteria, $value)
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get career with {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total career
     *
     * @param  string  $criteria
     * @param  string  $value
     * @return integer total
     **/
    public function countCareerBy($criteria, $value)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('ec.id AS career_id')
            ->from('GatotKacaErpHumanResourcesBundle:Career', 'ec')
            ->where("ec.{$criteria} = :{$criteria}")
            ->setParameter($criteria, $value)
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk menyimpan data shiftment
     *
     * @param mixed $input
     **/
    public function saveShiftment($input)
    {
        $this->setAction("create");
        $from       = strtotime($input->shift_from);
        $to         = strtotime($input->shift_to);
        $employee   = $this->getEntityManager()->getReference('GatotKacaErpHumanResourcesBundle:Employee', $input->employee_id);
        for ($i = $from; $i <= $to; $i = strtotime('+1 day', $i)) {
            $shiftment  = new Shiftment();
            $date       = new \DateTime(date('Y-m-d', $i));
            if ($exist = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Shiftment')->findOneBy(array('shift_date' => $date, 'employee' => $employee))) {
                $shiftment  = $exist;
            } else {
                $shiftment->setId($this->getHelper()->getUniqueId());
            }
            $shiftment->setDate($date);
            $shiftment->setEmployee($employee);
            $shiftment->setOfficeHour($this->getEntityManager()->getReference('GatotKacaErpMainBundle:OfficeHour', $input->shift_ohid));
            //Simpan shiftment
            $this->setEntityLog($shiftment);
            $this->getEntityManager()->persist($shiftment);
        }
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($shiftment, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee shiftment with id {$shiftment->getId()}");

            return $shiftment->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menyimpan data education
     *
     * @param mixed $input
     **/
    public function saveEducation($input)
    {
        $education  = new EmployeeEducation();
        if (isset($input->education_id) && $input->education_id != '') {
            $education  = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeEducation')->find($input->education_id);
            $this->setAction("modify");
        } else {
            $education->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $education->setName(strtoupper($input->education_name));
        $education->setSpecialist((strtoupper($input->education_specialist)));
        $education->setEmployee($this->getEntityManager()->getReference('GatotKacaErpHumanResourcesBundle:Employee', $input->employee_id));
        $education->setEducation($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Education', $input->education_lid));
        $education->setDistrict($this->getEntityManager()->getReference('GatotKacaErpMainBundle:District', $input->education_district));
        $education->setStart(new \DateTime($input->education_start.'-01-01'));
        $education->setEnd(new \DateTime($input->education_end.'-01-01'));
        //Simpan education
        $this->setEntityLog($education);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($education);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($education, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee education with id {$education->getId()}");

            return $education->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menyimpan data family
     *
     * @param mixed $input
     **/
    public function saveFamily($input)
    {
        $family = new EmployeeFamily();
        if (isset($input->family_id) && $input->family_id != '') {
            $family = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeFamily')->find($input->family_id);
            $this->setAction("modify");
        } else {
            $family->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $family->setFirstName(strtoupper($input->family_fname));
        $family->setLastName(strtoupper($input->family_lname));
        $family->setRelation(strtoupper($input->family_level));
        $family->setBod(new \DateTime($input->family_born));
        $family->setEmployee($this->getEntityManager()->getReference('GatotKacaErpHumanResourcesBundle:Employee', $input->employee_id));
        $family->setEducation($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Education', $input->family_education));
        if ($input->family_institute !== null && $input->family_institute !== '') {
            $family->setInstitute(strtoupper($input->family_institute));
        }
        //Simpan family
        $this->setEntityLog($family);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($family);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($family, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee family with id {$family->getId()}");

            return $family->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menyimpan data experience
     *
     * @param mixed $input
     **/
    public function saveExperience($input)
    {
        $experience = new EmployeeExperience();
        if (isset($input->experience_id) && $input->experience_id != '') {
            $experience = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeExperience')->find($input->experience_id);
            $this->setAction("modify");
        } else {
            $experience->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $experience->setCompany(strtoupper($input->experience_company));
        $experience->setStart(new \DateTime($input->experience_start));
        $experience->setEnd(new \DateTime($input->experience_end));
        $experience->setEmployee($this->getEntityManager()->getReference('GatotKacaErpHumanResourcesBundle:Employee', $input->employee_id));
        $experience->setJobTitle(strtoupper($input->experience_jobtitle));
        if ($input->experience_reason !== null && $input->experience_reason !== '') {
            $experience->setReason(strtoupper($input->experience_reason));
        }
        //Simpan experience
        $this->setEntityLog($experience);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($experience);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($experience, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee experience with id {$experience->getId()}");

            return $experience->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menyimpan data training
     *
     * @param mixed $input
     **/
    public function saveTraining($input)
    {
        $training   = new EmployeeTraining();
        if (isset($input->training_id) && $input->training_id != '') {
            $training   = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeTraining')->find($input->training_id);
            $this->setAction("modify");
        } else {
            $training->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $training->setSkill(strtoupper($input->training_skill));
        $training->setName(strtoupper($input->training_name));
        $training->setInstitute(strtoupper($input->training_institute));
        $training->setStart(new \DateTime($input->training_start));
        $training->setEnd(new \DateTime($input->training_end));
        $training->setEmployee($this->getEntityManager()->getReference('GatotKacaErpHumanResourcesBundle:Employee', $input->employee_id));
        $training->setDistrict($this->getEntityManager()->getReference('GatotKacaErpMainBundle:District', $input->training_district));
        //Simpan training
        $this->setEntityLog($training);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($training);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($training, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee training with id {$training->getId()}");

            return $training->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menyimpan data language
     *
     * @param mixed $input
     **/
    public function saveLanguage($input)
    {
        $language   = new EmployeeLanguage();
        if (isset($input->language_id) && $input->language_id != '') {
            $language   = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeLanguage')->find($input->language_id);
            $this->setAction("modify");
        } else {
            $language->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $language->setEmployee($this->getEntityManager()->getReference('GatotKacaErpHumanResourcesBundle:Employee', $input->employee_id));
        $language->setLanguage($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Language', $input->language_lid));
        $language->setSpoken($input->language_spoken);
        $language->setWriten($input->language_writen);
        //Simpan language
        $this->setEntityLog($language);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($language);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($language, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee language with id {$language->getId()}");

            return $language->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menyimpan data organitation
     *
     * @param mixed $input
     **/
    public function saveOrganitation($input)
    {
        $org    = new EmployeeOrganitation();
        if (isset($input->org_id) && $input->org_id != '') {
            $org    = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeOrganitation')->find($input->org_id);
            $this->setAction("modify");
        } else {
            $org->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $org->setEmployee($this->getEntityManager()->getReference('GatotKacaErpHumanResourcesBundle:Employee', $input->employee_id));
        $org->setName(strtoupper($input->org_name));
        $org->setCategories($input->org_categories);
        $org->setPosition($input->org_position);
        $org->setStart(new \DateTime($input->org_start));
        $org->setEnd(new \DateTime($input->org_end));
        //Simpan org
        $this->setEntityLog($org);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($org);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($org, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee organitation with id {$org->getId()}");

            return $org->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menyimpan data career
     *
     * @param mixed $input
     **/
    public function saveCareer($input)
    {
        $career = new Career();
        if (isset($input->career_id) && $input->career_id != '') {
            $career = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Career')->find($input->career_id);
            $this->setAction("modify");
        } else {
            $career->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $employee   = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->find($input->employee_id);
        $company    = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Company')->find($input->career_company);
        $jobtitle   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:JobTitle')->find($input->career_jobtitle);
        $supervisor = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->find($input->career_supervisor);
        $employee->setCompany($company);
        $employee->setJobTitle($jobtitle);
        $employee->setSupervisor($supervisor);
        $career->setEmployee($employee);
        $career->setReferenceNumber($input->career_refno);
        $career->setPromoteDate(new \DateTime($input->career_date));
        $career->setOldCompany($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Company', $input->employee_company));
        $career->setOldJobTitle($this->getEntityManager()->getReference('GatotKacaErpMainBundle:JobTitle', $input->employee_jobtitle));
        $career->setOldSupervisor($this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->find($input->employee_supervisor));
        $career->setNewCompany($company);
        $career->setNewJobTitle($jobtitle);
        $career->setNewSupervisor($supervisor);
        //Simpan career
        $this->setEntityLog($career);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($career);
            $this->getEntityManager()->persist($employee);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($career, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee career with id {$career->getId()}");

            return $career->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data experience
     * @return boolean
     **/
    public function deleteExperience($id)
    {
        $experience = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeExperience')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($experience);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting employee experience with id {$experience->getCompany()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$experience->getCompany()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data family
     * @return boolean
     **/
    public function deleteFamily($id)
    {
        $family = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeFamily')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($family);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting employee family with id {$family->getFirstName()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$family->getFirstName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data language
     * @return boolean
     **/
    public function deleteLanguage($id)
    {
        $language   = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeLanguage')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($language);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting employee language with id {$language->getLanguage()->getName()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$language->getLanguage()->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data organitation
     * @return boolean
     **/
    public function deleteOrganitation($id)
    {
        $organitation   = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeOrganitation')->find($id);
        $connection     = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($organitation);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting employee organitation with id {$organitation->getName()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$organitation->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data education
     * @return boolean
     **/
    public function deleteEducation($id)
    {
        $education  = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeEducation')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($education);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting employee education with id {$education->getName()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$education->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data training
     * @return boolean
     **/
    public function deleteTraining($id)
    {
        $training   = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:EmployeeTraining')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($training);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting employee training with id {$training->getName()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$training->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data career
     * @return boolean
     **/
    public function deleteCareer($id)
    {
        $career     = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Career')->find($id);
        $employee   = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->find($career->getEmployee()->getId());
        $company    = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Company')->find($career->getOldCompany()->getId());
        $jobtitle   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:JobTitle')->find($career->getOldJobTitle()->getId());
        $supervisor = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->find($career->getOldSupervisor()->getId());
        if ($career->getNewJobtitle()->getId() !== $employee->getJobtitle()->getId()) {
            $this->setMessage("older data can't be removed.");

            return false;
        }
        $employee->setCompany($company);
        $employee->setJobTitle($jobtitle);
        $employee->setSupervisor($supervisor);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($employee);
            $this->getEntityManager()->remove($career);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting career with id {$career->getReferenceNumber()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$career->getReferenceNumber()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data shiftment
     * @return boolean
     **/
    public function deleteShiftment($id)
    {
        $shiftment  = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Shiftment')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($shiftment);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting shiftment with id {$shiftment->getDate()->format('Y-m-d')}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$shiftment->getDate()->format('Y-m-d')} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk mendapatkan list employee yang berulang tahun
     * @param  boolean $isHRD
     * @return mixed   employee birthday
     **/
    public function getEmployeeBirthday()
    {
        $today   = new \DateTime();
        $mapping = new ResultSetMapping();
        $mapping->addScalarResult('employee_id', 'employee_id');
        $mapping->addScalarResult('employee_code', 'employee_code');
        $mapping->addScalarResult('employee_fname', 'employee_fname');
        $mapping->addScalarResult('employee_lname', 'employee_lname');
        $mapping->addScalarResult('employee_company', 'employee_company');
        $mapping->addScalarResult('employee_jobtitle', 'employee_jobtitle');
        $mapping->addScalarResult('employee_bod', 'employee_bod');
        $mapping->addScalarResult('employee_age', 'employee_age');
        $mapping->addScalarResult('employee_username', 'employee_username');
        $query = $this->getEntityManager()->createNativeQuery(
            "SELECT
                e.id AS employee_id,
                e.code AS employee_code,
                e.fname AS employee_fname,
                e.lname AS employee_lname,
                c.name AS employee_company,
                jt.name AS employee_jobtitle,
                e.utl_user_id AS employee_username,
                TO_CHAR(e.bod, '{$this->getHelper()->getSession()->get('date_format_text')}') AS employee_bod,
                EXTRACT(year from AGE(NOW(), e.bod)) AS employee_age
            FROM
                mtr_employee e
            LEFT JOIN
                sys_jobtitle jt
                ON
                e.sys_jobtitle_id = jt.id
            LEFT JOIN
                sys_company c
                ON
                e.sys_company_id = c.id
            WHERE
                e.bod::text LIKE '%-{$today->format('m-d')}' AND e.status = true",
            $mapping
        );
        $this->setModelLog("get employee birthday");

        return $query->getResult();
    }

    /**
     * Untuk menyimpan data resign
     *
     * @param mixed $input
     **/
    public function resign($input)
    {
        if (isset($input->employee_id) && $input->employee_id != '') {
            $employee  = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->find($input->employee_id);
            $this->setAction("modify");
        }
        $date = new \DateTime($input->resign_date);
        $employee->setReason(strtoupper($input->resign_reason));
        $employee->setResignDate($date);
        $employee->setStatus((strtotime($date->format('Y-m-d')) <= strtotime(date('Y-m-d'))) ? false : true);
        $employee->setIsResign(true);
        //Simpan employee
        $this->setEntityLog($employee);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($employee);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($employee, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving employee with id {$employee->getId()}");

            return $employee->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menyimpan data resign
     *
     * @param mixed $input
     **/
    public function resigning()
    {
        $this->setAction('modify');
        $date      = new \DateTime();
        $employees = $this->getEntityManager()
            ->createQueryBuilder()
            ->select("e.id AS id")
            ->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
            ->where("e.status = true AND e.is_resign = true AND e.resign_date <= '{$date->format('Y-m-d')}'")
            ->getQuery()
            ->getResult();
        if (count($employees) === 0) {
            $this->setMessage("resigning employee with empty result");
            $this->setModelLog($this->getMessage());

            return false;
        }
        //Simpan employee
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            foreach ($employees as $key => $employee) {
                $employee  = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->find($employee['id']);
                $employee->setStatus(false);
                $this->getEntityManager()->persist($employee);
            }
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("resigning employee with effective <= {$date->format('Y-m-d')}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return 'a';
        }
    }
}
