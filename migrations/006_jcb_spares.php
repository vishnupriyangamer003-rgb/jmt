<?php
// Migration 006: replace TRK truck spares with JCB spares (Hydraulics / Filters & Oils / Service).
// - Soft-deletes TRK-% products, inserts JCB-% products (idempotent)
// - Remaps demo detail rows (clutch/oil ids) to JCB seal kit + JCB engine oil
// Run: php migrations/006_jcb_spares.php
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

$log = ["Migration 006 started " . date('Y-m-d H:i:s')];
$now = date('Y-m-d H:i:s');

function has6(mysqli $conn, string $sql): bool {
    $r = mysqli_query($conn, $sql);
    $a = $r ? mysqli_fetch_assoc($r) : null;
    return $a && ((int)array_values($a)[0] > 0);
}
$uom = [];
foreach (['PCS', 'LTR', 'SET', 'KG'] as $n) {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT uom_id FROM tbl_uom WHERE uom_name='$n' LIMIT 1"));
    $uom[$n] = $r['uom_id'];
}

// 1. Deactivate TRK catalog
try {
    mysqli_query($conn, "UPDATE tbl_products SET delete_status='0',deleted_by='admin',deleted_date='$now' WHERE product_code LIKE 'TRK-%' AND delete_status='NDL'");
    $log[] = "OK: deactivated TRK rows=" . mysqli_affected_rows($conn);
} catch (mysqli_sql_exception $e) { $log[] = "FAIL: deactivate :: " . $e->getMessage(); }

