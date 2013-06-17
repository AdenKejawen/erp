<?php
/**
 * @filenames   : GatotKaca/Erp/UtilitiesBundle/Controller/SettingController.php
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

class SettingController extends AdminController{
    const MODULE= 'panelparameter';
    /**
     * @Route("/utilities/setting", name="GatotKacaErpUtilitiesBundle_Setting_index")
     */
    public function indexAction(){
        return $this->goHome();
    }

    /**
     * @Route("/utilities/setting/getlist", name="GatotKacaErpUtilitiesBundle_Setting_getList")
     */
    public function getListAction(){
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => FALSE);
        //Don't have authorization
        if(!$security->isAllowed($session->get('group_id'), SettingController::MODULE, 'view')){
            return new JsonResponse($output);
        }
        $output = array('success' => TRUE);
        //Get model
        $model  = $this->getSetting();
        $setting= $model->getAll();
        $output['total']= count($setting);
        $output['data'] = $setting;
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
        return new JsonResponse($output);
    }

    /**
     * @Route("/utilities/setting/save", name="GatotKacaErpUtilitiesBundle_Setting_save")
     */
    public function saveAction(){
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => FALSE);
        //Don't have authorization
        if(!$security->isAllowed($session->get('group_id'), SettingController::MODULE, 'modif')){
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('setting', ''));
        //Get model
        $model  = $this->getSetting();
        if($success = $model->save($input)){
            $output['success']  = TRUE;
            $output['msg']      = 'Setting has been saved.';
        }else{
            $output['msg']      = $model->getMessage().'. Setting has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
        return new JsonResponse($output);
    }
}
