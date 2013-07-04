<?php
/**
 * @filenames   : GatotKaca/Erp/UtilitiesBundle/Controller/UserController.php
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

class UserController extends AdminController
{
    const MODULE   = 'paneluser';
    const PASSWORD = 'personalpassword';

    /**
     * @Route("/utilities/user", name="GatotKacaErpUtilitiesBundle_User_index")
     */
    public function indexAction()
    {
        return $this->goHome();
    }

    /**
     * @Route("/utilities/user/getlist", name="GatotKacaErpUtilitiesBundle_User_getList")
     */
    public function getListAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), UserController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        $keyword= strtoupper($request->get('query', ''));
        $start  = abs($request->get('start'));
        $limit  = abs($request->get('limit'));
        $status = $request->get('status', 'true');
        //Get model
        $model  = $this->getModelManager()->getUser();
        $model->setStatus(($status === 'all') ? null : $status);
        $user   = $model->getList($keyword, $start, $limit);
        if ($total = count($user)) {
            $output['total']= $model->countTotal($keyword, $limit);
            $output['data'] = $user;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/utilities/user/getbyid", name="GatotKacaErpUtilitiesBundle_User_getById")
     */
    public function getByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), UserController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $model  = $this->getModelManager()->getUser();
        $user   = $model->getById($request->get('user_id'), $request->get('table'));
        if (count($user)) {
            $output['data'] = $user;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/utilities/user/update", name="GatotKacaErpUtilitiesBundle_User_update")
     */
    public function updateAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), UserController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        //Get model
        $model = $this->getModelManager()->getUser();
        $input = json_decode($request->get('user'));
        if ($success = $model->save($input)) {
            $output['success']  = true;
            $output['msg']      = 'User has been modified.';
        } else {
            $output['msg']      = $model->getMessage().'. User has not been modified.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/utilities/user/getpassword", name="GatotKacaErpUtilitiesBundle_User_getPassword")
     */
    public function getPasswordAction()
    {
        return new JsonResponse(array('password_id' => 'fake', 'password_name' => 'fake_password'));
    }

    /**
     * @Route("/utilities/user/updatepassword", name="GatotKacaErpUtilitiesBundle_User_updatePassword")
     */
    public function updatePasswordAction()
    {
        $session  = $this->getHelper()->getSession();
        $request  = $this->getRequest();
        $security = $this->getSecurity();
        $output   = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), UserController::PASSWORD, 'modif')) {
            return new JsonResponse($output);
        }
        //Get model
        $model = $this->getModelManager()->getUser();
        $input = json_decode($request->get('password'));
        if ($success = $model->updatePassword($input, $security)) {
            $output['success']  = true;
            $output['msg']      = 'Password has been modified.';
        } else {
            $output['msg']      = $model->getMessage().'. Password has not been modified.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }
}
