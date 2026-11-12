<?php
// 009_master_cleanup: run manually after backup.
// 1) New username suffix @jmt (migrate old @krrchamberss logins):
//    UPDATE tbl_employee_details SET uname=REPLACE(uname,'@krrchamberss','@jmt') WHERE uname LIKE '%@krrchamberss';
// 2) Remove Production Price column (frontend already removed):
//    ALTER TABLE tbl_products DROP COLUMN production_price;
// 3) Remove deduction type column (frontend already removed):
//    ALTER TABLE tbl_employee_details DROP COLUMN deducation_type;
// Raw Material: hidden from menu/BOM (no DB drop; drop only if confirmed):
//    -- ALTER TABLE tbl_raw_material ... (skipped, reversible hide)
