<?php
/**
 * @filenames: GatotKaca/Erp/Personal/Controller/OverTimeController.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\PersonalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class OverTimeController extends AdminController{
	const MODULE	= 'personalovertime';

	/**
	 * @Route("/personal/overtime/getlist", name="GatotKacaErpPersonalBundle_OverTime_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output		= array('success' => TRUE);
		$keyword	= strtoupper($request->get('query', ''));
		$status		= $request->get('status', TRUE);
		//Get model
		$model		= $this->modelManager()->getOverTime();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$overtime	= $model->getList($keyword, $request->get('from', ''), $request->get('to', ''), $request->get('supervise', 'FALSE'), $request->get('approve', 'all'));
		if($total	= count($overtime)){
			$output['total']	= $total;
			$output['data']	= $overtime;
		}else{
			$output['total']	= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/personal/overtime/save", name="GatotKacaErpPersonalBundle_OverTime_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input		= json_decode($request->get('overtime', ''));
		//Get model
		$model		= $this->modelManager()->getOverTime();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'Over time has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Over time has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
	
		return new JsonResponse($output);
	}

	/**
	 * @Route("/personal/overtime/getbyid", name="GatotKacaErpPersonalBundle_OverTime_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->modelManager()->getOverTime();
		$overtime	= $model->getBy('id', $request->get('overtime_id'), NULL, NULL, array(0, 1, 2));
		if(count($overtime)){
			$output['data']	= $overtime;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}