<?php
// Migration 004: dummy demo seed for all wiped tables. Idempotent (Demo% markers), logged.
// Run: php migrations/004_seed_dummy.php
$base = dirname(__DIR__);
require $base . '/phpservices/connection.php';

$log = ["Migration 004 started " . date('Y-m-d H:i:s')];
$now = date('Y-m-d H:i:s');
$today = date('Y-m-d');
$d1 = date('Y-m-d', strtotime('-2 days'));
$d2 = date('Y-m-d', strtotime('-1 day'));

function seeded(mysqli $conn, string $sql): bool {
    $r = mysqli_query($conn, $sql);
    $a = $r ? mysqli_fetch_assoc($r) : null;
    return $a && ((int)array_values($a)[0] > 0);
}
function ins(mysqli $conn, string $label, string $sql, array &$log) {
    try {
        mysqli_query($conn, $sql);
        $log[] = "OK: $label id=" . mysqli_insert_id($conn);
        return mysqli_insert_id($conn);
    } catch (mysqli_sql_exception $e) { $log[] = "FAIL: $label :: " . $e->getMessage(); return 0; }
}

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");

// ---- 1. Customers x5 ----
$cids = [];
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_customer WHERE customer_name LIKE 'Demo %'")) {
    $demos = [
        ['Demo Customer - Karur', 'Demo Ref Karur', 'Demo Traders Karur', '9840010001', '33DEMO10001X1Z5', 'Karur, Tamil Nadu'],
        ['Demo Customer - Namakkal', 'Demo Ref Namakkal', 'Demo Traders Namakkal', '9840010002', '33DEMO10002X1Z5', 'Namakkal, Tamil Nadu'],
        ['Demo Customer - Velur', 'Demo Ref Velur', 'Demo Traders Velur', '9840010003', '33DEMO10003X1Z5', 'Velur, Namakkal'],
        ['Demo Customer - Mohanur', 'Demo Ref Mohanur', 'Demo Traders Mohanur', '9840010004', '33DEMO10004X1Z5', 'Mohanur, Namakkal'],
        ['Demo Customer - Vengamedu', 'Demo Ref Vengamedu', 'Demo Traders Vengamedu', '9840010005', '33DEMO10005X1Z5', 'Vengamedu, Karur'],
    ];
    foreach ($demos as $i => $d) {
        $id = ins($conn, "customer {$d[0]}", "INSERT INTO tbl_customer (customer_name,reference_name,company_name,owner_name,gst_no,state_code,state,mblno,owner_contact,reference_details,status,email,address,create_date,created_by,delete_status) VALUES ('{$d[0]}','{$d[1]}','{$d[2]}','Demo Owner','{$d[4]}','33','Tamil Nadu','{$d[3]}','9840099999','Demo seed','Active','demo{$i}@example.com','{$d[5]}','$now','admin','NDL')", $log);
        if ($id) $cids[] = $id;
        ins($conn, "customer_backup {$d[0]}", "INSERT INTO tbl_customer_backup (customer_id,customer_name,company_name,gst_no,state_code,state,mblno,email,address,create_date,created_by,delete_status) VALUES ('$id','{$d[0]}','{$d[2]}','{$d[4]}','33','Tamil Nadu','{$d[3]}','demo{$i}@example.com','{$d[5]}','$now','admin','NDL')", $log);
    }
} else { $log[] = "SKIP: customers already seeded"; $r = mysqli_query($conn, "SELECT customer_id FROM tbl_customer WHERE customer_name LIKE 'Demo %' ORDER BY customer_id LIMIT 5"); while ($a = mysqli_fetch_assoc($r)) $cids[] = $a['customer_id']; }
$c1 = $cids[0] ?? 1; $c2 = $cids[1] ?? 1; $c3 = $cids[2] ?? 1;

