<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php 
include('sessionservices.php'); 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance Module - Jayam Hydraulic Engineering</title>
    <link rel="icon" type="image/png" href="userdata/images/favicon.png">

    <!-- begin::global styles -->
    <link rel="stylesheet" href="vendors/bundle.css" type="text/css">
    <link rel="stylesheet" href="vendors/select2/css/select2.min.css" type="text/css">
    <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="css/app.min.css" type="text/css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- end::global styles -->

    <style>
        .no-wrap { word-break: break-all; }
        .attendance-matrix-wrapper {
            overflow-x: auto;
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            background: #fff;
        }
        .attendance-matrix-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
            margin-bottom: 0;
        }
        .attendance-matrix-table th, .attendance-matrix-table td {
            border: 1px solid #e2e8f0;
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
        .attendance-matrix-table thead th {
            background: #0f172a;
            color: #f8fafc;
            position: sticky;
            top: 0;
            z-index: 3;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.3px;
        }
        .attendance-matrix-table th.col-sticky-emp,
        .attendance-matrix-table td.col-sticky-emp {
            position: sticky;
            left: 0;
            background: #ffffff;
            z-index: 2;
            text-align: left;
            font-weight: 600;
            min-width: 180px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }
        .attendance-matrix-table thead th.col-sticky-emp {
            background: #0f172a;
            color: #ffffff;
            z-index: 4;
        }
        .attendance-matrix-table tr:hover td {
            background-color: #f8fafc;
        }
        .attendance-matrix-table tr:hover td.col-sticky-emp {
            background-color: #f1f5f9;
        }

        /* Status cell dropdown styles */
        .att-select {
            width: 90px;
            height: 32px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            padding: 2px 4px;
            text-align-last: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background-color: #ffffff;
            color: #475569;
        }
        .att-select:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(37,99,235,0.3);
        }
        .att-select.st-present {
            background-color: #dcfce7 !important;
            color: #15803d !important;
            border-color: #86efac !important;
        }
        .att-select.st-absent {
            background-color: #fee2e2 !important;
            color: #b91c1c !important;
            border-color: #fca5a5 !important;
        }
        .att-select.st-halfday {
            background-color: #fef3c7 !important;
            color: #b45309 !important;
            border-color: #fde68a !important;
        }
        .att-select.st-holiday {
            background-color: #fce7f3 !important;
            color: #be185d !important;
            border-color: #fbcfe8 !important;
        }
        .att-select.st-festival {
            background-color: #e0e7ff !important;
            color: #4338ca !important;
            border-color: #c7d2fe !important;
        }
        .weekly-off-badge {
            display: inline-block;
            background: #f1f5f9;
            color: #64748b;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            font-size: 12px;
            letter-spacing: 0.3px;
        }

        /* Stat cards */
        .stat-card-pill {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 14px;
            margin-right: 10px;
            margin-bottom: 8px;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }
        .stat-card-pill .stat-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            margin-right: 8px;
        }
        .stat-card-pill .stat-value {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
        }

        /* Custom tabs */
        .att-tab-nav {
            display: flex;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 16px;
        }
        .att-tab-link {
            padding: 10px 24px;
            font-size: 15px;
            font-weight: 600;
            color: #64748b;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .att-tab-link:hover {
            color: #1e293b;
            text-decoration: none;
        }
        .att-tab-link.active {
            color: #0f766e;
            border-bottom-color: #0f766e;
            font-weight: 700;
            background: rgba(15,118,110,0.05);
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        /* Toast notification */
        #save_status_toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            background: #0f172a;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: none;
        }
    </style>
</head>
<body>


<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border text-primary"></div>
    <span>Loading Attendance ...</span>
</div>
<!-- end::page loader -->

<?php echo $header;?>

<?php
// Active tab state: 'monthly' or 'weekly'
$active_tab = ($_GET['tab'] ?? '') === 'weekly' ? 'weekly' : 'monthly';

// Monthly parameters
$sel_month = !empty($_GET['month']) ? str_pad(intval($_GET['month']), 2, '0', STR_PAD_LEFT) : date('m');
$sel_year = !empty($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));
if ($sel_year < 2020 || $sel_year > 2050) { $sel_year = intval(date('Y')); }

