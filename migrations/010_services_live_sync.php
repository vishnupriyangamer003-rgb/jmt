<?php
/* Migration 010: Live Services sync - additive only, idempotent.
 * - Ensures tbl_services_non_dc / _details / _receipt exist (CREATE TABLE IF NOT EXISTS).
 * - Ensures newer columns the grids/services code selects (order_id, advance_amount,
 *   payment_terms_days, service_place, is_service_bill, receipt is_service_bill).
 * - Ensures the same newer columns on karurchambers billing tables (gst/non_dc),
 *   so older live databases stop killing grid queries.
 * Run once on live: php migrations/010_services_live_sync.php (or open in browser).
 */
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

function col_exists10(mysqli $conn, string $table, string $col): bool {
    $t = mysqli_real_escape_string($conn, $table);
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `$t`");
    if (!$res) return false;
    while ($r = mysqli_fetch_assoc($res)) {
        if (strcasecmp($r['Field'], $col) === 0) return true;
    }
    return false;
}
function tbl_exists10(mysqli $conn, string $table): bool {
    $t = mysqli_real_escape_string($conn, $table);
    $res = mysqli_query($conn, "SHOW TABLES LIKE '$t'");
    return $res && mysqli_num_rows($res) > 0;
}
function apply10(mysqli $conn, string $label, string $sql, array &$log): void {
    try {
        mysqli_query($conn, $sql);
        $log[] = "OK: $label";
    } catch (mysqli_sql_exception $e) {
        $log[] = "FAIL: $label :: " . $e->getMessage();
    }
}

$log = [];
$log[] = "Migration 010 started " . date('Y-m-d H:i:s');

// --- services tables (create if missing) ---
$creates = [
'tbl_services_non_dc' => "CREATE TABLE IF NOT EXISTS `tbl_services_non_dc` (
  `dc_id` int(11) NOT NULL AUTO_INCREMENT,
  `dc_no` varchar(100) DEFAULT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `billing_date` date DEFAULT NULL,
  `customer_id` varchar(150) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `mblno` varchar(100) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gst_no` varchar(150) DEFAULT NULL,
  `state` varchar(150) DEFAULT NULL,
  `state_code` varchar(150) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `convert_status` varchar(50) DEFAULT NULL,
  `convert_id` varchar(100) DEFAULT NULL,
  `total_amount` varchar(100) DEFAULT NULL,
  `refrence_name` varchar(150) DEFAULT NULL,
  `vechicle_number` varchar(100) DEFAULT NULL,
  `vechicle_id` varchar(100) DEFAULT NULL,
  `driver_type` varchar(100) DEFAULT NULL,
  `driver_name` varchar(100) DEFAULT NULL,
  `driver_id` varchar(100) DEFAULT NULL,
  `grand_total_amount` varchar(100) DEFAULT NULL,
  `advance_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_terms_days` int(11) DEFAULT NULL,
  `service_place` enum('Outdoor','Workshop') DEFAULT NULL,
  `is_service_bill` tinyint(1) NOT NULL DEFAULT 0,
  `discount` varchar(150) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `delete_date` date DEFAULT NULL,
  `delete_status` varchar(100) DEFAULT NULL,
  `delete_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`dc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1",
'tbl_services_non_dc_details' => "CREATE TABLE IF NOT EXISTS `tbl_services_non_dc_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dc_id` int(11) NOT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `uom_id` varchar(100) DEFAULT NULL,
  `qty` text DEFAULT NULL,
  `rate` varchar(100) DEFAULT NULL,
  `product_rate` varchar(50) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(100) DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `delete_status` varchar(100) DEFAULT NULL,
  `delete_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1",
'tbl_services_non_receipt' => "CREATE TABLE IF NOT EXISTS `tbl_services_non_receipt` (
  `receipt_id` int(11) NOT NULL AUTO_INCREMENT,
  `dc_no` varchar(100) DEFAULT NULL,
  `billing_date` date DEFAULT NULL,
  `customer_id` varchar(150) DEFAULT NULL,
  `dc_id` varchar(100) DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `bank_id` varchar(50) DEFAULT NULL,
  `pay_amount` varchar(100) DEFAULT NULL,
  `is_service_bill` tinyint(1) NOT NULL DEFAULT 0,
  `ref_no` varchar(150) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `delete_date` date DEFAULT NULL,
  `delete_status` varchar(100) DEFAULT NULL,
  `delete_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`receipt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1",
];
foreach ($creates as $t => $sql) {
    if (tbl_exists10($conn, $t)) $log[] = "SKIP: table $t exists";
    else apply10($conn, "CREATE $t", $sql, $log);
}

// --- newer columns the grids select (older live DBs may lack them) ---
$cols = [
    ['tbl_services_non_dc', 'order_id', "ADD COLUMN `order_id` VARCHAR(50) NULL AFTER `dc_no`"],
    ['tbl_services_non_dc', 'advance_amount', "ADD COLUMN `advance_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `grand_total_amount`"],
    ['tbl_services_non_dc', 'payment_terms_days', "ADD COLUMN `payment_terms_days` INT NULL AFTER `advance_amount`"],
    ['tbl_services_non_dc', 'service_place', "ADD COLUMN `service_place` ENUM('Outdoor','Workshop') NULL AFTER `payment_terms_days`"],
    ['tbl_services_non_dc', 'is_service_bill', "ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `service_place`"],
    ['tbl_services_non_receipt', 'is_service_bill', "ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `pay_amount`"],
    ['tbl_services_non_receipt', 'ref_no', "ADD COLUMN `ref_no` VARCHAR(150) NULL AFTER `is_service_bill`"],
    ['tbl_gst_invoice', 'advance_amount', "ADD COLUMN `advance_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `grand_total_amount`"],
    ['tbl_gst_invoice', 'payment_terms_days', "ADD COLUMN `payment_terms_days` INT NULL AFTER `advance_amount`"],
    ['tbl_non_dc', 'advance_amount', "ADD COLUMN `advance_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `grand_total_amount`"],
    ['tbl_non_dc', 'payment_terms_days', "ADD COLUMN `payment_terms_days` INT NULL AFTER `advance_amount`"],
    ['tbl_non_dc', 'service_place', "ADD COLUMN `service_place` ENUM('Outdoor','Workshop') NULL AFTER `payment_terms_days`"],
    ['tbl_non_dc', 'is_service_bill', "ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `service_place`"],
    ['tbl_non_receipt', 'is_service_bill', "ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `pay_amount`"],
];
foreach ($cols as [$t, $c, $ddl]) {
    if (!tbl_exists10($conn, $t)) { $log[] = "SKIP: $t.$c (no table)"; continue; }
    if (!col_exists10($conn, $t, $c)) apply10($conn, "$t.$c", "ALTER TABLE `$t` $ddl", $log);
    else $log[] = "SKIP: $t.$c exists";
}

$log[] = "Migration 010 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/010_applied.log', $out, FILE_APPEND);
if (php_sapi_name() === 'cli') { echo $out; }
else { echo '<pre>' . htmlspecialchars($out) . '</pre>'; }
