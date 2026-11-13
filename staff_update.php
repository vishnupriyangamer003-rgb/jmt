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

<!-- begin::main content -->
<main class="main-content">
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body" style="padding-top:10px;padding-bottom:5px;">
					<form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">

						<input type="hidden" name="emp_status" value="S">
							<div class="col-md-12 col-lg-12 col-xs-12">
								<div class="card" style="margin-bottom:10px">
									<div class="card-header text-center" style="padding:3px"><h4 style="font-weight:bold;margin-bottom:0">Update Staff Details</h4></div>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Staff Name :</label>
									<input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="Enter Staff Name">
								</div>
							</div>
							
							
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Mobile No :</label>
									<input type="number" class="form-control" id="emp_mblno" name="emp_mblno" placeholder="Enter Employee Mobile No">
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Email : <span style="font-weight:bold;color:red" id="emailmsg"></span></label>
									<input type="email" class="form-control" id="emp_email" name="emp_email" placeholder="Enter Email">
									<input type="hidden" id="mailcheck">
								</div>
							</div>
									<input type="hidden" id="req" name="req">
									<input type="hidden" id="emp_id" name="emp_id" value="<?php echo $_GET['id'];?>">
							<div class="col-md-3">
								<div class="form-group">
									<label>Address :</label>
									<textarea class="form-control" id="emp_addr" name="emp_addr" placeholder="Enter Employee Address"></textarea>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Salary :</label>
									<input type="number" class="form-control" id="salary" name="salary" placeholder="Enter salary">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Staff Type :</label><span style="color:red">*</span><a href="javascript:void(0)" id="cat_add_but" data-toggle="modal" data-target="#stafftypeModalCenter"><i class="fa fa-plus-circle" style="font-size:25px;position:absolute;margin-left:6px;color:red;"></i></a>
									<select  class="form-control emp_type" id="emp_type" name="emp_type" >
									</select>
									
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Salary Type :</label><span style="color:red">*</span><a href="javascript:void(0)" id="cat_add_but" data-toggle="modal" data-target="#staffsalaryModalCenter"><i class="fa fa-plus-circle" style="font-size:25px;position:absolute;margin-left:6px;color:red;"></i></a>
									<select  class="form-control emp_salary" id="emp_salary" name="emp_salary" >
									</select>
									
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group" style="margin-top: 30px;">
									<a href="employee_details.php"><button type="button" class="btn btn-danger" style="float:right;margin-bottom:10px;margin-left:10px">Cancel</button></a>
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;margin-bottom:10px;">Update</button>
									<span id="msg" style="font-weight:bold;float:right;margin-top:7px;"></span>
								</div>
							</div>
						</div>
                    </form>
				</div>
				<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
            </div>
		</div>
	</div>
<input type="hidden" name="modulenamebox" id="modulenamebox" value="2">
<input type="hidden" name="rightsbox" id="rightsbox">
</main>


<div class="modal fade" id="staffsalaryModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Emp Salary Type</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="mainformsalary" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
									<input type="hidden" name="salary_id" id="salary_id" >
										<label>Salary Type:</label>
										<input type="text" placeholder="Salary Type" id="emp_salary_name" name="emp_salary_name"  class="form-control">
									
									</div>
								</div>
							
								<input type="hidden" name="req" id="salaryreq">
								<span id="salarymsg" style="font-weight:bold;float:left;margin-top:7px;"></span>
								<div class="col-md-2">
									<div class="form-group" style="padding-top: 25px;">
										<button type="button" name="submit" id="submitsalary" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;">Save</button>
										<button type="button" name="submit" id="updatesalary" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;display:none;">Update</button>
									</div>
								</div>
							</div>
						</form>
						<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
						<hr style="padding-top:0;margin-top:0"/>
						<table id="salarygrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Name</th>
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



