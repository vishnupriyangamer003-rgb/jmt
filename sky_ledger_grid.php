<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
// This is the sky_ledger_grid.php file content
// It should be saved as a separate file: sky_ledger_grid.php

header('Access-Control-Allow-Origin: *');
//include connection file 
include_once("sessionservices.php");

// storing request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$columns = array( 
    // datatable column index => database column name
    0 => 'title',
);

// Get customer_id from POST
$customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;

// Initialize variables
$balance = 0;
$non_balance = 0;
$data = array();
$non_data = array();

if ($customer_id > 0) {
    $sql = "select create_date,dc_id,billing_date,date_format(billing_date,'%d/%m/%Y') as billing_date1,dc_no,grand_total_amount as amount,total_amount,1 from tbl_sky_gst_invoice where delete_status!='0' and customer_id='" . $customer_id . "'   UNION  select create_date,dc_id,billing_date,date_format(billing_date,'%d/%m/%Y') as billing_date1,dc_no,pay_amount as amount,NULL as total_amount,2 from tbl_sky_receipt where delete_status!='0' and customer_id='" . $customer_id . "' order by create_date ASC"; 

    $query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");

    while ($row = mysqli_fetch_array($query)) {
        $nestedData = array();

        if ($row['1'] == '1') {
            if (empty($row['discount'])) {
                $discount = 0;
            } else {
                $discount = $row['discount'];
            }
            
            // Calculate balance
            $packing_cost = isset($row['packing_cost']) ? floatval($row['packing_cost']) : 0;
            $print_cost = isset($row['print_cost']) ? floatval($row['print_cost']) : 0;
            $advance_amount = isset($row['advance_amount']) ? floatval($row['advance_amount']) : 0;
            
            $balance = $balance + (floatval($row['amount']) + $packing_cost + $print_cost) - ($advance_amount + floatval($discount));

            $sql1 = "SELECT *,group_concat(b.product_id SEPARATOR ',<br/>') as product_id,group_concat(b.qty SEPARATOR ',<br/>') as qty FROM tbl_sky_gst_invoice  a 
            inner join tbl_sky_gst_invoice_details b on a.dc_id=b.dc_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.customer_id='" . $customer_id . "' and a.dc_id='" . $row['dc_id'] . "'";

            $exec_sql1 = mysqli_query($conn, $sql1);
            $fetch_sql1 = mysqli_fetch_array($exec_sql1);



            // Get driver and vehicle details
            $driver_name = '-';
            $vechicle_number = '-';
            
            if (isset($fetch_sql1["driver_type"]) && $fetch_sql1["driver_type"] == '1') {
                $gql_driver = "SELECT * FROM tbl_employee_details where delete_status!='0' and emp_id='" . $fetch_sql1["driver_id"] . "' ";
                $exec_gql_driver = mysqli_query($conn, $gql_driver);
                $fetch_gql_driver = mysqli_fetch_array($exec_gql_driver);
                $driver_name = isset($fetch_gql_driver["emp_name"]) ? $fetch_gql_driver["emp_name"] : '-';

                $gql_vechicle = "SELECT * FROM tbl_vechicle_details where delete_status!='0' and vechicle_id='" . $fetch_sql1["vechicle_id"] . "' ";
                $exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
                $fetch_gql_vechicle = mysqli_fetch_array($exec_gql_vechicle);
                $vechicle_number = isset($fetch_gql_vechicle["vechicle_name"]) ? $fetch_gql_vechicle["vechicle_name"] : '-';
            } else if (isset($row["driver_type"]) && $row["driver_type"] == '2') {
                $driver_name = isset($fetch_sql1["driver_name"]) ? $fetch_sql1["driver_name"] : '-';
                $vechicle_number = isset($fetch_sql1["vechicle_number"]) ? $fetch_sql1["vechicle_number"] : '-';
            }

            // Get products
            $product_list = isset($fetch_sql1['product_id']) ? explode(",<br/>", $fetch_sql1['product_id']) : array();
            $excess = '';
            
            foreach ($product_list as $product) {
                if (!empty($product)) {
                    $gql3 = "SELECT * FROM tbl_products where delete_status!='0' and product_id='" . $product . "' ";
                    $exec_gql3 = mysqli_query($conn, $gql3);
                    while ($fetch_gql3 = mysqli_fetch_array($exec_gql3)) {
                        $excess .= isset($fetch_gql3["product_name"]) ? $fetch_gql3["product_name"] : '';
                    }
                    if (!empty($excess)) {
                        $excess .= "<br>";
                    }
                }
            }

            $nestedData['0'] = '<div style="text-align:center;">' . (isset($row['billing_date1']) ? $row['billing_date1'] : '') . '</div>';
            $nestedData['1'] = '<div style="text-align:center;"><b>Invoice No :</b>' . (isset($row['dc_no']) ? $row['dc_no'] : '') . '<br><b>Driver Name :</b>' . $driver_name . '<b>Vechicle No :</b>' . $vechicle_number . '<br> <b>Product :</b>' . $excess . '<b>Qty :</b>' . (isset($fetch_sql1['qty']) ? $fetch_sql1['qty'] : '') . '<br><b> Rate : </b>' . (isset($fetch_sql1['product_rate']) ? $fetch_sql1['product_rate'] : '') . '</div>';
            $nestedData['2'] = '<div style="text-align:center;">Sales</div>';
            $nestedData['3'] = '<div style="text-align:center;">' . (isset($row['amount']) ? $row['amount'] : '') . '</div>';
            $nestedData['4'] = '';
            $nestedData['5'] = '<div style="text-align:center;">' . $balance . '</div>';
        }
        
        if ($row['1'] == '2') {
            $balance = $balance - floatval($row['amount']);

            $pay_sql = "select * from tbl_sky_receipt where delete_status!='0'  and dc_id='" . $row['dc_id'] . "'";
            $pay_query = mysqli_query($conn, $pay_sql);
            $pay_row = mysqli_fetch_array($pay_query);

            $payment_mode = '-';
            if (isset($pay_row['payment_mode'])) {
                if ($pay_row['payment_mode'] == 1) {
                    $payment_mode = 'UPI';
                } else if ($pay_row['payment_mode'] == 2) {
                    $payment_mode = 'Card';
                } else if ($pay_row['payment_mode'] == 3) {
                    $payment_mode = 'Cash';
                } else if ($pay_row['payment_mode'] == 4) {
                    $payment_mode = 'Bank Transfer';
                } else if ($pay_row['payment_mode'] == 5) {
                    $payment_mode = 'Cheque';
                } else if ($pay_row['payment_mode'] == 6) {
                    $payment_mode = 'Other';
                }
            }

            $bank_name = '';
            if (isset($pay_row['bank_id']) && !empty($pay_row['bank_id'])) {
                $bank_sql = "SELECT * FROM tbl_bank_details WHERE  delete_status!='0' and  id='" . $pay_row['bank_id'] . "'";
                $bank_query = mysqli_query($conn, $bank_sql);
                $bank_row = mysqli_fetch_array($bank_query);
                $bank_name = isset($bank_row['bank_name']) ? $bank_row['bank_name'] : '';
            }

            $nestedData['0'] = '<div style="text-align:center;">' . (isset($row['billing_date1']) ? $row['billing_date1'] : '') . '</div>';
            $nestedData['1'] = '<div style="text-align:center;"><b>Invoice No :</b>' . (isset($row['dc_no']) ? $row['dc_no'] : '') . '<br><b>Payment Mode :</b>' . $payment_mode . '<b> Bank Name :</b> ' . $bank_name . '</div>';
            $nestedData['2'] = '<div style="text-align:center;">Receipt</div>';
            $nestedData['3'] = '';
            $nestedData['4'] = '<div style="text-align:center;">' . (isset($row['amount']) ? $row['amount'] : '') . '</div>';
            $nestedData['5'] = '<div style="text-align:center;">' . $balance . '</div>';
        }

        $data[] = $nestedData;
    }
}

$json_data = array(
    "data" => $data
);

echo json_encode($json_data);
?>