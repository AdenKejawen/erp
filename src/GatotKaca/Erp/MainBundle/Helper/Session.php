<?php
/**
 * @filenames: GatotKaca/Erp/Helper/Session.php
 * @author: Aden Kejawen
 * @since: Version 1
 **/
namespace GatotKaca\Erp\MainBundle\Helper;

use Symfony\Component\HttpFoundation\Session\Session as BaseSession;

class Session extends BaseSession{
	
	public function __construct(){
		parent::__construct();
		
		/**
		 * Value dapat dirubah melalui fungsi lifetime()
		 **/
		if(!$this->get('lifetime')){
			$this->set('lifetime', 3600);//Default 1 hour
			$this->set('time', strtotime(date('Y-m-d H:i:s')));
		}
	}
	
	/**
	 * Check session expire using time in second
	 * 
	 * @return boolean
	 **/
	public function isValid(){
		$lifetime	= strtotime(date('Y-m-d H:i:s')) - $this->get('time');
		if($lifetime <= $this->get('lifetime')){
			$this->set('time', strtotime(date('Y-m-d H:i:s')));
			return TRUE;
		}
		$this->clear();
		return FALSE;
	}
	
	/**
	 * Set session lifetime
	 * 
	 * @param string time
	 **/
	public function lifetime($lifetime){
		$this->set('lifetime', $lifetime);
		$this->set('time', strtotime(date('Y-m-d H:i:s')));
		
		return $this;
	}
}