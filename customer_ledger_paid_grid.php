<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
//include connection file 
include_once("sessionservices.php");
 
// storing request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$booking_type = $_REQUEST['booking_type'] ?? '';
$columns = array(
    0 => 'title',
);

// getting total number records without any search
$sql = "SELECT a.dc_id FROM tbl_gst_invoice a 
inner join tbl_gst_invoice_details b on a.dc_id=b.dc_id 
left join tbl_customer d on d.customer_id=a.customer_id 
WHERE a.delete_status!='0' and b.delete_status!='0' and d.delete_status!='0'";
$query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;

if (!empty($requestData['search']['value'])) {
    $name_search = " AND (c.customer_name LIKE '%" . $requestData['search']['value'] . "%' )";
} else {
    $name_search = "";
}

// Use Sunday-Saturday range from JavaScript
if (!empty($_POST['week_sunday']) && !empty($_POST['week_saturday'])) {
    $start_date = $_POST['week_sunday'];
    $end_date = $_POST['week_saturday'];
    $where_date = " AND a.billing_date BETWEEN '$start_date' AND '$end_date' ";
} elseif (!empty($_POST['week_ww_yyyy'])) {
    // Fallback: Convert from ISO week to Sunday-Saturday
    $week = $_POST['week_ww_yyyy'];
    $year = substr($week, 0, 4);
    $weekNum = substr($week, 6);
    
    // Calculate Sunday of the week (Sunday-Saturday)
    $jan1 = new DateTime($year . '-01-01');
    $dayOfWeek = $jan1->format('w'); // 0=Sunday
    
    // Calculate Monday of ISO week
    $monday = new DateTime($year . '-01-01');
    $monday->modify('+' . (($weekNum - 1) * 7) . ' days');
    $monday->modify('-' . ($dayOfWeek - 1) . ' days');
    
    // Sunday = Monday - 1 day
    $sunday = clone $monday;
    $sunday->modify('-1 day');
    
    // Saturday = Sunday + 6 days
    $saturday = clone $sunday;
    $saturday->modify('+6 days');
    
    $start_date = $sunday->format('Y-m-d');
    $end_date = $saturday->format('Y-m-d');
    $where_date = " AND a.billing_date BETWEEN '$start_date' AND '$end_date' ";
} else {
    // Default to current week (Sunday-Saturday)
    $today = new DateTime();
    $currentDayOfWeek = $today->format('w'); // 0=Sunday
    
    // Get Sunday of current week
    $sunday = clone $today;
    $sunday->modify('-' . $currentDayOfWeek . ' days');
    
    // Get Saturday (6 days after Sunday)
    $saturday = clone $sunday;
    $saturday->modify('+6 days');
    
    $start_date = $sunday->format('Y-m-d');
    $end_date = $saturday->format('Y-m-d');
    $where_date = " AND a.billing_date BETWEEN '$start_date' AND '$end_date' ";
}

$sql = "
SELECT 
    
    
    a.customer_id,
    c.customer_name,
    IFNULL(SUM(paid_data.paid), 0) AS paid,
    IFNULL(SUM(total_data.total_amount), 0) AS total_amount,
    IFNULL(SUM(total_data.total_amount), 0) - IFNULL(SUM(paid_data.paid), 0) AS balance

FROM tbl_gst_invoice a

LEFT JOIN tbl_customer c
    ON c.customer_id = a.customer_id

LEFT JOIN (
    SELECT dc_id, SUM(pay_amount) AS paid
    FROM tbl_receipt
    WHERE delete_status!='0'
      AND billing_date BETWEEN '$start_date' AND '$end_date'
    GROUP BY dc_id
) AS paid_data ON paid_data.dc_id = a.dc_id

LEFT JOIN (
    SELECT dc_id, SUM(grand_total_amount) AS total_amount
    FROM tbl_gst_invoice
    WHERE delete_status!='0'
      AND billing_date BETWEEN '$start_date' AND '$end_date'
    GROUP BY dc_id
) AS total_data ON total_data.dc_id = a.dc_id

WHERE a.delete_status!='0' AND c.delete_status!='0'
-- An invoice must still have at least one non-deleted detail line. This used to be an
-- INNER JOIN to tbl_gst_invoice_details, but that duplicates this row once per detail
-- line, which then double(or more)-counts total_amount/paid/balance for any invoice with
-- more than one product line. EXISTS filters the same way without duplicating rows.
AND EXISTS (
    SELECT 1 FROM tbl_gst_invoice_details b
    WHERE b.dc_id = a.dc_id AND b.delete_status!='0'
)
$where_date $name_search

GROUP BY  a.customer_id, c.customer_name
ORDER BY c.customer_name ASC
";

$query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

$total_amount = '0';
$total_paid = '0';
$total_balance = '0';

$data = array();
$i = 1 + $requestData['start'];
while ($row = mysqli_fetch_array($query)) {
    $nestedData = array();



    $nestedData[] = "#" . $i;

    $nestedData[] = '<a href="receipt_preview.php?id=' . $row['customer_id'] . '"><span style="font-size: 15px;color: #16a34a;font-weight: bold;">' . htmlspecialchars(str_replace("^", "'", $row["customer_name"]), ENT_QUOTES, 'UTF-8') . '</span></a>';



    $nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">' . str_replace("^", "'", $row["total_amount"]) . '</span>';

    $nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">' . str_replace("^", "'", $row["paid"]) . '</span>';

    $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . str_replace("^", "'", ($row["balance"])) . '</span>';

    $total_amount = $total_amount + $row["total_amount"];
    $total_paid = $total_paid + $row["paid"];
    $total_balance = $total_balance + $row["balance"];

    $data[] = $nestedData;
    $i++;
}

// Add total row
$nestedData1 = array();
$nestedData1[] = "Total";
$nestedData1[] = '';
$nestedData1[] = '';
$nestedData1[] = '';

$nestedData1[] = "<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;'>" . $total_amount . "</span>";
$nestedData1[] = "<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;'>" . $total_paid . "</span>";
$nestedData1[] = "<span style='background: red;padding: 5px 5px;color: #fff;border-radius: 4px;'>" . $total_balance . "</span>";
$nestedData1[] = '';
$data[] = $nestedData1;

$json_data = array(
    "draw" => intval($requestData['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
);

echo json_encode($json_data);
?>