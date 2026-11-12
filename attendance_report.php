<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php 
include('sessionservices.php');
require_once('attendance_monthly_report_grid.php');

$active_tab = ($_GET['tab'] ?? '') === 'weekly' ? 'weekly' : 'monthly';

// Monthly parameters
$sel_month = !empty($_GET['month']) ? str_pad(intval($_GET['month']), 2, '0', STR_PAD_LEFT) : (!empty($_GET['select_month']) ? str_pad(intval($_GET['select_month']), 2, '0', STR_PAD_LEFT) : date('m'));
$sel_year  = !empty($_GET['year']) ? intval($_GET['year']) : (!empty($_GET['select_year']) ? intval($_GET['select_year']) : intval(date('Y')));
if ($sel_year < 2020 || $sel_year > 2050) { $sel_year = intval(date('Y')); }

// Weekly parameters
$select_week = $_GET['select_week'] ?? date('d/m/Y');

// Pre-render Monthly Report data
$monthly_data = renderMonthlyAttendanceReport($conn, $sel_month, $sel_year);
$cnt_monthly = $monthly_data['tot_employee'];

// Count weekly staff
$cw_q = mysqli_query($conn, "SELECT COUNT(*) as c FROM tbl_employee_details WHERE delete_status='NDL' AND active_status='Y' AND emp_salary_type='2'");
$cnt_weekly = ($cw_q && $cwr = mysqli_fetch_assoc($cw_q)) ? (int)$cwr['c'] : 0;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance Reports - Jayam Hydraulic Engineering</title>
    <link rel="icon" type="image/png" href="userdata/images/favicon.png">

    <!-- begin::global styles -->
    <link rel="stylesheet" href="vendors/bundle.css" type="text/css">
	<link rel="stylesheet" href="vendors/select2/css/select2.min.css" type="text/css">
    <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="vendors/vmap/jqvmap.min.css">
    <link rel="stylesheet" href="css/app.min.css" type="text/css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- end::global styles -->

    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://www.jqueryscript.net/demo/Week-Picker-Plugin-jQuery-UI/jquery.weekpicker.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css">

    <style>
        .no-wrap { word-break: break-all; }

        /* Navigation Tab Styles */
        .att-nav-tabs {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 18px;
        }
        .att-nav-tabs .nav-link {
            font-size: 15px;
            font-weight: 600;
            color: #64748b;
            border: none;
            border-bottom: 3px solid transparent;
            padding: 11px 24px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .att-nav-tabs .nav-link:hover {
            color: #0f172a;
        }
        .att-nav-tabs .nav-link.active {
            color: #0f766e !important;
            font-weight: 700 !important;
            border-bottom: 3px solid #0f766e !important;
            background: transparent;
        }

        /* Stat cards */
        .stat-card-pill {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 12px;
            margin-right: 8px;
            margin-bottom: 6px;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }
        .stat-card-pill .stat-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
            margin-right: 8px;
        }
        .stat-card-pill .stat-value {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
        }

        /* Status legend pills */
        .legend-pill {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            margin-right: 8px;
            margin-bottom: 4px;
        }
        .legend-pill.lp-present  { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .legend-pill.lp-absent   { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .legend-pill.lp-halfday  { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .legend-pill.lp-festival { background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; }
        .legend-pill.lp-sunday   { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

        /* Report tables and zero y-axis scrolling */
        .table-responsive {
            max-width: 100%;
            overflow-x: auto !important;
            overflow-y: visible !important;
            max-height: none !important;
        }
        .monthly_attendance_bind .table-responsive,
        .monthly_attendance_bind table,
        .monthly_attendance_bind tbody,
        .attendance_bind,
        .attendance_bind table,
        .attendance_bind tbody {
            overflow-y: visible !important;
            max-height: none !important;
        }

        /* Monthly Attendance Table Styles - strictly zero y-axis scrolling */
        .monthly-table-wrapper {
            max-height: none !important;
            min-height: auto !important;
            overflow-x: auto !important;
            overflow-y: visible !important;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            position: relative;
        }
        .monthly-table-wrapper table,
        .monthly-table-wrapper tbody {
            overflow-y: visible !important;
            max-height: none !important;
        }
        #monthly_attendance_table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }
        #monthly_attendance_table thead th {
            position: sticky !important;
            top: 0 !important;
            z-index: 20 !important;
        }
        #monthly_attendance_table thead th.sticky-corner-1 {
            position: sticky !important;
            left: 0 !important;
            top: 0 !important;
            z-index: 30 !important;
        }
        #monthly_attendance_table thead th.sticky-corner-2 {
            position: sticky !important;
            left: 42px !important;
            top: 0 !important;
            z-index: 30 !important;
        }
        #monthly_attendance_table tbody td.col-monthly-num {
            position: sticky !important;
            left: 0 !important;
            z-index: 10 !important;
            background: #f8fafc;
        }
        #monthly_attendance_table tbody td.col-monthly-emp {
            position: sticky !important;
            left: 42px !important;
            z-index: 10 !important;
            background: #ffffff;
        }
        #monthly_attendance_table tbody tr:hover td {
            background-color: #f1f5f9 !important;
        }
        #monthly_attendance_table tbody tr:hover td.col-monthly-emp,
        #monthly_attendance_table tbody tr:hover td.col-monthly-num {
            background-color: #f1f5f9 !important;
        }
        #monthly_attendance_table tfoot td.sticky-footer-title {
            position: sticky !important;
            left: 0 !important;
            z-index: 12 !important;
        }

        /* Freeze / Sticky Columns for Weekly Table */
        #weekly_attendance_table thead th.sticky-emp-col {
            position: sticky;
            left: 40px;
            z-index: 3;
            border-right: 2px solid #cbd5e1 !important;
        }
        #weekly_attendance_table td.sticky-emp-col {
            position: sticky;
            left: 40px;
            z-index: 2;
            border-right: 2px solid #cbd5e1 !important;
            box-shadow: 4px 0 6px -2px rgba(0, 0, 0, 0.08);
        }
        #weekly_attendance_table tbody tr:hover td,
        #weekly_attendance_table tbody tr:hover td.sticky-emp-col {
            background-color: #f1f5f9 !important;
        }

        /* Clean action bar */
        .toolbar-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        @media print {
            .page-loader, .d-print-none, .header, .navigation, .app-header, .sidebar, 
            .att-nav-tabs, form, .form-group, #search_monthly, #search, .btn, .toolbar-box {
                display: none !important;
            }
            body, main.main-content, .card, .card-body {
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                background: transparent !important;
            }
            .table-responsive {
                max-height: none !important;
                overflow: visible !important;
                border: none !important;
            }
            table {
                width: 100% !important;
            }
            th, td {
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border text-primary"></div>
    <span>Loading Attendance Report ...</span>
</div>
<!-- end::page loader -->

<?php echo $header;?>

<!-- begin::main content -->
<main class="main-content">

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1" style="font-weight:700;color:#0f172a;">
                    <i class="fa fa-calendar-check-o text-primary mr-2"></i> Attendance Reports
                </h4>
                <small class="text-muted">Comprehensive monthly and weekly staff attendance tracking, worked days, and wage summaries</small>
            </div>
            <div class="d-flex align-items-center mt-2 mt-md-0 d-print-none">
                <a href="attendance_details.php" class="btn btn-outline-primary mr-2">
                    <i class="fa fa-edit mr-1"></i> Mark Attendance
                </a>
                <a href="add_attendance_salary.php" class="btn btn-outline-success mr-2">
                    <i class="fa fa-money mr-1"></i> Salary Payment
                </a>
                <button type="button" onclick="window.print()" class="btn btn-success">
                    <i class="fa fa-print mr-1"></i> Print Report
                </button>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs att-nav-tabs d-print-none">
            <li class="nav-item">
                <a class="nav-link <?php echo $active_tab === 'monthly' ? 'active' : ''; ?>" id="tab-nav-monthly" href="javascript:void(0)" onclick="switchTab('monthly')">
                    <i class="fa fa-calendar mr-1"></i> Monthly Attendance Report
                    <span class="badge badge-pill badge-primary ml-1" id="badge_monthly_count"><?php echo $cnt_monthly; ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $active_tab === 'weekly' ? 'active' : ''; ?>" id="tab-nav-weekly" href="javascript:void(0)" onclick="switchTab('weekly')">
                    <i class="fa fa-calendar-minus-o mr-1"></i> Weekly Attendance Report
                    <span class="badge badge-pill badge-info ml-1" id="badge_weekly_count"><?php echo $cnt_weekly; ?></span>
                </a>
            </li>
        </ul>

        <!-- ======================================================== -->
        <!-- PANE 1: MONTHLY ATTENDANCE REPORT                         -->
        <!-- ======================================================== -->
        <div id="pane_monthly" style="<?php echo $active_tab === 'monthly' ? '' : 'display:none;'; ?>">
            
            <!-- Dual-Bar Toolbar -->
            <div class="toolbar-box d-print-none">
                <!-- Top Row: Month Picker, Navigation, and Action Buttons -->
                <div class="row align-items-center pb-2 mb-2 border-bottom">
                    <div class="col-lg-7 col-md-12 mb-2 mb-lg-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="font-weight-bold mr-2 text-dark" style="font-size:13px;">Month:</span>
                            <div class="btn-group mr-2 mb-1" role="group">
                                <button type="button" id="btn_prev_month" class="btn btn-sm btn-outline-secondary" title="Previous Month">
                                    <i class="fa fa-chevron-left mr-1"></i> Prev
                                </button>
                                <button type="button" id="btn_next_month" class="btn btn-sm btn-outline-secondary" title="Next Month">
                                    Next <i class="fa fa-chevron-right ml-1"></i>
                                </button>
                            </div>
                            <select class="form-control form-control-sm mr-2 mb-1" name="select_month" id="select_month" style="width:130px;font-weight:600;">
                                <?php
                                $months_arr = [
                                    "01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April",
                                    "05"=>"May", "06"=>"June", "07"=>"July", "08"=>"August",
                                    "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December"
                                ];
                                foreach ($months_arr as $m_num => $m_name) {
                                    $s = ($sel_month === $m_num) ? 'selected' : '';
                                    echo '<option value="' . $m_num . '" ' . $s . '>' . $m_name . '</option>';
                                }
                                ?>
                            </select>
                            <select class="form-control form-control-sm mr-2 mb-1" name="select_year" id="select_year" style="width:95px;font-weight:600;">
                                <?php for ($yr = 2021; $yr <= 2040; $yr++): ?>
                                    <option value="<?php echo $yr; ?>" <?php echo ($sel_year == $yr) ? 'selected' : ''; ?>><?php echo $yr; ?></option>
                                <?php endfor; ?>
                            </select>
                            <button type="button" id="search_monthly" class="btn btn-sm btn-primary mb-1">
                                <i class="fa fa-refresh mr-1"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 text-lg-right">
                        <button type="button" onclick="exportMonthlyToExcel()" class="btn btn-sm btn-outline-success mr-2 mb-1" title="Download spreadsheet (.csv)">
                            <i class="fa fa-file-excel-o mr-1"></i> Export to Excel
                        </button>
                        <button type="button" onclick="window.print()" class="btn btn-sm btn-outline-dark mb-1">
                            <i class="fa fa-print mr-1"></i> Print
                        </button>
                    </div>
                </div>

                <!-- Second Row: Live Employee Search and Summary Stat Pills -->
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-5 col-sm-12 mb-2 mb-md-0">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                            </div>
                            <input type="text" id="filter_monthly_emp" class="form-control" placeholder="Quick search staff name..." autocomplete="off">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="clear_monthly_search" title="Clear search" style="display:none;">&times;</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-12 text-md-right">
                        <div class="d-inline-flex flex-wrap justify-content-md-end">
                            <div class="stat-card-pill">
                                <span class="stat-label">Monthly Staff</span>
                                <span class="stat-value text-primary" id="stat_monthly_staff"><?php echo $cnt_monthly; ?></span>
                            </div>
                            <div class="stat-card-pill">
                                <span class="stat-label">Days in Month</span>
                                <span class="stat-value" id="stat_cal_days"><?php echo $monthly_data['tot_days']; ?></span>
                            </div>
                            <div class="stat-card-pill" title="Sundays are weekly off">
                                <span class="stat-label">Sundays (Off)</span>
                                <span class="stat-value text-info" id="stat_sundays"><?php echo $monthly_data['tot_sundays']; ?></span>
                            </div>
                            <div class="stat-card-pill" title="Working days excluding Sundays">
                                <span class="stat-label">Working Days</span>
                                <span class="stat-value text-success" id="stat_working_days"><?php echo $monthly_data['tot_working']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Legend Row -->
                <div class="mt-2 pt-2 border-top d-flex flex-wrap align-items-center">
                    <small class="font-weight-bold text-muted mr-3">Status Legend:</small>
                    <span class="legend-pill lp-present"><strong>P</strong> &nbsp;Present</span>
                    <span class="legend-pill lp-absent"><strong>A</strong> &nbsp;Absent</span>
                    <span class="legend-pill lp-halfday"><strong>HD</strong> &nbsp;Half Day</span>
                    <span class="legend-pill lp-festival"><strong>F</strong> &nbsp;Festival / Holiday</span>
                    <span class="legend-pill lp-sunday"><strong>Off</strong> &nbsp;Sunday Weekly Off</span>
                    <small class="text-muted ml-auto d-none d-lg-inline-block"><em>Payable Days = Present + Festival + (0.5 &times; Half Day)</em></small>
                </div>
            </div>

            <!-- Monthly Report Grid Card -->
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h5 class="mb-0 font-weight-bold" id="monthly_heading">
                                Monthly Attendance Report - <?php echo date('F Y', strtotime("$sel_year-$sel_month-01")); ?>
                            </h5>
                            <small class="text-muted">Showing Monthly-salary staff only &middot; Sundays counted as Weekly Off</small>
                        </div>
                        <div class="d-print-none text-muted font-weight-bold" style="font-size:12px;">
                            Showing <span id="lbl_visible_monthly_count"><?php echo $cnt_monthly; ?></span> of <?php echo $cnt_monthly; ?> staff
                        </div>
                    </div>

                    <div class="monthly_attendance_bind">
                        <?php echo $monthly_data['html']; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- PANE 2: WEEKLY ATTENDANCE REPORT                          -->
        <!-- ======================================================== -->
        <div id="pane_weekly" style="<?php echo $active_tab === 'weekly' ? '' : 'display:none;'; ?>">
            
            <!-- Dual-Bar Toolbar -->
            <div class="toolbar-box d-print-none">
                <!-- Top Row: Week Picker, Week Steppers, and Action Buttons -->
                <div class="row align-items-center pb-2 mb-2 border-bottom">
                    <div class="col-lg-7 col-md-12 mb-2 mb-lg-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <span class="font-weight-bold mr-2 text-dark" style="font-size:13px;">Week:</span>
                            <div class="btn-group mr-2 mb-1" role="group">
                                <button type="button" id="btn_prev_week" class="btn btn-sm btn-outline-secondary" title="Previous Week">
                                    <i class="fa fa-chevron-left mr-1"></i> Prev Week
                                </button>
                                <button type="button" id="btn_next_week" class="btn btn-sm btn-outline-secondary" title="Next Week">
                                    Next Week <i class="fa fa-chevron-right ml-1"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control form-control-sm select_week mr-2 mb-1" id="select_week" name="select_week" value="<?php echo htmlspecialchars($select_week); ?>" style="width:140px;font-weight:600;">
                            <input type="hidden" class="form-control" id="select_week1" name="select_week1" value="<?php echo htmlspecialchars($select_week); ?>">
                            <button id="search" name="search" class="btn btn-sm btn-success mb-1">
                                <i class="fa fa-search mr-1"></i> Search
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 text-lg-right">
                        <button type="button" onclick="exportWeeklyToExcel()" class="btn btn-sm btn-outline-success mr-2 mb-1" title="Download spreadsheet (.csv)">
                            <i class="fa fa-file-excel-o mr-1"></i> Export to Excel
                        </button>
                        <button type="button" onclick="window.print()" class="btn btn-sm btn-outline-dark mb-1">
                            <i class="fa fa-print mr-1"></i> Print
                        </button>
                    </div>
                </div>

                <!-- Second Row: Live Employee Search and Stats -->
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-5 col-sm-12 mb-2 mb-md-0">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                            </div>
                            <input type="text" id="filter_weekly_emp" class="form-control" placeholder="Quick search staff name..." autocomplete="off">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="clear_weekly_search" title="Clear search" style="display:none;">&times;</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-12 text-md-right">
                        <div class="stat-card-pill">
                            <span class="stat-label">Weekly Staff</span>
                            <span class="stat-value text-info" id="stat_weekly_staff"><?php echo $cnt_weekly; ?></span>
                        </div>
                        <span class="legend-pill lp-sunday"><strong>Off</strong> &nbsp;Sunday Weekly Off</span>
                    </div>
                </div>
            </div>

            <!-- Weekly Report Grid Card -->
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h5 class="mb-0 font-weight-bold" id="weekly_heading">Weekly Attendance Report</h5>
                            <small class="text-muted">Weekly-salary staff only &middot; Mon–Sat attendance with Sunday as Weekly Off</small>
                        </div>
                        <div class="d-print-none text-muted font-weight-bold" style="font-size:12px;">
                            Showing <span id="lbl_visible_weekly_count"><?php echo $cnt_weekly; ?></span> of <?php echo $cnt_weekly; ?> staff
                        </div>
                    </div>

                    <div class="attendance_bind" style="overflow-x:auto;margin-top:10px;">
                        <table id="weekly_attendance_table" class="table table-bordered table-striped" style="width:100%; text-align:center;margin-bottom:0;border-collapse:separate;border-spacing:0;font-size:13px;">
                            <thead style="background:#f8fafc;color:#1e293b;">
                                <tr>
                                    <th style="width:40px;position:sticky;left:0;z-index:3;background:#f8fafc;">No</th>
                                    <th class="name sticky-emp-col" style="width:160px;text-align:left;position:sticky;left:40px;z-index:3;background:#f8fafc;padding-left:10px;">Name</th>
                                    <th class="name" style="width:100px;">Daily Wage</th>
                                    <?php 				
                                    // Parse selected week or default date
                                    $w_dt = DateTime::createFromFormat('d/m/Y', $select_week);
                                    if (!$w_dt) { $w_dt = DateTime::createFromFormat('Y-m-d', $select_week); }
                                    if (!$w_dt) { $w_dt = new DateTime(); }
                                    $w_date_str = $w_dt->format('Y-m-d');

                                    $ts = strtotime($w_date_str);
                                    $year = date('o', $ts);
                                    $week = date('W', $ts);					

                                    // print week for the current date
                                    for($i = 1; $i <= 7; $i++) {
                                        $day_ts = strtotime($year.'W'.$week.$i);
                                        $is_sun = ($i == 7);
                                        $bg_th = $is_sun ? 'background:#e0f2fe;color:#0369a1;' : '';
                                        ?>
                                        <th style="<?php echo $bg_th; ?>"><?php echo date("d/m", $day_ts); ?><br><small><?php echo date("D", $day_ts); ?></small></th>
                                    <?php }

                                    $start_date = strtotime($year.'W'.$week.'1');
                                    $end_date = strtotime($year.'W'.$week.'7');

                                    $start_date1 = date("Y-m-d", $start_date);
                                    $end_date1 = date("Y-m-d", $end_date);
                                    ?>
                                    <th class="name" style="width:90px;">Worked Days</th>	
                                    <th class="name" style="width:95px;">Tot.Salary</th>							
                                    <th class="name" style="width:95px;">Tot.Paid</th>
                                    <th class="name" style="width:95px;">Balance</th>							
                                </tr>
                            </thead>
                            <tbody>
                                <?php 							
                                $sql = "select * from tbl_employee_details where delete_status='NDL' and active_status='Y' and emp_salary_type='2' order by emp_id desc";
                                $exec_query = mysqli_query($conn, $sql);
                                
                                $j = 0;
                                $grand_salary = 0;
                                $grand_paid = 0;
                                $grand_balance = 0;

                                if ($exec_query) {
                                    while ($fetch = mysqli_fetch_array($exec_query)) {
                                        $emp_name = $fetch['emp_name'];
                                        $salary = (float)($fetch['salary'] ?? 0);
                                        $emp_id = (int)$fetch['emp_id'];

                                        // Query attendance for this week
                                        $att_map = [];
                                        $aq = mysqli_query($conn, "SELECT attendance_date, attendance_status FROM tbl_attendance WHERE delete_status='NDL' AND emp_id='$emp_id' AND attendance_date BETWEEN '$start_date1' AND '$end_date1'");
                                        if ($aq) {
                                            while ($ar = mysqli_fetch_assoc($aq)) {
                                                $att_map[$ar['attendance_date']] = $ar['attendance_status'];
                                            }
                                        }

                                        $pres = 0; $abs = 0; $half = 0; $fest = 0;
                                ?>
                                <tr class="weekly-emp-row" data-emp-name="<?php echo htmlspecialchars(strtolower($emp_name)); ?>">
                                    <td style="font-weight:bold;position:sticky;left:0;z-index:2;background:#fff;"><?php echo $j + 1; ?></td>
                                    <td class="sticky-emp-col" style="font-weight:bold;text-align:left;color:#0f172a;position:sticky;left:40px;z-index:2;background:#fff;padding-left:10px;"><?php echo htmlspecialchars($emp_name); ?></td>
                                    <td style="font-weight:bold;"><?php echo htmlspecialchars($fetch['salary']); ?></td>
                                    <?php 	
                                    for($z = 1; $z <= 7; $z++) {
                                        $day_ts = strtotime($year.'W'.$week.$z);
                                        $day_str = date('Y-m-d', $day_ts);

                                        if ($z == 7) {
                                            echo '<td style="background:#e0f2fe;color:#0369a1;font-weight:600;font-size:11px;">Off</td>';
                                        } else {
                                            $st = $att_map[$day_str] ?? '';
                                            if ($st === 'Present') {
                                                $pres++;
                                                echo '<td style="color:#16a34a;font-weight:bold;" title="Present">P</td>';
                                            } else if ($st === 'Absent') {
                                                $abs++;
                                                echo '<td style="color:#dc2626;font-weight:bold;" title="Absent">A</td>';
                                            } else if ($st === 'Halfday') {
                                                $half++;
                                                echo '<td style="color:#d97706;font-weight:bold;" title="Halfday">HD</td>';
                                            } else if ($st === 'Festival') {
                                                $fest++;
                                                echo '<td style="color:#2563eb;font-weight:bold;" title="Festival">F</td>';
                                            } else {
                                                echo '<td style="color:#94a3b8;">-</td>';
                                            }
                                        }
                                    }

                                    $worked_days = $pres + $fest + ($half * 0.5);
                                    $tot_sal = round($worked_days * $salary, 2);

                                    $salary_sql1 = "select COALESCE(sum(pay_amount),0) as total_amount from tbl_emp_hour_salary where delete_status='NDL' and emp_id='$emp_id' and start_date = '$start_date1' and end_date='$end_date1'";
                                    $salary_query_sql1 = mysqli_query($conn, $salary_sql1);
                                    $fetch_salary = $salary_query_sql1 ? mysqli_fetch_assoc($salary_query_sql1) : ['total_amount' => 0];
                                    $tot_paid = (float)($fetch_salary['total_amount'] ?? 0);
                                    $balance = $tot_sal - $tot_paid;

                                    $grand_salary += $tot_sal;
                                    $grand_paid += $tot_paid;
                                    $grand_balance += $balance;
                                    ?>
                                    <td style="font-weight:bold;background:#f0fdfa;"><?php echo $worked_days; ?></td>
                                    <td style="font-weight:bold;"><?php echo number_format($tot_sal, 2, '.', ''); ?></td>
                                    <td style="font-weight:bold;color:#16a34a;"><?php echo number_format($tot_paid, 2, '.', ''); ?></td>
                                    <td style="font-weight:bold;<?php echo ($balance > 0 ? 'color:#dc2626;' : 'color:#16a34a;'); ?>"><?php echo number_format($balance, 2, '.', ''); ?></td>
                                </tr>
                                <?php $j++; } } 

                                if ($j === 0) {
                                    echo '<tr><td colspan="14" class="text-center text-muted p-3">No active weekly-wage employees found</td></tr>';
                                }
                                ?>
                                <tr id="no_weekly_search_match" style="display:none;"><td colspan="14" class="text-center text-muted p-4"><i class="fa fa-info-circle mr-1"></i> No staff found matching "<span class="weekly-search-term-disp"></span>"</td></tr>
                            </tbody>
                            <tfoot>
                                <tr style="background:#f1f5f9;font-weight:bold;">
                                    <th colspan="10" style="text-align:right;">Total:</th>
                                    <th><?php echo number_format($grand_salary, 2, '.', ''); ?></th>
                                    <th><?php echo number_format($grand_paid, 2, '.', ''); ?></th>
                                    <th style="<?php echo ($grand_balance > 0 ? 'color:#dc2626;' : 'color:#16a34a;'); ?>"><?php echo number_format($grand_balance, 2, '.', ''); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<!-- end::main content -->

<?php include("footer.php") ?>

<!-- begin::global scripts -->
<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>
<script src="vendors/select2/js/select2.min.js"></script>
<script src="vendors/datepicker/daterangepicker.js"></script>
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>
<!-- end::global scripts -->

<script>
// Tab Switching function
function switchTab(tab) {
    if (tab === 'monthly') {
        $('#pane_monthly').show();
        $('#pane_weekly').hide();
        $('#tab-nav-monthly').addClass('active');
        $('#tab-nav-weekly').removeClass('active');
        if (history.replaceState) {
            var m = $('#select_month').val();
            var y = $('#select_year').val();
            history.replaceState(null, '', '?tab=monthly&month=' + m + '&year=' + y);
        }
    } else {
        $('#pane_monthly').hide();
        $('#pane_weekly').show();
        $('#tab-nav-monthly').removeClass('active');
        $('#tab-nav-weekly').addClass('active');
        if (history.replaceState) {
            var w = $('#select_week').val();
            history.replaceState(null, '', '?tab=weekly&select_week=' + encodeURIComponent(w));
        }
    }
}

// Universal Excel/CSV Export Engine
function downloadCSV(csvContent, filename) {
    var blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' });
    if (navigator.msSaveBlob) {
        navigator.msSaveBlob(blob, filename);
    } else {
        var link = document.createElement("a");
        if (link.download !== undefined) {
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}

function exportMonthlyToExcel() {
    var table = document.getElementById("monthly_attendance_table");
    if (!table) return;

    var csv = [];
    // Title row
    var title = $("#monthly_heading").text().trim();
    csv.push('"' + title.replace(/"/g, '""') + '"');
    csv.push('');

    // Headers
    var headerRow = [];
    $(table).find('thead tr:first th').each(function() {
        var txt = $(this).clone().children('small').remove().end().text().trim();
        txt = txt.replace(/\s+/g, ' ');
        headerRow.push('"' + txt.replace(/"/g, '""') + '"');
    });
    csv.push(headerRow.join(','));

    // Data rows
    $(table).find('tbody tr.emp-report-row:visible').each(function() {
        var row = [];
        $(this).find('td').each(function() {
            var cellText = $(this).text().trim();
            cellText = cellText.replace(/\s+/g, ' ');
            row.push('"' + cellText.replace(/"/g, '""') + '"');
        });
        csv.push(row.join(','));
    });

    // Footer rows
    $(table).find('tfoot tr').each(function() {
        var frow = [];
        $(this).find('th, td').each(function() {
            var ftxt = $(this).text().trim();
            ftxt = ftxt.replace(/\s+/g, ' ');
            frow.push('"' + ftxt.replace(/"/g, '""') + '"');
        });
        csv.push(frow.join(','));
    });

    var monthName = $('#select_month option:selected').text();
    var year = $('#select_year').val();
    downloadCSV(csv.join('\r\n'), 'Monthly_Attendance_Report_' + monthName + '_' + year + '.csv');
}

function exportWeeklyToExcel() {
    var table = document.getElementById("weekly_attendance_table");
    if (!table) return;

    var csv = [];
    var title = $("#weekly_heading").text().trim() + ' (' + $('#select_week').val() + ')';
    csv.push('"' + title.replace(/"/g, '""') + '"');
    csv.push('');

    // Headers
    var headerRow = [];
    $(table).find('thead tr th').each(function() {
        var txt = $(this).clone().children('small').remove().end().text().trim();
        txt = txt.replace(/\s+/g, ' ');
        headerRow.push('"' + txt.replace(/"/g, '""') + '"');
    });
    csv.push(headerRow.join(','));

    // Visible Rows
    $(table).find('tbody tr.weekly-emp-row:visible').each(function() {
        var row = [];
        $(this).find('td').each(function() {
            var cellText = $(this).text().trim();
            cellText = cellText.replace(/\s+/g, ' ');
            row.push('"' + cellText.replace(/"/g, '""') + '"');
        });
        csv.push(row.join(','));
    });

    // Footer
    $(table).find('tfoot tr').each(function() {
        var frow = [];
        $(this).find('th, td').each(function() {
            var ftxt = $(this).text().trim();
            ftxt = ftxt.replace(/\s+/g, ' ');
            frow.push('"' + ftxt.replace(/"/g, '""') + '"');
        });
        csv.push(frow.join(','));
    });

    var wStr = $('#select_week').val().replace(/[\/\\]/g, '-');
    downloadCSV(csv.join('\r\n'), 'Weekly_Attendance_Report_' + wStr + '.csv');
}

$(document).ready(function(){
    // Initialize Weekpicker
    if ($.fn.weekpicker) {
        $("#select_week").weekpicker();
    }

    // Monthly Live Search
    $('#filter_monthly_emp').on('input', function() {
        var q = $(this).val().toLowerCase().trim();
        var total = 0;
        var visible = 0;

        $('#clear_monthly_search').toggle(q.length > 0);

        $('#monthly_attendance_table tbody tr.emp-report-row').each(function() {
            total++;
            var name = $(this).attr('data-emp-name') || '';
            if (!q || name.indexOf(q) !== -1) {
                $(this).show();
                visible++;
            } else {
                $(this).hide();
            }
        });

        $('#lbl_visible_monthly_count').text(visible);
        if (visible === 0 && total > 0) {
            $('.search-term-disp').text(q);
            $('#no_emp_search_match').show();
        } else {
            $('#no_emp_search_match').hide();
        }
    });

    $('#clear_monthly_search').on('click', function() {
        $('#filter_monthly_emp').val('').trigger('input').focus();
    });

    // Weekly Live Search
    $('#filter_weekly_emp').on('input', function() {
        var q = $(this).val().toLowerCase().trim();
        var total = 0;
        var visible = 0;

        $('#clear_weekly_search').toggle(q.length > 0);

        $('#weekly_attendance_table tbody tr.weekly-emp-row').each(function() {
            total++;
            var name = $(this).attr('data-emp-name') || '';
            if (!q || name.indexOf(q) !== -1) {
                $(this).show();
                visible++;
            } else {
                $(this).hide();
            }
        });

        $('#lbl_visible_weekly_count').text(visible);
        if (visible === 0 && total > 0) {
            $('.weekly-search-term-disp').text(q);
            $('#no_weekly_search_match').show();
        } else {
            $('#no_weekly_search_match').hide();
        }
    });

    $('#clear_weekly_search').on('click', function() {
        $('#filter_weekly_emp').val('').trigger('input').focus();
    });

    // Monthly Report AJAX fetch
    function loadMonthlyReport() {
        var month = $('#select_month').val();
        var year = $('#select_year').val();
        $(".page-loader").show();

        $.ajax({
            type: "POST",
            url: "attendance_monthly_report_grid.php",
            data: { select_month: month, select_year: year },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $(".monthly_attendance_bind").html(res.attendance_bind);
                    $("#stat_monthly_staff").text(res.tot_employee);
                    $("#stat_cal_days").text(res.tot_days);
                    $("#stat_sundays").text(res.tot_sundays);
                    $("#stat_working_days").text(res.tot_working);
                    $("#badge_monthly_count").text(res.tot_employee);
                    $("#lbl_visible_monthly_count").text(res.tot_employee);

                    var monthName = $('#select_month option:selected').text();
                    $("#monthly_heading").text("Monthly Attendance Report - " + monthName + " " + year);

                    // Re-apply filter if user already typed in search box
                    if ($('#filter_monthly_emp').val().trim()) {
                        $('#filter_monthly_emp').trigger('input');
                    }

                    if (history.replaceState) {
                        history.replaceState(null, '', '?tab=monthly&month=' + month + '&year=' + year);
                    }
                }
                $(".page-loader").hide();
            },
            error: function(xhr, status, error) {
                console.error("Monthly Attendance Report Error:", error);
                $(".page-loader").hide();
            }
        });
    }

    $(document).on('click', '#search_monthly', loadMonthlyReport);
    $(document).on('change', '#select_month, #select_year', loadMonthlyReport);

    // Prev / Next Month Shortcuts
    $('#btn_prev_month').on('click', function() {
        var curM = parseInt($('#select_month').val(), 10);
        var curY = parseInt($('#select_year').val(), 10);

        curM--;
        if (curM < 1) {
            curM = 12;
            curY--;
        }

        var mStr = (curM < 10 ? '0' : '') + curM;
        $('#select_month').val(mStr);
        $('#select_year').val(curY);
        loadMonthlyReport();
    });

    $('#btn_next_month').on('click', function() {
        var curM = parseInt($('#select_month').val(), 10);
        var curY = parseInt($('#select_year').val(), 10);

        curM++;
        if (curM > 12) {
            curM = 1;
            curY++;
        }

        var mStr = (curM < 10 ? '0' : '') + curM;
        $('#select_month').val(mStr);
        $('#select_year').val(curY);
        loadMonthlyReport();
    });

    // Weekly Report AJAX fetch
    function loadWeeklyReport() {
        $(".attendance_bind").empty();
        $(".page-loader").show();

        var select_week = $("#select_week").val();
        if (!select_week) {
            select_week = $("#select_week1").val();
        }

        $.ajax({
            type: "POST",
            url: "attendance_report_grid.php",
            dataType: 'json',
            data: { select_week: select_week },
            success: function(result) {
                $(".attendance_bind").html(result.attendance_bind);

                // Re-apply weekly search filter if active
                if ($('#filter_weekly_emp').val().trim()) {
                    $('#filter_weekly_emp').trigger('input');
                } else {
                    var totalWeekly = $('#weekly_attendance_table tbody tr.weekly-emp-row').length;
                    $('#lbl_visible_weekly_count').text(totalWeekly);
                }

                if (history.replaceState) {
                    history.replaceState(null, '', '?tab=weekly&select_week=' + encodeURIComponent(select_week));
                }
                $(".page-loader").hide();
            },
            error: function(xhr, status, error) {
                console.error("Weekly Attendance Report Error:", error);
                $(".page-loader").hide();
            }
        });
    }

    $(document).on('click', '#search', loadWeeklyReport);
    $(document).on('change', '#select_week', loadWeeklyReport);

    // Prev / Next Week Shortcuts
    function parseDateDMY(dateStr) {
        if (!dateStr) return new Date();
        var parts = dateStr.split('/');
        if (parts.length === 3) {
            return new Date(parseInt(parts[2], 10), parseInt(parts[1], 10) - 1, parseInt(parts[0], 10));
        }
        var pDash = dateStr.split('-');
        if (pDash.length === 3) {
            return new Date(parseInt(pDash[0], 10), parseInt(pDash[1], 10) - 1, parseInt(pDash[2], 10));
        }
        return new Date();
    }

    function formatDateDMY(d) {
        var day = (d.getDate() < 10 ? '0' : '') + d.getDate();
        var mon = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
        return day + '/' + mon + '/' + d.getFullYear();
    }

    $('#btn_prev_week').on('click', function() {
        var curDate = parseDateDMY($('#select_week').val());
        curDate.setDate(curDate.getDate() - 7);
        var newStr = formatDateDMY(curDate);
        $('#select_week').val(newStr);
        $('#select_week1').val(newStr);
        loadWeeklyReport();
    });

    $('#btn_next_week').on('click', function() {
        var curDate = parseDateDMY($('#select_week').val());
        curDate.setDate(curDate.getDate() + 7);
        var newStr = formatDateDMY(curDate);
        $('#select_week').val(newStr);
        $('#select_week1').val(newStr);
        loadWeeklyReport();
    });
});
</script>
</body>
</html>