// ---- 2. GST bills x3 + details ----
$gstDc = [];
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_gst_invoice WHERE suffix='DEMO'")) {
    $bills = [
        [$c1, 'DEMO-GST-1', $d1, '10000', '900', '900', '1800', '11800'],
        [$c2, 'DEMO-GST-2', $d2, '20000', '1800', '1800', '3600', '23600'],
        [$c3, 'DEMO-GST-3', $today, '5000', '450', '450', '900', '5900'],
    ];
    foreach ($bills as $b) {
        $id = ins($conn, "gst {$b[1]}", "INSERT INTO tbl_gst_invoice (dc_no,suffix,billing_date,customer_id,company_name,mblno,email,address,gst_no,state,state_code,delivery_address,total_amount,refrence_name,vechicle_number,vechicle_id,driver_type,driver_name,driver_id,discount,cgst,sgst,gst_total_amount,grand_total_amount,advance_amount,created_by,create_date,delete_status) VALUES ('{$b[1]}','DEMO','{$b[2]}','$b[0]','Demo Traders','9840010001','demo@example.com','Karur','33DEMO10001X1Z5','Tamil Nadu','33','Karur','$b[3]','Demo Ref','TN76 MK 5649','1','1','','1','0','$b[4]','$b[5]','$b[6]','$b[7]','1000','admin','$now','NDL')", $log);
        if ($id) { $gstDc[] = $id;
            ins($conn, "gst_det $id-a", "INSERT INTO tbl_gst_invoice_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id','2','1','1000','6.50','6500','admin','$now','NDL')", $log);
            ins($conn, "gst_det $id-b", "INSERT INTO tbl_gst_invoice_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id','1','1','500','10','5000','admin','$now','NDL')", $log);
        }
    }
} else $log[] = "SKIP: gst already seeded";

// ---- 3. Non-GST x2 + details (1 regular, 1 service) ----
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_non_dc WHERE dc_no LIKE 'DEMO-NON%'")) {
    $id = ins($conn, "nongst DEMO-NON-1", "INSERT INTO tbl_non_dc (dc_no,billing_date,customer_id,company_name,mblno,address,delivery_address,total_amount,refrence_name,grand_total_amount,advance_amount,is_service_bill,discount,created_by,create_date,delete_status) VALUES ('DEMO-NON-1','$d2','$c1','Demo Traders','9840010001','Karur','Karur','8000','Demo Ref','8000','0',0,'0','admin','$now','NDL')", $log);
    if ($id) { ins($conn, "nondet $id-a", "INSERT INTO tbl_non_dc_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id','2','1','1000','6.50','6500','admin','$now','NDL')", $log); ins($conn, "nondet $id-b", "INSERT INTO tbl_non_dc_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id','1','1','150','10','1500','admin','$now','NDL')", $log); }
    $id2 = ins($conn, "nongst DEMO-NON-2 service", "INSERT INTO tbl_non_dc (dc_no,billing_date,customer_id,company_name,mblno,address,delivery_address,total_amount,refrence_name,grand_total_amount,advance_amount,service_place,is_service_bill,discount,created_by,create_date,delete_status) VALUES ('DEMO-NON-2','$today','$c2','Demo Traders','9840010002','Namakkal','Namakkal','3000','Demo Ref','3000','0','Workshop',1,'0','admin','$now','NDL')", $log);
    if ($id2) { ins($conn, "nondet $id2-a", "INSERT INTO tbl_non_dc_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id2','2','1','200','6.50','1300','admin','$now','NDL')", $log); ins($conn, "nondet $id2-b", "INSERT INTO tbl_non_dc_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id2','1','1','170','10','1700','admin','$now','NDL')", $log); }
} else $log[] = "SKIP: nongst already seeded";

