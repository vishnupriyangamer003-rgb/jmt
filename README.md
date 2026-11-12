# JMT — Jayam Hydraulic Engineering (Spares) Billing

A web-based billing and business-management application for **Jayam Hydraulic Engineering**, a seller of hydraulic / JCB spare parts. It covers sales and GST invoicing, purchases, receipts and payments, ledgers, stock, staff and attendance, banking, loans/investors, and a wide set of reports.

- **Stack:** plain PHP (procedural, page-per-feature) + MySQL / MariaDB, served by Apache (XAMPP). Front end is a bundled admin theme (jQuery, Bootstrap-style grids).
- **Database:** `jmt_jeyam_billing` (58 tables, all prefixed `tbl_`).
- **Timezone:** `Asia/Kolkata`. **Charset:** `utf8mb4`.

---

## 1. Getting started (local)

1. Install XAMPP and start **Apache** and **MySQL**.
2. Place the project at `C:\xampp\htdocs\...` (this repo lives at `d:\xampp\htdocs\vichu\jmt\billing`).
3. Create the database `jmt_jeyam_billing` and import the schema/data dump (the dump is not stored in this repo).
4. Local DB credentials are chosen automatically in [phpservices/connection.php](phpservices/connection.php) when the host is `localhost` / `127.0.0.1`: user `root`, empty password, database `jmt_jeyam_billing`.
5. Open the app in a browser; `index.php` is the login page.
6. Run any pending migrations (see section 6).

> **Security note:** `phpservices/connection.php` contains the production DB host/user/password committed in plain text. Move production credentials to an environment variable or an untracked config file and rotate the password.

## 2. Project layout

| Path | Purpose |
|------|---------|
| `index.php` | Login page |
| `dashboard.php` | Home dashboard after login |
| `sessionservices.php` / `sessionservices1.php` | Session guard — included by every page; redirects to `index.php` if not logged in; resolves the logged-in user; date helper `jayam_parse_date()` |
| `*_details.php`, `*_add_details.php`, `*_edit_details.php` | Entry / edit forms for a module |
| `*_grid.php`, `*_report.php`, `*_report_grid.php` | List grids and reports (loaded via AJAX into pages) |
| `*_service.php` | Server-side save / update / delete handlers for a module |
| `*_preview.php`, `*_pdf_preview.php` | Printable / PDF views of bills, receipts, ledgers |
| `*_dropdown.php`, `*_search_bind.php`, `get_*.php` | AJAX helpers for selects, autocomplete and lookups (e.g. `get_product_rate.php`, `get_hsncode.php`) |
| `phpservices/` | Shared PHP: `connection.php`, `jayam_helpers.php`, autocomplete endpoints, import handlers (~110 files) |
| `migrations/` | One-off, idempotent CLI/browser database migration scripts |
| `phpspreadsheet/`, `PHPExcel-1.8/` | Excel read/write libraries (PhpSpreadsheet is used for imports) |
| `css/`, `js/`, `vendors/`, `images/` | Theme assets — **read-only, do not edit** (see `GEMINI.md`) |
| `userdata/` | Runtime uploads (images, imported Excel copies) |
| `doc/` | Reference documents, including `software data.xlsx` (item master) |
| `GEMINI.md` | Workspace rules for AI assistants |

## 3. Modules

**Sales**
- Sales / delivery challans (`sales_*`, `tbl_dc`, `tbl_dc_details`) and orders (`order_*`, `tbl_order`)
- GST invoices (`gst_invoice_*`, `tbl_gst_invoice`) and a second GST invoice series (`sky_gst_invoice_*`)
- Non-GST bills (`non_sales_*`, `tbl_non_dc`) and service bills (`services_non_sales_*`, `tbl_services_non_dc`) — non-GST and service are split by `is_service_bill`
- E-way bills (`eway_bill_*`) and gate passes (`gate_pass_*`)

**Purchases**
- Purchase entry, purchase order / stock reports, supplier-wise and outstanding reports (`purchase_*`)
- Raw-material purchases (`raw_material_*`, hidden from the menu)
- Supplier master (`supplier_details.php`, `tbl_supplier`)

**Money in / out**
- Customer receipts (`receipt_*`, `non_receipt_*`, `sky_receipt_*`, `services_non_receipt_*`) and supplier payments (`payment_*`, `non_pay_entry_*`)
- Customer ledgers: paid / pending / outstanding / customer-wise (regular, non-GST, service and Sky series)
- Bank accounts and bank income/expense (`bank_*`), general income/expense with income headers (`income_expense_*`, `income_header_*`), deposits, loans, investors and investor entries
- Day book, balance report, profit report, profit & loss

**Stock & masters**
- Products (`products_details.php`, `tbl_products`), UOM / sub-UOM, categories / sub-categories, customers, vehicles, assets
- Stock reports (`stock_report.php`, `product_stock_report.php`), opening stock

**Production** (carried over from the original base application)
- Production entry with labour and shift details (`production_*`, `tbl_production_*`)