// Weekly parameters (ISO week Mon - Sun)
$week_date = !empty($_GET['week_date']) ? mysqli_real_escape_string($conn, trim($_GET['week_date'])) : date('Y-m-d');
$w_ts = strtotime($week_date);
if (!$w_ts) { $w_ts = time(); $week_date = date('Y-m-d'); }
$w_dow = date('N', $w_ts); // 1 = Mon, 7 = Sun
$mon_ts = strtotime('-' . ($w_dow - 1) . ' days', $w_ts);
$prev_week_date = date('Y-m-d', strtotime('-7 days', $mon_ts));
$next_week_date = date('Y-m-d', strtotime('+7 days', $mon_ts));

// Employees strictly categorized by tab: Monthly (salary_type=1) and Weekly (salary_type=2)
$monthly_employees = [];
$weekly_employees = [];
$emp_query = mysqli_query($conn, "SELECT emp_id, emp_name, emp_salary_type, salary FROM tbl_employee_details WHERE delete_status='NDL' AND active_status='Y' ORDER BY emp_name ASC");
if ($emp_query) {
    while ($er = mysqli_fetch_assoc($emp_query)) {
        if ($er['emp_salary_type'] == '1') {
            $monthly_employees[] = $er;
        } else if ($er['emp_salary_type'] == '2') {
            $weekly_employees[] = $er;
        }
    }
}
$cnt_monthly = count($monthly_employees);
$cnt_weekly = count($weekly_employees);

// Month metadata & Sunday calculation
$total_calendar_days = cal_days_in_month(CAL_GREGORIAN, (int)$sel_month, $sel_year);
$monthly_working_dates = [];
$monthly_sundays_count = 0;
for ($d = 1; $d <= $total_calendar_days; $d++) {
    $date_str = sprintf('%04d-%02d-%02d', $sel_year, (int)$sel_month, $d);
    $dow = date('N', strtotime($date_str));
    if ($dow == 7) {
        $monthly_sundays_count++;
    }
    $monthly_working_dates[] = [
        'day' => $d,
        'date' => $date_str,
        'label' => sprintf('%02d %s', $d, date('D', strtotime($date_str))),
        'dow' => $dow,
        'is_sunday' => ($dow == 7)
    ];
}
$monthly_working_days_count = count($monthly_working_dates) - $monthly_sundays_count;

// Query all monthly attendance records in ONE fast query
$m_start_date = sprintf('%04d-%02d-01', $sel_year, (int)$sel_month);
$m_end_date = sprintf('%04d-%02d-%02d', $sel_year, (int)$sel_month, $total_calendar_days);
$monthly_att_map = [];
$m_att_q = mysqli_query($conn, "SELECT emp_id, attendance_date, attendance_status FROM tbl_attendance WHERE delete_status='NDL' AND attendance_date BETWEEN '$m_start_date' AND '$m_end_date'");
if ($m_att_q) {
    while ($mar = mysqli_fetch_assoc($m_att_q)) {
        $monthly_att_map[$mar['emp_id']][$mar['attendance_date']] = $mar['attendance_status'];
    }
}

// Holiday day count (distinct dates marked Holiday) for the selected month
$monthly_holiday_dates = [];
foreach ($monthly_att_map as $m_emp_days) {
    foreach ($m_emp_days as $m_d => $m_st) {
        if ($m_st === 'Holiday') $monthly_holiday_dates[$m_d] = true;
    }
}
$monthly_holiday_count = count($monthly_holiday_dates);

// Week metadata (7 days: Monday through Sunday)
$weekly_days = [];
for ($i = 0; $i < 7; $i++) {
    $c_ts = strtotime('+' . $i . ' days', $mon_ts);
    $c_date = date('Y-m-d', $c_ts);
    $c_dow = date('N', $c_ts);
    $weekly_days[] = [
        'date' => $c_date,
        'day_name' => date('l', $c_ts),
        'short_name' => date('D', $c_ts),
        'display' => date('d M (D)', $c_ts),
        'is_sunday' => ($c_dow == 7)
    ];
}
$w_start_disp = date('d M Y', $mon_ts);
$w_end_disp = date('d M Y', strtotime('+6 days', $mon_ts));

