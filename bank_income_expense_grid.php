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

// Total distinct billing dates
$totalData = 0;
$totalRes = mysqli_query($conn, "SELECT COUNT(DISTINCT billing_date) as cnt FROM tbl_bank_income_expense_details WHERE delete_status!='0'");
if ($totalRes && ($tRow = mysqli_fetch_assoc($totalRes))) {
    $totalData = intval($tRow['cnt']);
}
$totalFiltered = $totalData;

// Base query
$whereSql = " WHERE a.delete_status!='0' ";
if ($searchVal !== '') {
    $escaped = mysqli_real_escape_string($conn, $searchVal);
    $whereSql .= " AND (a.billing_date LIKE '%" . $escaped . "%' OR DATE_FORMAT(a.billing_date, '%d/%m/%Y') LIKE '%" . $escaped . "%') ";
    $filterRes = mysqli_query($conn, "SELECT COUNT(DISTINCT a.billing_date) as cnt FROM tbl_bank_income_expense_details a WHERE a.delete_status!='0' " . $whereSql);
    if ($filterRes && ($fRow = mysqli_fetch_assoc($filterRes))) {
        $totalFiltered = intval($fRow['cnt']);
    }
}

$sql = "SELECT a.billing_date, DATE_FORMAT(a.billing_date, '%d/%m/%Y') as billing_date1 
        FROM tbl_bank_income_expense_details a 
        " . $whereSql . " 
        GROUP BY a.billing_date 
        ORDER BY a.billing_date DESC 
        LIMIT " . $start . ", " . $length;

$query = mysqli_query($conn, $sql);

$data = array();
$i = 1 + $start;
if ($query) {
    while ($row = mysqli_fetch_array($query)) {
        $bDate = $row["billing_date"];

        $sql1 = "SELECT COALESCE(SUM(amount), 0) as total_income FROM tbl_bank_income_expense_details WHERE delete_status!='0' AND income_expense_type='Income' AND billing_date='" . mysqli_real_escape_string($conn, $bDate) . "' ";
        $query1 = mysqli_query($conn, $sql1);
        $row1 = $query1 ? mysqli_fetch_assoc($query1) : ['total_income' => 0];

        $sql11 = "SELECT COALESCE(SUM(amount), 0) as total_expense FROM tbl_bank_income_expense_details WHERE delete_status!='0' AND income_expense_type='Expense' AND billing_date='" . mysqli_real_escape_string($conn, $bDate) . "' ";
        $query11 = mysqli_query($conn, $sql11);
        $row11 = $query11 ? mysqli_fetch_assoc($query11) : ['total_expense' => 0];

        $nestedData = array();
        $nestedData[] = "#" . $i;
        $nestedData[] = htmlspecialchars($row["billing_date1"] ?? $bDate, ENT_QUOTES, 'UTF-8');
        $nestedData[] = '<span style="font-size: 15px;color: green;font-weight: bold;">' . htmlspecialchars((string)$row1["total_income"], ENT_QUOTES, 'UTF-8') . '</span>';
        $nestedData[] = '<span style="font-size: 15px;color: red;font-weight: bold;">' . htmlspecialchars((string)$row11["total_expense"], ENT_QUOTES, 'UTF-8') . '</span>';
        $nestedData[] = "<div class='btn-group' role='group' aria-label='Basic example'>
                            <a href='bank_income_expense_edit_details.php?id=" . urlencode($bDate) . "'><button type='button' class='btn btn-danger' style='padding:4px 5px 5px 2px;background: green'><i class='fa fa-edit' style='color: #fff;padding: 0;margin: 0;font-size: 18px;'></i></button></a>&nbsp;
                            <a href='javascript:void(0)' class='income_expensedeleteTriger' data-value='" . htmlspecialchars($bDate, ENT_QUOTES, 'UTF-8') . "'><button type='button' class='btn btn-danger' style='padding:4px 5px 5px 2px;'>
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