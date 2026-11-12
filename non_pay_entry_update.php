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
<?php include('sessionservices.php');?>
<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading ...</span>
</div>
<!-- end::page loader -->

<?php echo $header;?>
<main class="main-content">

	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
					<form id="mainform" method="POST" action="" enctype="multipart/form-data">
					<div class="row">

							<div class="col-md-3">
								<div class="form-group">
									<label>Pay Type :</label><span style="color:red">*</span>
									<select  class="form-control " id="pay_type" name="pay_type" >
										<option value='1'>INWARD</option>
										<option value='2'>OUTWARD</option>
									</select>

									
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Income & Expense Header: <a href="income_header_details.php">&nbsp;<i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a></label><span style="color:red">*</span>
									<select  class="form-control  expense_header_id" id="expense_header_id" name="expense_header_id" >
										
									</select>

									
								</div>
							</div>


							<?php
									$sql="SELECT *,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_pay_entry  a  WHERE   a.pay_id='".$_GET['id']."'";
									$exec_sql=mysqli_query($conn,$sql);
									$fetch_sql=mysqli_fetch_array($exec_sql);?>


							<div class="col-md-3">
								<div class="form-group">
									<label>Date :</label><span style="color:red">*</span>
									<input type="text" id="billing_date" class="form-control"  name="billing_date" value="<?php echo $fetch_sql['billing_date'];?>" >
								</div>
							</div>

							
							<div class="col-md-3">
								<div class="form-group">
									<label>Amount :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="amount" name="amount" placeholder="Enter amount">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Remarks :</label>
									<input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter remarks">
								</div>
							</div>
						
							<input type="hidden" name="req" id="req">
							<input type="hidden" name="pay_id" id="pay_id" value="<?php echo $_GET['id'];?>">
							<div class="col-md-3">
								<div class="form-group" style="margin-top:32px;">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="font-weight:bold"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Update</button>
									<a href="non_pay_entry_details.php"><button type="button" id="resetbut" class="btn btn-danger" style="font-weight:bold"><i class="fa fa-close"></i>&nbsp;&nbsp;Cancel</button></a>
								</div>
							</div>
							
						
							<span id="msg" style="font-weight:bold;float:right;margin-top:7px;"></span>
						</div>
					</form>
                </div>
            </div>
		</div>
	</div>
</main>
<!-- end::main content -->



<div class="modal fade" id="incomeModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Income and Expense Header Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="income_mainform" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Name :</label><span style="color:red">*</span>
										<input type="text" class="form-control" id="income_header_name" name="income_header_name" placeholder="Enter Income and Expense Header">
									</div>
								</div>								

								
								<div class="col-md-3">
									<span id="cus_msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
								</div>
							</div>
							<div class='row'>
							
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="req" id="income_req">
										<button type="submit" name="income_submit" id="income_submit" class="btn btn-success">Save</button>									
										
									</div>
								</div>
							</div>
						</form>
						<hr style="margin:15px 0 10px 0;"/>
						<table id="incomeheadergrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Name</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
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

<?php include("footer.php") ?>


<input type="hidden" name="modulenamebox" id="modulenamebox" value="1">
<input type="hidden" name="rightsbox" id="rightsbox">
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
<script src="js/examples/sweet-alert.js"></script>
<!-- end::custom scripts -->

</body>

