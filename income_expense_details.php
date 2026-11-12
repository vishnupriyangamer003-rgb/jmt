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
            <h4>Expense Details</h4>
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">

							<div class="col-md-12">
								<div class="card" style="border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc;">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label for="order_date"><strong>Date :</strong> <span style="color:red">*</span></label>
													<input type="text" id="order_date" class="form-control" placeholder="Select Date" name="order_date">
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label><strong>Expense Header :</strong> <span style="color:red">*</span> <a href="income_header_details.php" title="Add Expense Header">&nbsp;<i class="fa fa-plus-circle" style="font-size:22px;color:red;vertical-align:middle;"></i></a></label>
													<select class="form-control js-example-basic-single expense_header_id" id="expense_header_id" name="expense_header_id[]">
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label><strong>Amount :</strong> <span style="color:red">*</span></label>
													<input type="number" step="any" min="0" id="expense_amount" class="form-control expense_amount" name="expense_amount[]" placeholder="Enter Amount">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label><strong>Payment Mode :</strong></label>
													<select class="form-control" id="payment_mode" name="payment_mode">
														<option value="Cash">Cash</option>
														<option value="Bank">Bank</option>
														<option value="UPI">UPI</option>
														<option value="Cheque">Cheque</option>
														<option value="Other">Other</option>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label><strong>Reference No :</strong></label>
													<input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Reference number">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label><strong>Description / Remarks :</strong></label>
													<input type="text" class="form-control" id="remarks" name="remarks" placeholder="Description / Remarks">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-top:15px;min-width:120px;">Save</button>									
									<button type="reset" name="resetbut" id="resetbut" class="btn btn-danger" style="margin-top:15px;min-width:120px;">Reset</button>
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

	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                   <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
						<tr>
							<th>S.no</th> 
							<th>Date</th> 
							<th>Expense&nbsp;Header</th>
							<th>Expense&nbsp;Amount</th>    
							<th>Action</th>
						</tr>
                    </thead>
					<tbody>
					</tbody>
				   </table>
                </div>
            </div>
		</div>
	</div>

</main>
<!-- end::main content -->

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
<!-- begin::datepicker -->
<script src="vendors/datepicker/daterangepicker.js"></script>
<!-- end::datepicker -->

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

	$('#detailsgrid').DataTable({
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"income_expense_grid.php",
            type: "post",
            error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
            }
		 }
    });	

	$("#resetbut").click(function(){
		setTimeout(function(){
			window.location.href='income_expense_details.php';
		},500);
	});

	$.ajax({
		type: "POST",
		url: "income_expense_dropdown.php",
		dataType: 'json',
		success: function(result) {
			if (result && result.income_header_id) {
				expenseHeaders = result;
				$(".expense_header_id").each(function(){
					var $select = $(this);
					fillExpenseHeaders($select);
					if ($select.hasClass("select2-hidden-accessible")) {
						$select.select2('destroy');
					}
					$select.select2({});
				});
			}
		},
		error:function(xhr,status,error){
			console.log(JSON.stringify(xhr,status,error));
		},
		complete: function() {
			$(".page-loader").hide();
		}
	});

	function hasRights(){
		var emprights=$("#rightsbox").val();
		return emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin';
	}

	$("#submit").click(function(e){
		e.preventDefault();
		if(!hasRights()){
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
		if($("#order_date").val()==''){
			swal("Error!", "Select Date !", "warning");
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

		$("#req").val('ADDINS');
		$("#submit").prop("disabled", true);
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
					$("#submit").prop("disabled", false);
					$("#msg").css("color","red").html("Save failed. Please try again.");
				}
			},
			error:function(xhr,status,error){
				$("#submit").prop("disabled", false);
				$("#msg").css("color","red").html("Save failed. Please try again.");
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	});

 	$(document).on('click','.income_expensedeleteTriger', function(e){
		e.preventDefault();
		if(!hasRights()){
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
		var delid=$(this).data('value');
		if (confirm("Do you want to Delete ?")) {
			$.ajax({
				type: "POST",
				url: "income_expense_service.php",
				dataType:'json',
				data: {delid:delid,req:"DEL"},
				success: function(result) {
					if(result.op==1 || result.op==true){
						swal("Success!", "Successfully Deleted !", "success");
						$('#detailsgrid').DataTable().ajax.reload(null, false);
					} else {
						swal("Error!", "Delete failed !", "error");
					}
				},
				error:function(xhr,status,error){
					console.log(JSON.stringify(xhr,status,error));
				}
			});
		}
	});
});

var expenseHeaders = null;

function fillExpenseHeaders($select){
	$select.empty().append($('<option>', {value: '', text: 'Select Expense Header'}));
	if (expenseHeaders) {
		for (var i = 0; i < expenseHeaders.income_header_id.length; i++) {
			$select.append($('<option>', {value: expenseHeaders.income_header_id[i], text: expenseHeaders.income_header_name[i]}));
		}
	}
	$select.trigger('change');
}
</script>
</html>