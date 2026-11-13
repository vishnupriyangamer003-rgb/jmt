<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Services)</title>
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
            <h4>Services - Non-GST Bills</h4>
            <nav aria-label="breadcrumb">
				<a href="services_non_sales_add_details.php" class="btn btn-warning" style="background: #000642;border-color: #000642;"><i class="fa fa-plus-circle" style="color:white;"></i>
					<span style="color:white">&nbsp;&nbsp;ADD SERVICE BILL</span></a>
			</nav>
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
					<form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>From :</label>
									<input type="text" class="form-control" name="single-date-picker" id="sfdate2" autocomplete="off">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>To :</label>
									<input type="text" class="form-control" name="single-date-picker" id="stdate2" autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Customer Name :</label>
									<select class="form-control js-example-basic-single select2-hidden-accessible" id="customer_id" name="customer_id" >
										<option value="">Select Customer </option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>&nbsp;</label>
									<div class="form-group">
										<button type="button" class="btn btn-primary" id="searchbtn" style="width: 90px;">Search</button>
										<button type="button" class="btn btn-secondary" id="searchrefresh" style="width: 90px;margin-left:5px;">Clear</button>
									</div>
								</div>
							</div>
						</div>
					</form>
					<hr>
                    <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>   
								<th>Date</th>
								<th>Bill No</th> 
								<th>Customer</th>
								<th>Place</th>
								<th>Service / Item</th> 
								<th>Qty</th>
								<th>Amount</th>
								<th>Paid</th>
								<th>Balance</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
                </div>
            </div>
		</div>
	</div>
</main>

<input type="hidden" name="modulenamebox" id="modulenamebox" value="5">
<input type="hidden" name="rightsbox" id="rightsbox">

<?php include("footer.php");?>

<!-- begin::global scripts -->
<script src="vendors/bundle.js"></script>
<!-- end::global scripts -->

<!-- begin::chart -->
<script src="vendors/charts/chartjs/chart.min.js"></script>
<script src="vendors/charts/peity/jquery.peity.min.js"></script>
<script src="js/examples/charts/chartjs.js"></script>
<script src="js/examples/charts/peity.js"></script>

<script src="vendors/datepicker/daterangepicker.js"></script>

<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>

<script src="js/examples/dashboard.js"></script>

<script src="vendors/vmap/jquery.vmap.min.js"></script>
<script src="vendors/vmap/maps/jquery.vmap.usa.js"></script>
<script src="js/examples/vmap.js"></script>

<script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>

<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>

</body>

<script>
$(document).ready(function(){
	$('input[name="single-date-picker"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		locale: { format: 'DD/MM/YYYY' }
	});

	if('<?php echo $log;?>' != "admin"){
		$.ajax({
			type: "POST",
			url: "phpservices/employee_rights.php",
			dataType:'JSON',
			data: {empid:<?php echo $login_id ?? 0;?>, moduleid:$("#modulenamebox").val()},
			success: function(result) {
				$("#rightsbox").val(result.rights);
			}
		});
	}

	$.ajax({
		type: "POST",
		url: "phpservices/customer_dropdown.php",
		success: function(result) {
			if (result && result.customer_id) {
				var d_data = '<option value="">Select Customer</option>';
				for(var i=0; i < result.customer_id.length; i++){
					d_data += '<option value="' + result.customer_id[i] + '">' + result.customer_name[i] + '</option>';
				}
				$("#customer_id").empty().append(d_data).removeAttr("disabled");
			}
			$(".page-loader").hide();	
		}							
	});

	var dataTable = $('#detailsgrid').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"responsive": true,
		"ajax": {
			url: "services_non_sales_details_grid.php",
			type: "post",
			data: { cond: "firstbind" },
			error: function(xhr, status, error){
				console.log(JSON.stringify(xhr, status, error));
			}
		}
	});

	$("#searchbtn").click(function(){
		var fdate = $('#sfdate2').val();
		var tdate = $('#stdate2').val();
		var cust_id = $('#customer_id').val();

		$('#detailsgrid').DataTable().destroy();
		dataTable = $('#detailsgrid').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"ajax": {
				url: "services_non_sales_details_grid.php",
				type: "post",
				data: { cond: "searchbind", fdate: fdate, tdate: tdate, customer_id: cust_id },
				error: function(xhr, status, error){
					console.log(JSON.stringify(xhr, status, error));
				}
			}
		});
	});

	$("#searchrefresh").click(function(){
		$('#customer_id').val('').trigger('change');
		$('#detailsgrid').DataTable().destroy();
		dataTable = $('#detailsgrid').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"ajax": {
				url: "services_non_sales_details_grid.php",
				type: "post",
				data: { cond: "firstbind" }
			}
		});
	});

	$(document).on('click', '.salesdeleteTriger', function(){
		var delid = $(this).data('value');
		swalConfirm("Do you want to Delete this Service Bill?", function(){
			$.ajax({
				type: "POST",
				url: "services_non_sales_details_service.php",
				dataType: 'json',
				data: { delid: delid, req: "DEL" },
				success: function(result) {
					if(result.op == 1 || result.op == true){
						swal("Success!", "Successfully Deleted!", "success");
						$('#detailsgrid').DataTable().ajax.reload();
					} else {
						swal("Error!", "Delete failed", "error");
					}
				},
				error: function(xhr, status, error){
					console.log(JSON.stringify(xhr, status, error));
				}
			});
		});
	});
});	
</script>
</html>
