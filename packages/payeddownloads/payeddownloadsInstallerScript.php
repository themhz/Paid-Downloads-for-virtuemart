<?php
/*------------------------------------------------------------------------
# payeddownloadsinstallerScript 
# ------------------------------------------------------------------------
# @author    themhz (codecraft.gr)
# @copyright Copyright (C) 2010 agorasite.gr All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
# @Websites: http://www.codecraft.gr
# @Technical Support:  e-mail me at themhz@codecraft.gr
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

class plgVmCustomPayeddownloadsInstallerScript {

   function install($parent) {
	         // echo '<p>'. JText::_('1.6 Custom install script') . '</p>';	
		 $data =new stdClass();
		 $data->module_id = null;
		 $data->module_name = "payedDownloads"; 
		 $data->module_description = "This is a module in order to enable payed downloads";
		 $data->module_perms = 'none';
		 $data->published = 1;
		 $data->is_admin = 1;
		 $data->ordering = 100;
					
		 $db = JFactory::getDBO();
		 $ret = $db->insertObject( '#__virtuemart_modules', $data, 'id' );
		 
		 if (!$ret) {
			$this->setError($db->getErrorMsg());
			return false;
		 }
		 $module_id = (int)$db->insertid();		

		 $db = JFactory::getDBO();
		 $data2 =new stdClass();
		 $data2->id = null;
		 $data2->module_id = $module_id;
		 $data2->parent_id = 0; 
		 $data2->name = "Payed Downloads";
		 $data2->link = "";
		 $data2->depends = "";
		 $data2->icon_class = "vmicon vmicon-16-coins";
		 $data2->ordering = 1;
  		 $data2->published = 1;
		 $data2->tooltip = NULL;
		 $data2->view = "payeddownloads";
		 $data2->task = "";					
		 $db->insertObject( '#__virtuemart_adminmenuentries', $data2, 'id' );

		 $db = JFactory::getDBO();
 		 $data3 =new stdClass();
		 $data3->id = null;
		 $data3->module_id = $module_id;
		 $data3->parent_id = 0; 
		 $data3->name = "Reporting";
		 $data3->link = "";
		 $data3->depends = "";
		 $data3->icon_class = "vmicon vmicon-16-price_watch";
		 $data3->ordering = 1;
  		 $data3->published = 1;
		 $data3->tooltip = NULL;
		 $data3->view = "payeddownloads";
		 $data3->task = "reporting";					
		 $db->insertObject( '#__virtuemart_adminmenuentries', $data3, 'id' );

		echo "<p style='color:#00FF00;'>Don't forget to enable the plugins plg_payeddownloadsvisits in order to monitor your visits and downloads and payeddownloads in order to make the system work</p>";
		
   }

   function uninstall($parent) {
	  $db = JFactory::getDBO();
	  $query = " DELETE FROM #__virtuemart_modules WHERE module_name = 'payedDownloads' ";
	  $db->setQuery($query);
	  $db->query();

	  $query = " DELETE FROM #__virtuemart_adminmenuentries WHERE view = 'payeddownloads' ";
	  $db->setQuery($query);
	  $db->query();	

	  $destination = JPATH_SITE."/components/com_virtuemart/controllers/payeddownloads.php";
	  JFile::delete($destination);

	  $destination = JPATH_SITE."/components/com_virtuemart/views/payeddownloads";		
	  JFolder::delete($destination);

	  $destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/views/payeddownloads";		
	  JFolder::delete($destination);

	  $destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/controllers/payeddownloads.php";
	  JFile::delete($destination);

	  $destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/helpers/PayeddownloadsHelper.php";
	  JFile::delete($destination);

	  $destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/models/payeddownloads.php";
	  JFile::delete($destination);


   }

   function update($parent) {

   }

   function preflight($type, $parent) {

   }

   function postflight($type, $parent) {
	//Site
        $src = JPATH_SITE."/plugins/vmcustom/payeddownloads/components/com_virtuemart/controllers/payeddownloads.php";
        $destination = JPATH_SITE . "/components/com_virtuemart/controllers/payeddownloads.php";
        JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$destination = JPATH_SITE."/components/com_virtuemart/views/payeddownloads";		
	JFolder::create($destination);
	echo $destination." Created<br>" ;
	$destination = JPATH_SITE."/components/com_virtuemart/views/payeddownloads/tmpl";		
	JFolder::create($destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/components/com_virtuemart/views/payeddownloads/index.html";
	$destination = JPATH_SITE."/components/com_virtuemart/views/payeddownloads/index.html";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/components/com_virtuemart/views/payeddownloads/view.html.php";
	$destination = JPATH_SITE."/components/com_virtuemart/views/payeddownloads/view.html.php";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/components/com_virtuemart/views/payeddownloads/tmpl/index.html";
	$destination = JPATH_SITE."/components/com_virtuemart/views/payeddownloads/tmpl/index.html";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/components/com_virtuemart/views/payeddownloads/tmpl/default.xml";
	$destination = JPATH_SITE."/components/com_virtuemart/views/payeddownloads/tmpl/default.xml";		   		           
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	//Administrator
	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/views/payeddownloads";		
	JFolder::create($destination);
	echo $destination." Created<br>" ;

	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/views/payeddownloads/tmpl";		
	JFolder::create($destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator/components/com_virtuemart/views/payeddownloads/tmpl/index.html";
	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/views/payeddownloads/tmpl/index.html";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator/components/com_virtuemart/views/payeddownloads/tmpl/default.php";
	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/views/payeddownloads/tmpl/default.php";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator/components/com_virtuemart/views/payeddownloads/tmpl/reporting.php";
	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/views/payeddownloads/tmpl/reporting.php";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator/components/com_virtuemart/views/payeddownloads/index.html";
	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/views/payeddownloads/index.html";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator/components/com_virtuemart/views/payeddownloads/view.html.php";
	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/views/payeddownloads/view.html.php";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator/components/com_virtuemart/controllers/payeddownloads.php";
	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/controllers/payeddownloads.php";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator/components/com_virtuemart/helpers/PayeddownloadsHelper.php";
	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/helpers/PayeddownloadsHelper.php";		
	JFile::move($src, $destination);
	echo $destination." Created<br>" ;

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator/components/com_virtuemart/models/payeddownloads.php";
	$destination = JPATH_ADMINISTRATOR."/components/com_virtuemart/models/payeddownloads.php";		
	JFile::move($src, $destination);
	echo $destination." Created<br>";
	
	//Administrator Language
	$destination = JPATH_ADMINISTRATOR."/language/overrides";		
	if(!JFolder::exists($destination))
	{
		$destination = JPATH_ADMINISTRATOR."/language/overrides";		
		JFolder::create($destination);
		echo $destination." Created<br>";
	}

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator/language/overrides/en-GB.override.ini";
	$destination = JPATH_ADMINISTRATOR."/language/overrides/en-GB.override.ini";		
	if(JFile::exists($destination)){
		//open the file to write at the bottom 
		$name = 'COM_VIRTUEMART_PAYEDDOWNLOADS_MOD="Payed Downloads"';
		file_put_contents($destination, PHP_EOL, FILE_APPEND);	
		file_put_contents($destination, $name, FILE_APPEND);		
	}
	else
	{
		//Create the file
		JFile::move($src, $destination);
		echo $destination." Created<br>";			
	}
	
	
	//media		

	//media	css
	$destination = JPATH_SITE."/media/system/css";		
	if(!JFolder::exists($destination))
	{
		$destination = JPATH_SITE."/media/system/css";		
		JFolder::create($destination);
	}

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/media/system/css";	
	$destination = JPATH_SITE."/media/system/css";
	JFolder::copy($src, $destination,'',true);

	echo $destination." Created<br>" ;

	//media	js	
	$destination = JPATH_SITE."/media/system/js";		
	if(!JFolder::exists($destination))
	{
		$destination = JPATH_SITE."/media/system/js";		
		JFolder::create($destination);
	}

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/media/system/js";	
	$destination = JPATH_SITE."/media/system/js";
	JFolder::copy($src, $destination,'',true);

	echo $destination." Created<br>" ;

	//media	images	
	$destination = JPATH_SITE."/media/system/images";		
	if(!JFolder::exists($destination))
	{
		$destination = JPATH_SITE."/media/system/images";		
		JFolder::create($destination);
	}

	$src = JPATH_SITE."/plugins/vmcustom/payeddownloads/media/system/images";	
	$destination = JPATH_SITE."/media/system/images";
	JFolder::copy($src, $destination,'',true);

	echo $destination." Created<br>" ;	


	//Clean Up
	 /*$destination = JPATH_SITE."/plugins/vmcustom/payeddownloads/components";
	 JFolder::delete($destination);

	 $destination = JPATH_SITE."/plugins/vmcustom/payeddownloads/administrator";		
	 JFolder::delete($destination);

	 $destination = JPATH_SITE."/plugins/vmcustom/payeddownloads/media";		
	 JFolder::delete($destination);*/
    }
}

?>
