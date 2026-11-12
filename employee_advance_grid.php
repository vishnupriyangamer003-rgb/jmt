<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
include_once("sessionservices.php");

$requestData = $_REQUEST;

$sql = "SELECT a.id FROM tbl_employee_advance a WHERE a.delete_status!='0'";
$query = mysqli_query($conn, $sql);
$totalData = $query ? mysqli_num_rows($query) : 0;
$totalFiltered = $totalData;

$sql = "SELECT a.id,a.adv_date,a.amount,a.adjusted_amount,a.payment_mode,a.ref_no,a.remarks,b.emp_name,date_format(a.adv_date,'%d/%m/%Y') as adv_date_fmt,date_format(a.create_date,'%d/%m/%Y %r') as create_date FROM tbl_employee_advance a LEFT JOIN tbl_employee_details b ON b.emp_id=a.emp_id WHERE a.delete_status!='0'";

if (!empty($requestData['search']['value'])) {
    $s = mysqli_real_escape_string($conn, $requestData['search']['value']);
    $sql .= " AND (b.emp_name LIKE '%".$s."%' OR a.ref_no LIKE '%".$s."%')";
}
$query = mysqli_query($conn, $sql);
$totalFiltered = $query ? mysqli_num_rows($query) : 0;
$start = (int)($requestData['start'] ?? 0);
$len = (int)($requestData['length'] ?? 10);
$sql .= " ORDER BY a.adv_date DESC, a.id DESC LIMIT ".$start.",".$len;
$query = mysqli_query($conn, $sql);

$data = array();
$i = 1 + $start;
if ($query) while ($row = mysqli_fetch_array($query)) {
    $nested = array();
    $nested[] = "#".$i;
    $nested[] = $row['adv_date_fmt'] ?: '-';
    $nested[] = $row['emp_name'] ?: '-';
    $nested[] = jayam_money($row['amount']);
    $nested[] = jayam_money($row['adjusted_amount']);
    $nested[] = jayam_money(jayam_outstanding($row['amount'], $row['adjusted_amount']));
    $nested[] = ($row['payment_mode'] ?: '-') . ($row['ref_no'] ? ' / '.$row['ref_no'] : '');
    $nested[] = "<div class='btn-group'><a href='javascript:void(0)' class='eadjTriger' data-value='".$row['id']."' data-adj='".$row['adjusted_amount']."'><button type='button' class='btn btn-warning' style='padding:6px 8px;margin-right:5px' title='Adjust against salary'><i class='fa fa-check' style='color:#fff;font-size:16px;'></i></button></a><a href='javascript:void(0)' class='deleteTriger' data-value='".$row['id']."'><button type='button' class='btn btn-danger' style='padding:6px 8px;'><i class='fa fa-trash' style='color:#fff;font-size:16px;'></i></button></a></div>";
    $data[] = $nested;
    $i++;
}

echo json_encode(array(
    "draw" => intval($requestData['draw'] ?? 0),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
));
?>
