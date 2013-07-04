<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Entity/Module.php
 * Author    : Muhammad Surya Ikhsanudin
 * License   : Protected
 * Email     : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup
 * - GatotKaca\Erp\UtilitiesBundle\Entity\Module
 **/

namespace GatotKaca\Erp\UtilitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "utl_role")
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity = "UserGroup", inversedBy = "role")
     * @ORM\JoinColumn(name = "utl_group_id", referencedColumnName = "id")
     **/
    protected $group;

    /**
     * @ORM\ManyToOne(targetEntity = "Module", inversedBy = "role")
     * @ORM\JoinColumn(name = "utl_module_id", referencedColumnName = "id")
     **/
    protected $module;

    /**
     * @ORM\Column(name = "`view`", type = "boolean", nullable = true)
     **/
    protected $view;

    /**
     * @ORM\Column(name = "`modif`", type = "boolean", nullable = true)
     **/
    protected $modif;

    /**
     * @ORM\Column(name = "`delete`", type = "boolean", nullable = true)
     **/
    protected $delete;

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

    public function __construct()
    {
        $this->view    = false;
        $this->modif   = false;
        $this->delete  = false;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string $id
     * @return Role
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
     * Set view
     *
     * @param  boolean $view
     * @return Role
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return boolean
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set modif
     *
     * @param  boolean $modif
     * @return Role
     */
    public function setModif($modif)
    {
        $this->modif = $modif;

        return $this;
    }

    /**
     * Get modif
     *
     * @return boolean
     */
    public function getModif()
    {
        return $this->modif;
    }

    /**
     * Set delete
     *
     * @param  boolean $delete
     * @return Role
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;

        return $this;
    }

    /**
     * Get delete
     *
     * @return boolean
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * Set created
     *
     * @param  \DateTime $created
     * @return Role
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
     * @return Role
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
     * @return Role
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
     * @return Role
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
     * Set group
     *
     * @param  \GatotKaca\Erp\UtilitiesBundle\Entity\UserGroup $group
     * @return Role
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
     * Set module
     *
     * @param  \GatotKaca\Erp\UtilitiesBundle\Entity\Module $module
     * @return Role
     */
    public function setModule(\GatotKaca\Erp\UtilitiesBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \GatotKaca\Erp\UtilitiesBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }
}
