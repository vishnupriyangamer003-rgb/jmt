<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Spares)</title>
    <link rel="icon" type="image/png" href="userdata/images/favicon.png">
    <link rel="stylesheet" href="vendors/bundle.css" type="text/css">
    <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/app.min.css" type="text/css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include('sessionservices.php');?>
<div class="page-loader"><div class="spinner-border"></div><span>Loading ...</span></div>
<?php echo $header;?>
<?php
$selMonth = preg_match('/^\d{4}-\d{2}$/', ($_GET['m'] ?? '')) ? $_GET['m'] : date('Y-m');
function pl_sum($conn, $sql){ $r = mysqli_query($conn, $sql); $f = $r ? mysqli_fetch_assoc($r) : null; return (float)($f['t'] ?? 0); }
$g = pl_sum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_gst_invoice WHERE delete_status='NDL' AND DATE_FORMAT(billing_date,'%Y-%m')='$selMonth'");
$n = pl_sum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_non_dc WHERE delete_status='NDL' AND is_service_bill=0 AND DATE_FORMAT(billing_date,'%Y-%m')='$selMonth'");
$sv = pl_sum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_non_dc WHERE delete_status='NDL' AND is_service_bill=1 AND DATE_FORMAT(billing_date,'%Y-%m')='$selMonth'");
$income = $g + $n + $sv;
$expQ = mysqli_query($conn, "SELECT h.income_header_name AS cat, COALESCE(SUM(d.amount),0) AS t FROM tbl_income_expense_details d LEFT JOIN tbl_income_header h ON h.id=d.header_id WHERE d.delete_status='NDL' AND d.income_expense_type='Expense' AND DATE_FORMAT(d.billing_date,'%Y-%m')='$selMonth' GROUP BY d.header_id ORDER BY t DESC");
$expTotal = 0; $expRows = [];
if ($expQ) while ($r = mysqli_fetch_assoc($expQ)) { $expRows[] = $r; $expTotal += (float)$r['t']; }
$salary = pl_sum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_emp_salary WHERE delete_status='NDL' AND DATE_FORMAT(start_date,'%Y-%m')='$selMonth'");
$totalExp = $expTotal + $salary;
$net = $income - $totalExp;
// 6-month series
$labels = []; $incS = []; $expS = []; $plS = [];
for ($mi = 5; $mi >= 0; $mi--) {
    $mkey = date('Y-m', strtotime($selMonth . '-01 ' . "-$mi months"));
    $labels[] = date('M Y', strtotime($mkey . '-01'));
    $ii = pl_sum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_gst_invoice WHERE delete_status='NDL' AND DATE_FORMAT(billing_date,'%Y-%m')='$mkey'") + pl_sum($conn, "SELECT COALESCE(SUM(grand_total_amount),0) t FROM tbl_non_dc WHERE delete_status='NDL' AND DATE_FORMAT(billing_date,'%Y-%m')='$mkey'");
    $ee = pl_sum($conn, "SELECT COALESCE(SUM(amount),0) t FROM tbl_income_expense_details WHERE delete_status='NDL' AND income_expense_type='Expense' AND DATE_FORMAT(billing_date,'%Y-%m')='$mkey'") + pl_sum($conn, "SELECT COALESCE(SUM(pay_amount),0) t FROM tbl_emp_salary WHERE delete_status='NDL' AND DATE_FORMAT(start_date,'%Y-%m')='$mkey'");
    $incS[] = round($ii,2); $expS[] = round($ee,2); $plS[] = round($ii-$ee,2);
}
?>
<main class="main-content">
    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Profit & Loss — <?php echo date('F Y', strtotime($selMonth.'-01')); ?></h4>
            <form method="GET" class="form-inline">
                <input type="month" class="form-control" name="m" value="<?php echo $selMonth; ?>">
                <button class="btn btn-primary ml-2" type="submit">View</button>
                <a href="javascript:window.print()" class="btn btn-warning ml-2">Print</a>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"><div class="card jhe-kpi"><div class="card-body"><h6>Total Income</h6><h4 class="font-weight-bold"><?php echo number_format($income,2); ?></h4><small class="text-muted">Spares GST <?php echo number_format($g,2); ?> · Non-GST <?php echo number_format($n,2); ?> · Service <?php echo number_format($sv,2); ?></small></div></div></div>
        <div class="col-md-4"><div class="card jhe-kpi"><div class="card-body"><h6>Total Expenses</h6><h4 class="font-weight-bold"><?php echo number_format($totalExp,2); ?></h4><small class="text-muted">Operating <?php echo number_format($expTotal,2); ?> · Salary <?php echo number_format($salary,2); ?></small></div></div></div>
        <div class="col-md-4"><div class="card jhe-kpi"><div class="card-body"><h6>Net <?php echo $net < 0 ? 'Loss' : 'Profit'; ?></h6><h4 class="font-weight-bold" style="color:<?php echo $net < 0 ? '#b91c1c' : '#15803d'; ?>;"><?php echo number_format($net,2); ?></h4><small class="text-muted">Income − Expenses (same definition as dashboard)</small></div></div></div>
    </div>
    <div class="row">
        <div class="col-md-6"><div class="card"><div class="card-header">Expense by Category — <?php echo date('M Y', strtotime($selMonth.'-01')); ?></div><div class="card-body"><div class="table-responsive"><table class="table table-striped table-bordered"><thead><tr><th>Category</th><th class="text-right">Amount</th></tr></thead><tbody>
            <?php if (!$expRows) echo '<tr><td colspan="2" class="jhe-empty">No expenses recorded</td></tr>'; foreach ($expRows as $r) echo '<tr><td>'.htmlspecialchars($r['cat'] ?: 'Uncategorised').'</td><td class="text-right">'.number_format((float)$r['t'],2).'</td></tr>'; ?>
            <tr><th>Operating Total</th><th class="text-right"><?php echo number_format($expTotal,2); ?></th></tr>
            <tr><th>Salary</th><th class="text-right"><?php echo number_format($salary,2); ?></th></tr>
        </tbody></table></div></div></div></div>
        <div class="col-md-6"><div class="card"><div class="card-header">6-Month Comparison (ending <?php echo date('M Y', strtotime($selMonth.'-01')); ?>)</div><div class="card-body"><canvas id="pnl_chart" height="180"></canvas><div class="table-responsive mt-3"><table class="table table-striped table-bordered"><thead><tr><th>Month</th><th class="text-right">Income</th><th class="text-right">Expense</th><th class="text-right">P/L</th></tr></thead><tbody>
            <?php foreach ($labels as $i => $lb) echo '<tr><td>'.$lb.'</td><td class="text-right">'.number_format($incS[$i],2).'</td><td class="text-right">'.number_format($expS[$i],2).'</td><td class="text-right" style="color:'.($plS[$i]<0?'#b91c1c':'#15803d').';font-weight:700;">'.number_format($plS[$i],2).'</td></tr>'; ?>
        </tbody></table></div></div></div></div>
    </div>
</main>
<?php include("footer.php") ?>
<script src="vendors/charts/chartjs/chart.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var el = document.getElementById('pnl_chart');
    if (el && window.Chart) {
        new Chart(el, { type: 'bar',
            data: { labels: <?php echo json_encode($labels); ?>,
                datasets: [
                    { label: 'Income', data: <?php echo json_encode($incS); ?>, backgroundColor: '#0e5f6b' },
                    { label: 'Expenses', data: <?php echo json_encode($expS); ?>, backgroundColor: '#f59e0b' },
                    { label: 'Profit/Loss', data: <?php echo json_encode($plS); ?>, backgroundColor: '#15803d' }
                ] },
            options: { responsive: true } });
    }
    if (window['hidePageLoader']) hidePageLoader();
    var pl = document.querySelector('.page-loader'); if (pl) pl.style.display = 'none';
});
</script>
</body>
</html>
