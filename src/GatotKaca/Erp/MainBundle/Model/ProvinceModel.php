<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/ProvinceModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\Province;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class ProvinceModel extends BaseModel{
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
	 * Untuk mendapatkan list province berdasarkan limit
	 * 
	 * @param string $keyword
	 * @param integer $start
	 * @param integer $limit
	 * @return array result
	 **/
	public function getList($keyword, $start, $limit){
		$start	= ($keyword == '') ? $start : 0;
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					p.id AS province_id,
					c.id AS country_id,
					c.name AS country_name,
					p.code AS province_code,
					p.name AS province_name
				')
				->from('GatotKacaErpMainBundle:Province', 'p')
				->leftJoin('GatotKacaErpMainBundle:Country', 'c', 'WITH', 'p.country = c.id')
				->where("p.name LIKE :name")
				->setParameter('name', "%{$keyword}%")
				->orderBy('c.name', 'ASC')
				->setFirstResult($start)
				->setMaxResults($limit)
				->getQuery();
		$this->setModelLog("get province from {$start} to {$limit}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan total province
	 *
	 * @param string $keyword
	 * @param integer $limit
	 * @return integer total
	 **/
	public function countTotal($keyword, $limit){
		$qb	= $this->getEntityManager()->createQueryBuilder();
		$qb->select('
				p.id AS province_id
			');
		$qb->from('GatotKacaErpMainBundle:Province', 'p');
		$qb->where("p.name LIKE :name");
		$qb->setParameter('name', "%{$keyword}%");
		if($keyword != ''){
			$qb->setFirstResult(0);
			$qb->setMaxResults($limit);
		};
		$query	= $qb->getQuery();
		return count($query->getResult());
	}

	/**
	 * Untuk mendapatkan data province by Id
	 *
	 * @param mixed id
	 **/
	public function getBy($criteria, $value){
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("
					p.id AS province_id,
					c.id AS country_id,
					c.name AS country_name,
					p.code AS province_code,
					p.name AS province_name
				")
				->from('GatotKacaErpMainBundle:Province', 'p')
				->leftJoin('GatotKacaErpMainBundle:Country', 'c', 'WITH', 'p.country = c.id')
				->where("p.{$criteria} = :{$criteria}")
				->setParameter($criteria, $value)
				->getQuery();
		$this->setModelLog("get province with {$criteria} = {$value}");
		return $query->getResult();
	}

	/**
	 * Untuk menyimpan data province
	 *
	 * @param mixed $input
	 **/
	public function save($input){
		$province	= new Province();
		if(isset($input->province_id) && $input->province_id != ''){
			$province	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Province')->find($input->province_id);
			$this->setAction("modify");
		}else{
			$province->setId($this->getHelper()->getUniqueId());
			$this->setAction("create");
		}
		$province->setCode(strtoupper($input->province_code));
		$province->setName(strtoupper($input->province_name));
		$province->setCountry($this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Country')->find($input->province_country));
		//Simpan province
		if(!$this->checkExist($province, $province->getCode())){
			return FALSE;
		}
		$this->setEntityLog($province);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->persist($province);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($province, LockMode::PESSIMISTIC_READ);
			$connection->commit();
			$this->setModelLog("saving province with id {$province->getId()}");
			return $province->getId();
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving province");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}

	/**
	 * Untuk menghapus data province
	 * @return boolean
	 **/
	public function delete($id){
		$province	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Province')->find($id);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->remove($province);
			$this->getEntityManager()->flush();
			$connection->commit();
			$this->setModelLog("deleting province with id {$province->getId()}");
			return TRUE;
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("{$province->getName()} has been related.");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}

	private function checkExist($entity, $code){
		$code	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Province')->findOneBy(array('code' => $code));
		if($code){
			if($code->getCode() === $entity->getCode() && $code->getId() !== $entity->getId()){
				$this->setMessage('Code is exist');
				$this->setModelLog($this->getMessage());
				return FALSE;
			}
		}
		return TRUE;
	}
}