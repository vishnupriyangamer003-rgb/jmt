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

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>Staff Details</h4>
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body" style="padding-top:10px;padding-bottom:5px;">
					<form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Staff Name :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="Enter Staff Name">
								</div>
							</div>
							
							<!--div class="col-md-3">
								<div class="form-group">
									<label> Designation :</label>
									<input type="text" class="form-control" id="emp_desig" name="emp_desig" placeholder="Enter  Designation">
								</div>
							</div-->
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Mobile No :</label>
									<input type="number" class="form-control" id="emp_mblno" name="emp_mblno" placeholder="Enter  Mobile No">
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
							<div class="col-md-3">
								<div class="form-group">
									<label>Address :</label>
									<textarea class="form-control" id="emp_addr" name="emp_addr" placeholder="Enter Address"></textarea>
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
						
							
							<div class="col-md-12 text-center" style="margin-top:15px;">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="min-width:120px;">Save</button>
									<button type="reset" name="reset" id="btnReset" class="btn btn-danger" style="min-width:120px;">Reset</button>
							</div>
							<span id="msg" style="font-weight:bold;float:right;margin-top:32px;"></span>
						</div>
                      
					
                    </form>
				</div>
				<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
				<button type="button" class="btn btn-success sweet-change" style="display:none"></button>
				<div class="card-body" style="padding-top:5px">
				<hr style="margin-top:5px;margin-bottom:5px;border-color:#fff"/>
                   <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
						<th>S.no</th>						
                        <th>Staff&nbsp;Name</th>
                        <th>Mobile&nbsp;No</th>
                        <th>Email</th>
						<th>Staff&nbsp;Type</th>
						<th>Salary&nbsp;Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
				</div>
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

	
<?php include("footer.php") ?>
<!-- end::main content -->

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
	$(".contractor").hide();

	$('#detailsgrid').tooltip({selector: '[data-toggle="tooltip"]'});

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

	$('#detailsgrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"staff_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
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
		if (emprights == '1' || emprights == '5' || emprights == '6' || emprights == '7' || '<?php echo $log;?>' == 'admin') {
		// alert($("#contract").val());
			if($("#emp_name").val()==""){
				swal("Error!", "Enter Staff Name !", "warning");
				return false;
			}		
			else if($("#emp_desig").val()==""){
				swal("Error!", "Enter Designation !", "warning");
				return false;
			}				
			else if($("#emp_mblno").val()==""){
				swal("Error!", "Enter Mobile Number !", "warning");
				return false;
			}
			else if($("#emp_salary").val()==""){
				swal("Error!", "Select Emp salary type !", "warning");
				return false;
			}
			else if($("#emp_type").val()==""){
				swal("Error!", "Select Emp type !", "warning");
				return false;
			}			
			else if($("#mailcheck").val()=='1'){
				swal("Error!", "Enter Valid Email Id !", "warning");
				return false;
			}
			
			else{
				$("#req").val('INS');
				$("#msg").css("color","#fff").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "phpservices/employee_functions.php",
						dataType:'json',
						data: $("#mainform").serialize(),
						success: function(result) {
							if(result.op==1){
								swal("Success!", "Successfully Saved !", "success");
								setTimeout(function(){
									window.location.href="staff_details.php";
								},1000);
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
		
	$(document).on('click','.deleteTriger', function(){
		var delid=$(this).data('value');
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='5' || emprights=='2' || emprights=='3' || '<?php echo $log;?>' == 'admin'){
			swalConfirm("Do you want to Delete ?", function(){
				$.ajax({
							type: "POST",
							url: "phpservices/employee_functions.php",
							dataType:'json',
							data: {delid:delid,req:"DEL"},
							success: function(result) {
								console.log(result.op);
								if(result.op==1){
									swal("Success!", "Successfully Deleted !", "success");
									setTimeout(function(){
										window.location.href="staff_details.php";
									},1500);
								}
								else{
									$("#msg").html(result.op);
								}
							},error:function(xhr,status,error){
								console.log(JSON.stringify(xhr,status,error));
							}
						});
			});
		}
		else{
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});
		
	$(document).on('click','.statuschanger', function(){
		var status=$(this).data('value'),emp_id=$(this).data('emp_id');
		var emprights=$("#rightsbox").val();
		if (emprights == '1' || emprights == '5' || emprights == '6' || emprights == '7' || '<?php echo $log;?>' == 'admin') {
			swalConfirm("Do you want to Change the Status ?", function(){
				$.ajax({
							type: "POST",
							url: "phpservices/employee_functions.php",
							dataType:'json',
							data: {status:status,emp_id:emp_id,req:"STATUSCHANGE"},
							success: function(result) {
								console.log(result.op);
								if(result.op==1){
									//$("#msg").css("color","#fff").html("Successfully Changed !");
									swal("Success!", "Status Changed Successfully !", "success");
									setTimeout(function(){
										window.location.href="staff_details.php";
									},1500);
								}
								else{
									$("#msg").html(result.op);
								}
							},error:function(xhr,status,error){
								console.log(JSON.stringify(xhr,status,error));
							}
						});
			});
		}
		else{
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});
	


	

});
</script>
</html>