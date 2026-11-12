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

$base_query = "
    FROM (
        SELECT 
            c.customer_id,
            c.customer_name,
            c.address,
            c.mblno,
            inv.first_bill_date,
            IFNULL(inv.total_amount, 0) AS total_amount,
            IFNULL(rec.paid, 0) AS paid,
            IFNULL(inv.total_amount, 0) - IFNULL(rec.paid, 0) AS balance
        FROM tbl_customer c
        INNER JOIN (
            SELECT customer_id, SUM(grand_total_amount) AS total_amount, MIN(billing_date) AS first_bill_date
            FROM tbl_services_non_dc
            WHERE delete_status!='0'
            GROUP BY customer_id
        ) inv ON inv.customer_id = c.customer_id
        LEFT JOIN (
            SELECT customer_id, SUM(pay_amount) AS paid
            FROM tbl_services_non_receipt
            WHERE delete_status!='0'
            GROUP BY customer_id
        ) rec ON rec.customer_id = c.customer_id
        WHERE c.delete_status!='0'
    ) AS derived
    WHERE derived.balance > 0
";

// Total records
$totalData = 0;
$tRes = mysqli_query($conn, "SELECT COUNT(*) as cnt " . $base_query);
if ($tRes && ($tRow = mysqli_fetch_assoc($tRes))) {
    $totalData = intval($tRow['cnt']);
}
$totalFiltered = $totalData;

if ($name_search !== '') {
    $fRes = mysqli_query($conn, "SELECT COUNT(*) as cnt " . $base_query . $name_search);
    if ($fRes && ($fRow = mysqli_fetch_assoc($fRes))) {
        $totalFiltered = intval($fRow['cnt']);
    }
}

$sql = "SELECT * " . $base_query . $name_search . " ORDER BY customer_name ASC";
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
        $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . number_format($bAmt, 2, '.', '') . '</span>';

        $days_html = '';
        $fbd = $row['first_bill_date'] ?? '';
        if ($fbd !== '' && $fbd !== '0000-00-00' && strtotime($fbd)) {
            $days = max(0, (int)(new DateTime(date('Y-m-d')))->diff(new DateTime(date('Y-m-d', strtotime($fbd))))->days);
            $days_color = $days >= 30 ? 'red' : ($days >= 15 ? '#d97706' : 'green');
            $days_html = '<span style="font-size: 15px;color: ' . $days_color . ';font-weight: bold;">' . $days . ' days</span>';
        }
        $nestedData[] = $days_html;

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
$nestedData1[] = '';
$data[] = $nestedData1;

$json_data = array(
    "draw"            => $draw,
    "recordsTotal"    => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data"            => $data
);

echo json_encode($json_data);
?>