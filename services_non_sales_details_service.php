<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
include_once("phpservices/connection.php");

if (file_exists(__DIR__ . '/phpservices/jayam_helpers.php')) {
    require_once __DIR__ . '/phpservices/jayam_helpers.php';
}
if (!function_exists('jayam_parse_date')) {
    function jayam_parse_date($date_str, $fmt = 'd/m/Y') {
        if ($date_str === null || trim((string)$date_str) === '') return null;
        $date_str = trim((string)$date_str);
        $d = DateTime::createFromFormat($fmt, $date_str);
        if ($d && $d->format($fmt) === $date_str) {
            return $d->format('Y-m-d');
        }
        $d2 = DateTime::createFromFormat('Y-m-d', $date_str);
        if ($d2 && $d2->format('Y-m-d') === $date_str) {
            return $d2->format('Y-m-d');
        }
        $ts = strtotime(str_replace('/', '-', $date_str));
        return $ts !== false ? date('Y-m-d', $ts) : null;
    }
}

date_default_timezone_set('Asia/Kolkata');	

if (!class_exists('services_dc_details_service')) {
class services_dc_details_service {
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn = $conn;
	}
	function esc($v){ return mysqli_real_escape_string($this->mySQLconn, (string)($v ?? '')); }
	function dbdate($dmy){ $r = function_exists('jayam_parse_date') ? jayam_parse_date($dmy ?? '') : null; return $r ?? date('Y-m-d'); }
	
	function add_insert($curdate){
		$log = $_SESSION['login_user'] ?? 'admin';
		$delivery_address = $this->esc($_POST['delivery_address'] ?? '');
		$customer_id = intval($_POST['customer_id'] ?? 0);
		$order_date = $this->dbdate($_POST['order_date'] ?? '');
		$dc_no = $this->esc($_POST['dc_no'] ?? '');	
		$order_id = $this->esc($_POST['order_id'] ?? '');
		$advance_amount = (float)($_POST['advance_amount'] ?? 0);
		$payment_terms_days = ($_POST['payment_terms_days'] ?? '') === '' ? null : (int)$_POST['payment_terms_days'];
		$service_place = in_array(($_POST['service_place'] ?? ''), ['Outdoor','Workshop'], true) ? $_POST['service_place'] : 'Workshop';
		$is_service_bill = 1;
		
		$total_amount = (float)($_POST['total_amount'] ?? 0);		
		$grand_total_amount = (float)($_POST['grand_total_amount'] ?? 0);
		$driver_type = $_POST['driver_type'] ?? '1';
		$driver_name = ($_POST['driver_name'] ?? '');
		$driver_id = ($_POST['driver_id'] ?? '');
		$vechicle_no = trim((string)($_POST['vechicle_number'] ?? ($_POST['vechicle_no'] ?? ($_POST['refrence_name'] ?? ''))));
		$vechicle_id = ($_POST['vechicle_id'] ?? '');
		$refrence_name = $this->esc($_POST['refrence_name'] ?? $vechicle_no);
		if ($refrence_name === '') {
			$refrence_name = $this->esc($vechicle_no);
		}

		$sql = "INSERT INTO tbl_services_non_dc (customer_id,company_name,mblno,email,address,gst_no,state,state_code,delivery_address,order_id,dc_no,billing_date,total_amount,discount,driver_type,driver_name,driver_id,vechicle_number,vechicle_id,grand_total_amount,advance_amount,payment_terms_days,service_place,is_service_bill,refrence_name,created_by,create_date,delete_status) 
		VALUES('".$customer_id."','".$this->esc($_POST['company_name'] ?? '')."','".$this->esc($_POST['mblno'] ?? '')."','".$this->esc($_POST['email'] ?? '')."','".$this->esc($_POST['address'] ?? '')."','".$this->esc($_POST['gst_no'] ?? '')."','".$this->esc($_POST['state'] ?? '')."','".$this->esc($_POST['state_code'] ?? '')."','".$delivery_address."','".$order_id."','".$dc_no."','".$order_date."','".$total_amount."','".$this->esc($_POST['discount'] ?? '0')."','".$driver_type."','".$this->esc($driver_name)."','".$this->esc($driver_id)."','".$this->esc($vechicle_no)."','".$this->esc($vechicle_id)."','".$grand_total_amount."','".$advance_amount."',".($payment_terms_days === null ? "NULL" : "'".$payment_terms_days."'").",".($service_place === null ? "NULL" : "'".$service_place."'").",'1','".$refrence_name."','".$log."','".$curdate."','NDL')";
		
		$exec_query = mysqli_query($this->mySQLconn, $sql);
		$lastdc_id = mysqli_insert_id($this->mySQLconn);
		if (!$lastdc_id) {
			$sql_select = "SELECT dc_id FROM tbl_services_non_dc WHERE delete_status='NDL' ORDER BY dc_id DESC LIMIT 1";
			$exec_query_select = mysqli_query($this->mySQLconn, $sql_select);
			$fetch = mysqli_fetch_array($exec_query_select);
			$lastdc_id = $fetch['dc_id'] ?? 0;
		}

		if ($exec_query && $lastdc_id > 0) {
			$i = 0;
			foreach (($_POST['product_id'] ?? []) as $key => $product_id) {		
				$product_rate = (float)($_POST['product_rate'][$i] ?? 0);		
				$rate = (float)($_POST['rate'][$i] ?? 0);
				$qty = (float)($_POST['qty'][$i] ?? 0);
				$uom_id = $this->esc($_POST['uom_id'][$i] ?? '');
				$prod_id = $this->esc($product_id);

				$sql_details = "INSERT INTO tbl_services_non_dc_details (dc_id,product_id,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) 
				VALUES('".$lastdc_id."','".$prod_id."','".$uom_id."','".$qty."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";
				mysqli_query($this->mySQLconn, $sql_details);
				$i++;
			}

			if ($advance_amount > 0) {
				$advStmt = mysqli_prepare($this->mySQLconn, "INSERT INTO tbl_services_non_receipt (customer_id,dc_no,billing_date,dc_id,payment_mode,bank_id,pay_amount,is_service_bill,remarks,created_by,create_date,delete_status) VALUES (?,?,?,?,?,?,?,'1',?,?,?, 'NDL')");
				if ($advStmt) {
					$advMode = 'Advance';
					$advBank = '';
					$advRemark = 'Service Bill-level advance';
					$advDcNo = (string)$dc_no;
					$advCust = (string)$customer_id;
					mysqli_stmt_bind_param($advStmt, 'ssssssdsss', $advCust, $advDcNo, $order_date, $lastdc_id, $advMode, $advBank, $advance_amount, $advRemark, $log, $curdate);
					mysqli_stmt_execute($advStmt);
					mysqli_stmt_close($advStmt);
				}
			}

			return true;
		} else {
			return false;
		}
	}
	
	function add_update($curdate){
		$log = $_SESSION['login_user'] ?? 'admin';
		$delivery_address = $this->esc($_POST['delivery_address'] ?? '');
		$customer_id = intval($_POST['customer_id'] ?? 0);
		$dc_no = $this->esc($_POST['dc_no'] ?? '');		
		$order_date = $this->dbdate($_POST['invoice_date'] ?? '');
		$dc_id = intval($_POST['dc_id'] ?? 0);
		$advance_amount = (float)($_POST['advance_amount'] ?? 0);
		$payment_terms_days = ($_POST['payment_terms_days'] ?? '') === '' ? null : (int)$_POST['payment_terms_days'];
		$service_place = in_array(($_POST['service_place'] ?? ''), ['Outdoor','Workshop'], true) ? $_POST['service_place'] : 'Workshop';

		$total_amount = (float)($_POST['total_amount'] ?? 0);		
		$grand_total_amount = (float)($_POST['grand_total_amount'] ?? 0);
		$driver_type = $_POST['driver_type'] ?? '1';
		$driver_name = ($_POST['driver_name'] ?? '');
		$driver_id = ($_POST['driver_id'] ?? '');
		$vechicle_no = ($_POST['vechicle_no'] ?? '');
		$vechicle_id = ($_POST['vechicle_id'] ?? '');

		$driver_name = ($_POST['driver_name'] ?? '');
		$driver_id = ($_POST['driver_id'] ?? '');
		$vechicle_no = trim((string)($_POST['vechicle_number'] ?? ($_POST['vechicle_no'] ?? ($_POST['refrence_name'] ?? ''))));
		$vechicle_id = ($_POST['vechicle_id'] ?? '');
		$refrence_name = $this->esc($_POST['refrence_name'] ?? $vechicle_no);
		if ($refrence_name === '') {
			$refrence_name = $this->esc($vechicle_no);
		}

		$sql_pro = "UPDATE tbl_services_non_dc SET delivery_address='".$delivery_address."',driver_type='".$driver_type."',driver_name='".$this->esc($driver_name)."',driver_id='".$this->esc($driver_id)."',vechicle_number='".$this->esc($vechicle_no)."',vechicle_id='".$this->esc($vechicle_id)."',refrence_name='".$refrence_name."',dc_no='".$dc_no."',customer_id='".$customer_id."',total_amount='".$total_amount."',discount='".$this->esc($_POST['discount'] ?? '0')."',grand_total_amount='".$grand_total_amount."',advance_amount='".$advance_amount."',payment_terms_days=".($payment_terms_days === null ? "NULL" : "'".$payment_terms_days."'").",service_place=".($service_place === null ? "NULL" : "'".$service_place."'").",is_service_bill='1', billing_date='".$order_date."',updated_by='".$log."',update_date='".$curdate."' WHERE dc_id='".$dc_id."'";
		$exec_query_pro = mysqli_query($this->mySQLconn, $sql_pro);
		
		if ($exec_query_pro) {
			mysqli_query($this->mySQLconn, "DELETE FROM tbl_services_non_dc_details WHERE dc_id='".$dc_id."'");
			$i = 0;
			foreach (($_POST['product_id'] ?? []) as $key => $product_id) {							
				$product_rate = (float)($_POST['product_rate'][$i] ?? 0);		
				$uom_id = $this->esc($_POST['uom_id'][$i] ?? '');
				$rate = (float)($_POST['rate'][$i] ?? 0);
				$qty = (float)($_POST['qty'][$i] ?? 0);	
				$prod_id = $this->esc($product_id);

				$sql_details = "INSERT INTO tbl_services_non_dc_details (dc_id,product_id,uom_id,qty,product_rate,rate,created_by,create_date,delete_status) 
				VALUES('".$dc_id."','".$prod_id."','".$uom_id."','".$qty."','".$product_rate."','".$rate."','".$log."','".$curdate."','NDL')";						
				mysqli_query($this->mySQLconn, $sql_details);
				$i++;
			}
			return true;
		} else {
			return false;
		}
	}

	function dc_delete($curdate){		
		$log = $_SESSION['login_user'] ?? 'admin';
		$delid = intval($_POST['delid'] ?? 0);
		if ($delid <= 0) return false;

		$sql = "UPDATE tbl_services_non_dc SET delete_status='0',delete_by='".$log."',delete_date='".$curdate."' WHERE dc_id='".$delid."'";
		$exec_query = mysqli_query($this->mySQLconn, $sql);
		
		if ($exec_query) {
			mysqli_query($this->mySQLconn, "UPDATE tbl_services_non_dc_details SET delete_status='0',delete_by='".$log."',delete_date='".$curdate."' WHERE dc_id='".$delid."'");
			mysqli_query($this->mySQLconn, "UPDATE tbl_services_non_receipt SET delete_status='0',delete_by='".$log."',delete_date='".$curdate."' WHERE dc_id='".$delid."'");
			return true;
		} else {
			return false;
		}
	}

	function dc_autobind($curdate){
		$bannerData = array();
		$dc_id = intval($_POST['dc_id'] ?? 0);
		$sql = "SELECT * FROM tbl_services_non_dc WHERE dc_id='".$dc_id."' AND delete_status='NDL'";
		$exec_query = mysqli_query($this->mySQLconn, $sql);
		if ($exec_query && mysqli_num_rows($exec_query) > 0) {
			while ($row = mysqli_fetch_array($exec_query, MYSQLI_ASSOC)) {
				$bannerData[] = str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}
}
}

$objVDS = new services_dc_details_service($conn);
$curdate = date('Y-m-d H:i:s');
$rtnMsg = false;

if (($_POST['req'] ?? '') == 'ADDINS') {
	$rtnMsg = $objVDS->add_insert($curdate);
} else if (($_POST['req'] ?? '') == 'UPD') {
	$rtnMsg = $objVDS->add_update($curdate);
} else if (($_POST['req'] ?? '') == 'DEL') {
	$rtnMsg = $objVDS->dc_delete($curdate);
} else if (($_POST['req'] ?? '') == 'AUB') {
	$rtnMsg = $objVDS->dc_autobind($curdate);
}

mysqli_close($conn);

header("Content-Type: application/json; charset=UTF-8");
echo json_encode(array("op" => $rtnMsg));
?>
