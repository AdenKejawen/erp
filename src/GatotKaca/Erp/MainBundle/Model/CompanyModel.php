<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Model/CompanyModel.php
 * @author: Aden Kejawen
 * @sinoe: Version 1
 **/

namespace GatotKaca\Erp\MainBundle\Model;

use GatotKaca\Erp\MainBundle\Entity\Company;
use GatotKaca\Erp\MainBundle\Entity\CompanyDepartment;
use GatotKaca\Erp\MainBundle\Model\BaseModel;
use Doctrine\DBAL\LockMode;

class CompanyModel extends BaseModel
{
    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param Helper        $helper
     **/
    public function __construct(\Doctrine\ORM\EntityManager $entityManager, \GatotKaca\Core\Helper\Helper $helper)
    {
        parent::__construct($entityManager, $helper);
    }

    /**
     * Untuk mendapatkan list company berdasarkan limit
     *
     * @param  integer $start
     * @param  integer $limit
     * @return array   result
     **/
    public function getList($keyword, $start, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND c.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND c.status = false";
        }
        $start  = ($keyword == '') ? $start : 0;
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                'c.id AS company_id,
                c.code AS company_code,
                p.id AS company_parent,
                p.name AS company_pname,
                c.name AS company_name'
            )
            ->from('GatotKacaErpMainBundle:Company', 'c')
            ->leftJoin('GatotKacaErpMainBundle:Company', 'p', 'WITH', 'p.id = c.parent')
            ->where("c.name LIKE :name {$extra}")
            ->setParameter('name', "%{$keyword}%")
            ->orderBy('c.name', 'ASC')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->getQuery();
        $this->setModelLog("get company from {$start} to {$limit}");

        return $query->getResult();
    }

    /**
     * Untuk mendapatkan total company
     *
     * @param  string  $keyword
     * @param  integer $limit
     * @return integer total
     **/
    public function countTotal($keyword, $limit)
    {
        $extra  = '';
        if ($this->getStatus() === 'true') {
            $extra  = "AND c.status = true";
        } elseif ($this->getStatus() === 'false') {
            $extra  = "AND c.status = false";
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c.id AS company_id');
        $qb->from('GatotKacaErpMainBundle:Company', 'c');
        $qb->where("c.name LIKE :name {$extra}");
        $qb->setParameter('name', "%{$keyword}%");
        if ($keyword != '') {
            $qb->setFirstResult(0);
            $qb->setMaxResults($limit);
        };
        $query  = $qb->getQuery();

        return count($query->getResult());
    }

    /**
     * Untuk mendapatkan data company by Id
     *
     * @param mixed id
     **/
    public function getById($id)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select(
                "c.id AS company_id,
                p.id AS parent_company,
                c.code AS company_code,
                c.name AS company_name,
                c.status AS company_status,
                c.is_fixed AS company_isfixed,
                c.work_day_start AS workday_start,
                c.work_day_end AS workday_end,
                TO_CHAR(c.office_hour, 'HH24:MI:SS') AS officehour"
            )
            ->from('GatotKacaErpMainBundle:Company', 'c')
            ->leftJoin('GatotKacaErpMainBundle:Company', 'p', 'WITH', 'p.id = c.parent')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $this->setModelLog("get company with id {$id}");

        return $query->getResult();
    }

    /**
     * Untuk menyimpan data company
     *
     * @param mixed $input
     **/
    public function save($input, $departments)
    {
        $company    = new Company();
        if (isset($input->company_id) && $input->company_id != '') {
            //Check jika company telah berelasi tidak boleh dinonaktifkan
            if (!isset($input->company_status)) {
                $isExist    = $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('e.id')
                    ->from('GatotKacaErpHumanResourcesBundle:Employee', 'e')
                    ->where('e.company = :company')
                    ->setParameter('company', $input->company_id)
                    ->getQuery()
                    ->getResult();
                if (count($isExist)) {
                    $this->setMessage("Company can't be inactive because it has been related");
                    $this->setModelLog($this->getMessage());

                    return false;
                }
            }
            $company    = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Company')->find($input->company_id);
            $this->setAction("modify");
        } else {
            $company->setId($this->getHelper()->getUniqueId());
            $this->setAction("create");
        }
        if (isset($input->parent_company) && $input->parent_company !== "") {
            $company->setParent($this->getEntityManager()->getReference('GatotKacaErpMainBundle:Company', $input->parent_company));
        }
        $company->setName(strtoupper($input->company_name));
        $company->setCode(strtoupper($input->company_code));
        $company->setStatus(isset($input->company_status));
        if ($fixed = isset($input->company_isfixed)) {
            $company->setIsFixed($fixed);
            $company->setIsTimeBase(!$fixed);
            $company->setWorkDayStart($input->workday_start);
            $company->setWorkDayEnd($input->workday_end);
            $company->setOfficeHour(null);
        } else {
            $company->setIsFixed($fixed);
            $company->setIsTimeBase(!$fixed);
            $company->setWorkDayStart(null);
            $company->setWorkDayEnd(null);
            $company->setOfficeHour(new \DateTime(date('Y-m-d').' '.$input->company_hin.':'.$input->company_min.':00'));
        }
        //Simpan company
        $this->setEntityLog($company);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            //Assign all department to company
            $division   = null;
            if ($this->getAction() === 'CREATE') {
                $departments    = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Department')->findAll();
                foreach ($departments as $department) {
                    $division   = new CompanyDepartment();
                    $division->setId($this->getHelper()->getUniqueId());
                    $division->setDepartment($department);
                    $division->setCompany($company);
                    $this->setEntityLog($division);
                    $this->getEntityManager()->persist($division);
                }
            } else {
                foreach ($departments as $department) {
                    $division   = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:CompanyDepartment')->findOneBy(
                        array(
                            'company'       => $company->getId(),
                            'department'    => $department->department_id
                        )
                    );
                    $division->setStatus($department->division_status);
                    $this->setEntityLog($division);
                    $this->getEntityManager()->persist($division);
                }
            }
            $this->getEntityManager()->persist($company);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->lock($company, LockMode::PESSIMISTIC_READ);
            $connection->commit();
            $this->setModelLog("saving company with id {$company->getId()}");

            return $company->getId();
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("Error while saving company");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk menghapus data company
     * @return boolean
     **/
    public function delete($id)
    {
        $company    = $this->getEntityManager()->getRepository('GatotKacaErpMainBundle:Company')->find($id);
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
        try {
            $this->getEntityManager()->remove($company);
            $this->getEntityManager()->flush();
            $connection->commit();
            $this->setModelLog("deleting company with id {$company->getId()}");

            return true;
        } catch (\Exception $e) {
            $connection->rollback();
            $this->getEntityManager()->close();
            $this->setMessage("{$company->getName()} has been related.");
            $this->setModelLog($this->getMessage());

            return false;
        }
    }

    /**
     * Untuk mendapatkan hari kerja
     * @param  integer $day 1 - 7
     * @return boolean
     */
    public function isWorkDay($day, $company)
    {
        $workday    = $this->getWorkDay($company);
        if ($day >= $workday['workday_start'] && $day <= $workday['workday_end']) {
            return false;
        }

        return true;
    }

    public function getWorkDay($company)
    {
        $query  = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('c.workday_start AS workday_start, c.workday_end AS workday_end')
            ->from('GatotKacaErpMainBundle:Company', 'c')
            ->where('c.id = :company AND c.isfixed = true')
            ->setParameter('company', $company)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $query;
    }
}
