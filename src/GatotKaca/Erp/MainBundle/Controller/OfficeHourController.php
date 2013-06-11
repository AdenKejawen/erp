<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/OfficeHourController.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Helper\Csv\Reader AS CsvReader;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class OfficeHourController extends AdminController{
	const MODULE	= 'panelofficehour';
	
	/**
	 * @Route("/officehour", name="GatotKacaErpMainBundle_OfficeHour_index")
	 **/
	public function indexAction(){
		return $this->goHome();
	}
	
	/**
	 * @Route("/officehour/save", name="GatotKacaErpMainBundle_OfficeHour_save")
	 * 
	 * Save OfficeHour
	 **/
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OfficeHourController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$input		= json_decode($request->get('officehour'));
		//Get model
		$model		= $this->modelManager()->getOfficeHour();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'Office Hour has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Office Hour has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/officehour/getlist", name="GatotKacaErpMainBundle_OfficeHour_getList")
	 **/
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OfficeHourController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword	= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		$status		= $request->get('status', TRUE);
		//Get model
		$model		= $this->modelManager()->getOfficeHour();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$officeHour	= $model->getList($keyword, $start, $limit);
		if($total	= count($officeHour)){
			$output['total']	= $model->getTotal($keyword, $limit);
			$output['data']		= $officeHour;
		}else{
			$output['total']	= $total;
			$output['data']		= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/officehour/getbyid", name="GatotKacaErpMainBundle_OfficeHour_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OfficeHourController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output		= array('success' => TRUE);
		//Get model
		$model		= $this->modelManager()->getOfficeHour();
		$officeHour	= $model->getById($request->get('officehour_id'));
		if(count($officeHour)){
			$output['data']	= $officeHour;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/officehour/delete", name="GatotKacaErpMainBundle_OfficeHour_delete")
	 */
	public function deleteAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE, 'msg' => 'Authorization failed.');
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OfficeHourController::MODULE, 'delete')){
			return new JsonResponse($output);	
		}
		//Get model
		$model		= $this->modelManager()->getOfficeHour();
		if($success	= $model->delete($request->get('id', ''))){
			$output['success']	= TRUE;
			$output['msg']	= 'OfficeHour has been delete.';
		}else{
			$output['msg']	= "Operation failed. ".$model->getMessage();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}