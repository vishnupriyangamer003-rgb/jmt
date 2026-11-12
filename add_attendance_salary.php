<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Spares)</title>
    <link rel="icon" type="image/png" href="userdata/images/favicon.png">

     <!-- begin::global styles -->
	 <link rel="stylesheet" href="vendors/bundle.css" type="text/css">
    <!-- end::global styles -->

    <!-- begin::datepicker -->
    <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <!-- begin::datepicker -->

    <!-- begin::vmap -->
    <link rel="stylesheet" href="vendors/vmap/jqvmap.min.css">
    <!-- begin::vmap -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="css/app.min.css" type="text/css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- end::custom styles -->

</head>
<body>
<style>
		.no-wrap{
			word-break: break-all;
		}
		</style>
<?php include('sessionservices.php');?>
<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading ...</span>
</div>
<!-- end::page loader -->

<?php echo $header;?>

<style>
	#tablemainbind{

		padding: 0.2rem!important;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 36px;
}
	/* Salary sheets: sticky header + print */
	.salary-grid thead th{
		position: sticky;
		top: 0;
		background: #f1f5f9;
		z-index: 2;
	}
	@media print{
		.no-print, .nav-tabs, .page-loader, .side-menu, .navbar{ display:none !important; }
		.main-content{ margin:0 !important; padding:0 !important; }
	}
	</style>
<!-- begin::main content -->
<main class="main-content">
<?php
    $salary_date = !empty($_GET['salary_date']) ? mysqli_real_escape_string($conn, trim($_GET['salary_date'])) : date('Y-m-d');
    $cur_date = $salary_date;
    $sel_month_display = date('F Y', strtotime($salary_date));
    $days_in_month = (int)date('t', strtotime($salary_date));
    $m_year = date('Y', strtotime($salary_date));
    $m_month = date('m', strtotime($salary_date));
    $monthly_sundays = 0;
    for ($d = 1; $d <= $days_in_month; $d++) {
        if (date('N', strtotime("$m_year-$m_month-" . sprintf('%02d', $d))) == 7) {
            $monthly_sundays++;
        }
    }
    $monthly_working_days = $days_in_month - $monthly_sundays;
    if ($monthly_working_days <= 0) $monthly_working_days = 1;

    $sql_exist_sal = "select payment_mode, remarks from tbl_emp_salary where MONTH(start_date) = MONTH('$cur_date') and YEAR(start_date) = YEAR('$cur_date') and delete_status='NDL' limit 1";
    $exec_exist_sal = mysqli_query($conn, $sql_exist_sal);
    $fetch_exist_sal = ($exec_exist_sal && mysqli_num_rows($exec_exist_sal) > 0) ? mysqli_fetch_assoc($exec_exist_sal) : null;
    $existing_payment_mode = $fetch_exist_sal['payment_mode'] ?? 'Cash';
    $existing_remarks = $fetch_exist_sal['remarks'] ?? '';

    // Weekly tab state (ISO Mon-Sun week containing week_date)
    $active_tab = (($_GET['tab'] ?? '') === 'weekly') ? 'weekly' : 'monthly';
    $week_date = !empty($_GET['week_date']) ? mysqli_real_escape_string($conn, trim($_GET['week_date'])) : date('Y-m-d');
    $wts = strtotime($week_date); if(!$wts){ $wts = time(); $week_date = date('Y-m-d'); }
    $wyear = date('o', $wts); $wweek = date('W', $wts);
    $week_start = date('Y-m-d', strtotime($wyear.'W'.$wweek.'1'));
    $week_end = date('Y-m-d', strtotime($wyear.'W'.$wweek.'7'));
    $week_display = date('d/m/Y', strtotime($week_start)).' - '.date('d/m/Y', strtotime($week_end));
