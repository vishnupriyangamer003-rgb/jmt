<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
include_once("phpservices/connection.php");

date_default_timezone_set('Asia/Kolkata');

if (!function_exists('jayam_parse_date')) {
	function jayam_parse_date($date_str) {
		if (empty($date_str)) return null;
		$date_str = trim($date_str);
		$d = DateTime::createFromFormat('d/m/Y', $date_str);
		if ($d && $d->format('d/m/Y') === $date_str) {
			return $d->format('Y-m-d');
		}
		$d = DateTime::createFromFormat('Y-m-d', $date_str);
		if ($d && $d->format('Y-m-d') === $date_str) {
			return $d->format('Y-m-d');
		}
		$ts = strtotime(str_replace('/', '-', $date_str));
		return $ts ? date('Y-m-d', $ts) : date('Y-m-d');
	}
}

if (!class_exists('services_receipt_service')) {
class services_receipt_service {
	private $mySQLconn;

	function __construct($conn){
		$this->mySQLconn = $conn;
	}
	
	function add_insert($curdate){
		$log = $_SESSION['login_user'] ?? 'admin';
		$curdate = date('Y-m-d H:i:s');
		
		$customer_id = intval($_POST['customer_id'] ?? 0);
		$billing_date = jayam_parse_date($_POST['billing_date'] ?? '') ?? date('Y-m-d');
		
		$payment_mode = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['payment_mode'] ?? '3'));
		$bank_id = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['bank_id'] ?? ''));
		$ref_no = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['ref_no'] ?? ''));
		$remarks = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['remarks'] ?? ''));

		$inserted = 0;

		if (!empty($_POST['dc_id']) && is_array($_POST['dc_id'])) {
			foreach ($_POST['dc_id'] as $i => $dc_id_val) {
				$dc_id = intval($dc_id_val);
				$dc_no = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['dc_no'][$i] ?? $_POST['dc'][$i] ?? ''));
				$balance = (float)($_POST['balance'][$i] ?? 0);
				$balance1 = isset($_POST['balance1'][$i]) && $_POST['balance1'][$i] !== '' ? (float)$_POST['balance1'][$i] : $balance;

				if ($balance1 < $balance) {
					$pay_amount = $balance - $balance1;
				} else if (isset($_POST['balance1'][$i]) && $balance1 <= 0 && $balance > 0) {
					$pay_amount = $balance;
				} else {
					$pay_amount = 0;
				}

				if ($pay_amount > 0 && $dc_id > 0) {
					$chk_svc = mysqli_query($this->mySQLconn, "SELECT dc_no FROM tbl_services_non_dc WHERE dc_id='".$dc_id."' LIMIT 1");
					$row_svc = $chk_svc ? mysqli_fetch_assoc($chk_svc) : null;
					if (empty($dc_no) && $row_svc) $dc_no = $row_svc['dc_no'];

					$sql = "INSERT INTO tbl_services_non_receipt(customer_id,dc_no,billing_date,dc_id,payment_mode,bank_id,pay_amount,is_service_bill,ref_no,remarks,created_by,create_date,delete_status) 
					        VALUES('".$customer_id."','".$dc_no."','".$billing_date."','".$dc_id."','".$payment_mode."','".$bank_id."','".$pay_amount."','1','".$ref_no."','".$remarks."','".$log."','".$curdate."','NDL')";
					if (mysqli_query($this->mySQLconn, $sql)) {
						$inserted++;
					}
				}
			}
		} else if (!empty($_POST['dc']) && is_array($_POST['dc'])) {
			$i = 0;
			foreach ($_POST['dc'] as $key => $dc_no_val) {
				$dc_id = intval($_POST['dc_id'][$i] ?? 0);
				$dc_no = mysqli_real_escape_string($this->mySQLconn, (string)$dc_no_val);
				$balance = (float)($_POST['balance'][$i] ?? 0);
				$balance1 = isset($_POST['balance1'][$i]) && $_POST['balance1'][$i] !== '' ? (float)$_POST['balance1'][$i] : 0;

				$pay_amount = ($balance1 <= 0) ? $balance : ($balance - $balance1);

				if ($pay_amount > 0 && $dc_id > 0) {
					$chk_svc = mysqli_query($this->mySQLconn, "SELECT dc_no FROM tbl_services_non_dc WHERE dc_id='".$dc_id."' LIMIT 1");
					$row_svc = $chk_svc ? mysqli_fetch_assoc($chk_svc) : null;
					if (empty($dc_no) && $row_svc) $dc_no = $row_svc['dc_no'];

					$sql = "INSERT INTO tbl_services_non_receipt(customer_id,dc_no,billing_date,dc_id,payment_mode,bank_id,pay_amount,is_service_bill,ref_no,remarks,created_by,create_date,delete_status) 
					        VALUES('".$customer_id."','".$dc_no."','".$billing_date."','".$dc_id."','".$payment_mode."','".$bank_id."','".$pay_amount."','1','".$ref_no."','".$remarks."','".$log."','".$curdate."','NDL')";
					if (mysqli_query($this->mySQLconn, $sql)) {
						$inserted++;
					}
				}
				$i++;
			}
		}

		return ($inserted > 0);
	}

	function booking_delete($curdate){		
		$log = $_SESSION['login_user'] ?? 'admin';
		$delid = intval($_POST['delid'] ?? 0);
		$sql = "UPDATE tbl_services_non_receipt SET delete_status='0', delete_by='".$log."', delete_date='".$curdate."' WHERE receipt_id='".$delid."'";
		return (bool)mysqli_query($this->mySQLconn, $sql);
	}
}
}

$objVDS = new services_receipt_service($conn);
$curdate = date('Y-m-d H:i:s');
$rtnMsg = false;

if (($_POST['req'] ?? '') == 'ADDINS') {
	$rtnMsg = $objVDS->add_insert($curdate);
} else if (($_POST['req'] ?? '') == 'ADDDEL') {
	$rtnMsg = $objVDS->booking_delete($curdate);
}

mysqli_close($conn);

header("Content-Type: application/json; charset=UTF-8");
echo json_encode(array("op" => $rtnMsg));
?>
