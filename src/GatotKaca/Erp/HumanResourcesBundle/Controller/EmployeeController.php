<?php
/**
 * @filenames   : GatotKaca/Erp/HumanResources/Controller/EmployeeController.php
 * Author       : Muhammad Surya Ikhsanudin
 * License      : Protected
 * Email        : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\HumanResourcesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use GatotKaca\Erp\MainBundle\Controller\AdminController;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class EmployeeController extends AdminController
{
    const MODULE    = 'panelemployee';
    const SHIFTMENT = 'panelworkshift';
    const PERSONAL  = 'personalprofile';
    const CAREER    = 'panelcarier';
    const RESIGN    = 'panelresign';
    const IS_XML_HTTP_REQUEST   = false;

    /**
     * Get List Employee Helper
     *
     * @param  \GatotKaca\Erp\HumanResourcesBundle\Model\EmployeeModel $model
     * @param  string                                                  $keyword
     * @param  integer                                                 $start
     * @param  integer                                                 $limit
     * @param  boolean                                                 $status
     * @param  boolean                                                 $isfixed
     * @return array                                                   $output
     **/
    private function getList($keyword, $start, $limit, $status = true, $isfixed = true)
    {
        $output = array();
        $model  = $this->getModelManager()->getEmployee();
        $model->setStatus(($status === 'all') ? null : $status);
        $employee   = $model->getList($keyword, $start, $limit, $isfixed);
        if ($total = count($employee)) {
            $output['total']= $model->countTotal($keyword, $limit, $isfixed);
            $output['data'] = $employee;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }

        return $output;
    }

    /**
     * @Route("/human_resources/employee", name="GatotKacaErpHumanResourcesBundle_Employee_index")
     */
    public function indexAction()
    {
        return $this->goHome();
    }

    /**
     * @Route("/human_resources/employee/save", name="GatotKacaErpHumanResourcesBundle_Employee_save")
     */
    public function saveAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $upload     = $request->files->get('employee_profile');
        $path       = $this->get('kernel')->getRootDir().'/../web/photos';
        $input      = (object) $request->request->all();
        $name       = null;
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'modif')) {
            $output['msg']  = "You don't have authorize to do this action.";

            return new JsonResponse($output);
        }
        if ($_FILES['employee_profile']['name'] !== "") {
            if ($_FILES['employee_profile']['size'] === 0) {
                $output['msg']  = "Maximum image size is 2 MB.";

                return new Response(json_encode($output));
            }
            $name   = "{$input->employee_code}.{$upload->guessExtension()}";
            $source = $path.'/'.$name;
            //Not Allowed File
            $mimes  = array('image/png', 'image/jpeg');
            if (!in_array($upload->getMimeType(), $mimes)) {
                $output['msg']  = "Not allowed extension.";

                return new Response(json_encode($output));
            }
            //Do upload
            $upload->move($path, $name);
            $image  = new Imagine();
            $image->open($source)->resize(new Box(250, 275))->save($source);
        }
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->save($input, $name)) {
            $output['success']  = true;
            $output['msg']      = 'Employee has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Employee has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new Response(json_encode($output));
    }

    /**
     * @Route("/human_resources/employee/saveshiftment", name="GatotKacaErpHumanResourcesBundle_Employee_saveShiftment")
     */
    public function saveShiftmentAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::SHIFTMENT, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('shiftment'));
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->saveShiftment($input)) {
            $output['success']  = true;
            $output['msg']      = 'Shiftment has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Shiftment has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/saveeducation", name="GatotKacaErpHumanResourcesBundle_Employee_saveEducation")
     */
    public function saveEducationAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('education'));
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->saveEducation($input)) {
            $output['success']  = true;
            $output['msg']      = 'Education has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Education has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/savefamily", name="GatotKacaErpHumanResourcesBundle_Employee_saveFamily")
     */
    public function saveFamilyAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('family'));
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->saveFamily($input)) {
            $output['success']  = true;
            $output['msg']      = 'Family has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Family has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/saveexperience", name="GatotKacaErpHumanResourcesBundle_Employee_saveExperience")
     */
    public function saveExperienceAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('experience'));
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->saveExperience($input)) {
            $output['success']  = true;
            $output['msg']      = 'Experience has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Experience has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/savetraining", name="GatotKacaErpHumanResourcesBundle_Employee_saveTraining")
     */
    public function saveTrainingAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('training'));
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->saveTraining($input)) {
            $output['success']  = true;
            $output['msg']      = 'Training has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Training has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/savelanguage", name="GatotKacaErpHumanResourcesBundle_Employee_saveLanguage")
     */
    public function saveLanguageAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('language'));
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->saveLanguage($input)) {
            $output['success']  = true;
            $output['msg']      = 'Language has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Language has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/saveorganitation", name="GatotKacaErpHumanResourcesBundle_Employee_saveOrganitation")
     */
    public function saveOrganitationAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('organitation'));
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->saveOrganitation($input)) {
            $output['success']  = true;
            $output['msg']      = 'Organitation has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Organitation has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/savecareer", name="GatotKacaErpHumanResourcesBundle_Employee_saveCareer")
     */
    public function saveCareerAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::CAREER, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('career'));
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->saveCareer($input)) {
            $output['success']  = true;
            $output['msg']      = 'Career has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Career has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getbyid", name="GatotKacaErpHumanResourcesBundle_Employee_getById")
     */
    public function getByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getEmployee();
        $employee   = $model->getBy('id', $request->get('employee_id'));
        if (count($employee)) {
            $output['data'] = $employee;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/profile", name="GatotKacaErpHumanResourcesBundle_Employee_profile")
     */
    public function viewAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::PERSONAL, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        $profile= $model->getBy('username', $session->get('user_id'));
        if ($total = count($profile)) {
            $output['total']= $total;
            $output['data'] = $profile;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getbyjoblevel", name="GatotKacaErpHumanResourcesBundle_Employee_getByJobLevel")
     */
    public function getByJobLevelAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getEmployee();
        $employee   = $model->getByJobLevel($request->get('jobtitle_id'));
        if (count($employee)) {
            $output['data'] = $employee;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getlist", name="GatotKacaErpHumanResourcesBundle_Employee_getList")
     */
    public function getListAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        $keyword= strtoupper($request->get('query', ''));
        $start  = abs($request->get('start'));
        $limit  = abs($request->get('limit'));
        $status = $request->get('status', 'true');
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        $data   = $this->getList($keyword, $start, $limit, $status);
        $output = array_merge($output, $data);
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getshiftable", name="GatotKacaErpHumanResourcesBundle_Employee_getShiftable")
     */
    public function getShiftableAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::SHIFTMENT, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        $keyword= strtoupper($request->get('query', ''));
        $start  = abs($request->get('start'));
        $limit  = abs($request->get('limit'));
        $status = $request->get('status', 'true');
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        $data   = $this->getList($keyword, $start, $limit, $status, false);
        $output = array_merge($output, $data);
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getshiftment", name="GatotKacaErpHumanResourcesBundle_Employee_getShifment")
     */
    public function getShifmentAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::SHIFTMENT, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $start  = abs($request->get('start'));
        $limit  = abs($request->get('limit'));
        $model      = $this->getModelManager()->getEmployee();
        $shiftment  = $model->getShiftmentBy('employee', $request->get('employee_id', ''), $request->get('from', null), $request->get('to', null), $start, $limit);
        if (count($shiftment)) {
            $output['data'] = $shiftment;
            $output['total']= $model->countShiftmentBy('employee', $request->get('employee_id', ''), $request->get('from', null), $request->get('to', null));
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/geteducation", name="GatotKacaErpHumanResourcesBundle_Employee_getEducation")
     */
    public function getEducationAction()
    {
        $session  = $this->getHelper()->getSession();
        $request  = $this->getRequest();
        $security = $this->getSecurity();
        $output   = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output    = array('success' => true);
        //Get model
        $start     = abs($request->get('start'));
        $limit     = abs($request->get('limit'));
        $model     = $this->getModelManager()->getEmployee();
        $education = $model->getEducationBy('employee', $request->get('employee_id', ''), $start, $limit);
        if (count($education)) {
            $output['data'] = $education;
            $output['total']= $model->countEducationBy('employee', $request->get('employee_id', ''));
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getfamily", name="GatotKacaErpHumanResourcesBundle_Employee_getFamily")
     */
    public function getFamilyAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $start     = abs($request->get('start'));
        $limit     = abs($request->get('limit'));
        $model  = $this->getModelManager()->getEmployee();
        $family = $model->getFamilyBy('employee', $request->get('employee_id', ''), $start, $limit);
        if (count($family)) {
            $output['data'] = $family;
            $output['total']= $model->countFamilyBy('employee', $request->get('employee_id', ''));
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getexperience", name="GatotKacaErpHumanResourcesBundle_Employee_getExperience")
     */
    public function getExperienceAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $start     = abs($request->get('start'));
        $limit     = abs($request->get('limit'));
        $model  = $this->getModelManager()->getEmployee();
        $experience = $model->getExperienceBy('employee', $request->get('employee_id', ''), $start, $limit);
        if (count($experience)) {
            $output['data'] = $experience;
            $output['total']= $model->countExperienceBy('employee', $request->get('employee_id', ''));
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/gettraining", name="GatotKacaErpHumanResourcesBundle_Employee_getTraining")
     */
    public function getTrainingAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $start     = abs($request->get('start'));
        $limit     = abs($request->get('limit'));
        $model      = $this->getModelManager()->getEmployee();
        $training   = $model->getTrainingBy('employee', $request->get('employee_id', ''), $start, $limit);
        if (count($training)) {
            $output['data'] = $training;
            $output['total']= $model->countTrainingBy('employee', $request->get('employee_id', ''));
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getlanguage", name="GatotKacaErpHumanResourcesBundle_Employee_getLanguage")
     */
    public function getLanguageAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $start     = abs($request->get('start'));
        $limit     = abs($request->get('limit'));
        $model      = $this->getModelManager()->getEmployee();
        $language   = $model->getLanguageBy('employee', $request->get('employee_id', ''), $start, $limit);
        if (count($language)) {
            $output['data'] = $language;
            $output['total']= $model->countLanguageBy('employee', $request->get('employee_id', ''));
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getorganitation", name="GatotKacaErpHumanResourcesBundle_Employee_getOrganitation")
     */
    public function getOrganitationAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $start     = abs($request->get('start'));
        $limit     = abs($request->get('limit'));
        $model  = $this->getModelManager()->getEmployee();
        $organitation   = $model->getOrganitationBy('employee', $request->get('employee_id', ''), $start, $limit);
        if (count($organitation)) {
            $output['data'] = $organitation;
            $output['total']= $model->countOrganitationBy('employee', $request->get('employee_id', ''));
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getcareer", name="GatotKacaErpHumanResourcesBundle_Employee_getCareer")
     */
    public function getCareerAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::CAREER, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $start     = abs($request->get('start'));
        $limit     = abs($request->get('limit'));
        $model  = $this->getModelManager()->getEmployee();
        $career = $model->getCareerBy('employee', $request->get('employee_id', ''), $start, $limit);
        if (count($career)) {
            $output['data'] = $career;
            $output['total']= $model->countCareerBy('employee', $request->get('employee_id', ''));
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/geteducationbyid", name="GatotKacaErpHumanResourcesBundle_Employee_getEducationById")
     */
    public function getEducationByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getEmployee();
        $shiftment  = $model->getEducationBy('id', $request->get('education_id'));
        if (count($shiftment)) {
            $output['data'] = $shiftment;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getfamilybyid", name="GatotKacaErpHumanResourcesBundle_Employee_getFamilyById")
     */
    public function getFamilyByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        $family = $model->getFamilyBy('id', $request->get('family_id'));
        if (count($family)) {
            $output['data'] = $family;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getexperiencebyid", name="GatotKacaErpHumanResourcesBundle_Employee_getExperienceById")
     */
    public function getExperienceByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getEmployee();
        $experience = $model->getExperienceBy('id', $request->get('experience_id'));
        if (count($experience)) {
            $output['data'] = $experience;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/gettrainingbyid", name="GatotKacaErpHumanResourcesBundle_Employee_getTrainingById")
     */
    public function getTrainingByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getEmployee();
        $training   = $model->getTrainingBy('id', $request->get('training_id'));
        if (count($training)) {
            $output['data'] = $training;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getlanguagebyid", name="GatotKacaErpHumanResourcesBundle_Employee_getLanguageById")
     */
    public function getLanguageByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $model      = $this->getModelManager()->getEmployee();
        $language   = $model->getLanguageBy('id', $request->get('language_id'));
        if (count($language)) {
            $output['data'] = $language;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getorganitationbyid", name="GatotKacaErpHumanResourcesBundle_Employee_getOrganitationById")
     */
    public function getOrganitationByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        $organitation   = $model->getOrganitationBy('id', $request->get('organitation_id'));
        if (count($organitation)) {
            $output['data'] = $organitation;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/getcareerbyid", name="GatotKacaErpHumanResourcesBundle_Employee_getCareerById")
     */
    public function getCareerByIdAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::CAREER, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        $career   = $model->getCareerBy('id', $request->get('career_id'));
        if (count($career)) {
            $output['data'] = $career;
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/deleteexperience", name="GatotKacaErpHumanResourcesBundle_Employee_deleteExperience")
     */
    public function deleteExperienceAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->deleteExperience($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Experience has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/deletefamily", name="GatotKacaErpHumanResourcesBundle_Employee_deleteFamily")
     */
    public function deleteFamilyAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->deleteFamily($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Family has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/deletelanguage", name="GatotKacaErpHumanResourcesBundle_Employee_deleteLanguage")
     */
    public function deleteLanguageAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->deleteLanguage($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Language has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/deleteorganitation", name="GatotKacaErpHumanResourcesBundle_Employee_deleteOrganitation")
     */
    public function deleteOrganitationAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->deleteOrganitation($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Organitation has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/deleteeducation", name="GatotKacaErpHumanResourcesBundle_Employee_deleteEducation")
     */
    public function deleteEducationAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->deleteEducation($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Education has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/deletetraining", name="GatotKacaErpHumanResourcesBundle_Employee_deleteTraining")
     */
    public function deleteTrainingAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->deleteTraining($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Training has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/deletecareer", name="GatotKacaErpHumanResourcesBundle_Employee_deleteCareer")
     */
    public function deleteCareerAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->deleteCareer($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Career has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/deleteshiftment", name="GatotKacaErpHumanResourcesBundle_Employee_deleteShiftment")
     */
    public function deleteShiftmentAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false, 'msg' => 'Authorization failed.');
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'delete')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->deleteShiftment($request->get('id', ''))) {
            $output['success']  = true;
            $output['msg']      = 'Shiftment has been delete.';
        } else {
            $output['msg']      = "Operation failed. ".$model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/employee/resign", name="GatotKacaErpHumanResourcesBundle_Employee_resign")
     */
    public function resignAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::RESIGN, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('resign'));
        //Get model
        $model  = $this->getModelManager()->getEmployee();
        if ($success = $model->resign($input)) {
            $output['success']  = true;
            $output['msg']      = 'Resign data has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Resign data has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }
}
