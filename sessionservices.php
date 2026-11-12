<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
date_default_timezone_set('Asia/Kolkata');
include('phpservices/connection.php');
if (file_exists(__DIR__ . '/phpservices/jayam_helpers.php')) {
    require_once __DIR__ . '/phpservices/jayam_helpers.php';
}
if (!function_exists('jayam_parse_date')) {
    function jayam_parse_date($date_str, $fmt = 'd/m/Y') {
        if ($date_str === null || trim((string)$date_str) === '') return null;
        $date_str = trim((string)$date_str);
        $d = DateTime::createFromFormat($fmt, $date_str);
        if ($d && $d->format($fmt) === $date_str) {
            return $d->format('Y-m-d');
        }
        $d2 = DateTime::createFromFormat('Y-m-d', $date_str);
        if ($d2 && $d2->format('Y-m-d') === $date_str) {
            return $d2->format('Y-m-d');
        }
        $ts = strtotime(str_replace('/', '-', $date_str));
        return $ts !== false ? date('Y-m-d', $ts) : null;
    }
}

$log = $_SESSION['login_user'] ?? null;
$login_id = $_SESSION['login_id'] ?? null;

if (empty($log)) {
    echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
    exit;
}

$logged_by = 'ADMIN';
if (($log ?? '') !== 'admin') {
    $stmt = mysqli_prepare($conn, "SELECT emp_name FROM tbl_employee_details WHERE emp_id=? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $login_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && ($r = mysqli_fetch_assoc($res)) && !empty($r['emp_name'])) {
            $logged_by = $r['emp_name'];
        }
        mysqli_stmt_close($stmt);
    }
}

