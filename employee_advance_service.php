<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");
date_default_timezone_set('Asia/Kolkata');

if (file_exists(__DIR__ . '/phpservices/jayam_helpers.php')) {
    require_once __DIR__ . '/phpservices/jayam_helpers.php';
}
if (!function_exists('jayam_parse_date')) {
    function jayam_parse_date($date_str, $fmt = 'd/m/Y') {
        if ($date_str === null || trim((string)$date_str) === '') return null;
        $date_str = trim((string)$date_str);
        $d = DateTime::createFromFormat($fmt, $date_str);
        if ($d && $d->format($fmt) === $date_str) {
            return $d->format('Y-m-d');
        }
        $d2 = DateTime::createFromFormat('Y-m-d', $date_str);
        if ($d2 && $d2->format('Y-m-d') === $date_str) {
            return $d2->format('Y-m-d');
        }
        $ts = strtotime(str_replace('/', '-', $date_str));
        return $ts !== false ? date('Y-m-d', $ts) : null;
    }
}

function ea_esc($conn, $v){ return mysqli_real_escape_string($conn, (string)($v ?? '')); }

$curdate = date('Y-m-d H:i:s');
$log = $_SESSION['login_user'] ?? 'admin';
$req = $_POST['req'] ?? '';
$rtnMsg = null;

if ($req === 'ADDINS') {
    $emp_id = (int)($_POST['emp_id'] ?? 0);
    $adv_date = jayam_parse_date($_POST['adv_date'] ?? '') ?? date('Y-m-d');
    $amount = (float)($_POST['amount'] ?? 0);
    $payment_mode = ea_esc($conn, $_POST['payment_mode'] ?? 'Cash');
    $ref_no = ea_esc($conn, $_POST['ref_no'] ?? '');
    $remarks = ea_esc($conn, $_POST['remarks'] ?? '');
    if ($emp_id > 0 && $amount > 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO tbl_employee_advance (emp_id,adv_date,amount,payment_mode,ref_no,remarks,created_by,create_date,delete_status) VALUES (?,?,?,?,?,?,?,?,'NDL')");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'isdsssss', $emp_id, $adv_date, $amount, $payment_mode, $ref_no, $remarks, $log, $curdate);
            $rtnMsg = mysqli_stmt_execute($stmt) ? 1 : 'Save failed';
            mysqli_stmt_close($stmt);
        } else { $rtnMsg = 'Save failed'; }
    } else { $rtnMsg = 'Select employee and enter amount'; }
} elseif ($req === 'ADDDEL') {
    $delid = (int)($_POST['delid'] ?? 0);
    $stmt = mysqli_prepare($conn, "UPDATE tbl_employee_advance SET delete_status='0' WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $delid);
        $rtnMsg = mysqli_stmt_execute($stmt) ? 1 : 'Delete failed';
        mysqli_stmt_close($stmt);
    }
} elseif ($req === 'ADJUPD') {
    // Adjust advance against salary (records adjusted amount; outstanding = amount - adjusted).
    $id = (int)($_POST['id'] ?? 0);
    $adj = (float)($_POST['adjusted_amount'] ?? 0);
    $stmt = mysqli_prepare($conn, "UPDATE tbl_employee_advance SET adjusted_amount=?,updated_by=?,update_date=? WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'dssi', $adj, $log, $curdate, $id);
        $rtnMsg = mysqli_stmt_execute($stmt) ? 1 : 'Update failed';
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
header("Content-Type: application/json", true);
echo json_encode(array("op" => $rtnMsg));
?>
