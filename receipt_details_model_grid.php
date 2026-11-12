<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include_once("sessionservices.php");

$requestData = $_REQUEST;

$draw = intval($requestData['draw'] ?? 1);
$start = max(0, intval($requestData['start'] ?? 0));
$length = intval($requestData['length'] ?? 10);
if ($length <= 0) $length = 10;
$searchVal = trim($requestData['search']['value'] ?? '');

$dc_id = intval($requestData['dc_id'] ?? 0);
$customer_id = intval($requestData['customer_id'] ?? 0);

// Total records
$totalData = 0;
$cntSql = "SELECT COUNT(*) as cnt FROM tbl_receipt WHERE delete_status!='0' AND dc_id='$dc_id' AND customer_id='$customer_id'";
$cntRes = mysqli_query($conn, $cntSql);
if ($cntRes && ($cRow = mysqli_fetch_assoc($cntRes))) {
    $totalData = intval($cRow['cnt']);
}
$totalFiltered = $totalData;

$whereSql = " WHERE a.delete_status!='0' AND a.dc_id='$dc_id' AND a.customer_id='$customer_id' ";
if ($searchVal !== '') {
    $escaped = mysqli_real_escape_string($conn, $searchVal);
    $whereSql .= " AND (b.bank_name LIKE '%$escaped%' OR a.pay_amount LIKE '%$escaped%' OR a.ref_no LIKE '%$escaped%') ";
    $fRes = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM tbl_receipt a LEFT JOIN tbl_bank_details b ON a.bank_id=b.id " . $whereSql);
    if ($fRes && ($fRow = mysqli_fetch_assoc($fRes))) {
        $totalFiltered = intval($fRow['cnt']);
    }
}

$sql = "SELECT a.*, DATE_FORMAT(a.billing_date, '%d/%m/%Y') as billing_date1, b.bank_name 
        FROM tbl_receipt a 
        LEFT JOIN tbl_bank_details b ON a.bank_id=b.id 
        " . $whereSql . " 
        ORDER BY a.receipt_id DESC 
        LIMIT $start, $length";

$query = mysqli_query($conn, $sql);

$data = array();
$i = 1 + $start;
if ($query) {
    while ($row = mysqli_fetch_array($query)) {
        $nestedData = array();
        
        $modeMap = [
            '1' => 'UPI',
            '2' => 'Card',
            '3' => 'Cash',
            '4' => 'Bank Transfer',
            '5' => 'Cheque',
            '6' => 'Other'
        ];
        $payment_mode = $modeMap[(string)$row['payment_mode']] ?? '-';

        $nestedData[] = "#" . $i;
        $nestedData[] = htmlspecialchars($row["billing_date1"] ?? '', ENT_QUOTES, 'UTF-8');
        $nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">' . htmlspecialchars($row["bank_name"] ?? '-', ENT_QUOTES, 'UTF-8') . '</span>';
        $nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">' . htmlspecialchars($payment_mode, ENT_QUOTES, 'UTF-8') . '</span>';
        $nestedData[] = '<span style="font-size: 15px;color: green;font-weight: bold">' . htmlspecialchars((string)$row["pay_amount"], ENT_QUOTES, 'UTF-8') . '</span>';
        $nestedData[] = "<div class='btn-group' role='group'>
                            <a href='javascript:void(0)' class='receipt_deleteTriger' data-value='" . $row['receipt_id'] . "'>
                                <button type='button' class='btn btn-danger' style='padding:4px 5px 5px 2px;'>
                                    <i class='fa fa-trash' style='color: #fff;font-size: 18px;'></i>
                                </button>
                            </a>
                        </div>";

        $data[] = $nestedData;
        $i++;
    }
}

$json_data = array(
    "draw"            => $draw,
    "recordsTotal"    => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data"            => $data
);

echo json_encode($json_data);