<?php
/**
 * @filenames: GatotKaca/Erp/HumanResourcesBundle/Controller/IndexController.php
 * Author     : Muhammad Surya Ikhsanudin 
 * License    : Protected 
 * Email      : mutofiyah@gmail.com 
 *  
 * Dilarang merubah, mengganti dan mendistribusikan 
 * ulang tanpa sepengetahuan Author
 **/
namespace GatotKaca\Erp\HumanResourcesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GatotKaca\Erp\MainBundle\Controller\AdminController;

class IndexController extends AdminController{
	/**
	 * @Route("/human_resources", name="GatotKacaErpHumanResourcesBundle_Index_index")
	 */
	public function indexAction(){
		return $this->goHome();
	}
}