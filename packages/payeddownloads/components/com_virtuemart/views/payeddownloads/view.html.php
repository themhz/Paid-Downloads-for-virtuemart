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
if (!class_exists('VmView'))
    require(JPATH_VM_SITE . DS . 'helpers' . DS . 'vmview.php');

/**
 * Product details
 *
 * @package VirtueMart
 * @author RolandD
 * @author Max Milbers
 */
class VirtueMartViewPayeddownloads extends VmView {

    /**
     * Collect all data to show on the template
     *
     * @author RolandD, Max Milbers
     */
    function display($tpl = null) {
		//echo "view.html.php";
		//die();
		//if(JRequest::getCmd( 'layout', 'default' )=='notify') $this->setLayout('notify'); //Added by Seyi Awofadeju to catch notify layout
		parent::display($tpl);
    }
	
	



}

// pure php no closing tag
