<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class pay_services{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		

		$billing_date = DateTime::createFromFormat('d/m/Y', $_POST['billing_date'])->format('Y-m-d');

		$sql= "INSERT INTO tbl_pay_entry (expense_header_id,pay_type,billing_date,amount,remarks,created_by,create_date) VALUES('".$_POST['expense_header_id']."','".$_POST['pay_type']."','".$billing_date."','".$_POST['amount']."','".$_POST['remarks']."','".$log."','".$curdate."')";
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
	function pay_delete($curdate){
		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_pay_entry set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where pay_id='".$_POST['delid']."'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			//unlink('userdata/images/banner/'.$_POST['photo_name']);
			return true;
		}
		else{
			 return false;
		}
	}
	function pay_autobind($curdate){
		$bannerData=array();
		$sql= "select *,date_format(billing_date,'%d/%m/%Y') as billing_date from tbl_pay_entry where pay_id='".$_POST['pay_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	function pay_update($curdate){
		$log=$_SESSION['login_user'];

		$billing_date = DateTime::createFromFormat('d/m/Y', $_POST['billing_date'])->format('Y-m-d');

		$sql= "update tbl_pay_entry set expense_header_id='".$_POST['expense_header_id']."',pay_type='".$_POST['pay_type']."',billing_date='".$billing_date."',amount='".$_POST['amount']."',remarks='".$_POST['remarks']."',updated_by='".$log."',update_date='".$curdate."' where pay_id='".$_POST['pay_id']."'";
	
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
$objVDS=new pay_services($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->pay_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->pay_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->pay_update($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>