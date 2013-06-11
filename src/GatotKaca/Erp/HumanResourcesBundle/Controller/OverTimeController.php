<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Controller/OverTimeController.php
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;
use PHPExcel_Cell_DataType;
use PHPExcel_Style_Alignment;

class OverTimeController extends AdminController{
	const MODULE	= 'panelovertimebyemployee';
	const BYDATE	= 'panelovertimebydate';
	const IS_POST_REQUEST		= FALSE;
	const IS_XML_HTTP_REQUEST	= FALSE;

	/**
	 * Export Helper
	 **/
	private function exportHelper($employeeId, $from, $to){
		$data	= $this->modelHelper($employeeId, $from, $to);
		//Get content from template
		return $this->renderView(
			'GatotKacaErpHumanResourcesBundle:OverTime:print.html.twig',
			array(
				'overtime'	=> $data['overtime'],
				'employee'	=> $data['employee'],
				'from'		=> $from,
				'to'		=> $to
			)
		);
	}
	
	/**
	 * Model Helper
	 **/
	private function modelHelper($employeeId, $from, $to){
		$model		= $this->modelManager()->getOverTime();
		$overtime	= $model->getBy('employee', $employeeId, $from, $to, array(1));
		$employee	= $this->modelManager()->getEmployee()->getById($employeeId);
		$this->getSecurity()->logging($this->getRequest()->getClientIp(), $this->getHelper()->getSession()->get('user_id'), $this->getRequest()->get('_route'), $model->getAction(), $model->getModelLog());
		return array(
			'overtime'	=> $overtime,
			'employee'	=> $employee
		);
	}

