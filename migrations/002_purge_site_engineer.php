<?php
// Migration 002: purge Site + Engineer concepts. Idempotent, logged. Backup taken before run.
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

function col_exists2(mysqli $conn, string $table, string $col): bool {
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `" . mysqli_real_escape_string($conn, $table) . "`");
    if (!$res) return false;
    while ($r = mysqli_fetch_assoc($res)) { if (strcasecmp($r['Field'], $col) === 0) return true; }
    return false;
}
function table_exists2(mysqli $conn, string $table): bool {
    $res = mysqli_query($conn, "SHOW TABLES LIKE '" . mysqli_real_escape_string($conn, $table) . "'");
    return $res && mysqli_num_rows($res) > 0;
}
$log = ["Migration 002 started " . date('Y-m-d H:i:s')];
// Snapshot totals for post-verify
try {
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_gst_invoice WHERE delete_status='NDL'"));
  $log[] = "PRE gst_total=" . $r['t'];
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_non_dc WHERE delete_status='NDL'"));
  $log[] = "PRE nongst_total=" . $r['t'];
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_receipt WHERE delete_status='NDL'"));
  $log[] = "PRE receipt_total=" . $r['t'];
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_non_receipt WHERE delete_status='NDL'"));
  $log[] = "PRE nonreceipt_total=" . $r['t'];
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_site"));
  $log[] = "PRE site_rows=" . $r['t'];
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_engineer"));
  $log[] = "PRE engineer_rows=" . $r['t'];
} catch (Throwable $e) { $log[] = "PRE snapshot note: " . $e->getMessage(); }

foreach (['tbl_engineer', 'tbl_site', 'tbl_customer_engineer_details', 'tbl_customer_site_details'] as $t) {
    if (table_exists2($conn, $t)) {
        try { mysqli_query($conn, "DROP TABLE `$t`"); $log[] = "OK: dropped $t"; }
        catch (mysqli_sql_exception $e) { $log[] = "FAIL: drop $t :: " . $e->getMessage(); }
    } else $log[] = "SKIP: $t already gone";
}
$drops = [
    'tbl_gst_invoice' => ['site_id', 'engineer_name'],
    'tbl_non_dc' => ['site_id', 'engineer_name'],
    'tbl_receipt' => ['site_id'],
    'tbl_non_receipt' => ['site_id'],
];
foreach ($drops as $t => $cols) {
    foreach ($cols as $c) {
        if (col_exists2($conn, $t, $c)) {
            try { mysqli_query($conn, "ALTER TABLE `$t` DROP COLUMN `$c`"); $log[] = "OK: $t DROP $c"; }
            catch (mysqli_sql_exception $e) { $log[] = "FAIL: $t DROP $c :: " . $e->getMessage(); }
        } else $log[] = "SKIP: $t.$c already gone";
    }
}
try {
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_gst_invoice WHERE delete_status='NDL'"));
  $log[] = "POST gst_total=" . $r['t'];
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_non_dc WHERE delete_status='NDL'"));
  $log[] = "POST nongst_total=" . $r['t'];
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_receipt WHERE delete_status='NDL'"));
  $log[] = "POST receipt_total=" . $r['t'];
  $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_non_receipt WHERE delete_status='NDL'"));
  $log[] = "POST nonreceipt_total=" . $r['t'];
} catch (Throwable $e) { $log[] = "POST snapshot note: " . $e->getMessage(); }
$log[] = "Migration 002 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/002_applied.log', $out, FILE_APPEND);
echo $out;
