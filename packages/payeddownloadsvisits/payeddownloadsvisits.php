<?php
/*------------------------------------------------------------------------
# payeddownloadsvisits
# ------------------------------------------------------------------------
# @author    themhz (codecraft.gr)
# @copyright Copyright (C) 2010 agorasite.gr All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
# @Websites: http://www.codecraft.gr
# @Technical Support:  e-mail me at themhz@codecraft.gr
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

defined('_JEXEC') or 	die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' ) ;

if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
$config = VmConfig::loadConfig();
//JPATH_VM_SITE = JPATH_ROOT.DS.'components'.DS.'com_virtuemart' );
//JPATH_VM_ADMINISTRATOR = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart' );

jimport( 'joomla.plugin.plugin' );


class plgSystempayeddownloadsvisits extends JPlugin
{
/**
* Constructor.
*
* @access protected
* @param object $subject The object to observe
* @param array   $config  An array that holds the plugin configuration
* @since 1.0
*/
	public function __construct( &$subject, $config )
	{
	parent::__construct( $subject, $config );
	 
	// Do some extra initialisation in this constructor if required
	}
	 
	/**
	* Do something onAfterInitialise
	*/
	function onAfterInitialise()
	{
														
			$payeddownloadsmodel = VmModel::getModel('payeddownloads');			
			$payeddownloadsmodel->savevisit(); 
	}
	 
	/**
	* Do something onAfterRoute
	*/
	function onAfterRoute()
	{
		
	}
	 
	/**
	* Do something onAfterDispatch
	*/
	function onAfterDispatch()
	{
	}
	 
	/**
	* Do something onAfterRender
	*/
	function onAfterRender()
	{
	
	}
}
?>
