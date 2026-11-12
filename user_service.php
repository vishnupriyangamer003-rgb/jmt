<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class customer_services{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$duplicate=mysqli_query($this->mySQLconn,"select * from tbl_customer where customer_name='".$_POST['customer_name']."' and mblno='".$_POST['mblno']."' and delete_status='NDL'");
		if (mysqli_num_rows($duplicate)>0)
		{			
			return;
		}
		else{
			$sql= "INSERT INTO tbl_customer (customer_name,company_name,gst_no,mblno,email,address,created_by,create_date,delete_status) VALUES('".$_POST['customer_name']."','".$_POST['company_name']."','".$_POST['gst_no']."','".$_POST['mblno']."','".$_POST['email']."','".$_POST['address']."','".$log."','".$curdate."','NDL')";
			
			//  print_r($sql);
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			if($exec_query){
				// $final_dest='userdata/images/addingfiles';
				// if(is_dir( $final_dest)==FALSE){
				// 	mkdir($final_dest,0777,TRUE);
				// }
				// copy('temp/'.$_POST['photo_name'],$final_dest.'/'.$_POST['photo_name']);
				return true;
			}
			else{
				return false;
			}
		}
	}
	function customer_delete($curdate){		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_customer set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where customer_id='".$_POST['delid']."'";
	//    print_r($sql);
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			//unlink('userdata/images/banner/'.$_POST['photo_name']);
			return true;
		}
		else{
			 return false;
		}
	}
	function customer_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_customer where customer_id='".$_POST['customer_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	function customer_update($curdate){
		$log=$_SESSION['login_user'];

		$sql= "update tbl_customer set customer_name='".$_POST['customer_name']."',company_name='".$_POST['company_name']."',gst_no='".$_POST['gst_no']."',mblno='".$_POST['mblno']."',email='".$_POST['email']."',address='".$_POST['address']."',updated_by='".$log."',update_date='".$curdate."' where customer_id='".$_POST['customer_id']."'";
	// print_r($sql);
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			// if($_POST['photo_new_name']!=''){
			// 	$final_dest='userdata/images/addingfiles';
			// 	 if(is_dir( $final_dest)==FALSE){
			// 		mkdir($final_dest,0777,TRUE);
			// 	}
			// 	copy('temp/'.$_POST['photo_new_name'],$final_dest.'/'.$_POST['photo_new_name']);
			// 	//unlink('userdata/images/banner/'.$_POST['photo_old_name']);
			// }
			return true;
		}
		else{
			 return false;
		}
	}
		
}		
$objVDS=new customer_services($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='CUSTOMERDEL'){
	$rtnMsg=$objVDS->customer_delete($curdate);
}
else if(($_POST['req'] ?? '')=='CUSTOMERAUB'){
	$rtnMsg=$objVDS->customer_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='CUSTOMERUPD'){
	$rtnMsg=$objVDS->customer_update($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>