	/**
	 * @Route("/human_resources/overtime/getbyemployee", name="GatotKacaErpHumanResourcesBundle_OverTime_getByEmployee")
	 * 
	 * Get Over Time List by Employee
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
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->modelManager()->getOverTime();
		$overtime	= $model->getBy('employee', $request->get('employee_id', ''), $request->get('from', ''), $request->get('to', ''), array(1));
		if($total	= count($overtime)){
			$output['total']	= $total;
			$output['data']		= $overtime;
		}else{
			$output['total']	= $total;
			$output['data']		= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/human_resources/overtime/getbydate", name="GatotKacaErpHumanResourcesBundle_OverTime_getByDate")
	 * 
	 * Get Today OverTime
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
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::BYDATE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$from	= $request->get('from', '');
		$to		= $request->get('to', '');
		$absence= $request->get('absence', 'true');
		//Get model
		$model		= $this->modelManager()->getOverTime();
		$overtime	= $model->getByDate($from, $to, $absence);
		if($total	= count($overtime)){
			$output['total']	= $total;
			$output['data']		= $overtime;
		}else{
			$output['total']	= $total;
			$output['data']		= array();
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
		return new JsonResponse($output);
	}

	/**
	 * @Route("/human_resources/overtime/viewdetail", name="GatotKacaErpHumanResourcesBundle_OverTime_getDetail")
	 *
	 * Get Over Time Detail
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
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		//Get model
		$model		= $this->modelManager()->getOverTime();
		$aData	= $model->getBy('id', $request->get('ot_id'), NULL, NULL, array(1));
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

	/**
	 * @Route("/human_resources/overtime/save", name="GatotKacaErpHumanResourcesBundle_OverTime_save")
	 */
	public function saveAction(){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		$output	= array('success' => FALSE);
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'modif')){
			return new JsonResponse($output);
		}
		$input		= json_decode($request->get('overtime', ''));
		//Get model
		$model		= $this->modelManager()->getOverTime();
		if($success	= $model->save($input)){
			$output['success']	= TRUE;
			$output['msg']	= 'Over time has been saved.';
		}else{
			$output['msg']	= $model->getMessage().'. Over time has not been saved.';
		}
		$security->logging($request->getClientIp(), $session->get('user_id'), $request->get('_route'), $model->getAction(), $model->getModelLog());
	
		return new JsonResponse($output);
	}

	/**
	 * @Route("/human_resources/overtime/preview", name="GatotKacaErpHumanResourcesBundle_OverTime_preview")
	 *
	 * Print Over Time by Employee
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
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$output	= array('success' => TRUE);
		$employeeId	= $request->get('employee_id', '');
		$from		= new \DateTime($request->get('from', ''));
		$to			= new \DateTime($request->get('to', ''));
		$output['data']	= $this->exportHelper($employeeId, $from->format('d M Y'), $to->format('d M Y'));
		return new JsonResponse($output);
	}
	
	/**
	 * @Route("/human_resources/overtime/export/jpg/{id}/{from}/{to}", name="GatotKacaErpHumanResourcesBundle_OverTime_exportJpg")
	 *
	 * Print OverTime by Employee
	 **/
	public function exportJpgAction($id, $from, $to){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
        if(!$session->get('ERP_LOGGED_IN') || !$session->isValid()){
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$from		= new \DateTime($from);
		$to			= new \DateTime($to);
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
	 * @Route("/human_resources/overtime/export/pdf/{id}/{from}/{to}", name="GatotKacaErpHumanResourcesBundle_OverTime_exportPdf")
	 *
	 * Print OverTime by Employee
	 **/
	public function exportPdfAction($id, $from, $to){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
        if(!$session->get('ERP_LOGGED_IN') || !$session->isValid()){
            return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
        }
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')){
			return new JsonResponse($output);
		}
		$from	= new \DateTime($from);
		$to		= new \DateTime($to);
		$data	= $this->modelHelper($id, $from->format('d M Y'), $to->format('d M Y'));
		$pdf	= $this->getPdfGenerator();
		$this->setSigniture($pdf);
		$partition	= 17;
		$kolom  = $this->getPerPartition($partition);
		$pdf->setFont('Arial', 'B', 13);
		$pdf->Cell($kolom * $partition, 7, "OverTime Detail From {$from->format('d M Y')} To {$to->format('d M Y')}", 0, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
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
    	$pdf->Cell($kolom * 2, 7, 'Day', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 3, 7, 'Date', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 2, 7, 'In', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 2, 7, 'Out', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 2, 7, 'Total', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 6, 7, 'Approved By', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Ln();
    	$pdf->setFont('Arial', '', 9);
    	$total	= 0;
    	foreach($data['overtime'] as $key => $val){
    		$pdf->Cell($kolom * 2, 7, $val['ot_day'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 3, 7, $val['ot_date'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 2, 7, $val['ot_start'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 2, 7, $val['ot_end'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 2, 7, $val['ot_real'], 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Cell($kolom * 6, 7, $val['ot_approvedby'], 1, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
			$pdf->Ln();
			$total	+= $val['ot_real'];
    	}
    	$pdf->setFont('Arial', 'B', 9);
    	$pdf->Cell($kolom * 9, 7, 'Total', 1, FALSE, 'C', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Cell($kolom * 8, 7, $total, 1, FALSE, 'L', 0, '', 0, FALSE, 'C', 'C');
    	$pdf->Output($id.$from->format('_d_m_Y').$to->format('_d_m_Y').'.pdf', 'D');
	}
	
	/**
	 * @Route("/human_resources/overtime/export/excel/{id}/{from}/{to}", name="GatotKacaErpHumanResourcesBundle_OverTime_exportExcel")
	 *
	 * Print OverTime by Employee
	 **/
	public function exportExcelAction($id, $from, $to){
		$session	= $this->getHelper()->getSession();
		$request	= $this->getRequest();
		$security	= $this->getSecurity();
		if(!$session->get('ERP_LOGGED_IN') || !$session->isValid()){
			return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_login'));
		}
		//Don't have authorization
		if(!$security->isAllowed($session->get('group_id'), OverTimeController::MODULE, 'view')){
			return new JsonResponse($output);
		}
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
		$worksheet->setTitle('OverTime Report')
			->getDefaultStyle()
			->getFont()
			->setName('Arial')
			->setSize(9);
		$worksheet->mergeCells('A'.$start.':F'.$start)
			->setCellValue('A'.$start, "OverTime Detail From {$from->format('d M Y')} To {$to->format('d M Y')}")
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
		$header	= $worksheet->getStyle('A'.$start.':F'.$start);
		$header->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$header->getFont()->setBold(TRUE);
		$start++;
		$indent	= $start;
		foreach($data['overtime'] as $key => $val){
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
		$worksheet->getStyle('A'.$start.':D'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle('A'.$start.':F'.$start)->getFont()->setBold(TRUE);
		$worksheet->setCellValue('E'.$start, '=SUM(E'.$indent.':E'.--$start.')');
		//Force download
		$response	= new Response();
		$response->headers->set('Content-Type', 'application/vnd.ms-excel');
		$response->headers->set('Content-Disposition', 'attachment; filename = "'.$id.$from->format('_d_m_Y').$to->format('_d_m_Y').'.xls"');
		$response->headers->set('Cache-Control', 'max-age=0');
		$response->prepare($request);
		$response->sendHeaders();
		$this->generateExcel($excel, 'Excel5');
	}
}