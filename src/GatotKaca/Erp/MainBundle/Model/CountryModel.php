<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/CountryModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\Country;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class CountryModel extends BaseModel{
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
	 * Untuk mendapatkan list country berdasarkan limit
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
					c.id AS country_id,
					c.code AS country_code,
					c.name AS country_name,
					c.phonecode AS country_phonecode
				')
				->from('GatotKacaErpMainBundle:Country', 'c')
				->where("c.name LIKE :name")
				->setParameter('name', "%{$keyword}%")
				->orderBy('c.name', 'ASC')
				->setFirstResult($start)
				->setMaxResults($limit)
				->getQuery();
		$this->setModelLog("get country from {$start} to {$limit}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan total country
	 *
	 * @param string $keyword
	 * @param integer $limit
	 * @return integer total
	 **/
	public function countTotal($keyword, $limit){
		$qb	= $this->getEntityManager()->createQueryBuilder();
		$qb->select('
				c.id AS country_id
			');
		$qb->from('GatotKacaErpMainBundle:Country', 'c');
		$qb->where("c.name LIKE :name");
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
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("
					c.id AS country_id,
					c.code AS country_code,
					c.name AS country_name,
					c.phonecode AS country_phonecode
				")
				->from('GatotKacaErpMainBundle:Country', 'c')
				->where("c.{$criteria} = :{$criteria}")
				->setParameter($criteria, $value)
				->getQuery();
		$this->setModelLog("get country with {$criteria} = {$value}");
		return $query->getResult();
	}

	/**
	 * Untuk menyimpan data country
	 *
	 * @param mixed $input
	 **/
	public function save($input){
		$country	= new Country();
		if(isset($input->country_id) && $input->country_id != ''){
			$country	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Country')->find($input->country_id);
			$this->setAction("modify");
		}else{
			$country->setId($this->getHelper()->getUniqueId());
			$this->setAction("create");
		}
		$country->setCode(strtoupper($input->country_code));
		$country->setName(strtoupper($input->country_name));
		$country->setPhonecode($input->country_phonecode);
		//Simpan country
		if(!$this->checkExist($country, $country->getCode(), $country->getPhonecode())){
			return FALSE;
		}
		$this->setEntityLog($country);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->persist($country);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($country, LockMode::PESSIMISTIC_READ);
			$connection->commit();
			$this->setModelLog("saving country with id {$country->getId()}");
			return $country->getId();
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving country");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}

	/**
	 * Untuk menghapus data country
	 * @return boolean
	 **/
	public function delete($id){
		$country	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Country')->find($id);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->remove($country);
			$this->getEntityManager()->flush();
			$connection->commit();
			$this->setModelLog("deleting country with id {$country->getId()}");
			return TRUE;
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("{$country->getName()} has been related.");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}

	private function checkExist($entity, $code, $phonecode){
		$countryCode	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Country')->findOneBy(array('code' => $code));
		$countryPhone	= $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Country')->findOneBy(array('phonecode' => $phonecode));
		if($countryCode){
			if($countryCode->getCode() === $entity->getCode() && $countryCode->getId() !== $entity->getId()){
				$this->setMessage('Code is exist');
				$this->setModelLog($this->getMessage());
				return FALSE;
			}
		}
		if($countryPhone){
			if($countryPhone->getPhonecode() === $entity->getPhonecode() && $countryPhone->getId() !== $entity->getId()){
				$this->setMessage('Phonecode is exist');
				$this->setModelLog($this->getMessage());
				return FALSE;
			}
		}
		return TRUE;
	}
}