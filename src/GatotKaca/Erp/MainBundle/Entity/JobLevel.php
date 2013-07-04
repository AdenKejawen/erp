<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Entity/JobLevel.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 *
 * Relation Mapping :
 * - GatotKaca\Erp\MainBundle\Entity\JobTitle
 **/

namespace GatotKaca\Erp\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "sys_joblevel")
 **/
class JobLevel
{
    /**
     * @ORM\Id
     * @ORM\Column(name = "`id`", type = "string", length = 40)
     **/
    protected $id;

    /**
     * @ORM\Column(name = "`name`", type = "string", length = 77, nullable = true)
     **/
    protected $name;

    /**
     * @ORM\Column(name = "`level`", type = "integer", length = 2, unique = true, nullable = true)
     **/
    protected $level;

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
     * @ORM\OneToMany(targetEntity = "JobTitle", mappedBy = "level")
     **/
    protected $jobtitle;

    public function __construct()
    {
        $this->status   = true;
        $this->created  = new \DateTime();
        $this->updated  = new \DateTime();
    }

    /**
     * Set id
     *
     * @param  string   $id
     * @return JobLevel
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
     * @param  string   $name
     * @return JobLevel
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
     * Set level
     *
     * @param  integer  $level
     * @return JobLevel
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set status
     *
     * @param  boolean  $status
     * @return JobLevel
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
     * @return JobLevel
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
     * @param  string   $createdBy
     * @return JobLevel
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
     * @return JobLevel
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
     * @param  string   $updatedBy
     * @return JobLevel
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
     * Add jobtitle
     *
     * @param  \GatotKaca\Erp\MainBundle\Entity\JobTitle $jobtitle
     * @return JobLevel
     */
    public function addJobtitle(\GatotKaca\Erp\MainBundle\Entity\JobTitle $jobtitle)
    {
        $this->jobtitle[] = $jobtitle;

        return $this;
    }

    /**
     * Remove jobtitle
     *
     * @param \GatotKaca\Erp\MainBundle\Entity\JobTitle $jobtitle
     */
    public function removeJobtitle(\GatotKaca\Erp\MainBundle\Entity\JobTitle $jobtitle)
    {
        $this->jobtitle->removeElement($jobtitle);
    }

    /**
     * Get jobtitle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJobtitle()
    {
        return $this->jobtitle;
    }
}
