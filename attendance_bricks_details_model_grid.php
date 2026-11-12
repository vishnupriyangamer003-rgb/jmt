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

$emp_id = mysqli_real_escape_string($conn, (string)($requestData["emp_id"] ?? ""));

$sql = "SELECT id FROM tbl_emp_bricks_salary WHERE delete_status!='0' AND emp_id='" . $emp_id . "'";
$query = mysqli_query($conn, $sql);
$totalData = $query ? mysqli_num_rows($query) : 0;
$totalFiltered = $totalData;

$sql = "SELECT * FROM tbl_emp_bricks_salary WHERE delete_status!='0' AND emp_id='" . $emp_id . "'";

if (!empty($requestData["search"]["value"])) {
    $searchVal = mysqli_real_escape_string($conn, $requestData["search"]["value"]);
    $sql .= " AND (pay_amount LIKE '" . $searchVal . "%')";
    $query = mysqli_query($conn, $sql);
    $totalFiltered = $query ? mysqli_num_rows($query) : 0;
}

$sql .= " GROUP BY id ORDER BY id DESC LIMIT " . $start . ", " . $length;
$query = mysqli_query($conn, $sql);

$data = array();
$i = 1 + $start;
if ($query) {
    while ($row = mysqli_fetch_array($query)) {
        $nestedData = array();
        $nestedData[] = "#" . $i;
        $nestedData[] = "<span style=\"font-size: 15px;color: blue;font-weight: bold;\">" . str_replace("^", "'", ($row["create_date"] ?? "-")) . "</span>";
        $nestedData[] = "<span style=\"font-size: 15px;color: green;font-weight: bold;\">" . str_replace("^", "'", ($row["start_date"] ?? "-")) . "</span><br><span style=\"font-size: 15px;color: red;font-weight: bold;\">" . str_replace("^", "'", ($row["end_date"] ?? "-")) . "</span>";
        $nestedData[] = "<span style=\"font-size: 15px;color: blue;font-weight: bold;\">" . str_replace("^", "'", ($row["pay_amount"] ?? "0")) . "</span>";
        $nestedData[] = "<div class='btn-group' role='group'>
            <a href='javascript:void(0)' class='attendance_bricks_salarydeleteTriger' data-value='" . $row["id"] . "'><button type='button' class='btn btn-danger' style='padding:4px 5px;'><i class='fa fa-trash' style='color: #fff;'></i></button></a>
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