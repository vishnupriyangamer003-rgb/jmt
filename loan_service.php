<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class loan_services{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$sql= "INSERT INTO tbl_loan_details (loan_name,amount,created_by,create_date) VALUES('".$_POST['loan_name']."','".$_POST['amount']."','".$log."','".$curdate."')";
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
	function loan_delete($curdate){
		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_loan_details set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where id='".$_POST['delid']."'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			//unlink('userdata/images/banner/'.$_POST['photo_name']);
			return true;
		}
		else{
			 return false;
		}
	}
	function loan_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_loan_details where id='".$_POST['loan_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}

	function loan_update($curdate){
		$log=$_SESSION['login_user'];
		$sql= "update tbl_loan_details set loan_name='".$_POST['loan_name']."',amount='".$_POST['amount']."',updated_by='".$log."',update_date='".$curdate."' where id='".$_POST['loan_id']."'";
	
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
$objVDS=new loan_services($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->loan_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->loan_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->loan_update($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>