<?php
/*------------------------------------------------------------------------
# payeddownloads
# ------------------------------------------------------------------------
# themhz (agorasite.gr)
# copyright Copyright (C) 2010 agorasite.gr. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.agorasite.gr
# Technical Support:  Forum - http://agorasite.gr/index.php?option=com_kunena&view=category&catid=1&Itemid=138
-------------------------------------------------------------------------*/
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport('joomla.application.component.controller');

/**
 * VirtueMart default administrator controller
 *
 * @package		VirtueMart
 */
class VirtuemartControllerPayeddownloads extends JController
{
	/**
	 * Method to display the view
	 *
	 * @access	public
	 */	
	public function __construct () {
	
		parent::__construct ();
	
		//$this->registerTask('getOffers', 'getOffers');
		//$this->registerTask('getProducts', 'getProducts');
	
	}
		
	 function display()
	 {

		 $document = JFactory::getDocument();
		 $viewName = JRequest::getWord('view', '');
		 $viewType = $document->getType();
		 $view = $this->getView($viewName, $viewType);		
		 parent::display();
	 }
	 
	 function reporting()
	 {
	 	
		 JRequest::setVar('view', 'payeddownloads');
		 JRequest::setVar('layout','reporting');		 
		 parent::display();	 		 	    		 		
	 }
		 
	 function getproductfiles(){
	 	$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->getproductfiles();
	 	echo $payeddownloads;
	 	die();	 
	 }
	 
	 function uploadfile()
	 {	 	
		$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloadsModel->uploadfile();
		die();
		//JRequest::setVar('view', 'payeddownloads');
		//JRequest::setVar('layout','default');		 
		//parent::display();	 		 	    		
	 	//echo $payeddownloads;	
	 	//echo 1;				
	 }
	 
	 function getproducts()
	 {
	 	$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->getproducts();
	 	echo $payeddownloads;
	 }
	 
	 function getfile(){
	 	$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloadsModel->getfile();
	 	//echo $payeddownloads;
	 }
	
	 
	 function deleteproductfile(){
	 	$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->deleteproductfile();
	 	echo $payeddownloads;
	 }
	 
	 function getActiveLinks(){
	 	$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->getActiveLinks();
	 	echo $payeddownloads;
	 }
	
	function getDownloadsPerDay(){
		$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->getDownloadsPerDay();
	 	echo $payeddownloads;
	} 	 
	
	function getDownloadsPerProduct(){
		$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->getDownloadsPerProduct();
	 	echo $payeddownloads;
	} 	 
	
	function getVisitsPerDate(){
		$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->getVisitsPerDate();
	 	echo $payeddownloads;
	}
	
	function saveActivation(){
		$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->saveActivation();
	 	echo $payeddownloads;
	}
	
	function getProductsWithFiles(){
		$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->getProductsWithFiles();
	 	echo $payeddownloads;		
	}
	
	function saveNewCustomActivation(){
		$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->saveNewCustomActivation();
	 	echo $payeddownloads;				
	}
}
