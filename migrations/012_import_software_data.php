<?php
// Migration 012: import product name + sales price from doc/software data.xlsx into tbl_products.
// Sheet "Item Master List": header on row 3, B = Item Name, H = Purchase Rate, J = Sales Rate. Other columns ignored.
// Idempotent: skips names that already exist (delete_status='NDL').
// Run: php migrations/012_import_software_data.php
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';
require_once $base . '/phpspreadsheet/vendor/phpoffice/phpspreadsheet/src/Bootstrap.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$now = date('Y-m-d H:i:s');
$reader = IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(true);
$rows = $reader->load($base . '/doc/software data.xlsx')->getActiveSheet()->toArray(null, true, true, true);

$ins = $upd = $skip = $fail = 0;
foreach ($rows as $n => $r) {
    if ($n <= 3) continue; // title rows + header
    $name = trim((string)($r['B'] ?? ''));
    if ($name === '') continue;
    $price = (float)str_replace(',', '', (string)($r['J'] ?? '0'));
    $price = number_format($price, 2, '.', '');
    $purchase = number_format((float)str_replace(',', '', (string)($r['H'] ?? '0')), 2, '.', '');
    $e = mysqli_real_escape_string($conn, $name);

    $q = mysqli_query($conn, "SELECT 1 FROM tbl_products WHERE product_name='$e' AND delete_status='NDL' LIMIT 1");
    if ($q && mysqli_num_rows($q) > 0) {
        // already imported: fill purchase rate only where it is still empty/0 (never overwrite manual edits)
        mysqli_query($conn, "UPDATE tbl_products SET purchase_rate='$purchase' WHERE product_name='$e' AND delete_status='NDL' AND (purchase_rate IS NULL OR purchase_rate=0) AND '$purchase'>0");
        if (mysqli_affected_rows($conn) > 0) $upd++; else $skip++;
        continue;
    }

    $ok = mysqli_query($conn, "INSERT INTO tbl_products (product_name,hsn_code,sale_price,purchase_rate,status,delete_status,deleted_by,created_by,updated_by,create_date) VALUES ('$e','','$price','$purchase','Active','NDL','','admin','','$now')");
    if ($ok) $ins++; else { $fail++; echo "FAIL row $n: " . mysqli_error($conn) . "\n"; }
}
echo "inserted=$ins updated=$upd skipped=$skip failed=$fail\n";