<script>
$(document).ready(function(){


	
	function reloadIncomeDropdowns() {
		$.ajax({
			type: "POST",
			url: "income_expense_dropdown.php",
			success: function(result) {
				if(result && result.income_header_id) {
					var income_header_id=result.income_header_id;
					var income_header_name=result.income_header_name;
					var d_data="<option value=\"\">Select Income Header</option>";
					for(var i=0;i<income_header_id.length;i++){
						d_data +="<option value=\""+income_header_id[i]+"\">"+income_header_name[i]+"</option>";
					}
					$(".income_header_id").empty().append(d_data).removeAttr("disabled");
					
					var d_exp="<option value=\"\">Select Expense Header</option>";
					for(var i=0;i<income_header_id.length;i++){
						d_exp +="<option value=\""+income_header_id[i]+"\">"+income_header_name[i]+"</option>";
					}
					$(".expense_header_id").empty().append(d_exp).removeAttr("disabled");
				}
				$(".page-loader").hide();	
			}							
		});
	}

	if (!$.fn.DataTable.isDataTable("#incomeheadergrid")) {
		$("#incomeheadergrid").DataTable({
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"ajax": {
				url: "income_header_grid.php",
				type: "post",
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
				}
			}
		});
	}

	$("#incomeModalCenter").on("shown.bs.modal", function() {
		if ($.fn.DataTable.isDataTable("#incomeheadergrid")) {
			$("#incomeheadergrid").DataTable().columns.adjust().responsive.recalc();
		}
	});

	$(document).on("click", "#incomeheadergrid .deleteTriger", function(e) {
		e.preventDefault();
		e.stopPropagation();
		var delid = $(this).attr("data-value") || $(this).data("value") || $(this).closest("[data-value]").attr("data-value");
		var alertmsg = confirm("Do you want to Delete this Header?");
		if (alertmsg == true) {
			$.ajax({
				type: "POST",
				url: "income_header_service.php",
				dataType: "json",
				data: { delid: delid, req: "DEL" },
				success: function(result) {
					if (result.op == 1 || result.op == true) {
						if (typeof swal === "function") {
							swal("Success!", "Successfully Deleted !", "success");
						} else {
							alert("Successfully Deleted !");
						}
						$("#incomeheadergrid").DataTable().ajax.reload(null, false);
						if ($.fn.DataTable.isDataTable("#detailsgrid")) {
							$("#detailsgrid").DataTable().ajax.reload(null, false);
						}
						if (typeof reloadIncomeDropdowns === "function") {
							reloadIncomeDropdowns();
						}
					} else {
						alert("Delete failed");
					}
				},
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
				}
			});
		}
	});

$('input[name="billing_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});



	$.ajax({
		
		type: "POST",
		url: "bank_income_expense_dropdown.php",
		success: function(result) {
			var income_header_id=result.income_header_id;
			var income_header_name=result.income_header_name;
			var d_length=result.income_header_id.length;
			var d_data='<option value="">Select Expense Header </option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+income_header_id[i]+'">'+income_header_name[i]+'</option>';
				
			}
			$(".expense_header_id").removeAttr("disabled");
			$(".expense_header_id").append(d_data);
			$(".page-loader").hide();	
		}							
	});

	  $("#income_submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#income_header_name").val()==''){
				swal("Error!", " Enter Income Expense Name !", "warning");
				return false;
			}
			else{
				$("#income_req").val('ADDINCOMEINS');
				$.ajax({
					type: "POST",
					url: "income_expense_service.php",
					dataType:'json',
					data: $("#income_mainform").serialize(),
					success: function(result) {
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							$("#income_header_name").val("");
							$("#incomeheadergrid").DataTable().ajax.reload();
							reloadIncomeDropdowns();
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
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
	var ids_string=<?php echo $_GET['id']; ?>;
	$(".page-loader").show();
	$.ajax({
		type: "POST",
		url: "non_pay_entry_service.php",
		dataType:'json',
		data: {pay_id:ids_string,req:"AUB"},
		success: function(result) {

			setTimeout(function(){
				$("#expense_header_id").val(result.op[0]['expense_header_id']);
			},1000);
			
			//$("#billing_date").val(result.op[0]['billing_date']);
			$("#pay_type").val(result.op[0]['pay_type']);
			$("#amount").val(result.op[0]['amount']);
			$("#remarks").val(result.op[0]['remarks']);
			
			$(".page-loader").hide();
		},error:function(xhr,status,error){
			console.log(JSON.stringify(xhr,status,error));
		}
	});	



	 $("#submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#customer_name").val()==''){
			$("#msg").css("color","red").html('* Enter customer name');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		
		if($("#amount").val()==''){
			$("#msg").css("color","red").html('* Enter amount');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			$(".page-loader").show();
			$("#req").val('UPD');
			$.ajax({
					type: "POST",
					url: "non_pay_entry_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						$(".page-loader").hide();
						if(result.op==1){
							swal("Success!", "Successfully Updated !", "success");
							setTimeout(function(){
								window.location.href="non_pay_entry_details.php";
							},1000);
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
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
</script>
</html>