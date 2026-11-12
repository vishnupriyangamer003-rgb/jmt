<?php
/* Migration 011: Live keys + needed-columns sync - additive only, idempotent.
 * - Adds PRIMARY KEY + AUTO_INCREMENT where missing and safe (no duplicate/zero
 *   key values; tables with collisions are LOGGED for manual review, never forced).
 * - Ensures newer columns the current code selects (advance/state/split flags,
 *   receipt refs, customer/product/employee extensions).
 * Run: php migrations/011_keys_live_sync.php (CLI or browser). Safe to re-run.
 */
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

function col_exists11(mysqli $conn, string $table, string $col): bool {
    $t = mysqli_real_escape_string($conn, $table);
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `$t`");
    if (!$res) return false;
    while ($r = mysqli_fetch_assoc($res)) {
        if (strcasecmp($r['Field'], $col) === 0) return true;
    }
    return false;
}
function has_pk11(mysqli $conn, string $table): bool {
    $t = mysqli_real_escape_string($conn, $table);
    $res = mysqli_query($conn, "SHOW INDEX FROM `$t` WHERE Key_name='PRIMARY'");
    return $res && mysqli_num_rows($res) > 0;
}
function has_autoinc11(mysqli $conn, string $table, string $col): bool {
    $t = mysqli_real_escape_string($conn, $table);
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `$t` LIKE '" . mysqli_real_escape_string($conn, $col) . "'");
    if (!$res || !($r = mysqli_fetch_assoc($res))) return false;
    return stripos($r['Extra'] ?? '', 'auto_increment') !== false;
}
function apply11(mysqli $conn, string $label, string $sql, array &$log): void {
    try {
        mysqli_query($conn, $sql);
        $log[] = "OK: $label";
    } catch (mysqli_sql_exception $e) {
        $log[] = "FAIL: $label :: " . $e->getMessage();
    }
}

$log = [];
$log[] = "Migration 011 started " . date('Y-m-d H:i:s');

// --- 1) keys: [table => id column] ---
$keys = [
    'tbl_gst_invoice' => 'dc_id',
    'tbl_gst_invoice_details' => 'id',
    'tbl_non_dc' => 'dc_id',
    'tbl_non_dc_details' => 'id',
    'tbl_receipt' => 'receipt_id',
    'tbl_non_receipt' => 'receipt_id',
    'tbl_customer' => 'customer_id',
    'tbl_products' => 'product_id',
    'tbl_employee_details' => 'emp_id',
    'tbl_emp_hour_salary' => 'id',
    'tbl_emp_bricks_salary' => 'id',
    'tbl_emp_bundle_salary' => 'id',
    'tbl_emp_salary' => 'id',
    'tbl_attendance' => 'attendance_id',
    'tbl_attendance_hours' => 'attendance_id',
    'tbl_attendance_bricks' => 'attendance_id',
    'tbl_attendance_bundle' => 'attendance_id',
    'tbl_income_expense_details' => 'id',
    'tbl_income_header' => 'id',
    'tbl_services_non_dc' => 'dc_id',
    'tbl_services_non_dc_details' => 'id',
    'tbl_services_non_receipt' => 'receipt_id',
];
foreach ($keys as $t => $c) {
    $chk = mysqli_query($conn, "SHOW TABLES LIKE '" . mysqli_real_escape_string($conn, $t) . "'");
    if (!$chk || mysqli_num_rows($chk) === 0) { $log[] = "SKIP: $t (no table)"; continue; }
    if (!col_exists11($conn, $t, $c)) { $log[] = "SKIP: $t.$c (no column)"; continue; }
    // duplicate/zero check BEFORE touching keys
    $dup = mysqli_query($conn, "SELECT `$c` v, COUNT(*) n FROM `$t` GROUP BY `$c` HAVING n > 1 LIMIT 3");
    $dups = [];
    if ($dup) { while ($r = mysqli_fetch_assoc($dup)) $dups[] = $r['v'] . 'x' . $r['n']; }
    if ($dups) { $log[] = "REVIEW: $t.$c has duplicate keys (" . implode(',', $dups) . ") - renumber manually, then re-run"; continue; }
    if (!has_pk11($conn, $t)) {
        apply11($conn, "$t PK($c)", "ALTER TABLE `$t` ADD PRIMARY KEY (`$c`)", $log);
    } else { $log[] = "SKIP: $t PK exists"; }
    if (!has_autoinc11($conn, $t, $c)) {
        apply11($conn, "$t auto-inc($c)", "ALTER TABLE `$t` MODIFY `$c` INT(11) NOT NULL AUTO_INCREMENT", $log);
    } else { $log[] = "SKIP: $t auto-inc exists"; }
}

