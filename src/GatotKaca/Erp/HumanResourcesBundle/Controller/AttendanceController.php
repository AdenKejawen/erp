<?php
/**
 * @filenames   : GatotKaca/Erp/HumanResourcesBundle/Controller/AttendanceController.php
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
use PHPExcel_Cell;
use PHPExcel_Style_Alignment;

class AttendanceController extends AdminController
{
    const MODULE    = 'panelattendancebyemployee';
    const BYDATE    = 'panelattendancebydate';
    const PERSONAL  = 'personalattendance';
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
            'GatotKacaErpHumanResourcesBundle:Attendance:print.html.twig',
            array(
                'attendance'=> $data['attendance'],
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
        $model      = $this->getModelManager()->getAttendance();
        $attendance = $model->getBy('employee', $employeeId, $from, $to);
        $employee   = $this->getModelManager()->getEmployee()->getBy('id', $employeeId);
        $this->getSecurity()->logging($this->getRequest()->getClientIp(), $this->getHelper()->getSession()->get('user_id'), $this->getRequest()->get('_route'), $model->getAction(), $model->getModelLog());

        return array(
            'attendance'=> $attendance,
            'employee'  => $employee
        );
    }

    /**
     * Menghitung terlambat dan loyal
     * @param  int $late  in second
     * @param  int $loyal in second
     * @return int
     **/
    private function lateLoyal($late, $loyal)
    {
        $hLate  = floor($late / (60 * 60));
        $mLate  = floor(($late % (60 * 60)) / 60);
        $sLate  = $late - ($hLate * 60 * 60) - ($mLate * 60);
        $hLoyal = floor($loyal / (60 * 60));
        $mLoyal = floor(($loyal % (60 * 60)) / 60);
        $sLoyal = $loyal - ($hLoyal * 60 * 60) - ($mLoyal * 60);
        $hLate  = ((int) $hLate < 10) ? '0'.$hLate : $hLate;
        $mLate  = ((int) $mLate < 10) ? '0'.$mLate : $mLate;
        $sLate  = ((int) $sLate < 10) ? '0'.$sLate : $sLate;
        $hLoyal = ((int) $hLoyal < 10) ? '0'.$hLoyal : $hLoyal;
        $mLoyal = ((int) $mLoyal < 10) ? '0'.$mLoyal : $mLoyal;
        $sLoyal = ((int) $sLoyal < 10) ? '0'.$sLoyal : $sLoyal;

        return array('late' => $hLate.':'.$mLate.':'.$sLate, 'loyal' => $hLoyal.':'.$mLoyal.':'.$sLoyal);
    }

    /**
     * @Route("/human_resources/attendance", name="GatotKacaErpHumanResourcesBundle_Attendance_index")
     **/
    public function indexAction()
    {
        return $this->goHome();
    }

    /**
     * @Route("/human_resources/attendance/save", name="GatotKacaErpHumanResourcesBundle_Attendance_save")
     */
    public function saveAction()
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
        if (!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $input  = json_decode($request->get('attendance'));
        //Get model
        $model  = $this->getModelManager()->getAttendance();
        if ($success = $model->save($input)) {
            $output['success']  = true;
            $output['msg']      = 'Attendance has been saved.';
        } else {
            $output['msg']      = $model->getMessage().'. Attendance has not been saved.';
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/attendance/getbyemployee", name="GatotKacaErpHumanResourcesBundle_Attendance_getByEmployee")
     *
     * Get Attendance List by Employee
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
        if (!($security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view') || $security->isAllowed($session->get('group_id'), AttendanceController::PERSONAL, 'view'))) {
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
        $eSess      = $this->getModelManager()->getEmployee()->getBy('username', $session->get('user_id'));
        $model      = $this->getModelManager()->getAttendance();
        $attendance = $model->getBy('employee', $request->get('employee_id', $eSess[0]['employee_id']), $from, $to, $start, $limit);
        if ($total = count($attendance)) {
            $output['total']= $model->countBy('employee', $request->get('employee_id', $eSess[0]['employee_id']), $from, $to);
            $output['data'] = $attendance;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/attendance/getbydate", name="GatotKacaErpHumanResourcesBundle_Attendance_getByDate")
     *
     * Get Today Attendance
     **/
    public function getByDateAction()
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
        if (!$security->isAllowed($session->get('group_id'), AttendanceController::BYDATE, 'view')) {
            return new JsonResponse($output);
        }
        $session->set('from', $request->get('from', $session->get('from')));
        $session->set('to', $request->get('to', $session->get('to')));
        $output     = array('success' => true);
        $from       = $session->get('from');
        $to         = $session->get('to');
        $start      = abs($request->get('start'));
        $limit      = abs($request->get('limit'));
        $absence    = $request->get('absence', 'true');
        //Get model
        $model      = $this->getModelManager()->getAttendance();
        $attendance = $model->getByDate($from, $to, $absence, $start, $limit);
        if ($total = count($attendance)) {
            $output['total'] = $model->countByDate($from, $to, $absence);
            $output['data']  = $attendance;
        } else {
            $output['total'] = $total;
            $output['data']  = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/attendance/preview", name="GatotKacaErpHumanResourcesBundle_Attendance_preview")
     *
     * Print Attendance by Employee
     **/
    public function previewAction()
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
        if (!($security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view') || $security->isAllowed($session->get('group_id'), AttendanceController::PERSONAL, 'view'))) {
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
     * @Route("/human_resources/attendance/export/jpg/{from}/{to}/{id}", name="GatotKacaErpHumanResourcesBundle_Attendance_exportJpg", defaults={"id" = null})
     *
     * Print Attendance by Employee
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
        if (!($security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view') || $security->isAllowed($session->get('group_id'), AttendanceController::PERSONAL, 'view'))) {
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
     * @Route("/human_resources/attendance/export/pdf/{from}/{to}/{id}", name="GatotKacaErpHumanResourcesBundle_Attendance_exportPdf", defaults={"id" = null})
     *
     * Print Attendance by Employee
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
        if (!($security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view') || $security->isAllowed($session->get('group_id'), AttendanceController::PERSONAL, 'view'))) {
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
        $pdf->Cell($kolom * $partition, 7, "ATTENDANCE REPORT", 0, false, 'C', 0, '', 0, false, 'C', 'C');
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
        $pdf->Cell($kolom, 7, 'Day', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, 'Date', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, 'Time In', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, 'Time Out', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, 'Late', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, 'Loyal', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, 'Reason', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 4, 7, 'Description', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Ln();
        $totalLate  = 0;
        $totalLoyal = 0;
        foreach ($data['attendance'] as $key => $val) {
            $pdf->setFont('Arial', '', 9);
            $pdf->Cell($kolom, 7, $val['att_day'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 2, 7, $val['att_date'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 2, 7, $val['att_in'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 2, 7, $val['att_out'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 2, 7, $val['att_late'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 2, 7, $val['att_loyal'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->Cell($kolom * 2, 7, $val['miss'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
            $pdf->setFont('Arial', '', 8);
            $pdf->Cell($kolom * 4, 7, $val['description'], 1, false, 'L', 0, '', 0, false, 'C', 'C');
            $pdf->Ln();
            $late   = explode(':', $val['att_late']);
            $hLate  = $late[0] * 60 * 60;
            $mLate  = $late[1] * 60;
            $sLate  = $late[2];
            $totalLate += $hLate + $mLate + $sLate;
            $loyal  = explode(':', $val['att_loyal']);
            $hLoyal = $loyal[0] * 60 * 60;
            $mLoyal = $loyal[1] * 60;
            $sLoyal = $loyal[2];
            $totalLoyal += $hLoyal + $mLoyal + $sLoyal;
        }
        $total = $this->lateLoyal($totalLate, $totalLoyal);
        $pdf->setFont('Arial', 'B', 9);
        $pdf->Cell($kolom * 7, 7, 'Total', 1, false, 'R', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, $total['late'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 2, 7, $total['loyal'], 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Cell($kolom * 6, 7, '', 1, false, 'C', 0, '', 0, false, 'C', 'C');
        $pdf->Output($id.$from->format($session->get('date_format')).$to->format($session->get('date_format')).'.pdf', 'D');
    }

    /**
     * @Route("/human_resources/attendance/export/excel/{from}/{to}/{id}", name="GatotKacaErpHumanResourcesBundle_Attendance_exportExcel", defaults={"id" = null})
     *
     * Print Attendance by Employee
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
        if (!($security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view') || $security->isAllowed($session->get('group_id'), AttendanceController::PERSONAL, 'view'))) {
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
        $worksheet->setTitle('Attendance Report')
            ->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);
        $worksheet->mergeCells('A'.$start.':H'.$start)
            ->setCellValue('A'.$start++, "ATTENDANCE REPORT")
            ->mergeCells('A'.$start.':H'.$start)
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
            ->setCellValue('C'.$start, 'Time In')
            ->setCellValue('D'.$start, 'Time Out')
            ->setCellValue('E'.$start, 'Late')
            ->setCellValue('F'.$start, 'Loyal')
            ->setCellValue('G'.$start, 'Reason')
            ->setCellValue('H'.$start, 'Description');
        $header = $worksheet->getStyle('A'.$start.':H'.$start);
        $header->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $header->getFont()->setBold(true);
        $start++;
        $totalLate  = 0;
        $totalLoyal = 0;
        foreach ($data['attendance'] as $key => $val) {
            $worksheet->setCellValue('A'.$start, $val['att_day'])
                ->setCellValue('B'.$start, $val['att_date'])
                ->setCellValue('C'.$start, $val['att_in'])
                ->setCellValue('D'.$start, $val['att_out'])
                ->setCellValue('E'.$start, $val['att_late'])
                ->setCellValue('F'.$start, $val['att_loyal'])
                ->setCellValue('G'.$start, $val['miss'])
                ->setCellValue('H'.$start, $val['description']);
            $start++;
            $late   = explode(':', $val['att_late']);
            $hLate  = $late[0] * 60 * 60;
            $mLate  = $late[1] * 60;
            $sLate  = $late[2];
            $totalLate += $hLate + $mLate + $sLate;
            $loyal  = explode(':', $val['att_loyal']);
            $hLoyal = $loyal[0] * 60 * 60;
            $mLoyal = $loyal[1] * 60;
            $sLoyal = $loyal[2];
            $totalLoyal += $hLoyal + $mLoyal + $sLoyal;
        }
        $total = $this->lateLoyal($totalLate, $totalLoyal);
        $worksheet->setCellValue('A'.$start, 'Total')
            ->mergeCells('A'.$start.':D'.$start)
            ->setCellValue('E'.$start, $total['late'])
            ->setCellValue('F'.$start, $total['loyal']);
        $worksheet->getStyle('A'.$start.':H'.$start)->getFont()->setBold(true);
        $worksheet->getStyle('A'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        //Force download
        $response   = new Response();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment; filename = "'.$id.$from->format($session->get('date_format')).$to->format($session->get('date_format')).'.xls"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $response->prepare($request);
        $response->sendHeaders();
        $this->generateExcel($excel, 'Excel5');
    }

    /**
     * @Route("/human_resources/attendance/upload", name="GatotKacaErpHumanResourcesBundle_Attendance_upload")
     *
     * Upload Attendance
     **/
    public function uploadAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        $upload     = $request->files->get('att_data');
        $path       = $this->get('kernel')->getRootDir().'/../docs';
        $date       = $request->get('att_date');
        //Don't have access
        if ($request->getMethod() !== 'POST') {
            return $this->goHome();
        }
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'modif')) {
            return new Response(json_encode($output));
        }
        $output['success']  = true;
        $output['status']   = false;
        if ($_FILES['att_data']['size'] === 0) {
            return new Response(json_encode($output));
        }
        $name   = "Attendance_".$date."_".date('Y_m_d_H_i_s').".{$upload->guessExtension()}";
        $output['filename'] = $name;
        //Not Allowed File
        $mimes  = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
        if (!in_array($upload->getMimeType(), $mimes)) {
            return new Response(json_encode($output));
        }
        //Do upload
        $upload->move($path, $name);
        $reader = $this->getExcelReader('CSV')
                ->setDelimiter(',')
                ->setEnclosure('"')
                ->setLineEnding("\n")
                ->setSheetIndex(0)
                ->load("{$path}/{$name}");
        $reader = $reader->setActiveSheetIndex(0);
        $highestRow = $reader->getHighestRow();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($reader->getHighestColumn());
        $data   = array();
        //Read from file
        for ($row = 2; $row <= $highestRow; ++$row) {//Exclude first row
            $file_data  = array();
            for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                $value  = $reader->getCellByColumnAndRow($col, $row)->getValue();
                $file_data[$col]= trim($value);
            }
            $data[] = $file_data;
        }
        //Fetch data
        $model  = $this->getModelManager()->getAttendance();
        $output['status']   = $model->saveFromMechine($data, $date);
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new Response(json_encode($output));
    }

    /**
     * @Route("/human_resources/attendance/getunprocces", name="GatotKacaErpHumanResourcesBundle_Attendance_getUnProccess")
     *
     * Get Unprocces Attendance
     **/
    public function getUnProccessAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        //Don't have access
        if (!$this->validRequest($request)) {
            return $this->goHome();
        }
        $output = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        $keyword= strtoupper($request->get('query', ''));
        $start  = abs($request->get('start'));
        $limit  = abs($request->get('limit'));
        //Get model
        $model  = $this->getModelManager()->getAttendance();
        $aData  = $model->getFromMechine($start, $limit);
        if ($total = count($aData)) {
            $output['total']= $model->countTotalFromMechine();
            $output['data'] = $aData;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/attendance/procces", name="GatotKacaErpHumanResourcesBundle_Attendance_proccess")
     *
     * Procces Attendance
     **/
    public function processAction()
    {
        $session    = $this->getHelper()->getSession();
        $request    = $this->getRequest();
        $security   = $this->getSecurity();
        //Don't have access
        if (!$this->validRequest($request)) {
            return $this->goHome();
        }
        $output = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        //Get model
        $model  = $this->getModelManager()->getAttendance();
        if ($success = $model->procces()) {
            $output['success']  = true;
            $output['msg']      = 'Attendance has been proccessed.';
        } else {
            $output['msg']      = $model->getMessage();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }

    /**
     * @Route("/human_resources/attendance/viewdetail", name="GatotKacaErpHumanResourcesBundle_Attendance_getDetail")
     *
     * Get Attendance Detail
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
        $output = array('success' => false);
        //Don't have authorization
        if (!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'modif')) {
            return new JsonResponse($output);
        }
        $output = array('success' => true);
        //Get model
        $model  = $this->getModelManager()->getAttendance();
        $aData  = $model->getBy('id', $request->get('att_id'));
        if ($total = count($aData)) {
            $output['total']= $total;
            $output['data'] = $aData;
        } else {
            $output['total']= $total;
            $output['data'] = array();
        }
        $security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());

        return new JsonResponse($output);
    }
}
