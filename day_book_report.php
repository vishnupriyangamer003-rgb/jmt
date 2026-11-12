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

<!-- begin::main content -->
<main class="main-content">

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Day Book Report Details</h4>
           
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">


				<?php if(isset($_POST['start_date'])){
					
					$fdate = DateTime::createFromFormat('d/m/Y', $_POST['start_date'])->format('Y-m-d');
					$tdate = DateTime::createFromFormat('d/m/Y', $_POST['end_date'])->format('Y-m-d');

					$fdate1 = $_POST['start_date'];
					$tdate1 = $_POST['end_date'];


					//and a.billing_date between '" . $fdate . "' and '" . $tdate . "'

					$sql_income = "SELECT a.amount,a.income_expense_type,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_income_expense_details  a inner join tbl_income_header b on a.header_id=b.id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.income_expense_type='Income' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";


					$sql_expense = "SELECT a.amount,a.income_expense_type,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_income_expense_details  a inner join tbl_income_header b on a.header_id=b.id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.income_expense_type='Expense' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";


					$inc_sql = "SELECT sum(a.amount) as total_income FROM tbl_income_expense_details  a inner join tbl_income_header b on a.header_id=b.id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.income_expense_type='Income' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";


					$exp_sql = "SELECT sum(a.amount) as total_income FROM tbl_income_expense_details  a inner join tbl_income_header b on a.header_id=b.id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.income_expense_type='Expense' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";


				}else{

					$fdate = date('Y-m-d');
					$tdate = date('Y-m-d');

					$sql_income = "SELECT a.amount,a.income_expense_type,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_income_expense_details  a inner join tbl_income_header b on a.header_id=b.id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.income_expense_type='Income' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

											
					$sql_expense = "SELECT a.amount,a.income_expense_type,b.income_header_name,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_income_expense_details  a inner join tbl_income_header b on a.header_id=b.id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.income_expense_type='Expense' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

					$inc_sql = "SELECT sum(a.amount) as total_income FROM tbl_income_expense_details  a inner join tbl_income_header b on a.header_id=b.id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.income_expense_type='Income' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

					$exp_sql = "SELECT sum(a.amount) as total_income FROM tbl_income_expense_details  a inner join tbl_income_header b on a.header_id=b.id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.income_expense_type='Expense' and a.billing_date between '" . $fdate . "' and '" . $tdate . "'";

					$fdate1 = date('d/m/Y');
					$tdate1 = date('d/m/Y');

				}?>

				<form id="mainform1" method="POST" action="" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label>From :</label>
								<input type="text" class="form-control" name="start_date" id="start_date" autocomplete="off" value="<?php echo $fdate1; ?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>To :</label>
								<input type="text" class="form-control" name="end_date" id="end_date" autocomplete="off" value="<?php echo $tdate1; ?>">
							</div>
						</div>
												
						<div class="col-md-2">
								<button type="submit" id="search" class="btn btn-success" style="margin-top:32px;">search</button>
						</div>
					</div>
					<span id="msg" style="font-weight:bold;float:right;margin-top:7px;"></span>
				</form>

				

                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">							

								<div class="col-md-6">

									<label class="col-sm-5 col-form-label">Cash Inward</label>

									<table id="detailsgrid_income" class="table table-striped table-bordered" width="50%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
										<thead>
											<tr>
												<th style="width: 10%">Date</th>	
												<th style="width: 10%">Transaction Details</th>
												<th style="width: 5%">Amount</th>
											</tr>
										</thead>
										<tbody id="tablemainbind1">
										<?php											

											$query_income=mysqli_query($conn, $sql_income) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

											$db_inc_has_rows=false;
											while( $row_income=mysqli_fetch_array($query_income) ) {  
												$db_inc_has_rows=true;
												echo "<tr class='trtag' id='trtag0'>
												<td tyle='padding:5px'>".$row_income['billing_date']."</td>
												<td tyle='padding:5px'>".$row_income['income_header_name']."</td>
												<td tyle='padding:5px'>".$row_income['amount']."</td>
											</tr>";
												
												
												
											}
											if (!$db_inc_has_rows) {
												echo "<tr><td colspan='3' class='text-center'>No content available</td></tr>";
											}


											?>
												
										</tbody>										


									</table>

								</div>

								<div class="col-md-6">

									<label class="col-sm-5 col-form-label">Cash Outward</label>

									<table id="detailsgrid1" class="table table-striped table-bordered" width="50%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
										<thead>
											<tr>
												<th style="width: 10%">Date</th>	
												<th style="width: 10%">Transaction Details</th>
												<th style="width: 5%">Amount</th>
											</tr>
										</thead>
										<tbody id="tablemainbind2">
										<?php											

											$query=mysqli_query($conn, $sql_expense) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");

											$db_exp_has_rows=false;
											while( $row=mysqli_fetch_array($query) ) {  
												$db_exp_has_rows=true;
												echo "<tr class='trtag' id='trtag0'>
												<td tyle='padding:5px'>".$row['billing_date']."</td>
												<td tyle='padding:5px'>".$row['income_header_name']."</td>
												<td tyle='padding:5px'>".$row['amount']."</td>
											</tr>";
												
												
												
											}
											if (!$db_exp_has_rows) {
												echo "<tr><td colspan='3' class='text-center'>No content available</td></tr>";
											}


											?>
												
											</tbody>
												


									</table>

								</div>

								<div class="col-md-6">									

									<table id="detailsgrid1" class="table table-striped table-bordered" width="50%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
										<thead>
											<tr>
												<th style="width: 20%" colspan="2">Delivery Cash Summary</th>	
												
												
											</tr>
										</thead>
										<tbody >
												<tr class="trtag" id="trtag0">
													<td tyle="padding:5px">Cash Inward</td>
													
													<?php										

											$inc_query=mysqli_query($conn, $inc_sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");
											$inc_row=mysqli_fetch_array($inc_query) ;

												echo "<td tyle='padding:5px'>".$inc_row['total_income']."</td>";
												
												
											?>

													
												</tr>
												<tr class="trtag" id="trtag0">
													<td tyle="padding:5px">Cash Outward</td>
													
													<?php

											

											$exp_query=mysqli_query($conn, $exp_sql) or die("tbl_prpty-grPrpty_Id-data.php: get	 tbl_prptys");
											$exp_row=mysqli_fetch_array($exp_query) ;

												echo "<td tyle='padding:5px'>".$exp_row['total_income']."</td>";
												
												
											?>
												</tr>
												<tr class="trtag" id="trtag0">
													<td tyle="padding:5px">Closing Balance</td>
													
													<td tyle="padding:5px"><?php echo $inc_row['total_income']-$exp_row['total_income']; ?></td>
												</tr>
										</tbody>
											


									</table>

								</div>
								<div class="col-md-6">
									

									<table id="detailsgrid1" class="table table-striped table-bordered" width="50%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
										<thead>
											<tr>
												<th style="width: 20%" colspan="2">&nbsp;</th>	
												
												
											</tr>
										</thead>
										<tbody >
												<tr class="trtag" id="trtag0">
													<td tyle="padding:5px">Closing Balance</td>
													
													<td tyle="padding:5px"><?php echo $inc_row['total_income']-$exp_row['total_income']; ?></td>
												</tr>
												
										</tbody>
											


									</table>

								</div>						
							
							
						<br>
							
							
						</div>
						
                    </form>
                </div>
            </div>
		</div>
	</div>
</main>
<!-- end::main content -->
<div class="modal fade" id="supplierModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Supplier</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="supplier_mainform" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Supplier Name :</label><span style="color:red">*</span>
										<input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter supplier Name">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Company Name :</label>
										<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name">
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Mobile Number :</label><span style="color:red">*</span>
										<input type="number" class="form-control" id="mblno" name="mblno" placeholder="Enter Mobile Number">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Email Id :</label>
										<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Id">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Address :</label><span style="color:red">*</span>
										<textarea class="form-control" id="address" name="address" placeholder="Enter Address"></textarea>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>GST Number :</label>
										<input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number">
									</div>
								</div>

								
								<div class="col-md-3">
									<span id="cus_msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
								</div>
							</div>
							<div class='row'>
							
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="req" id="supplier_req">
										<button type="submit" name="supplier_submit" id="supplier_submit" class="btn btn-success">Save</button>									
										<button type="reset" name="supplier_submit" id="supplier_submit" class="btn btn-danger">Reset</button>
									</div>
								</div>
							</div>
						</form>
						<!--<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
						<hr style="padding-top:0;margin-top:0"/>
						<table id="colorgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Color</th>
								<th>Action</th>
							</tr>
						</thead>
					
					</table>-->
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background: #000321;color: #fff;">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
				</button>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="modulenamebox" id="modulenamebox" value="11">
<input type="hidden" name="rightsbox" id="rightsbox">


<?php include("footer.php") ?>



<!-- begin::global scripts -->

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
<!-- START::select2 -->
<script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<!-- end::select2 -->
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




<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script>
	

$(document).ready(function(){

	$('input[name="start_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});
	  $('input[name="end_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});
	 

	$(document).on('click', '.trtag1', function () {
		$("#trtag"+$(this).data('value')+"").remove();
		return false;
	});	
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

	
	



	


		
		
});

</script>
</html>