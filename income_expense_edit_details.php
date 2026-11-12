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
	<link rel="stylesheet" href="vendors/select2/css/select2.min.css" type="text/css">
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
<?php 
include_once("sessionservices.php");

$record_id = $_GET['id'] ?? '';
$record = null;
if (ctype_digit((string)$record_id)) {
	$rsql = "SELECT *, DATE_FORMAT(billing_date,'%d/%m/%Y') as billing_date_fmt FROM tbl_income_expense_details WHERE id='".mysqli_real_escape_string($conn, $record_id)."' AND delete_status!='0' LIMIT 1";
	$rexe = mysqli_query($conn, $rsql);
	$record = $rexe ? mysqli_fetch_assoc($rexe) : null;
}
$validRecord = !empty($record);
$billing_date_formatted = $record['billing_date_fmt'] ?? '';
$cur_payment_mode = $record['payment_mode'] ?? 'Cash';
$cur_ref_no = $record['ref_no'] ?? '';
$cur_remarks = $record['remarks'] ?? '';
$cur_header_id = $record['header_id'] ?? '';
$cur_amount = $record['amount'] ?? '';
?>

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading ...</span>
</div>
<!-- end::page loader -->

<?php echo $header;?>

<!-- begin::main content -->
<main class="main-content">

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Edit Expense Details</h4>
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">

							<div class="col-md-12">
								<?php if (!$validRecord) { ?>
								<div class="alert alert-danger text-center">Invalid expense record selected. <a href="income_expense_details.php">Back to list</a></div>
								<?php } ?>
								<div class="card" style="border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc;">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label for="order_date"><strong>Date :</strong> <span style="color:red">*</span></label>
													<input type="text" id="order_date" class="form-control" placeholder="Select Date" name="order_date" value="<?php echo htmlspecialchars($billing_date_formatted, ENT_QUOTES, 'UTF-8'); ?>">
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label><strong>Expense Header :</strong> <span style="color:red">*</span></label>
													<select class="form-control js-example-basic-single expense_header_id" id="expense_header_id" name="expense_header_id[]">
														<option value="">Select Expense Header</option>
														<?php
															$sql_product = "SELECT id, income_header_name FROM tbl_income_header WHERE delete_status='NDL' ORDER BY id DESC";
															$exec_sql_product = mysqli_query($conn, $sql_product);
															while ($fetch_sql_product = mysqli_fetch_array($exec_sql_product)) {
														?>
															<option value="<?php echo $fetch_sql_product['id']; ?>" <?php if ($fetch_sql_product['id'] == $cur_header_id) echo "selected"; ?>><?php echo htmlspecialchars($fetch_sql_product['income_header_name'], ENT_QUOTES, 'UTF-8'); ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label><strong>Amount :</strong> <span style="color:red">*</span></label>
													<input type="number" step="any" min="0" id="expense_amount" class="form-control expense_amount" name="expense_amount[]" value="<?php echo htmlspecialchars((string)$cur_amount, ENT_QUOTES, 'UTF-8');?>" placeholder="Enter Amount">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label><strong>Payment Mode :</strong></label>
													<select class="form-control" id="payment_mode" name="payment_mode">
														<option value="Cash" <?php if($cur_payment_mode=='Cash') echo 'selected';?>>Cash</option>
														<option value="Bank" <?php if($cur_payment_mode=='Bank') echo 'selected';?>>Bank</option>
														<option value="UPI" <?php if($cur_payment_mode=='UPI') echo 'selected';?>>UPI</option>
														<option value="Cheque" <?php if($cur_payment_mode=='Cheque') echo 'selected';?>>Cheque</option>
														<option value="Other" <?php if($cur_payment_mode=='Other') echo 'selected';?>>Other</option>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label><strong>Reference No :</strong></label>
													<input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Reference number" value="<?php echo htmlspecialchars($cur_ref_no, ENT_QUOTES, 'UTF-8'); ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><strong>Description / Remarks :</strong></label>
													<input type="text" class="form-control" id="remarks" name="remarks" placeholder="Description / Remarks" value="<?php echo htmlspecialchars($cur_remarks, ENT_QUOTES, 'UTF-8'); ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" name="record_id" id="record_id" value="<?php echo htmlspecialchars((string)$record_id, ENT_QUOTES, 'UTF-8'); ?>">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-top:15px;min-width:120px;">Save</button>									
									<a href="income_expense_details.php" class="btn btn-danger" style="margin-top:15px;min-width:120px;">Cancel</a>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<span id="msg" style="font-weight:bold;"></span>
							</div>
						</div>
                    </form>
                </div>
            </div>
		</div>
	</div>
</main>
<!-- end::main content -->

<input type="hidden" name="modulenamebox" id="modulenamebox" value="11">
<input type="hidden" name="rightsbox" id="rightsbox">

<?php include("footer.php") ?>

<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>
<script src="vendors/charts/chartjs/chart.min.js"></script>
<script src="vendors/charts/peity/jquery.peity.min.js"></script>
<script src="js/examples/charts/chartjs.js"></script>
<script src="js/examples/charts/peity.js"></script>
<script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<script src="vendors/datepicker/daterangepicker.js"></script>
<script src="js/examples/dashboard.js"></script>
<script src="vendors/vmap/jquery.vmap.min.js"></script>
<script src="vendors/vmap/maps/jquery.vmap.usa.js"></script>
<script src="js/examples/vmap.js"></script>
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){
	$(".page-loader").hide();

	$('input[name="order_date"]').daterangepicker({
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});

	if('<?php echo $log;?>'!="admin"){
		$.ajax({
			type: "POST",
			url: "phpservices/employee_rights.php",
			dataType:'JSON',
			data: {empid:<?php echo $login_id;?>,moduleid:$("#modulenamebox").val()},
			success: function(result) {
				$("#rightsbox").val(result.rights);
			}
		});
	}

	$("#submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#order_date").val()==''){
				swal("Error!", "Select Date !", "warning");
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}
			var headerId = $("#expense_header_id").val();
			var amount = $.trim($("#expense_amount").val());
			if(!headerId){
				swal("Error!", "Select an Expense Header !", "warning");
				return false;
			}
			if(amount === '' || isNaN(amount) || parseFloat(amount) <= 0){
				swal("Error!", "Enter a valid Amount !", "warning");
				return false;
			}
			$("#req").val('UPD');
				$("#msg").css("color","green").html("Processing . . .");
				$.ajax({
					type: "POST",
					url: "income_expense_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						if(result.op==1 || result.op==true){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='income_expense_details.php';
							},1500);
						} else {
							alert($("#msg").html(result.op));
						}
					},
					error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		} else {
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});
});

</script>
</html>