// --- 2) needed columns the current code reads ---
$cols = [
    // billing headers
    ['tbl_gst_invoice', 'advance_amount', "ADD COLUMN `advance_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `grand_total_amount`"],
    ['tbl_gst_invoice', 'payment_terms_days', "ADD COLUMN `payment_terms_days` INT NULL AFTER `advance_amount`"],
    ['tbl_non_dc', 'advance_amount', "ADD COLUMN `advance_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `grand_total_amount`"],
    ['tbl_non_dc', 'payment_terms_days', "ADD COLUMN `payment_terms_days` INT NULL AFTER `advance_amount`"],
    ['tbl_non_dc', 'service_place', "ADD COLUMN `service_place` ENUM('Outdoor','Workshop') NULL AFTER `payment_terms_days`"],
    ['tbl_non_dc', 'is_service_bill', "ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `service_place`"],
    ['tbl_services_non_dc', 'order_id', "ADD COLUMN `order_id` VARCHAR(50) NULL AFTER `dc_no`"],
    ['tbl_services_non_dc', 'advance_amount', "ADD COLUMN `advance_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `grand_total_amount`"],
    ['tbl_services_non_dc', 'payment_terms_days', "ADD COLUMN `payment_terms_days` INT NULL AFTER `advance_amount`"],
    ['tbl_services_non_dc', 'service_place', "ADD COLUMN `service_place` ENUM('Outdoor','Workshop') NULL AFTER `payment_terms_days`"],
    ['tbl_services_non_dc', 'is_service_bill', "ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `service_place`"],
    // receipts
    ['tbl_receipt', 'ref_no', "ADD COLUMN `ref_no` VARCHAR(150) NULL AFTER `bank_id`"],
    ['tbl_non_receipt', 'is_service_bill', "ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `pay_amount`"],
    ['tbl_non_receipt', 'ref_no', "ADD COLUMN `ref_no` VARCHAR(150) NULL AFTER `is_service_bill`"],
    ['tbl_services_non_receipt', 'is_service_bill', "ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `pay_amount`"],
    ['tbl_services_non_receipt', 'ref_no', "ADD COLUMN `ref_no` VARCHAR(150) NULL AFTER `is_service_bill`"],
    // customer extensions
    ['tbl_customer', 'reference_name', "ADD COLUMN `reference_name` VARCHAR(200) NULL AFTER `customer_name`"],
    ['tbl_customer', 'owner_name', "ADD COLUMN `owner_name` VARCHAR(200) NULL AFTER `company_name`"],
    ['tbl_customer', 'owner_contact', "ADD COLUMN `owner_contact` VARCHAR(100) NULL AFTER `mblno`"],
    ['tbl_customer', 'reference_details', "ADD COLUMN `reference_details` TEXT NULL AFTER `owner_contact`"],
    ['tbl_customer', 'status', "ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'Active' AFTER `reference_details`"],
    // product extensions
    ['tbl_products', 'product_code', "ADD COLUMN `product_code` VARCHAR(100) NULL AFTER `product_name`"],
    ['tbl_products', 'purchase_rate', "ADD COLUMN `purchase_rate` DECIMAL(12,2) NULL AFTER `sale_price`"],
    ['tbl_products', 'category', "ADD COLUMN `category` VARCHAR(150) NULL AFTER `purchase_rate`"],
    ['tbl_products', 'status', "ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'Active' AFTER `category`"],
];
foreach ($cols as [$t, $c, $ddl]) {
    $chk = mysqli_query($conn, "SHOW TABLES LIKE '" . mysqli_real_escape_string($conn, $t) . "'");
    if (!$chk || mysqli_num_rows($chk) === 0) { $log[] = "SKIP: $t.$c (no table)"; continue; }
    if (!col_exists11($conn, $t, $c)) apply11($conn, "$t.$c", "ALTER TABLE `$t` $ddl", $log);
    else $log[] = "SKIP: $t.$c exists";
}

$log[] = "Migration 011 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/011_applied.log', $out, FILE_APPEND);
if (php_sapi_name() === 'cli') { echo $out; }
else { echo '<pre>' . htmlspecialchars($out) . '</pre>'; }
