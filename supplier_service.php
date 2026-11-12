<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class supplier_services{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$duplicate=mysqli_query($this->mySQLconn,"select * from tbl_supplier where supplier_name='".$_POST['supplier_name']."' and mblno='".$_POST['mblno']."'");
		if (mysqli_num_rows($duplicate)>0)
		{			
			return;
		}
		else{
			$sql= "INSERT INTO tbl_supplier (supplier_name,company_name,gst_no,mblno,email,address,created_by,create_date,delete_status) VALUES('".$_POST['supplier_name']."','".$_POST['company_name']."','".$_POST['gst_no']."','".$_POST['mblno']."','".$_POST['email']."','".$_POST['address']."','".$log."','".$curdate."','NDL')";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			if($exec_query){
				return true;
			}
			else{
				return false;
			}
		}
	}
	function add_insert_other($curdate){
		$log=$_SESSION['login_user'];
		$duplicate=mysqli_query($this->mySQLconn,"select * from tbl_supplier where supplier_name='".$_POST['supplier_name']."' and mblno='".$_POST['mblno']."'");
		if (mysqli_num_rows($duplicate)>0)
		{			
			return;
		}
		else{
			$sql= "INSERT INTO tbl_supplier (supplier_name,company_name,gst_no,mblno,email,address,created_by,create_date,delete_status) VALUES('".$_POST['supplier_name']."','".$_POST['company_name']."','".$_POST['gst_no']."','".$_POST['mblno']."','".$_POST['email']."','".$_POST['address']."','".$log."','".$curdate."','NDL')";
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			if($exec_query){
				return true;
			}
			else{
				return false;
			}
		}
	}
	function supplier_delete($curdate){		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_supplier set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where supplier_id='".$_POST['delid']."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			return true;
		}
		else{
			 return false;
		}
	}
	function supplier_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_supplier where supplier_id='".$_POST['supplier_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	function supplier_update($curdate){
		$log=$_SESSION['login_user'];

		$sql= "update tbl_supplier set supplier_name='".$_POST['supplier_name']."',company_name='".$_POST['company_name']."',gst_no='".$_POST['gst_no']."',mblno='".$_POST['mblno']."',email='".$_POST['email']."',address='".$_POST['address']."',updated_by='".$log."',update_date='".$curdate."' where supplier_id='".$_POST['supplier_id']."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			return true;
		}
		else{
			 return false;
		}
	}
		
}		
$objVDS=new supplier_services($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='SUPPLIERDEL'){
	$rtnMsg=$objVDS->supplier_delete($curdate);
}
else if(($_POST['req'] ?? '')=='SUPPLIERAUB'){
	$rtnMsg=$objVDS->supplier_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='SUPPLIERUPD'){
	$rtnMsg=$objVDS->supplier_update($curdate);
}
else if(($_POST['supplier_req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert_other($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>