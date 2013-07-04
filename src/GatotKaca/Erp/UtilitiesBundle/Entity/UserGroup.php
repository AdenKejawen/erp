<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/UserGroup.php
 * Author    : Muhammad Surya Ikhsanudin
 * License   : Protected
 * Email     : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\UtilitiesBundle\Entity\User
 * - GatotKaca\Erp\UtilitiesBundle\Entity\Role
 **/
namespace GatotKaca\Erp\UtilitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "utl_group")
 **/
class UserGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 27, nullable = true)
     **/
    protected $name;

    /**
     * @ORM\Column(name = "`relation`", type = "string", length = 77, nullable = true)
     **/
    protected $relation;

    /**
     * @ORM\Column(name = "`status`", type = "boolean", nullable = true)
     **/
    protected $status;

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
    * @ORM\OneToMany(targetEntity = "User", mappedBy = "group")
    **/
    protected $user;

    /**
    * @ORM\OneToMany(targetEntity = "Role", mappedBy = "group")
    **/
    protected $role;

    public function __construct()
    {
        $this->status  = true;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string    $id
     * @return UserGroup
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
     * @param  string    $name
     * @return UserGroup
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
     * Set relation
     *
     * @param  string    $relation
     * @return UserGroup
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * Get relation
     *
     * @return string
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Set status
     *
     * @param  boolean   $status
     * @return UserGroup
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
     * Set created
     *
     * @param  \DateTime $created
     * @return UserGroup
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
     * @param  string    $createdBy
     * @return UserGroup
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
     * @return UserGroup
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
     * @param  string    $updatedBy
     * @return UserGroup
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
     * Add user
     *
     * @param  \GatotKaca\Erp\UtilitiesBundle\Entity\User $user
     * @return UserGroup
     */
    public function addUser(\GatotKaca\Erp\UtilitiesBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\User $user
     */
    public function removeUser(\GatotKaca\Erp\UtilitiesBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add role
     *
     * @param  \GatotKaca\Erp\UtilitiesBundle\Entity\Role $role
     * @return UserGroup
     */
    public function addRole(\GatotKaca\Erp\UtilitiesBundle\Entity\Role $role)
    {
        $this->role[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \GatotKaca\Erp\UtilitiesBundle\Entity\Role $role
     */
    public function removeRole(\GatotKaca\Erp\UtilitiesBundle\Entity\Role $role)
    {
        $this->role->removeElement($role);
    }

    /**
     * Get role
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRole()
    {
        return $this->role;
    }
}
