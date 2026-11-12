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
            <h4>Add Employee</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Employee Details</li>
                    <li class="breadcrumb-item active" aria-current="page">Add Employee </li>
                </ol>
            </nav>
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Employee Name : <span><a href="employee_details.php"><i class="fa fa-plus-circle" style="font-size:25px;position:absolute;margin-left:6px;color:red;"></i></a></span></label>
									<select class="form-control" id="emp_id" name="emp_id">
                                    </select>
									
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Username : <span id="unameshow" style="color:red">emp</span></label>
									<input type="text" class="form-control" placeholder="Enter Username" name="uname" id="uname">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Password :</label>
									<input type="password" class="form-control" placeholder="Enter Password" name="pass" id="pass" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
                        <div class="table-responsive">
							<table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col"><h5 style="font-weight:bold;position:relative;top:3px">Module</h5></th>
                                    <th scope="col"><h5 style="font-weight:bold;position:relative;top:3px">Add</h5></th>
                                    <th scope="col"><h5 style="font-weight:bold;position:relative;top:3px">Update</h5></th>
                                    <th scope="col"><h5 style="font-weight:bold;position:relative;top:3px">Delete</h5></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck1"><label class="custom-control-label" for="customCheck1"><h5 style="font-weight:bold;position:relative;top:3px">Master</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck2"><label class="custom-control-label" for="customCheck2"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck3"><label class="custom-control-label" for="customCheck3"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck4"><label class="custom-control-label" for="customCheck4"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck5"><label class="custom-control-label" for="customCheck5"><h5 style="font-weight:bold;position:relative;top:3px">Employee</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck6"><label class="custom-control-label" for="customCheck6"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck7"><label class="custom-control-label" for="customCheck7"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck8"><label class="custom-control-label" for="customCheck8"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck9"><label class="custom-control-label" for="customCheck9"><h5 style="font-weight:bold;position:relative;top:3px">Purchase order</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck10"><label class="custom-control-label" for="customCheck10"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck11"><label class="custom-control-label" for="customCheck11"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck12"><label class="custom-control-label" for="customCheck12"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck13"><label class="custom-control-label" for="customCheck13"><h5 style="font-weight:bold;position:relative;top:3px">Fabric Checking</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck14"><label class="custom-control-label" for="customCheck14"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck15"><label class="custom-control-label" for="customCheck15"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck16"><label class="custom-control-label" for="customCheck16"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck17"><label class="custom-control-label" for="customCheck17"><h5 style="font-weight:bold;position:relative;top:3px">Cutting</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck18"><label class="custom-control-label" for="customCheck18"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck19"><label class="custom-control-label" for="customCheck19"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck20"><label class="custom-control-label" for="customCheck20"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck21"><label class="custom-control-label" for="customCheck21"><h5 style="font-weight:bold;position:relative;top:3px">Stitching</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck22"><label class="custom-control-label" for="customCheck22"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck23"><label class="custom-control-label" for="customCheck23"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck24"><label class="custom-control-label" for="customCheck24"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck25"><label class="custom-control-label" for="customCheck25"><h5 style="font-weight:bold;position:relative;top:3px">Checking</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck26"><label class="custom-control-label" for="customCheck26"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck27"><label class="custom-control-label" for="customCheck27"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck28"><label class="custom-control-label" for="customCheck28"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
								<tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck29"><label class="custom-control-label" for="customCheck29"><h5 style="font-weight:bold;position:relative;top:3px">Packing</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck30"><label class="custom-control-label" for="customCheck30"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck31"><label class="custom-control-label" for="customCheck31"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck32"><label class="custom-control-label" for="customCheck32"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
								<tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck33"><label class="custom-control-label" for="customCheck33"><h5 style="font-weight:bold;position:relative;top:3px">Reports</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck34"><label class="custom-control-label" for="customCheck34"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck35"><label class="custom-control-label" for="customCheck35"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="customCheck36"><label class="custom-control-label" for="customCheck36"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                </tbody>
                            </table>
						</div>
							</div>
						</div>
                        <button type="submit" name="submit" id="submit" class="btn btn-success">Save</button>
						<a href="employee_rights_details.php"><button type="button" class="btn btn-danger">Cancel</button></a>
						<span id="msg" style="font-weight:bold;float:right;margin-top:7px;"></span>
                    </form>
                </div>
            </div>
		</div>
	</div>
