<?php
/*------------------------------------------------------------------------
# payeddownloads - 
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
$document->addScript(JURI::root().'media/system/js/datetimeformat.js?ver=1' );

$document->addScript(JURI::root().'media/system/js/jquery.jqplot.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.logAxisRenderer.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.logAxisRenderer.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.logAxisRenderer.min.js?ver=1' );

$document->addScript(JURI::root().'media/system/js/plugins/jqplot.logAxisRenderer.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.canvasTextRenderer.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.canvasAxisLabelRenderer.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.canvasAxisTickRenderer.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.dateAxisRenderer.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.cursor.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.categoryAxisRenderer.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.barRenderer.min.js?ver=1' );
$document->addScript(JURI::root().'media/system/js/plugins/jqplot.highlighter.min.js?ver=1' );



$document->addStyleSheet(JURI::root().'media/system/js/jquery.jqplot.min.css');
$document->addStyleSheet(JURI::root().'media/system/css/shCoreDefault.min.css');
$document->addStyleSheet(JURI::root().'media/system/css/shThemejqPlot.min.css');

	    
    //<script class="include" type="text/javascript" src="../jquery.jqplot.min.js"></script>
    //<script type="text/javascript" src="syntaxhighlighter/scripts/shCore.min.js"></script>
    //<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    //<script type="text/javascript" src="syntaxhighlighter/scripts/shBrushXml.min.js"></script>


jimport('joomla.environment.browser');
// Invoke JBrowser
$browser = JBrowser::getInstance();
// Get the browser type
$browserType = $browser->getBrowser();
// Get the browser version
$browserVersion = $browser->getMajor();

if($browserType == 'msie') {
	if($browserVersion < 7) {
		//echo "<html class=\"no-js ie6 oldie\" lang=\"en\">";
	}
	if($browserVersion = 7) {
		//echo "<html class=\"no-js ie7 oldie\" lang=\"en\">";
	}
	if($browserVersion = 8) {
		//echo "<html class=\"no-js ie8 oldie\" lang=\"en\">";
	}
	if($browserVersion = 9) {
		$document->addStyleSheet(JURI::root().'media/system/js/excanvas.js');
	}
} else {
	//echo "<html class=\"no-js\" lang=\"en\">";
}

	//<link class="include" rel="stylesheet" type="text/css" href="../jquery.jqplot.min.css" />
    //<link rel="stylesheet" type="text/css" href="examples.min.css" />
    //<link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shCoreDefault.min.css" />
    //<link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shThemejqPlot.min.css" />  
  	//<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->  
?>

<style type="text/css">
	.timeremainer{
		width:180px;		
		height:5px;
		padding-top:0px !important;
		padding-bottom:0px !important;
		
	}
	.unit{
		width:6px;
		background-color:#000080;
		height:5px;
		float:left;
		padding:0px !important;		
		
	}
	.jqplot-point-label {white-space: nowrap;}
/*    .jqplot-yaxis-label {font-size: 14pt;}*/
/*    .jqplot-yaxis-tick {font-size: 7pt;}*/

    div.jqplot-target {
        height: 400px;
        width: 600px;
        margin-right: 5px;
    }
</style>
<div id="confirmdialog" title="Basic dialog" style="display:none;"></div>



<div id="editactivation" title="Edit activation" style="display:none;">	   
   		<table>
   			<tr><td>Expiration Date</td><td><input type="text" id="txtactivationdate" /></td></tr>
   			<tr><td></td><td><input type="button" value="Save" id="btnsave" onclick="saveactivation()"/></td></tr>   			
   		</table>					
</div>

<table>
	<tr><td colspa="2"><table id="tblfiles" style="display:"></table></td></tr>
</table>
<br>
<table>
	<tr><td><div class="example-plot" id="chart1"></div></td><td><div class="example-plot" id="chart4"></div></td></tr>
	<tr><td><div class="example-plot" id="chart2"></div></td><td><div class="example-plot" id="chart5"></div></td></tr>
	<tr><td><div class="example-plot" id="chart3"></div></td><td><div class="example-plot" id="chart6"></div></td></tr>
</table>



