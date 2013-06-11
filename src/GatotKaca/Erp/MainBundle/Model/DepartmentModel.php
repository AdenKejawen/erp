<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/DepartmentModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Model\BaseModel;
use GatotKaca\Erp\MainBundle\Entity\Department;
use Doctrine\DBAL\LockMode;

class DepartmentModel extends BaseModel{
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
	 * Untuk mendapatkan list department by criteria
	 * 
	 * @param string $criteria
	 * @param string $value
	 * @return array result
	 **/
	public function getBy($criteria, $value){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND d.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND d.status = FALSE";
		}
		$qb		= $this->getEntityManager()->createQueryBuilder();
		$qb->select('
				d.id AS department_id,
				d.code AS department_code,
				d.status AS department_status,
				c.status AS division_status,
				p.id AS department_parent,
				p.name AS department_pname,
				d.name AS department_name
			');
		$qb->from('GatotKacaErpMainBundle:Department', 'd');
		$qb->leftJoin('GatotKacaErpMainBundle:Department', 'p', 'WITH', 'p.id = d.parent');
		$qb->leftJoin('GatotKacaErpMainBundle:CompanyDepartment', 'c', 'WITH', 'd.id = c.department');
		if($criteria == 'company'){
			$qb->where("c.{$criteria} = :{$criteria} {$extra}");
		}else{
			$qb->where("d.{$criteria} = :{$criteria} {$extra}");
		}
		$qb->setParameter($criteria, $value);
		$query	= $qb->getQuery();
		$this->setModelLog("get departement with {$criteria} {$value}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan list department berdasarkan limit
	 *
	 * @param integer $start
	 * @param integer $limit
	 * @return array result
	 **/
	public function getList($keyword, $start, $limit, $status = TRUE){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND d.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND d.status = FALSE";
		}
		$start	= ($keyword == '') ? $start : 0;
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					d.id AS department_id,
					d.code AS department_code,
					p.id AS department_parent,
					p.name AS department_pname,
					d.name AS department_name
				')
				->from('GatotKacaErpMainBundle:Department', 'd')
				->leftJoin('GatotKacaErpMainBundle:Department', 'p', 'WITH', 'p.id = d.parent')
				->where("d.name LIKE :name {$extra}")
				->setParameter('name', "%{$keyword}%")
				->orderBy('d.name', 'ASC')
				->setFirstResult($start)
				->setMaxResults($limit)
				->getQuery();
		$this->setModelLog("get department from {$start} to {$limit}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan total department
	 *
	 * @param string $keyword
	 * @param integer $limit
	 * @return integer total
	 **/
	public function countTotal($keyword, $limit, $status = TRUE){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND d.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND d.status = FALSE";
		}
		$qb	= $this->getEntityManager()->createQueryBuilder();
		$qb->select('
				d.id AS department_id
			');
		$qb->from('GatotKacaErpMainBundle:Department', 'd');
		$qb->where("d.name LIKE :name {$extra}");
		$qb->setParameter('name', "%{$keyword}%");
		if($keyword != ''){
			$qb->setFirstResult(0);
			$qb->setMaxResults($limit);
		};
		$query	= $qb->getQuery();
		return count($query->getResult());
	}
	
	/**
	 * Untuk menyimpan data department
	 *
	 * @param mixed $input
	 **/
	public function save($input){
		$department	= new Department();
		if(isset($input->department_id) && $input->department_id != ''){
			//Check jika department telah berelasi tidak boleh dinonaktifkan
			if(!isset($input->department_status)){
				$isExist	= $this->getEntityManager()
				->createQueryBuilder()
				->select('e.id')
				->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
				->where('e.department = :department')
				->setParameter('department', $input->department_id)
				->getQuery()
				->getResult();
				if(count($isExist)){
					$this->setMessage("Department can't be inactive because it has been related");
					$this->setModelLog($this->getMessage());
					return FALSE;
				}
			}
			$department	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Department')->find($input->department_id);
			$this->setAction("modify");
		}else{
			$department->setId($this->getHelper()->getUniqueId());
			$this->setAction("create");
		}
		if(isset($input->parent_department) && $input->parent_department !== "")
			$department->setParent($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Department', $input->parent_department));
		$department->setName(strtoupper($input->department_name));
		$department->setCode(strtoupper($input->department_code));
		$department->setStatus(isset($input->department_status));
		//Simpan department
		$this->setEntityLog($department);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->persist($department);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($department, LockMode::PESSIMISTIC_READ);
			$connection->commit();
			$this->setModelLog("saving department with id {$department->getId()}");
			return $department->getId();
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving department");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}

	/**
	 * Untuk menghapus data department
	 * @return boolean
	 **/
	public function delete($id){
		$department	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Department')->find($id);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->remove($department);
			$this->getEntityManager()->flush();
			$connection->commit();
			$this->setModelLog("deleting department with id {$department->getId()}");
			return TRUE;
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("{$department->getName()} has been related.");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}
}