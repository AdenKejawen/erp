<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/BaseModel.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/

namespace GatotKaca\Erp\MainBundle\Model;

class BaseModel{
	private $em;
	private $helper;
	private $message;
	private $log;
	private $action;
	private $status;
	
	/**
	 * Construct BaseModel
	 * 
	 * @param \Doctrine\ORM\EntityManager $em
	 * @param \GatotKaca\Erp\MainBundle\Helper\Helper $helper
	 **/
	public function __construct(\Doctrine\ORM\EntityManager $em = NULL, \GatotKaca\Erp\MainBundle\Helper\Helper $helper = NULL){
		$this->em		= $em;
		$this->helper	= $helper;
		$this->action	= 'ACCESS';
	}
	
	/**
	 *  Set status
	 *
	 *  @param boolean $status
	 **/
	public function setStatus($status){
		$this->status	= $status;
	}
	
	/**
	 * Get status
	 *
	 * @return boolean $status
	 **/
	public function getStatus(){
		return $this->status;
	}
	
	/**
	 * Set message
	 * 
	 * @param string $message
	 **/
	public function setMessage($message){
		$this->message	= $message;
	}
	
	/**
	 * Get message
	 * 
	 * @return string message
	 **/
	public function getMessage(){
		return $this->message;
	}
	
	/**
	 * Set action user
	 * 
	 * @param string $action
	 **/
	public function setAction($action){
		$this->action	= strtoupper($action);
	}
	
	/**
	 * Get action user
	 * 
	 * @return string
	 **/
	public function getAction(){
		return $this->action;
	}
	
	/**
	 * Set entity manager
	 * 
	 * @param \Doctrine\ORM\EntityManager $em
	 **/
	public function setEntityManager(\Doctrine\ORM\EntityManager $em){
		$this->em	= $em;
	}
	
	/**
	 * Get entity manager
	 * 
	 * @return \Doctrine\ORM\EntityManager
	 **/
	public function getEntityManager(){
		return $this->em;
	}
	
	/**
	 * Set helper
	 * 
	 * @param \GatotKaca\Erp\MainBundle\Helper\Helper $helper
	 **/
	public function setHelper(\GatotKaca\Erp\MainBundle\Helper\Helper $helper){
		$this->helper	= $helper;
	}
	
	/**
	 * Get helper
	 * 
	 * @return \GatotKaca\Erp\MainBundle\Helper\Helper $helper
	 **/
	public function getHelper(){
		return $this->helper;
	}
	
	/**
	 * Set log message
	 * 
	 * @param string $log
	 **/
	public function setModelLog($log){
		$this->log	= strtoupper($log);
	}
	
	/**
	 * Get log message
	 * 
	 * @return string log message
	 **/
	public function getModelLog(){
		return $this->log;
	}

	/**
	 * Set log entity
	 * 
	 * @param string $log
	 **/
	public function setEntityLog($entity){
		if($this->action === 'CREATE'){
			$entity->setCreatedby($this->getHelper()->getSession()->get('user_name'));
			$entity->setUpdatedby($this->getHelper()->getSession()->get('user_name'));
		}else{
			$entity->setUpdated(new \DateTime());
			$entity->setUpdatedby($this->getHelper()->getSession()->get('user_name'));
		}
	}
}