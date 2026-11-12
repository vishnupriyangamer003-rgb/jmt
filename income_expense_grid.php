<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

include_once("sessionservices.php");

$requestData = $_REQUEST;

$draw = intval($requestData['draw'] ?? 1);
$start = max(0, intval($requestData['start'] ?? 0));
$length = intval($requestData['length'] ?? 10);
if ($length <= 0) $length = 10;
$searchVal = trim($requestData['search']['value'] ?? '');

// Total individual records
$totalData = 0;
$totalRes = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM tbl_income_expense_details WHERE delete_status!='0'");
if ($totalRes && ($tRow = mysqli_fetch_assoc($totalRes))) {
    $totalData = intval($tRow['cnt']);
}
$totalFiltered = $totalData;

// Base query
$whereSql = " WHERE a.delete_status!='0' ";
if ($searchVal !== '') {
    $escaped = mysqli_real_escape_string($conn, $searchVal);
    $whereSql .= " AND (a.billing_date LIKE '%" . $escaped . "%' OR DATE_FORMAT(a.billing_date, '%d/%m/%Y') LIKE '%" . $escaped . "%' OR h.income_header_name LIKE '%" . $escaped . "%') ";
    $filterRes = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM tbl_income_expense_details a LEFT JOIN tbl_income_header h ON h.id=a.header_id WHERE a.delete_status!='0' " . $whereSql);
    if ($filterRes && ($fRow = mysqli_fetch_assoc($filterRes))) {
        $totalFiltered = intval($fRow['cnt']);
    }
}

$sql = "SELECT a.id, a.billing_date, DATE_FORMAT(a.billing_date, '%d/%m/%Y') as billing_date1,
               a.income_expense_type, a.amount, h.income_header_name
        FROM tbl_income_expense_details a
        LEFT JOIN tbl_income_header h ON h.id = a.header_id
        " . $whereSql . " 
        ORDER BY a.billing_date DESC, a.id DESC 
        LIMIT " . $start . ", " . $length;

$query = mysqli_query($conn, $sql);

$data = array();
$i = 1 + $start;
if ($query) {
    while ($row = mysqli_fetch_array($query)) {
        $nestedData = array();
        $nestedData[] = "#" . $i;
        $nestedData[] = htmlspecialchars($row["billing_date1"] ?? $row["billing_date"], ENT_QUOTES, 'UTF-8');
        $nestedData[] = htmlspecialchars($row["income_header_name"] ?? '-', ENT_QUOTES, 'UTF-8');
        $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . htmlspecialchars((string)$row["amount"], ENT_QUOTES, 'UTF-8') . '</span>';
        $nestedData[] = "<div class='btn-group' role='group' aria-label='Basic example'>
                            <a href='income_expense_edit_details.php?id=" . intval($row['id']) . "'><button type='button' class='btn btn-danger' style='padding:4px 5px 5px 2px;background: green'><i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i></button></a>&nbsp;
                            <a href='javascript:void(0)' class='income_expensedeleteTriger' data-value='" . intval($row['id']) . "'><button type='button' class='btn btn-danger' style='padding:4px 5px 5px 2px;'>
                                <i class='fa fa-trash' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i>
                            </button></a>
                        </div>";

        $data[] = $nestedData;
        $i++;
    }
}

$json_data = array(
    "draw"            => $draw,
    "recordsTotal"    => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data"            => $data
);

echo json_encode($json_data);