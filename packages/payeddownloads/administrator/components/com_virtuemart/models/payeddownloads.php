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
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library

jimport( 'joomla.application.component.model');
if(!class_exists('VmModel'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmmodel.php');
/**
 * Offers Model
 */
class VirtueMartModelPayeddownloads extends VmModel
{
	function __construct()
	{
	
		//ekteleite prin ton viewer kai meta ton controler
		parent::__construct();
	
		//$array = JRequest::getVar('cid',  0, '', 'array');
		//$this->setId((int)$array[0]);
	
	}
	
	/**
	 * Method to set the hello identifier
	 *
	 * @access	public
	 * @param	int Hello identifier
	 * @return	void
	 */
	/*function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= array();
	}*/
	
	var $_data			= null;
	
	function getproductfiles(){
		$db = JFactory::getDBO();
						
		$page = 1; // The current page
		$sortname = 'id'; // Sort column
		$sortorder = 'asc'; // Sort order
		$qtype = ''; // Search column
		$query = ''; // Search string
		// Get posted data
			$jinput = JFactory::getApplication()->input;		
			$page = $jinput->get('page','','INT');
		
			$sortname = $jinput->get('sortname','','STRING');
		
			$sortorder = $jinput->get('sortorder','','STRING');
		
			$qtype = $jinput->get('qtype','','STRING');
		
			$query = $jinput->get('query','','STRING');
		
			$rp = $jinput->get('rp');
					
		// Setup sort and search SQL using posted data
		$sortSql = ($sortname != '' && $sortorder != '') ? " order by $sortname $sortorder" : '';
		if (strpos($query, '%') !== false) {
			$searchSql = ($qtype != '' && $query != '') ? "where $qtype like '$query'" : '';
		}
		else 
		{
			$searchSql = ($qtype != '' && $query != '') ? "where $qtype = '$query'" : '';
		}
		// Get total count of records
		$sql = "select count(*)
				from #__virtuemart_payeddownload_productfiles t1
				inner join #__virtuemart_products_en_gb t2 on t1.virtuemart_product_id=t2.virtuemart_product_id
		$searchSql";
		
		$db->setQuery($sql);
		$total = $db->loadResult();
				
		$pageStart = ($page-1)*$rp;
		$limitSql = "limit $pageStart, $rp";		
		$data = array();
		$data['page'] = $page;
		$data['total'] = $total;
		$data['rows'] = array();
		//$sql = "select id, startdate, enddate, product_id, discount_amount,discount_percent
		$sql = "select t1.id,
					   t2.product_name,
					   t1.virtuemart_product_id,
					   t1.file_size,
					   t1.file_name,
					   t1.file_type,
					   t1.file_blob,
					   t1.reg_date
		from #__virtuemart_payeddownload_productfiles t1
		inner join #__virtuemart_products_en_gb t2 on t1.virtuemart_product_id=t2.virtuemart_product_id
		$searchSql
		$sortSql
		$limitSql";
		
		//echo $sql;
		//die();
		$db->setQuery($sql);
		$results = $db->loadObjectList();
		if(count($results)>0){			
			foreach( $results as $row ){						
			
				$reg_date = new DateTime($row->reg_date);
				$reg_date =  $reg_date->format('Y/m/d H:i:s');
				//die();
				$data['rows'][] = array(
						'id' => $row->id,
						'cell' => array($row->id, 
										$row->product_name,
										$row->virtuemart_product_id, 
										$row->file_size, 
										$row->file_name, 
										$row->file_type,									
										$reg_date,
										"<input type='button' value='$row->file_name' onclick='getfile($row->id)'>",
										"<input type='button' value='delete' onclick='deleteproductfile($row->id,$row->virtuemart_product_id)'>"									
									));			
															
			
			}
		}
		return json_encode($data);		
	}


	function getproducts($noLimit=false){
			$quer= 'select t1.virtuemart_product_id, t1.product_name from #__virtuemart_products_en_gb t1
						inner join #__virtuemart_products t2 on t1.virtuemart_product_id = t2.virtuemart_product_id
					where published=1 ';
		//echo $quer;
		//die();
		if ($noLimit) {
		    $this->_data = $this->_getList($quer);
		}
		else {
		    $this->_data = $this->_getList($quer, $this->getState('limitstart'), $this->getState('limit'));
		}

		if(count($this->_data) >0){
			$this->_total = $this->_getListCount($quer);
		}

		//print_r($this->_data);
		return json_encode($this->_data);
		
	}
	
	function getProductsWithFiles($noLimit=false){
			$quer= 'select t1.virtuemart_product_id, t1.product_name from #__virtuemart_products_en_gb t1
						inner join #__virtuemart_products t2 on t1.virtuemart_product_id = t2.virtuemart_product_id
						inner join #__virtuemart_payeddownload_productfiles t3 on t3.virtuemart_product_id = t2.virtuemart_product_id
					where published=1 ';
		//echo $quer;
		//die();
		if ($noLimit) {
		    $this->_data = $this->_getList($quer);
		}
		else {
		    $this->_data = $this->_getList($quer, $this->getState('limitstart'), $this->getState('limit'));
		}

		if(count($this->_data) >0){
			$this->_total = $this->_getListCount($quer);
		}

		//print_r($this->_data);
		return json_encode($this->_data);
	}
	
	public function uploadfile(){		 
		 $input = new Jinput;
		 $virtuemart_product_id = $input->get('product');
		 
		 $fileName = $_FILES['file']['name'];
		 $tmpName =  $_FILES['file']['tmp_name'];
		 $fileSize = $_FILES['file']['size'];
		 $fileType = $_FILES['file']['type'];
		 $fp = fopen($tmpName, 'r');
		 $content = fread($fp, filesize($tmpName));	
		 fclose($fp);
		 
		 $data =new stdClass();
		 $data->id = null;
		 $data->virtuemart_product_id = $virtuemart_product_id; 
		 $data->file_size = $fileSize;
		 $data->file_name = $fileName;
		 $data->file_type = $fileType;
		 $data->file_blob = $content;
		 $data->reg_date = date("Y-m-d H:i:s");
					
		 $db = JFactory::getDBO();
		 $db->insertObject( '#__virtuemart_payeddownload_productfiles', $data, 'id' );
		 return $db->getErrorMsg();
	}
	
	public function getfile(){
		//file_id,password		
		
		$jinput = JFactory::getApplication()->input;		
		$file_id = $jinput->get('file_id','','INT');
		//$password = $jinput->get('password','','STRING');
		
		$sql = "select * from #__virtuemart_payeddownload_productfiles where id=$file_id";
		$db = JFactory::getDBO();		
		$db->setQuery($sql);
		$results = $db->loadObjectList();
		$file_size = $results[0]->file_size;
		$file_type = $results[0]->file_type;
		$file_name = $results[0]->file_name;
		$file_blob = $results[0]->file_blob;
		
						
		header('Content-Description: File Transfer');			
		header("Content-Type: $file_type");
		header("Content-Disposition: attachment; filename= $file_name");
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . strlen($file_blob));
			 	
		ob_clean();
		flush();
		 
		echo $file_blob;
		exit;
	}
	
	public function getfilebypassword(){
		$jinput = JFactory::getApplication()->input;
		$password = $jinput->get('password', null, "STRING");
		$file_id = $jinput->get('file_id', null, "INTEGER");
		
		$sql = "select t3.id as file_id,
						t3.file_size,
						t3.file_type,
						t3.file_name,
						t3.file_blob,
						t1.password 
					from #__virtuemart_payeddownload_orderfilepasswords t1
					inner join #__virtuemart_order_items t2 on t1.order_id=t2.virtuemart_order_id
					inner join #__virtuemart_payeddownload_productfiles t3 on t3.virtuemart_product_id=t2.virtuemart_product_id
				where t1.password='$password' and t1.end_date>now() and t3.id =$file_id";
				
		//echo $sql;
		//die();	
		$db = JFactory::getDBO();			
		$db->setQuery($sql);
		$results = $db->loadObjectList();
		
		if(count($results)>0){
			$this->savedownload($results[0]->file_id,$results[0]->password);					
			$file_size = $results[0]->file_size;
			$file_type = $results[0]->file_type;
			$file_name = $results[0]->file_name;
			$file_blob = $results[0]->file_blob;
							 
			header("Content-length: $file_size");			 
			header("Content-type: $file_type");
			header("Content-Disposition: attachment; filename= $file_name");	 		
			return $file_blob;
		}
	}
	
	public function savedownload($file_id,$password){
		 $data =new stdClass();
		 $data->id = null;
		 $data->file_id = $file_id; 
		 $data->reg_date = date("Y-m-d H:i:s");
		 $data->ip_address = $_SERVER['REMOTE_ADDR'];		 
		 $data->password = $password;
					
		 $db = JFactory::getDBO();
		 $db->insertObject( '#__virtuemart_payeddownload_downloads', $data, 'id' );
		 return $db->getErrorMsg();
	}
	
	public function deleteproductfile(){
		$jinput = JFactory::getApplication()->input;
		$file_id = $jinput->get('file_id', null, "INTEGER");
		$id = $jinput->get('file_id', null, "INTEGER");
		
		$db = JFactory::getDBO();
		  $query = " DELETE FROM #__virtuemart_payeddownload_productfiles WHERE id = '$file_id' ";
		  $db->setQuery($query);
		  $db->query();
	}
	
	public function createorderfilepasswords($order_id,$password,$end_date){				 				 
		 $data =new stdClass();
		 $data->id = null;
		 $data->order_id = $order_id; 
		 $data->password = $password;
		 $data->end_date = $end_date;
		 $data->reg_date = date("Y-m-d H:i:s");
					
		 $db = JFactory::getDBO();
		 $db->insertObject( '#__virtuemart_payeddownload_orderfilepasswords', $data, 'id' );
		 return $db->getErrorMsg();
	}
	
	public function getProductfilesByOrderId($order_id){						
		$db = JFactory::getDBO();
		$query = "select t3.id as file_id, t3.file_name, t3.file_size 
					from #__virtuemart_order_items t2 
					inner join #__virtuemart_payeddownload_productfiles t3 on t3.virtuemart_product_id=t2.virtuemart_product_id 
					where t2.virtuemart_order_id=$order_id
		  		";
		//echo $query;
		//die();  
		$db->setQuery($query);
		$results = $db->loadObjectList();
		
		return $results;							                                             
	}
	
	public function getActiveLinks()
	{
		$db = JFactory::getDBO();
						
		$page = 1; // The current page
		$sortname = 'id'; // Sort column
		$sortorder = 'asc'; // Sort order
		$qtype = ''; // Search column
		$query = ''; // Search string
		// Get posted data
			$jinput = JFactory::getApplication()->input;		
			$page = $jinput->get('page','','INT');
		
			$sortname = $jinput->get('sortname','','STRING');
		
			$sortorder = $jinput->get('sortorder','','STRING');
		
			$qtype = $jinput->get('qtype','','STRING');
		
			$query = $jinput->get('query','','STRING');
		
			$rp = $jinput->get('rp');
					
		// Setup sort and search SQL using posted data
		$sortSql = ($sortname != '' && $sortorder != '') ? " order by $sortname $sortorder" : '';
		if (strpos($query, '%') !== false) {
			$searchSql = ($qtype != '' && $query != '') ? "where $qtype like '$query'" : '';
		}
		else 
		{
			$searchSql = ($qtype != '' && $query != '') ? "where $qtype = '$query'" : '';
		}
		// Get total count of records
		$sql = "select count(*)
				from #__virtuemart_payeddownload_orderfilepasswords t1 
				left join #__virtuemart_order_items t2 on t1.order_id=t2.virtuemart_order_id 
				inner join #__virtuemart_payeddownload_productfiles t3 on t3.virtuemart_product_id=t2.virtuemart_product_id 
				inner join #__virtuemart_products_en_gb t4 on t4.virtuemart_product_id=t2.virtuemart_product_id 	
				inner join #__virtuemart_orders t5 on t5.virtuemart_order_id=t2.virtuemart_order_id 
				where t1.end_date>now() 
		$searchSql";
		
		$db->setQuery($sql);
		$total = $db->loadResult();
				
		$pageStart = ($page-1)*$rp;
		$limitSql = "limit $pageStart, $rp";		
		$data = array();
		$data['page'] = $page;
		$data['total'] = $total;
		
		$data['rows'] = array();
				
		$sql = "select CONCAT(t3.id,t1.order_id) id,
					t3.id as file_id,
					t1.order_id,
					t3.virtuemart_product_id,
					t4.product_name,				
					t1.password,
					t1.end_date,			
					DATEDIFF(t1.end_date,now()) as days_remaining,
					t1.reg_date,
					(select count(t5.id) from #__virtuemart_payeddownload_downloads t5 where t5.file_id=t3.id and t5.password=t1.password) number_of_downloads,
					t5.order_number
				from #__virtuemart_payeddownload_orderfilepasswords t1 
				left join #__virtuemart_order_items t2 on t1.order_id=t2.virtuemart_order_id 
				inner join #__virtuemart_payeddownload_productfiles t3 on t3.virtuemart_product_id=t2.virtuemart_product_id 
				inner join #__virtuemart_products_en_gb t4 on t4.virtuemart_product_id=t2.virtuemart_product_id 		
				inner join #__virtuemart_orders t5 on t5.virtuemart_order_id=t2.virtuemart_order_id			
				$searchSql
				$sortSql
				$limitSql";
		
		//echo $sql;
		//die();		
		$db->setQuery($sql);
		$results = $db->loadObjectList();
					
		
		if(count($results)>0)
		{
			foreach( $results as $row ){
				
										
				if($row->days_remaining>=0){
					$activation = "Deactivate";
				}					
				else {
					$activation = "Activate";
				}
				
				$reg_date = new DateTime($row->reg_date);
				$reg_date =  $reg_date->format('Y/m/d');
				
				$end_date = new DateTime($row->end_date);
				$end_date =  $end_date->format('Y/m/d');
				
				$data['rows'][] = array(
						'id' => $row->id,
						'cell' => array($row->id,
										$row->file_id,
										$row->order_id,
										$row->virtuemart_product_id,
										$row->product_name,
										$row->password,
										$reg_date,
										$end_date,
										$row->days_remaining,
										$row->number_of_downloads,																													
										$row->order_number,
										"<div id='timeremainer_$row->id' class='timeremainer'></div>",
										"<input type='button' value='edit' onclick='fneditactivation(this)'>"
									));																	
				
			}
		}
		return json_encode($data);		
									
	}
	
	public function getDownloadsPerDay(){		
		$db = JFactory::getDBO();				
		$sql = "select  DATE_FORMAT(reg_date,'%Y-%m-%d') as reg_date, 
				count(*) number_of_downloads
				from #__virtuemart_payeddownload_downloads
				group by DATE_FORMAT(reg_date,'%Y-%m-%d')";
				
		$db->setQuery($sql);
		$results = $db->loadObjectList();
		
		$data="[";
		$icounter=0;
		foreach ($results as $row){
			if($icounter==0)					
				$data .= "['".$row->reg_date."',".$row->number_of_downloads."]";
			else	
				$data .= ",['".$row->reg_date."',".$row->number_of_downloads."]";
			
			$icounter++;				
		}					
		
		$data.="]";	
		
		return $data;						
	}
	
	public function getDownloadsPerProduct(){		
		$db = JFactory::getDBO();
		$sql = "select t1.product_name, 
					t2.file_name,
					t2.id as file_id,
					(select count(*) from #__virtuemart_payeddownload_downloads t3 where t3.file_id=t2.id) as downloads
				from #__virtuemart_products_en_gb t1
				inner join #__virtuemart_payeddownload_productfiles t2 on t2.virtuemart_product_id= t1.virtuemart_product_id";
				
		$db->setQuery($sql);
		$results = $db->loadObjectList();
		
		$data="[";
		$icounter=0;
		foreach ($results as $row){
			if($icounter==0)					
				$data .= "['".$row->product_name."',".$row->downloads."]";
			else	
				$data .= ",['".$row->product_name."',".$row->downloads."]";
			
			$icounter++;				
		}					
				
		$data.="]";	
		
		return $data;						
	}  
	
	public function getVisitsPerDate(){
		$db = JFactory::getDBO();
		$sql = "select DATE_FORMAT(reg_date,'%Y-%m-%d') visit_date, 
						count(id) number_of_visits
						from #__virtuemart_payeddownload_visits
						group by DATE_FORMAT(reg_date,'%Y-%m-%d')";
				
		$db->setQuery($sql);
		$results = $db->loadObjectList();
		
		$data="[";
		$icounter=0;
		foreach ($results as $row){
			if($icounter==0)					
				$data .= "['".$row->visit_date."',".$row->number_of_visits."]";
			else	
				$data .= ",['".$row->visit_date."',".$row->number_of_visits."]";
			
			$icounter++;				
		}					
				
		$data.="]";	
		
		return $data;
	}
	

	public function savevisit(){		
		
		jimport('joomla.environment.browser');
        $doc =& JFactory::getDocument();
        $browser = &JBrowser::getInstance();
        $browserType = $browser->getBrowser();
        $browserVersion = $browser->getMajor();
		
		 $data =new stdClass();
		 $data->id = null;
		 $data->ip = $_SERVER['REMOTE_ADDR']; 
		 $data->reg_date = date("Y-m-d H:i:s");
		 $data->browser = $browser." ".$browserVersion;
		 //$data->page_url = $_SERVER['REQUEST_URI'];
		 $data->platform = $browser->getPlatform();		 		
					
		 $db = JFactory::getDBO();
		 $sqlcheck="select count(id) from #__virtuemart_payeddownload_visits
		 			where ip='$data->ip' and DATE_FORMAT('$data->reg_date','%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')";
							
		 $db->setQuery($sqlcheck);
		 $result = $db->loadResult();
		 
		 if($result==0)
		 {	
		 	$db->insertObject( '#__virtuemart_payeddownload_visits', $data, 'id' );
		 }
		 return $db->getErrorMsg();		
	}
	
	public function saveActivation(){
		$db = JFactory::getDBO();
		$jinput = JFactory::getApplication()->input;	
			
		$file_id = $jinput->get('file_id','','INT');
		$password = $jinput->get('password','','STRING');
		$end_date = $jinput->get('end_date','','DATE');
		
		$query = "update #__virtuemart_payeddownload_orderfilepasswords set end_date ='$end_date' where password='$password'";
		//echo $query;
		//die();
		$db->setQuery($query);
		$db->query();
		return $db->getErrorMsg();
		//Update the record. Third parameter is table id field that will be used to update.
		//$ret = $db->updateObject('#__virtuemart_payeddownload_downloads', $row,'rec_id');
	}

	public function saveNewCustomActivation(){
		
	}
	public function test(){
		return "test success";
	}
}
