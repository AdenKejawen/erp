<?php
/**
 * @filenames   : GatotKaca/Erp/MainBundle/Controller/ProvinceController.php
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

class ProvinceController extends AdminController
{
    const MODULE= 'panelprovince';
    /**
     * @Route("/province", name="GatotKacaErpMainBundle_Province_index")
     */
    public function indexAction()
    {
        return $this->goHome();
    }

    /**
     * @Route("/province/getbycountry", name="GatotKacaErpMainBundle_Province_getByCountry")
     */
    public function getByCountryAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), ProvinceController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getProvince();
        $province   = $model->getBy('country', $request->get('country_id'));
        if ($total = count($province)) {
            $output = $province;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/province/getlist", name="GatotKacaErpMainBundle_Province_getList")
     */
    public function getListAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), ProvinceController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        $keyword    = strtoupper($request->get('query', ''));
        $start      = abs($request->get('start'));
        $limit      = abs($request->get('limit'));
        //Get model
        $model      = $this->getModelManager()->getProvince();
        $province   = $model->getList($keyword, $start, $limit);
        if ($total = count($province)) {
            $output['total']= $model->countTotal($keyword, $limit);
            $output['data'] = $province;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/province/getbyid", name="GatotKacaErpMainBundle_Province_getById")
     */
    public function getByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), ProvinceController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getProvince();
        $province   = $model->getBy('id', $request->get('province_id'));
        if (count($province)) {
            $output['data'] = $province;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/province/save", name="GatotKacaErpMainBundle_Province_save")
     */
    public function saveAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), ProvinceController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('province', ''));
        //Get model
        $model  = $this->getModelManager()->getProvince();
        if ($success    = $model->save($input)) {
            $output['success']  = true;
            $output['msg']      = 'Province has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Province has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/province/delete", name="GatotKacaErpMainBundle_Province_delete")
     */
    public function deleteAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), ProvinceController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getProvince();
        if ($success    = $model->delete($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Province has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }
}
