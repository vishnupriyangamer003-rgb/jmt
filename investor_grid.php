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

$sql = "SELECT investor_id FROM tbl_investor WHERE delete_status!='0'";
$query = mysqli_query($conn, $sql);
$totalData = $query ? mysqli_num_rows($query) : 0;
$totalFiltered = $totalData;

$sql = "SELECT investor_id, investor_name, date_format(create_date,'%d/%m/%Y %r') as create_date, date_format(update_date,'%d/%m/%Y %r') as update_date, created_by, updated_by FROM tbl_investor WHERE delete_status!='0'";

if (!empty($requestData["search"]["value"])) {
    $searchVal = mysqli_real_escape_string($conn, $requestData["search"]["value"]);
    $sql .= " AND (investor_name LIKE '" . $searchVal . "%')";
    $query = mysqli_query($conn, $sql);
    $totalFiltered = $query ? mysqli_num_rows($query) : 0;
}

$sql .= " ORDER BY investor_id DESC LIMIT " . $start . ", " . $length;
$query = mysqli_query($conn, $sql);

$data = array();
$i = 1 + $start;
if ($query) {
    while ($row = mysqli_fetch_array($query)) {
        $nestedData = array();
        $nestedData[] = "#" . $i;
        $nestedData[] = ($row["investor_name"] == "") ? "-" : str_replace("^", "'", $row["investor_name"]);

        if (!empty($row["update_date"])) {
            $updater = ($row["updated_by"] == "admin" || $row["updated_by"] == "Admin" || $row["updated_by"] == "1") ? "Admin" : $row["updated_by"];
            $nestedData[] = "<span class=\"badge badge-info\">Updated by " . $updater . " on " . $row["update_date"] . "</span>";
        } else {
            $creator = ($row["created_by"] == "admin" || $row["created_by"] == "Admin" || $row["created_by"] == "1") ? "Admin" : $row["created_by"];
            $nestedData[] = "<span class=\"badge badge-success\">Created by " . $creator . " on " . $row["create_date"] . "</span>";
        }

        $nestedData[] = "<div class='btn-group' role='group'>
            <a href='investor_update.php?id=" . $row["investor_id"] . "'><button type='button' class='btn btn-success' style='padding:6px 8px;margin-right:5px'><i class='fa fa-edit' style='color:#fff;'></i></button></a>
            <a href='javascript:void(0)' class='deleteTriger' data-value='" . $row["investor_id"] . "'><button type='button' class='btn btn-danger' style='padding:6px 8px;'><i class='fa fa-trash' style='color:#fff;'></i></button></a>
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