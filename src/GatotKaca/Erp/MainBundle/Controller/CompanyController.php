<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/CompanyController.php
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
use GatotKaca\Erp\MainBundle\Model\CompanyModel;

class CompanyController extends AdminController{
	const MODULE	= 'panelcompany';
	/**
	 * @Route("/company", name="GatotKacaErpMainBundle_Company_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}

	/**
	 * @Route("/company/getbyid", name="GatotKacaErpMainBundle_Company_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), CompanyController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->getModelManager()->getCompany();
		$company	= $model->getById($request->get('company_id'));
		if(count($company)){
			$output['data']	= $company;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/company/delete", name="GatotKacaErpMainBundle_Company_delete")
	 */
	public function deleteAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE, 'msg' => 'Authorization failed.');
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), CompanyController::MODULE, 'delete')){
			return new JsonResponse($output);
		}
		//Get model
		$model	= $this->getModelManager()->getCompany();
		if($success	= $model->delete($request->get('id', ''))){
			$output['success']	= TRUE;
			$output['msg']	= 'Company has been delete.';
		}else{
			$output['msg']	= "Operation failed. ".$model->getMessage();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/company/getlist", name="GatotKacaErpMainBundle_Company_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), CompanyController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword	= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		$status	= $request->get('status', TRUE);
		//Get model
		$model		= $this->getModelManager()->getCompany();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$company	= $model->getList($keyword, $start, $limit);
		if($total	= count($company)){
			$output['total']	= $model->countTotal($keyword, $limit);
			$output['data']	= $company;
		}else{
			$output['total']	= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/company/save", name="GatotKacaErpMainBundle_Company_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), CompanyController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input		= json_decode($request->get('company', ''));
		$division	= json_decode($request->get('division', ''));
		//Get model
		$model		= $this->getModelManager()->getCompany();
		if($success	= $model->save($input, $division)){
			$output['success']	= TRUE;
			$output['msg']	= 'Company has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Company has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}