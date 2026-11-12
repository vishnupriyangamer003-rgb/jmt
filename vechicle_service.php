<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class vechicle_services{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];

		$insurance_from = DateTime::createFromFormat('d/m/Y', $_POST['insurance_from'])->format('Y-m-d');
		$insurance_to = DateTime::createFromFormat('d/m/Y', $_POST['insurance_to'])->format('Y-m-d');
		$fc_from = DateTime::createFromFormat('d/m/Y', $_POST['fc_from'])->format('Y-m-d');
		$fc_to = DateTime::createFromFormat('d/m/Y', $_POST['fc_to'])->format('Y-m-d');
		$tax_from = DateTime::createFromFormat('d/m/Y', $_POST['tax_from'])->format('Y-m-d');
		$tax_to = DateTime::createFromFormat('d/m/Y', $_POST['tax_to'])->format('Y-m-d');

		$sql= "INSERT INTO tbl_vechicle_details (vechicle_name,insurance_number,insurance_from,insurance_to,fc_number,fc_from,fc_to,tax_from,tax_to,created_by,create_date,delete_status) VALUES('".$_POST['vechicle_name']."','".$_POST['insurance_number']."','".$insurance_from."','".$insurance_to."','".$_POST['fc_number']."','".$fc_from."','".$fc_to."','".$tax_from."','".$tax_to."','".$log."','".$curdate."','NDL')";
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
	function vechicle_delete($curdate){
		
	$log=$_SESSION['login_user'];
		$sql= "update tbl_vechicle_details set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where vechicle_id='".$_POST['delid']."'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query){
			//unlink('userdata/images/banner/'.$_POST['photo_name']);
			return true;
		}
		else{
			 return false;
		}
	}
	function vechicle_autobind($curdate){
		$bannerData=array();
		$sql= "select * from tbl_vechicle_details where vechicle_id='".$_POST['vechicle_id']."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		$rows=mysqli_num_rows($exec_query);
		if($rows>0){
			while($row=mysqli_fetch_array($exec_query,MYSQLI_ASSOC)){
				$bannerData[]=str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
	function vechicle_update($curdate){
		$log=$_SESSION['login_user'];

		$insurance_from = DateTime::createFromFormat('d/m/Y', $_POST['insurance_from'])->format('Y-m-d');
		$insurance_to = DateTime::createFromFormat('d/m/Y', $_POST['insurance_to'])->format('Y-m-d');
		$fc_from = DateTime::createFromFormat('d/m/Y', $_POST['fc_from'])->format('Y-m-d');
		$fc_to = DateTime::createFromFormat('d/m/Y', $_POST['fc_to'])->format('Y-m-d');
		$tax_from = DateTime::createFromFormat('d/m/Y', $_POST['tax_from'])->format('Y-m-d');
		$tax_to = DateTime::createFromFormat('d/m/Y', $_POST['tax_to'])->format('Y-m-d');
		
		$sql= "update tbl_vechicle_details set vechicle_name='".$_POST['vechicle_name']."',insurance_number='".$_POST['insurance_number']."',insurance_from='".$insurance_from."',insurance_to='".$insurance_to."',fc_number='".$_POST['fc_number']."',fc_from='".$fc_from."',fc_to='".$fc_to."',tax_from='".$tax_from."',tax_to='".$tax_to."',updated_by='".$log."',update_date='".$curdate."' where vechicle_id='".$_POST['vechicle_id']."'";
	
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
$objVDS=new vechicle_services($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='DEL'){
	$rtnMsg=$objVDS->vechicle_delete($curdate);
}
else if(($_POST['req'] ?? '')=='AUB'){
	$rtnMsg=$objVDS->vechicle_autobind($curdate);
}
else if(($_POST['req'] ?? '')=='UPD'){
	$rtnMsg=$objVDS->vechicle_update($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>