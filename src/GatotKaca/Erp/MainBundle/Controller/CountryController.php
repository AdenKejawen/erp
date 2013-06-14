<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/CountryController.php
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

class CountryController extends AdminController{
	const MODULE	= 'panelcountry';
	/**
	 * @Route("/country", name="GatotKacaErpMainBundle_Country_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}

	/**
	 * @Route("/country/getall", name="GatotKacaErpMainBundle_Country_getAll")
	 */
	public function getAllAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), CountryController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output		= array('success' => TRUE);
		$keyword	= strtoupper($request->get('query', ''));
		//Get model
		$model		= $this->getModelManager()->getCountry();
		$country	= $model->getAll($keyword);
		if($total	= count($country)){
			$output['total']	= $total;
			$output['data']	= $country;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/country/getlist", name="GatotKacaErpMainBundle_Country_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), CountryController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		//Get model
		$model		= $this->getModelManager()->getCountry();
		$country	= $model->getList($keyword, $start, $limit);
		if($total	= count($country)){
			$output['total']	= $model->countTotal($keyword, $limit);
			$output['data']	= $country;
		}else{
			$output['total']	= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/country/getbyid", name="GatotKacaErpMainBundle_Country_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), CountryController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->getModelManager()->getCountry();
		$country	= $model->getBy('id', $request->get('country_id'));
		if(count($country)){
			$output['data']	= $country;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/country/save", name="GatotKacaErpMainBundle_Country_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), CountryController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input		= json_decode($request->get('country', ''));
		//Get model
		$model		= $this->getModelManager()->getCountry();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'Country has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Country has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/country/delete", name="GatotKacaErpMainBundle_Country_delete")
	 */
	public function deleteAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE, 'msg' => 'Authorization failed.');
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), CountryController::MODULE, 'delete')){
			return new JsonResponse($output);
		}
		//Get model
		$model	= $this->getModelManager()->getCountry();
		if($success	= $model->delete($request->get('id', ''))){
			$output['success']	= TRUE;
			$output['msg']	= 'Country has been delete.';
		}else{
			$output['msg']	= "Operation failed. ".$model->getMessage();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}