<script type="text/javascript">
	function createBarchart(chart_id,title,data){
		var line3 = eval(data);	 
	    var plot3 = jQuery.jqplot(chart_id, [line3], {
	      series:[{renderer:jQuery.jqplot.BarRenderer}],
	      title:title,	      
	      axes: {
	        xaxis: {
	          renderer: jQuery.jqplot.CategoryAxisRenderer,
	          label: 'Products',
	          labelRenderer: jQuery.jqplot.CanvasAxisLabelRenderer,
	          tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer,
	          tickOptions: {
	              angle: 30,
	              fontFamily: 'Courier New',
	              fontSize: '9pt'
	          }
	           
	        },
	        yaxis: {
	          label: 'Downloads',
	          labelRenderer: jQuery.jqplot.CanvasAxisLabelRenderer
	        }
	      }
	    }).replot();	   
	}
	
	function createLinechart(chart_id,title,data){
		var line1=eval(data);		
			var plot1 = jQuery.jqplot(chart_id, [line1], {
		      title:title,
		      axes:{
		        xaxis:{
		          label: 'Date',
		          renderer:jQuery.jqplot.DateAxisRenderer,
		          tickOptions:{
		            formatString:'%b&nbsp;%#d'
		          }
		        },
		        yaxis:{
		          label: 'Downloads',
		          labelRenderer: jQuery.jqplot.CanvasAxisLabelRenderer		          
		        }
		      },
		      highlighter: {
		        show: true,
		        sizeAdjust: 7.5
		      },
		      cursor: {
		        show: false
		      }
		  }).replot();		  
	}
	
	function createdblLinechart(chart_id,title,line1,line2){
			
		 	oline1=eval(line1);		
			oline2=eval(line2);
			//alert(line1);
			//alert(line2);	
			//[['2012-10-15',2],['2012-10-16',4],['2012-10-17',5]]
			//[['Hand Shovel',0],['Ladder',6],['Hammer',5],['Nice Saw',0]]	
			var plot1 = jQuery.jqplot(chart_id, [oline1,oline2], {
		      title:title,
		      axes:{		      	
		        xaxis:{
		          label: 'Date',		          
		          renderer:jQuery.jqplot.DateAxisRenderer,
		          tickOptions:{
		            formatString:'%b&nbsp;%#d'
		          }
		        },
		        yaxis:{
		          label: 'Downloads or visits',
		          labelRenderer: jQuery.jqplot.CanvasAxisLabelRenderer		
		        }
		      },
		      highlighter: {
		        show: true,
		        sizeAdjust: 7.5
		      },
		      cursor: {
		        show: false
		      }
		  }).replot();		  
	}
	
	
	jQuery(function($) {
			
		
	    $("#txtactivationdate").datepicker({ dateFormat: 'yy/mm/dd' });
	    $("#txtexpirationdate").datepicker({ dateFormat: 'yy/mm/dd' });
	    
	    
    		
		
		$("#editactivation").dialog({
				height:150,
				width:400,
				modal: true,
				autoOpen: false,
				title:'Edit link',
				close: function(ev, ui) 
					{ 												
						//jQuery('#payment_date .trSelected').removeClass('trSelected');
						//jQuery(this).close(); 
					}
				});		
	
											
		$("#tblfiles").flexigrid({
				url: 'index.php?option=com_virtuemart&view=payeddownloads&task=getActiveLinks&page=1&format=raw',
				dataType: 'json',								 
				singleSelect:true,			
				colModel : [				
					{display: 'Activation code', name : 'id', width : 100, sortable : true, align: 'center',hide:true},
					{display: 'File id', name : 'file_id', width : 180, sortable : true, align: 'center',hide:true},
					{display: 'Order id', name : 'order_id', width : 180, sortable : true, align: 'center',hide:true},					
					{display: 'Product id', name : 'virtuemart_product_id', width : 180, sortable : true, align: 'left',hide:true},
					{display: 'Product Name', name : 'product_name', width : 120, sortable : true, align: 'left'},
					{display: 'Password', name : 'password', width : 100, sortable : true, align: 'left'},
					{display: 'Registration Date', name : 'reg_date', width : 120, sortable : true, align: 'right'},
					{display: 'Expiration Date', name : 'end_date', width : 120, sortable : true, align: 'right'},					
					{display: 'Days Remaining', name : 'days_remaining', width : 120, sortable : true, align: 'right'},
					{display: 'Downloads', name : 'number_of_downloads', width : 120, sortable : true, align: 'right'},
					{display: 'Order number', name : 'order_number', width : 120, sortable : true, align: 'right'},																						
					{display: 'Remaining', name : 'timeremainer', width : 200, sortable : true, align: 'right'},					
					{display: 'Edit', name : 'editactivation', width : 120, sortable : true, align: 'right'}
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
				title: 'Active links',
				useRp: true,
				rp: 15,
				showTableToggleBtn: true,
				width: '100%',		
				height: '100%',											
				onSuccess:loadEvents,
				resizable :true
			});		
		
				
		$.getJSON('index.php?option=com_virtuemart&view=payeddownloads&task=getProductsWithFiles&format=raw', function(data){
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
	
	
	function loadEvents(obj){
		var icounter=0;
		jQuery('#tblfiles tr').each(function() {
		    var data = jQuery(this).find("td").eq(8).text();
		    var control = "#timeremainer_"+jQuery(this).find("td").eq(0).text();
		
		    if(data>0)
		    {
		    	for(i=0;i<data;i++){
		    		jQuery(control).append("<div class='unit'>&nbsp;</div>");
		    	}
		    }		    
		    
		    icounter++;
		});
		
		initializecharts();
	}
	
	
	
	function progressHandlingFunction(data){
		alert(data);
	}
	
	
	function getfile(file_id){		
		window.open('index.php?option=com_virtuemart&view=payeddownloads&task=getfile&file_id='+file_id+'&format=raw', 'downloader', '');
	}
	
	
	
	var file_id,password,end_date;
	
	function fneditactivation(obj){		
		
		file_id=jQuery(jQuery(obj).closest("tr")).find("td").eq(1).text();
		password=jQuery(jQuery(obj).closest("tr")).find("td").eq(5).text();
		end_date=jQuery(jQuery(obj).closest("tr")).find("td").eq(7).text();
				
		jQuery("#txtactivationdate").val(end_date);		
		jQuery("#editactivation").dialog("open");		
		jQuery('#editactivation').unbind();		
		
	}

	function saveactivation(){
		
		end_date = jQuery("#txtactivationdate").val();
		
		jQuery.ajax({
				  type: "POST",							  
				  url: "index.php?option=com_virtuemart&view=payeddownloads&task=saveActivation&format=raw",
				  cache: false,
				  data : {file_id:file_id,password:password,end_date:end_date}
				}).done(function(data) {		
					jQuery("#editactivation").dialog("close");
					jQuery("#tblfiles").flexReload();							
					//var line3 = data;																														
					//createdblLinechart("chart4","Visits and downloads per day",line1,line3);												
																												  
				}).error(function(data){
					alert(msg);					
				});			
	}



		
function initializecharts(){
		
		timeUnit = 'M';
		
		jQuery.ajax({
				  type: "POST",							  
				  url: "index.php?option=com_virtuemart&view=payeddownloads&task=getDownloadsPerDay&format=raw",
				  cache: false,
				  data : {timeUnit:timeUnit}
				}).done(function(data) {
					var line1 = data;										    
					createLinechart("chart1","Downloads per day",data);
										
					jQuery.ajax({
								  type: "POST",							  
								  url: "index.php?option=com_virtuemart&view=payeddownloads&task=getDownloadsPerProduct&format=raw",
								  cache: false,
								  data : {timeUnit:timeUnit}
								}).done(function(data) {									
									var line2 = data;	    							    								    				    				    
									createBarchart("chart2","Downloads per product",data);		
									
									jQuery.ajax({
											  type: "POST",							  
											  url: "index.php?option=com_virtuemart&view=payeddownloads&task=getVisitsPerDate&format=raw",
											  cache: false,
											  data : {timeUnit:timeUnit}
											}).done(function(data) {									
												var line3 = data;																										
												createdblLinechart("chart4","Visits and downloads per day",line1,line3);												
																																			  
											}).error(function(data){
												alert(msg);					
											});					
									
																																  
								}).error(function(data){
									alert(msg);					
								});															  
				}).error(function(data){
					alert(msg);					
				});
				
							
}	
//createdblLinechart
</script>


<?php AdminUIHelper::endAdminArea(); ?>
