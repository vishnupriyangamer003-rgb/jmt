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

   <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="vendors/clockpicker/bootstrap-clockpicker.min.css" type="text/css">
    <!-- begin::datepicker -->
    <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
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
<?php include 'sessionservices.php';?>
<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading ...</span>
</div>
<!-- end::page loader -->
<style>
.bg-danger-gradient{
	background: #000642!important;
}
h5, h2{
	color:#fff;
	
}
.dashrow{
	padding-right: 0px;
    padding-left: 0px;
}
</style>
<?php echo $header; ?>

<!-- begin::main content -->
<main class="main-content">
	<div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Dashboard</h4>
			
        </div>
    </div>

<div class="row">
<?php
// Jayam KPIs - all live DB values, single consistent definitions.
$j_today = date('Y-m-d'); $j_ym = date('Y-m');
function jsum($conn, $sql){ try { $r = mysqli_query($conn, $sql); $f = $r ? mysqli_fetch_assoc($r) : null; return (float)($f['t'] ?? 0); } catch (Throwable $e) { error_log('dashboard jsum failed: '.$e->getMessage().' | '.$sql); return 0.0; } }
$j_gst_today = jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_gst_invoice WHERE delete_status='NDL' AND billing_date='$j_today'");
$j_non_today = jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_non_dc WHERE delete_status='NDL' AND billing_date='$j_today'");
$j_today_sales = $j_gst_today + $j_non_today;
$j_gst_month = jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_gst_invoice WHERE delete_status='NDL' AND DATE_FORMAT(billing_date,'%Y-%m')='$j_ym'");
$j_non_month = jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_non_dc WHERE delete_status='NDL' AND DATE_FORMAT(billing_date,'%Y-%m')='$j_ym'");
$j_month_sales = $j_gst_month + $j_non_month;
$j_service_month = jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_services_non_dc WHERE delete_status='NDL' AND DATE_FORMAT(billing_date,'%Y-%m')='$j_ym'");
$j_coll_today = jsum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_receipt WHERE delete_status='NDL' AND billing_date='$j_today'") + jsum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_non_receipt WHERE delete_status='NDL' AND billing_date='$j_today'") + jsum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_services_non_receipt WHERE delete_status='NDL' AND billing_date='$j_today'");
$j_gst_total = jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_gst_invoice WHERE delete_status='NDL'");
$j_gst_paid = jsum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_receipt WHERE delete_status='NDL'");
$j_non_total = jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_non_dc WHERE delete_status='NDL'");
$j_non_paid = jsum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_non_receipt WHERE delete_status='NDL'");
$j_srv_total = jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_services_non_dc WHERE delete_status='NDL'");
$j_srv_paid = jsum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_services_non_receipt WHERE delete_status='NDL'");
$j_outstanding = ($j_gst_total - $j_gst_paid) + ($j_non_total - $j_non_paid) + ($j_srv_total - $j_srv_paid);
$j_exp_month = jsum($conn, "SELECT COALESCE(SUM(amount),0) t FROM tbl_income_expense_details WHERE delete_status='NDL' AND income_expense_type='Expense' AND DATE_FORMAT(billing_date,'%Y-%m')='$j_ym'");
$j_sal_month = jsum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_emp_salary WHERE delete_status='NDL' AND DATE_FORMAT(start_date,'%Y-%m')='$j_ym'");
$j_month_pl = $j_month_sales - $j_exp_month - $j_sal_month;
$j_emp_count = (int)jsum($conn, "SELECT COUNT(*) t FROM tbl_employee_details WHERE delete_status='NDL'");
$j_present = (int)jsum($conn, "SELECT COUNT(*) t FROM tbl_attendance WHERE delete_status='NDL' AND attendance_status='Present' AND attendance_date='$j_today'");
$j_absent = (int)jsum($conn, "SELECT COUNT(*) t FROM tbl_attendance WHERE delete_status='NDL' AND attendance_status='Absent' AND attendance_date='$j_today'");
// 6-month P&L series (real data)
$j_labels = []; $j_inc = []; $j_exp = []; $j_pl = [];
for ($mi = 5; $mi >= 0; $mi--) {
    $mkey = date('Y-m', strtotime("-$mi months")); $mlab = date('M Y', strtotime("-$mi months"));
    $inc = jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_gst_invoice WHERE delete_status='NDL' AND DATE_FORMAT(billing_date,'%Y-%m')='$mkey'") + jsum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_non_dc WHERE delete_status='NDL' AND DATE_FORMAT(billing_date,'%Y-%m')='$mkey'");
    $exp = jsum($conn, "SELECT COALESCE(SUM(amount),0) t FROM tbl_income_expense_details WHERE delete_status='NDL' AND income_expense_type='Expense' AND DATE_FORMAT(billing_date,'%Y-%m')='$mkey'") + jsum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_emp_salary WHERE delete_status='NDL' AND DATE_FORMAT(start_date,'%Y-%m')='$mkey'");
    $j_labels[] = $mlab; $j_inc[] = round($inc,2); $j_exp[] = round($exp,2); $j_pl[] = round($inc-$exp,2);
}
?>

            <div class="col-md-3">
                <div class="card jhe-kpi">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Today's Sales</h6>
                                <h4 class="m-b-0 font-weight-bold"><?php echo number_format($j_today_sales, 2); ?></h4>
                            </div>
                            <div>
                                <img src="images/dash4.svg" style="width: 25px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card jhe-kpi">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>This Month Sales</h6>
                                <h4 class="m-b-0 font-weight-bold"><?php echo number_format($j_month_sales, 2); ?></h4>
                            </div>
                            <div>
                                <img src="images/dash3.svg" style="width: 25px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
            <div class="col-md-3">
                <div class="card jhe-kpi">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Service Billing (Month)</h6>
                                <h4 class="m-b-0 font-weight-bold"><?php echo number_format($j_service_month, 2); ?></h4>
                            </div>
                            <div>
                                <img src="images/dash2.svg" style="width: 40px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card jhe-kpi">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Today's Collection</h6>
                                <h4 class="m-b-0 font-weight-bold"><?php echo number_format($j_coll_today, 2); ?></h4>
                            </div>
                            <div>
                                <img src="images/dash1.svg" style="width: 40px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card jhe-kpi">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Total Outstanding</h6>
                                <h4 class="m-b-0 font-weight-bold"><?php echo number_format($j_outstanding, 2); ?></h4>
                            </div>
                            <div>
                                <img src="images/dash2.svg" style="width: 40px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
            <div class="col-md-3">
                <div class="card jhe-kpi">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Month Expenses</h6>
                                <h4 class="m-b-0 font-weight-bold"><?php echo number_format($j_exp_month + $j_sal_month, 2); ?></h4>
                            </div>
                            <div>
                                <img src="images/dash3.svg" style="width: 25px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
            <div class="col-md-3">
                <div class="card jhe-kpi">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Month Profit / Loss</h6>
                                <h4 class="m-b-0 font-weight-bold" style="color:<?php echo $j_month_pl < 0 ? '#b91c1c' : '#15803d'; ?>;"><?php echo number_format($j_month_pl, 2); ?></h4>
                            </div>
                            <div>
                                <img src="images/dash4.svg" style="width: 25px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card jhe-kpi">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Staff (Present / Absent Today)</h6>
                                <h4 class="m-b-0 font-weight-bold"><?php echo $j_emp_count; ?> <small style="font-size:13px;color:#64748b;">(<?php echo $j_present; ?> / <?php echo $j_absent; ?>)</small></h4>
                            </div>
                            <div>
                                <img src="images/customer.png" style="width: 40px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span>Last 6 Months - Income vs Expense vs Profit/Loss</span>
                    </div>
                    <div class="card-body">
                        <canvas id="jhe_pnl_chart" height="110"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function(){
            var el = document.getElementById('jhe_pnl_chart');
            if (el && window.Chart) {
                new Chart(el, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($j_labels); ?>,
                        datasets: [
                            { label: 'Income', data: <?php echo json_encode($j_inc); ?>, backgroundColor: '#0e5f6b' },
                            { label: 'Expenses', data: <?php echo json_encode($j_exp); ?>, backgroundColor: '#f59e0b' },
                            { label: 'Profit/Loss', data: <?php echo json_encode($j_pl); ?>, backgroundColor: '#15803d' }
                        ]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: false } } }
                });
            }
        });
        </script>

		<div class="row">

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body" style="border: 1px solid;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="images/customer.png" style="width: 75px;">
                            </div>
                            <div>
                                <h6>No. of Customers</h6>
                                <h4 class="m-b-0 font-weight-bold">
                                <?php                                
                                
                                
                                $cus_gql = "SELECT count(customer_id) as total_cus FROM  tbl_customer where delete_status='NDL' ";
                        
                                $exec_cus_gql = mysqli_query($conn, $cus_gql);
                                $fetch_cus_gql = mysqli_fetch_array($exec_cus_gql);
                                echo $fetch_cus_gql['total_cus'];
                                ?>
                                    
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body" style="border: 1px solid;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="images/invoice.png" style="width: 75px;">
                            </div>
                            <div>
                                <h6>No. of Products</h6>
                                <h4 class="m-b-0 font-weight-bold">
                                <?php
                                $prd_gql = "SELECT count(product_id) as total_prd FROM tbl_products where delete_status='NDL' ";
                                $exec_prd_gql = mysqli_query($conn, $prd_gql);
                                $fetch_prd_gql = mysqli_fetch_array($exec_prd_gql);
                                echo (int)$fetch_prd_gql['total_prd'];
                                ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body" style="border: 1px solid;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="images/invoice2.png" style="width: 75px;">
                            </div>
                            <div>
                                <h6>Sales Invoices</h6>
                                <h4 class="m-b-0 font-weight-bold">
                                <?php
                                $sale_invoice_gql = "SELECT count(dc_id) as total_sale_invoice FROM tbl_gst_invoice where delete_status='NDL' ";
                                $exec_sale_invoice_gql = mysqli_query($conn, $sale_invoice_gql);
                                $fetch_sale_invoice_gql = mysqli_fetch_array($exec_sale_invoice_gql);

                                $non_sale_invoice_gql = "SELECT count(dc_id) as total_non_invoice FROM tbl_non_dc where delete_status='NDL' ";
                                $exec_non_sale_invoice_gql = mysqli_query($conn, $non_sale_invoice_gql);
                                $fetch_non_sale_invoice_gql = mysqli_fetch_array($exec_non_sale_invoice_gql);

                                echo (int)$fetch_sale_invoice_gql['total_sale_invoice'] + (int)$fetch_non_sale_invoice_gql['total_non_invoice'];
                                ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body" style="border: 1px solid;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="images/production.png" style="width: 75px;">
                            </div>
                            <div>
                                <h6>Service Bills</h6>
                                <h4 class="m-b-0 font-weight-bold">
                                <?php
                                $srv_gql = "SELECT count(dc_id) as total_srv FROM tbl_services_non_dc where delete_status='NDL'";
                                $exec_srv_gql = mysqli_query($conn, $srv_gql);
                                $fetch_srv_gql = mysqli_fetch_array($exec_srv_gql);
                                echo (int)$fetch_srv_gql['total_srv'];
                                ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			
        </div>
		
		
 
    <!--div class="row">
            <div class="col-md-3"> 
                <div class="card">
                    <div class="card-header bg-warning d-flex align-items-center justify-content-between">Order Entry Count
                        
                    </div>
                    <div class="card-body text-center">
                        <?php
                            $order_gql="SELECT count(order_id) as total_order FROM tbl_order   where delete_status='NDL'";
                            $order_exec_gql=mysqli_query($conn,$order_gql);
                            $order_fetch_gql=mysqli_fetch_array($order_exec_gql);
                        ?>
                        <h3 class="text-primary font-weight-bold"><i class="fa fa-thumbs-o-up text-primary m-r-5"></i> <span id='total_trip'><?php echo $order_fetch_gql['total_order'];?></span> </h3>
                        -
                    </div>
                </div> 

            </div>

            <div class="col-md-3"> 
                <div class="card">
                    <div class="card-header bg-danger d-flex align-items-center justify-content-between">Pending Order Entry Count</div>
                    <div class="card-body text-center">
                        <?php
                            $dc_order_gql="select count(order_id) as total_order from tbl_non_dc where delete_status='NDL'";
                            $dc_order_exec_gql=mysqli_query($conn,$dc_order_gql);
                            $dc_order_fetch_gql=mysqli_fetch_array($dc_order_exec_gql);
                        ?>
                        <h3 class="text-primary font-weight-bold"><i class="fa fa-thumbs-o-down text-primary m-r-5"></i> <span id='total_hour'><?php echo $order_fetch_gql['total_order']-$dc_order_fetch_gql['total_order'];?></span> </h3>
                        -
                    </div>
                </div> 

            </div>
            <div class="col-md-3"> 
                <div class="card">
                    <div class="card-header bg-success d-flex align-items-center justify-content-between">Today Income</div>
                    <div class="card-body text-center">
                        <?php
                            $income_gql="select sum(amount) as total_amount from tbl_income_expense_details where delete_status='NDL' and income_expense_type='Income' and billing_date='".date('Y-m-d')."'";
                            $income_exec_gql=mysqli_query($conn,$income_gql);
                            $income_fetch_gql=mysqli_fetch_array($income_exec_gql);
                        ?>

                        <h3 class="text-primary font-weight-bold"><i class="fa fa-rupee text-primary m-r-5"></i> <span id='collection_amount'><?php echo $income_fetch_gql['total_amount'];?></span> </h3>
                        -
                    </div>
                </div> 

            </div>
            <div class="col-md-3"> 
                <div class="card" >
                    <div class="card-header bg-green d-flex align-items-center justify-content-between" style="background: #873600;border-color: #873600; color:#FFFFFF;">Today Expense</div>
                    <div class="card-body text-center">
                        <?php
                            $expense_gql="select sum(amount) as total_amount from tbl_income_expense_details where delete_status='NDL' and income_expense_type='Expense' and billing_date='".date('Y-m-d')."'";
                            $expense_exec_gql=mysqli_query($conn,$expense_gql);
                            $expense_fetch_gql=mysqli_fetch_array($expense_exec_gql);
                        ?>
                        <h3 class="text-primary font-weight-bold"><i class="fa fa-rupee text-primary m-r-5"></i> <span id='paid_amount'><?php echo $expense_fetch_gql['total_amount'];?></span> </h3>
                        -
                    </div>
                </div> 

            </div>
            <div class="col-md-3"> 
                <div class="card">
                    <div class="card-header bg-primary d-flex align-items-center justify-content-between">Today Present</div>
                    <div class="card-body text-center">
                        <?php
                            $att_present_gql="select count(attendance_id) as present from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t1.attendance_status='Present' and t2.emp_salary_type='1' and t1.attendance_date='".date('Y-m-d')."'";
                            $att_present_exec_gql=mysqli_query($conn,$att_present_gql);
                            $att_present_fetch_gql=mysqli_fetch_array($att_present_exec_gql);
                        ?>

                        <h3 class="text-primary font-weight-bold"><i class="fa fa-users text-primary m-r-5"></i> <span id='pending_amount'><?php echo $att_present_fetch_gql['present'];?></span> </h3>
                        -
                    </div>
                </div> 

            </div>

            <div class="col-md-3"> 
                <div class="card">
                    <div class="card-header bg-secondary d-flex align-items-center justify-content-between">Today Absent</div>
                    <div class="card-body text-center">
                    <?php
                            $att_absent_gql="select count(attendance_id) as absent from tbl_attendance t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t1.attendance_status='Absent' and t2.emp_salary_type='1' and t1.attendance_date='".date('Y-m-d')."'";
                            $att_absent_exec_gql=mysqli_query($conn,$att_absent_gql);
                            $att_absent_fetch_gql=mysqli_fetch_array($att_absent_exec_gql);
                        ?>
                        <h3 class="text-primary font-weight-bold"><i class="fa fa-users text-primary m-r-5"></i> <span id='diesal_amount'><?php echo $att_absent_fetch_gql['absent'];?></span> </h3>
                        -
                    </div>
                </div> 

            </div>
            
    </div--> 

    <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info d-flex align-items-center justify-content-between" >
                        Product Stock
                        
                    </div>
                    <div class="card-body">
                        <div class="card-scroll">
                            <div class="table-responsive">
                                <table class="table" id="detailsgrid1">
                                    <thead>    
                                        <tr>
                                            <th>Product&nbsp;Name</th>
                                            <th>Qty</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    
                                    $sql = "SELECT a.product_id,a.product_name,COALESCE(a.opening_stock,0) AS opening_stock FROM tbl_products a  where a.delete_status='NDL'";
                                    

                                    $sql.=" GROUP BY a.product_id, a.product_name, a.opening_stock order by a.product_id desc";
                                    $query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

                                    $i=1;
                                    // Optional date-filter fragments (empty = all dates)
                                    $dc_sql_date = $dc_sql_date ?? '';
                                    $production_sql_date = $production_sql_date ?? '';
                                    while( $row=mysqli_fetch_array($query) ) { 

                                        // Total sold across all bill channels (headers + details must be live)
                                        $sales_sql = "SELECT COALESCE(SUM(qty),0) AS sold FROM ("
                                            . "SELECT b.qty FROM tbl_gst_invoice a INNER JOIN tbl_gst_invoice_details b ON a.dc_id=b.dc_id WHERE b.product_id='".$row["product_id"]."' AND a.delete_status='NDL' AND b.delete_status='NDL' $dc_sql_date "
                                            . "UNION ALL SELECT b.qty FROM tbl_non_dc a INNER JOIN tbl_non_dc_details b ON a.dc_id=b.dc_id WHERE b.product_id='".$row["product_id"]."' AND a.delete_status='NDL' AND b.delete_status='NDL' $dc_sql_date "
                                            . "UNION ALL SELECT b.qty FROM tbl_sky_gst_invoice a INNER JOIN tbl_sky_gst_invoice_details b ON a.dc_id=b.dc_id WHERE b.product_id='".$row["product_id"]."' AND a.delete_status='NDL' AND b.delete_status='NDL' $dc_sql_date "
                                            . "UNION ALL SELECT b.qty FROM tbl_dc a INNER JOIN tbl_dc_details b ON a.dc_id=b.dc_id WHERE b.product_id='".$row["product_id"]."' AND a.delete_status='NDL' AND b.delete_status='NDL' $dc_sql_date "
                                            . "UNION ALL SELECT b.qty FROM tbl_sdc a INNER JOIN tbl_sdc_details b ON a.dc_id=b.dc_id WHERE b.product_id='".$row["product_id"]."' AND a.delete_status='NDL' AND b.delete_status='NDL' $dc_sql_date "
                                            . ") s";
                                        $sales_query=mysqli_query($conn, $sales_sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys4");
                                        $sales_row=mysqli_fetch_array($sales_query);             
                                
                                        
                                
                                        $production_sql = "SELECT COALESCE(sum(a.qty),0) as production_qty FROM tbl_production_details a where a.delete_status='NDL'  and a.product_id='".$row["product_id"]."' $production_sql_date ";
                                
                                        //echo $gql31;
                                        $exec_gql31 = mysqli_query($conn, $production_sql);
                                        $fetch_gql31 = mysqli_fetch_array($exec_gql31);
                                
                                            $stock=(float)$row['opening_stock']+(float)($fetch_gql31['production_qty'] ?? 0)-(float)($sales_row['sold'] ?? 0);

                                        ?>
                                        <tr>
                                            <td><?php echo $row["product_name"]; ?></td>
                                            <td><?php echo $stock; ?></td>
                                        </tr>
                                        <?php

                                        $i++;
                                    }

                                ?>
                                    </tbody>
                                    
                                
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-warning d-flex align-items-center justify-content-between" >
                    Service Bills Outstanding
                    </div>
                    <div class="card-body">
                        <div class="card-scroll">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sq = "SELECT a.dc_id, a.dc_no, COALESCE(NULLIF(d.customer_name, ''), NULLIF(a.company_name, ''), 'Customer') AS customer_name, a.grand_total_amount, COALESCE((SELECT SUM(r.pay_amount) FROM tbl_services_non_receipt r WHERE r.dc_id=a.dc_id AND r.delete_status='NDL'),0) AS paid FROM tbl_services_non_dc a LEFT JOIN tbl_customer d ON d.customer_id=a.customer_id WHERE a.delete_status='NDL' ORDER BY a.dc_id DESC LIMIT 25";
                                        $qq = mysqli_query($conn, $sq);
                                        $hasRows = false;
                                        while ($row = mysqli_fetch_array($qq)) {
                                            $bal = (float)$row['grand_total_amount'] - (float)$row['paid'];
                                            if ($bal <= 0) continue;
                                            $hasRows = true;
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="services_non_sales_preview.php?id=<?php echo (int)$row['dc_id']; ?>" style="color: inherit; text-decoration: none;">
                                                        <strong><?php echo htmlspecialchars($row["customer_name"] ?? '-'); ?></strong>
                                                    </a>
                                                    <?php if (!empty($row['dc_no'])): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars($row['dc_no']); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo number_format($bal, 2); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        if (!$hasRows) { echo '<tr><td colspan="2" class="jhe-empty">No outstanding service bills</td></tr>'; }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success d-flex align-items-center justify-content-between" >
                        Customer Outstanding Report
                        
                    </div>
                    <div class="card-body">
                        <div class="card-scroll">
                            <div class="table-responsive">
                                <table class="table" id="outstanding_detailsgrid1">
                                    <thead>    
                                        <tr>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    
                                        $sql = "SELECT d.customer_id, d.customer_name FROM tbl_gst_invoice  a 
                                        inner join tbl_gst_invoice_details b on a.dc_id=b.dc_id 
                                        left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0'";
                                        

                                        $sql.=" GROUP BY d.customer_id, d.customer_name ORDER BY MAX(a.dc_id) DESC";
                                        $query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

                                        $i=1;
                                        while( $row=mysqli_fetch_array($query) ) { 

                                                $gql3 = "SELECT sum(pay_amount) as paid FROM tbl_receipt where delete_status='NDL' and customer_id='".$row['customer_id']."' ";

                                                $exec_gql3 = mysqli_query($conn, $gql3);
                                                $fetch_gql3 = mysqli_fetch_array($exec_gql3);
                                        
                                        
                                                $gql4 = "SELECT sum(grand_total_amount) as total_amount FROM tbl_gst_invoice where delete_status='NDL' and customer_id='".$row['customer_id']."' ";
                                        
                                                $exec_gql4 = mysqli_query($conn, $gql4);
                                                $fetch_gql4 = mysqli_fetch_array($exec_gql4);	
                                            ?>
                                            <tr>
                                                <td><?php echo $row["customer_name"]; ?></td>
                                                <td><?php echo $fetch_gql4["total_amount"]-$fetch_gql3["paid"]; ?></td>
                                            </tr>
                                            <?php

                                            $i++;
                                        }

                                    ?>
                                        
                                    </tbody>                                    
                                
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            
			<!--div class="col-md-8">
                <div class="card">
                    <div class="card-body"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                        <div class="d-md-flex justify-content-between align-items-start" style="display: unset;float: right;">
										<select  class="form-control" style="background: #3a3d5b;color: #fff;">
											<option value="">This Month</option>
											<option value="">Last Month</option>
									
										</select>
                            <div class="d-lg-none d-sm-block m-t-15"></div>
						</div><br><br>
                        <canvas id="chartjs_one" height="306" style="display: block; width: 460px; height: 306px;" width="460"></canvas>
                    </div>
                </div>
            </div-->
            
        </div>


        

        


	

</main>
                           
<!-- end::main content -->

<?php include("footer.php") ?>

<!-- begin::global scripts -->
<!--<!--script src="vendors/bundle.js"></script-->-->
<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>
<!-- end::global scripts -->

<!-- begin::charts -->
<script src="vendors/charts/chartjs/chart.min.js"></script>
<script src="vendors/charts/peity/jquery.peity.min.js"></script>
<script src="js/examples/charts/chartjs.js"></script>
<script src="js/examples/charts/peity.js"></script>
<!-- end::charts -->

<!-- begin::daterangepicker -->
<script src="vendors/datepicker/daterangepicker.js"></script>
<script src="js/examples/datepicker.js"></script>
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
	#searchbut{
		margin-top:33px
	}
}
</style>
<script>
$(document).ready(function(){

          

        

$('#detailsgrid').DataTable({"responsive": true,});
$('#defgrid').DataTable({"responsive": true,});
$("#design_completed").click(function(){
	if ($(this).hasClass("down_div_showing")==false) {
		$(this).addClass('down_div_showing');
		$("#design_upload_div").slideDown(500);
	}
	else{
		$(this).removeClass('down_div_showing');
		$("#design_upload_div").slideUp(500);
	}
});

$("#own_outsource").change(function(){
	if($(this).val()=='outsource'){
		$("#supplierdiv").slideDown(500);
	}
	else if($(this).val()=='own'){
		$("#supplierdiv").slideUp(500);
	}
});
});
</script>
<script>
// Failsafe: never trap user on the loader (e.g. if a chart/vendor script fails).
setTimeout(function(){
	var l = document.querySelector('.page-loader');
	if (l) { l.style.display = 'none'; }
}, 8000);
</script>
</html>