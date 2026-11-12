<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class type_services{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$sql= "INSERT INTO tbl_staff_type (name,created_by,create_date) VALUES('".$_POST['emp_type_name']."','".$log."','".$curdate."')";
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
	function type_delete($curdate){
		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_staff_type set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where id='".$_POST['delid']."'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			//unlink('userdata/images/banner/'.$_POST['photo_name']);
			return true;
		}
		else{
			 return false;
		}
	}
	function type_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_staff_type where id='".$_POST['type_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	function type_update($curdate){
		$log=$_SESSION['login_user'];
		$sql= "update tbl_staff_type set name='".$_POST['emp_type_name']."',updated_by='".$log."',update_date='".$curdate."' where id='".$_POST['type_id']."'";
	
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
$objVDS=new type_services($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADD_TYPE'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='TYPEDEL'){
	$rtnMsg=$objVDS->type_delete($curdate);
}
else if(($_POST['req'] ?? '')=='TYPE_AUB'){
	$rtnMsg=$objVDS->type_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='UPDATE_TYPE'){
	$rtnMsg=$objVDS->type_update($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>