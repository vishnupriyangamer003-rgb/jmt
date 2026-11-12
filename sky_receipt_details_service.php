<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');

		

class booking_details_service{
	function __construct($conn){
		$this->mySQLconn=$conn;
	}
	
	function add_insert($curdate){
		$log=$_SESSION['login_user'];
		$curdate=date('Y-m-d H:i:s');
		
		$customer_id=$_POST['customer_id'];
	function add_insert($curdate){
		$log=$_SESSION['login_user'] ?? '';
		$curdate=date('Y-m-d H:i:s');
		
		$customer_id=mysqli_real_escape_string($this->mySQLconn, (string)($_POST['customer_id'] ?? ''));
		$raw_date = $_POST['billing_date'] ?? date('Y-m-d');
		$billing_date = date('Y-m-d', strtotime(str_replace('/', '-', $raw_date)));
		
		$payment_mode=mysqli_real_escape_string($this->mySQLconn, (string)($_POST['payment_mode'] ?? ''));
		$bank_id=mysqli_real_escape_string($this->mySQLconn, (string)($_POST['bank_id'] ?? '0'));
		$ref_no=mysqli_real_escape_string($this->mySQLconn, (string)($_POST['ref_no'] ?? ''));
		$remarks=mysqli_real_escape_string($this->mySQLconn, (string)($_POST['remarks'] ?? ''));

		$exec_query = false;

		if (!empty($_POST['row_selected']) && is_array($_POST['row_selected'])) {
			foreach ($_POST['row_selected'] as $idx => $val) {
				$dc_id = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['row_dc_id'][$idx] ?? ''));
				$dc_no = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['row_dc_no'][$idx] ?? ''));
				$balance = (float)($_POST['row_balance'][$idx] ?? 0);
				$balance1 = isset($_POST['row_balance1'][$idx]) && $_POST['row_balance1'][$idx] !== '' ? (float)$_POST['row_balance1'][$idx] : 0;

				if ($balance1 <= 0) {
					$pay_amount = $balance;
				} else {
					$pay_amount = $balance - $balance1;
				}

				if ($pay_amount > 0 && !empty($dc_id)) {
					$sql = "INSERT INTO tbl_sky_receipt(customer_id,dc_no,billing_date,dc_id,payment_mode,bank_id,pay_amount,ref_no,remarks,created_by,create_date,delete_status) VALUES('".$customer_id."','".$dc_no."','".$billing_date."','".$dc_id."','".$payment_mode."','".$bank_id."','".$pay_amount."','".$ref_no."','".$remarks."','".$log."','".$curdate."','NDL')";
					$exec_query = mysqli_query($this->mySQLconn, $sql);
				}
			}
		} else if (!empty($_POST['dc']) && is_array($_POST['dc'])) {
			$i = 0;
			foreach ($_POST['dc'] as $key => $dc_no_val) {
				$dc_id = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['dc_id'][$i] ?? ''));
				$dc_no = mysqli_real_escape_string($this->mySQLconn, (string)$dc_no_val);
				$balance = (float)($_POST['balance'][$i] ?? 0);
				$balance1 = isset($_POST['balance1'][$i]) && $_POST['balance1'][$i] !== '' ? (float)$_POST['balance1'][$i] : 0;

				if ($balance1 <= 0) {
					$pay_amount = $balance;
				} else {
					$pay_amount = $balance - $balance1;
				}

				if ($pay_amount > 0 && !empty($dc_id)) {
					$sql = "INSERT INTO tbl_sky_receipt(customer_id,dc_no,billing_date,dc_id,payment_mode,bank_id,pay_amount,ref_no,remarks,created_by,create_date,delete_status) VALUES('".$customer_id."','".$dc_no."','".$billing_date."','".$dc_id."','".$payment_mode."','".$bank_id."','".$pay_amount."','".$ref_no."','".$remarks."','".$log."','".$curdate."','NDL')";
					$exec_query = mysqli_query($this->mySQLconn, $sql);
				}
				$i++;
			}
		}

		return (bool)$exec_query;
	}

		


	}

	function booking_delete($curdate){		
		$log=$_SESSION['login_user'];
		$sql= "update tbl_sky_receipt set delete_status='0',delete_by='".$log."',delete_date='".$curdate."' where receipt_id='".$_POST['delid']."'";
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