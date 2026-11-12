<?php
/* Migration 008: Non-GST vs Service virtual split - additive only, idempotent.
 * - Ensures tbl_non_dc.is_service_bill + service_place, backfills NULL->0, adds index.
 * - Adds tbl_non_receipt.is_service_bill, backfills from parent bill, adds index.
 * Run: php migrations/008_service_split.php
 */
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

function col_exists8(mysqli $conn, string $table, string $col): bool {
    $t = mysqli_real_escape_string($conn, $table);
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `$t`");
    if (!$res) return false;
    while ($r = mysqli_fetch_assoc($res)) {
        if (strcasecmp($r['Field'], $col) === 0) return true;
    }
    return false;
}
function apply8(mysqli $conn, string $label, string $sql, array &$log): void {
    try {
        mysqli_query($conn, $sql);
        $log[] = "OK: $label";
    } catch (mysqli_sql_exception $e) {
        $log[] = "FAIL: $label :: " . $e->getMessage();
    }
}

$log = [];
$log[] = "Migration 008 started " . date('Y-m-d H:i:s');

if (!col_exists8($conn, 'tbl_non_dc', 'service_place'))
    apply8($conn, 'tbl_non_dc.service_place', "ALTER TABLE `tbl_non_dc` ADD COLUMN `service_place` ENUM('Outdoor','Workshop') NULL AFTER `payment_terms_days`", $log);
else $log[] = "SKIP: tbl_non_dc.service_place exists";

if (!col_exists8($conn, 'tbl_non_dc', 'is_service_bill'))
    apply8($conn, 'tbl_non_dc.is_service_bill', "ALTER TABLE `tbl_non_dc` ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `service_place`", $log);
else $log[] = "SKIP: tbl_non_dc.is_service_bill exists";

try {
    mysqli_query($conn, "UPDATE `tbl_non_dc` SET `is_service_bill`=0 WHERE `is_service_bill` IS NULL");
    $log[] = "OK: tbl_non_dc backfill NULL->0 (affected=" . mysqli_affected_rows($conn) . ")";
} catch (mysqli_sql_exception $e) { $log[] = "FAIL: tbl_non_dc backfill :: " . $e->getMessage(); }

if (!col_exists8($conn, 'tbl_non_receipt', 'is_service_bill'))
    apply8($conn, 'tbl_non_receipt.is_service_bill', "ALTER TABLE `tbl_non_receipt` ADD COLUMN `is_service_bill` TINYINT(1) NOT NULL DEFAULT 0 AFTER `pay_amount`", $log);
else $log[] = "SKIP: tbl_non_receipt.is_service_bill exists";

try {
    mysqli_query($conn, "UPDATE `tbl_non_receipt` r JOIN `tbl_non_dc` d ON d.dc_id=r.dc_id SET r.is_service_bill=d.is_service_bill WHERE r.is_service_bill<>d.is_service_bill OR r.is_service_bill IS NULL");
    $log[] = "OK: tbl_non_receipt backfill from parent (affected=" . mysqli_affected_rows($conn) . ")";
} catch (mysqli_sql_exception $e) { $log[] = "FAIL: tbl_non_receipt backfill :: " . $e->getMessage(); }

foreach ([
    'idx_nondc_service' => "ALTER TABLE `tbl_non_dc` ADD INDEX `idx_nondc_service` (`delete_status`,`is_service_bill`)",
    'idx_nonreceipt_service' => "ALTER TABLE `tbl_non_receipt` ADD INDEX `idx_nonreceipt_service` (`delete_status`,`is_service_bill`)",
] as $name => $sql) {
    try { mysqli_query($conn, $sql); $log[] = "OK: index $name"; }
    catch (mysqli_sql_exception $e) {
        if (stripos($e->getMessage(), 'Duplicate key name') !== false) $log[] = "SKIP: index $name exists";
        else $log[] = "FAIL: index $name :: " . $e->getMessage();
    }
}

try {
    $r = mysqli_query($conn, "SELECT is_service_bill, COUNT(*) c FROM tbl_non_dc WHERE delete_status='NDL' GROUP BY is_service_bill");
    while ($a = mysqli_fetch_assoc($r)) $log[] = "COUNT tbl_non_dc flag={$a['is_service_bill']}: {$a['c']}";
    $r = mysqli_query($conn, "SELECT is_service_bill, COUNT(*) c FROM tbl_non_receipt WHERE delete_status='NDL' GROUP BY is_service_bill");
    while ($a = mysqli_fetch_assoc($r)) $log[] = "COUNT tbl_non_receipt flag={$a['is_service_bill']}: {$a['c']}";
} catch (mysqli_sql_exception $e) { $log[] = "FAIL: counts :: " . $e->getMessage(); }

$log[] = "Migration 008 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/008_applied.log', $out, FILE_APPEND);
if (php_sapi_name() === 'cli') { echo $out; }
else { echo '<pre>' . htmlspecialchars($out) . '</pre>'; }
