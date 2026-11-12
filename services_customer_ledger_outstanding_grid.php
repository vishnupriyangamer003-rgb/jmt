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
    $name_search = " AND (c.customer_name LIKE '%" . $sv . "%' OR c.address LIKE '%" . $sv . "%') ";
}

$base_query = "
    FROM tbl_customer c
    INNER JOIN (
        SELECT customer_id, SUM(grand_total_amount) AS total_amount
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
";

// Total distinct customers
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

$sql = "SELECT 
            c.customer_id,
            c.customer_name,
            IFNULL(inv.total_amount, 0) AS total_amount,
            IFNULL(rec.paid, 0) AS paid,
            IFNULL(inv.total_amount, 0) - IFNULL(rec.paid, 0) AS balance
        " . $base_query . $name_search . "
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
        $nestedData[] = '<a href="services_non_receipt_preview.php?id=' . $cid . '"><span style="font-size: 15px;color: #16a34a;font-weight: bold;">' . htmlspecialchars($cname, ENT_QUOTES, 'UTF-8') . '</span></a>';
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