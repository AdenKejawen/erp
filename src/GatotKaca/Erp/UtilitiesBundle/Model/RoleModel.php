<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Model/RoleModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\UtilitiesBundle\Model;

use GatotKaca\Erp\MainBundle\Model\BaseModel;
use GatotKaca\Erp\UtilitiesBundle\Entity\Role;
use GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\Query;
use GatotKaca\Erp\MainBundle\Doctrine\DQL\PostgreSQL\Walker\OrderByNullWalker;

class RoleModel extends BaseModel{
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
	 * Untuk mendapatkan list group berdasarkan limit
	 *
	 * @param integer $start
	 * @param integer $limit
	 * @return array result
	 **/
	public function getGroupList($keyword, $start, $limit){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND g.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND g.status = FALSE";
		}
		$start	= ($keyword == '') ? $start : 0;
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("
					g.id AS group_id,
					g.name AS group_name,
					g.status AS group_status,
					SPLIT_PART(g.relation, ':', 2) AS group_relation
				")
				->from('GatotKacaErpUtilitiesBundle:UserGroup', 'g')
				->where("g.name LIKE :name {$extra}")
				->orderBy('g.name', 'ASC')
				->setParameter('name', "%{$keyword}%")
				->setFirstResult($start)
				->setMaxResults($limit)
				->getQuery();
		$this->setModelLog("get group from {$start} to {$limit}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan total group
	 *
	 * @return integer total
	 **/
	public function countTotalGroup($keyword, $limit){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND g.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND g.status = FALSE";
		}
		$qb	= $this->getEntityManager()->createQueryBuilder();
		$qb->select('
				g.id AS group_id
			');
		$qb->from('GatotKacaErpUtilitiesBundle:UserGroup', 'g');
		$qb->where("g.name LIKE :name {$extra}");
		$qb->setParameter('name', "%{$keyword}%");
		if($keyword != ''){
			$qb->setFirstResult(0);
			$qb->setMaxResults($limit);
		};
		$query	= $qb->getQuery();
		return count($query->getResult());
	}
	
	/**
	 * Untuk mendapatkan list role
	 * 
	 * @param string group
	 * @return array result
	 **/
	public function getListByGroup($group){
		$extra	= '';
		if($this->getStatus()){
			$extra	= "AND m.status = TRUE";
		}else if($this->getStatus() === FALSE){
			$extra	= "AND m.status = FALSE";
		}
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					r.id AS role_id,
					m.id AS module_id,
					p.name AS module_pid,
					m.name AS module_name,
					m.selector AS module_selector,
					p.name AS module_pname,
					r.view AS role_view,
					r.modif AS role_modify,
					r.delete AS role_delete
				')
				->from('GatotKacaErpUtilitiesBundle:Module', 'm')
				->leftJoin('GatotKacaErpUtilitiesBundle:Role', 'r', 'WITH', 'r.module = m.id')
				->leftJoin('GatotKacaErpUtilitiesBundle:Module', 'p', 'WITH', 'm.parent = p.id')
				->where("r.group = :group {$extra}")
				->addOrderBy('p.name', 'ASC')
				->addOrderBy('m.name', 'ASC')
				->setParameter('group', $group)
				->getQuery();
		$query->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'GatotKaca\Erp\MainBundle\Doctrine\DQL\PostgreSQL\Walker\OrderByNullWalker');
		$query->setHint('OrderByNullWalker.NullOrder', array(
			'p.name'	=> OrderByNullWalker::NULLS_FIRST,
			'm.name'	=> OrderByNullWalker::NULLS_LAST
		));
		$this->setModelLog("get role list with group {$group}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan by id
	 *
	 * @param string group
	 * @return array result
	 **/
	public function getById($id){
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					r.id AS role_id,
					m.name AS role_module,
					g.name AS role_group,
					r.view AS role_view,
					r.modif AS role_modif,
					r.delete AS role_delete
				')
				->from('GatotKacaErpUtilitiesBundle:Role', 'r')
				->leftJoin('GatotKacaErpUtilitiesBundle:Module', 'm', 'WITH', 'r.module = m.id')
				->leftJoin('GatotKacaErpUtilitiesBundle:UserGroup', 'g', 'WITH', 'r.group = g.id')
				->where('r.id = :id')
				->setParameter('id', $id)
				->getQuery();
		$this->setModelLog("get role with id {$id}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mendapatkan group berdasarkan id
	 *
	 * @param string $id
	 * @return array $result
	 **/
	public function getGroup($id){
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select("
					g.id AS group_id,
					g.name AS group_name,
					g.status AS group_status,
					g.relation AS group_relation
				")
				->from('GatotKacaErpUtilitiesBundle:UserGroup', 'g')
				->where('g.id = :id')
				->setParameter('id', $id)
				->getQuery();
		$this->setModelLog("get group with id {$id}");
		return $query->getResult();
	}
	
	/**
	 * Untuk mengupdate role
	 *
	 * @param string $input
	 * @return mixed $result
	 **/
	public function save($input){
		if(count($input)){
			foreach ($input as $data){
				$role	= $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:Role')->find($data->role_id);
				$this->setAction("modify");
				$role->setView($data->role_view);
				$role->setModif($data->role_modify);
				$role->setDelete($data->role_delete);
				$this->setEntityLog($role);
				$this->getEntityManager()->persist($role);
				//Jika rule punya child maka semua child harus diset
				$modules	= $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:Module')->findBy(array('parent' => $role->getModule()->getId()));
				foreach($modules AS $module){
					$role	= $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:Role')->findOneBy(
							array(
									'module' => $module->getId(),
									'group' => $role->getGroup()->getId()
							)
					);
					if(!$data->role_view){$role->setView($data->role_view);}
					if(!$data->role_modify){$role->setModif($data->role_modify);}
					if(!$data->role_delete){$role->setDelete($data->role_delete);}
					$this->setEntityLog($role);
					$this->getEntityManager()->persist($role);
				}
			}
			//Simpan role
			$connection	= $this->getEntityManager()->getConnection();
			$connection->beginTransaction();
			try {
				$this->getEntityManager()->flush();
				$connection->commit();
				$this->setModelLog("saving role with group {$role->getGroup()->getId()}");
				return $role->getId();
			}catch(\Exception $e) {
				$connection->rollback();
				$this->getEntityManager()->close();
				$this->setMessage("Error while saving role");
				$this->setModelLog($this->getMessage());
				return FALSE;
			}
		}
		return FALSE;
	}
	
	/**
	 *
	 * @param string $input
	 * @return mixed $result
	 **/
	public function saveGroup($input){
		$group	= new UserGroup();
		if(isset($input->group_id) && $input->group_id != ''){
			//Check jika group telah berelasi tidak boleh dinonaktifkan
			if(!isset($input->group_status)){
				$isExist	= $this->getEntityManager()
				->createQueryBuilder()
				->select('u.id')
				->from('GatotKacaErpUtilitiesBundle:User', 'u')
				->where('u.group = :group')
				->setParameter('group', $input->group_id)
				->getQuery()
				->getResult();
				if(count($isExist)){
					$this->setMessage("Group can't be inactive because it has been related");
					$this->setModelLog($this->getMessage());
					return FALSE;
				}
			}
			$group	= $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:UserGroup')->find($input->group_id);
			$this->setAction("modify");
		}else{
			$group->setId($this->getHelper()->getUniqueId());
			$this->setAction("create");
		}
		$group->setName(strtoupper($input->group_name));
		$group->setRelation($input->group_relation);
		$group->setStatus(isset($input->group_status));
		//Simpan group
		$this->setEntityLog($group);
		$connection	= $this->getEntityManager()->getConnection();
		$connection->beginTransaction();
		try {
			//Assign group to role
			if($this->getAction() === 'CREATE'){
				$modules	= $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:Module')->findAll();
				foreach($modules AS $module){
					$role	= new Role();
					$role->setId($this->getHelper()->getUniqueId());
					$role->setGroup($group);
					$role->setModule($module);
					$this->setEntityLog($role);
					$this->getEntityManager()->persist($role);
				}
			}
			$this->getEntityManager()->persist($group);
			$this->getEntityManager()->flush();
			$this->getEntityManager()->lock($group, LockMode::PESSIMISTIC_READ);
			$connection->commit();
			$this->setModelLog("saving group with id {$group->getId()}");
			return $group->getId();
		}catch(\Exception $e) {
			$connection->rollback();
			$this->getEntityManager()->close();
			$this->setMessage("Error while saving group");
			$this->setModelLog($this->getMessage());
			return FALSE;
		}
	}
}