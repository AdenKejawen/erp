<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/JobTitleController.php
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

class JobTitleController extends AdminController{
	const MODULE	= 'paneljobtitle';
	/**
	 * @Route("/jobtitle", name="GatotKacaErpMainBundle_JobTitle_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}
	
	/**
	 * @Route("/jobtitle/getbyid", name="GatotKacaErpMainBundle_JobTitle_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobTitleController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->modelManager()->getJobTitle();
		$jobtitle	= $model->getBy('id', $request->get('jobtitle_id'));
		if(count($jobtitle)){
			$output['data']	= $jobtitle;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/jobtitle/getbylevel", name="GatotKacaErpMainBundle_JobTitle_getByLevel")
	 */
	public function getByLevelAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobTitleController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->modelManager()->getJobTitle();
		$jobtitle	= $model->getBy('level', $request->get('level'));
		if(count($jobtitle)){
			$output['data']	= $jobtitle;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/jobtitle/delete", name="GatotKacaErpMainBundle_JobTitle_delete")
	 */
	public function deleteAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE, 'msg' => 'Authorization failed.');
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobTitleController::MODULE, 'delete')){
			return new JsonResponse($output);
		}
		//Get model
		$model		= $this->modelManager()->getJobTitle();
		if($success	= $model->delete($request->get('id', ''))){
			$output['success']	= TRUE;
			$output['msg']	= 'Job Title has been delete.';
		}else{
			$output['msg']	= "Operation failed. ".$model->getMessage();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/jobtitle/getlist", name="GatotKacaErpMainBundle_JobTitle_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobTitleController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword	= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		$status	= $request->get('status', TRUE);
		//Get model
		$model		= $this->modelManager()->getJobTitle();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$jobtitle	= $model->getList($keyword, $start, $limit);
		if($total	= count($jobtitle)){
			$output['total']	= $model->countTotal($keyword, $limit);
			$output['data']	= $jobtitle;
		}else{
			$output['total']	= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/jobtitle/save", name="GatotKacaErpMainBundle_JobTitle_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobTitleController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input		= json_decode($request->get('jobtitle', ''));
		//Get model
		$model		= $this->modelManager()->getJobTitle();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'Job Title has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Job Title has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
	
		return new JsonResponse($output);
	}
}