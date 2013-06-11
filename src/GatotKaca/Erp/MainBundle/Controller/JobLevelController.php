<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/JobLevelController.php
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

class JobLevelController extends AdminController{
	const MODULE	= 'paneljoblevel';
	/**
	 * @Route("/joblevel", name="GatotKacaErpMainBundle_JobLevel_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}
	
	/**
	 * @Route("/joblevel/getbyid", name="GatotKacaErpMainBundle_JobLevel_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobLevelController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->modelManager()->getJobLevel();
		$joblevel	= $model->getById($request->get('joblevel_id'));
		if(count($joblevel)){
			$output['data']	= $joblevel;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/joblevel/delete", name="GatotKacaErpMainBundle_JobLevel_delete")
	 */
	public function deleteAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE, 'msg' => 'Authorization failed.');
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobLevelController::MODULE, 'delete')){
			return new JsonResponse($output);
		}
		//Get model
		$model		= $this->modelManager()->getJobLevel();
		if($success	= $model->delete($request->get('id', ''))){
			$output['success']	= TRUE;
			$output['msg']	= 'Job Level has been delete.';
		}else{
			$output['msg']	= "Operation failed. ".$model->getMessage();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/joblevel/getlist", name="GatotKacaErpMainBundle_JobLevel_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobLevelController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		$status	= $request->get('status', TRUE);
		//Get model
		$model		= $this->modelManager()->getJobLevel();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$joblevel	= $model->getList($keyword, $start, $limit);
		if($total	= count($joblevel)){
			$output['total']	= $model->countTotal($keyword, $limit);
			$output['data']	= $joblevel;
		}else{
			$output['total']	= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/joblevel/save", name="GatotKacaErpMainBundle_JobLevel_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), JobLevelController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input		= json_decode($request->get('joblevel', ''));
		//Get model
		$model		= $this->modelManager()->getJobLevel();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'Job Level has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Job Level has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
	
		return new JsonResponse($output);
	}
}