// ---- 4. SKY GST x2 + details ----
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_sky_gst_invoice WHERE suffix='DEMO'")) {
    foreach ([[$c1, 'DEMO-SKY-1', $d2, '15000', '1350', '1350', '2700', '17700'], [$c2, 'DEMO-SKY-2', $today, '7000', '630', '630', '1260', '8260']] as $b) {
        $id = ins($conn, "sky {$b[1]}", "INSERT INTO tbl_sky_gst_invoice (dc_no,suffix,billing_date,customer_id,company_name,mblno,address,gst_no,state,state_code,delivery_address,total_amount,refrence_name,driver_type,discount,cgst,sgst,gst_total_amount,grand_total_amount,created_by,create_date,delete_status) VALUES ('{$b[1]}','DEMO','{$b[2]}','$b[0]','Demo Traders','9840010001','Karur','33DEMO10001X1Z5','Tamil Nadu','33','Karur','$b[3]','Demo Ref','2','0','$b[4]','$b[5]','$b[6]','$b[7]','admin','$now','NDL')", $log);
        if ($id) { ins($conn, "skydet $id-a", "INSERT INTO tbl_sky_gst_invoice_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id','2','1','1000','6.50','6500','admin','$now','NDL')", $log); ins($conn, "skydet $id-b", "INSERT INTO tbl_sky_gst_invoice_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id','1','1','500','10','5000','admin','$now','NDL')", $log); }
    }
} else $log[] = "SKIP: sky already seeded";

// ---- 5. DC x2 + SDC x1 + details ----
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_dc WHERE dc_no LIKE 'DEMO-DC%'")) {
    foreach ([[$c1, 'DEMO-DC-1'], [$c2, 'DEMO-DC-2']] as $d) {
        $id = ins($conn, "dc {$d[1]}", "INSERT INTO tbl_dc (dc_no,billing_date,customer_id,company_name,mblno,address,delivery_address,total_amount,grand_total_amount,created_by,create_date,delete_status) VALUES ('{$d[1]}','$d2','$d[0]','Demo Traders','9840010001','Karur','Karur','6000','6000','admin','$now','NDL')", $log);
        if ($id) { ins($conn, "dcdet $id-a", "INSERT INTO tbl_dc_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id','2','1','500','6.50','3250','admin','$now','NDL')", $log); ins($conn, "dcdet $id-b", "INSERT INTO tbl_dc_details (dc_id,product_id,uom_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$id','1','1','275','10','2750','admin','$now','NDL')", $log); }
    }
    $sid = ins($conn, "sdc DEMO-SDC-1", "INSERT INTO tbl_sdc (dc_no,billing_date,customer_id,total_amount,grand_total_amount,created_by,create_date,delete_status) VALUES ('DEMO-SDC-1','$today','$c3','2000','2000','admin','$now','NDL')", $log);
    if ($sid) { ins($conn, "sdcdet-a", "INSERT INTO tbl_sdc_details (dc_id,product_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$sid','2','200','6.50','1300','admin','$now','NDL')", $log); ins($conn, "sdcdet-b", "INSERT INTO tbl_sdc_details (dc_id,product_id,qty,rate,product_rate,created_by,create_date,delete_status) VALUES ('$sid','1','70','10','700','admin','$now','NDL')", $log); }
} else $log[] = "SKIP: dc/sdc already seeded";

// ---- 6. Receipts ----
$gdc = $gstDc[0] ?? 0;
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_receipt WHERE ref_no='DEMO-SEED'")) {
    if ($gdc) {
        $rid = ins($conn, "receipt gst", "INSERT INTO tbl_receipt (dc_no,billing_date,customer_id,dc_id,payment_mode,bank_id,pay_amount,ref_no,remarks,created_by,create_date,delete_status) VALUES ('DEMO-GST-1','$today','$c1','$gdc','Cash','1','5000','DEMO-SEED','Demo seed part-payment','admin','$now','NDL')", $log);
        if ($rid) ins($conn, "receipt_det", "INSERT INTO tbl_receipt_details (receipt_id,product_id,hsn_code,qty,uom_id,rate,product_rate,created_by,create_date,delete_status) VALUES ('$rid','2','68','500','1','6.50','3250','admin','$now','NDL')", $log);
    }
    ins($conn, "non_receipt", "INSERT INTO tbl_non_receipt (dc_no,billing_date,customer_id,dc_id,payment_mode,bank_id,pay_amount,ref_no,remarks,created_by,create_date,delete_status) VALUES ('DEMO-NON-1','$today','$c1','1','Cash','1','3000','DEMO-SEED','Demo seed','admin','$now','NDL')", $log);
    ins($conn, "non_receipt2", "INSERT INTO tbl_non_receipt (dc_no,billing_date,customer_id,dc_id,payment_mode,bank_id,pay_amount,ref_no,remarks,created_by,create_date,delete_status) VALUES ('DEMO-NON-2','$today','$c2','2','UPI','1','1500','DEMO-SEED','Demo seed','admin','$now','NDL')", $log);
    ins($conn, "sky_receipt", "INSERT INTO tbl_sky_receipt (dc_no,billing_date,customer_id,dc_id,payment_mode,bank_id,pay_amount,created_by,create_date,delete_status) VALUES ('DEMO-SKY-1','$today','$c1','1','Cash','1','7000','admin','$now','NDL')", $log);
} else $log[] = "SKIP: receipts already seeded";

