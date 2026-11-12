<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include_once("sessionservices.php");

$requestData = $_REQUEST;
$customer_id = isset($_POST['customer_id']) ? mysqli_real_escape_string($conn, $_POST['customer_id']) : '';

if (empty($customer_id)) {
    echo json_encode(array("data" => array()));
    exit;
}

$sql = "
    SELECT create_date, dc_id, billing_date,
           DATE_FORMAT(billing_date, '%d/%m/%Y') AS billing_date1,
           dc_no, grand_total_amount AS amount, total_amount,
           1 AS record_type
    FROM tbl_gst_invoice
    WHERE delete_status!='0' AND customer_id = '{$customer_id}'

    UNION ALL

    SELECT create_date, dc_id, billing_date,
           DATE_FORMAT(billing_date, '%d/%m/%Y') AS billing_date1,
           dc_no, pay_amount AS amount, NULL AS total_amount, 
           2 AS record_type
    FROM tbl_receipt
    WHERE delete_status!='0' AND customer_id = '{$customer_id}'

    ORDER BY billing_date ASC, create_date ASC
";

$query = mysqli_query($conn, $sql) or die("SQL error: " . mysqli_error($conn));

$data = array();
$balance = 0;

while ($row = mysqli_fetch_assoc($query)) {
    $nested = array();
    $row_amount = floatval($row['amount'] ?? 0);
    $billing_date_display = !empty($row['billing_date1']) ? $row['billing_date1'] : date('d/m/Y', strtotime($row['billing_date']));

    if ($row['record_type'] == 1) {
        $balance += $row_amount;

        $dc_id_safe = mysqli_real_escape_string($conn, $row['dc_id']);
        $sql_details = "
            SELECT a.*, 
                   GROUP_CONCAT(b.product_id SEPARATOR ',<br/>') AS product_id,
                   GROUP_CONCAT(b.qty SEPARATOR ',<br/>') AS qty,
                   GROUP_CONCAT(b.product_rate SEPARATOR ',<br/>') AS product_rate
            FROM tbl_gst_invoice a
            LEFT JOIN tbl_gst_invoice_details b ON a.dc_id = b.dc_id AND b.delete_status!='0'
            WHERE a.dc_id = '{$dc_id_safe}' AND a.customer_id = '{$customer_id}'
            GROUP BY a.dc_id
        ";
        $det = mysqli_fetch_assoc(mysqli_query($conn, $sql_details));

        $driver_name = '-';
        $vehicle_number = '-';
        $product_list_str = $det['product_id'] ?? '';
        $qty_list = $det['qty'] ?? '';
        $product_rate = $det['product_rate'] ?? '';

        $nested[0] = '<div style="text-align:center;">' . $billing_date_display . '</div>';
        $nested[1] = '<div style="text-align:left;"><b>Invoice No :</b> ' . htmlspecialchars($row['dc_no']) . '</div>';
        $nested[2] = '<div style="text-align:center;">Bill</div>';
        $nested[3] = '<div style="text-align:right;">' . number_format($row_amount, 2, '.', '') . '</div>';
        $nested[4] = '<div style="text-align:right;">-</div>';
        $nested[5] = '<div style="text-align:right;">' . number_format($balance, 2, '.', '') . '</div>';
    } else {
        $balance -= $row_amount;

        $pay_sql = "SELECT * FROM tbl_receipt WHERE delete_status!='0' AND dc_id='" . intval($row['dc_id']) . "'";
        $pay_query = mysqli_query($conn, $pay_sql);
        $pay_row = $pay_query ? mysqli_fetch_array($pay_query) : null;

        $pm = $pay_row['payment_mode'] ?? '';
        if ($pm == 1 || $pm == '1') $payment_mode = 'UPI';
        else if ($pm == 2 || $pm == '2') $payment_mode = 'Card';
        else if ($pm == 3 || $pm == '3') $payment_mode = 'Cash';
        else if ($pm == 4 || $pm == '4') $payment_mode = 'Bank Transfer';
        else if ($pm == 5 || $pm == '5') $payment_mode = 'Cheque';
        else if ($pm == 6 || $pm == '6') $payment_mode = 'Other';
        else $payment_mode = '-';

        $bank_name = '';
        if (!empty($pay_row['bank_id'])) {
            $bank_sql = "SELECT bank_name FROM tbl_bank_details WHERE delete_status!='0' AND id='" . intval($pay_row['bank_id']) . "'";
            $bank_res = mysqli_query($conn, $bank_sql);
            if ($bank_res && ($bRow = mysqli_fetch_assoc($bank_res))) {
                $bank_name = $bRow['bank_name'];
            }
        }

        $desc = '<b>Invoice No :</b> ' . htmlspecialchars($row['dc_no']) . '<br><b>Payment Mode :</b> ' . $payment_mode;
        if (!empty($bank_name)) {
            $desc .= ' | <b>Bank :</b> ' . htmlspecialchars($bank_name);
        }

        $nested[0] = '<div style="text-align:center;">' . $billing_date_display . '</div>';
        $nested[1] = '<div style="text-align:left;">' . $desc . '</div>';
        $nested[2] = '<div style="text-align:center;">Receipt</div>';
        $nested[3] = '<div style="text-align:right;">-</div>';
        $nested[4] = '<div style="text-align:right;">' . number_format($row_amount, 2, '.', '') . '</div>';
        $nested[5] = '<div style="text-align:right;">' . number_format($balance, 2, '.', '') . '</div>';
    }

    $data[] = $nested;
}

echo json_encode(array("data" => $data));
?>