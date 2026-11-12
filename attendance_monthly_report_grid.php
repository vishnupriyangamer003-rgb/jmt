<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
include_once("sessionservices.php");
date_default_timezone_set('Asia/Kolkata');

if (!function_exists('renderMonthlyAttendanceReport')) {
    function renderMonthlyAttendanceReport($conn, $sel_month, $sel_year) {
        $sel_month = str_pad(intval($sel_month), 2, '0', STR_PAD_LEFT);
        $sel_year = intval($sel_year);
        if ($sel_year < 2020 || $sel_year > 2050) {
            $sel_year = intval(date('Y'));
        }

        $total_calendar_days = cal_days_in_month(CAL_GREGORIAN, (int)$sel_month, $sel_year);
        $m_start_date = sprintf('%04d-%02d-01', $sel_year, (int)$sel_month);
        $m_end_date = sprintf('%04d-%02d-%02d', $sel_year, (int)$sel_month, $total_calendar_days);

        // Precompute days metadata and count Sundays
        $month_days = [];
        $monthly_sundays_count = 0;
        for ($d = 1; $d <= $total_calendar_days; $d++) {
            $date_str = sprintf('%04d-%02d-%02d', $sel_year, (int)$sel_month, $d);
            $dow = (int)date('N', strtotime($date_str)); // 1=Mon, 7=Sun
            $is_sun = ($dow === 7);
            if ($is_sun) {
                $monthly_sundays_count++;
            }
            $month_days[$d] = [
                'day' => $d,
                'date' => $date_str,
                'dow' => $dow,
                'day_name' => date('D', strtotime($date_str)),
                'is_sunday' => $is_sun
            ];
        }
        $monthly_working_days_count = max(1, $total_calendar_days - $monthly_sundays_count);

        // 1. Fetch all Monthly Staff (emp_salary_type = '1')
        $sql = "SELECT emp_id, emp_name, salary FROM tbl_employee_details WHERE delete_status='NDL' AND active_status='Y' AND emp_salary_type='1' ORDER BY emp_name ASC";
        $exec_query = mysqli_query($conn, $sql);
        $monthly_employees = [];
        if ($exec_query) {
            while ($row = mysqli_fetch_assoc($exec_query)) {
                $monthly_employees[] = $row;
            }
        }
        $cnt_monthly = count($monthly_employees);

        // 2. Fetch all attendance for this month in ONE query
        $att_map = [];
        $aq = mysqli_query($conn, "SELECT emp_id, attendance_date, attendance_status FROM tbl_attendance WHERE delete_status='NDL' AND attendance_date BETWEEN '$m_start_date' AND '$m_end_date'");
        if ($aq) {
            while ($ar = mysqli_fetch_assoc($aq)) {
                $att_map[$ar['emp_id']][$ar['attendance_date']] = $ar['attendance_status'];
            }
        }

        // 3. Fetch all paid salaries for this month in ONE query
        $paid_map = [];
        $salary_month_str = sprintf('%04d-%02d', $sel_year, (int)$sel_month);
        $pq = mysqli_query($conn, "SELECT emp_id, pay_amount FROM tbl_emp_salary WHERE delete_status='NDL' AND (salary_month='$salary_month_str' OR (MONTH(start_date)='" . (int)$sel_month . "' AND YEAR(start_date)='$sel_year'))");
        if ($pq) {
            while ($pr = mysqli_fetch_assoc($pq)) {
                $eid = (int)$pr['emp_id'];
                $val = (float)($pr['pay_amount'] ?? 0);
                $paid_map[$eid] = ($paid_map[$eid] ?? 0.0) + $val;
            }
        }

        // Daily counters across all employees
        $daily_present = array_fill(1, $total_calendar_days, 0);
        $daily_absent  = array_fill(1, $total_calendar_days, 0);
        $daily_halfday = array_fill(1, $total_calendar_days, 0);
        $daily_festival = array_fill(1, $total_calendar_days, 0);

        // Overall summary aggregates
        $grand_pres = 0;
        $grand_abs = 0;
        $grand_half = 0;
        $grand_fest = 0;
        $grand_payable_days = 0;
        $grand_salary = 0.0;
        $grand_paid = 0.0;
        $grand_balance = 0.0;

        // Column width math:
        // # (42px) + Staff Name (190px) + Monthly Salary (105px) = 337px
        // Days: $total_calendar_days * 34px (31 * 34 = 1054px)
        // Metrics: P(38) + A(38) + HD(38) + F(38) + Payable(80) + Earned(105) + Paid(100) + Balance(105) = 542px
        // Total width: 337 + ($total_calendar_days * 34) + 542 = 879 + ($total_calendar_days * 34)
        $total_table_width = 879 + ($total_calendar_days * 34);

        // Avatar color palette
        $avatar_colors = ['#2563eb', '#7c3aed', '#db2777', '#059669', '#d97706', '#0891b2', '#4f46e5', '#dc2626'];

        // Build HTML
        $html = '';
        $html .= '<div class="monthly-table-wrapper shadow-sm" style="overflow-x: auto; overflow-y: visible; max-height: none; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; position: relative;">';
        $html .= '<table id="monthly_attendance_table" class="table mb-0 text-center" style="width: ' . $total_table_width . 'px; min-width: ' . $total_table_width . 'px; table-layout: fixed; border-collapse: separate; border-spacing: 0; font-size: 12px;">';
        
        // Colgroup to enforce exact pixel widths across all browser rendering engines
        $html .= '<colgroup>';
        $html .= '<col style="width: 42px;">';  // #
        $html .= '<col style="width: 190px;">'; // Staff Name
        $html .= '<col style="width: 105px;">'; // Monthly Salary
        for ($d = 1; $d <= $total_calendar_days; $d++) {
            $html .= '<col style="width: 34px;">'; // Days
        }
        $html .= '<col style="width: 38px;">';  // P
        $html .= '<col style="width: 38px;">';  // A
        $html .= '<col style="width: 38px;">';  // HD
        $html .= '<col style="width: 38px;">';  // F
        $html .= '<col style="width: 80px;">';  // Payable Days
        $html .= '<col style="width: 105px;">'; // Earned Salary
        $html .= '<col style="width: 100px;">'; // Tot. Paid
        $html .= '<col style="width: 105px;">'; // Balance
        $html .= '</colgroup>';

        // Table Header
        $html .= '<thead style="position: sticky; top: 0; z-index: 20; background: #0f172a;">';
        $html .= '<tr style="height: 50px;">';
        
        // Sticky Left Headers
        $html .= '<th class="sticky-corner-1" style="width: 42px; position: sticky; left: 0; top: 0; z-index: 30; background: #0f172a; color: #ffffff; border-right: 1px solid #334155; border-bottom: 2px solid #334155; vertical-align: middle; padding: 4px 2px; font-weight: 700;">#</th>';
        $html .= '<th class="sticky-corner-2" style="width: 190px; position: sticky; left: 42px; top: 0; z-index: 30; background: #0f172a; color: #ffffff; border-right: 2px solid #475569; border-bottom: 2px solid #334155; vertical-align: middle; text-align: left; padding: 4px 12px; font-weight: 700; box-shadow: 4px 0 8px -2px rgba(0,0,0,0.25);">Staff Name</th>';
        $html .= '<th style="width: 105px; position: sticky; top: 0; z-index: 20; background: #0f172a; color: #ffffff; border-right: 1px solid #334155; border-bottom: 2px solid #334155; vertical-align: middle; text-align: right; padding: 4px 10px; font-weight: 700;">Monthly Salary</th>';

        // 01 to 31 Day Headers
        for ($d = 1; $d <= $total_calendar_days; $d++) {
            $day_info = $month_days[$d];
            $is_sun = $day_info['is_sunday'];
            $th_bg = $is_sun ? 'background: #0284c7; color: #ffffff; border-color: #0369a1;' : 'background: #1e293b; color: #f8fafc; border-color: #334155;';
            $html .= '<th style="width: 34px; position: sticky; top: 0; z-index: 20; padding: 4px 1px; ' . $th_bg . ' border-right: 1px solid #334155; border-bottom: 2px solid #334155; vertical-align: middle;" title="' . $day_info['date'] . ' (' . $day_info['day_name'] . ')">';
            $html .= '<div style="font-size: 12px; font-weight: 700; line-height: 1.1;">' . sprintf('%02d', $d) . '</div>';
            $html .= '<div style="font-size: 9px; opacity: 0.9; font-weight: 600; text-transform: uppercase;">' . substr($day_info['day_name'], 0, 3) . '</div>';
            $html .= '</th>';
        }

        // Summary Metric Headers
        $html .= '<th style="width: 38px; position: sticky; top: 0; z-index: 20; background: #065f46; color: #ffffff; border-left: 2px solid #047857; border-right: 1px solid #047857; border-bottom: 2px solid #047857; vertical-align: middle; padding: 4px 1px;" title="Present Days">P</th>';
        $html .= '<th style="width: 38px; position: sticky; top: 0; z-index: 20; background: #991b1b; color: #ffffff; border-right: 1px solid #b91c1c; border-bottom: 2px solid #b91c1c; vertical-align: middle; padding: 4px 1px;" title="Absent Days">A</th>';
        $html .= '<th style="width: 38px; position: sticky; top: 0; z-index: 20; background: #92400e; color: #ffffff; border-right: 1px solid #b45309; border-bottom: 2px solid #b45309; vertical-align: middle; padding: 4px 1px;" title="Half Days">HD</th>';
        $html .= '<th style="width: 38px; position: sticky; top: 0; z-index: 20; background: #3730a3; color: #ffffff; border-right: 1px solid #4338ca; border-bottom: 2px solid #4338ca; vertical-align: middle; padding: 4px 1px;" title="Festival / Holiday Days">F</th>';
        $html .= '<th style="width: 80px; position: sticky; top: 0; z-index: 20; background: #1e3a8a; color: #ffffff; border-right: 1px solid #1e40af; border-bottom: 2px solid #1e40af; vertical-align: middle; padding: 4px 2px; font-weight: 700;" title="Payable Days = Present + Festival + (Halfday * 0.5)">Payable Days</th>';
        $html .= '<th style="width: 105px; position: sticky; top: 0; z-index: 20; background: #0f172a; color: #ffffff; border-right: 1px solid #334155; border-bottom: 2px solid #334155; vertical-align: middle; text-align: right; padding: 4px 8px; font-weight: 700;">Earned Salary</th>';
        $html .= '<th style="width: 100px; position: sticky; top: 0; z-index: 20; background: #0f172a; color: #ffffff; border-right: 1px solid #334155; border-bottom: 2px solid #334155; vertical-align: middle; text-align: right; padding: 4px 8px; font-weight: 700;">Tot. Paid</th>';
        $html .= '<th style="width: 105px; position: sticky; top: 0; z-index: 20; background: #0f172a; color: #ffffff; border-bottom: 2px solid #334155; vertical-align: middle; text-align: right; padding: 4px 8px; font-weight: 700;">Balance</th>';
        $html .= '</tr>';
        $html .= '</thead>';

        // Table Body
        $html .= '<tbody style="background: #ffffff;">';
        if (empty($monthly_employees)) {
            $html .= '<tr><td colspan="' . ($total_calendar_days + 11) . '" class="text-center text-muted p-5 font-weight-bold">No active monthly-salary staff found</td></tr>';
        } else {
            $sno = 1;
            foreach ($monthly_employees as $emp) {
                $eid = (int)$emp['emp_id'];
                $emp_name = $emp['emp_name'];
                $salary = (float)($emp['salary'] ?? 0);

                $pres = 0; $abs = 0; $half = 0; $fest = 0;

                $initial = strtoupper(mb_substr($emp_name, 0, 1));
                $avatar_bg = $avatar_colors[$eid % count($avatar_colors)];

                $html .= '<tr class="emp-report-row" data-emp-name="' . htmlspecialchars(strtolower($emp_name)) . '" style="height: 38px;">';
                
                // Sticky S.No
                $html .= '<td class="col-monthly-num" style="width: 42px; position: sticky; left: 0; z-index: 10; background: #f8fafc; font-weight: 700; color: #64748b; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; padding: 4px 2px;">' . $sno++ . '</td>';
                
                // Sticky Staff Name with Avatar
                $html .= '<td class="col-monthly-emp" style="width: 190px; position: sticky; left: 42px; z-index: 10; background: #ffffff; border-right: 2px solid #cbd5e1; border-bottom: 1px solid #e2e8f0; padding: 4px 10px; vertical-align: middle; box-shadow: 4px 0 8px -2px rgba(0,0,0,0.08);">';
                $html .= '<div style="display: flex; align-items: center; gap: 8px;">';
                $html .= '<span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; background: ' . $avatar_bg . '; color: #ffffff; font-weight: 700; font-size: 11px; flex-shrink: 0;">' . $initial . '</span>';
                $html .= '<span style="font-weight: 700; text-align: left; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . htmlspecialchars($emp_name) . '">' . htmlspecialchars($emp_name) . '</span>';
                $html .= '</div>';
                $html .= '</td>';
                
                // Monthly Salary
                $html .= '<td style="width: 105px; text-align: right; padding-right: 10px; font-weight: 600; color: #334155; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; font-size: 12px; font-variant-numeric: tabular-nums;">₹' . number_format($salary, 2, '.', '') . '</td>';

                // Days Loop
                for ($d = 1; $d <= $total_calendar_days; $d++) {
                    $day_info = $month_days[$d];
                    $date_str = $day_info['date'];

                    if ($day_info['is_sunday']) {
                        // Sunday Weekly Off
                        $html .= '<td style="width: 34px; background: #f0f9ff; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; padding: 2px 1px;" title="' . $date_str . ' (Sunday Off)">';
                        $html .= '<span style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 22px; border-radius: 4px; background: #e0f2fe; color: #0284c7; font-weight: 700; font-size: 9.5px; border: 1px solid #bae6fd;">Off</span>';
                        $html .= '</td>';
                    } else {
                        $st = $att_map[$eid][$date_str] ?? '';
                        if ($st === 'Present') {
                            $pres++;
                            $daily_present[$d]++;
                            $html .= '<td style="width: 34px; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; padding: 2px 1px;" title="' . $date_str . ' (Present)">';
                            $html .= '<span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 6px; background: #dcfce7; color: #15803d; font-weight: 700; font-size: 11px; border: 1px solid #86efac;">P</span>';
                            $html .= '</td>';
                        } else if ($st === 'Absent') {
                            $abs++;
                            $daily_absent[$d]++;
                            $html .= '<td style="width: 34px; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; padding: 2px 1px;" title="' . $date_str . ' (Absent)">';
                            $html .= '<span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 6px; background: #fee2e2; color: #b91c1c; font-weight: 700; font-size: 11px; border: 1px solid #fca5a5;">A</span>';
                            $html .= '</td>';
                        } else if ($st === 'Halfday') {
                            $half++;
                            $daily_halfday[$d]++;
                            $html .= '<td style="width: 34px; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; padding: 2px 1px;" title="' . $date_str . ' (Half Day)">';
                            $html .= '<span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 6px; background: #fef3c7; color: #b45309; font-weight: 700; font-size: 9.5px; border: 1px solid #fde68a;">HD</span>';
                            $html .= '</td>';
                        } else if ($st === 'Festival') {
                            $fest++;
                            $daily_festival[$d]++;
                            $html .= '<td style="width: 34px; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; padding: 2px 1px;" title="' . $date_str . ' (Festival / Holiday)">';
                            $html .= '<span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 6px; background: #e0e7ff; color: #4338ca; font-weight: 700; font-size: 11px; border: 1px solid #c7d2fe;">F</span>';
                            $html .= '</td>';
                        } else {
                            $html .= '<td style="width: 34px; color: #cbd5e1; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; padding: 2px 1px; font-size: 13px; font-weight: 600;">-</td>';
                        }
                    }
                }

                // Calculations
                $payable_days = $pres + $fest + ($half * 0.5);
                $daily_rate = $monthly_working_days_count > 0 ? ($salary / $monthly_working_days_count) : 0;
                $earned_salary = round($payable_days * $daily_rate, 2);
                $tot_paid = (float)($paid_map[$eid] ?? 0);
                $balance = $earned_salary - $tot_paid;

                $grand_pres += $pres;
                $grand_abs += $abs;
                $grand_half += $half;
                $grand_fest += $fest;
                $grand_payable_days += $payable_days;
                $grand_salary += $earned_salary;
                $grand_paid += $tot_paid;
                $grand_balance += $balance;

                // Summary Data Columns
                $html .= '<td style="width: 38px; font-weight: 700; background: #f0fdf4; color: #16a34a; border-left: 2px solid #86efac; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle;">' . $pres . '</td>';
                $html .= '<td style="width: 38px; font-weight: 700; background: #fef2f2; color: #dc2626; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle;">' . $abs . '</td>';
                $html .= '<td style="width: 38px; font-weight: 700; background: #fffbeb; color: #d97706; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle;">' . $half . '</td>';
                $html .= '<td style="width: 38px; font-weight: 700; background: #eef2ff; color: #4f46e5; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle;">' . $fest . '</td>';
                $html .= '<td style="width: 80px; font-weight: 800; background: #e0f2fe; color: #0369a1; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; font-size: 13px;">' . $payable_days . '</td>';
                $html .= '<td style="width: 105px; font-weight: 700; color: #0f172a; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; text-align: right; padding-right: 8px; font-size: 12px; font-variant-numeric: tabular-nums;">₹' . number_format($earned_salary, 2, '.', '') . '</td>';
                $html .= '<td style="width: 100px; font-weight: 700; color: #16a34a; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; vertical-align: middle; text-align: right; padding-right: 8px; font-size: 12px; font-variant-numeric: tabular-nums;">₹' . number_format($tot_paid, 2, '.', '') . '</td>';
                $bal_color = ($balance > 0) ? '#dc2626' : (($balance < 0) ? '#d97706' : '#16a34a');
                $html .= '<td style="width: 105px; font-weight: 800; color: ' . $bal_color . '; border-bottom: 1px solid #e2e8f0; vertical-align: middle; text-align: right; padding-right: 8px; font-size: 12px; font-variant-numeric: tabular-nums;">₹' . number_format($balance, 2, '.', '') . '</td>';
                $html .= '</tr>';
            }
            $html .= '<tr id="no_emp_search_match" style="display:none;"><td colspan="' . ($total_calendar_days + 11) . '" class="text-center text-muted p-4"><i class="fa fa-info-circle mr-1"></i> No employees found matching "<span class="search-term-disp"></span>"</td></tr>';
        }
        $html .= '</tbody>';

        // Table Footer
        $html .= '<tfoot style="font-weight: bold; font-size: 11.5px;">';
        
        // Footer Row 1: Daily Present Total across all staff
        $html .= '<tr style="background: #ecfdf5; color: #065f46; height: 36px;">';
        $html .= '<td colspan="2" class="sticky-footer-title" style="width: 232px; position: sticky; left: 0; z-index: 12; background: #ecfdf5; text-align: right; padding-right: 12px; border-right: 2px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; font-weight: 800; box-shadow: 4px 0 8px -2px rgba(0,0,0,0.08);"><i class="fa fa-user-plus mr-1"></i> Total Present:</td>';
        $html .= '<td style="border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; color: #64748b;">-</td>';
        for ($d = 1; $d <= $total_calendar_days; $d++) {
            if ($month_days[$d]['is_sunday']) {
                $html .= '<td style="background: #e0f2fe; color: #0369a1; border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; font-size: 9.5px; font-weight: 700;">Off</td>';
            } else {
                $html .= '<td style="border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; font-weight: 700;">' . $daily_present[$d] . '</td>';
            }
        }
        $html .= '<td style="border-left: 2px solid #059669; border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; font-weight: 800; background: #dcfce7; color: #15803d;">' . $grand_pres . '</td>';
        $html .= '<td style="border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; color: #94a3b8;">-</td>';
        $html .= '<td style="border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; color: #94a3b8;">-</td>';
        $html .= '<td style="border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; color: #94a3b8;">-</td>';
        $html .= '<td style="border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; font-weight: 800; background: #e0f2fe; color: #0369a1;">' . $grand_payable_days . '</td>';
        $html .= '<td style="border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; text-align: right; padding-right: 8px;">₹' . number_format($grand_salary, 2, '.', '') . '</td>';
        $html .= '<td style="border-right: 1px solid #a7f3d0; border-bottom: 1px solid #a7f3d0; color: #16a34a; text-align: right; padding-right: 8px;">₹' . number_format($grand_paid, 2, '.', '') . '</td>';
        $fbal_color = ($grand_balance > 0) ? '#dc2626' : '#16a34a';
        $html .= '<td style="border-bottom: 1px solid #a7f3d0; color: ' . $fbal_color . '; text-align: right; padding-right: 8px;">₹' . number_format($grand_balance, 2, '.', '') . '</td>';
        $html .= '</tr>';

        // Footer Row 2: Daily Absent Total across all staff
        $html .= '<tr style="background: #fff1f2; color: #9f1239; height: 36px;">';
        $html .= '<td colspan="2" class="sticky-footer-title" style="width: 232px; position: sticky; left: 0; z-index: 12; background: #fff1f2; text-align: right; padding-right: 12px; border-right: 2px solid #fecdd3; border-bottom: 1px solid #fecdd3; font-weight: 800; box-shadow: 4px 0 8px -2px rgba(0,0,0,0.08);"><i class="fa fa-user-times mr-1"></i> Total Absent:</td>';
        $html .= '<td style="border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; color: #64748b;">-</td>';
        for ($d = 1; $d <= $total_calendar_days; $d++) {
            if ($month_days[$d]['is_sunday']) {
                $html .= '<td style="background: #e0f2fe; color: #0369a1; border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; font-size: 9.5px; font-weight: 700;">Off</td>';
            } else {
                $html .= '<td style="border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; font-weight: 700;">' . $daily_absent[$d] . '</td>';
            }
        }
        $html .= '<td style="border-left: 2px solid #dc2626; border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; color: #94a3b8;">-</td>';
        $html .= '<td style="border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; font-weight: 800; background: #fee2e2; color: #b91c1c;">' . $grand_abs . '</td>';
        $html .= '<td style="border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; color: #94a3b8;">-</td>';
        $html .= '<td style="border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; color: #94a3b8;">-</td>';
        $html .= '<td style="border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; color: #94a3b8;">-</td>';
        $html .= '<td style="border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; color: #94a3b8;">-</td>';
        $html .= '<td style="border-right: 1px solid #fecdd3; border-bottom: 1px solid #fecdd3; color: #94a3b8;">-</td>';
        $html .= '<td style="border-bottom: 1px solid #fecdd3; color: #94a3b8;">-</td>';
        $html .= '</tr>';

        // Footer Row 3: Grand Summary Totals
        // Colspan: 2 (No + Name) + ($total_calendar_days + 1 for Salary + Days) + 8 Summary metrics = $total_calendar_days + 11
        $html .= '<tr style="background: #0f172a; color: #ffffff; height: 42px;">';
        $html .= '<td colspan="2" class="sticky-footer-title" style="width: 232px; position: sticky; left: 0; z-index: 12; background: #0f172a; color: #ffffff; text-align: right; padding-right: 12px; font-weight: 800; letter-spacing: 0.5px; border-right: 2px solid #475569; font-size: 12px; box-shadow: 4px 0 8px -2px rgba(0,0,0,0.25);">';
        $html .= 'GRAND TOTALS:';
        $html .= '</td>';
        $html .= '<td colspan="' . ($total_calendar_days + 1) . '" style="background: #1e293b; color: #94a3b8; font-weight: 600; border-right: 2px solid #334155; font-size: 11.5px; text-align: center;">';
        $html .= '<span class="text-white font-weight-bold mr-3"><i class="fa fa-users text-primary mr-1"></i> Staff: ' . $cnt_monthly . '</span>';
        $html .= '<span class="mr-3"><i class="fa fa-briefcase text-success mr-1"></i> Working Days: ' . $monthly_working_days_count . '</span>';
        $html .= '<span><i class="fa fa-coffee text-info mr-1"></i> Sundays (Off): ' . $monthly_sundays_count . '</span>';
        $html .= '</td>';
        $html .= '<td style="background: #1e293b; color: #4ade80; font-weight: 800; border-right: 1px solid #334155; font-size: 12px;">' . $grand_pres . '</td>';
        $html .= '<td style="background: #1e293b; color: #f87171; font-weight: 800; border-right: 1px solid #334155; font-size: 12px;">' . $grand_abs . '</td>';
        $html .= '<td style="background: #1e293b; color: #fbbf24; font-weight: 800; border-right: 1px solid #334155; font-size: 12px;">' . $grand_half . '</td>';
        $html .= '<td style="background: #1e293b; color: #818cf8; font-weight: 800; border-right: 1px solid #334155; font-size: 12px;">' . $grand_fest . '</td>';
        $html .= '<td style="background: #1e293b; color: #38bdf8; font-weight: 800; border-right: 1px solid #334155; font-size: 12.5px;">' . $grand_payable_days . ' Days</td>';
        $html .= '<td style="background: #1e293b; color: #ffffff; font-weight: 800; border-right: 1px solid #334155; font-size: 12px; text-align: right; padding-right: 8px;">₹' . number_format($grand_salary, 2, '.', '') . '</td>';
        $html .= '<td style="background: #1e293b; color: #4ade80; font-weight: 800; border-right: 1px solid #334155; font-size: 12px; text-align: right; padding-right: 8px;">₹' . number_format($grand_paid, 2, '.', '') . '</td>';
        $tot_bal_color = ($grand_balance > 0) ? '#f87171' : '#4ade80';
        $html .= '<td style="background: #1e293b; color: ' . $tot_bal_color . '; font-weight: 800; font-size: 12px; text-align: right; padding-right: 8px;">₹' . number_format($grand_balance, 2, '.', '') . '</td>';
        $html .= '</tr>';

        $html .= '</tfoot>';
        $html .= '</table>';
        $html .= '</div>';

        return [
            'status' => 'success',
            'html' => $html,
            'tot_employee' => $cnt_monthly,
            'tot_days' => $total_calendar_days,
            'tot_sundays' => $monthly_sundays_count,
            'tot_working' => $monthly_working_days_count,
            'grand_pres' => $grand_pres,
            'grand_abs' => $grand_abs,
            'grand_half' => $grand_half,
            'grand_fest' => $grand_fest,
            'grand_payable_days' => $grand_payable_days,
            'grand_salary' => $grand_salary,
            'grand_paid' => $grand_paid,
            'grand_balance' => $grand_balance
        ];
    }
}

// If accessed directly via AJAX
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$is_direct = basename($_SERVER['SCRIPT_FILENAME'] ?? '') === 'attendance_monthly_report_grid.php';

if ($is_ajax || $is_direct) {
    $sel_month = !empty($_REQUEST['select_month']) ? $_REQUEST['select_month'] : (!empty($_REQUEST['month']) ? $_REQUEST['month'] : date('m'));
    $sel_year  = !empty($_REQUEST['select_year']) ? $_REQUEST['select_year'] : (!empty($_REQUEST['year']) ? $_REQUEST['year'] : date('Y'));

    $res = renderMonthlyAttendanceReport($conn, $sel_month, $sel_year);
    $res['attendance_bind'] = $res['html'];

    header("Content-Type: application/json", true);
    echo json_encode($res);
    exit;
}
?>
