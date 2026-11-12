<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
}

include_once("sessionservices.php");

$requestData = $_REQUEST;
$draw = intval($requestData['draw'] ?? 1);
$start = max(0, intval($requestData['start'] ?? 0));
$length = intval($requestData['length'] ?? 10);

$name_search = "";
if (!empty($requestData['search']['value'])) {
    $sv = mysqli_real_escape_string($conn, trim($requestData['search']['value']));
    $name_search = " AND (c.customer_name LIKE '%" . $sv . "%' OR c.address LIKE '%" . $sv . "%' OR c.mblno LIKE '%" . $sv . "%') ";
}

// Determine date range
if (!empty($_POST['week_sunday']) && !empty($_POST['week_saturday'])) {
    $start_date = mysqli_real_escape_string($conn, $_POST['week_sunday']);
    $end_date = mysqli_real_escape_string($conn, $_POST['week_saturday']);
    $where_date = " AND a.billing_date BETWEEN '$start_date' AND '$end_date' ";
} elseif (!empty($_POST['week_ww_yyyy'])) {
    $week = trim($_POST['week_ww_yyyy']);
    $year = substr($week, 0, 4);
    $weekNum = substr($week, 6);

    try {
        $date = new DateTime();
        $date->setISODate(intval($year), intval($weekNum));
        $start_date = $date->format('Y-m-d');
        $end_date = $date->modify('+6 days')->format('Y-m-d');
    } catch (Exception $e) {
        $start_date = date('Y-m-d', strtotime('sunday last week'));
        $end_date = date('Y-m-d', strtotime('saturday this week'));
    }
    $where_date = " AND a.billing_date BETWEEN '$start_date' AND '$end_date' ";
} else {
    // Default to current week (Sunday to Saturday)
    $today = new DateTime();
    $currentDayOfWeek = intval($today->format('w')); // 0=Sunday
    $sunday = clone $today;
    $sunday->modify('-' . $currentDayOfWeek . ' days');
    $saturday = clone $sunday;
    $saturday->modify('+6 days');

    $start_date = $sunday->format('Y-m-d');
    $end_date = $saturday->format('Y-m-d');
    $where_date = " AND a.billing_date BETWEEN '$start_date' AND '$end_date' ";
}

$base_query = "
    FROM tbl_services_non_dc a
    LEFT JOIN tbl_customer c ON c.customer_id = a.customer_id
    LEFT JOIN (
        SELECT dc_id, SUM(pay_amount) AS paid
        FROM tbl_services_non_receipt
        WHERE delete_status!='0'
          AND billing_date BETWEEN '$start_date' AND '$end_date'
        GROUP BY dc_id
    ) AS paid_data ON paid_data.dc_id = a.dc_id
    LEFT JOIN (
        SELECT dc_id, SUM(grand_total_amount) AS total_amount
        FROM tbl_services_non_dc
        WHERE delete_status!='0'
          AND billing_date BETWEEN '$start_date' AND '$end_date'
        GROUP BY dc_id
    ) AS total_data ON total_data.dc_id = a.dc_id
    WHERE a.delete_status!='0' AND c.delete_status!='0'
      $where_date $name_search
";

// Count total groups
$total_sql = "SELECT a.customer_id " . $base_query . " GROUP BY a.customer_id, c.customer_name";
$tRes = mysqli_query($conn, $total_sql);
$totalData = $tRes ? mysqli_num_rows($tRes) : 0;
$totalFiltered = $totalData;

$sql = "SELECT 
            a.customer_id,
            c.customer_name,
            c.mblno,
            IFNULL(SUM(paid_data.paid), 0) AS paid,
            IFNULL(SUM(total_data.total_amount), 0) AS total_amount,
            IFNULL(SUM(total_data.total_amount), 0) - IFNULL(SUM(paid_data.paid), 0) AS balance
        " . $base_query . "
        GROUP BY a.customer_id, c.customer_name
        ORDER BY c.customer_name ASC";

if ($length > 0) {
    $sql .= " LIMIT " . $start . ", " . $length;
}

$query = mysqli_query($conn, $sql);

$total_amount = 0;
$total_paid = 0;
$total_balance = 0;

$data = array();
$i = 1 + $start;
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $nestedData = array();
        $cid = $row['customer_id'];
        $cname = $row["customer_name"] ?? '-';
        $tAmt = floatval($row["total_amount"]);
        $pAmt = floatval($row["paid"]);
        $bAmt = floatval($row["balance"]);

        $nestedData[] = "#" . $i;
        $nestedData[] = '<a href="services_non_receipt_preview.php?id=' . $cid . '"><span style="font-size: 15px;color: #16a34a;font-weight: bold;">' . htmlspecialchars($cname, ENT_QUOTES, 'UTF-8') . '</span></a>'
            . (trim((string)($row['mblno'] ?? '')) !== '' ? '<br><span style="font-size:12px;color:#64748b;"><i class="fa fa-phone"></i> ' . htmlspecialchars(trim($row['mblno']), ENT_QUOTES, 'UTF-8') . '</span>' : '');
        $nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">' . number_format($tAmt, 2, '.', '') . '</span>';
        $nestedData[] = '<span style="font-size: 15px;color: green;font-weight: bold">' . number_format($pAmt, 2, '.', '') . '</span>';
        $nestedData[] = "<a href='services_non_receipt_edit_details.php?id=" . $cid . "'><button type='button' class='btn btn-danger' style='padding:4px 8px;background: red;border-color:red;font-weight:bold;'>" . number_format($bAmt, 2, '.', '') . "</button></a>";

        $total_amount += $tAmt;
        $total_paid += $pAmt;
        $total_balance += $bAmt;

        $data[] = $nestedData;
        $i++;
    }
}

$nestedData1 = array();
$nestedData1[] = "Total";
$nestedData1[] = '';
$nestedData1[] = "<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;font-weight:bold;'>" . number_format($total_amount, 2, '.', '') . "</span>";
$nestedData1[] = "<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;font-weight:bold;'>" . number_format($total_paid, 2, '.', '') . "</span>";
$nestedData1[] = "<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;font-weight:bold;'>" . number_format($total_balance, 2, '.', '') . "</span>";
$data[] = $nestedData1;

$json_data = array(
    "draw"            => $draw,
    "recordsTotal"    => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data"            => $data
);

echo json_encode($json_data);
?>
