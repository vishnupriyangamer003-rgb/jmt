<?php
/* Jayam Hydraulic Engineering (Spares) - shared helpers, PHP 5.6 - 8.3 compatible.
 * Include AFTER connection.php + session where needed:
 *   require_once __DIR__ . '/jayam_helpers.php';
 */
date_default_timezone_set('Asia/Kolkata');

if (!defined('JAYAM_COMPANY_NAME')) define('JAYAM_COMPANY_NAME', 'Jayam Hydraulic Engineering (Spares)');
if (!defined('JAYAM_ADDRESS')) define('JAYAM_ADDRESS', 'East Street, New Road, Bye-Pass Bridge, Velayuthampalayam - 639117, Karur DT');
if (!defined('JAYAM_OWNER')) define('JAYAM_OWNER', 'S. Sudarsan');
if (!defined('JAYAM_PHONES')) define('JAYAM_PHONES', '70314 12345 / 70316 12345');

/** Fetch company profile from tbl_admin (falls back to constants). */
function jayam_company($conn) {
    $c = array(
        'cname' => JAYAM_COMPANY_NAME,
        'addr' => JAYAM_ADDRESS,
        'owner' => JAYAM_OWNER,
        'phones' => JAYAM_PHONES,
        'gstno' => '', 'adm_state' => '', 'bank' => '',
        'branch' => '', 'acc_no' => '', 'acc_type' => '',
        'ifsc' => '', 'holder_name' => '',
    );
    try {
        $res = mysqli_query($conn, "SELECT cname, addr, adm_state, gstno, bank, branch, acc_no, acc_type, ifsc, holder_name FROM tbl_admin WHERE admin_id=1 LIMIT 1");
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            foreach ($c as $k => $v) {
                if (isset($row[$k]) && $row[$k] !== '' && $row[$k] !== null) $c[$k] = $row[$k];
            }
            // Owner/phones live in constants until dedicated columns exist.
        }
    } catch (Exception $e) { error_log('jayam_company: '.$e->getMessage()); }
    return $c;
}

/** Consistent money formatting (2 decimals, no fake values). */
function jayam_money($v) {
    if ($v === null || $v === '') return '0.00';
    return number_format((float)$v, 2, '.', '');
}

/** Single source of truth: outstanding = grand_total - paid. Never negative-display without sign. */
function jayam_outstanding($grandTotal, $paid) {
    return round((float)$grandTotal - (float)$paid, 2);
}

/** Sum of pay_amount for a bill. $table is whitelisted. */
function jayam_bill_paid($conn, $table, $dcId) {
    $allowed = array('tbl_receipt' => 'dc_id', 'tbl_non_receipt' => 'dc_id', 'tbl_sky_receipt' => 'dc_id', 'tbl_payment' => 'purchase_id');
    if (!isset($allowed[$table])) return 0.0;
    $col = $allowed[$table];
    $sql = "SELECT COALESCE(SUM(pay_amount),0) AS paid FROM `$table` WHERE `$col`=? AND delete_status='NDL'";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return 0.0;
    mysqli_stmt_bind_param($stmt, 'i', $dcId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);
    return (float)(isset($row['paid']) ? $row['paid'] : 0);
}

/** CSRF token helpers. */
function jayam_csrf_token() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (empty($_SESSION['jayam_csrf'])) {
        if (function_exists('random_bytes')) {
            $_SESSION['jayam_csrf'] = bin2hex(random_bytes(32));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $_SESSION['jayam_csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
        } else {
            $_SESSION['jayam_csrf'] = md5(uniqid(mt_rand(), true));
        }
    }
    return $_SESSION['jayam_csrf'];
}
function jayam_csrf_check($token) {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (!isset($_SESSION['jayam_csrf'])) return false;
    if (function_exists('hash_equals')) {
        return hash_equals($_SESSION['jayam_csrf'], (string)$token);
    }
    return $_SESSION['jayam_csrf'] === (string)$token;
}

/** Safe date parse for d/m/Y UI -> Y-m-d DB; returns null on invalid. */
function jayam_parse_date($dmy, $fmt = 'd/m/Y') {
    if ($dmy === null || trim((string)$dmy) === '') return null;
    $dmy = trim((string)$dmy);
    $dt = DateTime::createFromFormat($fmt, $dmy);
    if (!$dt) {
        $ts = strtotime(str_replace('/', '-', $dmy));
        if ($ts === false) return null;
        return date('Y-m-d', $ts);
    }
    return $dt->format('Y-m-d');
}

/** HTML escape shortcut. */
function e($s) { return htmlspecialchars((string)(isset($s) ? $s : ''), ENT_QUOTES, 'UTF-8'); }