// ---- 7. Orders x2 + details ----
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_order WHERE order_no LIKE 'DEMO-ORD%'")) {
    foreach ([[$c1, 'DEMO-ORD-1'], [$c2, 'DEMO-ORD-2']] as $o) {
        $id = ins($conn, "order {$o[1]}", "INSERT INTO tbl_order (order_no,order_date,delivery_date,customer_id,company_name,mblno,address,gst_no,state,state_code,created_by,create_date,delete_status) VALUES ('{$o[1]}','$today','" . date('Y-m-d', strtotime('+7 days')) . "','$o[0]','Demo Traders','9840010001','Karur','33DEMO10001X1Z5','Tamil Nadu','33','admin','$now','NDL')", $log);
        if ($id) { ins($conn, "orddet $id-a", "INSERT INTO tbl_order_details (order_id,product_id,uom_id,qty,created_by,create_date,delete_status) VALUES ('$id','2','1','2000','admin','$now','NDL')", $log); ins($conn, "orddet $id-b", "INSERT INTO tbl_order_details (order_id,product_id,uom_id,qty,created_by,create_date,delete_status) VALUES ('$id','1','1','1000','admin','$now','NDL')", $log); }
    }
} else $log[] = "SKIP: orders already seeded";

// ---- 8. Raw purchase x2 + details, payment x2, gate pass x2, eway x1 ----
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_raw_purchase WHERE dc_no LIKE 'DEMO-RP%'")) {
    foreach ([['DEMO-RP-1', '17'], ['DEMO-RP-2', '18']] as $p) {
        $id = ins($conn, "rawpur {$p[0]}", "INSERT INTO tbl_raw_purchase (dc_no,purchase_date,billing_date,supplier_id,total_amount,tax_amount,grand_total_amount,created_by,create_date,delete_status) VALUES ('{$p[0]}','$today','$today','{$p[1]}','50000','2500','52500','admin','$now','NDL')", $log);
        if ($id) { ins($conn, "rawdet $id-a", "INSERT INTO tbl_raw_purchase_details (purchase_id,raw_material_id,sub_uom_id,hsn_code,qty,total_qty,uom_id,purchase_rate,gst,rate,rate_tax,created_by,create_date,delete_status) VALUES ('$id','1','1','123123','10','10','1','5000','5','50000','52500','admin','$now','NDL')", $log); ins($conn, "rawdet $id-b", "INSERT INTO tbl_raw_purchase_details (purchase_id,raw_material_id,sub_uom_id,hsn_code,qty,total_qty,uom_id,purchase_rate,gst,rate,rate_tax,created_by,create_date,delete_status) VALUES ('$id','2','1','12356','5','5','1','1000','5','5000','5250','admin','$now','NDL')", $log); }
        ins($conn, "payment {$p[0]}", "INSERT INTO tbl_payment (dc_no,billing_date,purchase_id,supplier_id,payment_mode,bank_id,pay_amount,created_by,create_date,delete_status) VALUES ('{$p[0]}','$today','$id','{$p[1]}','Cash','1','20000','admin','$now','NDL')", $log);
    }
} else $log[] = "SKIP: raw purchase already seeded";
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_pay_entry WHERE remarks='DEMO-SEED'")) {
    ins($conn, "pay_entry1", "INSERT INTO tbl_pay_entry (expense_header_id,pay_type,billing_date,amount,remarks,delete_status,deleted_by,created_by) VALUES ('1','Cash','$today','2500','DEMO-SEED','NDL','','admin')", $log);
    ins($conn, "pay_entry2", "INSERT INTO tbl_pay_entry (expense_header_id,pay_type,billing_date,amount,remarks,delete_status,deleted_by,created_by) VALUES ('2','UPI','$today','4000','DEMO-SEED','NDL','','admin')", $log);
} else $log[] = "SKIP: pay_entry already seeded";
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_gate_pass WHERE customer_name LIKE 'Demo %'")) {
    ins($conn, "gatepass1", "INSERT INTO tbl_gate_pass (customer_name,driver_name,vechicle_number,product_name,qty,delete_status,deleted_by,created_by) VALUES ('Demo Customer - Karur','Demo Driver','TN76 MK 5649','Fly Ash Brick','1000','NDL','','admin')", $log);
    ins($conn, "gatepass2", "INSERT INTO tbl_gate_pass (customer_name,driver_name,vechicle_number,product_name,qty,delete_status,deleted_by,created_by) VALUES ('Demo Customer - Velur','Demo Driver 2','TN76 MK 5649','Bricks','500','NDL','','admin')", $log);
} else $log[] = "SKIP: gate_pass already seeded";
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_eway_bill WHERE doc_no='DEMO-EWB-1'")) {
    $eid = ins($conn, "eway", "INSERT INTO tbl_eway_bill (order_type,gstin,legal_name,address,place,state,pincode,supply_type,sub_type,doc_type,doc_no,doc_date,from_party_name,from_gstin,from_place,from_pincode,from_state,to_party_name,to_gstin,to_place,to_pincode,to_state,trans_mode,distance,trans_name,vehicle_no,vehicle_type,created_by,create_date,delete_status) VALUES ('Outward','33DEMO10001X1Z5','Demo Traders','Karur','Karur','Tamil Nadu','639117','Outward','Supply','Invoice','DEMO-EWB-1','$today','Demo Traders','33DEMO10001X1Z5','Karur','639117','Tamil Nadu','Demo Customer - Karur','33DEMO10002X1Z5','Namakkal','637001','Tamil Nadu','Road','60','Demo Transport','TN76 MK 5649','Regular','admin','$now','NDL')", $log);
    if ($eid) { ins($conn, "ewaydet-a", "INSERT INTO tbl_eway_bill_details (eb_id,product_id,description,hsn_code,unit,qty,assessable_value,tax_rate,cgst,sgst,tot_invoice,created_by,create_date,delete_status) VALUES ('$eid','2','Fly Ash Brick','68','PCS','1000','6500','12','390','390','7280','admin','$now','NDL')", $log); ins($conn, "ewaydet-b", "INSERT INTO tbl_eway_bill_details (eb_id,product_id,description,hsn_code,unit,qty,assessable_value,tax_rate,cgst,sgst,tot_invoice,created_by,create_date,delete_status) VALUES ('$eid','1','Bricks','123','PCS','500','5000','5','125','125','5250','admin','$now','NDL')", $log); }
} else $log[] = "SKIP: eway already seeded";

