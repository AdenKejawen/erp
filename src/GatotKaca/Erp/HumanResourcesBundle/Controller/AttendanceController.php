<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Controller/AttendanceController.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\HumanResourcesBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Helper\Csv\Reader AS CsvReader;
use GatotKaca\Erp\MainBundle\Controller\AdminController;
use PHPExcel_Cell_DataType;
use PHPExcel_Style_Alignment;

class AttendanceController extends AdminController{
	const MODULE	= 'panelattendancebyemployee';
	const BYDATE	= 'panelattendancebydate';
	const IS_POST_REQUEST		= FALSE;
	const IS_XML_HTTP_REQUEST	= FALSE;
	
	/**
	 * Export Helper
	 **/
	private function exportHelper($employeeId, $from, $to){
		$data	= $this->modelHelper($employeeId, $from, $to);
		//Get content from template
		return $this->renderView(
			'GatotKacaErpHumanResourcesBundle:Attendance:print.html.twig',
			array(
				'attendance'	=> $data['attendance'],
				'employee'		=> $data['employee'],
				'from'			=> $from,
				'to'			=> $to
			)
		);
	}
	
	/**
	 * Model Helper
	 **/
	private function modelHelper($employeeId, $from, $to){
		$model		= $this->modelManager()->getAttendance();
		$attendance	= $model->getBy('employee', $employeeId, $from, $to);
		$employee	= $this->modelManager()->getEmployee()->getBy('id', $employeeId);
		$this->getSecurity()->logging($this->getRequest()->getClientIp(), $this->getHelper()->getSession()->get('user_id'), $this->getRequest()->get('_route'), $model->getAction(), $model->getModelLog());
		return array(
			'attendance'	=> $attendance,
			'employee'		=> $employee
		);
	}
	
	/**
	 * @Route("/human_resources/attendance", name="GatotKacaErpHumanResourcesBundle_Attendance_index")
	 **/
	public function indexAction(){
		return $this->goHome();
	}
	
