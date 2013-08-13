<?php
/*------------------------------------------------------------------------
# payeddownload
# ------------------------------------------------------------------------
# themhz (agorasite.gr)
# copyright Copyright (C) 2010 agorasite.gr. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.agorasite.gr
# Technical Support:  Forum - http://agorasite.gr/index.php?option=com_kunena&view=category&catid=1&Itemid=138
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
defined('_JEXEC') or 	die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' ) ;

if (!class_exists('vmCustomPlugin')) require(JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php');


//require_once(JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php');
///var/www/agorasite.gr/administrator/components/com_virtuemart/plugins/vmcustomplugin.php
require_once(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'PayeddownloadsHelper.php');

class plgVmCustomPayeddownloads extends vmCustomPlugin {

	//Otan kataxorithei sto kalathi agorwn
	public function plgVmOnAddToCart(&$product){
		//echo JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php';
		//die();
		//$payeddownloadsmodel = VmModel::getModel('payeddownloads');
		//echo $payeddownloadsmodel->test();
		//die();
		
		//$PayeddownloadFunctions = new PayeddownloadFunctions();
		//$end_date=$PayeddownloadFunctions->setexpirationdate(30);
		//echo $end_date;
		//die();
		
	} 
	
	//When the order completes
	public function plgVmConfirmedOrder($html,$paymentResponse){		
		$body="";
		$payeddownloadsmodel = VmModel::getModel('payeddownloads');		
		$PayeddownloadFunctions = new PayeddownloadFunctions();
				
		$order_id = $paymentResponse["details"]["BT"]->virtuemart_order_id;
		
		$rows=$payeddownloadsmodel->getProductfilesByOrderId($order_id);
		$password =$PayeddownloadFunctions->createpassword(); 
		$end_date=$PayeddownloadFunctions->setexpirationdate(30);
					
		if(count($rows)>0)
		{							
			foreach($rows as $row)
			{
															
				$body.="
					<p>You may download the ".$row->file_name." from the following link</p>
					<p>
						<a href='".JURI::base()."index.php?option=com_virtuemart&view=payeddownloads&task=getfilebypassword&password=$password&file_id=$row->file_id'>
							Download the file
						</a>
					</p>
					<p>
						Please save this file since this url will expire at $end_date <br><br>
						thank you
					</p>						
				";			
			}
			
			$payeddownloadsmodel->createorderfilepasswords($order_id,$password,$end_date);		
			$PayeddownloadFunctions->sentfileurl($paymentResponse["details"]["BT"]->email,$body);								
						
		}
				
	}
		
 

}

?>
