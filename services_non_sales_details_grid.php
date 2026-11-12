<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
include_once("sessionservices.php");
include_once("phpservices/connection.php");


$requestData = $_REQUEST;

$sql = "SELECT a.dc_id FROM tbl_services_non_dc a WHERE a.delete_status != '0'";
$query = mysqli_query($conn, $sql);
$totalData = $query ? mysqli_num_rows($query) : 0;
$totalFiltered = $totalData;

$cond_clause = "";
if (($_POST['cond'] ?? '') == "searchbind") {
	$fdate = date('Y-m-d', strtotime($_POST['fdate']));
	$tdate = date('Y-m-d', strtotime($_POST['tdate'] . ' +1 day'));
	$customer_id = intval($_POST['customer_id'] ?? 0);
	if ($customer_id > 0) {
		$cond_clause = " AND a.billing_date BETWEEN '" . $fdate . "' AND '" . $tdate . "' AND a.customer_id = '" . $customer_id . "'";
	} else {
		$cond_clause = " AND a.billing_date BETWEEN '" . $fdate . "' AND '" . $tdate . "'";
	}
}

$search_clause = "";
if (!empty($requestData['search']['value'])) {
	$searchVal = mysqli_real_escape_string($conn, $requestData['search']['value']);
	$search_clause = " AND (a.dc_no LIKE '%" . $searchVal . "%' OR d.customer_name LIKE '%" . $searchVal . "%')";
}

$sql = "SELECT a.*, a.delete_status as deleted, d.customer_id, d.customer_name, 
        DATE_FORMAT(a.billing_date,'%d/%m/%Y') as billing_date_formatted,
        GROUP_CONCAT(b.product_id SEPARATOR ',<br/>') as product_id,
        GROUP_CONCAT(b.qty SEPARATOR ',<br/>') as qty,
        GROUP_CONCAT(b.product_rate SEPARATOR ',<br/>') as product_rate
        FROM tbl_services_non_dc a 
        INNER JOIN tbl_services_non_dc_details b ON a.dc_id = b.dc_id AND b.delete_status != '0' 
        LEFT JOIN tbl_customer d ON d.customer_id = a.customer_id 
        WHERE a.delete_status != '0' $cond_clause $search_clause
        GROUP BY a.dc_id, a.dc_no, a.order_id, a.billing_date, a.customer_id, a.company_name, a.mblno, a.email, a.address, a.gst_no, a.state, a.state_code, a.delivery_address, a.convert_status, a.convert_id, a.total_amount, a.refrence_name, a.vechicle_number, a.vechicle_id, a.driver_type, a.driver_name, a.driver_id, a.grand_total_amount, a.advance_amount, a.payment_terms_days, a.service_place, a.is_service_bill, a.discount, a.created_by, a.create_date, a.update_date, a.updated_by, a.delete_date, a.delete_status, a.delete_by, d.customer_id, d.customer_name 
        ORDER BY a.dc_id DESC";

$query = mysqli_query($conn, $sql);
if ((!empty($search_clause) || !empty($cond_clause)) && $query) {
	$totalFiltered = mysqli_num_rows($query);
}

$start = intval($requestData['start'] ?? 0);
$length = intval($requestData['length'] ?? 10);
if ($length <= 0) $length = 10;
$sql .= " LIMIT " . $start . ", " . $length;
$query = mysqli_query($conn, $sql);

$data = array();
$i = 1 + $start;

if ($query) {
	while ($row = mysqli_fetch_array($query)) {
		$nestedData = array();
		
		$dc_id = $row['dc_id'];
		$q_rec = mysqli_query($conn, "SELECT COALESCE(SUM(pay_amount), 0) as paid FROM tbl_services_non_receipt WHERE delete_status!='0' AND dc_id='" . $dc_id . "'");
		$r_rec = $q_rec ? mysqli_fetch_assoc($q_rec) : null;
		$paid = floatval($r_rec['paid'] ?? 0);
		$grand = floatval($row['grand_total_amount'] ?? 0);
		$bal = $grand - $paid;

		$nestedData[] = "#" . $i;
		$nestedData[] = htmlspecialchars($row['billing_date_formatted'] ?? $row['billing_date'], ENT_QUOTES, 'UTF-8');
		$nestedData[] = "<b>" . htmlspecialchars($row['dc_no'], ENT_QUOTES, 'UTF-8') . "</b>";
		$nestedData[] = htmlspecialchars($row['customer_name'] ?? 'Unknown Customer', ENT_QUOTES, 'UTF-8');
		
		$place = !empty($row['service_place']) ? $row['service_place'] : 'Workshop';
		$nestedData[] = '<span class="badge badge-info" style="font-size:12px;">' . htmlspecialchars($place, ENT_QUOTES, 'UTF-8') . '</span>';
		
		$nestedData[] = '<span style="font-size: 14px;color: blue;font-weight: bold">' . ($row['product_id'] ?? '-') . '</span>';
		$nestedData[] = '<span style="font-size: 14px;color: blue;font-weight: bold">' . ($row['qty'] ?? '-') . '</span>';
		$nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold;">' . number_format($grand, 2, '.', '') . '</span>';
		$nestedData[] = '<span style="font-size: 15px;color: green;font-weight: bold;">' . number_format($paid, 2, '.', '') . '</span>';
		$nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . number_format($bal, 2, '.', '') . '</span>';

		$actions = "<div class='btn-group' role='group'>
			<a href='services_non_sales_preview.php?id=" . $dc_id . "' title='Print Invoice'><button type='button' class='btn btn-warning' style='padding:4px 6px;'><i class='fa fa-print' style='color:#fff;'></i></button></a>&nbsp;
			<a href='services_non_sales_edit_details.php?id=" . $dc_id . "' title='Edit Bill'><button type='button' class='btn btn-danger' style='padding:4px 6px;background:green;'><i class='fa fa-edit' style='color:#fff;'></i></button></a>&nbsp;
			<a href='services_non_receipt_edit_details.php?id=" . $row['customer_id'] . "&dc_id=" . $dc_id . "' title='Pay this Bill'><button type='button' class='btn btn-success' style='padding:4px 8px;background:#15803d;'><i class='fa fa-money' style='color:#fff;'></i></button></a>&nbsp;
			<a href='javascript:void(0)' class='salesdeleteTriger' data-value='" . $dc_id . "' title='Delete'><button type='button' class='btn btn-danger' style='padding:4px 6px;'><i class='fa fa-trash' style='color:#fff;'></i></button></a>
		</div>";
		$nestedData[] = $actions;

		$data[] = $nestedData;
		$i++;
	}
}

$json_data = array(
	"draw" => intval($requestData['draw'] ?? 1),
	"recordsTotal" => intval($totalData),
	"recordsFiltered" => intval($totalFiltered),
	"data" => $data
);

echo json_encode($json_data);
?>
