<?php
/**
 * @filenames: GatotKaca/Erp/UtilitiesBundle/Controller/IndexController.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\UtilitiesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class IndexController extends AdminController{
	/**
	 * @Route("/utilities", name="GatotKacaErpUtilitiesBundle_Index_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}
}