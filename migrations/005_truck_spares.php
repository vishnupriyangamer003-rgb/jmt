<?php
// Migration 005: replace bricks catalog with truck spares (Plates / Oil & Lubricants / Service Parts).
// - Adds LTR/SET/KG uoms (idempotent)
// - Soft-deletes old products (delete_status='0'), inserts TRK-% products (NDL)
// - Remaps 004 demo detail rows from product_id 1/2 to new spares
// Run: php migrations/005_truck_spares.php
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

$log = ["Migration 005 started " . date('Y-m-d H:i:s')];
$now = date('Y-m-d H:i:s');

function has5(mysqli $conn, string $sql): bool {
    $r = mysqli_query($conn, $sql);
    $a = $r ? mysqli_fetch_assoc($r) : null;
    return $a && ((int)array_values($a)[0] > 0);
}

// 1. UOMs
foreach ([['LTR', 'Litre'], ['SET', 'Set'], ['KG', 'Kilogram']] as $u) {
    if (!has5($conn, "SELECT COUNT(*) FROM tbl_uom WHERE uom_name='{$u[0]}'")) {
        try { mysqli_query($conn, "INSERT INTO tbl_uom (uom_name,delete_status,created_by,create_date) VALUES ('{$u[0]}','NDL','admin','$now')"); $log[] = "OK: uom {$u[0]} id=" . mysqli_insert_id($conn); }
        catch (mysqli_sql_exception $e) { $log[] = "FAIL: uom {$u[0]} :: " . $e->getMessage(); }
    } else $log[] = "SKIP: uom {$u[0]} exists";
}
$uom = [];
foreach (['PCS', 'LTR', 'SET', 'KG'] as $n) {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT uom_id FROM tbl_uom WHERE uom_name='$n' LIMIT 1"));
    $uom[$n] = $r['uom_id'];
}

// 2. Deactivate old catalog (keep history rows)
try {
    mysqli_query($conn, "UPDATE tbl_products SET delete_status='0',deleted_by='admin',deleted_date='$now' WHERE delete_status='NDL'");
    $log[] = "OK: deactivated old catalog rows=" . mysqli_affected_rows($conn);
} catch (mysqli_sql_exception $e) { $log[] = "FAIL: deactivate :: " . $e->getMessage(); }

// 3. Truck spares: [code, name, category, hsn, gst, uom, sale, purchase]
$items = [
    ['TRK-CLU-001', 'Clutch Plate Assembly', 'Plates', '87089300', '18', 'PCS', '4500', '3600'],
    ['TRK-CLU-002', 'Pressure Plate', 'Plates', '87089300', '18', 'PCS', '3800', '3000'],
    ['TRK-CLU-003', 'Clutch Release Bearing', 'Plates', '84821000', '18', 'PCS', '950', '700'],
    ['TRK-CLU-004', 'Flywheel Ring Gear', 'Plates', '87089900', '18', 'PCS', '2200', '1700'],
    ['TRK-CLU-005', 'Clutch Fork', 'Plates', '87089900', '18', 'PCS', '650', '480'],
    ['TRK-OIL-001', 'Engine Oil 15W40', 'Oil & Lubricants', '27101980', '18', 'LTR', '420', '330'],
    ['TRK-OIL-002', 'Gear Oil 85W140', 'Oil & Lubricants', '27101980', '18', 'LTR', '480', '380'],
    ['TRK-OIL-003', 'Oil Filter', 'Oil & Lubricants', '84212300', '18', 'PCS', '350', '260'],
    ['TRK-OIL-004', 'Fuel Filter', 'Oil & Lubricants', '84212300', '18', 'PCS', '420', '310'],
    ['TRK-OIL-005', 'Air Filter Element', 'Oil & Lubricants', '84213100', '18', 'PCS', '850', '640'],
    ['TRK-OIL-006', 'Coolant', 'Oil & Lubricants', '38200000', '18', 'LTR', '300', '220'],
    ['TRK-SRV-001', 'Fan Belt', 'Service Parts', '40103900', '18', 'PCS', '550', '400'],
    ['TRK-SRV-002', 'Brake Lining Set', 'Service Parts', '68138100', '18', 'SET', '1800', '1350'],
    ['TRK-SRV-003', 'Wheel Bearing Kit', 'Service Parts', '84821000', '18', 'SET', '2400', '1850'],
    ['TRK-SRV-004', 'Grease', 'Service Parts', '27101990', '18', 'KG', '380', '290'],
    ['TRK-SRV-005', 'Head Lamp Bulb Set', 'Service Parts', '85392900', '18', 'SET', '700', '520'],
    ['TRK-SRV-006', 'Wiper Blade Set', 'Service Parts', '85129000', '18', 'SET', '450', '330'],
    ['TRK-SRV-007', 'Gasket Kit', 'Service Parts', '40169300', '18', 'SET', '1200', '900'],
];
$newIds = [];
foreach ($items as $it) {
    if (has5($conn, "SELECT COUNT(*) FROM tbl_products WHERE product_code='{$it[0]}'")) {
        $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_id FROM tbl_products WHERE product_code='{$it[0]}' LIMIT 1"));
        $newIds[$it[0]] = $r['product_id'];
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

// 4. Remap 004 demo detail rows (old product_id 1/2 -> clutch plate + engine oil)
$clutch = $newIds['TRK-CLU-001'] ?? 0;
$oil = $newIds['TRK-OIL-001'] ?? 0;
if ($clutch && $oil) {
    $detailTables = ['tbl_gst_invoice_details', 'tbl_non_dc_details', 'tbl_sky_gst_invoice_details', 'tbl_dc_details', 'tbl_order_details'];
    foreach ($detailTables as $t) {
        try {
            mysqli_query($conn, "UPDATE `$t` SET product_id='$clutch' WHERE product_id='2'");
            $a = mysqli_affected_rows($conn);
            mysqli_query($conn, "UPDATE `$t` SET product_id='$oil' WHERE product_id='1'");
            $b = mysqli_affected_rows($conn);
            $log[] = "OK: remap $t 2->$clutch ($a), 1->$oil ($b)";
        } catch (mysqli_sql_exception $e) { $log[] = "FAIL: remap $t :: " . $e->getMessage(); }
    }
    // refresh demo rates to match new spares (clutch 4500, oil 420/L)
    try {
        mysqli_query($conn, "UPDATE tbl_gst_invoice_details SET rate='4500',product_rate='4500',qty='2' WHERE product_id='$clutch' AND dc_id IN (SELECT dc_id FROM tbl_gst_invoice WHERE suffix='DEMO')");
        mysqli_query($conn, "UPDATE tbl_gst_invoice_details SET rate='420',product_rate='4200',qty='10' WHERE product_id='$oil' AND dc_id IN (SELECT dc_id FROM tbl_gst_invoice WHERE suffix='DEMO')");
        $log[] = "OK: refreshed demo gst detail rates";
    } catch (mysqli_sql_exception $e) { $log[] = "FAIL: refresh rates :: " . $e->getMessage(); }
} else $log[] = "SKIP: remap (missing new ids)";

try {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_products WHERE delete_status='NDL'")); $log[] = "POST active_products=" . $r['t'];
} catch (Throwable $e) { $log[] = "POST note: " . $e->getMessage(); }
$log[] = "Migration 005 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/005_applied.log', $out, FILE_APPEND);
echo $out;
