<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Helper/Helper.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Helper;

use GatotKaca\Erp\MainBundle\Helper\Session;
use GatotKaca\Erp\MainBundle\Helper\ModelManager;

class Helper{
	private $session;
	private $modelManager;

	/**
	 * Untuk mengenerate Id
	 * 
	 * @return string generated id
	 **/
	public function getUniqueId(){
		return sha1(uniqid('', TRUE));
	}
	
	/**
	 * Untuk mengenerate Salt Password
	 * 
	 * @param string username
	 * @return string salt
	 **/
	public function getSalt($username){
		return sha1($username.$this->getUniqueId());
	}
	
	/**
	 * Untuk mengenerate Password
	 * 
	 * @param string password
	 * @param string salt
	 * @return string encoded password
	 **/
	public function hashPassword($password, $salt){
		return sha1($password.$salt);
	}
	
	/**
	 * Untuk mendapatkan session
	 * 
	 * @return session
	 **/
	public function getSession(){
		if(!$this->session){
			$this->session	= new Session();
		}
		
		return $this->session;
	}
	
	/**
	 * Untuk menghitung perbedaan waktu
	 * 
	 * @param datetime start
	 * @param datetime end
	 * 
	 * @return integer different in minutes
	 **/
	public function getTimeDiff($start, $end){
		try{
			$diff	= $end->diff($start);
			$years		= $diff->y * 12 * $diff->days * 24 * 60 * 60;
			$months		= $diff->m * $diff->days * 24 * 60 * 60;
			$days		= $diff->d * 24 * 60 * 60;
			$hours		= $diff->h * 60 * 60;
			$minutes	= $diff->i * 60;
			$seconds	= $diff->s;
			
			return $years + $months + $days + $hours + $minutes + $seconds;
		}catch (\Exception $e){
			return FALSE;
		}
	}

	/**
	 * Untuk mendapatkan model manager
	 * 
	 * @return model manager
	 **/
	public function modelManager(\Doctrine\ORM\EntityManager $entityManager){
		if(!$this->modelManager){
			$this->modelManager	= new ModelManager($entityManager, $this);
		}
		return $this->modelManager;
	}
}
