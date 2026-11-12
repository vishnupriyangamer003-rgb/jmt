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
            <h4>Update Settings</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Settings</li>
                </ol>
            </nav>
        </div>
    </div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
						<div class="card-body">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
									aria-controls="home" aria-selected="true"><b>Profile Update</b></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
									aria-controls="profile" aria-selected="false"><b>For Support</b></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
									aria-controls="contact" aria-selected="false"><b>Terms & Conditions</b></a>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent" style="border-style:solid;border-color:#dee2e6;border-width:0 1px 1px 1px;padding:15px;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
									<form id="mainform" method="POST" action="" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-3">
												<div class="form-group">
													<label>Company Name :</label>
													<input type="text" class="form-control" id="cname" name="cname" placeholder="Enter Company Name">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Company Address :</label>
													<textarea class="form-control" id="addr" name="addr" placeholder="Enter Company Address" style="min-height: 100px;height: 100px;"></textarea>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Suffix :</label>
													<input type="text" class="form-control" id="suffix" name="suffix" placeholder="Enter suffix">
												</div>
											</div>	
											<div class="col-md-3">
												<div class="form-group">
													<label>State :</label>
													<input type="text" class="form-control" id="adm_state" name="adm_state" placeholder="Enter State Name">
												</div>
											</div>	
											<div class="col-md-3">
												<div class="form-group">
													<label>GST Number :</label>
													<input type="text" class="form-control" id="gstno" name="gstno" placeholder="Enter GST Number">
												</div>
											</div>														
											<div class="col-md-3">
												<div class="form-group">
													<label>Bank Name :</label>
													<input type="text" class="form-control" id="bank" name="bank" placeholder="Enter Bank Name">
												</div>
											</div>													
											<div class="col-md-3">
												<div class="form-group">
													<label>Branch :</label>
													<input type="text" class="form-control" id="branch" name="branch" placeholder="Enter Branch">
												</div>
											</div>												
											<div class="col-md-3">
												<div class="form-group">
													<label>Account Number :</label>
													<input type="number" class="form-control" id="acc_no" name="acc_no" placeholder="Enter Account Number">
												</div>
											</div>												
											<div class="col-md-3">
												<div class="form-group">
													<label>Account Type :</label>
													<input type="text" class="form-control" id="acc_type" name="acc_type" placeholder="Enter Account Type">
												</div>
											</div>											
											<div class="col-md-3">
												<div class="form-group">
													<label>IFSC Code :</label>
													<input type="text" class="form-control" id="ifsc" name="ifsc" placeholder="Enter IFSC Code">
												</div>
											</div>											
											<div class="col-md-3">
												<div class="form-group">
													<label>Account Holder Name :</label>
													<input type="text" class="form-control" id="holder_name" name="holder_name" placeholder="Enter Account Holder Name">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Username :</label>
													<input type="text" class="form-control" id="uname" name="uname" placeholder="Enter Username">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Password :</label>
													<input type="text" class="form-control" id="pass" name="pass" placeholder="Enter Password">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group searchbut">
													<button type="submit" name="submit" id="submit" class="btn btn-primary" style="font-weight:bold;"><i class="ti-check-box"></i>&nbsp;Update</button>
													<a href="settings.php"><button type="button" class="btn btn-danger" style="font-weight:bold;"><i class="ti-close"></i>&nbsp;Cancel</button></a>
												</div>
											</div>
										</div>
										<span id="msg" style="font-weight:bold;float:right;margin-top:7px;"></span>
									</form>
									<form id="empform" method="POST" action="" enctype="multipart/form-data" style="display:none;">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label>Username : <span id="unameshow" style="color:red"></span></label>
												<input type="text" class="form-control" id="emp_uname" name="emp_uname" placeholder="Enter Username">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Password :</label>
												<input type="text" class="form-control" id="emp_pass" name="emp_pass" placeholder="Enter Password">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group submitbut">
												<button type="button" name="submit" id="emp_submit" class="btn btn-success">Update</button>
												<a href="settings.php"><button type="button" class="btn btn-danger">Cancel</button></a>
											</div>
										</div>
									</div>

									<span id="emp_msg" style="font-weight:bold;margin-top:7px;color:red"></span>
								</form>
								</div>
								<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
									<label style="font-size:18px">About Developers :</label>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<a href="https://www.knocktheglobe.com/" target="_blank" style="font-size:16px"><b>Knock The Globe Technologies,</b></a><br/> 94, Vaiyapuri Nagar
													2nd Cross,<br/> Karur-639002,<br/> Tamilnadu.
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Email Id :</label>
													<a href="mailto:ktgtoffice@gmail.com" target="_blank" style="font-size:16px"><b>ktgtoffice@gmail.com</b></a><br/>
													<label>Mobile No :</label>
													<a href="tel:+919514314333" target="_blank" style="font-size:16px"><b>+91 7200 123452</b></a><br/>
													<a href="https://www.facebook.com/KarurWebsiteDesigners/" target="_blank" style="font-size:35px;margin-right:15px"><i class="ti-facebook"></i></a>
													<a href="https://twitter.com/knocktheglobe" target="_blank" style="font-size:35px;margin-right:15px"><i class="ti-twitter-alt"></i></a>
													<a href="https://www.linkedin.com/in/ktgtechnologies" target="_blank" style="font-size:35px;margin-right:15px"><i class="ti-linkedin"></i></a>
												</div>
											</div>
										</div>
								</div>
								<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
									Click here for <a href="https://www.knocktheglobe.com/termsandconditions.php" target="_blank" class="btn btn-danger"><i class="ti-unlink"></i>&nbsp;&nbsp;Terms & Conditions</a>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
