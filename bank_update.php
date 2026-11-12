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
									<label>Name :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Account Number :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="account_number" name="account_number" placeholder="Enter Account Number">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>IFSC :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="Enter IFSC Code">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Opening Balance :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="opening_balance" name="opening_balance" placeholder="Enter Opening Balance">
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" name="bank_id" id="bank_id" value="<?php echo $_GET['id'];?>">

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
<!-- end::main content -->

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
			url: "bank_service.php",
			dataType:'json',
			data: {bank_id:ids_string,req:"AUB"},
			success: function(result) {
				
				$("#bank_name").val(result.op[0]['bank_name']);
				$("#account_number").val(result.op[0]['account_no']);
				$("#ifsc_code").val(result.op[0]['ifsc_code']);
				$("#opening_balance").val(result.op[0]['open_balance']);
				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});	



	 $("#submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		
		if($("#bank_name").val()==''){
			$("#msg").css("color","red").html('* Enter Bank Name');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#account_no").val()==''){
			$("#msg").css("color","red").html('* Enter Account Number');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#ifsc_code").val()==''){
			$("#msg").css("color","red").html('* Enter IFSC Code');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#open_balance").val()==''){
			$("#msg").css("color","red").html('* Enter Opening Balance');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			$(".page-loader").show();
			$("#req").val('UPD');
			$.ajax({
					type: "POST",
					url: "bank_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						$(".page-loader").hide();
						if(result.op==1){
							swal("Success!", "Successfully Updated !", "success");
							setTimeout(function(){
								window.location.href="bank_details.php";
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