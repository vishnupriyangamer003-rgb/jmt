<?php
// Migration 003: full wipe / fresh start. Keeps masters, truncates transactionals. Idempotent, logged.
// Backup must exist at backups/karurchambers_pre_wipe_*.sql before run.
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

function table_exists3(mysqli $conn, string $table): bool {
    $res = mysqli_query($conn, "SHOW TABLES LIKE '" . mysqli_real_escape_string($conn, $table) . "'");
    return $res && mysqli_num_rows($res) > 0;
}

// Masters KEPT (not wiped): tbl_admin, tbl_uom, tbl_sub_uom, tbl_staff_type,
// tbl_income_header, tbl_bank_details, tbl_vechicle_details, tbl_products,
// tbl_product_details, tbl_raw_material, tbl_supplier, tbl_employee_details,
// tbl_employee_rights.

$wipe = [
    // details/children first
    'tbl_gst_invoice_details', 'tbl_non_dc_details', 'tbl_dc_details', 'tbl_sdc_details',
    'tbl_sky_gst_invoice_details', 'tbl_order_details', 'tbl_eway_bill_details',
    'tbl_raw_purchase_details', 'tbl_receipt_details', 'tbl_production_labour_details',
    'tbl_production_shift_details',
    // headers / transactional
    'tbl_gst_invoice', 'tbl_non_dc', 'tbl_dc', 'tbl_sdc', 'tbl_sky_gst_invoice',
    'tbl_receipt', 'tbl_non_receipt', 'tbl_sky_receipt', 'tbl_order',
    'tbl_pay_entry', 'tbl_payment', 'tbl_eway_bill', 'tbl_gate_pass',
    'tbl_production_details', 'tbl_raw_purchase', 'tbl_income_expense_details',
    'tbl_bank_income_expense_details', 'tbl_investor_details', 'tbl_investor',
    'tbl_loan_details', 'tbl_deposit_details', 'tbl_assets_details',
    'tbl_attendance', 'tbl_attendance_bricks', 'tbl_attendance_bundle', 'tbl_attendance_hours',
    'tbl_emp_bricks_salary', 'tbl_emp_bundle_salary', 'tbl_emp_hour_salary', 'tbl_emp_salary',
    'tbl_employee_advance', 'tbl_staff_salary', 'tbl_login_details',
    // master-ish reset for fresh start
    'tbl_customer_backup', 'tbl_customer',
];

$log = ["Migration 003 started " . date('Y-m-d H:i:s')];
try {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_gst_invoice WHERE delete_status='NDL'"));
    $log[] = "PRE gst_total=" . $r['t'];
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_customer"));
    $log[] = "PRE customer_rows=" . $r['t'];
} catch (Throwable $e) { $log[] = "PRE snapshot note: " . $e->getMessage(); }

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");
foreach ($wipe as $t) {
    if (!table_exists3($conn, $t)) { $log[] = "SKIP: $t missing"; continue; }
    try {
        mysqli_query($conn, "TRUNCATE TABLE `$t`");
        $log[] = "OK: truncated $t";
    } catch (mysqli_sql_exception $e) {
        // Fallback for tables with FK constraints
        try { mysqli_query($conn, "DELETE FROM `$t`"); $log[] = "OK: deleted $t (fallback)"; }
        catch (mysqli_sql_exception $e2) { $log[] = "FAIL: $t :: " . $e2->getMessage(); }
    }
}
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");

try {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_customer"));
    $log[] = "POST customer_rows=" . $r['t'];
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_gst_invoice"));
    $log[] = "POST gst_rows=" . $r['t'];
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_admin"));
    $log[] = "POST admin_rows=" . $r['t'] . " (kept)";
} catch (Throwable $e) { $log[] = "POST snapshot note: " . $e->getMessage(); }
$log[] = "Migration 003 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/003_applied.log', $out, FILE_APPEND);
echo $out;
