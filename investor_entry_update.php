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

							<div class="col-md-6">


								
								<div class="form-group row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label text-left">Select Investor : <a href="javascript:void(0)" id="color_add_but" data-toggle="modal" data-target="#investorModalCenter">&nbsp;<i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a></label>
                                    <div class="col-md-5">
										<select  class="form-control investor_id" id="investor_id" name="investor_id" >
										
									
										</select>
									</div>
								</div> 
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">Amount :</label>
									<div class="col-sm-5">										
										<input type="text" class="form-control" id="amount" name="amount">
									</div>
								</div>
								
								                          
                                    
                                    
                            </div>

													


								<div class="col-md-6">
									
									
										
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Date :</label>
											<div class="col-sm-5">
												<input type="text" id="invoice_date" class="form-control" placeholder="Date" name="invoice_date" >
												<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
											</div>
										</div>	
																	
                                    
                                </div>							
							
							
						<br>

						
							
							
							<div class="col-md-2">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>">

									<button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-top:32px;">Save</button>
									<button type="reset" name="submit" id="submit" class="btn btn-danger" style="margin-top:32px;">Reset</button>
								</div>
							</div>
							<div class="col-md-2">
								<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>

									
					</form>
                </div>
            </div>
		</div>
	</div>
</main>

<div class="modal fade" id="investorModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Investor Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="mainforminvestor" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="minvestor_id" id="minvestor_id" >
										<label>Investor Name:</label>
										<input type="text" placeholder="Investor Name" id="investor_name" name="investor_name"  class="form-control">
									
									</div>
								</div>
							
								<input type="hidden" name="req" id="investorreq">
								<span id="investormsg" style="font-weight:bold;float:left;margin-top:7px;"></span>
								<div class="col-md-2">
									<div class="form-group" style="padding-top: 25px;">
										<button type="button" name="submit" id="submitinvestor" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;">Save</button>
										<button type="button" name="submit" id="updateinvestor" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;display:none;">Update</button>
									</div>
								</div>
							</div>
						</form>
						<hr style="margin:15px 0 10px 0;"/>
						<table id="investorgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Investor Name</th>
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
<!-- end::main content -->

<?php include("footer.php") ?>


<input type="hidden" name="modulenamebox" id="modulenamebox" value="13">
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

	
	function reloadInvestorDropdowns() {
		$.ajax({
			type: "POST",
			url: "investor_dropdown.php",
			success: function(result) {
				if(result && result.investor_id) {
					var investor_id=result.investor_id;
					var investor_name=result.investor_name;
					var d_data="<option value=\"\">Select Investor</option>";
					for(var i=0;i<investor_id.length;i++){
						d_data +="<option value=\""+investor_id[i]+"\">"+investor_name[i]+"</option>";
					}
					$(".investor_id").empty().append(d_data).removeAttr("disabled");
				}
				$(".page-loader").hide();	
			}							
		});
	}

	if (!$.fn.DataTable.isDataTable("#investorgrid")) {
		$("#investorgrid").DataTable({
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"ajax": {
				url: "investor_grid.php",
				type: "post",
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
				}
			}
		});
	}

	$("#investorModalCenter").on("shown.bs.modal", function() {
		if ($.fn.DataTable.isDataTable("#investorgrid")) {
			$("#investorgrid").DataTable().columns.adjust().responsive.recalc();
		}
	});

	$(document).on("click", "#investorgrid .deleteTriger", function(e) {
		e.preventDefault();
		e.stopPropagation();
		var delid = $(this).attr("data-value") || $(this).data("value") || $(this).closest("[data-value]").attr("data-value");
		swalConfirm("Do you want to Delete this Investor?", function(){
			$.ajax({
				type: "POST",
				url: "investor_service.php",
				dataType: "json",
				data: { delid: delid, req: "DEL" },
				success: function(result) {
					if (result.op == 1 || result.op == true) {
						if (typeof swal === "function") {
							swal("Success!", "Successfully Deleted !", "success");
						} else {
							alert("Successfully Deleted !");
						}
						$("#investorgrid").DataTable().ajax.reload(null, false);
						if ($.fn.DataTable.isDataTable("#detailsgrid")) {
							$("#detailsgrid").DataTable().ajax.reload(null, false);
						}
						if (typeof reloadInvestorDropdowns === "function") {
							reloadInvestorDropdowns();
						}
					} else {
						alert("Delete failed");
					}
				},
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
				}
			});
		});
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


	$('input[name="invoice_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});


	
	$.ajax({
			
			type: "POST",
			url: "investor_dropdown.php",
			success: function(result) {				
				var investor_id=result.investor_id;
				var investor_name=result.investor_name;
				var d_length=result.investor_id.length;
				var d_data='<option value="">Select Investor</option>';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+investor_id[i]+'">'+investor_name[i]+'</option>';
					
				}
				$(".investor_id").removeAttr("disabled");
				$(".investor_id").append(d_data);
				$(".page-loader").hide();	
			}						
	});


		var ids_string=<?php echo $_GET['id']; ?>;
		$(".page-loader").show();
		$.ajax({
			type: "POST",
			url: "investor_entry_service.php",
			dataType:'json',
			data: {id:ids_string,req:"AUB"},
			success: function(result) {
				
				$("#invoice_date").val(result.op[0]['billing_date']);

				setTimeout(function(){
					$("#investor_id").val(result.op[0]['investor_id']);
				},1000);

				
				$("#amount").val(result.op[0]['amount']);
				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});	

/**************************Investor Start**************************/

	
$("#submitinvestor").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#investor_name").val()==''){
				$("#investormsg").css("color","red").html('* Enter Investor Name');
				setTimeout(function(){$("#investormsg").html('')},3000);
				return false;
			}		
			else{
				$("#investorreq").val('ENTRY_ADD');
				$("#investormsg").css("color","green").html("Processing . . .");
				$.ajax({
					type: "POST",
					url: "investor_service.php",
					dataType:'json',
					data: $("#mainforminvestor").serialize(),
					success: function(result) {
						if(result.op==1){
							$("#investormsg").css("color","green").html("Successfully Saved !");
							setTimeout(function(){$("#investormsg").html('')},1000);
							if ($.fn.DataTable.isDataTable('#detailsgrid')) {
								$('#detailsgrid').DataTable().ajax.reload();
							}
							$("#investor_name").val('');
							$("#investorgrid").DataTable().ajax.reload();
							reloadInvestorDropdowns();
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

	

	/**************************Investor End**************************/


	 $("#submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		
		if($("#invoice_date").val()==''){
			$("#msg").css("color","red").html('* Enter invoice date');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#investor_id").val()==''){
			$("#msg").css("color","red").html('* Enter investor Name');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}	
		else if($("#amount").val()==''){
			$("#msg").css("color","red").html('* Enter amount');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}	
		else{
			$(".page-loader").show();
			$("#req").val('UPD');
			$.ajax({
					type: "POST",
					url: "investor_entry_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						$(".page-loader").hide();
						if(result.op==1){
							swal("Success!", "Successfully Updated !", "success");
							setTimeout(function(){
								window.location.href="investor_entry_details.php";
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