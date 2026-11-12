<?php
/* Migration 001: Jayam foundation - additive only, idempotent. Run via CLI or browser (admin session).
 * php migrations/001_jayam_foundation.php
 */
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

function col_exists(mysqli $conn, string $table, string $col): bool {
    $t = mysqli_real_escape_string($conn, $table);
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `$t`");
    if (!$res) return false;
    while ($r = mysqli_fetch_assoc($res)) {
        if (strcasecmp($r['Field'], $col) === 0) return true;
    }
    return false;
}
function table_exists(mysqli $conn, string $table): bool {
    $res = mysqli_query($conn, "SHOW TABLES LIKE '" . mysqli_real_escape_string($conn, $table) . "'");
    return $res && mysqli_num_rows($res) > 0;
}
function apply(mysqli $conn, string $label, string $sql, array &$log): void {
    try {
        mysqli_query($conn, $sql);
        $log[] = "OK: $label";
    } catch (mysqli_sql_exception $e) {
        $log[] = "FAIL: $label :: " . $e->getMessage();
    }
}

$log = [];
$log[] = "Migration 001 started " . date('Y-m-d H:i:s');

// --- tbl_admin: password_hash + Jayam seed ---
if (!col_exists($conn, 'tbl_admin', 'password_hash'))
    apply($conn, 'tbl_admin.password_hash', "ALTER TABLE `tbl_admin` ADD COLUMN `password_hash` VARCHAR(255) NULL AFTER `pass`", $log);
else $log[] = "SKIP: tbl_admin.password_hash exists";

// --- tbl_customer ---
$customerCols = [
    'reference_name' => "ADD COLUMN `reference_name` VARCHAR(200) NULL AFTER `customer_name`",
    'owner_name' => "ADD COLUMN `owner_name` VARCHAR(200) NULL AFTER `company_name`",
    'owner_contact' => "ADD COLUMN `owner_contact` VARCHAR(100) NULL AFTER `mblno`",
    'reference_details' => "ADD COLUMN `reference_details` TEXT NULL AFTER `owner_contact`",
    'status' => "ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'Active' AFTER `reference_details`",
];
foreach ($customerCols as $c => $ddl) {
    if (!col_exists($conn, 'tbl_customer', $c)) apply($conn, "tbl_customer.$c", "ALTER TABLE `tbl_customer` $ddl", $log);
    else $log[] = "SKIP: tbl_customer.$c exists";
}

// --- tbl_products ---
$productCols = [
    'product_code' => "ADD COLUMN `product_code` VARCHAR(100) NULL AFTER `product_name`",
    'purchase_rate' => "ADD COLUMN `purchase_rate` DECIMAL(12,2) NULL AFTER `sale_price`",
    'category' => "ADD COLUMN `category` VARCHAR(150) NULL AFTER `purchase_rate`",
    'status' => "ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'Active' AFTER `category`",
];
foreach ($productCols as $c => $ddl) {
    if (!col_exists($conn, 'tbl_products', $c)) apply($conn, "tbl_products.$c", "ALTER TABLE `tbl_products` $ddl", $log);
    else $log[] = "SKIP: tbl_products.$c exists";
}

// --- billing headers: advance + terms; non_dc gets service fields ---
foreach (['tbl_gst_invoice', 'tbl_non_dc'] as $t) {
    if (!col_exists($conn, $t, 'advance_amount')) apply($conn, "$t.advance_amount", "ALTER TABLE `$t` ADD COLUMN `advance_amount` DECIMAL(12,2) NOT NULL DEFAULT 0 AFTER `grand_total_amount`", $log);
    else $log[] = "SKIP: $t.advance_amount exists";
    if (!col_exists($conn, $t, 'payment_terms_days')) apply($conn, "$t.payment_terms_days", "ALTER TABLE `$t` ADD COLUMN `payment_terms_days` INT NULL AFTER `advance_amount`", $log);
    else $log[] = "SKIP: $t.payment_terms_days exists";
}
if (!col_exists($conn, 'tbl_non_dc', 'service_place')) apply($conn, 'tbl_non_dc.service_place', "ALTER TABLE `tbl_non_dc` ADD COLUMN `service_place` ENUM('Outdoor','Workshop') NULL AFTER `payment_terms_days`", $log);
else $log[] = "SKIP: tbl_non_dc.service_place exists";
if (!col_exists($conn, 'tbl_non_dc', 'is_service_bill')) apply($conn, 'tbl_non_dc.is_service_bill', "ALTER TABLE `tbl_non_dc` ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `service_place`", $log);
else $log[] = "SKIP: tbl_non_dc.is_service_bill exists";

// --- receipts: ref_no + remarks ---
foreach (['tbl_receipt', 'tbl_non_receipt'] as $t) {
    if (!col_exists($conn, $t, 'ref_no')) apply($conn, "$t.ref_no", "ALTER TABLE `$t` ADD COLUMN `ref_no` VARCHAR(150) NULL AFTER `pay_amount`", $log);
    else $log[] = "SKIP: $t.ref_no exists";
    if (!col_exists($conn, $t, 'remarks')) apply($conn, "$t.remarks", "ALTER TABLE `$t` ADD COLUMN `remarks` TEXT NULL AFTER `ref_no`", $log);
    else $log[] = "SKIP: $t.remarks exists";
}

