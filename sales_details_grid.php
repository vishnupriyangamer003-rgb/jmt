<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
include_once("sessionservices.php");

$requestData = $_REQUEST;
$booking_type = $_REQUEST['booking_type'] ?? '';
$columns = array(0 => 'title');

// total record count without search
$sqlCount = "SELECT a.dc_id FROM tbl_dc a WHERE a.delete_status!='0'";
$query = mysqli_query($conn, $sqlCount) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;

if (($_POST['cond'] ?? '') != "searchbind") {

    $sql = "SELECT *,
        a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,
        a.driver_type,a.total_amount,a.grand_total_amount,d.customer_id,d.customer_name,
        b.product_id as product_id,
        b.qty as qty,
        b.rate as rate,
        date_format(a.create_date,'%d/%m/%Y %r') as create_date,
        date_format(a.billing_date,'%d/%m/%Y') as billing_date,
        date_format(a.update_date,'%d/%m/%Y %r') as update_date,
        a.created_by,a.updated_by
        FROM tbl_dc a
        INNER JOIN (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_dc_details WHERE delete_status!='0' GROUP BY dc_id) b ON b.dc_id = a.dc_id
        LEFT JOIN tbl_customer d ON d.customer_id = a.customer_id
        WHERE a.delete_status!='0' AND d.delete_status!='0'";

} else {

    $fdate = date('Y-m-d', strtotime($_POST['fdate']));
    $tdate = date('Y-m-d', strtotime($_POST['tdate'] . ' +1 day'));
    $customer_id = $_POST['customer_id'];    

    $sql = "SELECT *,
        a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.vechicle_id,
        a.driver_type,a.total_amount,a.grand_total_amount,d.customer_id,d.customer_name,
        b.product_id as product_id,
        b.qty as qty,
        b.rate as rate,
        date_format(a.create_date,'%d/%m/%Y %r') as create_date,
        date_format(a.billing_date,'%d/%m/%Y') as billing_date,
        date_format(a.update_date,'%d/%m/%Y %r') as update_date,
        a.created_by,a.updated_by
        FROM tbl_dc a
        INNER JOIN (SELECT dc_id, group_concat(product_id SEPARATOR ',<br/>') AS product_id, group_concat(qty SEPARATOR ',<br/>') AS qty, group_concat(rate SEPARATOR ',<br/>') AS rate FROM tbl_dc_details WHERE delete_status!='0' GROUP BY dc_id) b ON b.dc_id = a.dc_id
        LEFT JOIN tbl_customer d ON d.customer_id = a.customer_id
        WHERE  a.delete_status!='0' AND d.delete_status!='0' AND a.billing_date BETWEEN '" . $fdate . "' AND '" . $tdate . "'";

    if (!empty($customer_id)) {
        $sql .= " AND a.customer_id='" . $customer_id . "'";
    }

}

// Search filter
if (!empty($requestData['search']['value'])) {
    $searchValue = mysqli_real_escape_string($conn, $requestData['search']['value']);

    if (stripos($sql, 'WHERE') === false) {
        $sql .= " WHERE (d.customer_name LIKE '%".$searchValue."%' OR b.product_id LIKE '%".$searchValue."%')";
    } else {
        $sql .= " AND (d.customer_name LIKE '%".$searchValue."%' OR b.product_id LIKE '%".$searchValue."%')";
    }
}

// Count filtered rows
$query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys2");
$totalFiltered = mysqli_num_rows($query);

// Pagination and order
$sql .= " ORDER BY a.dc_id DESC LIMIT ".$requestData['start'].", ".$requestData['length'];

$query = mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys3");

$data = array();
$i = 1 + $requestData['start'];
while ($row = mysqli_fetch_array($query)) {
    $nestedData = array();

    // Get product names
    $product_list = explode(",<br/>", $row['product_id']);
    $excess = '';
    foreach ($product_list as $product) {
        $gql3 = "SELECT product_name FROM tbl_products where delete_status!='0' and product_id='".$product."'";
        $exec_gql3 = mysqli_query($conn, $gql3);
        while ($fetch_gql3 = mysqli_fetch_array($exec_gql3)) {
            $excess .= $fetch_gql3["product_name"] . "<br>";
        }
    }

    // Row data
    $nestedData[] = "#".$i;
    $nestedData[] = $row["billing_date"];
    $nestedData[] = $row["dc_no"];
    $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.$row["customer_name"].'<br>'.$row["mblno"].'</span>';

    if ($row["driver_type"] == '1') {
        $gql_vechicle = "SELECT vechicle_name FROM tbl_vechicle_details where delete_status!='0' and vechicle_id='".$row["vechicle_id"]."'";
        $exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
        $fetch_gql_vechicle = mysqli_fetch_array($exec_gql_vechicle);
        $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.$fetch_gql_vechicle["vechicle_name"].'</span>';
    } elseif ($row["driver_type"] == '2') {
        $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.$row["vechicle_number"].'</span>';
    } else {
        $nestedData[] = '-';
    }

    $nestedData[] = !empty($excess) ? '<span style="font-size: 15px;color: #000;font-weight: bold">'.$excess.'</span>' : '-';
    $nestedData[] = '<span style="font-size: 15px;color: blue;font-weight: bold">'.$row["qty"].'</span>';
    $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">'.round($row["grand_total_amount"], 2).'</span>';

    $nestedData[] = "<div class='btn-group'>
        <a href='sales_dc_gate_pass_preview.php?id=".$row['dc_id']."'><button class='btn btn-primary'>GP</button></a>
        <a href='sales_preview.php?id=".$row['dc_id']."'><button class='btn btn-warning'><i class='fa fa-print'></i></button></a>
        <a href='sales_edit_details.php?id=".$row['dc_id']."'><button class='btn btn-success'><i class='fa fa-edit'></i></button></a>
        <a href='javascript:void(0)' class='salesdeleteTriger' data-value='".$row['dc_id']."'><button class='btn btn-danger'><i class='fa fa-trash'></i></button></a>
    </div>";

    $data[] = $nestedData;
    $i++;
}

$json_data = array(
    "draw" => intval($requestData['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
);

echo json_encode($json_data);
?>
