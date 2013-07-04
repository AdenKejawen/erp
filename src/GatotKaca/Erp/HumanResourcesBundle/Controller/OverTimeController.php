<?php
/**
 * @filenames   : GatotKaca/Erp/HumanResourcesBundle/Controller/OverTimeController.php
 * Author       : Muhammad Surya Ikhsanudin
 * License      : Protected
 * Email        : mutofiyah@gmail.com
 *
 * Dilarang merubah, mengganti dan mendistribusikan
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\HumanResourcesBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;
use PHPExcel_Style_Alignment;

class OverTimeController extends AdminController
{
    const MODULE    = 'panelovertimebyemployee';
    const BYDATE    = 'panelovertimebydate';
    const PERSONAL  = 'personalovertime';
    const IS_POST_REQUEST       = false;
    const IS_XML_HTTP_REQUEST   = false;

    /**
     * Export Helper
     **/
    private function exportHelper($employeeId, $from, $to)
    {
        $data   = $this->modelHelper($employeeId, $from, $to);
        //Get content from template
        return $this->renderView(
            'GatotKacaErpHumanResourcesBundle:OverTime:print.html.twig',
            array(
                'overtime'  => $data['overtime'],
                'employee'  => $data['employee'],
                'from'      => $from,
                'to'        => $to
            )
        );
    }

    /**
     * Model Helper
     **/
    private function modelHelper($employeeId, $from, $to)
    {
        $model      = $this->getModelManager()->getOverTime();
        $overtime   = $model->getBy('employee', $employeeId, $from, $to, array(1));
        $employee   = $this->getModelManager()->getEmployee()->getBy('id', $employeeId);
        $this->getSecurity()->logging($this->getRequest()->getClientIp(), $this->getHelper()->getSession()->get('user_id'), $this->getRequest()->get('_route'), $model->getAction(), $model->getModelLog());

        return array(
            'overtime'  => $overtime,
            'employee'  => $employee
        );
    }

    /**
     * @Route("/human_resources/overtime/getlist", name="GatotKacaErpHumanResourcesBundle_OverTime_getList")
     */
    public function getListAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), OverTimeController::PERSONAL, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        $status     = $request->get('status', 'true');
        //Get model
        $session->set('from', $request->get('from', $session->get('from')));
        $session->set('to', $request->get('to', $session->get('to')));
        $start      = abs($request->get('start'));
        $limit      = abs($request->get('limit'));
        $from       = $session->get('from');
        $to         = $session->get('to');
        $model      = $this->getModelManager()->getOverTime();
        $overtime   = $model->getList($from, $to, $request->get('supervise', 'false'), $request->get('approve', 'all'), $start, $limit);
        if ($total   = count($overtime)) {
            $output['total']= $model->countList($from, $to, $request->get('supervise', 'false'), $request->get('approve', 'all'));
            $output['data'] = $overtime;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/overtime/getbyemployee", name="GatotKacaErpHumanResourcesBundle_OverTime_getByEmployee")
     *
     * Get Over Time List by Employee
     **/
    public function getByEmployeeAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        //Don't have access
        if (!$this->validRequest($request)) {
            return $this->goHome();
        }
        $output     = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output     = array('success' => true);
        //Get model
        $session->set('from', $request->get('from', $session->get('from')));
        $session->set('to', $request->get('to', $session->get('to')));
        $start      = abs($request->get('start'));
        $limit      = abs($request->get('limit'));
        $from       = $session->get('from');
        $to         = $session->get('to');
        $model      = $this->getModelManager()->getOverTime();
        $overtime   = $model->getBy('employee', $request->get('employee_id', ''), $from, $to, array(1), $start, $limit);
        if ($total = count($overtime)) {
            $output['total'] = $model->countBy('employee', $request->get('employee_id', ''), $from, $to, array(1));
            $output['data']  = $overtime;
        } else {
            $output['total'] = $total;
            $output['data']  = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/overtime/getbydate", name="GatotKacaErpHumanResourcesBundle_OverTime_getByDate")
     *
     * Get Today OverTime
     **/
    public function getByDateAction()
    {
        $session  = $this->getHelper()->getSession();
        $request  = $this->getRequest();
        $security = $this->getSecurity();
        //Don't have access
        if (!$this->validRequest($request)) {
            return $this->goHome();
        }
        $output   = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), OverTimeController::BYDATE, 'view')) {
            return new JsonResponse($output);
        }
        $session->set('from', $request->get('from', $session->get('from')));
        $session->set('to', $request->get('to', $session->get('to')));
        $output   = array('success' => true);
        $from     = $session->get('from');
        $to       = $session->get('to');
        $start    = abs($request->get('start'));
        $limit    = abs($request->get('limit'));
        //Get model
        $model    = $this->getModelManager()->getOverTime();
        $overtime = $model->getByDate($from, $to, $start, $limit);
        if ($total = count($overtime)) {
            $output['total'] = $model->countByDate($from, $to);
            $output['data']  = $overtime;
        } else {
            $output['total'] = $total;
            $output['data']  = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/overtime/viewdetail", name="GatotKacaErpHumanResourcesBundle_OverTime_getDetail")
     *
     * Get Over Time Detail
     **/
    public function getDetailAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        //Don't have access
        if (!$this->validRequest($request)) {
            return $this->goHome();
        }
        $output     = array('success' => false);
        //Don't have authorization
        if (!($security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view') || $security->isAllowed($session->get('group_id'), OverTimeController::PERSONAL, 'view'))) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $model  = $this->getModelManager()->getOverTime();
        $data   = $model->getBy('id', $request->get('ot_id'), null, null, array(0, 1, 2));
        if ($total = count($aData)) {
            $output['total']= $total;
            $output['data'] = $data;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/overtime/save", name="GatotKacaErpHumanResourcesBundle_OverTime_save")
     */
    public function saveAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $output     = array('success' => false);
        //Don't have authorization
        if (!($security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'modif') || $security->isAllowed($session->get('group_id'), OverTimeController::PERSONAL, 'modif'))) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('overtime', ''));
        //Get model
        $model  = $this->getModelManager()->getOverTime();
        if ($success = $model->save($input)) {
            $output['success']  = true;
            $output['msg']      = 'Over time has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Over time has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/overtime/preview", name="GatotKacaErpHumanResourcesBundle_OverTime_preview")
     *
     * Print Over Time by Employee
     **/
    public function previewAction()
    {
        $session  = $this->getHelper()->getSession();
        $request  = $this->getRequest();
        $security = $this->getSecurity();
        //Don't have access
        if (!$this->validRequest($request)) {
            return $this->goHome();
        }
        $output   = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        $eSess  = $this->getModelManager()->getEmployee()->getBy('username', $session->get('user_id'));
        $id     = $request->get('employee_id', $eSess[0]['employee_id']);
        $from   = new \DateTime($request->get('from', ''));
        $to     = new \DateTime($request->get('to', ''));
        $output['data'] = $this->exportHelper($id, $from->format($session->get('date_format')), $to->format($session->get('date_format')));

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/overtime/export/jpg/{from}/{to}/{id}", name="GatotKacaErpHumanResourcesBundle_OverTime_exportJpg", defaults={"id" = null})
     *
     * Print OverTime by Employee
     **/
    public function exportJpgAction($from, $to, $id)
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        if (!$session->get('ERP_LOGGED_IN') || !$session->isValid()) {
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $eSess  = $this->getModelManager()->getEmployee()->getBy('username', $session->get('user_id'));
        $id     = $id === null ? $eSess[0]['employee_id'] : $id;
        $from   = new \DateTime($from);
        $to     = new \DateTime($to);

        return new Response(
            $this->getJpgGenerator()->getOutputFromHtml($this->exportHelper($id, $from->format($session->get('date_format')), $to->format($session->get('date_format')))),
            200,
            array(
                'Content-Type'          => 'application/jpg',
                'Content-Disposition'   => 'attachment; filename = "'.$id.$from->format($session->get('date_format')).$to->format($session->get('date_format')).'.jpg"'
            )
        );
    }

    /**
     * @Route("/human_resources/overtime/export/pdf/{from}/{to}/{id}", name="GatotKacaErpHumanResourcesBundle_OverTime_exportPdf", defaults={"id" = null})
     *
     * Print OverTime by Employee
     **/
    public function exportPdfAction($from, $to, $id)
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        if (!$session->get('ERP_LOGGED_IN') || !$session->isValid()) {
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $eSess  = $this->getModelManager()->getEmployee()->getBy('username', $session->get('user_id'));
        $id     = $id === null ? $eSess[0]['employee_id'] : $id;
        $from   = new \DateTime($from);
        $to     = new \DateTime($to);
        $data   = $this->modelHelper($id, $from->format($session->get('date_format')), $to->format($session->get('date_format')));
        $pdf    = $this->getPdfGenerator();
        $this->setSigniture($pdf);
        $partition  = 17;
        $kolom      = $this->getPerPartition($partition);
        $pdf->setFont('Arial', 'B', 13);
        $pdf->Cell($kolom * $partition, 7, "OVERTIME REPORT", 0, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * $partition, 7, "Period : {$from->format($session->get('date_format'))} - {$to->format($session->get('date_format'))}", 0, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Ln(17);
        $pdf->setFont('Arial', '', 10);
        $pdf->Cell($kolom * 3, 7, 'Fullname', 0, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom, 7, ':', 0, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 13, 7, $data['employee'][0]['employee_fname'].' '.$data['employee'][0]['employee_lname'], 0, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Ln();
        $pdf->Cell($kolom * 3, 7, 'Company', 0, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom, 7, ':', 0, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 13, 7, $data['employee'][0]['employee_companyname'], 0, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Ln();
        $pdf->Cell($kolom * 3, 7, 'Department', 0, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom, 7, ':', 0, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 13, 7, $data['employee'][0]['employee_departmentname'], 0, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Ln(11);
        $pdf->setFont('Arial', 'B', 9);
        $pdf->Cell($kolom * 2, 7, 'Day', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 3, 7, 'Date', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, 'In', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, 'Out', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, 'Total', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 6, 7, 'Approved By', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Ln();
        $pdf->setFont('Arial', '', 9);
        $total  = 0;
        foreach ($data['overtime'] as $key => $val) {
            $pdf->Cell($kolom * 2, 7, $val['ot_day'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 3, 7, $val['ot_date'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 2, 7, $val['ot_start'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 2, 7, $val['ot_end'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 2, 7, $val['ot_real'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 6, 7, $val['ot_approvedby'], 1, false, 'L', 0, '', 0, false, 'C', 'C');
            $pdf->Ln();
            $total  += $val['ot_real'];
        }
        $pdf->setFont('Arial', 'B', 9);
        $pdf->Cell($kolom * 9, 7, 'Total', 1, false, 'R', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 8, 7, $total, 1, false, 'L', 0, '', 0, false, 'C', 'C');
        $pdf->Output($id.$from->format($session->get('date_format')).$to->format($session->get('date_format')).'.pdf', 'D');
    }

    /**
     * @Route("/human_resources/overtime/export/excel/{from}/{to}/{id}", name="GatotKacaErpHumanResourcesBundle_OverTime_exportExcel", defaults={"id" = null})
     *
     * Print OverTime by Employee
     **/
    public function exportExcelAction($from, $to, $id)
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        if (!$session->get('ERP_LOGGED_IN') || !$session->isValid()) {
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $eSess  = $this->getModelManager()->getEmployee()->getBy('username', $session->get('user_id'));
        $id     = $id === null ? $eSess[0]['employee_id'] : $id;
        $from   = new \DateTime($from);
        $to     = new \DateTime($to);
        $data   = $this->modelHelper($id, $from->format($session->get('date_format')), $to->format($session->get('date_format')));
        //Get Excel Instance
        $start  = 1;
        $excel  = $this->getExcelWriter();
        $this->setSigniture($excel);
        $excel->getDefaultStyle()
            ->getAlignment()
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //Writing excel
        $worksheet  = $excel->setActiveSheetIndex(0);
        $worksheet->getStyle('A'.$start.':A'.($start + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setTitle('OverTime Report')
            ->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);
        $worksheet->mergeCells('A'.$start.':F'.$start)
            ->setCellValue('A'.$start++, "OVERTIME REPORT")
            ->mergeCells('A'.$start.':F'.$start)
            ->setCellValue('A'.$start++, "Period : {$from->format($session->get('date_format'))} - {$to->format($session->get('date_format'))}")
            ->setCellValue('A'.$start += 2, 'Fullname')
            ->mergeCells('B'.$start.':D'.$start)
            ->setCellValue('B'.$start++, $data['employee'][0]['employee_fname'].' '.$data['employee'][0]['employee_lname'])
            ->mergeCells('B'.$start.':D'.$start)
            ->setCellValue('A'.$start, 'Company')
            ->setCellValue('B'.$start++, $data['employee'][0]['employee_companyname'])
            ->mergeCells('B'.$start.':D'.$start)
            ->setCellValue('A'.$start, 'Department')
            ->setCellValue('B'.$start++, $data['employee'][0]['employee_departmentname'])
            ->setCellValue('A'.++$start, 'Day')
            ->setCellValue('B'.$start, 'Date')
            ->setCellValue('C'.$start, 'In')
            ->setCellValue('D'.$start, 'Out')
            ->setCellValue('E'.$start, 'Total')
            ->setCellValue('F'.$start, 'Approved By');
        $header = $worksheet->getStyle('A'.$start.':F'.$start);
        $header->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $header->getFont()->setBold(true);
        $start++;
        $indent = $start;
        foreach ($data['overtime'] as $key => $val) {
            $worksheet->setCellValue('A'.$start, $val['ot_day'])
                ->setCellValue('B'.$start, $val['ot_date'])
                ->setCellValue('C'.$start, $val['ot_start'])
                ->setCellValue('D'.$start, $val['ot_end'])
                ->setCellValue('E'.$start, $val['ot_real'])
                ->setCellValue('F'.$start, $val['ot_approvedby']);
            $worksheet->getStyle('E'.$start.':D'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $start++;
        }
        $worksheet->mergeCells('A'.$start.':D'.$start)->setCellValue('A'.$start, 'Total');
        $worksheet->getStyle('A'.$start.':D'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->getStyle('A'.$start.':F'.$start)->getFont()->setBold(true);
        if ($indent !== $start) {
            $worksheet->setCellValue('E'.$start, '=SUM(E'.$indent.':E'.--$start.')');
        } else {
            $worksheet->setCellValue('E'.$start, '0');
        }
        //Force download
        $response   = new Response();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment; filename = "'.$id.$from->format($session->get('date_format')).$to->format($session->get('date_format')).'.xls"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $response->prepare($request);
        $response->sendHeaders();
        $this->generateExcel($excel, 'Excel5');
    }
}
