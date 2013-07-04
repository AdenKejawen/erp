<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/OfficeHourModel.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use Doctrine\DBAL\LockMode;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use GatotKaca\Erp\MainBundle\Entity\OfficeHour;

class OfficeHourModel extends BaseModel
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
     * Untuk menyimpan data office hour
     *
     * @param mixed $input
     **/
    public function save($input)
    {
        $timeIn  = new \DateTime(date('Y-m-d').' '.$input->officehour_hin.':'.$input->officehour_min.':00');
        $timeOut = new \DateTime(date('Y-m-d').' '.$input->officehour_hout.':'.$input->officehour_mout.':00');
        //Create object
        $oHour   = new OfficeHour();
        if (isset($input->officehour_id) && $input->officehour_id != '') {
            //Check jika office hour telah berelasi tidak boleh dinonaktifkan
            if (!isset($input->officehour_status)) {
                $isExist    = $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('e.id')
                    ->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
                    ->where('e.shift = :officehour')
                    ->setParameter('officehour', $input->officehour_id)
                    ->getQuery()
                    ->getResult();
                if (count($isExist)) {
                    $this->setMessage("Office Hour can't be inactive because it has been related");
                    $this->setModelLog($this->getMessage());

                    return false;
                }
            }
            $oHour  = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:OfficeHour')->find($input->officehour_id);
            $this->setAction("modify");
        } else {
            $oHour->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $oHour->setName(strtoupper($input->officehour_name));
        $oHour->setStatus(isset($input->officehour_status));
        $oHour->setTimeIn($timeIn);
        $oHour->setTimeOut($timeOut);
        //Simpan office hour
        $this->setEntityLog($oHour);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($oHour);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($oHour, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving office hour with id {$oHour->getId()}");

            return $oHour->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("Error while saving office hour.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk mendapatkan list office hour berdasarkan limit
     *
     * @param  integer $start
     * @param  integer $limit
     * @return array   result
     **/
    public function getList($keyword, $start, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND o.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND o.status = false";
        }
        $start  = ($keyword == '') ? $start : 0;
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "o.id AS officehour_id,
                o.name AS officehour_name,
                TO_CHAR(o.time_in, 'HH24:MI') AS officehour_in,
                TO_CHAR(o.time_out, 'HH24:MI') AS officehour_out,
                o.status AS officehour_status"
            )
            ->from('GatotKacaErpMainBundle:OfficeHour', 'o')
            ->where("o.name LIKE :name {$extra}")
            ->setParameter('name', "%{$keyword}%")
            ->orderBy('o.name', 'ASC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get office hour from {$start} to {$limit}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total office hour
     *
     * @param  string  $keyword
     * @param  integer $limit
     * @return integer total
     **/
    public function getTotal($keyword, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND o.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND o.status = false";
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('o.id AS officehour_id');
        $qb->from('GatotKacaErpMainBundle:OfficeHour', 'o');
        $qb->where("o.name LIKE :name {$extra}");
        $qb->setParameter('name', "%{$keyword}%");
        if ($keyword != '') {
            $qb->setFirstResult(0);
            $qb->setMaxResults($limit);
        };
        $query  = $qb->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan data office hour by Id
     *
     * @param mixed id
     **/
    public function getById($id)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "o.id AS officehour_id,
                o.name AS officehour_name,
                TO_CHAR(o.time_in, 'HH24:MI') AS officehour_in,
                TO_CHAR(o.time_out, 'HH24:MI') AS officehour_out,
                o.status AS officehour_status"
            )
            ->from('GatotKacaErpMainBundle:OfficeHour', 'o')
            ->where('o.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $this->setModelLog("get office hour with id {$id}");

        return $query->getResult();
    }

    /**
     * Untuk menghapus data officehour
     * @return boolean
     **/
    public function delete($id)
    {
        $officehour = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:OfficeHour')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($officehour);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting job level with id {$officehour->getId()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$officehour->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }
}
