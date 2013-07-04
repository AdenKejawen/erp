<?php
/**
 * @filenames   : GatotKaca/Erp/MainBundle/Controller/DepartmentController.php
 * Author       : Muhammad Surya Ikhsanudin
 * License      : Protected
 * Email        : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class DepartmentController extends AdminController
{
    const MODULE= 'paneldepartment';

    /**
     * @Route("/department", name="GatotKacaErpMainBundle_Department_index")
     */
    public function indexAction()
    {
        return $this->goHome();
    }

    /**
     * @Route("/department/getbyid", name="GatotKacaErpMainBundle_Department_getById")
     */
    public function getByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), DepartmentController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getDepartment();
        $department = $model->getBy('id', $request->get('department_id', ''));
        if ($total = count($department)) {
            $output['data'] = $department;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/department/delete", name="GatotKacaErpMainBundle_Department_delete")
     */
    public function deleteAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), DepartmentController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getDepartment();
        if ($success = $model->delete($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Department has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/department/getlist", name="GatotKacaErpMainBundle_Department_getList")
     */
    public function getListAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), DepartmentController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        $keyword= strtoupper($request->get('query', ''));
        $start  = abs($request->get('start'));
        $limit  = abs($request->get('limit'));
        $status = $request->get('status', 'true');
        //Get model
        $model  = $this->getModelManager()->getDepartment();
        $model->setStatus(($status === 'all') ? null : $status);
        $department = $model->getList($keyword, $start, $limit);
        if ($total = count($department)) {
            $output['total']= $model->countTotal($keyword, $limit);
            $output['data'] = $department;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/department/getbycompany", name="GatotKacaErpMainBundle_Department_getByCompany")
     */
    public function getByCompanyAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), DepartmentController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $status = $request->get('status', 'true');
        $start  = abs($request->get('start'));
        $limit  = abs($request->get('limit'));
        $model  = $this->getModelManager()->getDepartment();
        $model->setStatus(($status === 'all') ? null : $status);
        $department = $model->getBy('company', $request->get('company_id', ''), $start, $limit);
        if ($total = count($department)) {
            $output['data'] = $department;
            $output['total']= $model->countTotalBy('company', $request->get('company_id', ''));
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/department/save", name="GatotKacaErpMainBundle_Department_save")
     */
    public function saveAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), DepartmentController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('department'));
        //Get model
        $model  = $this->getModelManager()->getDepartment();
        if ($success = $model->save($input)) {
            $output['success']  = true;
            $output['msg']      = 'Department has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Department has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }
}
