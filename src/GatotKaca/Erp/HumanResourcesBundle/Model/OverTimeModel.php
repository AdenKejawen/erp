<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/ReligionModel.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\HumanResourcesBundle\Model;

use GatotKaca\Erp\HumanResourcesBundle\Entity\Overtime;
use GatotKaca\Erp\HumanResourcesBundle\Entity\Employee;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class OverTimeModel extends BaseModel
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

    private function getEmployee()
    {
        return $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->findOneBy(array('username' => $this->getHelper()->getSession()->get('user_id')));
    }

    /**
     * Untuk mendapatkan list overtime berdasarkan limit
     *
     * @param  integer $from
     * @param  integer $to
     * @return array   result
     **/
    public function getList($from = null, $to = null, $isSupervise = 'false', $isApprove = 'all', $start = 0, $limit = 25)
    {
        $extra = '';
        if ($from === '') {
            $from = new \DateTime(date('Y-m-1'));
            $to   = cal_days_in_month(CAL_GREGORIAN, $from->format('m'), $from->format('Y'));
            $to   = new \DateTime($to.'-'.$from->format('m').'-'.$from->format('Y'));
        } else {
            $from = new \DateTime($from);
            $to   = new \DateTime($to);
        }
        $extra .= " AND ot.date BETWEEN '{$from->format('Y-m-d')}' AND '{$to->format('Y-m-d')}'";
        $extra .= $isApprove !== 'all' ? " AND ot.is_approve = {$isApprove}" : "" ;
        $extra .= $isSupervise !== 'false' ? " AND e.supervisor = '{$this->getEmployee()->getId()}'" : " AND e.id = '{$this->getEmployee()->getId()}'";
        $qb    = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select(
            "ot.id AS ot_id,
            TO_CHAR(ot.date, '{$this->getHelper()->getSession()->get('date_format_text')}') AS ot_date,
            e.first_name AS ot_fname,
            e.last_name AS ot_lname,
            ot.total AS ot_real,
            ot.is_approve AS ot_isapprove"
        )
        ->from('GatotKacaErpHumanResourcesBundle:Overtime', 'ot')
        ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'ot.employee = e.id')
        ->where("ot.is_expire = false{$extra}")
        ->setFirstResult($start)
        ->setMaxResults($limit)
        ->orderBy('ot.date, e.fname', 'ASC')
        ->getQuery();
        $this->setModelLog("get overtime from {$from->format('Y-m-d')} to {$to->format('Y-m-d')}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total overtime
     *
     * @param  integer $from
     * @param  integer $to
     * @return array   result
     **/
    public function countList($from = null, $to = null, $isSupervise = 'false', $isApprove = 'all')
    {
        $extra = '';
        if ($from === '') {
            $from = new \DateTime(date('Y-m-1'));
            $to   = cal_days_in_month(CAL_GREGORIAN, $from->format('m'), $from->format('Y'));
            $to   = new \DateTime($to.'-'.$from->format('m').'-'.$from->format('Y'));
        } else {
            $from = new \DateTime($from);
            $to   = new \DateTime($to);
        }
        $extra .= " AND ot.date BETWEEN '{$from->format('Y-m-d')}' AND '{$to->format('Y-m-d')}'";
        $extra .= $isApprove !== 'all' ? " AND ot.is_approve = {$isApprove}" : "" ;
        $extra .= $isSupervise !== 'false' ? " AND e.supervisor = '{$this->getEmployee()->getId()}'" : " AND e.id = '{$this->getEmployee()->getId()}'";
        $qb    = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('ot.id AS ot_id')
            ->from('GatotKacaErpHumanResourcesBundle:Overtime', 'ot')
            ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'ot.employee = e.id')
            ->where("ot.is_expire = false{$extra}")
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan list Over Time berdasarkan criteria
     *
     * @param string criteria
     * @param string value
     * @param date from
     * @param date to
     **/
    public function getBy($criteria, $value, $from = null, $to = null, $isApprove = array(), $start = 0, $limit = 25)
    {
        $from  = new \DateTime($from);
        $to    = new \DateTime($to);
        $isApprove = implode(', ', $isApprove);
        $extra = '';
        $extra .= $from !== null ? " AND ot.date BETWEEN '{$from->format('Y-m-d')} 00:00:00' AND '{$to->format('Y-m-d')} 23:59:59'" : "";
        $extra .= " AND ot.is_approve IN({$isApprove})";
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "ot.id AS ot_id,
                e.id AS employee_id,
                e.code AS employee_code,
                e.first_name AS employee_fname,
                e.last_name AS employee_lname,
                TO_CHAR(ot.date, 'Dy') AS ot_day,
                TO_CHAR(ot.date, '{$this->getHelper()->getSession()->get('date_format_text')}') AS ot_date,
                TO_CHAR(ot.start, 'HH24:MI:SS') AS ot_start,
                TO_CHAR(ot.end, 'HH24:MI:SS') AS ot_end,
                ot.total AS ot_real,
                ot.is_approve AS ot_status,
                ap.first_name AS ot_approvedby"
            )
            ->from('GatotKacaErpHumanResourcesBundle:Overtime', 'ot')
            ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'ot.employee = e.id')
            ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'ap', 'WITH', 'ot.approved_by = ap.id')
            ->where("ot.{$criteria} = :{$criteria}{$extra}")
            ->setParameter($criteria, $value)
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->orderBy('ot.date', 'ASC')
            ->getQuery();
        $this->setModelLog("get attendance with {$criteria} {$value}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total Over Time berdasarkan criteria
     *
     * @param string criteria
     * @param string value
     * @param date from
     * @param date to
     **/
    public function countBy($criteria, $value, $from = null, $to = null, $isApprove = array())
    {
        $from  = new \DateTime($from);
        $to    = new \DateTime($to);
        $isApprove = implode(', ', $isApprove);
        $extra = '';
        $extra .= $from !== null ? " AND ot.date BETWEEN '{$from->format('Y-m-d')} 00:00:00' AND '{$to->format('Y-m-d')} 23:59:59'" : "";
        $extra .= " AND ot.is_approve IN({$isApprove})";
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('ot.id AS ot_id')
            ->from('GatotKacaErpHumanResourcesBundle:Overtime', 'ot')
            ->where("ot.{$criteria} = :{$criteria}{$extra}")
            ->setParameter($criteria, $value)
            ->orderBy('ot.date', 'ASC')
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan list Overtime berdasarkan tanggal
     *
     * @param date dateStart
     * @param date dateEnd
     * @param int start
     * @param int limit
     **/
    public function getByDate($dateStart, $dateEnd, $start, $limit)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        if ($dateStart === '') {
            $dateStart = new \DateTime();
            $dateEnd   = new \DateTime();
        } else {
            $dateStart = new \DateTime($dateStart);
            $dateEnd   = new \DateTime($dateEnd);
        }
        $query = $qb->select(
            "ot.id AS ot_id,
            e.id AS employee_id,
            e.code AS employee_code,
            e.first_name AS employee_fname,
            e.last_name AS employee_lname,
            TO_CHAR(ot.date, 'Dy') AS ot_day,
            TO_CHAR(ot.date, '{$this->getHelper()->getSession()->get('date_format_text')}') AS ot_date,
            TO_CHAR(ot.start, 'HH24:MI:SS') AS ot_start,
            TO_CHAR(ot.end, 'HH24:MI:SS') AS ot_end,
            ot.total AS ot_real,
            ot.is_approve AS ot_status,
            ap.first_name AS ot_approvedby"
        )
        ->from('GatotKacaErpHumanResourcesBundle:Overtime', 'ot')
        ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'ot.employee = e.id')
        ->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'ap', 'WITH', 'ot.approved_by = ap.id')
        ->where("ot.date BETWEEN :date_start AND :date_end")
        ->setParameter('date_start', $dateStart->format('Y-m-d').' 00:00:00')
        ->setParameter('date_end', $dateEnd->format('Y-m-d').' 23:59:59')
        ->setFirstResult($start)
        ->setMaxResults($limit)
        ->orderBy('ot.date', 'ASC')
        ->getQuery();
        $this->setModelLog("get attendance from {$dateStart->format('d-m-Y')} to {$dateEnd->format('d-m-Y')}");

        return $query->getResult();
    }

     /**
     * Untuk mendapatkan total Overtime berdasarkan tanggal
     *
     * @param date dateStart
     * @param date dateEnd
     * @param int start
     * @param int limit
     **/
    public function countByDate($dateStart, $dateEnd)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        if ($dateStart === '') {
            $dateStart = new \DateTime();
            $dateEnd   = new \DateTime();
        } else {
            $dateStart = new \DateTime($dateStart);
            $dateEnd   = new \DateTime($dateEnd);
        }
        $query = $qb->select('ot.id AS ot_id')
            ->from('GatotKacaErpHumanResourcesBundle:Overtime', 'ot')
            ->where("ot.date BETWEEN :date_start AND :date_end")
            ->setParameter('date_start', $dateStart->format('Y-m-d').' 00:00:00')
            ->setParameter('date_end', $dateEnd->format('Y-m-d').' 23:59:59')
            ->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk menyimpan data overtime
     *
     * @param mixed $input
     **/
    public function save($input)
    {
        $employee = $this->getEmployee();
        if (!$employee->getIsOverTime()) {
            $this->setMessage("You don't get overtime benefit");
            $this->setModelLog($this->getMessage());

            return false;
        }
        if ($employee->getIsManualOverTime()) {
            $this->setMessage("Please use manual form");
            $this->setModelLog($this->getMessage());

            return false;
        }
        if (!$this->setExpire()) {
            $this->setMessage("Unknow Error. Please contact your IT Division");
            $this->setModelLog($this->getMessage());

            return false;
        }
        $otStart   = new \DateTime(date('Y-m-d').' '.$input->ot_start_h.':'.$input->ot_start_m.':00');
        $otEnd     = new \DateTime(date('Y-m-d').' '.$input->ot_end_h.':'.$input->ot_end_m.':00');
        $date      = new \DateTime($input->ot_date);
        $overtime  = new Overtime();
        $company   = $this->getHelper()->getModelManager($this->getEntityManager())->getCompany();
        $isholiday = $company->isWorkDay($date->format('N'), $employee->getCompany()->getId());
        $otReal    = $this->calculate($otStart, $otEnd, $isholiday);
        if (isset($input->ot_id) && $input->ot_id != '') {
            $overtime = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Overtime')->find($input->ot_id);
            if ($overtime->getIsApprove() && $input->ot_status !== 2) {
                $this->setMessage("Overtime is approved");
                $this->setModelLog($this->getMessage());

                return false;
            }
            if ($input->ot_status !== 0) {
                $overtime->setIsApprove($input->ot_status);
                $overtime->setApprovedBy($this->getEmployee());
            }
            $this->setAction("modify");
        } else {
            $overtime->setId($this->getHelper()->getUniqueId());
            $overtime->setEmployee($employee);
            $this->setAction("create");
            if ($input->ot_status === 1) {
                $overtime->setIsApprove($input->ot_status);
                $overtime->setApprovedBy($this->getEmployee());
            }
        }
        $overtime->setDate($date);
        $overtime->setJobDescription($input->ot_description);
        $overtime->setStart($otStart);
        $overtime->setEnd($otEnd);
        $overtime->setTotal($otReal / 2);
        $overtime->setIsHoliday($isholiday);
        //Simpan overtime
        $this->setEntityLog($overtime);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($overtime);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($overtime, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving overtime with id {$overtime->getId()}");

            return $overtime->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage($e->getMessage());
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    private function calculate($otStart, $otEnd, $isholiday = false)
    {
        $isholiday = $isholiday ? 'holiday' : 'workday';
        $setting   = $this->getHelper()->getModelManager($this->getEntityManager())->getSetting();
        //Get Overtime before rounded
        $breakTime = $setting->get('ot_breaktime_value');
        $otReal    = intval($this->getHelper()->getTimeDiff($otStart, $otEnd) / 60);
        if ($otReal < $setting->get('minimum_ot_value')) {
            return 0;
        }
        $otReal     += $setting->get('att_adjust_value');
        $roundBy    = $setting->get('att_round_value') == '0' ? 1 : $setting->get('att_round_value');
        $roundValue = intval($otReal/$roundBy);
        $roundValue = $roundValue * $roundBy;
        if ($roundValue > $breakTime && $breakTime != '0') {
            $multiple = intval($roundValue/$breakTime);
            if ($roundValue / ($multiple * $breakTime) === 1) {
                $multiple--;
            }
            $roundValue -= ($setting->get('ot_breaktime_minus') * $multiple);
        }
        //Rounding Overtime
        $setting->setLoyal($roundValue);

        return intval($setting->calculate($setting->getMathNotation("ot_fixed_{$isholiday}_formula")) / 30);
    }

    private function setExpire()
    {
        //Get Attendance Start
        $setting = $this->getHelper()->getModelManager($this->getEntityManager())->getSetting();
        $date    = $setting->calculate($setting->getMathNotation('att_start_date'));
        $month   = $setting->calculate($setting->getMathNotation('att_start_month'));
        $date    = new \DateTime(date('Y').'-'.$month.'-'.$date);
        $expire  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('ot.id AS id')
            ->from('GatotKacaErpHumanResourcesBundle:Overtime', 'ot')
            ->where("ot.date < :date")
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
        foreach ($expire as $key => $value) {
            $overtime = $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Overtime')->find($value['id']);
            $overtime->setIsexpire(true);
            $this->getEntityManager()->persist($overtime);
            $this->getEntityManager()->flush();
        }
        //Simpan overtime
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->flush();
            $connection->commit();

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();

            return false;
        }
    }
}
