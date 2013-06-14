<?php
/**
 * @filenames	: GatotKaca/Erp/MainBundle/Controller/DistrictController.php
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

class DistrictController extends AdminController{
	const MODULE= 'paneldistrict';
	/**
	 * @Route("/district", name="GatotKacaErpMainBundle_District_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}

	/**
	 * @Route("/district/getbyid", name="GatotKacaErpMainBundle_District_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), DistrictController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output		= array('success' => TRUE);
		//Get model
		$model		= $this->getModelManager()->getDistrict();
		$district	= $model->getBy('id', $request->get('district_id'));
		if($total = count($district)){
			$output['data']	= $district;
			$output['total']= $total;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/district/getbyprovince", name="GatotKacaErpMainBundle_District_getByProvince")
	 */
	public function getByProvinceAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), DistrictController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output		= array('success' => TRUE);
		//Get model
		$model		= $this->getModelManager()->getDistrict();
		$district	= $model->getBy('province', $request->get('province_id'));
		if($total	= count($district)){
			$output['data']	= $district;
			$output['total']= $total;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/district/getall", name="GatotKacaErpMainBundle_District_getAll")
	 */
	public function getAllAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array();
		$keyword	= strtoupper($request->get('query', ''));
		//Get model
		$model		= $this->getModelManager()->getDistrict();
		$district	= $model->getBy('name', $keyword, 'like');
		if($total = count($district)){
			$output['data']	= $district;
			$output['total']= $total;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/district/getlist", name="GatotKacaErpMainBundle_District_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), DistrictController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		//Get model
		$model		= $this->getModelManager()->getDistrict();
		$district	= $model->getList($keyword, $start, $limit);
		if($total = count($district)){
			$output['total']= $model->countTotal($keyword, $limit);
			$output['data']	= $district;
		}else{
			$output['total']= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/district/save", name="GatotKacaErpMainBundle_District_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), DistrictController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input	= json_decode($request->get('district', ''));
		//Get model
		$model	= $this->getModelManager()->getDistrict();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']		= 'District has been saved.';
		}else{
			$output['msg']		= $model->getMessage().'. District has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/district/delete", name="GatotKacaErpMainBundle_District_delete")
	 */
	public function deleteAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE, 'msg' => 'Authorization failed.');
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), DistrictController::MODULE, 'delete')){
			return new JsonResponse($output);
		}
		//Get model
		$model	= $this->getModelManager()->getDistrict();
		if($success	= $model->delete($request->get('id', ''))){
			$output['success']	= TRUE;
			$output['msg']		= 'District has been delete.';
		}else{
			$output['msg']		= "Operation failed. ".$model->getMessage();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}