<?php
/**
 * @filenames: GatotKaca/Erp/MainBundle/Controller/BaseController.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : public 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PHPExcel;
use PHPExcel_IOFactory;
use TCPDF;

class BaseController extends Controller{
	private $helper;
	private $security;
	private $modelManager;
	private $pdf;
	private $image;
	private $excel;
	private $setting;
	private $pdfSeparator	= 21;
	
	/**
	 * Redirect to url
	 *
	 * @return url
	 **/
	public function goHome(){
		return $this->redirect($this->generateUrl('GatotKacaErpMainBundle_Main_index'));
	}
	
	/**
	 * Untuk mendapatkan object Helper
	 *
	 * @return mixed helper
	 **/
	public function getHelper(){
		if(!$this->helper){
			$this->helper   = $this->get('kejawen.helper');
		}
		return $this->helper;
	}
	
	/**
	 * Untuk mendapatkan object SecurityModel
	 *
	 * @return mixed security
	 **/
	public function getSecurity(){
		if(!$this->security){
			$this->security	= $this->get('kejawen.security');
		}
		return $this->security;
	}

	/**
	 * Untuk mendapatkan object ModelManager
	 *
	 * @return mixed modelManager
	 **/
	public function modelManager(){
		if(!$this->modelManager){
			$this->modelManager	= $this->get('kejawen.model.manager');
		}
		return $this->modelManager;
	}

	/**
	 * Untuk mendapatkan object SettingModel
	 *
	 * @return mixed setting
	 **/
	public function getSetting(){
		if(!$this->setting){
			$this->setting	= $this->get('kejawen.setting');
		}
		return $this->setting;
	}
	

	/**
	 * Untuk mendapatkan object TCPDF
	 * 
	 * @return mixed pdf
	 **/
	public function getPdfGenerator(){
		if(!$this->pdf){
			$this->pdf	= new TCPDF();
		}
		return $this->pdf;
	}

	/**
	 * Untuk mendapatkan object KNP Snappy
	 *
	 * @return mixed image
	 **/
	public function getJpgGenerator(){
		if(!$this->image){
			$this->image	= $this->get('knp_snappy.image');
		}
		return $this->image;
	}
	
	/**
	 * Untuk mendapatkan object PHPExcel
	 *
	 * @return mixed excel
	 **/
	public function getExcelWriter(){
		if(!$this->excel){
			$this->excel	= new PHPExcel();
		}
		return $this->excel;
	}
	
	/**
	 * Untuk mengenerate excel
	 *
	 * @return mixed excel
	 **/
	public function generateExcel(PHPExcel $excel, $format){
		PHPExcel_IOFactory::createWriter($excel, $format)->save('php://output');
	}

	/**
	 * Untuk validasi request
	 *
	 * @param mixed $session
	 * @param mixed $request
	 * @return boolean
	 **/
	public function validRequest($request){
		//Only Ajax Request
		if(!($request->getMethod() == 'POST' && $request->isXmlHttpRequest())){
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Untuk set signiture
	 **/
	public function setSigniture($object, $title = 'Gatot Kaca Report Generator'){
		if($object instanceof PHPExcel){
			$object->getProperties()
				->setCreator('Gatot Kaca ERP Report Generator')
				->setLastModifiedBy('Aden Kejawen Generator')
				->setTitle($title)
				->setSubject($title);
		}else if($object instanceof TCPDF){
			$object->SetCreator('Gatot Kaca ERP Report Generator');
			$object->SetAuthor('Gatot Kaca ERP Report Generator');
			$object->SetTitle($title);
			$object->SetSubject($title);
			$object->SetKeywords($title);
			$object->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$object->setPrintHeader(false);
			$object->AddPage();
		}
		return $object;
	}

	/**
	 * Set pdf separator
	 * 
	 * @param int $separator
	 **/
	public function setSeparator($separator){
		$this->pdfSeparator	= $separator;
	}

	/**
	 * Untuk mendapatkan panjang per bagian pada pdf
	 * 
	 * @param int $partition
	 * @return int
	 **/
	public function getPerPartition($partition){
		return ($this->getPdfGenerator()->getPageWidth() - $this->pdfSeparator) / $partition;
	}
}