// old demo product ids (clutch=13, oil=18) for remap
$oldSeal = (int)(mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_id FROM tbl_products WHERE product_code='TRK-CLU-001' LIMIT 1"))['product_id'] ?? 0);
$oldOil = (int)(mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_id FROM tbl_products WHERE product_code='TRK-OIL-001' LIMIT 1"))['product_id'] ?? 0);

// 2. JCB items: [code, name, category, hsn, gst, uom, sale, purchase]
$items = [
    ['JCB-HYD-001', 'Hydraulic Seal Kit', 'Hydraulics', '40169300', '18', 'SET', '2800', '2100'],
    ['JCB-HYD-002', 'Hydraulic Hose Pipe', 'Hydraulics', '40092100', '18', 'PCS', '1450', '1050'],
    ['JCB-HYD-003', 'Hydraulic Pump Spares Kit', 'Hydraulics', '84139100', '18', 'SET', '9500', '7200'],
    ['JCB-HYD-004', 'Control Valve Seal Kit', 'Hydraulics', '40169300', '18', 'SET', '3200', '2400'],
    ['JCB-HYD-005', 'Hydraulic Oil Filter', 'Hydraulics', '84212300', '18', 'PCS', '650', '470'],
    ['JCB-HYD-006', 'Bucket Tooth Point', 'Hydraulics', '84314100', '18', 'PCS', '850', '620'],
    ['JCB-FLT-001', 'Engine Oil 15W40 (JCB)', 'Filters & Oils', '27101980', '18', 'LTR', '460', '360'],
    ['JCB-FLT-002', 'Hydraulic Oil 68', 'Filters & Oils', '27101980', '18', 'LTR', '520', '410'],
    ['JCB-FLT-003', 'Engine Oil Filter', 'Filters & Oils', '84212300', '18', 'PCS', '380', '280'],
    ['JCB-FLT-004', 'Fuel Filter', 'Filters & Oils', '84212300', '18', 'PCS', '450', '330'],
    ['JCB-FLT-005', 'Air Filter Element', 'Filters & Oils', '84213100', '18', 'PCS', '980', '730'],
    ['JCB-FLT-006', 'Transmission Oil Filter', 'Filters & Oils', '84212300', '18', 'PCS', '720', '540'],
    ['JCB-SRV-001', 'Fan Belt', 'Service Parts', '40103900', '18', 'PCS', '620', '450'],
    ['JCB-SRV-002', 'Wiper Motor', 'Service Parts', '85129000', '18', 'PCS', '2600', '1950'],
    ['JCB-SRV-003', 'Head Lamp Assembly', 'Service Parts', '85122000', '18', 'PCS', '1350', '1000'],
    ['JCB-SRV-004', 'Grease', 'Service Parts', '27101990', '18', 'KG', '400', '300'],
    ['JCB-SRV-005', 'Gasket Kit', 'Service Parts', '40169300', '18', 'SET', '1500', '1100'],
    ['JCB-SRV-006', 'Pivot Pin & Bush Kit', 'Service Parts', '84314900', '18', 'SET', '3100', '2300'],
];
$newIds = [];
foreach ($items as $it) {
    if (has6($conn, "SELECT COUNT(*) FROM tbl_products WHERE product_code='{$it[0]}'")) {
        $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_id FROM tbl_products WHERE product_code='{$it[0]}' LIMIT 1"));
        $newIds[$it[0]] = $r['product_id'];
        // ensure active on re-run
        mysqli_query($conn, "UPDATE tbl_products SET delete_status='NDL' WHERE product_code='{$it[0]}'");
        $log[] = "SKIP: {$it[0]} exists";
        continue;
    }
    try {
        mysqli_query($conn, "INSERT INTO tbl_products (product_name,product_code,hsn_code,gst,uom_id,sale_price,purchase_rate,category,status,delete_status,created_by,create_date) VALUES ('{$it[1]}','{$it[0]}','{$it[3]}','{$it[4]}','{$uom[$it[5]]}','{$it[6]}','{$it[7]}','{$it[2]}','Active','NDL','admin','$now')");
        $id = mysqli_insert_id($conn);
        $newIds[$it[0]] = $id;
        $log[] = "OK: {$it[0]} id=$id";
    } catch (mysqli_sql_exception $e) { $log[] = "FAIL: {$it[0]} :: " . $e->getMessage(); }
}

// 3. Remap demo details
$seal = $newIds['JCB-HYD-001'] ?? 0;
$oil = $newIds['JCB-FLT-001'] ?? 0;
if ($seal && $oil && $oldSeal && $oldOil) {
    foreach (['tbl_gst_invoice_details', 'tbl_non_dc_details', 'tbl_sky_gst_invoice_details', 'tbl_dc_details', 'tbl_order_details'] as $t) {
        try {
            mysqli_query($conn, "UPDATE `$t` SET product_id='$seal' WHERE product_id='$oldSeal'");
            $a = mysqli_affected_rows($conn);
            mysqli_query($conn, "UPDATE `$t` SET product_id='$oil' WHERE product_id='$oldOil'");
            $b = mysqli_affected_rows($conn);
            $log[] = "OK: remap $t $oldSeal->$seal ($a), $oldOil->$oil ($b)";
        } catch (mysqli_sql_exception $e) { $log[] = "FAIL: remap $t :: " . $e->getMessage(); }
    }
    try {
        mysqli_query($conn, "UPDATE tbl_gst_invoice_details SET rate='2800',product_rate='5600',qty='2' WHERE product_id='$seal' AND dc_id IN (SELECT dc_id FROM tbl_gst_invoice WHERE suffix='DEMO')");
        mysqli_query($conn, "UPDATE tbl_gst_invoice_details SET rate='460',product_rate='4600',qty='10' WHERE product_id='$oil' AND dc_id IN (SELECT dc_id FROM tbl_gst_invoice WHERE suffix='DEMO')");
        $log[] = "OK: refreshed demo gst detail rates";
    } catch (mysqli_sql_exception $e) { $log[] = "FAIL: refresh rates :: " . $e->getMessage(); }
} else $log[] = "SKIP: remap (ids seal=$seal oil=$oil old=$oldSeal/$oldOil)";

try {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_products WHERE delete_status='NDL'")); $log[] = "POST active_products=" . $r['t'];
} catch (Throwable $e) { $log[] = "POST note: " . $e->getMessage(); }
$log[] = "Migration 006 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/006_applied.log', $out, FILE_APPEND);
echo $out;