</main>
<!-- end::main content -->

    <?php include("footer.php") ?>
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
	.searchbut{
		margin-top:33px
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

	if('<?php echo $log; ?>'!="admin"){
	$("#mainform").css('display','none');
	$("#empform").css('display','block');

	$.ajax({
		type: "POST",
		url: "phpservices/emp_profile_autobind.php",
		data:{emp_id:"<?php echo $login_id; ?>"},
		dataType:'json',
		success: function(result) {
			$("#emp_uname").val(result.uname);
			$("#unameshow").html(result.uname);
			$("#emp_pass").val(result.pass);
		},error:function(xhr,status,error){
			console.log(JSON.stringify(xhr,status,error));
		}
	});
}
else{
	$("#mainform").css('display','block');
	$("#empform").css('display','none');

	$.ajax({
		type: "POST",
		url: "phpservices/profile_autobind.php",
		dataType:'json',
		success: function(result) {
			$("#cname").val(result.cname);
			$("#addr").val(result.addr);
			$("#suffix").val(result.suffix);
			$("#adm_state").val(result.adm_state);
			$("#gstno").val(result.gstno);
			$("#bank").val(result.bank);
			$("#branch").val(result.branch);
			$("#acc_no").val(result.acc_no);
			$("#acc_type").val(result.acc_type);
			$("#ifsc").val(result.ifsc);
			$("#holder_name").val(result.holder_name);
			$("#uname").val(result.uname);
			$("#pass").val(result.pass);
		},error:function(xhr,status,error){
			console.log(JSON.stringify(xhr,status,error));
		}
	});
}


// $("#ct_id").empty();
// $.ajax({
// 		type: "POST",
// 		url: "phpservices/city_dropdown.php",
// 		success: function(result) {
// 			var sid=result.s_id;
// 			var sname=result.s_name;
// 			var d_length=result.s_id.length;
// 			var d_data='<option value="">Select City</option>';
// 			for(var i=0;i<=d_length-1;i++){
// 				d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
// 			}
// 			$("#ct_id").removeAttr("disabled");
// 			$("#ct_id").append(d_data);
// 			$(".page-loader").hide();	
// 		}							
// });
$("#emp_uname").keyup(function(){
	$("#unameshow").html($("#emp_uname").val()+"@realtex");
});

	$("#emp_submit").click(function(e){
		e.preventDefault();
		if($("#emp_uname").val()==''){
			$("#emp_msg").css("color","red").html('* Enter Username');
			setTimeout(function(){$("#emp_msg").html('')},3000);
			return false;
		}
		else if($("#emp_pass").val()==''){
			$("#emp_msg").css("color","red").html('* Enter Password');
			setTimeout(function(){$("#emp_msg").html('')},3000);
			return false;
		}
		else{
			$("#emp_msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "phpservices/emp_profile_update.php",
					dataType:'json',
					data: $("#empform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							$("#emp_msg").css("color","green").html("Successfully Updated !");
							$(".sweet-update").click();
							setTimeout(function(){
								window.location.href='settings.php';
							},2000);
						}
						else{
							$("#emp_msg").html(result.op);
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
	});

	$("#submit").click(function(e){
		e.preventDefault();
		 if($("#uname").val()==''){
			$("#msg").css("color","red").html('* Enter Username');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#pass").val()==''){
			$("#msg").css("color","red").html('* Enter Password');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			$.ajax({
					type: "POST",
					url: "phpservices/profile_update.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='settings.php';
							},2000);
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
	});
	
});
</script>
</html>