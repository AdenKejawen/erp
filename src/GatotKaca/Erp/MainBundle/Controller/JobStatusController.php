<?php
/**
 * @filenames	: GatotKaca/Erp/MainBundle/Controller/JobStatusController.php
 * Author		: Muhammad Surya Ikhsanudin
 * License		: Protected
 * Email		: mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class JobStatusController extends AdminController{
	const MODULE= 'paneljobstatus';
	/**
	 * @Route("/jobstatus", name="GatotKacaErpMainBundle_JobStatus_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}

	/**
	 * @Route("/jobstatus/getbyid", name="GatotKacaErpMainBundle_JobStatus_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobStatusController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output		= array('success' => TRUE);
		//Get model
		$model		= $this->getModelManager()->getJobStatus();
		$jobstatus	= $model->getById($request->get('jobstatus_id'));
		if(count($jobstatus)){
			$output['data']	= $jobstatus;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/jobstatus/delete", name="GatotKacaErpMainBundle_JobStatus_delete")
	 */
	public function deleteAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE, 'msg' => 'Authorization failed.');
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobStatusController::MODULE, 'delete')){
			return new JsonResponse($output);
		}
		//Get model
		$model	= $this->getModelManager()->getJobStatus();
		if($success	= $model->delete($request->get('id', ''))){
			$output['success']	= TRUE;
			$output['msg']		= 'Job Status has been delete.';
		}else{
			$output['msg']		= "Operation failed. ".$model->getMessage();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/jobstatus/getlist", name="GatotKacaErpMainBundle_JobStatus_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobStatusController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		$status	= $request->get('status', TRUE);
		//Get model
		$model	= $this->getModelManager()->getJobStatus();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$jobstatus	= $model->getList($keyword, $start, $limit);
		if($total = count($jobstatus)){
			$output['total']= $model->countTotal($keyword, $limit);
			$output['data']	= $jobstatus;
		}else{
			$output['total']= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/jobstatus/save", name="GatotKacaErpMainBundle_JobStatus_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobStatusController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input	= json_decode($request->get('jobstatus', ''));
		//Get model
		$model	= $this->getModelManager()->getJobStatus();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']		= 'Job Status has been saved.';
		}else{
			$output['msg']		= $model->getMessage().'. Job Status has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}