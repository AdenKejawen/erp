<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Controller/ModuleController.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\UtilitiesBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class ModuleController extends AdminController{
	const MODULE	= 'paneluser';
	
	/**
	 * @Route("/utilities/module", name="GatotKacaErpUtilitiesBundle_Module_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}
	
	/**
	 * @Route("/utilities/module/getlist", name="GatotKacaErpUtilitiesBundle_Module_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), ModuleController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output		= array('success' => TRUE);
		$keyword	= strtoupper($request->get('query', ''));
		($keyword == '') ? $keyword	= strtoupper($request->get('query', '')) : $keyword;
		$start		= abs($request->get('start'));
		$limit		= abs($request->get('limit'));
		$status		= $request->get('status', TRUE);
		//Get model
		$model	= $this->modelManager()->getModule();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$module	= $model->getList($keyword, $start, $limit);
		if($total	= count($module)){
			$output['total']	= $model->countTotal($keyword, $limit);
			$output['data']		= $module;
		}else{
			$output['total']	= $total;
			$output['data']		= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/utilities/module/getbyid", name="GatotKacaErpUtilitiesBundle_Module_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), ModuleController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model	= $this->modelManager()->getModule();
		$module	= $model->getById($request->get('module_id'));
		if(count($module)){
			$output['data']	= $module;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/utilities/module/save", name="GatotKacaErpMainBundle_Module_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), ModuleController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input	= json_decode($request->get('module'));
		//Get model
		$model	= $this->modelManager()->getModule();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'Module has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Module has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}