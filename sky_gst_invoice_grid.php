<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
// Production-safe: log errors, never print into JSON responses
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Set JSON header first
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Recursively replace any byte sequence that isn't valid UTF-8 so json_encode() never
// fails outright on legacy latin1-collated data (works on any PHP version, unlike the
// JSON_INVALID_UTF8_SUBSTITUTE flag which needs PHP >= 7.2).
function sky_grid_utf8ize($mixed) {
 if (is_array($mixed)) {
 foreach ($mixed as $key => $value) {
 $mixed[$key] = sky_grid_utf8ize($value);
 }
 return $mixed;
 }
 if (is_string($mixed)) {
 if (function_exists('mb_convert_encoding')) {
 return mb_convert_encoding($mixed, 'UTF-8', 'UTF-8');
 }
 if (function_exists('iconv')) {
 $clean = @iconv('UTF-8', 'UTF-8//IGNORE', $mixed);
 if ($clean !== false) {
 return $clean;
 }
 }
 // Last-resort fallback with no extension dependency: strip anything outside
 // printable ASCII rather than let the whole response fail to encode.
 return preg_replace('/[\x80-\xFF]/', '', $mixed);
 }
 return $mixed;
}

try {
 // Check if connection file exists
 if (!file_exists("sessionservices.php")) {
 throw new Exception("sessionservices.php file not found");
 }
 
 include_once("sessionservices.php");
 
 // Check database connection
 if (!isset($conn) || !$conn) {
 throw new Exception("Database connection failed: " . mysqli_connect_error());
 }
 
 // Get request data safely
 $requestData = $_REQUEST;
 
 // Check if booking_type exists
 $booking_type = isset($_REQUEST['booking_type']) ? $_REQUEST['booking_type'] : '';
 
 // Initialize variables
 $total_discount = 0;
 $total_gst = 0;
 $total_grand_total_amount = 0;
 
 // Get total number of records without any search
 $sql = "SELECT COUNT(DISTINCT a.dc_id) as total FROM tbl_sky_gst_invoice a WHERE a.delete_status!='0'";
 $query = mysqli_query($conn, $sql);
 
 if (!$query) {
 throw new Exception("Error in count query: " . mysqli_error($conn));
 }
 
 $row = mysqli_fetch_assoc($query);
 $totalData = $row['total'];
 $totalFiltered = $totalData;
 
 // Build main query based on condition
 if (isset($_POST['cond'])) {
 if (($_POST['cond'] ?? '') == "firstbind") {
 $sql = "SELECT a.*, 
 a.dc_id, a.dc_no, a.driver_id, a.driver_name, 
 a.vechicle_number, a.vechicle_id, a.driver_type,
 a.total_amount, a.gst_total_amount, a.discount, 
 a.grand_total_amount,
 d.customer_id, d.customer_name, d.mblno, d.gst_no, d.address,
 GROUP_CONCAT(DISTINCT b.product_id SEPARATOR ',<br/>') as product_id,
 GROUP_CONCAT(DISTINCT b.qty SEPARATOR ',<br/>') as qty,
 GROUP_CONCAT(DISTINCT b.rate SEPARATOR ',<br/>') as rate,
 DATE_FORMAT(a.create_date, '%d/%m/%Y %r') as create_date,
 a.billing_date as raw_billing_date,DATE_FORMAT(a.billing_date, '%d/%m/%Y') as billing_date,
 DATE_FORMAT(a.update_date, '%d/%m/%Y %r') as update_date,
 a.created_by, a.updated_by, a.convert_status
 FROM tbl_sky_gst_invoice a
 INNER JOIN tbl_sky_gst_invoice_details b ON a.dc_id = b.dc_id
 LEFT JOIN tbl_customer d ON d.customer_id = a.customer_id
 WHERE a.delete_status!='0' AND b.delete_status!='0' AND d.delete_status!='0'";
 }
 else if (($_POST['cond'] ?? '') == "searchbind") {
 // Validate dates
 if (!isset($_POST['fdate']) || !isset($_POST['tdate'])) {
 throw new Exception("From date and To date are required");
 }
 
 $fdate = date('Y-m-d', strtotime($_POST['fdate']));
 $tdate = date('Y-m-d', strtotime($_POST['tdate']));
 
 // Escape parameters

 $sql = "SELECT a.*, 
 a.dc_id, a.dc_no, a.driver_id, a.driver_name, 
 a.vechicle_number, a.vechicle_id, a.driver_type,
 a.total_amount, a.gst_total_amount, a.discount, 
 a.grand_total_amount,
 d.customer_id, d.customer_name, d.mblno, d.gst_no, d.address,
 GROUP_CONCAT(DISTINCT b.product_id SEPARATOR ',<br/>') as product_id,
 GROUP_CONCAT(DISTINCT b.qty SEPARATOR ',<br/>') as qty,
 GROUP_CONCAT(DISTINCT b.rate SEPARATOR ',<br/>') as rate,
 DATE_FORMAT(a.create_date, '%d/%m/%Y %r') as create_date,
 a.billing_date as raw_billing_date,DATE_FORMAT(a.billing_date, '%d/%m/%Y') as billing_date,
 DATE_FORMAT(a.update_date, '%d/%m/%Y %r') as update_date,
 a.created_by, a.updated_by, a.convert_status
 FROM tbl_sky_gst_invoice a
 INNER JOIN tbl_sky_gst_invoice_details b ON a.dc_id = b.dc_id
 LEFT JOIN tbl_customer d ON d.customer_id = a.customer_id
 WHERE a.delete_status!='0' AND b.delete_status!='0' AND d.delete_status!='0'
 AND a.billing_date BETWEEN '" . mysqli_real_escape_string($conn, $fdate) . "'
 AND '" . mysqli_real_escape_string($conn, $tdate) . "'
 ";
 
 // Add customer filter if provided
 if (!empty($_POST['customer_id'])) {
 $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
 $sql .= " AND a.customer_id = '$customer_id'";
 }
 }
 } else {
 // Default query if no condition
 $sql = "SELECT a.*, 
 a.dc_id, a.dc_no, a.driver_id, a.driver_name, 
 a.vechicle_number, a.vechicle_id, a.driver_type,
 a.total_amount, a.gst_total_amount, a.discount, 
 a.grand_total_amount,
 d.customer_id, d.customer_name, d.mblno, d.gst_no, d.address,
 GROUP_CONCAT(DISTINCT b.product_id SEPARATOR ',<br/>') as product_id,
 GROUP_CONCAT(DISTINCT b.qty SEPARATOR ',<br/>') as qty,
 GROUP_CONCAT(DISTINCT b.rate SEPARATOR ',<br/>') as rate,
 DATE_FORMAT(a.create_date, '%d/%m/%Y %r') as create_date,
 a.billing_date as raw_billing_date,DATE_FORMAT(a.billing_date, '%d/%m/%Y') as billing_date,
 DATE_FORMAT(a.update_date, '%d/%m/%Y %r') as update_date,
 a.created_by, a.updated_by, a.convert_status
 FROM tbl_sky_gst_invoice a
 INNER JOIN tbl_sky_gst_invoice_details b ON a.dc_id = b.dc_id
 LEFT JOIN tbl_customer d ON d.customer_id = a.customer_id
 WHERE a.delete_status!='0' AND b.delete_status!='0' AND d.delete_status!='0'";
 }
 
 // Apply search filter
 if (!empty($requestData['search']['value'])) {
 $searchValue = mysqli_real_escape_string($conn, $requestData['search']['value']);
 
 if (stripos($sql, 'WHERE') === false) {
 $sql .= " WHERE (d.customer_name LIKE '%$searchValue%' OR a.dc_no LIKE '%$searchValue%')";
 } else {
 $sql .= " AND (d.customer_name LIKE '%$searchValue%' OR a.dc_no LIKE '%$searchValue%')";
 }
 }
 
 // Get filtered count
 $countSql = $sql . " GROUP BY a.dc_id";
 $countQuery = mysqli_query($conn, $countSql);
 
 if (!$countQuery) {
 throw new Exception("Error in filtered count query: " . mysqli_error($conn));
 }
 
 $totalFiltered = mysqli_num_rows($countQuery);
 
 // Add ORDER BY, GROUP BY and LIMIT for actual data
 $start = isset($requestData['start']) ? intval($requestData['start']) : 0;
 $length = isset($requestData['length']) ? intval($requestData['length']) : 10;
 
 $sql .= " GROUP BY a.dc_id ORDER BY a.billing_date DESC, a.dc_id DESC LIMIT $start, $length";
 
 // Execute main query
 $query = mysqli_query($conn, $sql);
 
 if (!$query) {
 throw new Exception("Error in main query: " . mysqli_error($conn));
 }
 
 // Prepare data array
 $data = array();
 $i = 1 + $start;
 
 while ($row = mysqli_fetch_assoc($query)) {
 $nestedData = array();
 
 // Process product list
 $product_list = array();
 if (!empty($row['product_id'])) {
 $product_list = explode(",<br/>", $row['product_id']);
 }
 
 $excess = '';
 $first = true;
 
 foreach ($product_list as $product) {
 if (!empty($product) && is_numeric($product)) {
 $gql3 = "SELECT product_name FROM tbl_products where delete_status!='0' and product_id= '" . mysqli_real_escape_string($conn, $product) . "'";
 $exec_gql3 = mysqli_query($conn, $gql3);
 
 if ($exec_gql3 && mysqli_num_rows($exec_gql3) > 0) {
 while ($fetch_gql3 = mysqli_fetch_assoc($exec_gql3)) {
 if (!$first) {
 $excess .= "<br>";
 }
 $excess .= $fetch_gql3["product_name"];
 $first = false;
 }
 }
 }
 }
 
 
 
 // Prepare row data
 $nestedData[] = "#" . $i;
 	$days_badge = '';
	if (!empty($row["raw_billing_date"])) {
		$diff_days = (int)floor((strtotime(date('Y-m-d')) - strtotime(substr($row["raw_billing_date"], 0, 10))) / 86400);
		if ($diff_days < 0) {
			$days_badge = '<br><span class="badge badge-secondary" style="font-size:10px;padding:2px 5px;margin-top:2px;">Future</span>';
		} else if ($diff_days === 0) {
			$days_badge = '<br><span class="badge badge-success" style="font-size:10px;padding:2px 5px;margin-top:2px;">Today (0 days)</span>';
		} else if ($diff_days === 1) {
			$days_badge = '<br><span class="badge badge-info" style="font-size:10px;padding:2px 5px;margin-top:2px;">1 day</span>';
		} else {
			$days_badge = '<br><span class="badge badge-primary" style="font-size:10px;padding:2px 5px;margin-top:2px;">' . $diff_days . ' days</span>';
		}
	}
	$nestedData[] = (!empty($row["billing_date"]) ? $row["billing_date"] : '-') . $days_badge;
 $nestedData[] = !empty($row["dc_no"]) ? $row["dc_no"] : '-';
 $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . 
 (!empty($row["customer_name"]) ? $row["customer_name"] : '-') . 
 '<br>' . (!empty($row["mblno"]) ? $row["mblno"] : '') . '</span>';
 $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . 
 (!empty($row["gst_no"]) ? $row["gst_no"] : '-') . '</span>';
 $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . 
 (!empty($row["address"]) ? $row["address"] : '-') . '</span>';
 
 // Vehicle info based on driver type
 if (isset($row["driver_type"])) {
 if ($row["driver_type"] == '1' && !empty($row["vechicle_id"])) {
 $gql_vechicle = "SELECT vechicle_name FROM tbl_vechicle_details where delete_status!='0' and vechicle_id= '" . mysqli_real_escape_string($conn, $row["vechicle_id"]) . "'";
 $exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
 if ($exec_gql_vechicle && mysqli_num_rows($exec_gql_vechicle) > 0) {
 $fetch_gql_vechicle = mysqli_fetch_assoc($exec_gql_vechicle);
 $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . $fetch_gql_vechicle["vechicle_name"] . '</span>';
 } else {
 $nestedData[] = '-';
 }
 } elseif ($row["driver_type"] == '2' && !empty($row["vechicle_number"])) {
 $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . $row["vechicle_number"] . '</span>';
 } else {
 $nestedData[] = '-';
 }
 } else {
 $nestedData[] = '-';
 }
 
 // Products
 $nestedData[] = !empty($excess) ? '<span style="font-size: 15px;color: #000;font-weight: bold">' . $excess . '</span>' : '-';
 
 // Quantities and rates
 $nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">' . 
 (!empty($row["qty"]) ? $row["qty"] : '-') . '</span>';
 $nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">' . 
 (!empty($row["rate"]) ? $row["rate"] : '-') . '</span>';
 
 // Amounts
 $gst_amount = !empty($row["gst_total_amount"]) ? round($row["gst_total_amount"], 2) : 0;
 $discount = !empty($row["discount"]) ? round($row["discount"], 2) : 0;
 $grand_total = !empty($row["grand_total_amount"]) ? round($row["grand_total_amount"], 2) : 0;
 
 $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . $gst_amount . '</span>';
 $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . $discount . '</span>';
 $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . $grand_total . '</span>';
 
 // Action buttons
 $nestedData[] = "<div class='btn-group' role='group'>
 <a href='sky_gst_invoice_preview.php?id=" . $row['dc_id'] . "'><button type='button' class='btn btn-warning' style='padding:4px 5px;'><i class='fa fa-print' style='color: #fff;font-size: 18px;'></i></button></a>
 <a href='sky_gst_invoice_edit_details.php?id=" . $row['dc_id'] . "'><button type='button' class='btn btn-danger' style='padding:4px 5px;background: green'><i class='fa fa-edit' style='color: #fff;font-size: 18px;'></i></button></a>
 <a href='javascript:void(0)' class='gstinvoicedeleteTriger' data-value='" . $row['dc_id'] . "'><button type='button' class='btn btn-danger' style='padding:4px 5px;'><i class='fa fa-trash' style='color: #fff;font-size: 18px;'></i></button></a>
 </div>";
 
 $nestedData[] = !empty($row["convert_status"]) ? $row["convert_status"] : '-';
 
 $data[] = $nestedData;
 
 // Calculate totals
 $total_discount += $discount;
 $total_gst += $gst_amount;
 $total_grand_total_amount += $grand_total;
 
 $i++;
 }
 
 // Add total row
 $totalRow = array_fill(0, 15, ''); // Create array with 17 empty elements
 $totalRow[0] = "Total";
 $totalRow[10] = $total_gst; // GST column
 $totalRow[11] = $total_discount; // Discount column
 $totalRow[12] = $total_grand_total_amount; // Grand total column
 
 $data[] = $totalRow;
 
 // Prepare JSON response
 $json_data = array(
 "draw" => isset($requestData['draw']) ? intval($requestData['draw']) : 0,
 "recordsTotal" => intval($totalData),
 "recordsFiltered" => intval($totalFiltered),
 "data" => $data
 );
 
 // The customer/product tables use a latin1 collation while this app is served as
 // UTF-8; json_encode() fails outright (returns false, i.e. an empty response) if any
 // string in the payload isn't valid UTF-8, which silently breaks the whole grid once
 // enough rows are requested to include one such value. Sanitize instead of failing.
 // (Not using the JSON_INVALID_UTF8_SUBSTITUTE flag here since it needs PHP >= 7.2.)
 echo json_encode(sky_grid_utf8ize($json_data));

} catch (Exception $e) {
 // Return error as JSON
 echo json_encode(array(
 "error" => true,
 "message" => $e->getMessage(),
 "draw" => isset($requestData['draw']) ? intval($requestData['draw']) : 0,
 "recordsTotal" => 0,
 "recordsFiltered" => 0,
 "data" => array()
 ));
}
?>