// Query weekly attendance records in ONE fast query
$w_start_date = $weekly_days[0]['date'];
$w_end_date = $weekly_days[6]['date'];
$weekly_att_map = [];
$weekly_holiday_dates = [];
$w_att_q = mysqli_query($conn, "SELECT emp_id, attendance_date, attendance_status FROM tbl_attendance WHERE delete_status='NDL' AND attendance_date BETWEEN '$w_start_date' AND '$w_end_date'");
if ($w_att_q) {
    while ($war = mysqli_fetch_assoc($w_att_q)) {
        $weekly_att_map[$war['emp_id']][$war['attendance_date']] = $war['attendance_status'];
        if ($war['attendance_status'] === 'Holiday') $weekly_holiday_dates[$war['attendance_date']] = true;
    }
}
$weekly_holiday_count = count($weekly_holiday_dates);
?>

<!-- begin::main content -->
<main class="main-content">

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1" style="font-weight:700;color:#0f172a;">
                    <i class="fa fa-calendar-check-o text-success mr-2"></i> Employee Attendance
                </h4>
                <small class="text-muted">Manage daily attendance with instant auto-save &middot; Sundays can be marked P / H / F (Absent not allowed on Sunday)</small>
            </div>
            <div class="d-flex align-items-center mt-2 mt-md-0">
                <button type="button" class="btn btn-primary mr-2" id="btn_save_all" onclick="saveAllAttendance()">
                    <i class="fa fa-save mr-1"></i> Save Changes
                </button>
                <a href="add_attendance_salary.php?salary_date=<?php echo htmlspecialchars($active_tab === 'weekly' ? $week_date : sprintf('%04d-%02d-01', $sel_year, (int)$sel_month)); ?>&tab=<?php echo $active_tab; ?>" class="btn btn-success">
                    <i class="fa fa-money mr-1"></i> Salary Payment
                </a>
            </div>
        </div>

        <!-- Attendance Tabs -->
        <div class="att-tab-nav">
            <a class="att-tab-link <?php echo $active_tab === 'monthly' ? 'active' : ''; ?>" href="attendance_details.php?tab=monthly&month=<?php echo $sel_month; ?>&year=<?php echo $sel_year; ?>">
                <i class="fa fa-calendar mr-1"></i> Monthly Attendance <span class="badge badge-pill badge-primary ml-1" style="font-size:11px;"><?php echo $cnt_monthly; ?></span>
            </a>
            <a class="att-tab-link <?php echo $active_tab === 'weekly' ? 'active' : ''; ?>" href="attendance_details.php?tab=weekly&week_date=<?php echo htmlspecialchars($week_date); ?>">
                <i class="fa fa-calendar-minus-o mr-1"></i> Weekly Attendance <span class="badge badge-pill badge-info ml-1" style="font-size:11px;"><?php echo $cnt_weekly; ?></span>
            </a>
        </div>

        <!-- ========================================== -->
        <!-- TAB 1: MONTHLY ATTENDANCE PANE             -->
        <!-- ========================================== -->
        <div id="pane_monthly" style="<?php echo $active_tab === 'monthly' ? '' : 'display:none;'; ?>">
            <div class="card mb-3">
                <div class="card-body py-3">
                    <form method="GET" action="attendance_details.php" class="row align-items-center">
                        <input type="hidden" name="tab" value="monthly">
                        
                        <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                            <label class="mb-1 font-weight-bold" style="font-size:12px;">Year:</label>
                            <select class="form-control" name="year" id="monthly_year" onchange="this.form.submit()">
                                <?php for ($yr = 2021; $yr <= 2040; $yr++): ?>
                                    <option value="<?php echo $yr; ?>" <?php echo ($sel_year == $yr) ? 'selected' : ''; ?>><?php echo $yr; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                            <label class="mb-1 font-weight-bold" style="font-size:12px;">Month:</label>
                            <select class="form-control" name="month" id="monthly_month" onchange="this.form.submit()">
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
                        </div>

                        <div class="col-md-8 col-sm-12 text-md-right mt-2 mt-md-0">
                            <div class="d-inline-flex flex-wrap justify-content-md-end">
                                <div class="stat-card-pill">
                                    <span class="stat-label">Monthly Staff</span>
                                    <span class="stat-value text-primary"><?php echo $cnt_monthly; ?></span>
                                </div>
                                <div class="stat-card-pill">
                                    <span class="stat-label">Calendar Days</span>
                                    <span class="stat-value"><?php echo $total_calendar_days; ?></span>
                                </div>
                                <div class="stat-card-pill" title="Sundays are editable (P/H/F) and not counted as absent">
                                    <span class="stat-label">Sundays</span>
                                    <span class="stat-value text-muted"><?php echo $monthly_sundays_count; ?></span>
                                </div>
                                <div class="stat-card-pill" title="Days marked Holiday this month">
                                    <span class="stat-label">Holidays</span>
                                    <span class="stat-value" style="color:#be185d;"><?php echo $monthly_holiday_count; ?></span>
                                </div>
                                <div class="stat-card-pill" title="Working days excluding Sundays">
                                    <span class="stat-label">Working Days</span>
                                    <span class="stat-value text-success"><?php echo $monthly_working_days_count; ?></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Monthly Attendance Table -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="attendance-matrix-wrapper">
                        <table class="attendance-matrix-table" id="table_monthly">
                            <thead>
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <th class="col-sticky-emp">Employee Name</th>
                                    <?php foreach ($monthly_working_dates as $wdate): ?>
                                        <th title="<?php echo $wdate['date']; ?>" style="min-width:105px;padding:6px 4px;<?php echo $wdate['is_sunday'] ? 'background:#334155;color:#94a3b8;' : ''; ?>">
                                            <div style="font-weight:700;font-size:12px;margin-bottom:3px;"><?php echo $wdate['label']; ?></div>
                                            <select class="bulk-day-setter" data-date="<?php echo $wdate['date']; ?>" data-table="monthly" title="Bulk update visible staff for <?php echo $wdate['label']; ?>" style="width:100%;height:22px;padding:1px 2px;font-size:10px;font-weight:700;border-radius:4px;background:#1e293b;color:#f8fafc;border:1px solid #475569;cursor:pointer;">
                                                <option value="" selected disabled>⚡ Bulk Set</option>
                                                <option value="Present">✓ All Present</option>
                                                <?php if (!$wdate['is_sunday']): ?><option value="Absent">✗ All Absent</option><?php endif; ?>
                                                <option value="Halfday">◐ All Halfday</option>
                                                <option value="Festival">★ All Festival</option>
                                                <option value="Holiday">☀ All Holiday</option>
                                                <option value="CLEAR">⟲ Clear All</option>
                                            </select>
                                        </th>
                                    <?php endforeach; ?>
                                    <th style="background:#0f766e;color:#fff;" title="Total Present Days">P</th>
                                    <th style="background:#be123c;color:#fff;" title="Total Absent Days">A</th>
                                    <th style="background:#b45309;color:#fff;" title="Total Half Days">H</th>
                                    <th style="background:#4338ca;color:#fff;" title="Total Festival / Holidays">F</th>
                                    <th style="background:#1e3a8a;color:#fff;min-width:90px;" title="Present + Festival + (Halfday * 0.5)">Payable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (empty($monthly_employees)): 
                                ?>
                                    <tr>
                                        <td colspan="<?php echo count($monthly_working_dates) + 7; ?>" class="text-center py-4 text-muted">
                                            No monthly employees found.
                                        </td>
                                    </tr>
                                <?php 
                                else: 
                                    $sno = 1;
                                    foreach ($monthly_employees as $emp):
                                        $eid = (int)$emp['emp_id'];

                                        $row_present = 0;
                                        $row_absent = 0;
                                        $row_halfday = 0;
                                        $row_festival = 0;
                                ?>
                                    <tr id="m_row_<?php echo $eid; ?>" class="emp-row emp-row-m">
                                        <td class="text-muted font-weight-bold"><?php echo $sno++; ?></td>
                                        <td class="col-sticky-emp">
                                            <div style="font-size:13px;font-weight:600;"><?php echo htmlspecialchars($emp['emp_name']); ?></div>
                                            <span class="badge badge-primary" style="font-size:10px;padding:2px 5px;">Monthly</span>
                                        </td>
                                        <?php 
                                        foreach ($monthly_working_dates as $wdate):
                                            $dt = $wdate['date'];
                                            $val = $monthly_att_map[$eid][$dt] ?? '';

                                            // Count for initial row stats
                                            if ($val === 'Present') $row_present++;
                                            else if ($val === 'Absent') $row_absent++;
                                            else if ($val === 'Halfday') $row_halfday++;
                                            else if ($val === 'Festival' || $val === 'Holiday') $row_festival++;

                                            $st_class = '';
                                            if ($val === 'Present') $st_class = 'st-present';
                                            else if ($val === 'Absent') $st_class = 'st-absent';
                                            else if ($val === 'Halfday') $st_class = 'st-halfday';
                                            else if ($val === 'Festival') $st_class = 'st-festival';
                                            else if ($val === 'Holiday') $st_class = 'st-holiday';
                                        ?>
                                            <td class="p-1">
                                                <select class="att-select <?php echo $st_class; ?>" 
                                                        data-empid="<?php echo $eid; ?>" 
                                                        data-date="<?php echo $dt; ?>"
                                                        onchange="handleStatusChange(this)">
                                                    <option value="" <?php echo empty($val) ? 'selected' : ''; ?>>-</option>
                                                    <option value="Present" <?php echo ($val === 'Present') ? 'selected' : ''; ?>>P</option>
                                                    <?php if (!$wdate['is_sunday']): ?><option value="Absent" <?php echo ($val === 'Absent') ? 'selected' : ''; ?>>A</option><?php endif; ?>
                                                    <option value="Halfday" <?php echo ($val === 'Halfday') ? 'selected' : ''; ?>>H</option>
                                                    <option value="Festival" <?php echo ($val === 'Festival') ? 'selected' : ''; ?>>F</option>
                                                    <option value="Holiday" <?php echo ($val === 'Holiday') ? 'selected' : ''; ?>>HD</option>
                                                </select>
                                            </td>
                                        <?php endforeach; ?>

                                        <?php
                                        $payable = $row_present + $row_festival + ($row_halfday * 0.5); 
                                        ?>
                                        <td class="font-weight-bold text-success cell-stat-p"><?php echo $row_present; ?></td>
                                        <td class="font-weight-bold text-danger cell-stat-a"><?php echo $row_absent; ?></td>
                                        <td class="font-weight-bold text-warning cell-stat-h"><?php echo $row_halfday; ?></td>
                                        <td class="font-weight-bold text-info cell-stat-f"><?php echo $row_festival; ?></td>
                                        <td class="font-weight-bold text-primary cell-stat-pay" style="background:#f0fdfa;font-size:14px;"><?php echo $payable; ?></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: WEEKLY ATTENDANCE PANE              -->
        <!-- ========================================== -->
        <div id="pane_weekly" style="<?php echo $active_tab === 'weekly' ? '' : 'display:none;'; ?>">
            <div class="card mb-3">
                <div class="card-body py-3">
                    <form method="GET" action="attendance_details.php" class="row align-items-center">
                        <input type="hidden" name="tab" value="weekly">

                        <div class="col-md-5 col-sm-12 mb-2 mb-md-0 d-flex align-items-center">
                            <a href="attendance_details.php?tab=weekly&week_date=<?php echo $prev_week_date; ?>" class="btn btn-outline-secondary btn-sm mr-2" title="Previous Week">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                            <div class="flex-grow-1">
                                <label class="mb-1 font-weight-bold" style="font-size:12px;">Select Week Date:</label>
                                <input type="date" class="form-control" name="week_date" id="weekly_picker" value="<?php echo htmlspecialchars($week_date); ?>" onchange="this.form.submit()">
                            </div>
                            <a href="attendance_details.php?tab=weekly&week_date=<?php echo $next_week_date; ?>" class="btn btn-outline-secondary btn-sm ml-2" title="Next Week">
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>

                        <div class="col-md-7 col-sm-12 text-md-right mt-2 mt-md-0">
                            <div class="d-inline-flex flex-wrap justify-content-md-end">
                                <div class="stat-card-pill">
                                    <span class="stat-label">Weekly Staff</span>
                                    <span class="stat-value text-primary"><?php echo $cnt_weekly; ?></span>
                                </div>
                                <div class="stat-card-pill">
                                    <span class="stat-label">Week</span>
                                    <span class="stat-value text-primary" style="font-size:13px;"><?php echo $w_start_disp . ' - ' . $w_end_disp; ?></span>
                                </div>
                                <div class="stat-card-pill">
                                    <span class="stat-label">Working Days</span>
                                    <span class="stat-value text-success">6 Days + Sunday</span>
                                </div>
                                <div class="stat-card-pill" title="Days marked Holiday this week">
                                    <span class="stat-label">Holidays</span>
                                    <span class="stat-value" style="color:#be185d;"><?php echo $weekly_holiday_count; ?></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Weekly Attendance Table -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="attendance-matrix-wrapper">
                        <table class="attendance-matrix-table" id="table_weekly">
                            <thead>
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <th class="col-sticky-emp">Employee Name</th>
                                    <?php foreach ($weekly_days as $wkd): ?>
                                        <th style="min-width:105px;padding:6px 4px;<?php echo $wkd['is_sunday'] ? 'background:#334155;color:#94a3b8;' : ''; ?>">
                                            <div style="font-weight:700;font-size:12px;margin-bottom:3px;"><?php echo $wkd['display']; ?></div>
                                            <select class="bulk-day-setter" data-date="<?php echo $wkd['date']; ?>" data-table="weekly" title="Bulk update visible staff for <?php echo $wkd['display']; ?>" style="width:100%;height:22px;padding:1px 2px;font-size:10px;font-weight:700;border-radius:4px;background:#1e293b;color:#f8fafc;border:1px solid #475569;cursor:pointer;">
                                                <option value="" selected disabled>⚡ Bulk Set</option>
                                                <option value="Present">✓ All Present</option>
                                                <?php if (!$wkd['is_sunday']): ?><option value="Absent">✗ All Absent</option><?php endif; ?>
                                                <option value="Halfday">◐ All Halfday</option>
                                                <option value="Festival">★ All Festival</option>
                                                <option value="Holiday">☀ All Holiday</option>
                                                <option value="CLEAR">⟲ Clear All</option>
                                            </select>
                                        </th>
                                    <?php endforeach; ?>
                                    <th style="background:#0f766e;color:#fff;" title="Total Present Days">P</th>
                                    <th style="background:#be123c;color:#fff;" title="Total Absent Days">A</th>
                                    <th style="background:#b45309;color:#fff;" title="Total Half Days">H</th>
                                    <th style="background:#4338ca;color:#fff;" title="Total Festival / Holidays">F</th>
                                    <th style="background:#1e3a8a;color:#fff;min-width:90px;" title="Payable Days (P + F + 0.5*H)">Payable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (empty($weekly_employees)): 
                                ?>
                                    <tr>
                                        <td colspan="12" class="text-center py-4 text-muted">
                                            No weekly employees found.
                                        </td>
                                    </tr>
                                <?php 
                                else: 
                                    $wsno = 1;
                                    foreach ($weekly_employees as $emp):
                                        $eid = (int)$emp['emp_id'];

                                        $wrow_present = 0;
                                        $wrow_absent = 0;
                                        $wrow_halfday = 0;
                                        $wrow_festival = 0;
                                ?>
                                    <tr id="w_row_<?php echo $eid; ?>" class="emp-row emp-row-w">
                                        <td class="text-muted font-weight-bold"><?php echo $wsno++; ?></td>
                                        <td class="col-sticky-emp">
                                            <div style="font-size:13px;font-weight:600;"><?php echo htmlspecialchars($emp['emp_name']); ?></div>
                                            <span class="badge badge-info" style="font-size:10px;padding:2px 5px;">
                                                Weekly
                                            </span>
                                        </td>
                                        <?php 
                                        foreach ($weekly_days as $wkd):
                                            $dt = $wkd['date'];
                                            $is_sun = $wkd['is_sunday'];
                                            $val = $weekly_att_map[$eid][$dt] ?? '';

                                            if ($val === 'Present') $wrow_present++;
                                            else if ($val === 'Absent') $wrow_absent++;
                                            else if ($val === 'Halfday') $wrow_halfday++;
                                            else if ($val === 'Festival' || $val === 'Holiday') $wrow_festival++;

                                            $st_class = '';
                                            if ($val === 'Present') $st_class = 'st-present';
                                            else if ($val === 'Absent') $st_class = 'st-absent';
                                            else if ($val === 'Halfday') $st_class = 'st-halfday';
                                            else if ($val === 'Festival') $st_class = 'st-festival';
                                            else if ($val === 'Holiday') $st_class = 'st-holiday';
                                        ?>
                                            <td class="p-1">
                                                <select class="att-select <?php echo $st_class; ?>"
                                                        data-empid="<?php echo $eid; ?>"
                                                        data-date="<?php echo $dt; ?>"
                                                        onchange="handleStatusChange(this)">
                                                    <option value="" <?php echo empty($val) ? 'selected' : ''; ?>>-</option>
                                                    <option value="Present" <?php echo ($val === 'Present') ? 'selected' : ''; ?>>P</option>
                                                    <?php if (!$is_sun): ?><option value="Absent" <?php echo ($val === 'Absent') ? 'selected' : ''; ?>>A</option><?php endif; ?>
                                                    <option value="Halfday" <?php echo ($val === 'Halfday') ? 'selected' : ''; ?>>H</option>
                                                    <option value="Festival" <?php echo ($val === 'Festival') ? 'selected' : ''; ?>>F</option>
                                                    <option value="Holiday" <?php echo ($val === 'Holiday') ? 'selected' : ''; ?>>HD</option>
                                                </select>
                                            </td>
                                        <?php endforeach; ?>

                                        <?php 
                                        $w_payable = $wrow_present + $wrow_festival + ($wrow_halfday * 0.5); 
                                        ?>
                                        <td class="font-weight-bold text-success cell-stat-p"><?php echo $wrow_present; ?></td>
                                        <td class="font-weight-bold text-danger cell-stat-a"><?php echo $wrow_absent; ?></td>
                                        <td class="font-weight-bold text-warning cell-stat-h"><?php echo $wrow_halfday; ?></td>
                                        <td class="font-weight-bold text-info cell-stat-f"><?php echo $wrow_festival; ?></td>
                                        <td class="font-weight-bold text-primary cell-stat-pay" style="background:#f0fdfa;font-size:14px;"><?php echo $w_payable; ?></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Live Toast -->
    <div id="save_status_toast">
        <i class="fa fa-check-circle text-success mr-1"></i> <span id="toast_msg">Saved</span>
    </div>

