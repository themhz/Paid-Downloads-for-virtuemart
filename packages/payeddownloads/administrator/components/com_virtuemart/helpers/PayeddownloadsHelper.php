<?php
/*------------------------------------------------------------------------
# payeddownloads
# ------------------------------------------------------------------------
# @author    themhz (codecraft.gr)
# @copyright Copyright (C) 2010 agorasite.gr All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
# @Websites: http://www.codecraft.gr
# @Technical Support:  e-mail me at themhz@codecraft.gr
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');
class PayeddownloadFunctions {

	/**
	 * @var global database object
	 */
	private $_db = null;


	/**
	 * Contructor
	 */
	public function __construct(){

		$this->_db = JFactory::getDBO();
	}

		public function sentfileurl($Recipientmail,$body){
			$mailSender = JFactory::getMailer();
			$mailSender ->addRecipient($Recipientmail);
			$mailSender ->setSender( array( "robot1@codecraft.gr" ,"robot") );
			$mailSender ->setSubject("Download Link");
			$mailSender ->setBody($body);
			$mailSender ->isHTML(true);
			
			if (!$mailSender ->Send())
			{
				echo "Error";
			}
		}

	  public function createpassword(){  
		 $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		 $res = "";
		 for ($i = 0; $i < 10; $i++) {
		 $res .= $chars[mt_rand(0, strlen($chars)-1)];
		 }
		 
		 list($usec, $sec) = explode(" ",microtime());
		 $string = ((float)$usec + (float)$sec);
		 $string2 = explode(".", $string);
		 $datetime = new DateTime();                   
		 
		 return $res.$datetime->format("YmdHis$string2[1]");	 
	  }
	  
	  public function setexpirationdate($days){
	  	//$days = 30;
		$date = new DateTime();
		//echo $date->format("d-m-Y H:i:s").'<br />';		
		date_add($date, new DateInterval("P".$days."D"));
		//echo '<br />'.$date->format("d-m-Y").' : 5 Days';
		//2012-10-13 17:37:31
		return $date->format("Y-m-d");
	  } 
	  
	 

}

//pure php no tag
