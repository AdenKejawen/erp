<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/MainController.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Controller;

use GatotKaca\Erp\MainBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends BaseController{
    /**
     * @Route("/", name="GatotKacaErpMainBundle_Main_index")
     * @Template()
     **/
    public function indexAction(){
        $session    = $this->getHelper()->getSession();
        if(!$session->get('ERP_LOGGED_IN') || !$session->isValid()){
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
        return array(
            'global'    => array(
                'GATOT_KACA_USER_ID'    => $session->get('user_id'),
                'GATOT_KACA_USER_NAME'  => $session->get('user_name'),
                'GATOT_KACA_GROUP_ID'   => $session->get('group_id'),
                'GATOT_KACA_GROUP_NAME' => $session->get('group_name')
            ),
        );
    }

    /**
     * @Route("/login", name="GatotKacaErpMainBundle_Main_login")
     * @Template()
     **/
    public function loginAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $response   = new JsonResponse();
            $response->setStatusCode(500);
            return $response;
        }
        $session    = $this->getHelper()->getSession();
        $session->set('client_id', $this->getHelper()->getUniqueId());
        return array(
            'secret'    => $session->get('client_id'),
        );
    }

    /**
     * @Route("/auth", name="GatotKacaErpMainBundle_Main_auth")
     **/
    public function authAction(){
        $request    = $this->getRequest();
        if(!($request->getMethod() == 'POST' && $request->isXmlHttpRequest())){
            return $this->goHome();
        }
        $session    = $this->getHelper()->getSession();
        if($request->get('client_id') != $session->get('client_id') || !$session->isValid()){
            return $this->goHome();
        }
        $response   = array(
            'success' => FALSE,
            'redirect' => $this->generateUrl('GatotKacaErpMainBundle_Main_index'),
        );
        $security   = $this->getSecurity();
        if($auth    = $security->authUser(strtoupper($request->get('username')), $request->get('password'))){//User terdaftar?
            $session->set('user_id', $auth['user_id']);
            $session->set('user_name', $auth['user_name']);
            $session->set('ERP_LOGGED_IN', TRUE);
            $session->set('group_id', $auth['group_id']);
            $session->set('group_name', $auth['group_name']);
            $response['success']    = TRUE;
            $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), 'LOGIN', $security->getModelLog());
        }else{
            $response['message']    = $security->getMessage();
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/logout", name = "GatotKacaErpMainBundle_Main_logout")
     **/
    public function logoutAction(){
        $session    = $this->getHelper()->getSession();
        if(!$session->get('ERP_LOGGED_IN') || !$session->isValid()){
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $security->setOnline($session->get('user_id'), FALSE);
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), 'LOGOUT', $security->getModelLog());
        $session->clear();
        if($request->isXmlHttpRequest()){
            return new JsonResponse(array('success' => TRUE));
        }else{
            return $this->goHome();
        }
    }
}