// ---- 9. Production x2 + labour + shift ----
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_production_details WHERE production_no LIKE 'DEMO-PR%'")) {
    foreach ([['DEMO-PR-1', '4'], ['DEMO-PR-2', '4']] as $p) {
        $id = ins($conn, "production {$p[0]}", "INSERT INTO tbl_production_details (production_no,product_id,operator_id,qty,production_date,remarks,delete_status,deleted_by,created_by) VALUES ('{$p[0]}','2','{$p[1]}','5000','$today','Demo seed','NDL','','admin')", $log);
        if ($id) { ins($conn, "plab $id", "INSERT INTO tbl_production_labour_details (production_id,labour_id,delete_status,deleted_by,created_by) VALUES ('$id','1','NDL','','admin')", $log); ins($conn, "pshift $id", "INSERT INTO tbl_production_shift_details (production_id,start_time,end_time,delete_status,deleted_by,created_by) VALUES ('$id','09:00','18:00','NDL','','admin')", $log); }
    }
} else $log[] = "SKIP: production already seeded";

// ---- 10. Finance/HR ----
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_income_expense_details WHERE ref_no='DEMO-SEED'")) {
    ins($conn, "incexp-inc", "INSERT INTO tbl_income_expense_details (billing_date,income_expense_type,header_id,amount,payment_mode,ref_no,remarks,created_by,create_date,delete_status) VALUES ('$today','Income','1','12000','Cash','DEMO-SEED','Demo seed','admin','$now','NDL')", $log);
    ins($conn, "incexp-exp1", "INSERT INTO tbl_income_expense_details (billing_date,income_expense_type,header_id,amount,payment_mode,ref_no,remarks,created_by,create_date,delete_status) VALUES ('$today','Expense','2','3500','Cash','DEMO-SEED','Demo seed','admin','$now','NDL')", $log);
    ins($conn, "incexp-exp2", "INSERT INTO tbl_income_expense_details (billing_date,income_expense_type,header_id,amount,payment_mode,ref_no,remarks,created_by,create_date,delete_status) VALUES ('$today','Expense','1','1500','UPI','DEMO-SEED','Demo seed','admin','$now','NDL')", $log);
    ins($conn, "bankinc", "INSERT INTO tbl_bank_income_expense_details (billing_date,bank_id,income_expense_type,header_id,amount,created_by,create_date,delete_status) VALUES ('$today','1','Income','1','20000','admin','$now','NDL')", $log);
    ins($conn, "bankexp", "INSERT INTO tbl_bank_income_expense_details (billing_date,bank_id,income_expense_type,header_id,amount,created_by,create_date,delete_status) VALUES ('$today','1','Expense','2','8000','admin','$now','NDL')", $log);
} else $log[] = "SKIP: income_expense already seeded";
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_investor WHERE investor_name LIKE 'Demo %'")) {
    $iid = ins($conn, "investor", "INSERT INTO tbl_investor (investor_name,delete_status,deleted_by,created_by) VALUES ('Demo Investor','NDL','','admin')", $log);
    if ($iid) ins($conn, "investor_det", "INSERT INTO tbl_investor_details (investor_id,billing_date,amount,delete_status,deleted_by,created_by) VALUES ('$iid','$today','100000','NDL','','admin')", $log);
    ins($conn, "loan", "INSERT INTO tbl_loan_details (loan_name,amount,delete_status,deleted_by,created_by) VALUES ('Demo Loan','50000','NDL','','admin')", $log);
    ins($conn, "deposit", "INSERT INTO tbl_deposit_details (deposit_name,amount,delete_status,deleted_by,created_by) VALUES ('Demo Deposit','25000','NDL','','admin')", $log);
    ins($conn, "asset1", "INSERT INTO tbl_assets_details (assets_name,assets_count,amount,delete_status,deleted_by,created_by) VALUES ('Demo Machinery','2','150000','NDL','','admin')", $log);
    ins($conn, "asset2", "INSERT INTO tbl_assets_details (assets_name,assets_count,amount,delete_status,deleted_by,created_by) VALUES ('Demo Vehicle','1','800000','NDL','','admin')", $log);
} else $log[] = "SKIP: investor/loan/deposit/assets already seeded";
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_staff_salary WHERE name LIKE 'Demo %'")) {
    ins($conn, "staffsal1", "INSERT INTO tbl_staff_salary (name,delete_status,deleted_by,created_by) VALUES ('Demo Driver Salary','NDL','','admin')", $log);
    ins($conn, "staffsal2", "INSERT INTO tbl_staff_salary (name,delete_status,deleted_by,created_by) VALUES ('Demo Manager Salary','NDL','','admin')", $log);
} else $log[] = "SKIP: staff_salary already seeded";
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_employee_advance WHERE ref_no='DEMO-SEED'")) {
    ins($conn, "empadv1", "INSERT INTO tbl_employee_advance (emp_id,adv_date,amount,payment_mode,ref_no,remarks,adjusted_amount,created_by,create_date,delete_status) VALUES ('1','$today','5000','Cash','DEMO-SEED','Demo seed','0','admin','$now','NDL')", $log);
    ins($conn, "empadv2", "INSERT INTO tbl_employee_advance (emp_id,adv_date,amount,payment_mode,ref_no,remarks,adjusted_amount,created_by,create_date,delete_status) VALUES ('2','$today','3000','UPI','DEMO-SEED','Demo seed','0','admin','$now','NDL')", $log);
} else $log[] = "SKIP: employee_advance already seeded";