	/**
	 * @Route("/human_resources/attendance/save", name="GatotKacaErpHumanResourcesBundle_Attendance_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		//Don't have access
		if(!$this->validRequest($request)){
			return $this->goHome();
		}
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), EmployeeController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input	= json_decode($request->get('attendance'));
		//Get model
		$model		= $this->modelManager()->getAttendance();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'Attendance has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Attendance has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/human_resources/attendance/getbyemployee", name="GatotKacaErpHumanResourcesBundle_Attendance_getByEmployee")
	 * 
	 * Get Attendance List by Employee
	 **/
	public function getByEmployeeAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		//Don't have access
		if(!$this->validRequest($request)){
			return $this->goHome();
		}
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->modelManager()->getAttendance();
		$attendance	= $model->getBy('employee', $request->get('employee_id', $this->modelManager()->getEmployee()->getBy('username', $session->get('user_id'))), $request->get('from', NULL), $request->get('to', NULL));
		if($total	= count($attendance)){
			$output['total']	= $total;
			$output['data']		= $attendance;
		}else{
			$output['total']	= $total;
			$output['data']		= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/human_resources/attendance/getbydate", name="GatotKacaErpHumanResourcesBundle_Attendance_getByDate")
	 * 
	 * Get Today Attendance
	 **/
	public function getByDateAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		//Don't have access
		if(!$this->validRequest($request)){
			return $this->goHome();
		}
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::BYDATE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$from	= $request->get('from', '');
		$to		= $request->get('to', '');
		$absence= $request->get('absence', 'true');
		//Get model
		$model		= $this->modelManager()->getAttendance();
		$attendance	= $model->getByDate($from, $to, $absence);
		if($total	= count($attendance)){
			$output['total']	= $total;
			$output['data']		= $attendance;
		}else{
			$output['total']	= $total;
			$output['data']		= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/human_resources/attendance/preview", name="GatotKacaErpHumanResourcesBundle_Attendance_preview")
	 *
	 * Print Attendance by Employee
	 **/
	public function previewAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		//Don't have access
		if(!$this->validRequest($request)){
			return $this->goHome();
		}
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$eSess	= $this->modelManager()->getEmployee()->getBy('username', $session->get('user_id'));
		$id		= $request->get('employee_id', $eSess[0]['employee_id']);
		$from	= new \DateTime($request->get('from', ''));
		$to		= new \DateTime($request->get('to', ''));
		$output['data']	= $this->exportHelper($id, $from->format('d M Y'), $to->format('d M Y'));
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/human_resources/attendance/export/jpg/{from}/{to}/{id}", name="GatotKacaErpHumanResourcesBundle_Attendance_exportJpg", defaults={"id" = null})
	 *
	 * Print Attendance by Employee
	 **/
	public function exportJpgAction($from, $to, $id){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
        if(!$session->get('ERP_LOGGED_IN') || !$session->isValid()){
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$eSess	= $this->modelManager()->getEmployee()->getBy('username', $session->get('user_id'));
		$id		= $id === NULL ? $eSess[0]['employee_id'] : $id;
		$from	= new \DateTime($from);
		$to		= new \DateTime($to);
		return new Response(
		    $this->getJpgGenerator()->getOutputFromHtml($this->exportHelper($id, $from->format('d M Y'), $to->format('d M Y'))),
		    200,
		    array(
		        'Content-Type'          => 'application/jpg',
		        'Content-Disposition'   => 'attachment; filename = "'.$id.$from->format('_d_m_Y').$to->format('_d_m_Y').'.jpg"'
		    )
		);
	}

	/**
	 * @Route("/human_resources/attendance/export/pdf/{from}/{to}/{id}", name="GatotKacaErpHumanResourcesBundle_Attendance_exportPdf", defaults={"id" = null})
	 *
	 * Print Attendance by Employee
	 **/
	public function exportPdfAction($from, $to, $id){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
        if(!$session->get('ERP_LOGGED_IN') || !$session->isValid()){
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$eSess	= $this->modelManager()->getEmployee()->getBy('username', $session->get('user_id'));
		$id		= $id === NULL ? $eSess[0]['employee_id'] : $id;
		$from	= new \DateTime($from);
		$to		= new \DateTime($to);
		$data	= $this->modelHelper($id, $from->format('d M Y'), $to->format('d M Y'));
		$pdf	= $this->getPdfGenerator();
		$this->setSigniture($pdf);
		$partition	= 17;
		$kolom  = $this->getPerPartition($partition);
		$pdf->setFont('Arial', 'B', 13);
		$pdf->Cell($kolom * $partition, 7, "Attendance Detail From {$from->format('d M Y')} To {$to->format('d M Y')}", 0, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Ln(17);
    	$pdf->setFont('Arial', '', 10);
    	$pdf->Cell($kolom * 3, 7, 'Fullname', 0, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom, 7, ':', 0, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 13, 7, $data['employee'][0]['employee_fname'].' '.$data['employee'][0]['employee_lname'], 0, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Ln();
    	$pdf->Cell($kolom * 3, 7, 'Company', 0, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom, 7, ':', 0, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 13, 7, $data['employee'][0]['employee_companyname'], 0, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Ln();
    	$pdf->Cell($kolom * 3, 7, 'Department', 0, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom, 7, ':', 0, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 13, 7, $data['employee'][0]['employee_departmentname'], 0, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Ln(11);
    	$pdf->setFont('Arial', 'B', 9);
    	$pdf->Cell($kolom, 7, 'Day', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 2, 7, 'Date', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 2, 7, 'Time In', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 2, 7, 'Time Out', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 2, 7, 'Late', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 2, 7, 'Loyal', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 2, 7, 'Reason', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 4, 7, 'Description', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Ln();
    	foreach($data['attendance'] as $key => $val){
    		$pdf->setFont('Arial', '', 9);
    		$pdf->Cell($kolom, 7, $val['att_day'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 2, 7, $val['att_date'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 2, 7, $val['att_in'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 2, 7, $val['att_out'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 2, 7, $val['att_late'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 2, 7, $val['att_loyal'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 2, 7, $val['miss'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->setFont('Arial', '', 8);
			$pdf->Cell($kolom * 4, 7, $val['description'], 1, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Ln();
    	}
    	$pdf->Output($id.$from->format('_d_m_Y').$to->format('_d_m_Y').'.pdf', 'D');
	}
	
	/**
	 * @Route("/human_resources/attendance/export/excel/{from}/{to}/{id}", name="GatotKacaErpHumanResourcesBundle_Attendance_exportExcel", defaults={"id" = null})
	 *
	 * Print Attendance by Employee
	 **/
	public function exportExcelAction($from, $to, $id){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		if(!$session->get('ERP_LOGGED_IN') || !$session->isValid()){
			return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
		}
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$eSess	= $this->modelManager()->getEmployee()->getBy('username', $session->get('user_id'));
		$id		= $id === NULL ? $eSess[0]['employee_id'] : $id;
		$from	= new \DateTime($from);
		$to		= new \DateTime($to);
		$data	= $this->modelHelper($id, $from->format('d M Y'), $to->format('d M Y'));
		//Get Excel Instance
		$start	= 1;
		$excel	= $this->getExcelWriter();
		$this->setSigniture($excel);
		$excel->getDefaultStyle()
			->getAlignment()
			->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		//Writing excel
		$worksheet	= $excel->setActiveSheetIndex(0);
		$worksheet->getStyle('A'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$worksheet->setTitle('Attendance Report')
			->getDefaultStyle()
			->getFont()
			->setName('Arial')
			->setSize(9);
		$worksheet->mergeCells('A'.$start.':H'.$start)
			->setCellValue('A'.$start, "Attendance Detail From {$from->format('d M Y')} To {$to->format('d M Y')}")
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
		$header	= $worksheet->getStyle('A'.$start.':H'.$start);
		$header->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$header->getFont()->setBold(TRUE);
		$start++;
		foreach($data['attendance'] as $key => $val){
			$worksheet->setCellValue('A'.$start, $val['att_day'])
				->setCellValue('B'.$start, $val['att_date'])
				->setCellValue('C'.$start, $val['att_in'])
				->setCellValue('D'.$start, $val['att_out'])
				->setCellValue('E'.$start, $val['att_late'])
				->setCellValue('F'.$start, $val['att_loyal'])
				->setCellValue('G'.$start, $val['miss'])
				->setCellValue('H'.$start, $val['description']);
			$start++;
		}
		//Force download
		$response	= new Response();
		$response->headers->set('Content-Type', 'application/vnd.ms-excel');
		$response->headers->set('Content-Disposition', 'attachment; filename = "'.$id.$from->format('_d_m_Y').$to->format('_d_m_Y').'.xls"');
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
	public function uploadAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$upload		= $request->files->get('att_data');
		$path		= $this->get('kernel')->getRootDir().'/../docs';
		$date		= $request->get('att_date');
		//Don't have access
		if($request->getMethod() !== 'POST'){
			return $this->goHome();
		}
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'modif')){
			return new Response(json_encode($output));
		}
		$output['success']	= TRUE;
		$output['status']	= FALSE;
		if($_FILES['att_data']['size'] === 0){
			return new Response(json_encode($output));
		}
		$name		= "Attendance_".$date."_".date('Y_m_d_H_i_s').".{$upload->guessExtension()}";
		$output['filename']	= $name;
		//Not Allowed File
		$mimes	= array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
		if(!in_array($upload->getMimeType(), $mimes)){
			return new Response(json_encode($output));
		}
		//Do upload
		$upload->move($path, $name);
		$reader		= new CsvReader("{$path}/{$name}");
		$data		= $reader->getData();
		//Fetch data
		$model		= $this->modelManager()->getAttendance();
		$output['status']	= $model->saveFromMechine($data, $date);;
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new Response(json_encode($output));
	}
	
	/**
	 * @Route("/human_resources/attendance/getunprocces", name="GatotKacaErpHumanResourcesBundle_Attendance_getUnProccess")
	 *
	 * Get Unprocces Attendance
	 **/
	public function getUnProccessAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		//Don't have access
		if(!$this->validRequest($request)){
			return $this->goHome();
		}
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$keyword	= strtoupper($request->get('query', ''));
		$start	= abs($request->get('start'));
		$limit	= abs($request->get('limit'));
		//Get model
		$model		= $this->modelManager()->getAttendance();
		$aData	= $model->getFromMechine($start, $limit);
		if($total	= count($aData)){
			$output['total']	= $model->countTotalFromMechine();
			$output['data']	= $aData;
		}else{
			$output['total']	= $total;
			$output['data']	= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/human_resources/attendance/procces", name="GatotKacaErpHumanResourcesBundle_Attendance_proccess")
	 *
	 * Procces Attendance
	 **/
	public function processAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		//Don't have access
		if(!$this->validRequest($request)){
			return $this->goHome();
		}
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		//Get model
		$model		= $this->modelManager()->getAttendance();
		if($success	= $model->procces()){
			$output['success']	= TRUE;
			$output['msg']	= 'Attendance has been proccessed.';
		}else{
			$output['msg']	= $model->getMessage();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/human_resources/attendance/viewdetail", name="GatotKacaErpHumanResourcesBundle_Attendance_getDetail")
	 *
	 * Get Attendance Detail
	 **/
	public function getDetailAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		//Don't have access
		if(!$this->validRequest($request)){
			return $this->goHome();
		}
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), AttendanceController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->modelManager()->getAttendance();
		$aData	= $model->getBy('id', $request->get('att_id'));
		if($total	= count($aData)){
			$output['total']	= $total;
			$output['data']	= $aData;
		}else{
			$output['total']	= $total;
			$output['data']	= array();
		}
		
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}
}