</main>
<!-- end::main content -->

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
    $("#submit").click(function(e){
	e.preventDefault();		
	var emprights=$("#rightsbox").val();
	if (emprights == '1' || emprights == '5' || emprights == '6' || emprights == '7' || '<?php echo $log;?>' == 'admin') {
		if($("#emp_id").val()=='' || $("#emp_id").val()==null){
			$("#msg").html('* Choose Employee Name');
			setTimeout(function(){$("#msg").html('');},2500);
			return false;
		}
		else if($("#uname").val()==''){
			$("#msg").html('* Enter Username');
			setTimeout(function(){$("#msg").html('');},2500);
			return false;
		}
		else if($("#pass").val()==''){
			$("#msg").html('* Enter Password');
			setTimeout(function(){$("#msg").html('');},2500);
			return false;
		}
		else{
			$("#msg").html('* Processing. . .');
			$.ajax({
						type: "POST",
						url: "employee_username_check.php",
						dataType:'json',
						data: {uname:$("#unameshow").html(),emp_id:$("#emp_id").val()},
						success: function(result) {
							if(result.op==0){
								$("#msg").css("color","green").html("Username is Available");
								var md_data=new Array();
								$('input[name="chk-module[]"]').each(function(i) {
									var mid=$('input[name="chk-module[]"]').eq(i).data('id');
									var mname=$('input[name="chk-module[]"]').eq(i).data('name');
									var memprid=$('input[name="chk-module[]"]').eq(i).data('emprid');
									var chkmod='N';
									var chkins='N';
									var chkupd='N';
									var chkdel='N';
									if(this.checked){
										chkmod='Y';
									}
									if($('input[name="chk-ins[]"').eq(i).prop('checked')==true){
										chkins='Y';
									}
									if($('input[name="chk-upd[]"').eq(i).prop('checked')==true){
										chkupd='Y';
									}
									if($('input[name="chk-del[]"').eq(i).prop('checked')==true){
										chkdel='Y';
									}
									md_data.push([mid,mname,chkmod,chkins,chkupd,chkdel,memprid]);
								});
								console.log(md_data);
								$.ajax({
										type: "POST",
										url: "employee_functions.php",
										dataType:'JSON',
										data: {req:"ADDRIGHTS",data1:md_data,data2:$("#emp_id").val(),uname:$("#uname").val(),pass:$("#pass").val()},
										success: function(result) {
											if(result.op==1){
												$(".sweet-insert").click();
												$("#msg").html('Saved Successfully');
												setTimeout(function(){location.reload()},1500);
											}
											else{
												$("#msg").html(result.op);
											}
										},
										error:function(xhr,status,error){
											console.log(JSON.stringify(xhr,status,error));
										}
									});
							}
							else if(result.op>0){
								$("#msg").css("color","red").html("Username Already Exists !");
								$("#unamecheck").val('');
							}
							else{
								$("#msg").html(result.op);
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

$("#emp_id").empty();
$.ajax({
		type: "POST",
		url: "employee_dropdown.php",
		success: function(result) {
		if(result.s_id){
			var sid=result.s_id;
			var sname=result.s_name;
			var d_length=result.s_id.length;
			var d_data='<option value="">Select Employee</option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
			}
			$("#emp_id").removeAttr("disabled");
			$("#emp_id").append(d_data);		
			$("#grid-loader").hide();
		}
		else{	
			$("#grid-loader").hide();
		}
		}							
});	


$("#emp_id").change(function(e){
		rightsValidation();
		$("#uname").val('');
		$("#unameshow").html('@airwill');
		$("#pass").val('');
		var empid=$(this).val();
		if(empid!=""){
			$.ajax({
				type:"POST",
				data:{req:"RAUB",empid:empid},
				url:"employee_functions.php",
				dataType:"JSON",
				success:function(result){
					if(result.op!=''){
					$("#submitdel").show();
					$.each(result.op, function (key, val) {
					$("#unameshow").html(val['uname']);
					$("#uname").val(val['uname']);
					$("#pass").val(val['pass']);
					//alert(val['module_id']+'-'+val['module_status']+'-'+val['emprt_id']);
					$('input[name="chk-module[]"]').eq(val['module_id']).data("emprid",val['emprt_id']);
					  if(val['module_status']=='Y'){
						if(val['module_id']=='1'){
							  $('#chk-master').prop('checked',true);
							  $('#chk-master-ins').removeAttr('disabled');
							  $('#chk-master-upd').removeAttr('disabled');
							  $('#chk-master-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-master-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-master-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-master-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='2'){
							  $('#chk-employee').prop('checked',true);
							  $('#chk-employee-ins').removeAttr('disabled');
							  $('#chk-employee-upd').removeAttr('disabled');
							  $('#chk-employee-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-employee-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-employee-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-employee-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='3'){
							  $('#chk-pimport').prop('checked',true);
							  $('#chk-pimport-ins').removeAttr('disabled');
							  $('#chk-pimport-upd').removeAttr('disabled');
							  $('#chk-pimport-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-pimport-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-pimport-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-pimport-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='4'){
							  $('#chk-dc').prop('checked',true);
							  $('#chk-dc-ins').removeAttr('disabled');
							  $('#chk-dc-upd').removeAttr('disabled');
							  $('#chk-dc-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-dc-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-dc-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-dc-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='5'){
							  $('#chk-billing').prop('checked',true);
							  $('#chk-billing-ins').removeAttr('disabled');
							  $('#chk-billing-upd').removeAttr('disabled');
							  $('#chk-billing-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-billing-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-billing-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-billing-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='6'){
							  $('#chk-reports').prop('checked',true);
							  $('#chk-reports-ins').removeAttr('disabled');
							  $('#chk-reports-upd').removeAttr('disabled');
							  $('#chk-reports-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-reports-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-reports-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-reports-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='7'){
							  $('#chk-hidden').prop('checked',true);
							  $('#chk-hidden-ins').removeAttr('disabled');
							  $('#chk-hidden-upd').removeAttr('disabled');
							  $('#chk-hidden-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-hidden-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-hidden-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-hidden-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='8'){
							  $('#chk-preturn').prop('checked',true);
							  $('#chk-preturn-ins').removeAttr('disabled');
							  $('#chk-preturn-upd').removeAttr('disabled');
							  $('#chk-preturn-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-preturn-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-preturn-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-preturn-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='9'){
							  $('#chk-penddc').prop('checked',true);
							  $('#chk-penddc-ins').removeAttr('disabled');
							  $('#chk-penddc-upd').removeAttr('disabled');
							  $('#chk-penddc-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-penddc-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-penddc-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-penddc-del').prop('checked',true);
							  }
						}
					  }
					});
					}
					else{
						$("#submitdel").hide();
					}
				},
				error:function(xhr,status,error){
					console.log(xhr.responseText + error);
					
				}
			});
		}
		else{
			rightsValidation();
		}
});

});
</script>
</html>