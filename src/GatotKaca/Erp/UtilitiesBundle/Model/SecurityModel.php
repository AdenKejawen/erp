<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Model/SecurityModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\UtilitiesBundle\Model;

use Doctrine\DBAL\LockMode;
use GatotKaca\Erp\UtilitiesBundle\Entity\Logging;
use GatotKaca\Erp\MainBundle\Model\BaseModel;

class SecurityModel extends BaseModel{
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
	 * Untuk mengecek salt password
	 * 
	 * @param string $username
	 * @return string|boolean
	 **/
	private function checkSalt($username){
		$salt   = $this->getEntityManager()
				->createQueryBuilder()
				->select('u.salt AS salt')
				->from('GatotKacaErpUtilitiesBundle:User', 'u')
				->where('u.name = :username AND u.status = TRUE')
				->setParameter('username', $username)
				->getQuery()
				->getOneOrNullResult();
		if($salt){//Username ditemukan ? return $salt : return FALSE
			return $salt['salt'];
		}else{
			//Salt tidak ditemukan
			$this->setMessage("User {$username} not found");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}
	
	/**
	 * Untuk memverifikasi user
	 * 
	 * @param string $username
	 * @param string $password
	 * @return mixed|boolean
	 **/
	public function authUser($username, $password){
		if($salt	= $this->checkSalt($username)){
			$auth   = $this->getEntityManager()
					->createQueryBuilder()
					->select('
						u.id AS user_id,
						u.name AS user_name,
						g.id AS group_id,
						g.name AS group_name
					')
					->from('GatotKacaErpUtilitiesBundle:User', 'u')
					->innerJoin('GatotKacaErpUtilitiesBundle:UserGroup', 'g', 'WITH', 'u.group = g.id')
					->where('u.name = :username AND u.pass = :password')
			        ->setParameter('username', $username)
			        ->setParameter('password', $this->getHelper()->hashPassword($password, $salt))
					->getQuery()
					->getOneOrNullResult();
			if($auth){//auth user?
				if(!$this->isOnline($auth['user_id'])){//is online?
					$this->setOnline($auth['user_id'], TRUE);
					return $auth;
				}else{
					$this->setMessage("User {$username} is online using other device");
				}
			}else{
				$this->setMessage("Username and Password not match");
			}
			return FALSE;
		}
		$this->setMessage("User {$username} not found");
		$this->setModelLog($this->getMessage());
		return FALSE;
	}
	
	/**
	 * Untuk online atau offline
	 **/
	public function setOnline($id, $status = FALSE){
		$user	= $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:User')->find($id);
		$user->setOnline($status);
		$this->getEntityManager()->persist($user);
		$this->getEntityManager()->flush();
		($status) ? $status = 'online' : $status = 'offline';
		$this->setModelLog("user {$user->getName()} is {$status}");
	}
	
	/**
	 * Check is online user
	 * 
	 * @param string $id
	 * @return boolean online
	 */
	public function isOnline($id){
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('u.online')
				->from('GatotKacaErpUtilitiesBundle:User', 'u')
				->where('u.id = :id')
				->setParameter('id', $id)
				->getQuery()
				->getOneOrNullResult();
		return $query['online'];
	}

	/**
	 * Untuk mengecek otorisasi user terhadap module
	 *
	 * @param string $group
	 * @param string $module
	 * @param string $role
	 * @return boolean
	 **/
	public function isAllowed($group, $module, $role){
		//Role tidak sesuai ketentuan? Nothing to do
		if(!($role == 'view' || $role == 'modif' || $role == 'delete')){
			return FALSE;
		}
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("r.{$role} AS rule")
				->from('GatotKacaErpUtilitiesBundle:Role', 'r')
				->innerJoin('GatotKacaErpUtilitiesBundle:UserGroup', 'g', 'WITH', 'r.group = g.id')
				->innerJoin('GatotKacaErpUtilitiesBundle:Module', 'm', 'WITH', 'r.module = m.id')
				->where("
					g.id = :group
				AND
					m.selector = :module
				AND
					r.{$role} = TRUE
				")
				->setParameter('group', $group)
				->setParameter('module', $module)
				->getQuery()
				->getOneOrNullResult();
		if($query){
			return $query['rule'];
		}
		return FALSE;
	}
	
	/**
	 * Untuk mendapatkan menu list berdasarkan parent
	 *
	 * @param string $parent
	 * @return mixed list menu
	 **/
	public function getMenu($parent, $group){
		$menu	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					m.id AS id,
					m.selector AS selector,
					m.name AS title,
					m.icon AS icon,
					m.url AS cls
				')
				->from('GatotKacaErpUtilitiesBundle:Module', 'm')
				->innerJoin('GatotKacaErpUtilitiesBundle:Role', 'r', 'WITH', 'm.id = r.module')
				->innerJoin('GatotKacaErpUtilitiesBundle:UserGroup', 'g', 'WITH', 'r.group = g.id')
				->where('
					m.parent = :parent
				AND
					r.view = TRUE
				AND
					r.modif = TRUE
				AND
					g.id = :group
				AND
					m.status = TRUE
				')
				->orderBy('m.menu_order', 'ASC')
				->setParameter('parent', $parent)
				->setParameter('group', $group)
				->getQuery();
		return $menu->getResult();
	}
	
	/**
	 * Untuk mendapatkan list module
	 *
	 * @return mixed list module
	 **/
	public function getModule($group){
		$menu	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					m.id AS id,
					m.selector AS selector,
					m.name AS title,
					m.icon AS icon,
					m.url AS cls
				')
				->from('GatotKacaErpUtilitiesBundle:Module', 'm')
				->innerJoin('GatotKacaErpUtilitiesBundle:Role', 'r', 'WITH', 'm.id = r.module')
				->innerJoin('GatotKacaErpUtilitiesBundle:UserGroup', 'g', 'WITH', 'r.group = g.id')
				->where('
					m.parent IS NULL
				AND
					r.view = TRUE
				AND
					g.id = :group
				AND
					m.status = TRUE
				')
				->orderBy('m.menu_order', 'ASC')
				->setParameter('group', $group)
				->getQuery();
		return $menu->getResult();
	}
	
	/**
	 * Untuk mengenerate logging
	 * 
	 * @param string $type
	 * @param string $agent
	 * @param string $activities
	 * 
	 **/
	public function logging($agent, $user, $route, $type, $message){
		$this->getEntityManager()
				->createQueryBuilder()
				->delete('GatotKacaErpUtilitiesBundle:Logging', 'l')
				->where('l.created <= :created')
				->setParameter('created', new \DateTime('-3 months'))
				->getQuery()
				->execute();
		
		$user	= $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:User')->find($user);
		$user->setLastactivity(new \DateTime());
		//Create logging object
		$log	= new Logging();
		$log->setId($this->getHelper()->getUniqueId());
		$log->setAgent($agent);
		$log->setUserId($user->getId());
		$log->setRoute($route);
		$log->setType($type);
		$log->setValue($message);
		//Transaction Start
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			$this->getEntityManager()->persist($user);
			$this->getEntityManager()->persist($log);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($user, LockMode::PESSIMISTIC_READ);
			$this->getEntityManager()->lock($log, LockMode::PESSIMISTIC_READ);
			$connection->commit();
			return TRUE;
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			return FALSE;
		}
	}
	
	/**
	 * Untuk mengenerate logging
	 *
	 * @param string $user
	 * 
	 * @return boolean session stage
	 **/
	public function checkSession($agent){
		$qb		= $this->getEntityManager()->createQueryBuilder();
		$users	= $qb->select('u.id')
				->from('GatotKacaErpUtilitiesBundle:User', 'u')
				->where('u.lastactivity <= :activity')
				->setParameter('activity', new \DateTime('-1 hours'))
				->getQuery()
				->getResult();
		foreach ($users as $user){
			$qb->update('GatotKacaErpUtilitiesBundle:User', 'u')
				->set('u.online', $qb->expr()->literal(FALSE))
				->where('u.id = :user')
				->setParameter('user', $user['id'])
				->getQuery()
				->execute();
		}
		$this->getEntityManager()->flush();
		$last	= $qb->select('u.lastactivity')
				->from('GatotKacaErpUtilitiesBundle:User', 'u')
				->where('u.id = :agent')
				->setParameter('agent', $agent)
				->setMaxResults(1)
				->getQuery()
				->getOneOrNullResult();
		$now	= new \DateTime();
		if($diff	= $this->getHelper()->getTimeDiff($last['lastactivity'], $now)){
			if($diff > 3600)// 1 Jam
				return FALSE;
		}
		return TRUE;
	}
}