// --- expenses ---
foreach (['payment_mode' => "ADD COLUMN `payment_mode` VARCHAR(50) NULL AFTER `amount`",
          'ref_no' => "ADD COLUMN `ref_no` VARCHAR(150) NULL AFTER `payment_mode`",
          'remarks' => "ADD COLUMN `remarks` TEXT NULL AFTER `ref_no`"] as $c => $ddl) {
    if (!col_exists($conn, 'tbl_income_expense_details', $c)) apply($conn, "tbl_income_expense_details.$c", "ALTER TABLE `tbl_income_expense_details` $ddl", $log);
    else $log[] = "SKIP: tbl_income_expense_details.$c exists";
}

// --- staff login hash ---
if (!col_exists($conn, 'tbl_employee_details', 'password_hash'))
    apply($conn, 'tbl_employee_details.password_hash', "ALTER TABLE `tbl_employee_details` ADD COLUMN `password_hash` VARCHAR(255) NULL AFTER `pass`", $log);
else $log[] = "SKIP: tbl_employee_details.password_hash exists";

// --- salary extras ---
foreach (['salary_month' => "ADD COLUMN `salary_month` VARCHAR(20) NULL AFTER `end_date`",
          'payment_mode' => "ADD COLUMN `payment_mode` VARCHAR(50) NULL AFTER `salary_month`",
          'remarks' => "ADD COLUMN `remarks` TEXT NULL AFTER `payment_mode`"] as $c => $ddl) {
    if (!col_exists($conn, 'tbl_emp_salary', $c)) apply($conn, "tbl_emp_salary.$c", "ALTER TABLE `tbl_emp_salary` $ddl", $log);
    else $log[] = "SKIP: tbl_emp_salary.$c exists";
}

// --- employee advance (new, separate from customer billing advance) ---
if (!table_exists($conn, 'tbl_employee_advance')) {
    apply($conn, 'CREATE tbl_employee_advance', "CREATE TABLE `tbl_employee_advance` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `emp_id` INT(11) NOT NULL,
      `adv_date` DATE NULL,
      `amount` DECIMAL(12,2) NOT NULL DEFAULT 0,
      `payment_mode` VARCHAR(50) NULL,
      `ref_no` VARCHAR(150) NULL,
      `remarks` TEXT NULL,
      `adjusted_amount` DECIMAL(12,2) NOT NULL DEFAULT 0,
      `created_by` VARCHAR(100) NULL,
      `create_date` DATETIME NULL,
      `updated_by` VARCHAR(100) NULL,
      `update_date` DATETIME NULL,
      `delete_status` VARCHAR(10) NOT NULL DEFAULT 'NDL',
      PRIMARY KEY (`id`),
      KEY `idx_emp_adv` (`emp_id`,`adv_date`,`delete_status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", $log);
} else $log[] = "SKIP: tbl_employee_advance exists";

// --- helpful indexes (best effort) ---
foreach ([
    'idx_gst_cust_date' => "ALTER TABLE `tbl_gst_invoice` ADD INDEX `idx_gst_cust_date` (`customer_id`,`billing_date`,`delete_status`)",
    'idx_nondc_cust_date' => "ALTER TABLE `tbl_non_dc` ADD INDEX `idx_nondc_cust_date` (`customer_id`,`billing_date`,`delete_status`)",
    'idx_receipt_dc' => "ALTER TABLE `tbl_receipt` ADD INDEX `idx_receipt_dc` (`dc_id`,`delete_status`)",
    'idx_nonreceipt_dc' => "ALTER TABLE `tbl_non_receipt` ADD INDEX `idx_nonreceipt_dc` (`dc_id`,`delete_status`)",
] as $name => $sql) {
    try { mysqli_query($conn, $sql); $log[] = "OK: index $name"; }
    catch (mysqli_sql_exception $e) {
        if (stripos($e->getMessage(), 'Duplicate key name') !== false) $log[] = "SKIP: index $name exists";
        else $log[] = "FAIL: index $name :: " . $e->getMessage();
    }
}

// --- Jayam company seed (DB-driven branding) ---
try {
    $stmt = mysqli_prepare($conn, "UPDATE `tbl_admin` SET `cname`=?, `addr`=?, `suffix`=?, `adm_state`=? WHERE `admin_id`=1");
    $cname = 'Jayam Hydraulic Engineering (Spares)';
    $addr = 'East Street, New Road, Bye-Pass Bridge, Velayuthampalayam - 639117, Karur DT';
    $suffix = 'JHE';
    $state = 'Tamil Nadu';
    mysqli_stmt_bind_param($stmt, 'ssss', $cname, $addr, $suffix, $state);
    mysqli_stmt_execute($stmt);
    $log[] = "OK: Jayam company seed (affected=" . mysqli_stmt_affected_rows($stmt) . ")";
    mysqli_stmt_close($stmt);
} catch (mysqli_sql_exception $e) { $log[] = "FAIL: company seed :: " . $e->getMessage(); }

$log[] = "Migration 001 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/001_applied.log', $out, FILE_APPEND);
if (php_sapi_name() === 'cli') { echo $out; }
else { echo '<pre>' . htmlspecialchars($out) . '</pre>'; }
