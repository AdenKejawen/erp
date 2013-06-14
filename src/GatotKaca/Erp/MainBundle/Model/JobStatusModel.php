<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/JobStatusModel.php
 * @author: Aden Kejawen
 * @sinoe: Version 1
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\JobStatus;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class JobStatusModel extends BaseModel{
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
	 * Untuk mendapatkan list jobstatus berdasarkan limit
	 * 
	 * @param string $keyword
	 * @param integer $start
	 * @param integer $limit
	 * @return array result
	 **/
	public function getList($keyword, $start, $limit){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND js.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND js.status = FALSE";
		}
		$start	= ($keyword == '') ? $start : 0;
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					js.id AS jobstatus_id,
					js.name AS jobstatus_name,
					js.ispermanent AS jobstatus_ispermanent,
					js.status AS jobstatus_status
				')
				->from('GatotKacaErpMainBundle:JobStatus', 'js')
				->where("js.name LIKE :name {$extra}")
				->setParameter('name', "%{$keyword}%")
				->orderBy('js.name', 'ASC')
				->setFirstResult($start)
				->setMaxResults($limit)
				->getQuery();
		$this->setModelLog("get job level from {$start} to {$limit}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan total jobstatus
	 *
	 * @param string $keyword
	 * @param integer $limit
	 * @return integer total
	 **/
	public function countTotal($keyword, $limit){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND js.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND js.status = FALSE";
		}
		$qb	= $this->getEntityManager()->createQueryBuilder();
		$qb->select('
				js.id AS jobstatus_id
			');
		$qb->from('GatotKacaErpMainBundle:JobStatus', 'js');
		$qb->where("js.name LIKE :name {$extra}");
		$qb->setParameter('name', "%{$keyword}%");
		if($keyword != ''){
			$qb->setFirstResult(0);
			$qb->setMaxResults($limit);
		};
		$query	= $qb->getQuery();
		return count($query->getResult());
	}
	
	/**
	 * Untuk mendapatkan data jobstatus by Id
	 *
	 * @param mixed id
	 **/
	public function getById($id){
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("
					js.id AS jobstatus_id,
					js.name AS jobstatus_name,
					js.ispermanent AS jobstatus_ispermanent,
					js.status AS jobstatus_status
				")
				->from('GatotKacaErpMainBundle:JobStatus', 'js')
				->where('js.id = :id')
				->setParameter('id', $id)
				->getQuery();
		$this->setModelLog("get job level with id {$id}");
		return $query->getResult();
	}
	
	/**
	 * Untuk menyimpan data jobstatus
	 *
	 * @param mixed $input
	 **/
	public function save($input){
		$jobstatus	= new JobStatus();
		if(isset($input->jobstatus_id) && $input->jobstatus_id != ''){
			//Check jika job level telah berelasi tidak boleh dinonaktifkan
			if(!isset($input->jobstatus_status)){
				$isExist	= $this->getEntityManager()
							->createQueryBuilder()
							->select('e.id')
							->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
							->where('e.jobstatus = :jobstatus')
							->setParameter('jobstatus', $input->jobstatus_id)
							->getQuery()
							->getResult();
				if(count($isExist)){
					$this->setMessage("Job Status can't be inactive because it has been related");
					$this->setModelLog($this->getMessage());
					return FALSE;
				}
			}
			$jobstatus	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:JobStatus')->find($input->jobstatus_id);
			$this->setAction("modify");
		}else{
			$jobstatus->setId($this->getHelper()->getUniqueId());
			$this->setAction("create");
		}
		$jobstatus->setName(strtoupper($input->jobstatus_name));
		$jobstatus->setIspermanent(isset($input->jobstatus_ispermanent));
		$jobstatus->setStatus(isset($input->jobstatus_status));
		//Simpan jobstatus
		$this->setEntityLog($jobstatus);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->persist($jobstatus);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($jobstatus, LockMode::PESSIMISTIC_READ);
			$connection->commit();
			$this->setModelLog("saving job level with id {$jobstatus->getId()}");
			return $jobstatus->getId();
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving job level");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}

	/**
	 * Untuk menghapus data jobstatus
	 * @return boolean
	 **/
	public function delete($id){
		$jobstatus	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:JobStatus')->find($id);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->remove($jobstatus);
			$this->getEntityManager()->flush();
			$connection->commit();
			$this->setModelLog("deleting job level with id {$jobstatus->getId()}");
			return TRUE;
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("{$jobstatus->getName()} has been related.");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}
}