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

use GatotKaca\Erp\HumanResourcesBundle\Entity\AttendanceFromMechine;
use GatotKaca\Erp\HumanResourcesBundle\Entity\Attendance;
use GatotKaca\Erp\HumanResourcesBundle\Entity\Employee;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class AttendanceModel extends BaseModel{
	/**
	 * Constructor
	 *
	 * @param EntityManager $entityManager
	 * @param Helper $helper
	 **/
	public function __construct(\Doctrine\ORM\EntityManager $entityManager, \GatotKaca\Erp\MainBundle\Helper\Helper $helper){
		parent::__construct($entityManager, $helper);
	}
	
	/**
	 * Untuk mendapatkan list Attendance berdasarkan criteria
	 * 
	 * @param string criteria
	 * @param string value
	 * @param date from
	 * @param date to
	 **/
	public function getBy($criteria, $value, $from = '', $to = ''){
		$extra	= '';
		if($from !== NULL && $from != ''){
			$extra	.= " AND a.att_date BETWEEN '{$from}' AND '{$to}'";
		}else if($from === NULL){
			$date	= new \DateTime();
			$days	= cal_days_in_month(CAL_GREGORIAN, $date->format('m'), $date->format('Y'));
			$extra	.= " AND a.att_date BETWEEN '{$date->format('Y-m-')}1 00:00:00' AND '{$date->format('Y-m-')}{$days} 23:59:59'";
		}
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("
					a.id AS att_id,
					e.id AS employee_id,
					e.code AS employee_code,
					e.fname AS employee_fname,
					e.lname AS employee_lname,
					TO_CHAR(a.att_date, 'Dy') AS att_day,
					TO_CHAR(a.att_date, 'DD-MM-YYYY') AS att_date,
					TO_CHAR(a.time_in, 'HH24:MI:SS') AS att_in,
					TO_CHAR(a.time_out, 'HH24:MI:SS') AS att_out,
					TO_CHAR(a.late, 'HH24:MI:SS') AS att_late,
					TO_CHAR(a.loyal, 'HH24:MI:SS') AS att_loyal,
					a.ismiss AS ismiss,
					a.miss AS miss,
					a.description AS description
				")
				->from('GatotKacaErpHumanResourcesBundle:Attendance', 'a')
				->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'a.employee = e.id')
				->where("a.{$criteria} = :{$criteria}{$extra}")
				->setParameter($criteria, $value)
				->orderBy('a.att_date', 'ASC')
				->getQuery();
		$this->setModelLog("get attendance with {$criteria} {$value}");
		return $query->getResult();
	}

	/**
	 * Untuk mendapatkan list Attendance berdasarkan Date
	 * 
	 * @param date dateStart
	 * @param date dateEnd
	 * @param int start
	 * @param int limit
	 **/
	public function getByDate($dateStart, $dateEnd, $isMiss){
		$qb	= $this->getEntityManager()->createQueryBuilder();
		if($dateStart === ''){
			$dateStart	= new \DateTime();
			$dateEnd	= new \DateTime();
		}else{
			$dateStart	= new \DateTime($dateStart);
			$dateEnd	= new \DateTime($dateEnd);
		}
		$query	= $qb->select("
					a.id AS att_id,
					e.id AS employee_id,
					e.code AS employee_code,
					e.fname AS employee_fname,
					e.lname AS employee_lname,
					TO_CHAR(a.att_date, 'Dy') AS att_day,
					TO_CHAR(a.att_date, 'DD-MM-YYYY') AS att_date,
					TO_CHAR(a.time_in, 'HH24:MI:SS') AS att_in,
					TO_CHAR(a.time_out, 'HH24:MI:SS') AS att_out,
					TO_CHAR(a.late, 'HH24:MI:SS') AS att_late,
					TO_CHAR(a.loyal, 'HH24:MI:SS') AS att_loyal,
					a.ismiss AS ismiss,
					a.miss AS miss,
					a.description AS description
				")
				->from('GatotKacaErpHumanResourcesBundle:Attendance', 'a')
				->leftJoin('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'a.employee = e.id')
				->where("a.ismiss = :ismiss AND a.att_date BETWEEN :date_start AND :date_end")
				->setParameter('date_start', $dateStart->format('Y-m-d').' 00:00:00')
				->setParameter('date_end', $dateEnd->format('Y-m-d').' 23:59:59')
				->setParameter('ismiss', $qb->expr()->literal($isMiss === 'true' ? TRUE : FALSE))
				->orderBy('a.att_date, e.fname', 'ASC')
				->getQuery();
		$this->setModelLog("get attendance from {$dateStart->format('d-m-Y')} to {$dateEnd->format('d-m-Y')}");
		return $query->getResult();
	}
	
	/**
	 * Untuk menyimpan data attendance sementara
	 * 
	 * @param mixed data
	 * @param date date
	 **/
	public function saveFromMechine($data, $date){
		$this->setAction('create');
		$employee	= $this->getEntityManager()
					->createQueryBuilder()
					->select('e.code')
					->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
					->getQuery()
					->getResult();
		//Start transaction
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$date	= new \DateTime($date);
			foreach($data as $key => $val){
				if(array_key_exists(7, $val)){//Key length min 8
					$employee	= trim($val[7]);
					if( $employee != '' && $val != NULL){
						$timestamp	= date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '.trim($val[1])));
						$time	= new \DateTime($timestamp);
						$aMechine	= new AttendanceFromMechine();
						$aMechine->setEmployee($employee);
						$aMechine->setAttDate($date);
						$aMechine->setTime($time);
						$this->getEntityManager()->persist($aMechine);
					}
				}
			}
			$this->getEntityManager()->flush();
			$connection->commit();
			$this->setModelLog("upload attendance to mechine for {$date->format('Y-m-d')}");
			return TRUE;
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving attendance data");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}
	
	/**
	 * Untuk mendapatkan list attendance from mechine
	 * 
	 * @param integer start
	 * @param integer limit
	 **/
	public function getFromMechine($start, $limit){
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("
					a.id AS att_id,
					a.employee AS att_emplcode,
					TO_CHAR(a.att_date, 'DD-MM-YYYY') AS att_date,
					TO_CHAR(a.time, 'HH24:MI:SS') AS att_time
				")
				->from('GatotKacaErpHumanResourcesBundle:AttendanceFromMechine', 'a')
				->setFirstResult($start)
				->setMaxResults($limit)
				->getQuery();
		$this->setModelLog("get attendance from mechine from {$start} to {$limit}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan total list attendance from mechine
	 * 
	 * @param date $from
	 * @param date $to
	 **/
	public function countTotalFromMechine(){
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("
					a.id AS att_id
				")
				->from('GatotKacaErpHumanResourcesBundle:AttendanceFromMechine', 'a')
				->getQuery();
		return count($query->getResult());
	}
	
	/**
	 * Memproses semua attendance from mechine berdasarkan tanggal
	 * 
	 * @param date $from
	 * @param date $to
	 * @return boolean
	 **/
	public function procces(){
		$this->setAction('create');
		$employee	= $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Employee')->findAll();
		$date		= $this->getEntityManager()
					->createQueryBuilder()
					->select('
						MIN(a.att_date) AS start_date,
						MAX(a.att_date) AS end_date
					')
					->from('GatotKacaErpHumanResourcesBundle:AttendanceFromMechine', 'a')
					->getQuery()
					->getOneOrNullResult();
		if($date === NULL){
			return FALSE;
		}
		$from	= strtotime($date['start_date']);
		$to		= strtotime($date['end_date']);
		//Start transaction
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try{
			for($i = $from; $i <= $to; $i = strtotime('+1 day', $i)){//Looping per tanggal, aku sangat menyesal harus melakukan ini
				foreach ($employee as $key => $val){//Ini sungguh diluar dugaanku, tolong buat PL/SQL untuk ini
					$date	= date('Y-m-d', $i);
					$time	= $this->getEntityManager()
							->createQueryBuilder()
							->select('
								MIN(a.time) AS timein,
								MAX(a.time) AS timeout,
								MAX(a.time) - MIN(a.time) AS jamkerja
							')
							->from('GatotKacaErpHumanResourcesBundle:AttendanceFromMechine', 'a')
							->where('a.att_date = :date AND a.employee = :employee')
							->setParameter('date', $date)
							->setParameter('employee', $val->getCode())
							->getQuery()
							->getOneOrNullResult();
					$officehour	= $this->getShiftByEmployee($val->getId());
					//Check isExistAttendance
					$isExist	= $this->getEntityManager()
								->createQueryBuilder()
								->select('a.id')
								->from('GatotKacaErpHumanResourcesBundle:Attendance', 'a')
								->join('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'a.employee = e.id')
								->where('a.att_date = :date AND e.id = :employee')
								->setParameter('date', $date)
								->setParameter('employee', $val->getId())
								->getQuery()
								->getOneOrNullResult();
					$attendance	= new Attendance();
					if($isExist){
						$attendance	= $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Attendance')->find($isExist['id']);
					}else{
						$attendance->setId($this->getHelper()->getUniqueId());
					}
					if($time['timein'] !== NULL && $time['timeout'] !== NULL){
						$absenIn	= new \DateTime(date('Y-m-d H:i:s', strtotime($date.' '.$time['timein'])));
						$absenOut	= new \DateTime(date('Y-m-d H:i:s', strtotime($date.' '.$time['timeout'])));
						$timeIn		= new \DateTime(date('Y-m-d H:i:s', strtotime($date.' '.$officehour['timein'])));
						$timeOut	= new \DateTime(date('Y-m-d H:i:s', strtotime($date.' '.$officehour['timeout'])));
						$absensi	= $this->calWorkTime($timeIn, $timeOut, $absenIn, $absenOut);
						$attendance->setTimeIn($absenIn);
						$attendance->setTimeOut($absenOut);
						$attendance->setLate(new \DateTime(date('Y-m-d H:i:s', $absensi['late'])));
						$attendance->setLoyal(new \DateTime(date('Y-m-d H:i:s', $absensi['loyal'])));
						$attendance->setMiss('IN');
						$attendance->setIsmiss(FALSE);
						$attendance->setDescription(NULL);
					}elseif(!$isExist){
						$attendance->setIsmiss(TRUE);
						$attendance->setDescription('Attendance is not avialable');
					}
					$attendance->setEmployee($val);
					$attendance->setShift($val->getShift());
					$attendance->setAttDate(new \DateTime($date));
					$this->setEntityLog($attendance);
					$this->getEntityManager()->persist($attendance);
				}
			}
			//Aku tidak tau apakah ada yang belum ke proses disebabkan ketidakkosistensian
			//Tapi yang pasti, apapun yang terjadi semua data harus dimusnahkan!!!
			$from	= new \DateTime(date('Y-m-d', $from));
			$to		= new \DateTime(date('Y-m-d', $to));
			$this->getEntityManager()->createQueryBuilder()
				->delete()
				->from('GatotKacaErpHumanResourcesBundle:AttendanceFromMechine', 'a')
				->where('a.att_date BETWEEN :start AND :end')
				->setParameter('start', $from)
				->setParameter('end', $to)
				->getQuery()
				->execute();
			$this->getEntityManager()->flush();
			$connection->commit();
			$this->setModelLog("proccessing attendance from mechine from {$from->format('d-m-Y')} to {$to->format('d-m-Y')}");
			return TRUE;
		}catch(\Exception $e){
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage($e->getMessage());
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}
	
	/**
	 * Untuk menyimpan data attendance
	 *
	 * @param mixed $input
	 **/
	public function save($input){
		$absenIn	= new \DateTime(date('Y-m-d').' '.$input->att_in_h.':'.$input->att_in_m.':00');
		$absenOut	= new \DateTime(date('Y-m-d').' '.$input->att_out_h.':'.$input->att_out_m.':00');
		$attDate	= new \DateTime(date('Y-m-d', strtotime($input->att_date)));
		$attendance	= $this->getEntityManager()->getRepository('GatotKacaErpHumanResourcesBundle:Attendance')->find($input->att_id);
		$officehour	= $this->getShiftByEmployee($attendance->getEmployee()->getId());
		$timeIn		= new \DateTime(date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '.$officehour['timein'])));
		$timeOut	= new \DateTime(date('Y-m-d H:i:s', strtotime(date('Y-m-d').' '.$officehour['timeout'])));
		$absensi	= $this->calWorkTime($timeIn, $timeOut, $absenIn, $absenOut);
		$this->setAction("modify");
		$attendance->setAttDate($attDate);
		$attendance->setTimeIn($absenIn);
		$attendance->setTimeOut($absenOut);
		$attendance->setLate(new \DateTime(date('Y-m-d H:i:s', $absensi['late'])));
		$attendance->setLoyal(new \DateTime(date('Y-m-d H:i:s', $absensi['loyal'])));
		$attendance->setIsmiss(isset($input->ismiss));
		$attendance->setMiss($input->miss);
		$attendance->setDescription($input->description.'. Manual Input');
		//Simpan Attendance
		$this->setEntityLog($attendance);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->persist($attendance);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($attendance, LockMode::PESSIMISTIC_READ);
			$connection->commit();
			$this->setModelLog("saving attendance with id {$attendance->getId()}");
			return $attendance->getId();
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving attendance");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}
	
	/**
	 * Untuk mengambil data shift karyawan berdasarkan id
	 * 
	 * @param string id
	 * @param DateTime date
	 * 
	 * @return mixed shiftment
	 **/
	private function getShiftByEmployee($id, $date = NULL){
		$officehour	= NULL;
		/**
		 * Is fixed schedule? 
		 **/
		$shift		= $this->getEntityManager()->createQueryBuilder()
					->select('e.isfixed')
					->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
					->where('e.id = :employee')
					->setParameter('employee', $id)
					->getQuery()
					->getOneOrNullResult();
		if($shift['isfixed']){
			$officehour	= $this->getEntityManager()
						->createQueryBuilder()
						->select("
							e.id,
							TO_CHAR(o.time_in, 'HH24:MI:SS') AS timein,
							TO_CHAR(o.time_out, 'HH24:MI:SS') AS timeout,
							o.time_out - o.time_in AS jamkerja
						")
						->from('GatotKacaErpMainBundle:OfficeHour', 'o')
						->innerJoin('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'o.id = e.shift')
						->where('e.id = :employee')
						->setParameter('employee', $id)
						->getQuery()
						->getOneOrNullResult();
		}else{
			if($date !== NULL){
				$officehour	= $this->getEntityManager()
							->createQueryBuilder()
							->select("
								e.id,
								TO_CHAR(o.time_in, 'HH24:MI:SS') AS timein,
								TO_CHAR(o.time_out, 'HH24:MI:SS') AS timeout,
								o.time_out - o.time_in AS jamkerja
							")
							->from('GatotKacaErpMainBundle:EmployeeShiftment', 'es')
							->innerJoin('GatotKacaErpMainBundle:OfficeHour', 'o', 'WITH', 'es.officehour = o.id')
							->innerJoin('GatotKacaErpHumanResourcesBundle:Employee', 'e', 'WITH', 'es.employee = e.id')
							->where('e.id = :employee AND es.shift_date = :date')
							->setParameter('employee', $id)
							->setParameter('date', $date)
							->getQuery()
							->getOneOrNullResult();
			}
		}
		return $officehour;
	}
	
	/**
	 * Untuk menghitung loyalitas dan keterlambatan
	 * 
	 * @param DateTime $timeIn
	 * @param DateTime $timeOut
	 * @param DateTime $absenIn
	 * @param DateTime $absenOut
	 * @return mixed
	 */
	private function calWorkTime(\DateTime $timeIn, \DateTime $timeOut, \DateTime $absenIn, \DateTime $absenOut){
		/**
		 * Menghitung absensi
		 *
		 * Jam kerja	= strtotime(timeout) - strtotime(timein);
		 * Karyawan		= strtotime(absenout) - strtotime(absenin);
		 * Terlambat	= strtotime(absenin) - strtotime(timein);
		 *
		 * Total Loyalitas	= Karyawan - Jam Kerja
		 **/
		$date		= strtotime(date('Y-m-d H:i:s', strtotime($absenIn->format('Y-m-d'). ' 00:00:00')));
		$absenIn	= strtotime($absenIn->format('Y-m-d H:i:s'));
		$absenOut	= strtotime($absenOut->format('Y-m-d H:i:s'));
		$timeIn		= strtotime($timeIn->format('Y-m-d H:i:s'));
		$timeOut	= strtotime($timeOut->format('Y-m-d H:i:s'));
		$jamKantor	= $timeOut - $timeIn;
		$jamKerja	= $absenOut - $absenIn;
		$late		= ($absenIn > $timeIn) ? $absenIn - $timeIn : 0;
		$loyal		= ($jamKerja > $jamKantor) ? $jamKerja - $jamKantor : 0;
		return array(
			'late'	=> $date + $late,
			'loyal'	=> $date + $loyal
		);
	}
}