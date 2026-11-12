<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class uom_services{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$sql= "INSERT INTO tbl_uom (uom_name,created_by,create_date) VALUES('".$_POST['uom_name']."','".$log."','".$curdate."')";
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
	function uom_delete($curdate){
		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_uom set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where uom_id='".$_POST['delid']."'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			//unlink('userdata/images/banner/'.$_POST['photo_name']);
			return true;
		}
		else{
			 return false;
		}
	}
	function uom_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_uom where uom_id='".$_POST['uom_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	function uom_update($curdate){
		$log=$_SESSION['login_user'];
		$sql= "update tbl_uom set uom_name='".$_POST['uom_name']."',updated_by='".$log."',update_date='".$curdate."' where uom_id='".$_POST['uom_id']."'";
	
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
$objVDS=new uom_services($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->uom_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->uom_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->uom_update($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>