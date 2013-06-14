<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Controller/UserController.php
 * Author     : Muhammad Surya Ikhsanudin
 * License    : Protected
 * Email      : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\UtilitiesBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class UserController extends AdminController{
	const MODULE	= 'paneluser';

	/**
	 * @Route("/utilities/user", name="GatotKacaErpUtilitiesBundle_User_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}

	/**
	 * @Route("/utilities/user/getlist", name="GatotKacaErpUtilitiesBundle_User_getList")
	 */
	public function getListAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), UserController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output		= array('success' => TRUE);
		$keyword	= strtoupper($request->get('query', ''));
		$start		= abs($request->get('start'));
		$limit		= abs($request->get('limit'));
		$status		= $request->get('status', TRUE);
		//Get model
		$model	= $this->getModelManager()->getUser();
		$model->setStatus(($status === 'all') ? NULL : $status);
		$user	= $model->getList($keyword, $start, $limit);
		if($total	= count($user)){
			$output['total']	= $model->countTotal($keyword, $limit);
			$output['data']		= $user;
		}else{
			$output['total']	= $total;
			$output['data']		= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/utilities/user/getbyid", name="GatotKacaErpUtilitiesBundle_User_getById")
	 */
	public function getByIdAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), UserController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model	= $this->getModelManager()->getUser();
		$user	= $model->getById($request->get('user_id'), $request->get('table'));
		if(count($user)){
			$output['data']	= $user;
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/utilities/user/update", name="GatotKacaErpUtilitiesBundle_User_update")
	 */
	public function updateAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output		= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), UserController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		//Get model
		$model	= $this->getModelManager()->getUser();
		$input	= json_decode($request->get('user'));
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'User has been modified.';
		}else{
			$output['msg']	= $model->getMessage().'. User has not been modified.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}