?>

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4> Add Salary - <span style="color:#2ea3f5;"><?php echo $sel_month_display; ?></span></h4>
            <div class="d-flex align-items-center">
                <label class="mb-0 mr-2 font-weight-bold">Select Date / Month:</label>
                <input type="date" id="salary_date_picker" class="form-control" style="width:170px;display:inline-block;" value="<?php echo date('Y-m-d', strtotime($salary_date)); ?>" onchange="changeSalaryMonth(this.value)">
            </div>
        </div>
    </div>
	<ul class="nav nav-tabs" style="margin-bottom:15px;border-bottom:2px solid #e2e8f0;">
		<li class="nav-item">
			<a class="nav-link <?php echo $active_tab=='monthly'?'active':''; ?>" href="add_attendance_salary.php?salary_date=<?php echo htmlspecialchars($salary_date); ?>" style="<?php echo $active_tab=='monthly'?'font-weight:bold;border-bottom:3px solid #16a34a;':''; ?>">Monthly Salary</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?php echo $active_tab=='weekly'?'active':''; ?>" href="add_attendance_salary.php?salary_date=<?php echo htmlspecialchars($salary_date); ?>&tab=weekly&week_date=<?php echo htmlspecialchars($week_date); ?>" style="<?php echo $active_tab=='weekly'?'font-weight:bold;border-bottom:3px solid #16a34a;':''; ?>">Weekly Salary</a>
		</li>
	</ul>
	<div class="row" id="pane-monthly" style="<?php echo $active_tab=='weekly'?'display:none;':''; ?>">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">	
						
					<input type="hidden" name="salary_date" id="salary_date" value="<?php echo htmlspecialchars($salary_date); ?>">

							<!--div class="row">
								<div class="col-md-6">
									<div class="input-block">
									<input type="text" id="attendance_date" class="form-control" placeholder="Date" name="attendance_date" >

									
										<span class="placeholder">
										Attedance Date
										</span>
									</div>
								
								</div>
								<?php



									$sql_present= "select count(attendance_id) as present from tbl_attendance where attendance_date='".date('Y-m-d')."' and delete_status='NDL'and attendance_status='Present' GROUP BY attendance_status";
									$exec_query_present=mysqli_query($conn, $sql_present);
									$fetch_present=mysqli_fetch_assoc($exec_query_present);
									$sql_absent="select count(attendance_id) as absent from tbl_attendance where attendance_date='".date('Y-m-d')."' and delete_status='NDL'and attendance_status='Absent' GROUP BY attendance_status";
									$exec_query_absent=mysqli_query($conn, $sql_absent);
									$fetch_absent=mysqli_fetch_assoc($exec_query_absent);

									if(!empty($fetch_present['present'])){ $present=$fetch_present['present']; }else{ $present=0; }
									if(!empty($fetch_absent['absent'])){ $absent=$fetch_absent['absent']; }else{ $absent=0; }

								?>
								<div class="col-sm-6">								
										<span>Tot.Present : <span style="color:green;font-weight:bold; font-size:25px;" id="total_present"><?php echo $present; ?></span>	</span>
										<span style="margin-left:0px;">&nbsp;&nbsp; Tot.Absent: <span style="color:red;font-weight:bold;font-size:25px;" id="total_absent"><?php echo $absent; ?></span>	</span>
								</div>
								
								
							</div-->
							
						<div class="row" style="margin-top:20px;">
							<div class="col-sm-12">
								<div class="row no-print" style="margin-bottom:10px;">
									<div class="col-md-6">
										<input type="text" class="form-control" placeholder="Search staff by name..." onkeyup="filterSalaryRows(this,'tablemainbind')">
									</div>
									<div class="col-md-6 text-right">
										<button type="button" class="btn btn-info" onclick="printSalaryPane()">Print Sheet</button>
									</div>
								</div>
								<table id="detailsgrid1" class="table table-striped table-bordered salary-grid" width="100%" cellspacing="0" style="display:block;margin-bottom:0;overflow-x:scroll;border: none;">
									<thead>
										<tr>
											<th style="width: 5%;color:#000;">S.No</th>
											<th style="width: 25%;color:#000;">E.Name</th>
											<th style="width: 14%;text-align:center;color:#000;">Salary</th>
											<th style="width: 10%;text-align:center;color:#000;">Present</th>
											<th style="width: 10%;text-align:center;color:#000;">Absent</th>
											<th style="width: 10%;text-align:center;color:#000;">Half Days</th>
											<th style="width: 16%;text-align:center;color:#000;">Pay Amount</th>
										</tr>
									</thead>


									<tbody id="tablemainbind">
									<?php 



									 $employee_sql="select * from tbl_employee_details where delete_status='NDL' and active_status='Y' and emp_salary_type='1' order by emp_id desc";
										$employee_query=mysqli_query($conn,$employee_sql);
										$i=0;
										
										while($employee_fetch_results=mysqli_fetch_array($employee_query)){
											
											$emp_id = (int)$employee_fetch_results['emp_id'];

											$sql_present= "select count(t1.attendance_id) as present from tbl_attendance t1 where MONTH(t1.attendance_date) =MONTH('$cur_date') and YEAR(t1.attendance_date) =YEAR('$cur_date') and t1.emp_id=".$emp_id." and t1.attendance_status='Present' and t1.delete_status='NDL'";			
											$exec_query_present=mysqli_query($conn, $sql_present);
											$fetch_results_present=$exec_query_present ? mysqli_fetch_array($exec_query_present) : [];

											$sql_sunday= "select count(t1.attendance_id) as sunday from tbl_attendance t1 where MONTH(t1.attendance_date) =MONTH('$cur_date') and YEAR(t1.attendance_date) =YEAR('$cur_date') and t1.emp_id=".$emp_id." and t1.attendance_status='Sunday' and t1.delete_status='NDL'";			
											$exec_query_sunday=mysqli_query($conn, $sql_sunday);
											$fetch_results_sunday=$exec_query_sunday ? mysqli_fetch_array($exec_query_sunday) : [];

											$sql_absent= "select count(t1.attendance_id) as absent from tbl_attendance t1 where MONTH(t1.attendance_date) =MONTH('$cur_date') and YEAR(t1.attendance_date) =YEAR('$cur_date') and t1.emp_id=".$emp_id." and t1.attendance_status='Absent' and t1.delete_status='NDL'";			
											$exec_query_absent=mysqli_query($conn, $sql_absent);
											$fetch_results_absent=$exec_query_absent ? mysqli_fetch_array($exec_query_absent) : [];

											$sql_halfday= "select count(t1.attendance_id) as halfday from tbl_attendance t1 where MONTH(t1.attendance_date) =MONTH('$cur_date') and YEAR(t1.attendance_date) =YEAR('$cur_date') and t1.emp_id=".$emp_id." and t1.attendance_status='Halfday' and t1.delete_status='NDL'";			
											$exec_query_halfday=mysqli_query($conn, $sql_halfday);
											$fetch_results_halfday=$exec_query_halfday ? mysqli_fetch_array($exec_query_halfday) : [];

											$sql_festival= "select count(t1.attendance_id) as festival from tbl_attendance t1 where MONTH(t1.attendance_date) =MONTH('$cur_date') and YEAR(t1.attendance_date) =YEAR('$cur_date') and t1.emp_id=".$emp_id." and t1.attendance_status='Festival' and t1.delete_status='NDL'";			
											$exec_query_festival=mysqli_query($conn, $sql_festival);
											$fetch_results_festival=$exec_query_festival ? mysqli_fetch_array($exec_query_festival) : [];

											$sql_salary= "select pay_amount from tbl_emp_salary t1 where MONTH(t1.start_date) =MONTH('$cur_date') and YEAR(t1.start_date) =YEAR('$cur_date') and t1.emp_id=".$emp_id." and t1.delete_status='NDL'";			
											$exec_query_salary=mysqli_query($conn, $sql_salary);
											$fetch_results_salary=$exec_query_salary ? mysqli_fetch_array($exec_query_salary) : null;

											$present = !empty($fetch_results_present['present']) ? (int)$fetch_results_present['present'] : 0;
											$sunday = !empty($fetch_results_sunday['sunday']) ? (int)$fetch_results_sunday['sunday'] : 0;
											$halfday = !empty($fetch_results_halfday['halfday']) ? (int)$fetch_results_halfday['halfday'] : 0;
											$festival = !empty($fetch_results_festival['festival']) ? (int)$fetch_results_festival['festival'] : 0;
											$absent = !empty($fetch_results_absent['absent']) ? (int)$fetch_results_absent['absent'] : 0;

											$monthly_sal = (float)($employee_fetch_results['salary'] ?? 0);
											$saved_pay = $fetch_results_salary['pay_amount'] ?? null;

											if ($saved_pay !== null && $saved_pay !== '') {
												$pay_amount_val = $saved_pay;
											} else if ($monthly_sal > 0 && ($present > 0 || $festival > 0 || $halfday > 0)) {
												// Sunday excluded from calculation & deductions:
												// Working Days = Calendar Days - Sundays
												// Daily Rate = Monthly Salary / Working Days
												// Payable Days = Present + Festival + (Halfday * 0.5)
												$payable_days = $present + $festival + ($halfday * 0.5);
												$daily_rate = $monthly_sal / $monthly_working_days;
												$pay_amount_val = round($payable_days * $daily_rate);
											} else {
												$pay_amount_val = '';
											}
											?>
										<tr>
											<td><?php echo $i+1;?></td>
											<td style="color:#795548;font-weight:bold;">
												<?php echo htmlspecialchars($employee_fetch_results['emp_name']);?> <input type="hidden" name="emp_id[]" value="<?php echo $employee_fetch_results['emp_id']; ?>">
											</td>
											<td align="center">
												<?php echo htmlspecialchars($employee_fetch_results['salary']);?> 
											</td>
											<td align="center">
												<?php echo $present;?> 
											</td>
											<td align="center">
												<?php echo $absent;?> 
											</td>
											<td align="center">
												<?php echo $halfday;?> 
											</td>
										<td align="center">
											<input type="number" step="any" min="0" class="form-control monthly-pay" style="width:140px;text-align:right;margin:auto;" name="attendance_salary<?php echo $i; ?>[]" id="attendance_salary<?php echo $i; ?>" value="<?php echo htmlspecialchars((string)$pay_amount_val); ?>" placeholder="0" >
										</td>
										</tr>	
									<?php $i++;} ?>							
									</tbody>
									<tfoot>
										<tr style="background:#f1f5f9;font-weight:bold;">
											<th colspan="6" class="text-right">Total Pay</th>
											<th class="text-center"><span id="monthly_total_pay">0.00</span></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>						
						
						<div class="col-md-12 text-center" style="margin-top:20px;">
							<div class="row justify-content-center">
								<div class="col-md-3 text-left">
									<div class="form-group">
										<label>Payment Mode :</label>
										<select class="form-control" id="salary_payment_mode" name="salary_payment_mode">
											<option value="Cash" <?php if($existing_payment_mode=='Cash') echo 'selected'; ?>>Cash</option>
											<option value="Bank" <?php if($existing_payment_mode=='Bank') echo 'selected'; ?>>Bank</option>
											<option value="UPI" <?php if($existing_payment_mode=='UPI') echo 'selected'; ?>>UPI</option>
											<option value="Cheque" <?php if($existing_payment_mode=='Cheque') echo 'selected'; ?>>Cheque</option>
											<option value="Other" <?php if($existing_payment_mode=='Other') echo 'selected'; ?>>Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-4 text-left">
									<div class="form-group">
										<label>Remarks :</label>
										<input type="text" class="form-control" id="salary_remarks" name="salary_remarks" placeholder="Salary month remarks" value="<?php echo htmlspecialchars($existing_remarks); ?>">
									</div>
								</div>
							</div>
							<div class="form-group">
								<input type="hidden" name="req" id="req">
								<button type="submit" name="submit" id="submit" class="btn btn-success">Save</button>									
								<a href="add_attendance.php"><button type="button" id="cansubmit" class="btn btn-danger">Cancel</button></a><div id="msg" style="margin-top:10px;font-weight:bold;"></div>
							</div>
						</div>
						</div>
					</div>
				
                    </form>					
		
                </div>
            </div>
		</div>
	</div>
	<div class="row" id="pane-weekly" style="<?php echo $active_tab=='weekly'?'':'display:none;'; ?>">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                    <form id="weeklyform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group row">
									<label class="col-sm-5 col-form-label text-left">Week : <b><?php echo $week_display; ?></b></label>
									<div class="col-md-5">
										<input type="date" id="week_date_picker" class="form-control" style="margin:0;" value="<?php echo htmlspecialchars($week_date); ?>" onchange="changeSalaryWeek(this.value)">
										<input type="hidden" name="week_date" id="week_date" value="<?php echo htmlspecialchars($week_date); ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<p class="text-muted" style="margin-top:8px;">Weekly-salary staff &middot; pay = Payable Days &times; Daily Wage for the week above</p>
							</div>
						</div>
						<div class="row no-print" style="margin-bottom:10px;">
							<div class="col-md-6">
								<input type="text" class="form-control" placeholder="Search staff by name..." onkeyup="filterSalaryRows(this,'weeklybind')">
							</div>
							<div class="col-md-6 text-right">
								<button type="button" class="btn btn-info" onclick="printSalaryPane()">Print Sheet</button>
							</div>
						</div>
						<table class="table table-striped table-bordered salary-grid" width="100%" cellspacing="0" style="margin-bottom:0;">
							<thead>
								<tr>
									<th style="width: 4%;">S.No</th>
									<th style="width: 24%;">E.Name</th>
									<th style="width: 12%;text-align:center;">Daily Wage</th>
									<th style="width: 8%;text-align:center;">Present</th>
									<th style="width: 8%;text-align:center;">Absent</th>
									<th style="width: 8%;text-align:center;">Half Days</th>
									<th style="width: 8%;text-align:center;">Festival</th>
									<th style="width: 10%;text-align:center;">Payable Days</th>
									<th style="width: 18%;text-align:center;">Pay Amount</th>
								</tr>
							</thead>
							<tbody id="weeklybind">
								<?php
								$w_employee_sql="select * from tbl_employee_details where delete_status='NDL' and active_status='Y' and emp_salary_type='2' order by emp_id desc";
								$w_employee_query=mysqli_query($conn,$w_employee_sql);
								$wi=0;
								if($w_employee_query){
								while($w_emp=mysqli_fetch_array($w_employee_query)){
									$w_emp_id=(int)$w_emp['emp_id'];
									$w_wage=(float)($w_emp['salary'] ?? 0);

									// Query daily attendance for this employee in the week (Monday to Sunday)
									$w_att_q = mysqli_query($conn, "SELECT attendance_status, count(*) as cnt FROM tbl_attendance WHERE delete_status='NDL' AND emp_id='$w_emp_id' AND attendance_date BETWEEN '$week_start' AND '$week_end' GROUP BY attendance_status");
									$w_pres = 0; $w_abs = 0; $w_half = 0; $w_fest = 0;
									if ($w_att_q) {
										while ($war = mysqli_fetch_assoc($w_att_q)) {
											if ($war['attendance_status'] === 'Present') $w_pres = (int)$war['cnt'];
											else if ($war['attendance_status'] === 'Absent') $w_abs = (int)$war['cnt'];
											else if ($war['attendance_status'] === 'Halfday') $w_half = (int)$war['cnt'];
											else if ($war['attendance_status'] === 'Festival') $w_fest = (int)$war['cnt'];
										}
									}
									$w_payable_days = $w_pres + $w_fest + ($w_half * 0.5);

									$w_pq = mysqli_query($conn, "select COALESCE(sum(pay_amount),0) p from tbl_emp_hour_salary where delete_status='NDL' and emp_id='".$w_emp_id."' and start_date='".$week_start."' and end_date='".$week_end."'");
									$w_pr = $w_pq ? mysqli_fetch_assoc($w_pq) : ['p'=>0];
									$w_paid = (float)($w_pr['p'] ?? 0);

									if ($w_paid > 0) {
										$w_suggest = $w_paid;
									} else {
										$w_suggest = round($w_payable_days * $w_wage, 2);
									}
								?>
								<tr>
									<td><?php echo $wi+1;?></td>
									<td style="color:#795548;font-weight:bold;">
										<?php echo htmlspecialchars($w_emp['emp_name']);?><input type="hidden" name="emp_id[]" value="<?php echo $w_emp_id; ?>">
									</td>
									<td align="center"><?php echo htmlspecialchars($w_emp['salary']);?></td>
									<td align="center" class="text-success font-weight-bold"><?php echo $w_pres;?></td>
									<td align="center" class="text-danger font-weight-bold"><?php echo $w_abs;?></td>
									<td align="center" class="text-warning font-weight-bold"><?php echo $w_half;?></td>
									<td align="center" class="text-info font-weight-bold"><?php echo $w_fest;?></td>
									<td align="center" class="font-weight-bold" style="background:#f0fdfa;"><?php echo $w_payable_days;?></td>
									<td align="center">
										<input type="number" step="any" min="0" class="form-control" style="width:140px;text-align:right;margin:auto;" name="week_pay[]" id="week_pay_<?php echo $wi; ?>" value="<?php echo $w_suggest>0?$w_suggest:''; ?>" placeholder="0">
									</td>
								</tr>
								<?php $wi++;} } ?>
							</tbody>
							<tfoot>
								<tr style="background:#f1f5f9;font-weight:bold;">
									<th colspan="8" class="text-right">Total Pay</th>
									<th class="text-center"><span id="weekly_total_pay">0.00</span></th>
								</tr>
							</tfoot>
						</table>
						<div class="col-md-12 text-center" style="margin-top:20px;">
							<div class="form-group">
								<button type="submit" name="weekly_submit" id="weekly_submit" class="btn btn-success">Save Weekly Pay</button>
								<a href="attendance_details.php?tab=weekly"><button type="button" class="btn btn-danger">Cancel</button></a><div id="wmsg" style="margin-top:10px;font-weight:bold;"></div>
							</div>
						</div>
                    </form>
                </div>
            </div>
		</div>
	</div>
	
