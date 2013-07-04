<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/EducationModel.php
 * @author: Aden Kejawen
 * @sinoe: Version 1
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\Education;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class EducationModel extends BaseModel
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
     * Untuk mendapatkan list education berdasarkan limit
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
            $extra  = "AND e.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND e.status = false";
        }
        $start  = ($keyword == '') ? $start : 0;
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'e.id AS education_id,
                e.name AS education_name,
                e.level AS education_level,
                e.status AS education_status'
            )
            ->from('GatotKacaErpMainBundle:Education', 'e')
            ->where("e.name LIKE :name {$extra}")
            ->setParameter('name', "%{$keyword}%")
            ->orderBy('e.level', 'ASC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get education from {$start} to {$limit}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total education
     *
     * @param  string  $keyword
     * @param  integer $limit
     * @return integer total
     **/
    public function countTotal($keyword, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND e.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND e.status = false";
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e.id AS education_id');
        $qb->from('GatotKacaErpMainBundle:Education', 'e');
        $qb->where("e.name LIKE :name {$extra}");
        $qb->setParameter('name', "%{$keyword}%");
        if ($keyword != '') {
            $qb->setFirstResult(0);
            $qb->setMaxResults($limit);
        };
        $query  = $qb->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan data education by Id
     *
     * @param mixed id
     **/
    public function getById($id)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "e.id AS education_id,
                e.name AS education_name,
                e.level AS education_level,
                e.status AS education_status"
            )
            ->from('GatotKacaErpMainBundle:Education', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $this->setModelLog("get education with id {$id}");

        return $query->getResult();
    }

    /**
     * Untuk menyimpan data education
     *
     * @param mixed $input
     **/
    public function save($input)
    {
        $education  = new Education();
        if (isset($input->education_id) && $input->education_id != '') {
            //Check jika education telah berelasi tidak boleh dinonaktifkan
            if (!isset($input->education_status)) {
                $isExist    = $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('ed.id')
                    ->from('GatotKacaErpHumanResourcesBundle:EmployeeEducation', 'ed')
                    ->where('ed.education = :education')
                    ->setParameter('education', $input->education_id)
                    ->getQuery()
                    ->getResult();
                if (count($isExist)) {
                    $this->setMessage("Education can't be inactive because it has been related");
                    $this->setModelLog($this->getMessage());

                    return false;
                }
            }
            $education  = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Education')->find($input->education_id);
            $this->setAction("modify");
        } else {
            $education->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        //Check jika level sama maka ga boleh masuk
        $isExist    = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('e.id')
            ->from('GatotKacaErpMainBundle:Education', 'e')
            ->where('e.level = :level AND e.id != :id')
            ->setParameter('level', $input->education_level)
            ->setParameter('id', $input->education_id)
            ->getQuery()
            ->getResult();
        if (count($isExist)) {
            $this->setMessage("Level is exist, choose other level");
            $this->setModelLog($this->getMessage());

            return false;
        }
        $education->setName(strtoupper($input->education_name));
        $education->setLevel($input->education_level);
        $education->setStatus(isset($input->education_status));
        //Simpan education
        $this->setEntityLog($education);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($education);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($education, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving education with id {$education->getId()}");

            return $education->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("Error while saving education");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data education
     * @return boolean
     **/
    public function delete($id)
    {
        $education  = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Education')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($education);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting education with id {$education->getId()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$education->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }
}
