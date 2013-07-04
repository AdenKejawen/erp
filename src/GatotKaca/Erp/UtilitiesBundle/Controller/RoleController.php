<?php
/**
 * @filenames   : GatotKaca/Erp/UtilitiesBundle/Controller/RoleController.php
 * Author       : Muhammad Surya Ikhsanudin
 * License      : Protected
 * Email        : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\UtilitiesBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class RoleController extends AdminController
{
    const MODULE= 'panelrole';
    const GROUP = 'panelgroup';

    /**
     * @Route("/utilities/role", name="GatotKacaErpUtilitiesBundle_Role_index")
     **/
    public function indexAction()
    {
        return $this->goHome();
    }

    /**
     * @Route("/utilities/role/getlist", name="GatotKacaErpUtilitiesBundle_Role_getList")
     *
     * Get Role List by Group
     **/
    public function getListAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), RoleController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $start  = abs($request->get('start'));
        $limit  = abs($request->get('limit'));
        $status = $request->get('status', 'true');
        $model  = $this->getModelManager()->getRole();
        $model->setStatus(($status === 'all') ? null : $status);
        $role   = $model->getListByGroup($request->get('group_id', ''), $start, $limit);
        if ($total   = count($role)) {
            $output['total']= $model->countListByGroup($request->get('group_id', ''));
            $output['data'] = $role;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/utilities/role/getgroup", name="GatotKacaErpUtilitiesBundle_Role_getGroup")
     *
     * Get Role List by Group
     **/
    public function getGroupAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), RoleController::GROUP, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        $keyword= strtoupper($request->get('query', ''));
        $start  = abs($request->get('start'));
        $limit  = abs($request->get('limit'));
        $status = $request->get('status', 'true');
        //Get model
        $model  = $this->getModelManager()->getRole();
        $model->setStatus(($status === 'all') ? null : $status);
        $user   = $model->getGroupList($keyword, $start, $limit);
        if ($total = count($user)) {
            $output['total']= $model->countTotalGroup($keyword, $limit);
            $output['data'] = $user;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/utilities/role/getgroupbyid", name="GatotKacaErpUtilitiesBundle_Role_getGroupById")
     */
    public function getGroupByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), RoleController::GROUP, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $model  = $this->getModelManager()->getRole();
        $role   = $model->getGroup($request->get('group_id'));
        if (count($role)) {
            $output['data'] = $role;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/utilities/role/getbyid", name="GatotKacaErpUtilitiesBundle_Role_getById")
     */
    public function getByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), RoleController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $model  = $this->getModelManager()->getRole();
        $role   = $model->getById($request->get('role_id'));
        if (count($role)) {
            $output['data'] = $role;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/utilities/role/update", name="GatotKacaErpUtilitiesBundle_Role_update")
     */
    public function updateAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), RoleController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getRole();
        $input  = json_decode($request->get('role'));
        if ($success = $model->save($input)) {
            $output['success']  = true;
            $output['msg']      = 'Role has been modified.';
        } else {
            $output['msg']      = $model->getMessage().'. Role has not been modified.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/utilities/role/savegroup", name="GatotKacaErpUtilitiesBundle_Role_saveGroup")
     */
    public function saveGroupAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), RoleController::GROUP, 'modif')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getRole();
        $input  = json_decode($request->get('group'));
        if ($success = $model->saveGroup($input)) {
            $output['success']  = true;
            $output['msg']      = 'Group has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Group has not been modified.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }
}