</main>


<input type="hidden" name="modulenamebox" id="modulenamebox" value="10">
<input type="hidden" name="rightsbox" id="rightsbox">


<!-- end::main content -->
<style>
.dataTables_length{
	text-align:left;
}
.dataTables_filter{
	text-align:left;
}
td{
	color:#795548;
	font-weight:bold;
}
</style>
<!-- begin::global scripts -->
<?php include("footer.php") ?>
<!-- begin::global scripts -->
<!--script src="vendors/bundle.js"></script-->
<!-- end::global scripts -->
<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>
<!-- begin::charts -->
<script src="vendors/charts/chartjs/chart.min.js"></script>
<script src="vendors/charts/peity/jquery.peity.min.js"></script>
<script src="js/examples/charts/chartjs.js"></script>
<script src="js/examples/charts/peity.js"></script>
<!-- end::charts -->

<!-- begin::daterangepicker -->
<script src="vendors/datepicker/daterangepicker.js"></script>
<!-- end::daterangepicker -->

<!-- begin::dashboard -->
<script src="js/examples/dashboard.js"></script>
<!-- end::dashboard -->

<!-- begin::vamp -->
<script src="vendors/vmap/jquery.vmap.min.js"></script>
<script src="vendors/vmap/maps/jquery.vmap.usa.js"></script>
<script src="js/examples/vmap.js"></script>
<!-- end::vamp -->

