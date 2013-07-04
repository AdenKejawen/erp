<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/ReligionController.php
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

class ReligionController extends AdminController
{
    const MODULE= 'panelreligion';
    /**
     * @Route("/jobstatus", name="GatotKacaErpMainBundle_Religion_index")
     */
    public function indexAction()
    {
        return $this->goHome();
    }

    /**
     * @Route("/religion/getlist", name="GatotKacaErpMainBundle_Religion_getList")
     */
    public function getListAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), ReligionController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        $keyword    = strtoupper($request->get('query', ''));
        $start      = abs($request->get('start'));
        $limit      = abs($request->get('limit'));
        //Get model
        $model      = $this->getModelManager()->getReligion();
        $jobstatus  = $model->getList($keyword, $start, $limit);
        if ($total = count($jobstatus)) {
            $output['total']= $model->countTotal($keyword, $limit);
            $output['data'] = $jobstatus;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/religion/getbyid", name="GatotKacaErpMainBundle_Religion_getById")
     */
    public function getByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), ReligionController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getReligion();
        $religion   = $model->getById($request->get('religion_id'));
        if (count($religion)) {
            $output['data'] = $religion;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/religion/save", name="GatotKacaErpMainBundle_Religion_save")
     */
    public function saveAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), ReligionController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('religion', ''));
        //Get model
        $model  = $this->getModelManager()->getReligion();
        if ($success    = $model->save($input)) {
            $output['success']  = true;
            $output['msg']      = 'Religion has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Religion has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/religion/delete", name="GatotKacaErpMainBundle_Religion_delete")
     */
    public function deleteAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), ReligionController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getReligion();
        if ($success    = $model->delete($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Religion has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }
}
