<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/ReligionController.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class ReligionController extends AdminController{
	/**
	 * @Route("/religion", name="GatotKacaErpMainBundle_Religion_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}
	
	/**
	 * @Route("/religion/getlist", name="GatotKacaErpMainBundle_Religion_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array();
		//Get model
		$model		= $this->modelManager()->getReligion();
		$religion	= $model->getList($request->get('country_id'));
		if($total	= count($religion)){
			$output	= $religion;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}