</main>
<!-- end::main content -->

<?php include("footer.php"); ?>

<!-- Scripts -->
<script src="vendors/bundle.js"></script>
<script src="vendors/select2/js/select2.min.js"></script>
<script src="vendors/datepicker/daterangepicker.js"></script>
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>

<script>
var toastTimer = null;
function showToast(msg) {
    var $t = $("#save_status_toast");
    $("#toast_msg").text(msg);
    $t.stop(true, true).fadeIn(200);
    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(function() {
        $t.fadeOut(400);
    }, 2200);
}

// Update class and styling on select
function updateSelectClass(el) {
    var val = $(el).val();
    $(el).removeClass('st-present st-absent st-halfday st-festival st-holiday');
    if (val === 'Present') $(el).addClass('st-present');
    else if (val === 'Absent') $(el).addClass('st-absent');
    else if (val === 'Halfday') $(el).addClass('st-halfday');
    else if (val === 'Festival') $(el).addClass('st-festival');
    else if (val === 'Holiday') $(el).addClass('st-holiday');
}

// Recalculate row summary for an employee row
function recalculateRow(rowEl) {
    var p = 0, a = 0, h = 0, f = 0;
    $(rowEl).find('select.att-select').each(function() {
        var v = $(this).val();
        if (v === 'Present') p++;
        else if (v === 'Absent') a++;
        else if (v === 'Halfday') h++;
        else if (v === 'Festival' || v === 'Holiday') f++;
    });
    var pay = p + f + (h * 0.5);
    $(rowEl).find('.cell-stat-p').text(p);
    $(rowEl).find('.cell-stat-a').text(a);
    $(rowEl).find('.cell-stat-h').text(h);
    $(rowEl).find('.cell-stat-f').text(f);
    $(rowEl).find('.cell-stat-pay').text(pay);
}

