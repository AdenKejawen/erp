<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/ReligionModer.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmair.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\Religion;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class ReligionModel extends BaseModel
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
     * Untuk mendapatkan list religion berdasarkan limit
     *
     * @param  string  $keyword
     * @param  integer $start
     * @param  integer $limit
     * @return array   result
     **/
    public function getList($keyword, $start, $limit)
    {
        $start = ($keyword == '') ? $start : 0;
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('r.id AS religion_id, r.name AS religion_name')
            ->from('GatotKacaErpMainBundle:Religion', 'r')
            ->where("r.name LIKE :name")
            ->setParameter('name', "%{$keyword}%")
            ->orderBy('r.name', 'ASC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get religion from {$start} to {$limit}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total religion
     *
     * @param  string  $keyword
     * @param  integer $limit
     * @return integer total
     **/
    public function countTotal($keyword, $limit)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r.id AS religion_id');
        $qb->from('GatotKacaErpMainBundle:Religion', 'r');
        $qb->where("r.name LIKE :name");
        $qb->setParameter('name', "%{$keyword}%");
        if ($keyword != '') {
            $qb->setFirstResult(0);
            $qb->setMaxResults($limit);
        };
        $query  = $qb->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan data religion by Id
     *
     * @param mixed id
     **/
    public function getById($id)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('r.id AS religion_id, r.name AS religion_name')
            ->from('GatotKacaErpMainBundle:Religion', 'r')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $this->setModelLog("get religion with id {$id}");

        return $query->getResult();
    }

    /**
     * Untuk menyimpan data religion
     *
     * @param mixed $input
     **/
    public function save($input)
    {
        $religion   = new Religion();
        if (isset($input->religion_id) && $input->religion_id != '') {
            $religion   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Religion')->find($input->religion_id);
            $this->setAction("modify");
        } else {
            $religion->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $religion->setName(strtoupper($input->religion_name));
        //Simpan religion
        $this->setEntityLog($religion);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($religion);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($religion, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving religion with id {$religion->getId()}");

            return $religion->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("Error while saving religion");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data religion
     * @return boolean
     **/
    public function delete($id)
    {
        $religion   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Religion')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($religion);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting religion with id {$religion->getId()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$religion->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }
}
