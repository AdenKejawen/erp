<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/ReligionModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Model\BaseModel;

class ReligionModel extends BaseModel{
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
	 * Untuk mendapatkan list religion
	 **/
	public function getList(){
		$query	= $this->getEntityManager()
				->createQueryBuilder()
				->select('
					r.id AS religion_id,
					r.name AS religion_name
				')
				->from('GatotKacaErpMainBundle:Religion', 'r')
				->getQuery();
		$this->setModelLog("get all religion");
		return $query->getResult();
	}
}