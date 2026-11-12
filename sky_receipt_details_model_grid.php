<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once("sessionservices.php");

$requestData = $_REQUEST;
$draw = intval($requestData["draw"] ?? 1);
$start = intval($requestData["start"] ?? 0);
$length = intval($requestData["length"] ?? 10);
if ($length <= 0) $length = 10;

$dc_id = mysqli_real_escape_string($conn, (string)($requestData["dc_id"] ?? ""));
$customer_id = mysqli_real_escape_string($conn, (string)($requestData["customer_id"] ?? ""));

$sql = "SELECT a.receipt_id FROM tbl_sky_receipt a WHERE a.delete_status!='0' AND a.dc_id='" . $dc_id . "' AND a.customer_id='" . $customer_id . "'";
$query = mysqli_query($conn, $sql);
$totalData = $query ? mysqli_num_rows($query) : 0;
$totalFiltered = $totalData;

$sql = "SELECT a.*, date_format(a.billing_date,'%d/%m/%Y') as billing_date_formatted, b.bank_name FROM tbl_sky_receipt a 
LEFT JOIN tbl_bank_details b ON a.bank_id=b.id WHERE a.delete_status!='0' AND a.dc_id='" . $dc_id . "' AND a.customer_id='" . $customer_id . "'";

if (!empty($requestData["search"]["value"])) {
    $searchVal = mysqli_real_escape_string($conn, $requestData["search"]["value"]);
    $sql .= " AND (a.pay_amount LIKE '" . $searchVal . "%' OR a.remarks LIKE '%" . $searchVal . "%')";
    $query = mysqli_query($conn, $sql);
    $totalFiltered = $query ? mysqli_num_rows($query) : 0;
}

$sql .= " GROUP BY a.receipt_id ORDER BY a.receipt_id DESC LIMIT " . $start . ", " . $length;
$query = mysqli_query($conn, $sql);

$modes = [1=>"UPI", 2=>"Card", 3=>"Cash", 4=>"Bank Transfer", 5=>"Cheque", 6=>"Other"];

$data = array();
$i = 1 + $start;
if ($query) {
    while ($row = mysqli_fetch_array($query)) {
        $nestedData = array();
        $mode_label = $modes[$row["payment_mode"]] ?? "-";
        
        $nestedData[] = "#" . $i;
        $nestedData[] = $row["billing_date_formatted"] ?? $row["billing_date"];
        $nestedData[] = "<span style=\"font-size: 15px;color: blue;font-weight: bold;\">" . str_replace("^", "'", (!empty($row["bank_name"]) ? $row["bank_name"] : "-")) . "</span>";
        $nestedData[] = "<span style=\"font-size: 15px;color: blue;font-weight: bold;\">" . $mode_label . "</span>";
        $nestedData[] = "<span style=\"font-size: 15px;color: blue;font-weight: bold;\">" . str_replace("^", "'", $row["pay_amount"]) . "</span>";
        $nestedData[] = "<div class='btn-group' role='group'>
            <a href='javascript:void(0)' class='receipt_deleteTriger' data-value='" . $row["receipt_id"] . "'><button type='button' class='btn btn-danger' style='padding:4px 5px;'><i class='fa fa-trash' style='color: #fff;'></i></button></a>
        </div>";

        $data[] = $nestedData;
        $i++;
    }
}

echo json_encode(array(
    "draw" => $draw,
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
));
?>