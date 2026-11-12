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

class income_header_services {
	private $mySQLconn;
	function __construct($conn){
		$this->mySQLconn = $conn;
	}
	
	function add_insert($curdate){
		$log = $_SESSION['login_user'] ?? 'admin';

		$order_date = jayam_parse_date($_POST['order_date'] ?? '') ?? date('Y-m-d');
		$payment_mode = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['payment_mode'] ?? 'Cash'));
		$ref_no = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['ref_no'] ?? ''));
		$remarks = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['remarks'] ?? ''));

		$insertedCount = 0;

		$i = 0;
		foreach (($_POST['income_header_id'] ?? []) as $key => $income_header_id){					
			$income_header_id = $_POST['income_header_id'][$i] ?? '';
			$income_amount = $_POST['income_amount'][$i] ?? '';
			if($income_header_id === '' || $income_header_id === null || $income_amount === '' || $income_amount === null){ $i++; continue; }
				
			$sql_details = "INSERT INTO tbl_income_expense_details (billing_date,income_expense_type,header_id,amount,payment_mode,ref_no,remarks,created_by,create_date,delete_status) VALUES('".$order_date."','Income','".$income_header_id."','".$income_amount."','".$payment_mode."','".$ref_no."','".$remarks."','".$log."','".$curdate."','NDL')";
			if (mysqli_query($this->mySQLconn, $sql_details)) {
				$insertedCount++;
			}
			$i++;
		}

		$j = 0;
		foreach (($_POST['expense_header_id'] ?? []) as $key => $expense_header_id){						
			$expense_header_id = $_POST['expense_header_id'][$j] ?? '';
			$expense_amount = $_POST['expense_amount'][$j] ?? '';
			if($expense_header_id === '' || $expense_header_id === null || $expense_amount === '' || $expense_amount === null){ $j++; continue; }
				
			$sql_details = "INSERT INTO tbl_income_expense_details (billing_date,income_expense_type,header_id,amount,payment_mode,ref_no,remarks,created_by,create_date,delete_status) VALUES('".$order_date."','Expense','".$expense_header_id."','".$expense_amount."','".$payment_mode."','".$ref_no."','".$remarks."','".$log."','".$curdate."','NDL')";
			if (mysqli_query($this->mySQLconn, $sql_details)) {
				$insertedCount++;
			}
			$j++;
		}

		return ($insertedCount > 0);
	}

	function sqlerr(){ $e = mysqli_error($this->mySQLconn); return $e !== '' ? 'SQL error: '.$e : 'SQL error: unknown database error'; }

	function income_header_delete($curdate){
		$log = $_SESSION['login_user'] ?? 'admin';
		$delid = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['delid'] ?? ''));
		// Single-record delete when a numeric row id is passed, else legacy whole-date delete.
		if (ctype_digit($delid)) {
			$sql = "UPDATE tbl_income_expense_details SET delete_status='0', delete_by='".$log."', delete_date='".$curdate."' WHERE id='".$delid."'";
		} else {
			$sql = "UPDATE tbl_income_expense_details SET delete_status='0', delete_by='".$log."', delete_date='".$curdate."' WHERE billing_date='".$delid."'";
		}
	    $res = mysqli_query($this->mySQLconn, $sql);
	    if ($res === false) return $this->sqlerr();
	    return (bool)$res;
	}

	function income_header_autobind($curdate){
		$bannerData = array();
		$bDate = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['billing_date'] ?? ''));
		$sql = "SELECT * FROM tbl_income_expense_details WHERE billing_date='".$bDate."' AND delete_status='NDL'";
	    $exec_query = mysqli_query($this->mySQLconn, $sql);
		if ($exec_query && mysqli_num_rows($exec_query) > 0){
			while($row = mysqli_fetch_array($exec_query, MYSQLI_ASSOC)){
				$bannerData[] = str_replace("^","'",$row);		
			}
		}
		return $bannerData;
	}

	function income_header_update($curdate){
		$log = $_SESSION['login_user'] ?? 'admin';

		// Single-record update (edit page posts record id; fields arrive as single-element arrays).
		if (isset($_POST['record_id']) && ctype_digit((string)$_POST['record_id'])) {
			$rid = (string)$_POST['record_id'];
			$exists = mysqli_query($this->mySQLconn, "SELECT id FROM tbl_income_expense_details WHERE id='".$rid."' AND delete_status!='0' LIMIT 1");
			if (!$exists || mysqli_num_rows($exists) === 0) {
				return 'Record not found. It may have been deleted.';
			}
			$order_date = jayam_parse_date($_POST['order_date'] ?? '') ?? date('Y-m-d');
			$raw_hid = $_POST['expense_header_id'] ?? '';
			if (is_array($raw_hid)) { $raw_hid = reset($raw_hid); }
			$raw_amt = $_POST['expense_amount'] ?? '';
			if (is_array($raw_amt)) { $raw_amt = reset($raw_amt); }
			$header_id = mysqli_real_escape_string($this->mySQLconn, (string)$raw_hid);
			$amount = (float)$raw_amt;
			$payment_mode = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['payment_mode'] ?? 'Cash'));
			$ref_no = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['ref_no'] ?? ''));
			$remarks = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['remarks'] ?? ''));
			if ($header_id === '' || $amount <= 0) {
				return 'Select an Expense Header and enter a valid Amount.';
			}
			$sql = "UPDATE tbl_income_expense_details SET billing_date='".$order_date."',header_id='".$header_id."',amount='".$amount."',payment_mode='".$payment_mode."',ref_no='".$ref_no."',remarks='".$remarks."',updated_by='".$log."',update_date='".$curdate."' WHERE id='".$rid."'";
			$exec = mysqli_query($this->mySQLconn, $sql);
			if ($exec === false) {
				return $this->sqlerr();
			}
			return (mysqli_affected_rows($this->mySQLconn) >= 0);
		}
		$order_date = jayam_parse_date($_POST['order_date'] ?? '') ?? date('Y-m-d');
		$payment_mode = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['payment_mode'] ?? 'Cash'));
		$ref_no = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['ref_no'] ?? ''));
		$remarks = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['remarks'] ?? ''));
		$orig_date = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['billing_date'] ?? ''));

		$rql = "DELETE FROM tbl_income_expense_details WHERE billing_date='".$orig_date."'";
		mysqli_query($this->mySQLconn, $rql);

		$insertedCount = 0;

		$i = 0;
		foreach (($_POST['income_header_id'] ?? []) as $key => $income_header_id){				
			$income_header_id = $_POST['income_header_id'][$i] ?? '';
			$income_amount = $_POST['income_amount'][$i] ?? '';
			if($income_header_id === '' || $income_header_id === null || $income_amount === '' || $income_amount === null){ $i++; continue; }
				
			$sql_details = "INSERT INTO tbl_income_expense_details (billing_date,income_expense_type,header_id,amount,payment_mode,ref_no,remarks,created_by,create_date,delete_status) VALUES('".$order_date."','Income','".$income_header_id."','".$income_amount."','".$payment_mode."','".$ref_no."','".$remarks."','".$log."','".$curdate."','NDL')";
			if (mysqli_query($this->mySQLconn, $sql_details)) {
				$insertedCount++;
			}
			$i++;
		}

		$j = 0;
		foreach (($_POST['expense_header_id'] ?? []) as $key => $expense_header_id){						
			$expense_header_id = $_POST['expense_header_id'][$j] ?? '';
			$expense_amount = $_POST['expense_amount'][$j] ?? '';
			if($expense_header_id === '' || $expense_header_id === null || $expense_amount === '' || $expense_amount === null){ $j++; continue; }
				
			$sql_details = "INSERT INTO tbl_income_expense_details (billing_date,income_expense_type,header_id,amount,payment_mode,ref_no,remarks,created_by,create_date,delete_status) VALUES('".$order_date."','Expense','".$expense_header_id."','".$expense_amount."','".$payment_mode."','".$ref_no."','".$remarks."','".$log."','".$curdate."','NDL')";
			if (mysqli_query($this->mySQLconn, $sql_details)) {
				$insertedCount++;
			}
			$j++;
		}

		return ($insertedCount > 0);
	}

	function income_header_add($curdate){
		$log = $_SESSION['login_user'] ?? 'admin';
		$headerName = mysqli_real_escape_string($this->mySQLconn, (string)($_POST['income_header_name'] ?? ''));
		$sql = "INSERT INTO tbl_income_header (income_header_name,created_by,create_date,delete_status) VALUES('".$headerName."','".$log."','".$curdate."','NDL')";
	    return (bool)mysqli_query($this->mySQLconn, $sql);
	}
}

$objVDS = new income_header_services($conn);
$curdate = date('Y-m-d H:i:s');
$rtnMsg = false;

if(($_POST['req'] ?? '') == 'ADDINS'){
	$rtnMsg = $objVDS->add_insert($curdate);
}
else if(($_POST['req'] ?? '') == 'DEL'){
	$rtnMsg = $objVDS->income_header_delete($curdate);
}
else if(($_POST['req'] ?? '') == 'AUB'){
	$rtnMsg = $objVDS->income_header_autobind($curdate);
}
else if(($_POST['req'] ?? '') == 'UPD'){
	$rtnMsg = $objVDS->income_header_update($curdate);
}
else if(($_POST['req'] ?? '') == 'ADDINCOMEINS'){
	$rtnMsg = $objVDS->income_header_add($curdate);
}

mysqli_close($conn);
// Preserve human-readable error strings; normalize booleans to 1/0.
$json = array("op" => is_string($rtnMsg) ? $rtnMsg : ($rtnMsg ? 1 : 0));

header("Content-Type: application/json; charset=utf-8");
echo json_encode($json);