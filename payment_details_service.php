<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');

		/*$sql= "INSERT INTO tbl_payment(supplier_id,dc_no,billing_date,purchase_id,payment_mode,bank_id,pay_amount,created_by,create_date,delete_status) VALUES('".$supplier_id."','".$dc_no."','".$billing_date."','".$purchase_id."','".$payment_mode."','".$bank_id."','".$pay_amount."','".$log."','".$curdate."','NDL')";
		
	    $exec_query=mysqli_query($conn, $sql);
		
		if($exec_query){
			
			//$result=1;
		}
		else{
			//$result=0;
		}*/


		
//$json = array("op" =>$result);
//header("Content-Type: application/json",true);
//echo json_encode($json);

class booking_details_service{
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$curdate=date('Y-m-d H:i:s');
		
		$supplier_id=$_POST['supplier_id'];
		$billing_date=date("Y-m-d", strtotime($_POST['billing_date']));		
		//$pay_amount=$_POST['pay_amount'];
		
		$payment_mode=$_POST['payment_mode'] ?? '';
		$bank_id=$_POST['bank_id'] ?? '';
		$ref_no=mysqli_real_escape_string($this->mySQLconn, (string)($_POST['ref_no'] ?? ''));
		$remarks=mysqli_real_escape_string($this->mySQLconn, (string)($_POST['remarks'] ?? ''));
		// tbl_payment has no ref_no/remarks columns yet: auto-add once so single+multi pay can store them.
		@mysqli_query($this->mySQLconn, "ALTER TABLE tbl_payment ADD COLUMN IF NOT EXISTS ref_no VARCHAR(150) NULL AFTER pay_amount");
		@mysqli_query($this->mySQLconn, "ALTER TABLE tbl_payment ADD COLUMN IF NOT EXISTS remarks TEXT NULL AFTER ref_no");
		$has_ref = false;
		$col_q = @mysqli_query($this->mySQLconn, "SHOW COLUMNS FROM tbl_payment LIKE 'ref_no'");
		if($col_q && @mysqli_num_rows($col_q)>0){ $has_ref = true; }

		//print_r('kathir');

		//print_r($_POST['dc']);

		$i=0;
		$ok = false;
		foreach ($_POST['dc'] as $key=>$dc_id){	
				
			

			$purchase_id=$_POST['purchase_id'][$i];	
			
			//$dc_id=$_POST['dc_id'][$i];	
			
			$dc_no= $_POST['dc'][$i];				
			$balance= $_POST['balance'][$i];
			$extra= $_POST['extra'][$i];
			$balance1= $_POST['balance1'][$i];		
			
			//$pay_amount=$balance-$extra;

			if($balance1<0){
				$pay_amount=$balance;
			}else if($balance1==0){
				$pay_amount=$balance;
			}else{
				$pay_amount=$_POST['balance'][$i]-$_POST['balance1'][$i];
			}

			// Cap: never pay more than the outstanding balance, never negative, no zero rows.
			$pay_amount = floatval($pay_amount);
			$balance = floatval($balance);
			if ($pay_amount > $balance) $pay_amount = $balance;
			if ($pay_amount < 0 || $balance <= 0) $pay_amount = 0;
			if ($pay_amount <= 0) { $i++; continue; }

			if($has_ref){
				$sql= "INSERT INTO tbl_payment(supplier_id,dc_no,billing_date,purchase_id,payment_mode,bank_id,pay_amount,ref_no,remarks,created_by,create_date,delete_status) VALUES('".$supplier_id."','".$dc_no."','".$billing_date."','".$purchase_id."','".$payment_mode."','".$bank_id."','".$pay_amount."','".$ref_no."','".$remarks."','".$log."','".$curdate."','NDL')";
			}else{
				$sql= "INSERT INTO tbl_payment(supplier_id,dc_no,billing_date,purchase_id,payment_mode,bank_id,pay_amount,created_by,create_date,delete_status) VALUES('".$supplier_id."','".$dc_no."','".$billing_date."','".$purchase_id."','".$payment_mode."','".$bank_id."','".$pay_amount."','".$log."','".$curdate."','NDL')";
			}
		
$exec_query=mysqli_query($this->mySQLconn, $sql);
			if($exec_query){ $ok = true; }


			$i++;
		}

		if($ok){
			return true;
		}	
		else{
			 return false;
		}

		


	}


	function booking_delete($curdate){		
		$log=$_SESSION['login_user'];
		$sql= "update tbl_payment set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where payment_id='".$_POST['delid']."'";
		$exec_query=mysqli_query($this->mySQLconn, $sql);
		

		
		if($exec_query){
			
			return true;
		}
		else{
			 return false;
		}
	}


	
	
	
	/****************************************** */
	
		
}		
$objVDS=new booking_details_service($conn);
$curdate=date('Y-m-d H:i:s');
if(($_POST['req'] ?? '')=='ADDINS'){
	$rtnMsg=$objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '')=='ADDUPD'){
	$rtnMsg=$objVDS->add_update($curdate);
}

else if(($_POST['req'] ?? '')=='ADDDEL'){
	$rtnMsg=$objVDS->booking_delete($curdate);
}
else if(($_POST['req'] ?? '')=='PRODAUB'){
	$rtnMsg=$objVDS->booking_autobind($curdate);
}

mysqli_close($conn);
$json = array("op" =>$rtnMsg);
			
			// send data as json format
			header("Content-Type: application/json",true);
				echo json_encode($json);
?>