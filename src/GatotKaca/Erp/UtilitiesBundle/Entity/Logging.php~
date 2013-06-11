<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Entity/Logging.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 * 
 * Relation Mapping : ~
 **/

namespace GatotKaca\Erp\UtilitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "utl_log")
 **/
class Logging{
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string", length = 40)
	 **/
	protected $id;
	
	/**
	 * @ORM\Column(type = "string", length = 17, nullable = true)
	 **/
	protected $agent;
	
	/**
	 * @ORM\Column(type = "string", length = 40, nullable = true)
	 **/
	protected $user_id;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = true)
	 **/
	protected $route;
	
	/**
	 * @ORM\Column(type = "string", length = 7, nullable = true)
	 **/
	protected $type;
	
	/**
	 * @ORM\Column(type = "string", length = 255, nullable = true)
	 **/
	protected $value;
	
	/**
	 * @ORM\Column(type = "datetime")
	 **/
	protected $created;
	
	public function __construct(){
		/**
		 * Log Type
		 * - ACCESS
		 * - LOGIN
		 * - LOGOUT
		 * - CREATE
		 * - MODIFY
		 * - DELETE
		 **/
		$this->log_type	= 'ACCESS';
		$this->created	= new \DateTime();
	}

    /**
     * Set id
     *
     * @param string $id
     * @return Logging
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set agent
     *
     * @param string $agent
     * @return Logging
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    
        return $this;
    }

    /**
     * Get agent
     *
     * @return string 
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set user_id
     *
     * @param string $userId
     * @return Logging
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    
        return $this;
    }

    /**
     * Get user_id
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return Logging
     */
    public function setRoute($route)
    {
        $this->route = $route;
    
        return $this;
    }

    /**
     * Get route
     *
     * @return string 
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Logging
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Logging
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Logging
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
}