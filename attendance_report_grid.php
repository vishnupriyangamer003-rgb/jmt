<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php 
include_once("sessionservices.php");
date_default_timezone_set('Asia/Kolkata');	

$select_week = $_POST['select_week'] ?? date('d/m/Y');

$dt = DateTime::createFromFormat('d/m/Y', $select_week);
if (!$dt) {
	$dt = DateTime::createFromFormat('Y-m-d', $select_week);
}
if (!$dt) {
	$dt = new DateTime();
}
$order_date = $dt->format('Y-m-d');

$ts = strtotime($order_date);
$year = date('o', $ts);
$week = date('W', $ts);

$start_date = strtotime($year.'W'.$week.'1');
$end_date = strtotime($year.'W'.$week.'7');

$start_date1 = date("Y-m-d", $start_date);
$end_date1 = date("Y-m-d", $end_date);

$html = "";
$html .= '<table id="weekly_attendance_table" class="table table-bordered table-striped" style="width:100%;text-align:center;margin-bottom:0;border-collapse:separate;border-spacing:0;">
        <thead style="background:#f8fafc;color:#1e293b;">
        <tr>
            <th style="width:40px;position:sticky;left:0;z-index:3;background:#f8fafc;">No</th>
            <th class="name sticky-emp-col" style="width:160px;text-align:left;position:sticky;left:40px;z-index:3;background:#f8fafc;padding-left:10px;">Name</th>
            <th class="name" style="width:100px;">Daily Wage</th>';

            for ($i = 1; $i <= 7; $i++) {
                $day_ts = strtotime($year.'W'.$week.$i);
                $is_sun = ($i == 7);
                $bg_th = $is_sun ? 'background:#e0f2fe;color:#0369a1;' : '';
                $html .= '<th style="' . $bg_th . '">' . date("d/m", $day_ts) . '<br><small>' . date("D", $day_ts) . '</small></th>';
            }

$html .=  '<th class="name" style="width:90px;">Worked Days</th>
            <th class="name" style="width:95px;">Tot.Salary</th>
			<th class="name" style="width:95px;">Tot.Paid</th>
			<th class="name" style="width:95px;">Balance</th>
        </tr>
        </thead>';
$html .= '<tbody>';

$sql = "select * from tbl_employee_details where delete_status!='0' and active_status='Y' and emp_salary_type='2' order by emp_id desc";
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

        // Fetch attendance map for this employee in the selected week
        $att_map = [];
        $aq = mysqli_query($conn, "SELECT attendance_date, attendance_status FROM tbl_attendance WHERE delete_status!='0' AND emp_id='$emp_id' AND attendance_date BETWEEN '$start_date1' AND '$end_date1'");
        if ($aq) {
            while ($ar = mysqli_fetch_assoc($aq)) {
                $att_map[$ar['attendance_date']] = $ar['attendance_status'];
            }
        }

        $pres = 0; $abs = 0; $half = 0; $fest = 0;

        $html .= '<tr class="weekly-emp-row" data-emp-name="' . htmlspecialchars(strtolower($emp_name)) . '">';
        $html .= '<td style="font-weight:bold;position:sticky;left:0;z-index:2;background:#fff;">' . ($j + 1) . '</td>';
        $html .= '<td class="sticky-emp-col" style="font-weight:bold;text-align:left;color:#0f172a;position:sticky;left:40px;z-index:2;background:#fff;padding-left:10px;">' . htmlspecialchars($emp_name) . '</td>'; 
        $html .= '<td style="font-weight:bold;">' . htmlspecialchars($fetch['salary']) . '</td>';   

        for ($z = 1; $z <= 7; $z++) { 
            $day_ts = strtotime($year.'W'.$week.$z);
            $day_str = date('Y-m-d', $day_ts);

            if ($z == 7) {
                // Sunday is weekly off
                $html .= '<td style="background:#e0f2fe;color:#0369a1;font-weight:600;font-size:11px;">Off</td>';
            } else {
                $st = $att_map[$day_str] ?? '';
                if ($st === 'Present') {
                    $pres++;
                    $html .= '<td style="color:#16a34a;font-weight:bold;" title="Present">P</td>';
                } else if ($st === 'Absent') {
                    $abs++;
                    $html .= '<td style="color:#dc2626;font-weight:bold;" title="Absent">A</td>';
                } else if ($st === 'Halfday') {
                    $half++;
                    $html .= '<td style="color:#d97706;font-weight:bold;" title="Halfday">HD</td>';
                } else if ($st === 'Festival') {
                    $fest++;
                    $html .= '<td style="color:#2563eb;font-weight:bold;" title="Festival">F</td>';
                } else {
                    $html .= '<td style="color:#94a3b8;">-</td>';
                }
            }
        }

        $worked_days = $pres + $fest + ($half * 0.5);
        $tot_sal = round($worked_days * $salary, 2);

        $salary_sql1 = "select COALESCE(sum(pay_amount),0) as total_amount from tbl_emp_hour_salary where delete_status!='0' and emp_id='$emp_id' and start_date = '$start_date1' and end_date='$end_date1'";
        $salary_query_sql1 = mysqli_query($conn, $salary_sql1);
        $fetch_salary = $salary_query_sql1 ? mysqli_fetch_assoc($salary_query_sql1) : ['total_amount' => 0];
        $tot_paid = (float)($fetch_salary['total_amount'] ?? 0);
        $balance = $tot_sal - $tot_paid;

        $grand_salary += $tot_sal;
        $grand_paid += $tot_paid;
        $grand_balance += $balance;

        $html .= '<td style="font-weight:bold;background:#f0fdfa;">' . $worked_days . '</td>';
        $html .= '<td style="font-weight:bold;">' . number_format($tot_sal, 2, '.', '') . '</td>';
        $html .= '<td style="font-weight:bold;color:#16a34a;">' . number_format($tot_paid, 2, '.', '') . '</td>';
        $html .= '<td style="font-weight:bold;' . ($balance > 0 ? 'color:#dc2626;' : 'color:#16a34a;') . '">' . number_format($balance, 2, '.', '') . '</td>';
        $html .= '</tr>';
        $j++;
    }
}

if ($j === 0) {
    $html .= '<tr><td colspan="14" class="text-center text-muted p-3">No active weekly-wage employees found</td></tr>';
}
$html .= '<tr id="no_weekly_search_match" style="display:none;"><td colspan="14" class="text-center text-muted p-4"><i class="fa fa-info-circle mr-1"></i> No staff found matching "<span class="weekly-search-term-disp"></span>"</td></tr>';
$html .= '</tbody>';
$html .= '<tfoot>
    <tr style="background:#f1f5f9;font-weight:bold;">
        <th colspan="10" style="text-align:right;">Total:</th>
        <th>' . number_format($grand_salary, 2, '.', '') . '</th>
        <th>' . number_format($grand_paid, 2, '.', '') . '</th>
        <th style="' . ($grand_balance > 0 ? 'color:#dc2626;' : 'color:#16a34a;') . '">' . number_format($grand_balance, 2, '.', '') . '</th>
    </tr>
</tfoot>';
$html .= '</table>';

$json = array("attendance_bind" => $html, "attendance_bind1" => "", "attendance_bind2" => "");

header("Content-Type: application/json", true);
echo json_encode($json);
?>