<?php
/**
 * @filenames   : GatotKaca/Erp/MainBundle/Controller/ApiController.php
 * Author       : Muhammad Surya Ikhsanudin
 * License      : Protected
 * Email        : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\BaseController;

class ApiController extends BaseController
{
    /**
     * @Route("/api", name="GatotKacaErpMainBundle_Api_index")
     */
    public function indexAction()
    {
        return $this->goHome();
    }

    /**
     * @Route("/api/menu", name="GatotKacaErpMainBundle_Api_menu")
     **/
    public function menuAction()
    {
        $session  = $this->getHelper()->getSession();
        $request  = $this->getRequest();
        if (!$this->validRequest($request) || !$session->get('ERP_LOGGED_IN')) {
            return $this->goHome();
        }
        $security = $this->getSecurity();
        $output   = array();
        $menu     = array();
        $last     = true;
        //Dapetin menunya
        $parent   = $request->get('node');
        if ($parent !== 'root') {//Root ? Module : Menu
            $menu = $security->getMenu($parent, $session->get('group_id'));
        } else {
            $menu = $security->getModule($session->get('group_id'));
        }
        //Bikin treenya
        foreach ($menu as $val) {
            if (count($security->getMenu($val['id'], $session->get('group_id')))) {
                $last = false;
            }
            $output[] = array(
                'id'       => $val['id'],
                'text'     => $val['title'],
                'iconCls'  => $val['icon'],
                'selector' => $val['selector'],
                'cls'      => $val['cls'],
                'leaf'     => $last,
            );
            $last = true;
        }

        return new JsonResponse($output);
    }

    /**
     * @Route("/api/check_session", name="GatotKacaErpMainBundle_Api_checkSession")
     **/
    public function checkSessionAction()
    {
        $security = $this->getSecurity();
        $session  = $this->getHelper()->getSession();

        return new JsonResponse(array('success' => $security->checkSession($session->get('user_id'))));
    }

    /**
     * @Route("/api/getbirthday", name="GatotKacaErpMainBundle_Api_getBirthday")
     **/
    public function getBirthdayAction()
    {
        $session  = $this->getHelper()->getSession();
        $request  = $this->getRequest();
        if (!$this->validRequest($request) || !$session->get('ERP_LOGGED_IN')) {
            return $this->goHome();
        }
        $output['success'] = true;
        $model = $this->getModelManager()->getEmployee();
        $data  = $model->getEmployeeBirthday();
        $total = count($data);
        $output['total'] = $total;
        $output['data']  = $data;

        return new JsonResponse($output);
    }

    /**
     * @Route("/api/resigning", name="GatotKacaErpMainBundle_Api_resigning")
     **/
    public function resigningAction()
    {
        $session  = $this->getHelper()->getSession();
        $request  = $this->getRequest();
        if (!$this->validRequest($request) || !$session->get('ERP_LOGGED_IN')) {
            return $this->goHome();
        }
        $model = $this->getModelManager()->getEmployee();
        $output['success'] = $model->resigning();
        $this->getSecurity()->logging($request->getClientIp(), 'SYSTEM', $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/api/getid", name="GatotKacaErpMainBundle_Api_getId")
     **/
    public function getIdAction()
    {
        return new JsonResponse(array('id' => $this->getHelper()->getUniqueId()));
    }
}
