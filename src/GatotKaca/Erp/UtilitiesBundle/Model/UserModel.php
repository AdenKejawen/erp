<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Model/UserModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\UtilitiesBundle\Model;

use Doctrine\DBAL\LockMode;
use GatotKaca\Erp\MainBundle\Model\BaseModel;

class UserModel extends BaseModel{
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
	 * Untuk mendapatkan list user berdasarkan limit
	 * 
	 * @param integer $start
	 * @param integer $limit
	 * @return array result
	 **/
	public function getList($keyword, $start, $limit){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND u.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND u.status = FALSE";
		}
		$start	= ($keyword == '') ? $start : 0;
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					u.id AS user_id,
					u.name AS user_name,
					g.id AS group_id,
					g.name AS group_name,
					g.relation AS table,
					u.status AS user_status,
					u.online AS user_online
				')
				->from('GatotKacaErpUtilitiesBundle:User', 'u')
				->leftJoin('GatotKacaErpUtilitiesBundle:UserGroup', 'g', 'WITH', 'g.id = u.group')
				->where("u.name LIKE :name {$extra}")
				->orderBy('g.name', 'ASC')
				->setParameter('name', "%{$keyword}%")
				->setFirstResult($start)
				->setMaxResults($limit)
				->getQuery();
		$this->setModelLog("get user from {$start} to {$limit}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan total user
	 *
	 * @return integer total
	 **/
	public function countTotal($keyword, $limit){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND u.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND u.status = FALSE";
		}
		$qb	= $this->getEntityManager()->createQueryBuilder();
		$qb->select('
				u.id AS user_id
			');
		$qb->from('GatotKacaErpUtilitiesBundle:User', 'u');
		$qb->where("u.name LIKE :name {$extra}");
		$qb->setParameter('name', "%{$keyword}%");
		if($keyword != ''){
			$qb->setFirstResult(0);
			$qb->setMaxResults($limit);
		};
		$query	= $qb->getQuery();
		return count($query->getResult());
	}
	
	/**
	 * Untuk mendapatkan user berdasarkan id
	 * 
	 * @param string $id
	 * @param string $table
	 * @return array $result
	 **/
	public function getById($id, $table){
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					u.id AS user_id,
					u.name AS user_name,
					g.id AS group_name,
					t.fname AS fname,
					t.lname AS lname,
					u.status AS user_status,
					u.online AS user_online
				')
				->from('GatotKacaErpUtilitiesBundle:User', 'u')
				->join('GatotKacaErpUtilitiesBundle:UserGroup', 'g', 'WITH', 'g.id = u.group')
				->join($table, 't', 'WITH', 't.username = u.id')
				->where('u.id = :id')
				->setParameter('id', $id)
				->getQuery();
		$this->setModelLog("get user by id {$id}");
		return $query->getResult();
	}
	
	/**
	 * Update User
	 * 
	 * @param mixed $input
	 * @return mixed $result
	 **/
	public function save($input){
		$user	= $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:User')->find($input->user_id);
		if($input->npassword != ''){
			$salt	= $this->getHelper()->getSalt($user->getName());
			$user->setSalt($salt);
			$user->setPass($this->getHelper()->hashPassword($input->npassword, $salt));
		}
		$user->setStatus(isset($input->user_status));
		$user->setOnline(isset($input->user_online));
		$user->setGroup($this->getEntityManager()->getReference('GatotKacaErpUtilitiesBundle:UserGroup', $input->group_name));
		//Simpan User
		$this->getEntityManager()->getConnection()->beginTransaction();
		$this->setEntityLog($user);
		try {
			$this->getEntityManager()->persist($user);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($user, LockMode::PESSIMISTIC_READ);
			$this->getEntityManager()->getConnection()->commit();
			$this->setModelLog("saving user with id {$user->getId()}");
			return $user->getId();
		}catch(\Exception $e) {
			$this->getEntityManager()->getConnection()->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving user");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}
}