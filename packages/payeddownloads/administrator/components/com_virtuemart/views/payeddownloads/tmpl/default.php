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
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
AdminUIHelper::startAdminArea();
$document = JFactory::getDocument();

$document->addStyleSheet(JURI::root().'media/system/css/flexigrid.pack.css?ver=1');
$document->addStyleSheet('http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css');
$document->addScript(JURI::root().'media/system/js/flexigrid.pack.js?ver=1' );


//$document->addStyleSheet(JURI::root().'media/system/css/flexigrid.pack.css?ver=1');
//$document->addStyleSheet(JURI::root().'media/system/css/jquery-ui-timepicker-addon.css?ver=1');
//$document->addStyleSheet(JURI::root().'media/system/css/ui/jquery.ui.all.css?ver=1');

//$document->addStyleSheet('http://code.jquery.com/ui/1.8.23/themes/base/jquery-ui.css');

//$document->addScript(JURI::root().'media/system/js/jquery-ui-1.8.23.custom.min.js?ver=1');
//$document->addScript(JURI::root().'media/system/js/jquery.ui.widget.js?ver=1');
//$document->addScript(JURI::root().'media/system/js/jquery-ui-timepicker-addon.js?ver=1');
//$document->addScript(JURI::root().'media/system/js/flexigrid.pack.js?ver=1' );

//include(JPATH_VM_ADMINISTRATOR.DS.'COPYRIGHT.php');
?>
<div id="confirmdialog" title="Basic dialog" style="display:none;"></div>
<div id="dialog" title="Basic dialog" style="display:none;">	
   <form enctype="multipart/form-data">
   		<table>
   			<tr><td>Product</td><td><select id="product" name="product"></td></tr>
   			<tr><td>File</td><td><input name="file" type="file" id="file"/></td></tr>
   			<tr><td></td><td><input type="button" value="Save" id="btnupload"/></td></tr>
   			<tr><td></td><td></td></tr>
   		</table>
				
	</form>
	<progress style="display:none;" id="progress"></progress>	
</div>
<table id="tblfiles" style="display:"></table>

<script type="text/javascript">
	jQuery(function($) {
		
		$("#dialog").dialog({
				height:150,
				width:400,
				modal: true,
				autoOpen: false,
				title:'Add new file to product',
				close: function(ev, ui) 
					{ 												
						
					}
				});
				
		$("#tblfiles").flexigrid({
				url: 'index.php?option=com_virtuemart&view=payeddownloads&task=getproductfiles&page=1&format=raw',
				dataType: 'json',				
				 buttons : [
				            {name: 'Add new file',    bclass: 'add_small',    onpress : CreateNewProductFile}				            				            				            
				        	],		
				singleSelect:true,			
				colModel : [				
					{display: 'Product File code', name : 'id', width : 100, sortable : true, align: 'center',hide:true},
					{display: 'Product Name', name : 'product_name', width : 180, sortable : true, align: 'center'},
					{display: 'Product id', name : 'virtuemart_product_id', width : 180, sortable : true, align: 'center',hide:true},					
					{display: 'File Size', name : 'file_size', width : 180, sortable : true, align: 'left'},
					{display: 'File Name', name : 'file_name', width : 120, sortable : true, align: 'left'},
					{display: 'File Type', name : 'file_type', width : 100, sortable : true, align: 'left'},
					{display: 'Uploaded date', name : 'reg_date', width : 120, sortable : true, align: 'right'},					
					{display: 'Action', name : 'getFile', width : 120, sortable : true, align: 'right'},
					{display: 'Action', name : 'delete', width : 120, sortable : true, align: 'right'}																	
					],
				searchitems : [
					{display: 'Ημερομηνία έναρξης', name : 'startdate', isdefault: true},
					{display: 'Product Name', name : 'product_name'},
					{display: 'File Size', name : 'file_size'},
					{display: 'File Name', name : 'file_name'},
					{display: 'File Type', name : 'file_type'},
					{display: 'Uploaded date', name : 'reg_date'},					
					{display: 'Action', name : 'delete'}					
					],
				sortname: "id",
				sortorder: "asc",
				usepager: true,
				title: 'Product Files',
				useRp: true,
				rp: 15,
				showTableToggleBtn: true,
				width: '100%',													
				onSuccess:loadEvents,
				resizable :true
			});		
		
		$('#btnupload').click(function(){
			
			$("#progress").css("display","");
		    var formData = new FormData($('form')[0]);
		    $.ajax({
		        url: 'index.php?option=com_virtuemart&view=payeddownloads&task=uploadfile&format=raw',  //server script to process data
		        type: 'POST',
		        xhr: function() {  // custom xhr
		            myXhr = $.ajaxSettings.xhr();
		            if(myXhr.upload){ // check if upload property exists
		                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
		            }
		            return myXhr;
		        },		        
		        success: completeHandler,		        
		        // Form data
		        data: formData,
		        //Options to tell JQuery not to process data or worry about content-type
		        cache: false,
		        contentType: false,
		        processData: false
		    });
		});
		
		$.getJSON('index.php?option=com_virtuemart&view=payeddownloads&task=getproducts&format=raw', function(data){
				    var html = '';
				    var len = data.length;
				    for (var i = 0; i< len; i++) {
				        html += '<option value="' + data[i].virtuemart_product_id + '">' + data[i].product_name + '</option>';
				    }
				    jQuery("#product").append(html);
				}).error(function() { alert("error"); })
				.complete(function() {
				});
		
	});
	
	
	function loadEvents(){
		jQuery('#tblfiles tr').dblclick(function(event) {		
				
				});	
	}
	
	function completeHandler(message){
		jQuery("#progress").css("display","none");
		jQuery("#file").val("");
		jQuery("#tblfiles").flexReload();
		jQuery("#dialog").dialog("close");
	}
	
	function progressHandlingFunction(data){
		//alert(data);
	}
	
	function CreateNewProductFile(){
		jQuery("#dialog").dialog("open");
		jQuery('#dialog').unbind();

		return false;
	}
	
	function getfile(file_id){		
		window.open('index.php?option=com_virtuemart&view=payeddownloads&task=getfile&file_id='+file_id+'&format=raw', 'downloader', '');
	}
	
	function deleteproductfile(file_id,product_id){
		jQuery("#confirmdialog").html("Are you sure you whant to delete the file?");			
			jQuery("#confirmdialog").dialog({
			  modal: true,	
		      buttons : {
		        "Confirm" : function() {				        			    		
		    		jQuery.ajax({
						  type: "POST",							  
						  url: "index.php?option=com_virtuemart&view=payeddownloads&task=deleteproductfile",
						  cache: false,		
						  data : { file_id: file_id,product_id:product_id }
						}).done(function(msg) {
							jQuery("#tblfiles").flexReload();
							jQuery("#confirmdialog").dialog("close");	
						}).error(function(msg){	});						
		        },
		        "Cancel" : function() {
		        	jQuery("#confirmdialog").dialog("close");
		        }
		      }
		    });
		  jQuery("#confirmdialog").dialog("open");		
	}
	
</script>


<?php AdminUIHelper::endAdminArea(); ?>
