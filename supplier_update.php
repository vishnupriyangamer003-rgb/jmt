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
									<label>Supplier Name :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter Supplier Name">
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
									<label>GST Number :</label>
									<input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Address :</label><span style="color:red">*</span>
									<textarea class="form-control" id="address" name="address" placeholder="Enter Address"></textarea>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group" style="margin-top:32px;">
									<input type="hidden" name="req" id="req">
									<input type="hidden" name="supplier_id" id="_id" value="<?php echo $_GET['id'];?>">
									<button type="submit" name="submit" id="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i>Update</button>									
									<a href="supplier_details.php"><button type="button" id="resetbut" class="btn btn-danger" style="font-weight:bold"><i class="fa fa-close"></i>&nbsp;&nbsp;Cancel</button></a>					
								</div>
							</div>
							<div class="col-md-3">
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
		url: "supplier_service.php",
		dataType:'json',
		data: {supplier_id:ids_string,req:"SUPPLIERAUB"},
		success: function(result) {
			$("#supplier_name").val(result.op[0]['supplier_name']);	
			$("#company_name").val(result.op[0]['company_name']);	
			$("#gst_no").val(result.op[0]['gst_no']);			
			$("#mblno").val(result.op[0]['mblno']);			
			$("#email").val(result.op[0]['email']);			
			$("#address").val(result.op[0]['address']);			
			//$("#packing_rate").val(result.op[0]['packing_rate']);
			//$("#comments").val(result.op[0]['comments']);
			// $("#photo_old_name").val(result.op[0]['imgname']);
			// $("#imgpreview").html('<label>Image Preview :</label><img src="userdata/images/product_details/'+result.op[0]['imgname']+'" style="width:100px;margin-left:10px">');
			$(".page-loader").hide();
		},error:function(xhr,status,error){
			console.log(JSON.stringify(xhr,status,error));
		}
	});	
	

	 $("#submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		if($("#supplier_name").val()==''){
			swal("Error!", " Enter Supplier Name !", "warning");
			return false;
		}
		else if($("#company_name").val()==''){
			swal("Error!", " Enter Company Name !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#mblno").val()==''){
			swal("Error!", " Enter Mobile No. !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#address").val()==''){
			swal("Error!", " Enter Supplier Address !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			$(".page-loader").show();
			$("#req").val('SUPPLIERUPD');
			$.ajax({
					type: "POST",
					url: "supplier_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						$(".page-loader").hide();
						if(result.op==1){
							swal("Success!", "Successfully Updated !", "success");
							setTimeout(function(){
								window.location.href="supplier_details.php";
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