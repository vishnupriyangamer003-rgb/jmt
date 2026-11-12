<?php
// Migration 007: opening_stock for traded spares + demo seed.
// Run: php migrations/007_stock_opening.php
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

$log = ["Migration 007 started " . date('Y-m-d H:i:s')];
try {
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `tbl_products` LIKE 'opening_stock'");
    if (mysqli_num_rows($res) === 0) {
        mysqli_query($conn, "ALTER TABLE `tbl_products` ADD COLUMN `opening_stock` DECIMAL(12,2) NOT NULL DEFAULT 0 AFTER `purchase_rate`");
        $log[] = "OK: tbl_products ADD opening_stock";
    } else $log[] = "SKIP: opening_stock exists";
} catch (mysqli_sql_exception $e) { $log[] = "FAIL: alter :: " . $e->getMessage(); }

// Demo opening stock for JCB items (pcs/set items 50, oils/grease/coolant 100)
try {
    mysqli_query($conn, "UPDATE tbl_products SET opening_stock = CASE WHEN uom_id IN (SELECT uom_id FROM tbl_uom WHERE uom_name IN ('LTR','KG')) THEN 100 ELSE 50 END WHERE product_code LIKE 'JCB-%'");
    $log[] = "OK: seeded JCB opening stock rows=" . mysqli_affected_rows($conn);
} catch (mysqli_sql_exception $e) { $log[] = "FAIL: seed :: " . $e->getMessage(); }

try {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_products WHERE delete_status='NDL' AND opening_stock > 0"));
    $log[] = "POST stocked_products=" . $r['t'];
} catch (Throwable $e) { $log[] = "POST note: " . $e->getMessage(); }
$log[] = "Migration 007 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/007_applied.log', $out, FILE_APPEND);
echo $out;