// Handle auto-save on change
function handleStatusChange(el) {
    updateSelectClass(el);
    var empId = $(el).data('empid');
    var attDate = $(el).data('date');
    var status = $(el).val();
    var row = $(el).closest('tr');

    recalculateRow(row);

    // Instant AJAX save
    $.ajax({
        type: "POST",
        url: "attendance_service.php",
        dataType: 'json',
        data: {
            req: 'SAVE_CELL',
            emp_id: empId,
            date: attDate,
            status: status
        },
        success: function(resp) {
            var statusLabel = status ? status : 'Cleared';
            showToast('Saved: ' + attDate + ' → ' + statusLabel);
        },
        error: function() {
            showToast('Save failed, please check connection.');
        }
    });
}

// Batch Save button
function saveAllAttendance() {
    var entries = [];
    var visibleTable = $("#pane_monthly").is(":visible") ? $("#table_monthly") : $("#table_weekly");
    visibleTable.find('tbody tr.emp-row:visible select.att-select').each(function() {
        var empId = $(this).data('empid');
        var attDate = $(this).data('date');
        var status = $(this).val();
        if (empId && attDate) {
            entries.push({
                emp_id: empId,
                date: attDate,
                status: status
            });
        }
    });

    if (entries.length === 0) {
        swal("Info", "No attendance records to save.", "info");
        return;
    }

    $("#btn_save_all").prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Saving...');
    $.ajax({
        type: "POST",
        url: "attendance_service.php",
        dataType: 'json',
        data: {
            req: 'SAVE_BATCH',
            entries: JSON.stringify(entries)
        },
        success: function(resp) {
            $("#btn_save_all").prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Save Changes');
            swal("Success", "Attendance changes have been confirmed and saved (" + entries.length + " entries)!", "success");
        },
        error: function() {
            $("#btn_save_all").prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Save Changes');
            swal("Error", "Could not save attendance. Please try again.", "error");
        }
    });
}