// ---- 11. Attendance + salaries ----
foreach (['tbl_attendance' => 'Present', 'tbl_attendance_bricks' => 'Present', 'tbl_attendance_bundle' => 'Present', 'tbl_attendance_hours' => '8'] as $t => $st) {
    if (!seeded($conn, "SELECT COUNT(*) FROM `$t` WHERE description='Demo seed'")) {
        ins($conn, "$t-1", "INSERT INTO `$t` (attendance_date,emp_id,attendance_status,description,delete_status,deleted_by,created_by) VALUES ('$today','1','$st','Demo seed','NDL','','admin')", $log);
        ins($conn, "$t-2", "INSERT INTO `$t` (attendance_date,emp_id,attendance_status,description,delete_status,deleted_by,created_by) VALUES ('$today','2','$st','Demo seed','NDL','','admin')", $log);
    } else $log[] = "SKIP: $t already seeded";
}
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_emp_salary WHERE remarks='Demo seed'")) {
    ins($conn, "empsal1", "INSERT INTO tbl_emp_salary (start_date,emp_id,end_date,salary_month,payment_mode,remarks,pay_amount,delete_status,deleted_by,created_by) VALUES ('$d1','1','$today','Sep 2026','Cash','Demo seed','12000','NDL','','admin')", $log);
    ins($conn, "empsal2", "INSERT INTO tbl_emp_salary (start_date,emp_id,end_date,salary_month,payment_mode,remarks,pay_amount,delete_status,deleted_by,created_by) VALUES ('$d1','2','$today','Sep 2026','UPI','Demo seed','10000','NDL','','admin')", $log);
} else $log[] = "SKIP: emp_salary already seeded";
foreach (['tbl_emp_bricks_salary', 'tbl_emp_bundle_salary', 'tbl_emp_hour_salary'] as $t) {
    if (!seeded($conn, "SELECT COUNT(*) FROM `$t` WHERE emp_id IN (1,2) AND start_date='$d1'")) {
        ins($conn, "$t-1", "INSERT INTO `$t` (start_date,emp_id,end_date,pay_amount,delete_status,deleted_by,created_by) VALUES ('$d1','1','$today','8000','NDL','','admin')", $log);
        ins($conn, "$t-2", "INSERT INTO `$t` (start_date,emp_id,end_date,pay_amount,delete_status,deleted_by,created_by) VALUES ('$d1','2','$today','7000','NDL','','admin')", $log);
    } else $log[] = "SKIP: $t already seeded";
}
if (!seeded($conn, "SELECT COUNT(*) FROM tbl_login_details WHERE descp='Demo seed'")) {
    ins($conn, "login", "INSERT INTO tbl_login_details (admin_id,location_details,descp,login_date,created_by,create_date,delete_status) VALUES ('1','Demo Office','Demo seed','$now','admin','$now','NDL')", $log);
} else $log[] = "SKIP: login_details already seeded";

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");
try {
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_customer")); $log[] = "POST customer_rows=" . $r['t'];
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_gst_invoice")); $log[] = "POST gst_rows=" . $r['t'];
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) t FROM tbl_non_dc")); $log[] = "POST nongst_rows=" . $r['t'];
} catch (Throwable $e) { $log[] = "POST note: " . $e->getMessage(); }
$log[] = "Migration 004 finished " . date('Y-m-d H:i:s');
$out = implode("\n", $log) . "\n";
@file_put_contents(__DIR__ . '/004_applied.log', $out, FILE_APPEND);
echo $out;
