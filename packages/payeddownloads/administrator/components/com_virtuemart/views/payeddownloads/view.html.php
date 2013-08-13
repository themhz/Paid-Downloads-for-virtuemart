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

// Load the view framework
if(!class_exists('VmView'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmview.php');
//jimport('joomla.html.pane');

/**
 * HTML View class for the VirtueMart Component
 *
 * @package		VirtueMart
 * @author
 */
class VirtuemartViewPayeddownloads extends VmView {

	function display($tpl = null) {
		//JFactory::getApplication()->JComponentTitle="Payed Downloads";
		//$this->loadHelper('adminMenu');
        JToolBarHelper::title("Payed Downloads"."::".JText::_('COM_VIRTUEMART_CONTROL_PANEL'), 'vm_store_48');

		parent::display($tpl);
	}


}

//pure php no tag
