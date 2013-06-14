<?php
/**
 * @filenames	: GatotKaca/Erp/MainBundle/Controller/EducationController.php
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

class EducationController extends AdminController{
	const MODULE= 'paneleducation';
	/**
	 * @Route("/education", name="GatotKacaErpMainBundle_Education_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}

	/**
	 * @Route("/education/getbyid", name="GatotKacaErpMainBundle_Education_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), EducationController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output		= array('success' => TRUE);
		//Get model
		$model		= $this->getModelManager()->getEducation();
		$education	= $model->getById($request->get('education_id'));
		if(count($education)){
			$output['data']	= $education;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/education/delete", name="GatotKacaErpMainBundle_Education_delete")
	 */
	public function deleteAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE, 'msg' => 'Authorization failed.');
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), EducationController::MODULE, 'delete')){
			return new JsonResponse($output);
		}
		//Get model
		$model	= $this->getModelManager()->getEducation();
		if($success	= $model->delete($request->get('id', ''))){
			$output['success']	= TRUE;
			$output['msg']		= 'Education has been delete.';
		}else{
			$output['msg']		= "Operation failed. ".$model->getMessage();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/education/getlist", name="GatotKacaErpMainBundle_Education_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), EducationController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		$status	= $request->get('status', TRUE);
		//Get model
		$model	= $this->getModelManager()->getEducation();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$education	= $model->getList($keyword, $start, $limit);
		if($total = count($education)){
			$output['total']= $model->countTotal($keyword, $limit);
			$output['data']	= $education;
		}else{
			$output['total']= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/education/save", name="GatotKacaErpMainBundle_Education_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), EducationController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input	= json_decode($request->get('education', ''));
		//Get model
		$model	= $this->getModelManager()->getEducation();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']		= 'Education has been saved.';
		}else{
			$output['msg']		= $model->getMessage().'. Education has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}