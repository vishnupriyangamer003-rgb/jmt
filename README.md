# jmt — Jayam Hydraulic Engineering (Spares) Billing

PHP 8.3 / MySQL 8.0 billing application (XAMPP). Database connection is configured in `phpservices/connection.php`.

## Migrations

One-off, idempotent CLI scripts live in `migrations/` and are run with XAMPP's PHP:

```
C:\xampp\php\php.exe migrations\<script>.php
```

## Product import from `doc/software data.xlsx` (migration 012)

Script: `migrations/012_import_software_data.php`

### What it does
Reads the client's item master (`doc/software data.xlsx`, sheet "Item Master List") and loads **only the product name and sales price** into `tbl_products`.

| Excel column | Header     | Goes to                  |
|--------------|------------|--------------------------|
| B            | Item Name  | `tbl_products.product_name` |
| J            | Sales Rate | `tbl_products.sale_price`   |

All other sheet columns (Item Code, Unit, GST, Purchase Rate, Group, HSN, MRP, etc.) are ignored.

### Sheet layout
- Rows 1–2: company title and "Item Master List".
- Row 3: column headers.
- Row 4 onward: one item per row (881 items).

### Rules
- Sales Rate comes as text with thousands separators (e.g. `1,320.80`); commas are stripped and the value stored with 2 decimals.
- Blank sales rate is imported as `0.00` (25 items). Fix these prices manually after import.
- Item names are SQL-escaped (names contain quotes and slashes).
- Rows with an empty Item Name are skipped.
- **Idempotent:** an item is skipped if an active product (`delete_status='NDL'`) with the same `product_name` already exists, so re-running inserts nothing.
- Fixed values on each inserted row: `status='Active'`, `delete_status='NDL'`, `created_by='admin'`, `hsn_code=''` (required NOT NULL column), `create_date=now`.
- Existing products are never modified or deleted.

### Parsing
Uses the bundled PhpSpreadsheet (`phpspreadsheet/vendor/...`) with `setReadDataOnly(true)`.

### Run
```
cd d:\xampp\htdocs\vichu\jmt\billing
C:\xampp\php\php.exe migrations\012_import_software_data.php
```
Output: `inserted=<n> skipped=<n> failed=<n>`. XAMPP MySQL must be running.

### Verification
Result on the first run: `inserted=881 skipped=0 failed=0`; second run: `inserted=0 skipped=881 failed=0`.

Checks on the imported rows: 0 empty names, 0 empty prices, 0 duplicate names, 856 with price > 0, 25 with price 0.00. Spot checks:
- `0023 BUSH COLLAR TNSLM` → 644.00
- `07774 STEERING SEAL 2021 (HP)` → 1320.80

### Finding items that still need a price
```sql
SELECT product_id, product_name FROM tbl_products
WHERE delete_status='NDL' AND CAST(sale_price AS DECIMAL(12,2)) = 0;
```

### Rolling back
Imported rows are the only ones with `created_by='admin'`, `hsn_code=''` and `product_code IS NULL`; soft-delete them the same way the app does:
```sql
UPDATE tbl_products SET delete_status='0', deleted_by='admin', deleted_date=NOW()
WHERE created_by='admin' AND hsn_code='' AND product_code IS NULL AND delete_status='NDL';
```
Review the row count before running, since later manually added products could match too.
