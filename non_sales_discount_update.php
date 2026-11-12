<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");	
date_default_timezone_set('Asia/Kolkata');

class booking_details_service {
	private $mySQLconn;

	function __construct($conn){
		$this->mySQLconn = $conn;
	}

	function add_update($curdate){		
		$log = $_SESSION['login_user'] ?? 'admin';
		$amount_discount = floatval($_POST['amount_discount'] ?? 0);
		$dc_id = intval($_POST['dc_id'] ?? 0);

		if ($dc_id <= 0) return false;

		$sql = "SELECT discount, total_amount FROM tbl_non_dc WHERE dc_id='".$dc_id."'";
		$exec_query = mysqli_query($this->mySQLconn, $sql);

		$total_amount = 0;
		if ($exec_query && mysqli_num_rows($exec_query) > 0) {
			$row = mysqli_fetch_array($exec_query, MYSQLI_ASSOC);
			$total_amount = floatval($row['total_amount'] ?? 0);
		}

		$total_discount = max(0.0, (float)$amount_discount);
		$grand_total_amount = $total_amount - $total_discount;

		// Never let discount push the running balance below what is already paid.
		$paid = 0.0;
		$pq = mysqli_query($this->mySQLconn, "SELECT COALESCE(SUM(pay_amount),0) p FROM tbl_non_receipt WHERE dc_id='".$dc_id."' AND delete_status='NDL'");
		if ($pq && $pr = mysqli_fetch_assoc($pq)) { $paid = (float)($pr['p'] ?? 0); }
		if ($grand_total_amount < $paid) {
			$grand_total_amount = $paid;
			$total_discount = max(0.0, $total_amount - $grand_total_amount);
		}
		$total_discount = round($total_discount, 2);
		$grand_total_amount = round($grand_total_amount, 2);

		$sql = "UPDATE tbl_non_dc SET discount='".$total_discount."', grand_total_amount='".$grand_total_amount."' WHERE dc_id='".$dc_id."'";
		$exec_query = mysqli_query($this->mySQLconn, $sql);
		return (bool)$exec_query;
	}
}

$objVDS = new booking_details_service($conn);
$curdate = date('Y-m-d H:i:s');
$rtnMsg = false;

if (($_POST['req'] ?? '') == 'DISUPD') {
	$rtnMsg = $objVDS->add_update($curdate);
}

mysqli_close($conn);

header("Content-Type: application/json; charset=UTF-8");
echo json_encode(array("op" => $rtnMsg));
?>
