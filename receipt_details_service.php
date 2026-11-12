<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');

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

if (!class_exists('booking_details_service')) {
class booking_details_service {
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

		// True outstanding for a bill: grand_total minus every NDL receipt recorded.
		$trueBal = function($dc_id) {
			$g = 0.0; $p = 0.0;
			$r = mysqli_query($this->mySQLconn, "SELECT grand_total_amount FROM tbl_gst_invoice WHERE dc_id='".intval($dc_id)."' AND delete_status='NDL' LIMIT 1");
			if ($r && $rg = mysqli_fetch_assoc($r)) $g = (float)($rg['grand_total_amount'] ?? 0);
			$r = mysqli_query($this->mySQLconn, "SELECT COALESCE(SUM(pay_amount),0) p FROM tbl_receipt WHERE dc_id='".intval($dc_id)."' AND delete_status='NDL'");
			if ($r && $rp = mysqli_fetch_assoc($r)) $p = (float)($rp['p'] ?? 0);
			return $g - $p;
		};

		if (!empty($_POST['dc_id']) && is_array($_POST['dc_id'])) {
			// Fallback allocation: if JS never filled balance1[] (e.g. single bill),
			// distribute top-level pay_amount across rows in order.
			$topPay = floatval($_POST['pay_amount'] ?? 0);
			$balance1Missing = true;
			foreach ($_POST['dc_id'] as $chk) {
				// checked via isset on parallel array index below; approximate by any non-empty balance1
			}
			if (isset($_POST['balance1']) && is_array($_POST['balance1'])) {
				foreach ($_POST['balance1'] as $b1) {
					if ($b1 !== '' && $b1 !== null) { $balance1Missing = false; break; }
				}
			}
			$fallbackRemaining = $topPay;
			foreach ($_POST['dc_id'] as $i => $dc_id_val) {
				$dc_id = intval($dc_id_val);
				$dc_no = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['dc_no'][$i] ?? $_POST['dc'][$i] ?? ''));
				$balance = floatval($_POST['balance'][$i] ?? 0);
				if ($balance1Missing && $topPay > 0) {
					$alloc = min($balance, $fallbackRemaining);
					$balance1 = $balance - $alloc;
					$fallbackRemaining -= $alloc;
				} else {
					$balance1 = isset($_POST['balance1'][$i]) && $_POST['balance1'][$i] !== '' ? floatval($_POST['balance1'][$i]) : $balance;
				}

				if ($balance1 < $balance) {
					$pay_amount = $balance - $balance1;
				} else if (isset($_POST['balance1'][$i]) && $balance1 <= 0 && $balance > 0) {
					$pay_amount = $balance;
				} else {
					$pay_amount = 0;
				}
				if ($pay_amount > $balance) $pay_amount = $balance;
				if ($pay_amount < 0 || $balance <= 0) $pay_amount = 0;
				$cap = $trueBal($dc_id);
				if ($pay_amount > $cap) $pay_amount = max(0.0, $cap);

				if ($pay_amount > 0 && $dc_id > 0) {
					if (empty($dc_no)) {
						$chk = mysqli_query($this->mySQLconn, "SELECT dc_no FROM tbl_gst_invoice WHERE dc_id='$dc_id' LIMIT 1");
						$row_chk = $chk ? mysqli_fetch_assoc($chk) : null;
						if ($row_chk) $dc_no = $row_chk['dc_no'];
					}
					$sql = "INSERT INTO tbl_receipt (customer_id, dc_no, billing_date, dc_id, payment_mode, bank_id, pay_amount, ref_no, remarks, created_by, create_date, delete_status) 
					        VALUES ('$customer_id', '$dc_no', '$billing_date', '$dc_id', '$payment_mode', '$bank_id', '$pay_amount', '$ref_no', '$remarks', '$log', '$curdate', 'NDL')";
					if (mysqli_query($this->mySQLconn, $sql)) {
						$inserted++;
					}
				}
			}
		} else if (!empty($_POST['dc']) && is_array($_POST['dc'])) {
			$i = 0;
			foreach ($_POST['dc'] as $key => $dc_val){				
				$dc_id = intval($_POST['dc_id'][$i] ?? 0);
				$dc_no = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['dc'][$i] ?? ''));
				$balance = floatval($_POST['balance'][$i] ?? 0);
				$balance1 = floatval($_POST['balance1'][$i] ?? 0);

				if ($balance1 <= 0) {
					$pay_amount = $balance;
				} else {
					$pay_amount = $balance - $balance1;
				}
				if ($pay_amount > $balance) $pay_amount = $balance;
				if ($pay_amount < 0 || $balance <= 0) $pay_amount = 0;
				$cap = $trueBal($dc_id);
				if ($pay_amount > $cap) $pay_amount = max(0.0, $cap);

				if ($pay_amount > 0 && $dc_id > 0) {
					$sql = "INSERT INTO tbl_receipt (customer_id, dc_no, billing_date, dc_id, payment_mode, bank_id, pay_amount, ref_no, remarks, created_by, create_date, delete_status) 
					        VALUES ('$customer_id', '$dc_no', '$billing_date', '$dc_id', '$payment_mode', '$bank_id', '$pay_amount', '$ref_no', '$remarks', '$log', '$curdate', 'NDL')";
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
		$sql = "UPDATE tbl_receipt SET delete_status='0', delete_by='$log', delete_date='$curdate' WHERE receipt_id='$delid'";
		return (bool)mysqli_query($this->mySQLconn, $sql);
	}
}
}

$objVDS = new booking_details_service($conn);
$curdate = date('Y-m-d H:i:s');
$rtnMsg = false;

if (($_POST['req'] ?? '') == 'ADDINS') {
	$rtnMsg = $objVDS->add_insert($curdate);
}
else if (($_POST['req'] ?? '') == 'ADDDEL') {
	$rtnMsg = $objVDS->booking_delete($curdate);
}

mysqli_close($conn);
$json = array("op" => $rtnMsg ? 1 : 0);

header("Content-Type: application/json; charset=utf-8");
echo json_encode($json);
?>