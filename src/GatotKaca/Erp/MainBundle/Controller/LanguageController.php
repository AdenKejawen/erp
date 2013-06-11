<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/LanguageController.php
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

class LanguageController extends AdminController{
	const MODULE	= 'panellanguage';
	/**
	 * @Route("/language", name="GatotKacaErpMainBundle_Language_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}
	
	/**
	 * @Route("/language/getbyid", name="GatotKacaErpMainBundle_Language_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), LanguageController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model	= $this->modelManager()->getLanguage();
		$language	= $model->getById($request->get('language_id'));
		if(count($language)){
			$output['data']	= $language;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/language/delete", name="GatotKacaErpMainBundle_Language_delete")
	 */
	public function deleteAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE, 'msg' => 'Authorization failed.');
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), LanguageController::MODULE, 'delete')){
			return new JsonResponse($output);
		}
		//Get model
		$model	= $this->modelManager()->getLanguage();
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
	 * @Route("/language/getlist", name="GatotKacaErpMainBundle_Language_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), LanguageController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword	= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		$status	= $request->get('status', TRUE);
		//Get model
		$model	= $this->modelManager()->getLanguage();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$language	= $model->getList($keyword, $start, $limit);
		if($total	= count($language)){
			$output['total']	= $model->countTotal($keyword, $limit);
			$output['data']	= $language;
		}else{
			$output['total']	= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/language/save", name="GatotKacaErpMainBundle_Language_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), LanguageController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input		= json_decode($request->get('language', ''));
		//Get model
		$model	= $this->modelManager()->getLanguage();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'Language has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Language has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
	
		return new JsonResponse($output);
	}
}