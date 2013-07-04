<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/LanguageModel.php
 * @author: Aden Kejawen
 * @sinoe: Version 1
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\Language;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class LanguageModel extends BaseModel
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
     * Untuk mendapatkan list language berdasarkan limit
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
            $extra  = "AND l.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND l.status = false";
        }
        $start  = ($keyword == '') ? $start : 0;
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'l.id AS language_id,
                l.name AS language_name,
                l.status AS language_status'
            )
            ->from('GatotKacaErpMainBundle:Language', 'l')
            ->where("l.name LIKE :name {$extra}")
            ->setParameter('name', "%{$keyword}%")
            ->orderBy('l.name', 'ASC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get language from {$start} to {$limit}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total language
     *
     * @param  string  $keyword
     * @param  integer $limit
     * @return integer total
     **/
    public function countTotal($keyword, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND l.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND l.status = false";
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('l.id AS language_id');
        $qb->from('GatotKacaErpMainBundle:Language', 'l');
        $qb->where("l.name LIKE :name {$extra}");
        $qb->setParameter('name', "%{$keyword}%");
        if ($keyword != '') {
            $qb->setFirstResult(0);
            $qb->setMaxResults($limit);
        };
        $query  = $qb->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan data language by Id
     *
     * @param mixed id
     **/
    public function getById($id)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'l.id AS language_id,
                l.name AS language_name,
                l.status AS language_status'
            )
            ->from('GatotKacaErpMainBundle:Language', 'l')
            ->where('l.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $this->setModelLog("get language with id {$id}");

        return $query->getResult();
    }

    /**
     * Untuk menyimpan data language
     *
     * @param mixed $input
     **/
    public function save($input)
    {
        $language   = new Language();
        if (isset($input->language_id) && $input->language_id != '') {
            //Check jika language telah berelasi tidak boleh dinonaktifkan
            if (!isset($input->language_status)) {
                $isExist    = $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('el.id')
                    ->from('GatotKacaErpHumanResourcesBundle:EmployeeLanguage', 'el')
                    ->where('el.language = :language')
                    ->setParameter('language', $input->language_id)
                    ->getQuery()
                    ->getResult();
                if (count($isExist)) {
                    $this->setMessage("Language can't be inactive because it has been related");
                    $this->setModelLog($this->getMessage());

                    return false;
                }
            }
            $language   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Language')->find($input->language_id);
            $this->setAction("modify");
        } else {
            $language->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        $language->setName(strtoupper($input->language_name));
        $language->setStatus(isset($input->language_status));
        //Simpan language
        $this->setEntityLog($language);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->persist($language);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($language, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving language with id {$language->getId()}");

            return $language->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("Error while saving language");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data language
     * @return boolean
     **/
    public function delete($id)
    {
        $language   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Language')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($language);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting language with id {$language->getId()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$language->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }
}