**Staff**
- Employees, staff types, attendance (day / hour / bundle / bricks variants), salary, employee advances, role-based **employee rights** (`employee_rights.php`, `tbl_employee_rights`)

**Admin**
- `user_details.php`, `settings.php`, `logout.php`, `report_history.php`

## 4. Authentication and access

- Login is handled by `index.php`; credentials are checked against `tbl_admin` (the `admin` user) and `tbl_employee_details` (employees, usernames end with the `@jmt` suffix since migration 009).
- The session keys `login_user` and `login_id` identify the user; every page includes `sessionservices.php` and is bounced to `index.php` when the session is empty.
- Employee menu / page access is controlled through `tbl_employee_rights`.

## 5. Conventions

- **Soft delete:** rows are never physically removed. `delete_status = 'NDL'` means active; any other value means deleted (`deleted_by` / `deleted_date` record who and when). Always filter `delete_status='NDL'` in queries.
- **Audit columns:** `created_by`, `create_date`, `updated_by`, `update_date`.
- **Dates:** the UI uses `d/m/Y`; the database stores `Y-m-d`. Use `jayam_parse_date()` to convert.
- **Page pattern:** form page → AJAX POST to `*_service.php` → JSON result; lists come from `*_grid.php`.
- **Theme assets** in `css/`, `js/`, `vendors/`, `images/` are read-only; write custom CSS/JS inside the PHP pages.

## 6. Migrations

Scripts in `migrations/` are additive and idempotent; each can be re-run safely and logs `OK` / `SKIP` / `FAIL`. Run them with XAMPP's PHP from the project root:

```
C:\xampp\php\php.exe migrations\<script>.php
```

| # | Script | Purpose |
|---|--------|---------|
| 001 | `001_jayam_foundation.php` | Jayam base columns/tables (password hash, customer and product extensions) |
| 002 | `002_purge_site_engineer.php` | Remove the Site / Engineer concepts |
| 003 | `003_wipe_data.php` | Fresh start: truncate transactional tables, keep masters (needs a backup first) |
| 004 | `004_seed_dummy.php` | Demo seed data |
| 005 | `005_truck_spares.php` | Truck spares catalogue (later replaced by 006) |
| 006 | `006_jcb_spares.php` | JCB spares catalogue |
| 007 | `007_stock_opening.php` | `opening_stock` column on products |
| 008 | `008_service_split.php` | Non-GST vs service bill split (`is_service_bill`) |
| 009 | `009_master_cleanup.php` | Manual cleanup notes (`@jmt` usernames, drop production price) |
| 010 | `010_services_live_sync.php` | Ensure service tables / columns exist on live |
| 011 | `011_keys_live_sync.php` | Ensure primary keys and newer columns on live |
| 012 | `012_import_software_data.php` | Import product name + sales price from `doc/software data.xlsx` (on branch `feature/import-software-data-products`) |

Always take a database backup before running migrations on live.

## 7. Product import from `doc/software data.xlsx` (migration 012)

Loads **only the product name and sales price** from the client's item master into `tbl_products`.

| Excel column | Header | Goes to |
|--------------|--------|---------|
| B | Item Name | `tbl_products.product_name` |
| H | Purchase Rate | `tbl_products.purchase_rate` |
| J | Sales Rate | `tbl_products.sale_price` |

- Sheet "Item Master List": rows 1–2 are titles, row 3 is the header, items start at row 4 (881 items). Other columns (code, unit, GST, purchase rate, group, HSN, MRP …) are ignored.
- Purchase rate (H) and sales rate (J) text such as `1,320.80` has commas stripped and is stored with 2 decimals; a blank sales rate imports as `0.00` (25 items). Purchase rate fills only rows where it is still empty/0 (never overwrites manual edits); 2 items have no purchase rate.
- Names are SQL-escaped; rows with an empty name are skipped.
- **Idempotent:** an item is skipped if an active product with the same `product_name` exists. Existing products are never changed.
- Inserted rows get `status='Active'`, `delete_status='NDL'`, `created_by='admin'`, `hsn_code=''`.

Run:
```
cd d:\xampp\htdocs\vichu\jmt\billing
C:\xampp\php\php.exe migrations\012_import_software_data.php
```
Output: `inserted=<n> updated=<n> skipped=<n> failed=<n>`. First run gave `inserted=881 skipped=0 failed=0`; a second run gave `inserted=0 skipped=881 failed=0`.

Items still needing a price:
```sql
SELECT product_id, product_name FROM tbl_products
WHERE delete_status='NDL' AND CAST(sale_price AS DECIMAL(12,2)) = 0;
```

Rollback (soft delete — check the row count first, since later hand-added products could match):
```sql
UPDATE tbl_products SET delete_status='0', deleted_by='admin', deleted_date=NOW()
WHERE created_by='admin' AND hsn_code='' AND product_code IS NULL AND delete_status='NDL';
```

## 8. Branches

- `main` — released code and this README.
- `feature/import-software-data-products` — adds migration 012; merge it to bring the importer into `main`.
