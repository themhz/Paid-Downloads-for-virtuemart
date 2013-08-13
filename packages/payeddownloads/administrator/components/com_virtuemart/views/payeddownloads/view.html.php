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