<div class="modal fade" id="stafftypeModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Emp Type</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="mainformtype" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
									<input type="hidden" name="type_id" id="type_id" >
										<label>Employee Type:</label>
										<input type="text" placeholder="Employee Type" id="emp_type_name" name="emp_type_name"  class="form-control">
									
									</div>
								</div>
							
								<input type="hidden" name="req" id="typereq">
								<span id="typemsg" style="font-weight:bold;float:left;margin-top:7px;"></span>
								<div class="col-md-2">
									<div class="form-group" style="padding-top: 25px;">
										<button type="button" name="submit" id="submittype" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;">Save</button>
										<button type="button" name="submit" id="updatetype" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;display:none;">Update</button>
									</div>
								</div>
							</div>
						</form>
						<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
						<hr style="padding-top:0;margin-top:0"/>
						<table id="typegrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Name</th>
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
<script src="js/examples/sweet-alert.js"></script>
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
}

@media(max-width:480px){
	nav.navbar .header-logo a img{
		width:180px;
	}
}

</style>
<script>
$(document).ready(function(){
	$('#contract').on('click', function () {
    $(this).val(this.checked ? 'YES' : 'NO');
    // console.log($(this).val());
	if($(this).val()=="YES"){
		$(".contractor").show();
	}
	else{
		$(".contractor").hide();
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
$.ajax({
		type: "POST",
		url: "phpservices/warehouse_dropdown.php",
		success: function(result) {
		if(result.s_id){
			var sid=result.s_id;
			var sname=result.s_name;
			var d_length=result.s_id.length;
			var d_data='<option value="">Select Warehouse</option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
			}
			$("#warehouse_id").removeAttr("disabled");
			$("#warehouse_id").append(d_data);
			$("#grid-loader").hide();
		}
		else{
			$("#grid-loader").hide();
		}
		}
	});
	$("#contractor_id").empty();
	$.ajax({
		type: "POST",
		url: "phpservices/contractor_dropdown.php",
		success: function(result) {
		if(result.s_id){
			var sid=result.s_id;
			var sname=result.s_name;
			var d_length=result.s_id.length;
			var d_data='<option value="">Select contractor</option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
			}
			$("#contractor_id").removeAttr("disabled");
			$("#contractor_id").append(d_data);
			$("#grid-loader").hide();
		}
		else{
			$("#grid-loader").hide();
		}
		}
		});
var ids_string=<?php echo $_GET['id']; ?>

$.ajax({
		type: "POST",
		url: "phpservices/employee_functions.php",
		dataType:'json',
		data: {emp_id:ids_string,req:"AUB"},
		success: function(result) {
			$("#emp_name").val(result.op[0]['emp_name']);
			$("#emp_desig").val(result.op[0]['emp_desig']);
			
			setTimeout(function(){
				$("#emp_type").val(result.op[0]['emp_type']);
			},1000);

			setTimeout(function(){
				$("#emp_salary").val(result.op[0]['emp_salary_type']);
			},1000);

			$("#salary").val(result.op[0]['salary']);
			$("#comments").val(result.op[0]['comments']);
			$("#emp_dob").val(result.op[0]['emp_dob']);
			$("#emp_mblno").val(result.op[0]['emp_mblno']);
			$("#emp_amblno").val(result.op[0]['emp_amblno']);
			$("#emp_email").val(result.op[0]['emp_email']);
			
			$("#emp_addr").val(result.op[0]['emp_addr']);
			
		},error:function(xhr,status,error){
			console.log(JSON.stringify(xhr,status,error));
		}
	});	
		
	// $("#warehouse_id").empty();
		
	$("#dob").change(function(){
		$("#emp_dob").val($("#dob").val());
	});
		
	$("#emp_email").blur(function(e){
		e.preventDefault();
		var mailids=$(this).val();
		if(mailids!=""){
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			if (reg.test(mailids) == false){
				$("#emailmsg").css("color","red").html("&nbsp;&nbsp;&nbsp;* Invalid Email Address");
				setTimeout(function(){$("#emailmsg").html('');},3000);
				$("#mailcheck").val('1');
				return false;
			}
			else{
				$("#mailcheck").val('');
		    }
		}
		else{
			$("#mailcheck").val('');
		}
	});


	$.ajax({
			
			type: "POST",
			url: "staff_salary_dropdown.php",
			success: function(result) {				
				var emp_salary_id=result.emp_salary_id;
				var emp_salary_name=result.emp_salary_name;
				var d_length=result.emp_salary_id.length;
				var d_data='<option value="">Select Salary Type</option>';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+emp_salary_id[i]+'">'+emp_salary_name[i]+'</option>';
					
				}
				$(".emp_salary").removeAttr("disabled");
				$(".emp_salary").append(d_data);
				$(".page-loader").hide();	
			}							
	});

	$.ajax({
			
			type: "POST",
			url: "staff_type_dropdown.php",
			success: function(result) {				
				var emp_type_id=result.emp_type_id;
				var emp_type_name=result.emp_type_name;
				var d_length=result.emp_type_id.length;
				var d_data='<option value="">Select Staff Type</option>';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+emp_type_id[i]+'">'+emp_type_name[i]+'</option>';
					
				}
				$(".emp_type").removeAttr("disabled");
				$(".emp_type").append(d_data);
				$(".page-loader").hide();	
			}							
	});
	
	
	/**************************Type Start**************************/

	$('#typegrid').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"responsive": true,
		"ajax":{
		url :"staff_type_grid.php", // json datasource
	
		type: "post",  // type of method  ,GET/POST/DELETE
		error: function(){
					console.log(JSON.stringify(xhr,status,error));
		}
		}
    });

	$("#submittype").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#emp_type_name").val()==''){
				$("#typemsg").css("color","red").html('* Enter Design');
				setTimeout(function(){$("#typemsg").html('')},3000);
				return false;
			}		
			else{
				$("#typereq").val('ADD_TYPE');
				$("#typemsg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "staff_type_service.php",
						dataType:'json',
						data: $("#mainformtype").serialize(),
						success: function(result) {
							console.log(result.op);
							if(result.op==1){
								$("#typemsg").css("color","green").html("Successfully Saved !");
									setTimeout(function(){$("#typemsg").html('')},1000);
								$('#detailsgrid').DataTable().ajax.reload();
								$('#typegrid').DataTable().ajax.reload();
								$("#emp_type_name").val('');
								$("#emp_type").val('');
								$("#emp_type").empty();
								$.ajax({
			
										type: "POST",
										url: "staff_type_dropdown.php",
										success: function(result) {				
											var emp_type_id=result.emp_type_id;
											var emp_type_name=result.emp_type_name;
											var d_length=result.emp_type_id.length;
											var d_data='<option value="">Select Type</option>';
											for(var i=0;i<=d_length-1;i++){
												d_data +='<option value="'+emp_type_id[i]+'">'+emp_type_name[i]+'</option>';
												
											}
											$(".emp_type").removeAttr("disabled");
											$(".emp_type").append(d_data);
											$(".page-loader").hide();	
										}						
								});
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

	$(document).on('click','.typedeleteTriger', function(){
		var delid=$(this).data('value');
			swalConfirm("Do you want to Delete ?", function(){
				$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: {delid:delid,req:"TYPEDEL"},
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							$("#typemsg").css("color","green").html("Successfully Deleted !");
							$(".sweet-delete").click();
							setTimeout(function(){$('#typegrid').DataTable().ajax.reload()},3000);
							$("#emp_type").empty();
							$.ajax({
		
								type: "POST",
								url: "staff_type_dropdown.php",
								success: function(result) {				
									var emp_type_id=result.emp_type_id;
									var emp_type_name=result.emp_type_name;
									var d_length=result.emp_type_id.length;
									var d_data='<option value="">Select Type</option>';
									for(var i=0;i<=d_length-1;i++){
										d_data +='<option value="'+emp_type_id[i]+'">'+emp_type_name[i]+'</option>';
										
									}
									$(".emp_type").removeAttr("disabled");
									$(".emp_type").append(d_data);
									$(".page-loader").hide();	
								}							
							});
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
			});
	});

	$(document).on('click','.typeupdateTriger', function(){
		$("#submittype").hide();
		$("#updatetype").show();
		var updid=$(this).data('value');
		$("#type_id").val(updid);
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
				$.ajax({
						type: "POST",
						url: "staff_type_service.php",
						dataType:'json',
						data: {type_id:updid,req:"TYPE_AUB"},
						success: function(result) {
								$("#emp_type_name").val(result.op[0]['name']);						
								$("#type_id").val(result.op[0]['id']);
								//$("#design_id").empty();
									
							},error:function(xhr,status,error){
								console.log(JSON.stringify(xhr,status,error));
							}
					});
				}
		else{
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});

	$("#updatetype").click(function(e){	
		e.preventDefault();
		// console.log("haiii");
		if($("#emp_type_name").val()==''){
			$("#typemsg").css("color","red").html('* Enter type name');
			setTimeout(function(){$("#typemsg").html('')},3000);
			return false;
		}
		
		else{
			$("#typereq").val('UPDATE_TYPE');
			$("#typemsg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "staff_type_service.php",
					dataType:'json',
					data: $("#mainformtype").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							$("#typemsg").css("color","green").html("Successfully Updated !");
							setTimeout(function(){$("#typemsg").html('')},1000);
							$(".sweet-update").click();
							$('#typegrid').DataTable().ajax.reload();
							$("#emp_type_name").val('');
							$("#type_id").val('');
							$("#submittype").show();
							$("#updatetype").hide();
							$("#emp_type").empty();
							$.ajax({
									type: "POST",
									url: "staff_type_dropdown.php",
									success: function(result) {				
										var emp_type_id=result.emp_type_id;
										var emp_type_name=result.emp_type_name;
										var d_length=result.emp_type_id.length;
										var d_data='<option value="">Select Type</option>';
										for(var i=0;i<=d_length-1;i++){
											d_data +='<option value="'+emp_type_id[i]+'">'+emp_type_name[i]+'</option>';
											
										}
										$(".emp_type").removeAttr("disabled");
										$(".emp_type").append(d_data);
										$(".page-loader").hide();	
									}							
							});
						}
						else{
							alert($("#typemsg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
	});

	/**************************Type End**************************/

	
	/**************************Salary Start**************************/

	$('#salarygrid').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"responsive": true,
		"ajax":{
		url :"staff_salary_grid.php", // json datasource
	
		type: "post",  // type of method  ,GET/POST/DELETE
		error: function(){
					console.log(JSON.stringify(xhr,status,error));
		}
		}
    });

	$("#submitsalary").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#emp_salary_name").val()==''){
				$("#salarymsg").css("color","red").html('* Enter Design');
				setTimeout(function(){$("#salarymsg").html('')},3000);
				return false;
			}		
			else{
				$("#salaryreq").val('ADD_SALARY');
				$("#salarymsg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "staff_salary_service.php",
						dataType:'json',
						data: $("#mainformsalary").serialize(),
						success: function(result) {
							console.log(result.op);
							if(result.op==1){
								$("#salarymsg").css("color","green").html("Successfully Saved !");
									setTimeout(function(){$("#salarymsg").html('')},1000);
								$('#detailsgrid').DataTable().ajax.reload();
								$('#salarygrid').DataTable().ajax.reload();
								$("#emp_salary_name").val('');
								$("#emp_salary").val('');
								$("#emp_salary").empty();
								$.ajax({
			
										type: "POST",
										url: "staff_salary_dropdown.php",
										success: function(result) {				
											var emp_salary_id=result.emp_salary_id;
											var emp_salary_name=result.emp_salary_name;
											var d_length=result.emp_salary_id.length;
											var d_data='<option value="">Select Salary Type</option>';
											for(var i=0;i<=d_length-1;i++){
												d_data +='<option value="'+emp_salary_id[i]+'">'+emp_salary_name[i]+'</option>';
												
											}
											$(".emp_salary").removeAttr("disabled");
											$(".emp_salary").append(d_data);
											$(".page-loader").hide();	
										}						
								});
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

	$(document).on('click','.salarydeleteTriger', function(){
		var delid=$(this).data('value');
			swalConfirm("Do you want to Delete ?", function(){
				$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: {delid:delid,req:"SALARYDEL"},
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							$("#salarymsg").css("color","green").html("Successfully Deleted !");
							$(".sweet-delete").click();
							setTimeout(function(){$('#salarygrid').DataTable().ajax.reload()},3000);
							
							$("#emp_salary").empty();
							$.ajax({
		
								type: "POST",
								url: "staff_salary_dropdown.php",
								success: function(result) {				
									var emp_salary_id=result.emp_salary_id;
									var emp_salary_name=result.emp_salary_name;
									var d_length=result.emp_salary_id.length;
									var d_data='<option value="">Select Salary Type</option>';
									for(var i=0;i<=d_length-1;i++){
										d_data +='<option value="'+emp_salary_id[i]+'">'+emp_salary_name[i]+'</option>';
										
									}
									$(".emp_salary").removeAttr("disabled");
									$(".emp_salary").append(d_data);
									$(".page-loader").hide();	
								}							
							});
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
			});
	});

	$(document).on('click','.salaryupdateTriger', function(){
		$("#submitsalary").hide();
		$("#updatesalary").show();
		var updid=$(this).data('value');
		$("#salary_id").val(updid);
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
				$.ajax({
						type: "POST",
						url: "staff_salary_service.php",
						dataType:'json',
						data: {salary_id:updid,req:"SALARY_AUB"},
						success: function(result) {
								$("#emp_salary_name").val(result.op[0]['name']);						
								$("#salary_id").val(result.op[0]['id']);
								//$("#design_id").empty();
									
							},error:function(xhr,status,error){
								console.log(JSON.stringify(xhr,status,error));
							}
					});
				}
		else{
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});

	$("#updatesalary").click(function(e){	
		e.preventDefault();
		// console.log("haiii");
		if($("#emp_salary_name").val()==''){
			$("#salarymsg").css("color","red").html('* Enter Salary name');
			setTimeout(function(){$("#salarymsg").html('')},3000);
			return false;
		}
		
		else{
			$("#salaryreq").val('UPDATE_SALARY');
			$("#salarymsg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "staff_salary_service.php",
					dataType:'json',
					data: $("#mainformsalary").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							$("#salarymsg").css("color","green").html("Successfully Updated !");
							setTimeout(function(){$("#salarymsg").html('')},1000);
							$(".sweet-update").click();
							$('#salarygrid').DataTable().ajax.reload();
							$("#emp_salary_name").val('');
							$("#salary_id").val('');
							$("#submitsalary").show();
							$("#updatesalary").hide();
							$("#emp_salary").empty();
							$.ajax({
									type: "POST",
									url: "staff_salary_dropdown.php",
									success: function(result) {				
										var emp_salary_id=result.emp_salary_id;
										var emp_salary_name=result.emp_salary_name;
										var d_length=result.emp_salary_id.length;
										var d_data='<option value="">Select Salary Type</option>';
										for(var i=0;i<=d_length-1;i++){
											d_data +='<option value="'+emp_salary_id[i]+'">'+emp_salary_name[i]+'</option>';
											
										}
										$(".emp_salary").removeAttr("disabled");
										$(".emp_salary").append(d_data);
										$(".page-loader").hide();	
									}							
							});
						}
						else{
							alert($("#salarymsg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
	});

	/**************************Salary End**************************/

	
	$( "#submit" ).click(function(e) {
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if (emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin') {
			if($("#emp_name").val()==""){
				swal("Error!", "Enter Staff Name !", "warning");
				return false;
			}				
			else if($("#emp_mblno").val()==""){
				swal("Error!", "Enter Mobile Number !", "warning");
				return false;
			}			
			else if($("#mailcheck").val()=='1'){
				swal("Error!", "Enter Valid Email Id !", "warning");
				return false;
			}
			else{
				$("#req").val('UPD');
				$("#msg").css("color","#fff").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "phpservices/employee_functions.php",
						dataType:'json',
						data: $("#mainform").serialize(),
						success: function(result) {
							if(result.op==1){
								swal("Success!", "Successfully Updated !", "success");
									setTimeout(function(){
										window.location.href="staff_details.php";
									},1500);
							}
							else{
								$("#msg").css("color","red").html(result.op);
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