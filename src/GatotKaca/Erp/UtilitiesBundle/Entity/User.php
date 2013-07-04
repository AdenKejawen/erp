<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Entity/User.php
 * Author    : Muhammad Surya Ikhsanudin
 * License   : Protected
 * Email     : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup
 * - GatotKaca\Erp\HumanResourcesBundle\Entity\Employee
 **/
namespace GatotKaca\Erp\UtilitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "utl_user")
 **/
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity = "User", mappedBy = "parent")
     **/
    protected $child;

    /**
     * Untuk supervisi
     *
     * @ORM\ManyToOne(targetEntity = "User", inversedBy = "child")
     * @ORM\JoinColumn(name = "parent", referencedColumnName = "id")
     */
     protected $parent;

     /**
      * @ORM\ManyToOne(targetEntity = "UserGroup", inversedBy = "user")
      * @ORM\JoinColumn(name = "utl_group_id", referencedColumnName = "id")
      **/
     protected $group;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 17, nullable = true)
     **/
    protected $name;

    /**
     * @ORM\Column(name = "`salt`", type = "string", length = 40, nullable = true)
     **/
    protected $salt;

    /**
     * @ORM\Column(name = "`pass`", type = "string", length = 40, nullable = true)
     **/
    protected $password;

    /**
     * @ORM\Column(name = "`status`", type = "boolean", nullable = true)
     **/
    protected $status;

    /**
     * @ORM\Column(name = "`online`", type = "boolean", nullable = true)
     **/
    protected $online;

    /**
     * @ORM\Column(name = "`lastactivity`", type = "datetime", nullable = true)
     **/
    protected $last_activity;

    /**
     * @ORM\Column(name = "`created`", type = "datetime")
     **/
    protected $created;

    /**
     * @ORM\Column(name = "`createdby`", type = "string", length = 40)
     **/
    protected $created_by;

    /**
     * @ORM\Column(name = "`updated`", type = "datetime")
     **/
    protected $updated;

    /**
     * @ORM\Column(name = "`updatedby`", type = "string", length = 40)
     **/
    protected $updated_by;

    /**
     * @ORM\OneToMany(targetEntity = "GatotKaca\Erp\HumanResourcesBundle\Entity\Employee", mappedBy = "username")
     **/
    protected $employee;

    public function __construct()
    {
        $this->last_activity = new \DateTime();
        $this->created   = new \DateTime();
        $this->updated   = new \DateTime();
        $this->status    = true;
        $this->is_online = false;
    }

    /**
     * Set id
     *
     * @param  string $id
     * @return User
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
     * Set name
     *
     * @param  string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set salt
     *
     * @param  string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param  string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set status
     *
     * @param  boolean $status
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set online
     *
     * @param  boolean $online
     * @return User
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return boolean
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set last_activity
     *
     * @param  \DateTime $lastActivity
     * @return User
     */
    public function setLastActivity($lastActivity)
    {
        $this->last_activity = $lastActivity;

        return $this;
    }

    /**
     * Get last_activity
     *
     * @return \DateTime
     */
    public function getLastActivity()
    {
        return $this->last_activity;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return User
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

    /**
     * Set created_by
     *
     * @param  string $createdBy
     * @return User
     */
    public function setCreatedBy($createdBy)
    {
        $this->created_by = $createdBy;

        return $this;
    }

    /**
     * Get created_by
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set updated
     *
     * @param  \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updated_by
     *
     * @param  string $updatedBy
     * @return User
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updated_by = $updatedBy;

        return $this;
    }

    /**
     * Get updated_by
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Add child
     *
     * @param  \GatotKaca\Erp\UtilitiesBundle\Entity\User $child
     * @return User
     */
    public function addChild(\GatotKaca\Erp\UtilitiesBundle\Entity\User $child)
    {
        $this->child[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\User $child
     */
    public function removeChild(\GatotKaca\Erp\UtilitiesBundle\Entity\User $child)
    {
        $this->child->removeElement($child);
    }

    /**
     * Get child
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Set parent
     *
     * @param  \GatotKaca\Erp\UtilitiesBundle\Entity\User $parent
     * @return User
     */
    public function setParent(\GatotKaca\Erp\UtilitiesBundle\Entity\User $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \GatotKaca\Erp\UtilitiesBundle\Entity\User
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set group
     *
     * @param  \GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup $group
     * @return User
     */
    public function setGroup(\GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add employee
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     * @return User
     */
    public function addEmployee(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee)
    {
        $this->employee[] = $employee;

        return $this;
    }

    /**
     * Remove employee
     *
     * @param \GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee
     */
    public function removeEmployee(\GatotKaca\Erp\HumanResourcesBundle\Entity\Employee $employee)
    {
        $this->employee->removeElement($employee);
    }

    /**
     * Get employee
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployee()
    {
        return $this->employee;
    }
}