<!-- begin::custom scripts -->
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>
<!-- end::custom scripts -->

</body>
<style>
@media(min-width:992px){
	.navbar-nav{
		display:block!important;
		width:100%;
	}
	.userdiv{
		float:right;
	}
	.mybut{
		margin-top:33px;
	}
}

@media(max-width:480px){
	nav.navbar .header-logo a img{
		width:180px;
	}
}
</style>


<script>
function changeSalaryMonth(dateVal) {
	if (dateVal) {
		var tab = '<?php echo $active_tab; ?>';
		var url = 'add_attendance_salary.php?salary_date=' + dateVal;
		if (tab === 'weekly') { url += '&tab=weekly&week_date=<?php echo htmlspecialchars($week_date); ?>'; }
		window.location.href = url;
	}
}
function changeSalaryWeek(dateVal) {
	if (dateVal) {
		window.location.href = 'add_attendance_salary.php?salary_date=<?php echo htmlspecialchars($salary_date); ?>&tab=weekly&week_date=' + dateVal;
	}
}

$(document).ready(function() {

	$(".page-loader").hide();
	updateSalaryTotals();

	if('<?php echo $log;?>'!="admin"){
	$.ajax({
		type: "POST",
		url: "phpservices/employee_rights.php",
		dataType:'JSON',
		data: {empid:<?php echo $login_id;?>,moduleid:$("#modulenamebox").val()},
		success: function(result) {
			$("#rightsbox").val(result.rights);
			var emprights=result.rights;
				}
			});
	}










	$("#weekly_submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			var hasPay=false;
			$("input[name='week_pay[]']").each(function(){ if(parseFloat($(this).val()||0) > 0){ hasPay=true; } });
			if(!hasPay){
				$("#wmsg").css("color","red").html('* Enter at least one pay amount');
				setTimeout(function(){$("#wmsg").html('')},3000);
				return false;
			}
			$("#wmsg").css("color","green").html("Processing . . .");
			var $wbtn = $("#weekly_submit"); $wbtn.prop('disabled', true);
			$.ajax({
					type: "POST",
					url: "attendance_hour_details_service.php",
					dataType:'json',
					data: $("#weeklyform").serialize(),
					success: function(result) {
						$wbtn.prop('disabled', false);
						console.log(result);
						if(result.op==1){
							$("#wmsg").css("color","green").html("Weekly pay saved (" + (result.saved||'') + " rows) !");
							setTimeout(function(){
								window.location.href='add_attendance_salary.php?salary_date=<?php echo htmlspecialchars($salary_date); ?>&tab=weekly&week_date=<?php echo htmlspecialchars($week_date); ?>';
							},1500);
						}
						else{
							var em = (typeof result.op === 'string' && result.op) ? result.op : 'Save failed. Please retry.';
							$("#wmsg").css("color","red").html(em);
						}
					},error:function(xhr,status,error){
						$wbtn.prop('disabled', false);
						$("#wmsg").css("color","red").html("Server error. Please retry.");
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
		else{
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});

	$("#submit").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			var count = document.getElementsByClassName("trtag").length;
			var check_count=count-1;
			console.log(count);
			
			
	
	 if($("#salary_date").val()==''){
			$("#msg").css("color","red").html('* Enter Work Order Date');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}		
		else{

			
			$("#msg").css("color","green").html("Processing . . .");
			var $saveBtn = $("#submit"); $saveBtn.prop('disabled', true);
			$.ajax({
					type: "POST",
					url: "attendance_details_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						$saveBtn.prop('disabled', false);
						console.log(result);
						if(result.op==1){
							$("#msg").css("color","green").html("Successfully Saved !");
							setTimeout(function(){
								window.location.href='attendance_details.php';
							},2000);
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
						$saveBtn.prop('disabled', false);
						$("#msg").css("color","red").html("Server error. Please retry.");
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
		}
		else{
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});

}); 
// ---- salary page helpers (global scope): live totals, staff search, print ----
function fmt2(n){ n = parseFloat(n || 0); return isNaN(n) ? '0.00' : n.toFixed(2); }
function updateSalaryTotals(){
	var m = 0;
	$("#tablemainbind tr:visible").each(function(){
		$(this).find("input.monthly-pay").each(function(){ m += parseFloat($(this).val() || 0); });
	});
	$("#monthly_total_pay").html(fmt2(m));
	var w = 0;
	$("#weeklybind tr:visible").each(function(){
		$(this).find("input[name='week_pay[]']").each(function(){ w += parseFloat($(this).val() || 0); });
	});
	$("#weekly_total_pay").html(fmt2(w));
}
$(document).on('keyup change', '.monthly-pay, input[name=\'week_pay[]\']', function(){ updateSalaryTotals(); });
function filterSalaryRows(input, tbodyId){
	var q = ($(input).val() || '').toLowerCase();
	$("#" + tbodyId + " tr").each(function(){
		var name = $(this).find("td:nth-child(2)").text().toLowerCase();
		$(this).toggle(name.indexOf(q) !== -1);
	});
	updateSalaryTotals();
}
function printSalaryPane(){
	var active = ($("#pane-weekly").is(":visible")) ? 'weekly' : 'monthly';
	var title = (active === 'weekly') ? 'Weekly Salary - <?php echo $week_display; ?>' : 'Monthly Salary - <?php echo $sel_month_display; ?>';
	var body = (active === 'weekly') ? $("#pane-weekly").html() : $("#pane-monthly").html();
	var w = window.open('', '_blank');
	w.document.write('<html><head><title>' + title + '</title>');
	w.document.write('<style>table{width:100%;border-collapse:collapse;}th,td{border:1px solid #000;padding:6px;font-size:13px;}input,button,.no-print,.nav-tabs{display:none !important;}</style>');
	w.document.write('</head><body><h3>' + title + '</h3>' + body + '</body></html>');
	w.document.close();
	w.focus();
	w.print();
}
</script>

</html>
