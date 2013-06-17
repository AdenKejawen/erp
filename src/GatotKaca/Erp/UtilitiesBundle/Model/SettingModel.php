<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Model/SettingModel.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\UtilitiesBundle\Model;

use GatotKaca\Erp\UtilitiesBundle\Entity\Setting;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\DBAL\LockMode;

class SettingModel extends BaseModel{
    private static $SETTING;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param Helper $helper
     **/
    public function __construct(\Doctrine\ORM\EntityManager $entityManager, \GatotKaca\Erp\MainBundle\Helper\Helper $helper){
        parent::__construct($entityManager, $helper);
        $query  = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('s.param, s.value')
                ->from('GatotKacaErpUtilitiesBundle:Setting', 's')
                ->where("s.param LIKE 'OT_%'")
                ->getQuery()
                ->getResult();
        foreach($query as $key => $value){
            self::$SETTING[$value['param']] = $value['value'];
        }
        self::$SETTING['MONTH']     = date('n');
        self::$SETTING['MONTH_END'] = date('t');
    }

    /**
     * Set Employee
     * @param string
     **/
    public function setLoyal($loyal){
        self::$SETTING['LOYAL'] = $loyal;
    }

    /**
     * Get value by key
     * @return string value
     **/
    public function get($key){
        $query  = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('s.value')
                ->from('GatotKacaErpUtilitiesBundle:Setting', 's')
                ->where('s.param = :key')
                ->setParameter('key', strtoupper($key))
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        return $query['value'];
    }

    public function getMathNotation($key){
        $notation   = $this->get(strtoupper($key));
        foreach(self::$SETTING as $key => $value){
            $notation   = str_replace(array_keys(self::$SETTING), array_values(self::$SETTING), $notation);
        }
        return str_replace(array('[', ']'), array('(', ')'), $notation);
    }

    /**
     * Calculate
     **/
    public function calculate($formula){
        if($formula === '' || $formula === NULL){
            return 1;
        }
        $mapping    = new ResultSetMapping();
        $mapping->addScalarResult('hasil', 'output');
        try {
            $query      = $this->getEntityManager()->createNativeQuery("SELECT {$formula} AS hasil", $mapping)->getOneOrNullResult();
            return $query['output'];
        }catch(\Exception $e) {
            throw new \Exception('SQL Syntax Error. Check your parameter setting.');
        }
    }

    /**
     * Untuk mendapatkan semua setting
     *
     * @return array result
     **/
    public function getAll(){
        $query  = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('
                s.param AS setting_id,
                s.value AS setting_name
                ')
                ->from('GatotKacaErpUtilitiesBundle:Setting', 's')
                ->orderBy('s.param')
                ->getQuery();
        $this->setModelLog("get all setting");
        return $query->getResult();
    }

    /**
     * Untuk menyimpan data setting
     *
     * @param mixed $input
     **/
    public function save($input){
        $this->setAction('modify');
        foreach($input as $key => $value){
            $setting = $this->getEntityManager()->getRepository('GatotKacaErpUtilitiesBundle:Setting')->findOneBy(array('param' => $key));
            $setting->setValue($value);
            $this->setEntityLog($setting);
            $this->getEntityManager()->persist($setting);
        }
        //Simpan setting
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("saving setting with id {$setting->getId()}");
            return $setting->getId();
        }catch(\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("Error while saving job title");
            $this->setModelLog($this->getMessage());
            return FALSE;
        }
    }
}
