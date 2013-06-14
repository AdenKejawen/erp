<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/DistrictModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\District;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class DistrictModel extends BaseModel{
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
	 * Untuk mendapatkan list district by criteria
	 **/
	public function getBy($criteria, $value, $phrase = '='){
		$phrase	= strtoupper($phrase);
		if($phrase == 'LIKE'){
			$value	= "%{$value}%";
		}
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					d.id AS district_id,
					c.id AS country_id,
					c.name AS country_name,
					p.id AS province_id,
					p.name AS province_name,
					d.code AS district_code,
					d.name AS district_name
				')
				->from('GatotKacaErpMainBundle:District', 'd')
				->leftJoin('GatotKacaErpMainBundle:Province', 'p', 'WITH', 'd.province = p.id')
				->leftJoin('GatotKacaErpMainBundle:Country', 'c', 'WITH', 'p.country = c.id')
				->where("d.{$criteria} {$phrase} :{$criteria}")
				->setParameter($criteria, $value)
				->getQuery();
		$this->setModelLog("get district by {$criteria} $phrase {$value}");
		return $query->getResult();
	}

	/**
	 * Untuk mendapatkan list district berdasarkan limit
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
					d.id AS district_id,
					c.id AS country_id,
					c.name AS country_name,
					p.id AS province_id,
					p.name AS province_name,
					d.code AS district_code,
					d.name AS district_name
				')
				->from('GatotKacaErpMainBundle:District', 'd')
				->leftJoin('GatotKacaErpMainBundle:Province', 'p', 'WITH', 'd.province = p.id')
				->leftJoin('GatotKacaErpMainBundle:Country', 'c', 'WITH', 'p.country = c.id')
				->where("d.name LIKE :name")
				->setParameter('name', "%{$keyword}%")
				->orderBy('p.name', 'ASC')
				->setFirstResult($start)
				->setMaxResults($limit)
				->getQuery();
		$this->setModelLog("get district from {$start} to {$limit}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan total district
	 *
	 * @param string $keyword
	 * @param integer $limit
	 * @return integer total
	 **/
	public function countTotal($keyword, $limit){
		$qb	= $this->getEntityManager()->createQueryBuilder();
		$qb->select('
				d.id AS district_id
			');
		$qb->from('GatotKacaErpMainBundle:District', 'd');
		$qb->where("d.name LIKE :name");
		$qb->setParameter('name', "%{$keyword}%");
		if($keyword != ''){
			$qb->setFirstResult(0);
			$qb->setMaxResults($limit);
		};
		$query	= $qb->getQuery();
		return count($query->getResult());
	}

	/**
	 * Untuk menyimpan data district
	 *
	 * @param mixed $input
	 **/
	public function save($input){
		$district	= new District();
		if(isset($input->district_id) && $input->district_id != ''){
			$district	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:District')->find($input->district_id);
			$this->setAction("modify");
		}else{
			$district->setId($this->getHelper()->getUniqueId());
			$this->setAction("create");
		}
		$district->setCode(strtoupper($input->district_code));
		$district->setName(strtoupper($input->district_name));
		$district->setProvince($this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Province')->find($input->district_province));
		//Simpan district
		if(!$this->checkExist($district, $district->getCode())){
			return FALSE;
		}
		$this->setEntityLog($district);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->persist($district);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($district, LockMode::PESSIMISTIC_READ);
			$connection->commit();
			$this->setModelLog("saving district with id {$district->getId()}");
			return $district->getId();
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving district");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}

	/**
	 * Untuk menghapus data district
	 * @return boolean
	 **/
	public function delete($id){
		$district	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:District')->find($id);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->remove($district);
			$this->getEntityManager()->flush();
			$connection->commit();
			$this->setModelLog("deleting district with id {$district->getId()}");
			return TRUE;
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("{$district->getName()} has been related.");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}

	private function checkExist($entity, $code){
		$code	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:District')->findOneBy(array('code' => $code));
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