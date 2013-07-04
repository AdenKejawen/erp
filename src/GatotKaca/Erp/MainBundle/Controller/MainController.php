<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/BaseController.php
 * Author    : Muhammad Surya Ikhsanudin
 * License   : Protected
 * Email     : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Controller;

use GatotKaca\Erp\MainBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends BaseController
{
    /**
     * @Route("/", name="GatotKacaErpMainBundle_Main_index")
     * @Template()
     **/
    public function indexAction()
    {
        $session = $this->getHelper()->getSession();
        if (!$session->get('ERP_LOGGED_IN') || !$session->isValid()) {
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
        $attendance['START'] = new \DateTime($session->get('att_start_date').'-'.$session->get('att_start_month').'-'.date('Y'));
        $attendance['END']   = new \DateTime($session->get('att_end_date').'-'.$session->get('att_end_month').'-'.date('Y'));

        return array(
            'global'=> array(
                'GATOT_KACA_USER_ID'    => $session->get('user_id'),
                'GATOT_KACA_USER_NAME'  => $session->get('user_name'),
                'GATOT_KACA_GROUP_ID'   => $session->get('group_id'),
                'GATOT_KACA_GROUP_NAME' => $session->get('group_name'),
                'DATE_FORMAT'           => $session->get('date_format'),
                'DATE_FORMAT_TEXT'      => $session->get('date_format_text'),
                'THOUSAND_SEPARATOR'    => $session->get('thousand_separator'),
                'DECIMAL_SEPARATOR'     => $session->get('decimal_separator'),
                'DECIMAL_PRECISION'     => $session->get('decimal_precision'),
                'DASHBOARD_BACKGROUND'  => $session->get('dashboard_background'),
                'APPLICATION_NAME'      => $session->get('application_name'),
                'CLIENT_NAME'           => $session->get('client_name'),
                'FILTER_START'          => $attendance['START']->format($session->get('date_format')),
                'FILTER_END'            => $attendance['END']->format($session->get('date_format')),
            ),
        );
    }

    /**
     * @Route("/login", name="GatotKacaErpMainBundle_Main_login")
     * @Template()
     **/
    public function loginAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $response = new JsonResponse();
            $response->setStatusCode(500);

            return $response;
        }
        $session = $this->getHelper()->getSession();
        $session->set('client_id', $this->getHelper()->getUniqueId());
        $setting = $this->getModelManager()->getSetting();

        return array(
            'secret'           => $session->get('client_id'),
            'background'       => $setting->get('login_background'),
            'application_name' => $setting->get('application_name'),
            'client_name'      => $setting->get('client_name'),
        );
    }

    /**
     * @Route("/auth", name="GatotKacaErpMainBundle_Main_auth")
     **/
    public function authAction()
    {
        $request = $this->getRequest();
        if (!($request->getMethod() === 'POST' && $request->isXmlHttpRequest())) {
            return $this->goHome();
        }
        $session = $this->getHelper()->getSession();
        if ($request->get('client_id') != $session->get('client_id') || !$session->isValid()) {
            //return $this->goHome();
            return new JsonResponse($request);
        }
        $response = array(
            'success' => false,
            'redirect'=> $this->generateUrl('GatotKacaErpMainBundle_Main_index')
        );
        $security = $this->getSecurity();
        if ($auth = $security->authUser(strtoupper($request->get('username')), $request->get('password'))) {//User terdaftar?
            $setting = $this->getModelManager()->getSetting();
            $session->set('date_format', $setting->get('date_format'));
            $session->set('date_format_text', $setting->get('date_format_text'));
            $session->set('thousand_separator', $setting->get('thousand_separator'));
            $session->set('decimal_separator', $setting->get('decimal_separator'));
            $session->set('decimal_precision', $setting->get('decimal_precision'));
            $session->set('dashboard_background', $setting->get('dashboard_background'));
            $session->set('application_name', $setting->get('application_name'));
            $session->set('client_name', $setting->get('client_name'));
            $session->set('att_start_date', $setting->calculate($setting->getMathNotation('att_start_date')));
            $session->set('att_end_date', $setting->calculate($setting->getMathNotation('att_end_date')));
            $session->set('att_start_month', $setting->calculate($setting->getMathNotation('att_start_month')));
            $session->set('att_end_month', $setting->calculate($setting->getMathNotation('att_end_month')));
            $session->set('user_id', $auth['user_id']);
            $session->set('user_name', $auth['user_name']);
            $session->set('ERP_LOGGED_IN', true);
            $session->set('group_id', $auth['group_id']);
            $session->set('group_name', $auth['group_name']);
            $response['success']= true;
            $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), 'LOGIN', $security->getModelLog());
        } else {
            $response['message']= $security->getMessage();
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/logout", name = "GatotKacaErpMainBundle_Main_logout")
     **/
    public function logoutAction()
    {
        $session  = $this->getHelper()->getSession();
        if (!$session->get('ERP_LOGGED_IN') || !$session->isValid()) {
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
        $request  = $this->getRequest();
        $security = $this->getSecurity();
        $security->setOnline($session->get('user_id'), false);
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), 'LOGOUT', $security->getModelLog());
        $session->clear();
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array('success' => true));
        } else {
            return $this->goHome();
        }
    }
}
