<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Model/ModuleModel.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\UtilitiesBundle\Model;

use GatotKaca\Erp\UtilitiesBundle\Entity\Module;
use GatotKaca\Erp\UtilitiesBundle\Entity\Role;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\Query;
use GatotKaca\Core\Doctrine\DQL\PostgreSQL\Walker\OrderByNullWalker;

class ModuleModel extends BaseModel
{
    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param Helper        $helper
     **/
    public function __construct(\Doctrine\ORM\EntityManager $entityManager, \GatotKaca\Core\Helper\Helper $helper)
    {
        parent::__construct($entityManager, $helper);
    }

    /**
     * Untuk mendapatkan list module berdasarkan limit
     *
     * @param  integer $start
     * @param  integer $limit
     * @return array   result
     **/
    public function getList($keyword, $start, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND m.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND m.status = false";
        }
        $start  = ($keyword == '') ? $start : 0;
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'm.id AS module_id,
                p.name AS module_parent,
                m.name AS module_name,
                m.status AS module_status'
            )
            ->from('GatotKacaErpUtilitiesBundle:Module', 'm')
            ->leftJoin('GatotKacaErpUtilitiesBundle:Module', 'p', 'WITH', 'm.parent = p.id')
            ->where("m.name LIKE :name {$extra}")
            ->addOrderBy('p.name', 'ASC')
            ->addOrderBy('m.name', 'ASC')
            ->setParameter('name', "%{$keyword}%")
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $query->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'GatotKaca\Core\Doctrine\DQL\PostgreSQL\Walker\OrderByNullWalker');
        $query->setHint(
            'OrderByNullWalker.NullOrder',
            array(
                'p.name' => OrderByNullWalker::NULLS_FIRST,
                'm.name' => OrderByNullWalker::NULLS_LAST
            )
        );
        $this->setModelLog("get module from {$start} to {$limit}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total module
     *
     * @return integer total
     **/
    public function countTotal($keyword, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND m.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND m.status = false";
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('m.id AS module_id');
        $qb->from('GatotKacaErpUtilitiesBundle:Module', 'm');
        $qb->where("m.name LIKE :name {$extra}");
        $qb->setParameter('name', "%{$keyword}%");
        if ($keyword != '') {
            $qb->setFirstResult(0);
            $qb->setMaxResults($limit);
        };
        $query  = $qb->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan module berdasarkan id
     *
     * @param  string $id
     * @return array  $result
     **/
    public function getById($id)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'm.id AS module_id,
                m.name AS module_name,
                p.id AS module_parent,
                p.name AS module_parentname,
                m.selector AS module_selector,
                m.icon AS module_icon,
                m.url AS module_url,
                m.status AS module_status'
            )
            ->from('GatotKacaErpUtilitiesBundle:Module', 'm')
            ->leftJoin('GatotKacaErpUtilitiesBundle:Module', 'p', 'WITH', 'p.id = m.parent')
            ->where('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $this->setModelLog("get module by id {$id}");

        return $query->getResult();
    }

    /**
     * Untuk menyimpan data module
     *
     * @param mixed $input
     **/
    public function save($input)
    {
        $module = new Module();
        if (isset($input->module_id) && $input->module_id != '') {
            $module = $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:Module')->find($input->module_id);
            $this->setAction("modify");
        } else {
            $module->setId($this->getHelper()->getUniqueId());
            $module->setMenuOrder(rand(0, 99));
            $this->setAction("create");
        }
        if (isset($input->module_parent) && $input->module_parent !== "") {
            $module->setParent($this->getEntityManager()->getReference('GatotKacaErpUtilitiesBundle:Module', $input->module_parent));
        }
        $module->setName(strtoupper($input->module_name));
        $module->setSelector(strtolower($input->module_selector));
        $module->setIcon(strtolower($input->module_icon));
        $module->setUrl($input->module_url);
        $module->setStatus(isset($input->module_status));
        $this->getEntityManager()->persist($module);
        //Simpan module
        $this->setEntityLog($module);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            //Assign module to role
            if ($this->getAction() === 'CREATE') {
                $groups = $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:UserGroup')->findAll();
                foreach ($groups as $group) {
                    $role   = new Role();
                    $role->setId($this->getHelper()->getUniqueId());
                    $role->setGroup($group);
                    $role->setModule($module);
                    $role->setCreatedby($this->getHelper()->getSession()->get('user_name'));
                    $role->setUpdatedby($this->getHelper()->getSession()->get('user_name'));
                    $this->getEntityManager()->persist($role);
                }
            }
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($module, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving module with id {$module->getId()}");

            return $module->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("Error while saving module");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }
}