if ($log == "admin") {
    $header = '<div class="side-menu">
	<div class="side-menu-body" style="background:#0f172a">
        <div style="text-align:center;padding:16px 120px 10px 12px;border-bottom:1px solid rgba(255,255,255,0.08);margin-bottom:8px;"><img src="userdata/images/jayam_logo.png" alt="Jayam Hydraulics Engineering" style="max-width:75px;width:85%;height:auto;filter:drop-shadow(0 2px 8px rgba(0,0,0,0.5));"></div>
        <ul>
            <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="font-size:30px; float:right;">×</a></li>
            <li class="side-menu-divider">Navigation</li>
            <li>
                <a href="dashboard.php"><i class="icon fa fa-home"></i> <span>Dashboard</span> </a>
            </li>
            
            <li><a href="#"><i class="icon fa fa-database"></i> <span>Master</span> </a>
                <ul>
                    <li><a href="customer_details.php">Customer</a></li>
                    <li><a href="products_details.php">Product</a></li>
                    <!-- <li><a href="uom_details.php">UOM</a></li> -->
                    <li><a href="bank_details.php">Bank Details</a></li>
                    <li><a href="income_header_details.php">Expense Category</a></li>
                </ul>
            </li>

            <li><a href="#"><i class="icon fa fa-user-circle-o"></i> <span>Staff</span> </a>
                <ul>
                    <li><a href="staff_details.php">Staff Details</a></li>
                    <li><a href="employee_rights.php">Staff Rights</a></li>
                </ul>
            </li>

            <li><a href="#"><i class="icon fa fa-check"></i> <span>Spares - GST Bill</span> </a>
                <ul>
                    <li><a href="gst_invoice_details.php"><span>GST Bills</span> </a></li>
                    <li><a href="gst_invoice_report.php"><span>Report</span> </a></li>
                    <li><a href="receipt_details.php"><span>Receipt Details</span> </a></li>
                    <li><a href="receipt_report.php"><span>Receipt Report</span> </a></li>
                    <li><a href="customer_ledger_outstanding_report.php"><span>Ledger Report</span> </a></li>
                    <li><a href="customer_ledger_pending_report.php"><span>Pending Report</span> </a></li>
                </ul>
            </li>

            <li><a href="#"><i class="icon fa fa-file-text-o"></i> <span>Spares - Non-GST Bill</span> </a>
                <ul>
                    <li><a href="non_sales_details.php"><span>Non-GST Bills</span> </a></li>
                    <li><a href="non_sales_entry_report.php"><span>Bill Report</span> </a></li>
                    <li><a href="non_receipt_details.php"><span>Receipt Details</span> </a></li>
                    <li><a href="non_receipt_report.php"><span>Receipt Report</span> </a></li>
                    <li><a href="non_customer_ledger_outstanding_report.php"><span>Ledger Report</span> </a></li>
                    <li><a href="non_customer_ledger_pending_report.php"><span>Pending Report</span> </a></li>
                </ul>
            </li>

            <li><a href="#"><i class="icon fa fa-wrench"></i> <span>Services - Non-GST</span> </a>
                <ul>
                    <li><a href="services_non_sales_details.php"><span>Service Bills</span> </a></li>
                    <li><a href="services_non_sales_entry_report.php"><span>Bill Report</span> </a></li>
                    <li><a href="services_non_receipt_details.php"><span>Receipt Details</span> </a></li>
                    <li><a href="services_non_receipt_report.php"><span>Receipt Report</span> </a></li>
                    <li><a href="services_customer_ledger_outstanding_report.php"><span>Ledger Report</span> </a></li>
                    <li><a href="services_customer_ledger_pending_report.php"><span>Pending Report</span> </a></li>
                </ul>
            </li>
            

            <li><a href="#"><i class="icon fa fa-registered"></i> <span>Reports</span> </a>
                <ul>
                    <li><a href="customer_wise_outstanding_report.php"><span>Customer Outstanding</span> </a></li>
                    <li class="d-none"><a href="stock_report.php"><span>Product Stock Report</span> </a></li>
                    <li class="d-none"><a href="sales_item_wise_report.php"><span>Product-wise Sales</span> </a></li>
                    <li><a href="profit_loss_report.php"><span>Profit & Loss</span> </a></li>
                </ul>
            </li>
            <!-- Bricks/Bundle attendance modules removed (2026-09-26, spares-only). Remaining legacy hidden from menu:
                 SKY GST, SU quotation/pay-entry, E-Way Bill, Production,
                 Raw Material Purchase, Gate Pass, DC, Vehicle, Order, Entry Details. -->
            <li><a href="#"><i class="icon fa fa-calendar-check-o"></i> <span>Attendance & Salary</span> </a>
                <ul>
                    <li><a href="attendance_details.php"><span>Employee Attendance</span> </a></li>
                    <li><a href="attendance_report.php">Attendance Report</a></li>
                    <li><a href="add_attendance_salary.php"><span>Salary Payment</span> </a></li>
                    <li><a href="employee_advance_details.php"><span>Employee Advance</span> </a></li>
                </ul>
            </li>            
           
           
            <!-- Legacy: Order/Investor/Assets/Loan/Deposit entry pages retained as files+data, hidden from menu. -->
            <li><a href="#"><i class="icon ti-paint-bucket"></i> <span>Expense</span> </a>
                <ul>
                    <li><a href="income_expense_details.php"><span>Expense Entry</span> </a></li>
                    <li><a href="income_expense_report.php"><span>Expense Report</span> </a></li>
                </ul>
            </li>  
            <!-- Legacy: Bank Income/Expense pages retained as files+data, hidden from menu. -->
            

            
            
            
           <li><a href="settings.php"><i class="icon fa fa-cogs"></i> <span>Settings</span> </a></li>

           <li class="side-menu-divider"><p style="margin-bottom: 0;padding: 5px 0;color: red;font-weight: bold;font-size: 14px;float:left"> <a href="https://www.knocktheglobe.com/" target="_blank" style="color:red;font-size: 12px;color: white;">Designed By KTG</a></p></li>

           


           

          
        </ul>
    </div>
</div>

<nav class="navbar" style="background:#ffffff;text-align: center;">
    <div class="container-fluid">
    
        <div class="header-logo" style="width: 10%;">
            
            <ul style="display:flex">
                <li style="margin-left: 15px;"> <button class="nav-link openbtn" onclick="openNav()" style="padding: 2px 10px; margin-top: 18px;">&#9776;</button></li>

                
            </ul>

        </div>

        <div class="header-body">
            <ul class="navbar-nav">

				<span id="titlename" style="display:inline-flex;align-items:center;gap:12px;">
					<img src="userdata/images/jayam_logo.png" alt="Logo" style="height:36px;width:auto;vertical-align:middle;">
					<span class="ksymbol" style="font-weight:800;color:#08444d;font-size:20px;vertical-align:middle;">Jayam Hydraulic Engineering</span>
				</span>
            

                <li class="nav-item dropdown userdiv">
                    <a href="#" data-toggle="dropdown">
                        <figure class="avatar avatar-sm">
                            <img class="rounded-circle1" src="images/log_out.png" alt="...">
                        </figure>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!--<a href="#" data-sidebar-target="#settings" class="sidebar-open dropdown-item">Settings</a>
                        <div class="dropdown-divider"></div>-->
                        <a href="logout.php" class="text-danger dropdown-item">Logout</a>
                    </div>
                </li>
                <li class="nav-item d-lg-none d-sm-block" >
                    <a href="#" class="nav-link side-menu-open">
                        <i class="ti-menu"></i>
                    </a>
                </li>
            </ul>
        </div>

    </div>
    
</nav>


';
} else {

    $header = '<div class="side-menu">
	<div class="side-menu-body">
        <div style="text-align:center;padding:16px 12px 10px 12px;border-bottom:1px solid rgba(255,255,255,0.08);margin-bottom:8px;"><img src="userdata/images/jayam_logo.png" alt="Jayam Hydraulics Engineering" style="max-width:170px;width:85%;height:auto;filter:drop-shadow(0 2px 8px rgba(0,0,0,0.5));"></div>
        <ul>
            <li class="side-menu-divider">Navigation</li>
            <li>
                <a href="dashboard.php"><i class="icon fa fa-home"></i> <span>Dashboard</span> </a>
            </li>';

    $pql = "select * from tbl_employee_rights where emp_id='" . $login_id . "' and delete_status='NDL'";
    $exec_pql = mysqli_query($conn, $pql);
    $i = 0;
    while ($fetch_pql = mysqli_fetch_array($exec_pql)) {
        if ($fetch_pql['module_id'] == '1' && $fetch_pql['module_status'] == 'Y') {
            $header .= '<li><a href="#"><i class="icon fa fa-database"></i> <span>Master</span> </a>
            <ul> 
                
                <!-- <li><a href="uom_details.php">UOM</a></li> --> 
                <!-- <li><a href="sub_uom_details.php">SUB UOM</a></li> -->   
                <li><a href="vechicle_details.php">Vechicle</a></li>          
                <!-- Raw Material hidden as per requirement -->
                <li><a href="products_details.php">Product</a></li> 
                <li><a href="bank_details.php">Bank Details</a></li>
                <li><a href="income_header_details.php">Income and Expense Header</a></li> 
                <li><a href="investor_details.php">Investor</a></li> 
                <li><a href="customer_details.php">Customer</a></li>
                <li><a href="supplier_details.php">Supplier</a></li>
            </ul>
        </li>';
        }
        if ($fetch_pql['module_id'] == '2' && $fetch_pql['module_status'] == 'Y') {
            $header .= '<li><a href="#"><i class="icon fa fa-user-circle-o"></i> <span>Staff</span> </a>
            <ul>
                <li><a href="staff_details.php">Staff Details</a></li>
                <li><a href="employee_rights.php">Staff Rights</a></li>
            </ul>
        </li>';
        }

        /* Raw Material Purchase hidden as per requirement
        if ($fetch_pql['module_id'] == '3' && $fetch_pql['module_status'] == 'Y') {
            $header .= '<li><a href="#"><i class="icon fa fa-bookmark-o"></i> <span>Raw Material Purchase</span> </a>
                <ul>
                    <li><a href="raw_material_purchase_details.php">Raw Material Purchase Details</a></li>
                    <li><a href="payment_details.php">Payment</a></li>
                    <li><a href="raw_material_stock_report.php"><span>Stock Report</span> </a></li>
                </ul>
            </li>';
        }
        */


        if ($fetch_pql['module_id'] == '4' && $fetch_pql['module_status'] == 'Y') {
            $header .= '<li><a href="#"><i class="icon fa fa-industry"></i> <span>Production</span> </a>
                <ul>
                    <li><a href="production_details.php"><span>Production Details</span> </a></li>
                    <li><a href="production_entry_report.php"><span>Entry Report</span> </a></li>
                </ul>
            </li>';
        }

        if ($fetch_pql['module_id'] == '6' && $fetch_pql['module_status'] == 'Y') {
            $header .= '<li><a href="#"><i class="icon fa fa-cube"></i> <span>Gate Pass </span> </a>
                <ul>
                    <li><a href="gate_pass_details.php"><span>Gate Pass Details</span> </a></li>
                    <li><a href="gate_pass_report.php"><span>Report</span> </a></li>
                </ul>
            </li>';
        }

        if ($fetch_pql['module_id'] == '5' && $fetch_pql['module_status'] == 'Y') {
            $header .= '<li><a href="#"><i class="icon fa fa-check"></i> <span>DC</span> </a>
            <ul>
                <li><a href="sales_details.php"><span>DC Details</span> </a></li>
                <li><a href="sales_entry_report.php"><span>Report</span> </a></li>
            </ul>
        </li>';
        }

        if ($fetch_pql['module_id'] == '7' && $fetch_pql['module_status'] == 'Y') {
            $header .= '
            <li><a href="#"><i class="icon fa fa-check"></i> <span>GST Invoice</span> </a>
                <ul>
                    <li><a href="gst_invoice_details.php"><span>GST Invoice Details</span> </a></li>
                    <li><a href="gst_invoice_report.php"><span>Report</span> </a></li>
                </ul>
            </li>';
        }

        if ($fetch_pql['module_id'] == '9' && $fetch_pql['module_status'] == 'Y') {
            $header .= '
            <li><a href="#"><i class="icon fa fa-check"></i> <span>E-Way Bill</span> </a>
                <ul>
                    <li><a href="eway_bill_details.php"><span>E-Way Bill Details</span> </a></li>
                    <li><a href="eway_bill_report.php"><span>Report</span> </a></li>
                </ul>
            </li>';
        }

        if ($fetch_pql['module_id'] == '8' && $fetch_pql['module_status'] == 'Y') {
            $header .= '
            <li><a href="#"><i class="icon fa fa-list"></i> <span>Receipt</span> </a>
                <ul>
                    <li><a href="receipt_details.php"><span>Receipt Details</span> </a></li>
                    <li><a href="receipt_report.php"><span> Report</span> </a></li>
                </ul>
            </li>';
        }


        if ($fetch_pql['module_id'] == '10' && $fetch_pql['module_status'] == 'Y') {
            $header .= '<li><a href="#"><i class="icon fa fa-calendar-check-o"></i> <span>Attendance</span> </a>
            <ul>
                <li><a href="attendance_details.php"><span>Employee Attendance</span> </a></li>
                <li><a href="attendance_report.php"> Report</a></li>
                
            </ul>
        </li>';
        }

        if ($fetch_pql['module_id'] == '11' && $fetch_pql['module_status'] == 'Y') {
            $header .= '
            <li><a href="#"><i class="icon ti-paint-bucket"></i> <span>Expense</span> </a>
                <ul>
                    <li><a href="income_expense_details.php"><span>Expense Details</span> </a></li>
                    <li><a href="income_expense_report.php"><span>Expense Report</span> </a></li>
                </ul>
            </li>';
        }

        if ($fetch_pql['module_id'] == '12' && $fetch_pql['module_status'] == 'Y') {
            $header .= '  
            <li><a href="#"><i class="icon ti-wallet"></i> <span>Bank Income Expense</span> </a>
                <ul>
                    <li><a href="bank_income_expense_details.php"><span>Bank Income Expense Details</span> </a></li>
                    
                    <li><a href="bank_income_expense_report.php"><span>Bank Income & Expense Report</span> </a></li>
                </ul>
            </li>';
        }

        if ($fetch_pql['module_id'] == '13' && $fetch_pql['module_status'] == 'Y') {
            $header .= '  
           
           
            <li><a href="#"><i class="icon fa fa-registered"></i> <span>Entery Details</span> </a>
                <ul>
                    <li><a href="order_details.php"><span>Order Entry</span> </a></li>
                    <li><a href="investor_entry_details.php"><span>Investor Entry</span> </a></li>
                    <li><a href="assets_details.php"><span>Assets Entry</span> </a></li>
                    <li><a href="loan_details.php"><span>Loan Entry</span> </a></li>
                    <li><a href="deposit_details.php"><span>Deposit Entry</span> </a></li>                    
                </ul>
            </li>';
        }

        if ($fetch_pql['module_id'] == '14' && $fetch_pql['module_status'] == 'Y') {
            $header .= '
    
            <li><a href="#"><i class="icon fa fa-registered"></i> <span>Report</span> </a>
                <ul>
                    
                    <li><a href="supplier_wise_outstanding_report.php"><span>Supplier wise Outstanding Report</span> </a></li>
                    <li><a href="customer_wise_outstanding_report.php"><span>Customer Wise Outstanding Report</span> </a></li> 
                    <li><a href="stock_report.php"><span>Product Stock Report</span> </a></li>
                    <li><a href="order_report.php"><span>Order Report</span> </a></li>
                    <li><a href="eway_bill_report.php"><span>Eway Bill Report</span> </a></li>

                    
                    <!--li><a href="profit_loss_report.php"><span>Profit & Loss Report</span> </a></li>
                    <li><a href="balance_sheet_report.php"><span>Balance Sheet Report</span> </a></li>
                    
                    <li><a href="pay_in_out_entry_report.php"><span>Pay Out/In Entry Report</span> </a></li--> 
                    <!--li><a href="delivery_chellan_report.php"><span>Delivery Chellan Report</span> </a></li-->
                    <!--li><a href="invoice_report.php"><span>Invoice Report</span> </a></li-->
                    <!--li><a href="item_wise_report.php"><span>Item Wise Report</span> </a></li-->
                </ul>
            </li>';
        }

        

        $i++;
    }
    $header .= '<li><a href="settings.php"><i class="icon fa fa-cogs"></i> <span>Settings</span> </a></li>

           <li class="side-menu-divider"><p style="margin-bottom: 0;padding: 5px 0;color: red;font-weight: bold;font-size: 14px;float:left"> <a href="https://www.knocktheglobe.com/" target="_blank" style="color:red;font-size: 12px;color: white;">Designed By KTG</a></p></li>


        </ul>
    </div>
</div>

<nav class="navbar" style="background:#ffffff;text-align: center;">
    <div class="container-fluid">
    
        <div class="header-logo">
            
            <ul style="display:flex">
                <li style="margin-left: 15px;"> <button class="nav-link openbtn" onclick="openNav()" style="padding: 2px 10px; margin-top: 18px;">&#9776;</button></li>

                
            </ul>

        </div>

        <div class="header-body">
            <ul class="navbar-nav">

				<span id="titlename" style="display:inline-flex;align-items:center;gap:12px;">
					<img src="userdata/images/jayam_logo.png" alt="Logo" style="height:36px;width:auto;vertical-align:middle;">
					<span class="ksymbol" style="font-weight:800;color:#08444d;font-size:20px;vertical-align:middle;">Jayam Hydraulic Engineering</span>
				</span>
            

                <li class="nav-item dropdown userdiv">
                    <a href="#" data-toggle="dropdown">
                        <figure class="avatar avatar-sm">
                            <img class="rounded-circle1" src="images/log_out.png" alt="...">
                        </figure>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!--<a href="#" data-sidebar-target="#settings" class="sidebar-open dropdown-item">Settings</a>
                        <div class="dropdown-divider"></div>-->
                        <a href="logout.php" class="text-danger dropdown-item">Logout</a>
                    </div>
                </li>
                <li class="nav-item d-lg-none d-sm-block" >
                    <a href="#" class="nav-link side-menu-open">
                        <i class="ti-menu"></i>
                    </a>
                </li>
            </ul>
        </div>

    </div>
    
</nav>';
}
?>