// Filter employees by salary type (instant client-side toggle)

// User-friendly Day Bulk Update in Header
$(document).on('change', '.bulk-day-setter', function() {
    var $setter = $(this);
    var targetDate = $setter.data('date');
    var targetTable = $setter.data('table'); // 'monthly' or 'weekly'
    var status = $setter.val();
    if (!status) return;

    var $container = (targetTable === 'weekly') ? $("#pane_weekly") : $("#pane_monthly");
    var $visibleSelects = $container.find('tbody tr.emp-row:visible select.att-select[data-date="' + targetDate + '"]');
    var count = $visibleSelects.length;

    if (count === 0) {
        showToast('No visible employees to update.');
        $setter.val('');
        return;
    }

    var newStatusValue = (status === 'CLEAR') ? '' : status;
    var entries = [];

    $visibleSelects.each(function() {
        var empId = $(this).data('empid');
        $(this).val(newStatusValue);
        updateSelectClass(this);
        recalculateRow($(this).closest('tr'));
        entries.push({
            emp_id: empId,
            date: targetDate,
            status: newStatusValue
        });
    });

    var statusDisplay = (status === 'CLEAR') ? 'Cleared' : status;
    showToast('Saving ' + count + ' staff as ' + statusDisplay + '...');

    $.ajax({
        type: "POST",
        url: "attendance_service.php",
        dataType: 'json',
        data: {
            req: 'SAVE_BATCH',
            entries: JSON.stringify(entries)
        },
        success: function(resp) {
            showToast('✓ ' + targetDate + ': Set ' + count + ' staff to ' + statusDisplay);
        },
        error: function() {
            showToast('Batch save failed, please check connection.');
        },
        complete: function() {
            $setter.val(''); // Reset back to placeholder
        }
    });
});

$(document).ready(function() {
    $(".page-loader").hide();
});
</script>

</body>
</html>