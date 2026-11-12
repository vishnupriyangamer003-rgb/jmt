<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');	
class customer_services{
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function esc($v){ return mysqli_real_escape_string($this->mySQLconn, (string)($v ?? '')); }
	function sqlerr(){ $e = mysqli_error($this->mySQLconn); return $e !== '' ? 'SQL error: '.$e : 'SQL error: unknown database error'; }
	// Debug echo: data + duplicate check WITHOUT writing, for POST debug=1
	function debug_insert(){
		$customer_name=$this->esc($_POST['customer_name'] ?? '');
		$mblno=$this->esc($_POST['mblno'] ?? '');
		$vals = array('customer_name'=>$customer_name,'reference_name'=>($this->esc($_POST['reference_name'] ?? '')),
			'company_name'=>($this->esc($_POST['company_name'] ?? '')),'owner_name'=>($this->esc($_POST['owner_name'] ?? '')),
			'state'=>($this->esc($_POST['state'] ?? '')),'gst_no'=>($this->esc($_POST['gst_no'] ?? '')),
			'state_code'=>($this->esc($_POST['state_code'] ?? '')),'mblno'=>$mblno,
			'owner_contact'=>($this->esc($_POST['owner_contact'] ?? '')),'email'=>($this->esc($_POST['email'] ?? '')),
			'address'=>($this->esc($_POST['address'] ?? '')),'reference_details'=>($this->esc($_POST['reference_details'] ?? '')),
			'status'=>($this->esc($_POST['status'] ?? 'Active')));
		$dupSql = "select * from tbl_customer where customer_name='".$customer_name."' and mblno='".$mblno."' and delete_status='NDL'";
		$dup = mysqli_query($this->mySQLconn, $dupSql);
		$dupCount = ($dup !== false) ? (int)mysqli_num_rows($dup) : -1;
		return array('debug'=>true,'post_keys'=>array_keys($_POST),'vals'=>$vals,'dup_sql'=>$dupSql,'dup_count'=>$dupCount,
			'db_error'=>mysqli_error($this->mySQLconn));
	}
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$customer_name=$this->esc($_POST['customer_name'] ?? '');
		$mblno=$this->esc($_POST['mblno'] ?? '');
		$duplicate=mysqli_query($this->mySQLconn,"select * from tbl_customer where customer_name='".$customer_name."' and mblno='".$mblno."' and delete_status='NDL'");
		if($duplicate === false){
			return $this->sqlerr();
		}
		if (mysqli_num_rows($duplicate)>0)
		{			
			return;
		}
		else{
			$sql= "INSERT INTO tbl_customer (customer_name,reference_name,company_name,owner_name,state,gst_no,state_code,mblno,owner_contact,email,address,reference_details,status,created_by,create_date,delete_status) VALUES('".$customer_name."','".$this->esc($_POST['reference_name'] ?? '')."','".$this->esc($_POST['company_name'] ?? '')."','".$this->esc($_POST['owner_name'] ?? '')."','".$this->esc($_POST['state'] ?? '')."','".$this->esc($_POST['gst_no'] ?? '')."','".$this->esc($_POST['state_code'] ?? '')."','".$mblno."','".$this->esc($_POST['owner_contact'] ?? '')."','".$this->esc($_POST['email'] ?? '')."','".$this->esc($_POST['address'] ?? '')."','".$this->esc($_POST['reference_details'] ?? '')."','".$this->esc($_POST['status'] ?? 'Active')."','".$log."','".$curdate."','NDL')";
			//  print_r($sql);
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			if($exec_query === false){
				return $this->sqlerr();
			}
			if($exec_query){

				// $final_dest='userdata/images/addingfiles';
				// if(is_dir( $final_dest)==FALSE){
				// 	mkdir($final_dest,0777,TRUE);
				// }
				// copy('temp/'.$_POST['photo_name'],$final_dest.'/'.$_POST['photo_name']);
				return (int)mysqli_insert_id($this->mySQLconn);
			}
			else{
				return false;
			}
		}
	}


	function add_insert_other($curdate){
		$log=$_SESSION['login_user'];
		$customer_name=$this->esc($_POST['customer_name'] ?? '');
		$mblno=$this->esc($_POST['mblno'] ?? '');
		$duplicate=mysqli_query($this->mySQLconn,"select * from tbl_customer where customer_name='".$customer_name."' and mblno='".$mblno."' and delete_status='NDL'");
		if($duplicate === false){
			return $this->sqlerr();
		}
		if (mysqli_num_rows($duplicate)>0)
		{			
			return;
		}
		else{
			$sql= "INSERT INTO tbl_customer (customer_name,reference_name,company_name,owner_name,state,gst_no,state_code,mblno,owner_contact,email,address,reference_details,status,created_by,create_date,delete_status) VALUES('".$customer_name."','".$this->esc($_POST['reference_name'] ?? '')."','".$this->esc($_POST['company_name'] ?? '')."','".$this->esc($_POST['owner_name'] ?? '')."','".$this->esc($_POST['state'] ?? '')."','".$this->esc($_POST['gst_no'] ?? '')."','".$this->esc($_POST['state_code'] ?? '')."','".$mblno."','".$this->esc($_POST['owner_contact'] ?? '')."','".$this->esc($_POST['email'] ?? '')."','".$this->esc($_POST['address'] ?? '')."','".$this->esc($_POST['reference_details'] ?? '')."','".$this->esc($_POST['status'] ?? 'Active')."','".$log."','".$curdate."','NDL')";
			//  print_r($sql);
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			if($exec_query === false){
				return $this->sqlerr();
			}
			if($exec_query){

				// $final_dest='userdata/images/addingfiles';
				// if(is_dir( $final_dest)==FALSE){
				// 	mkdir($final_dest,0777,TRUE);
				// }
				// copy('temp/'.$_POST['photo_name'],$final_dest.'/'.$_POST['photo_name']);
				return (int)mysqli_insert_id($this->mySQLconn);
			}
			else{
				return false;
			}
		}
	}


	function customer_delete($curdate){		
	$log=$_SESSION['login_user'];
		$delid=$this->esc($_POST['delid'] ?? '');
		$sql= "update tbl_customer set delete_status='0',deleted_by='".$log."',deleted_date='".$curdate."' where customer_id='".$delid."'";
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
		$sql= "select * from tbl_customer where customer_id='".$this->esc($_POST['customer_id'] ?? '')."' and delete_status='NDL'";
	    $exec_query=mysqli_query($this->mySQLconn, $sql);
		if($exec_query === false){
			return $bannerData;
		}
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

		$customer_name = $this->esc($_POST['customer_name'] ?? '');
		$mblno = $this->esc($_POST['mblno'] ?? '');
		$customer_id = $this->esc($_POST['customer_id'] ?? '');

		$duplicate = mysqli_query($this->mySQLconn, "
			SELECT * FROM tbl_customer 
			WHERE customer_name = '$customer_name' 
			AND mblno = '$mblno' 
			AND delete_status = 'NDL'
			AND customer_id != '$customer_id'
		");

		if($duplicate === false){
			return $this->sqlerr();
		}
		if (mysqli_num_rows($duplicate) > 0) {
			// Duplicate found, stop execution or return error
			return;
		} else {

		
			$sql= "update tbl_customer set customer_name='".$customer_name."',reference_name='".$this->esc($_POST['reference_name'] ?? '')."',company_name='".$this->esc($_POST['company_name'] ?? '')."',owner_name='".$this->esc($_POST['owner_name'] ?? '')."',state='".$this->esc($_POST['state'] ?? '')."',gst_no='".$this->esc($_POST['gst_no'] ?? '')."',state_code='".$this->esc($_POST['state_code'] ?? '')."',mblno='".$mblno."',owner_contact='".$this->esc($_POST['owner_contact'] ?? '')."',email='".$this->esc($_POST['email'] ?? '')."',address='".$this->esc($_POST['address'] ?? '')."',reference_details='".$this->esc($_POST['reference_details'] ?? '')."',status='".$this->esc($_POST['status'] ?? 'Active')."',updated_by='".$log."',update_date='".$curdate."' where customer_id='".$customer_id."'";
			// print_r($sql);
			$exec_query=mysqli_query($this->mySQLconn, $sql);
			if($exec_query === false){
				return $this->sqlerr();
			}
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
		
}		
$objVDS=new customer_services($conn);
$curdate=date('Y-m-d H:i:s');
$newCustomerId=null;
$rtnMsg=null;
if((($_POST['debug'] ?? '')=='1') && ((($_POST['req'] ?? '')=='ADDINS') || (($_POST['customer_req'] ?? '')=='ADDINS'))){
	$rtnMsg=$objVDS->debug_insert();
}
else if(($_POST['req'] ?? '')=='ADDINS'){
	$res=$objVDS->add_insert($curdate);
	if($res){ $rtnMsg=1; $newCustomerId=(int)$res; } else { $rtnMsg=$res; }
}else if(($_POST['customer_req'] ?? '')=='ADDINS'){
	$res=$objVDS->add_insert_other($curdate);
	if($res){ $rtnMsg=1; $newCustomerId=(int)$res; } else { $rtnMsg=$res; }
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
$json = array("op" =>$rtnMsg, "customer_id" => $newCustomerId);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>