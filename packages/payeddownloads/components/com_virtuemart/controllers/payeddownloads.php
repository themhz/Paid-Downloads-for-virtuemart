<?php
/*------------------------------------------------------------------------
# payeddownloads - 
# ------------------------------------------------------------------------
# themhz (agorasite.gr)
# copyright Copyright (C) 2010 agorasite.gr. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.agorasite.gr
# Technical Support:  Forum - http://agorasite.gr/index.php?option=com_kunena&view=category&catid=1&Itemid=138
-------------------------------------------------------------------------*/
// no direct access

defined ('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport ('joomla.application.component.controller');

/**
 * VirtueMart Component Controller
 *
 * @package VirtueMart
 * @author RolandD
 */
class VirtueMartControllerPayeddownloads extends JController {

	public function __construct () {

		parent::__construct ();		
	}

	function display($cachable = false, $urlparams = false)  {		
		$view = $this->getView('payeddownloads', 'html');
		$view->display ();
	}

	function getfilebypassword(){
	 	$payeddownloadsModel = VmModel::getModel('payeddownloads');
	 	$payeddownloads = $payeddownloadsModel->getfilebypassword();
	 	echo $payeddownloads;
	 }
		
	
	public function getfileurl(){
		
		//echo "ok";
		//die();
	}
	
	
}
