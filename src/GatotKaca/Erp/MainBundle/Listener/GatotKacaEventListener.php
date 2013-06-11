<?php
namespace GatotKaca\Erp\MainBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GatotKacaEventListener{
    public function onKernelController(FilterControllerEvent $event){
    	$controller	= $event->getController();
    	$request	= $event->getRequest();
    	/*
         * $controller passed can be either a class or a Closure. This is not usual in Symfony2 but it may happen.
         * If it is a class, it comes in array format
         */
        if(!is_array($controller)){
            return;
        }
        $controller	= $controller[0];
        //Akhirnya bisa juga membuat hook untuk ngecek user, session dan request
        if(is_subclass_of($controller, 'GatotKaca\Erp\MainBundle\Controller\AdminController')){
        	$session	= $controller->getHelper()->getSession();
        	if(!($session->get('ERP_LOGGED_IN') && $session->isValid())){
        		throw new HttpException(307, NULL, NULL, array('Location' => $controller->generateUrl('GatotKacaErpMainBundle_Main_index')));
    		}
    		if($controller::IS_POST_REQUEST){
    			if($request->getMethod() !== 'POST'){
           			throw new HttpException(307, NULL, NULL, array('Location' => $controller->generateUrl('GatotKacaErpMainBundle_Main_index')));
            	}
    		}
    		if($controller::IS_XML_HTTP_REQUEST){
            	if(!$request->isXmlHttpRequest()){
           			throw new HttpException(307, NULL, NULL, array('Location' => $controller->generateUrl('GatotKacaErpMainBundle_Main_index')));
            	}
            }
        }
    }
}