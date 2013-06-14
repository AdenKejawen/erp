<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/JobTitleModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\JobTitle;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class JobTitleModel extends BaseModel{
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
	 * Untuk mendapatkan list jobtitle berdasarkan limit
	 * 
	 * @param string $keyword
	 * @param integer $start
	 * @param integer $limit
	 * @return array result
	 **/
	public function getList($keyword, $start, $limit){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND jt.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND jt.status = FALSE";
		}
		$start	= ($keyword == '') ? $start : 0;
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					jt.id AS jobtitle_id,
					p.id AS jobtitle_parent,
					jt.name AS jobtitle_name,
					jl.name AS jobtitle_level,
					jl.level AS level,
					jt.status AS jobtitle_status
				')
				->from('GatotKacaErpMainBundle:JobTitle', 'jt')
				->leftJoin('GatotKacaErpMainBundle:JobLevel', 'jl', 'WITH', 'jl.id = jt.level')
				->leftJoin('GatotKacaErpMainBundle:JobTitle', 'p', 'WITH', 'jt.parent = p.id')
				->where("jt.name LIKE :name {$extra}")
				->setParameter('name', "%{$keyword}%")
				->orderBy('jt.name', 'ASC')
				->setFirstResult($start)
				->setMaxResults($limit)
				->getQuery();
		$this->setModelLog("get job level from {$start} to {$limit}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan total jobtitle
	 *
	 * @param string $keyword
	 * @param integer $limit
	 * @return integer total
	 **/
	public function countTotal($keyword, $limit){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND jt.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND jt.status = FALSE";
		}
		$qb	= $this->getEntityManager()->createQueryBuilder();
		$qb->select('
				jt.id AS jobtitle_id
			');
		$qb->from('GatotKacaErpMainBundle:JobTitle', 'jt');
		$qb->leftJoin('GatotKacaErpMainBundle:JobLevel', 'jl', 'WITH', 'jl.id = jt.level');
		$qb->where("jt.name LIKE :name {$extra}");
		$qb->setParameter('name', "%{$keyword}%");
		if($keyword != ''){
			$qb->setFirstResult(0);
			$qb->setMaxResults($limit);
		};
		$query	= $qb->getQuery();
		return count($query->getResult());
	}
	
	/**
	 * Untuk mendapatkan data jobtitle by Id
	 *
	 * @param mixed id
	 **/
	public function getBy($criteria, $value){
		$where	= "";
		if($criteria === 'level'){
			$cond	= $this->getEntityManager()
					->createQueryBuilder()
					->select("l.level")
					->from('GatotKacaErpMainBundle:JobLevel', 'l')
					->where("l.id = :id")
					->setParameter('id', $value)
					->getQuery()
					->getSingleResult();
			$value	= $cond['level'];
			$where	= "jl.{$criteria} < :{$criteria}";
		}else{
			$where	= "jt.{$criteria} = :{$criteria}";
		}
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("
					jt.id AS jobtitle_id,
					p.id AS jobtitle_parent,
					jt.name AS jobtitle_name,
					jl.id AS jobtitle_level,
					jt.status AS jobtitle_status
				")
				->from('GatotKacaErpMainBundle:JobTitle', 'jt')
				->leftJoin('GatotKacaErpMainBundle:JobLevel', 'jl', 'WITH', 'jl.id = jt.level')
				->leftJoin('GatotKacaErpMainBundle:JobTitle', 'p', 'WITH', 'jt.parent = p.id')
				->where($where)
				->setParameter($criteria, $value)
				->getQuery();
		$this->setModelLog("get job level with {$criteria} = {$value}");
		return $query->getResult();
	}
	
	/**
	 * Untuk menyimpan data jobtitle
	 *
	 * @param mixed $input
	 **/
	public function save($input){
		$jobtitle	= new JobTitle();
		if(isset($input->jobtitle_id) && $input->jobtitle_id != ''){
			//Check jika job level telah berelasi tidak boleh dinonaktifkan
			if(!isset($input->jobtitle_status)){
				$isExist	= $this->getEntityManager()
							->createQueryBuilder()
							->select('e.id')
							->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
							->where('e.jobtitle = :jobtitle')
							->setParameter('jobtitle', $input->jobtitle_id)
							->getQuery()
							->getResult();
				if(count($isExist)){
					$this->setMessage("Job Title can't be inactive because it has been related");
					$this->setModelLog($this->getMessage());
					return FALSE;
				}
			}
			$jobtitle	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:JobTitle')->find($input->jobtitle_id);
			$this->setAction("modify");
		}else{
			$jobtitle->setId($this->getHelper()->getUniqueId());
			$this->setAction("create");
		}
		if(isset($input->jobtitle_parent) && $input->jobtitle_parent !== "")
			$jobtitle->setParent($this->getEntityManager()->getReference('GatotKacaErpMainBundle:JobTitle', $input->jobtitle_parent));
		$jobtitle->setName(strtoupper($input->jobtitle_name));
		$jobtitle->setLevel($this->getEntityManager()->getReference('GatotKacaErpMainBundle:JobLevel', $input->jobtitle_level));
		$jobtitle->setStatus(isset($input->jobtitle_status));
		//Simpan jobtitle
		$this->setEntityLog($jobtitle);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->persist($jobtitle);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($jobtitle, LockMode::PESSIMISTIC_READ);
			$connection->commit();
			$this->setModelLog("saving job title with id {$jobtitle->getId()}");
			return $jobtitle->getId();
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving job title");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}

	/**
	 * Untuk menghapus data jobtitle
	 * @return boolean
	 **/
	public function delete($id){
		$jobtitle	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:JobTitle')->find($id);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->remove($jobtitle);
			$this->getEntityManager()->flush();
			$connection->commit();
			$this->setModelLog("deleting job title with id {$jobtitle->getId()}");
			return TRUE;
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("{$jobtitle->getName()} has been related.");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}
}