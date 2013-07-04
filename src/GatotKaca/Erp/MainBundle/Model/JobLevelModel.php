<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/JobLevelModel.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\JobLevel;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class JobLevelModel extends BaseModel
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
     * Untuk mendapatkan list joblevel berdasarkan limit
     *
     * @param  string  $keyword
     * @param  integer $start
     * @param  integer $limit
     * @return array   result
     **/
    public function getList($keyword, $start, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND jl.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND jl.status = false";
        }
        $start  = ($keyword == '') ? $start : 0;
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'jl.id AS joblevel_id,
                jl.name AS joblevel_name,
                jl.level AS joblevel_level,
                jl.status AS joblevel_status'
            )
            ->from('GatotKacaErpMainBundle:JobLevel', 'jl')
            ->where("jl.name LIKE :name {$extra}")
            ->setParameter('name', "%{$keyword}%")
            ->orderBy('jl.level', 'ASC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get job level from {$start} to {$limit}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total joblevel
     *
     * @param  string  $keyword
     * @param  integer $limit
     * @return integer total
     **/
    public function countTotal($keyword, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND jl.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND jl.status = false";
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('jl.id AS joblevel_id');
        $qb->from('GatotKacaErpMainBundle:JobLevel', 'jl');
        $qb->where("jl.name LIKE :name {$extra}");
        $qb->setParameter('name', "%{$keyword}%");
        if ($keyword != '') {
            $qb->setFirstResult(0);
            $qb->setMaxResults($limit);
        };
        $query  = $qb->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan data joblevel by Id
     *
     * @param mixed id
     **/
    public function getById($id)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'jl.id AS joblevel_id,
                jl.name AS joblevel_name,
                jl.level AS joblevel_level,
                jl.status AS joblevel_status'
            )
            ->from('GatotKacaErpMainBundle:JobLevel', 'jl')
            ->where('jl.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $this->setModelLog("get job level with id {$id}");

        return $query->getResult();
    }

    /**
     * Untuk menyimpan data joblevel
     *
     * @param mixed $input
     **/
    public function save($input)
    {
        //Level 1 is required
        if ($this->countTotal('', 1) === 0 && $input->joblevel_level !== 1) {
            $this->setMessage("Level 1 is required");
            $this->setModelLog($this->getMessage());

            return false;
        }
        $joblevel = new JobLevel();
        if (isset($input->joblevel_id) && $input->joblevel_id != '') {
            //Check jika job level telah berelasi tidak boleh dinonaktifkan
            if (!isset($input->joblevel_status)) {
                $isExist = $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('jt.id')
                    ->from('GatotKacaErpMainBundle:JobTitle', 'jt')
                    ->where('jt.level = :level')
                    ->setParameter('level', $input->joblevel_id)
                    ->getQuery()
                    ->getResult();
                if (count($isExist)) {
                    $this->setMessage("Job Level can't be inactive because it has been related");
                    $this->setModelLog($this->getMessage());

                    return false;
                }
            }
            $joblevel = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:JobLevel')->find($input->joblevel_id);
            $this->setAction("modify");
        } else {
            $joblevel->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        //Check jika level sama maka ga boleh masuk
        $isExist = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('jl.id')
            ->from('GatotKacaErpMainBundle:JobLevel', 'jl')
            ->where('jl.level = :level AND jl.id != :id')
            ->setParameter('level', $input->joblevel_level)
            ->setParameter('id', $input->joblevel_id)
            ->getQuery()
            ->getResult();
        if (count($isExist)) {
            $this->setMessage("Level is exist, choose other level");
            $this->setModelLog($this->getMessage());

            return false;
        }
        $joblevel->setName(strtoupper($input->joblevel_name));
        $joblevel->setLevel($input->joblevel_level);
        $joblevel->setStatus(isset($input->joblevel_status));
        //Simpan joblevel
        $this->setEntityLog($joblevel);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($joblevel);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($joblevel, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving job level with id {$joblevel->getId()}");

            return $joblevel->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("Error while saving job level");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data joblevel
     * @return boolean
     **/
    public function delete($id)
    {
        $joblevel   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:JobLevel')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($joblevel);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting job level with id {$joblevel->getId()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$joblevel->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }
}
