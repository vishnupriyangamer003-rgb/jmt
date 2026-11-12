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

	<?php
		$sql="SELECT * FROM tbl_gate_pass   WHERE  delete_status!='0'and gate_pass_id='".$_GET['id']."'";
		$exec_sql=mysqli_query($conn,$sql);
		$fetch_sql=mysqli_fetch_array($exec_sql);
		$customer_id = $fetch_sql['customer_name'];
	?>

	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
					<form id="mainform" method="POST" action="" enctype="multipart/form-data">
					<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Customer Name :</label><span style="color:red">*</span>
									<select  class="form-control js-example-basic-single select2-hidden-accessible" id="customer_id" name="customer_id" >
										
									</select>

									
								</div>
								<div class="form-group" id="customer_details" style="display:none;margin-bottom:5px;">								
										
										
								</div>

							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Driver Name :</label><span style="color:red">*</span>
									<select  class="form-control js-example-basic-single select2-hidden-accessible" id="driver_id" name="driver_id" >
										
									
										</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Vechicle Number :</label><span style="color:red">*</span>
									<select  class="form-control js-example-basic-single select2-hidden-accessible" id="vechicle_id" name="vechicle_id" >
										
									
										</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Product Name :</label><span style="color:red">*</span>
									<select  class="form-control js-example-basic-single select2-hidden-accessible" id="product_id" name="product_id" >
										
									
										</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Qty :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="qty" name="qty" placeholder="Enter Qty">
								</div>
							</div>
						
							<input type="hidden" name="req" id="req">
							<input type="hidden" name="gate_pass_id" id="gate_pass_id" value="<?php echo $_GET['id'];?>">
							<div class="col-md-3">
								<div class="form-group" style="margin-top:32px;">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="font-weight:bold"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Update</button>
									<a href="gate_pass_details.php"><button type="button" id="resetbut" class="btn btn-danger" style="font-weight:bold"><i class="fa fa-close"></i>&nbsp;&nbsp;Cancel</button></a>
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

<?php include("footer.php") ?>


<input type="hidden" name="modulenamebox" id="modulenamebox" value="6">
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

	//$(window).load(function(){

		var customer_id='<?php echo $customer_id;  ?>';
				$.ajax({
						type: "POST",
						url: "phpservices/customer_dropdown.php",
						dataType:'json',
						data: {customer_id:customer_id},
						success: function(result) {
							console.log(result);
							$("#customer_details").show();
							var customer_details = result.customer_name + '<br>';
							if (result.company_name != '') {

								customer_details += result.company_name +'<br>';
							}
							if (result.address != '') {
								customer_details += result.address + '<br>';
							}
							
							if (result.state != '') {
								customer_details += result.state + '<br>';
							}
							if (result.mblno != '') {
								customer_details += result.mblno + '<br>';
							}
							customer_details += result.gst_no;
							console.log(customer_details);
							$("#customer_details").html(customer_details);
					

						},error:function(xhr,status,error){
							console.log(JSON.stringify(xhr,status,error));
						}
					});


	//	});


	$.ajax({
			
			type: "POST",
			url: "staff_driver_dropdown.php",
			success: function(result) {
				var emp_id=result.emp_id;
				var emp_name=result.emp_name;
				var d_length=result.emp_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+emp_id[i]+'">'+emp_name[i]+'</option>';
					
				}
				$("#driver_id").removeAttr("disabled");
				$("#driver_id").append(d_data);
				$(".page-loader").hide();	
			}							
		});


		$.ajax({
		
			type: "POST",
			url: "phpservices/customer_dropdown.php",
			success: function(result) {
				var customer_id=result.customer_id;
				var customer_name=result.customer_name;
				var d_length=result.customer_id.length;
				var d_data='<option value="">Select Customer </option>';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+customer_id[i]+'">'+customer_name[i]+'</option>';
					
				}
				$("#customer_id").removeAttr("disabled");
				$("#customer_id").append(d_data);
				$(".page-loader").hide();	
			}							
		});

		
		$(document).on('change', '#customer_id', function() {

				
			var customer_id = $("#customer_id").val();
			if(!customer_id){ $("#customer_details").hide().html(''); return; }
			$.ajax({
				type: "POST",
				url: "phpservices/customer_dropdown.php",
				dataType: 'json',
				data: {
					customer_id: customer_id
				},
				success: function(result) {
					console.log(result);
					$("#customer_details").show();
					function pick(v){ return Array.isArray(v) ? (v[0] ?? '') : (v ?? ''); }
					var cn = pick(result.customer_name), rf = pick(result.reference_name),
					    co = pick(result.company_name), ad = pick(result.address),
					    st = pick(result.state), mb = pick(result.mblno),
					    em = pick(result.email), sc = pick(result.state_code),
					    gs = pick(result.gst_no);
					var customer_details = '';
					if (cn != '') { customer_details += cn + '<br>'; }
					if (rf != '') { customer_details += rf + '<br>'; }
					if (co != '') {

						customer_details += co +'<br>';
					}
					if (ad != '') {
						customer_details += ad + '<br>';
					}
					
					if (st != '') {
						customer_details += st + '<br>';
					}
					if (mb != '') {
						customer_details += mb + '<br>';
					}
					if (em != '') {
						customer_details += em + '<br>';
					}
					if (sc != '') {
						customer_details += sc + '<br>';
					}
					if (gs != '') { customer_details += gs + '<br>'; }
					console.log(customer_details);
					$("#customer_details").html(customer_details);

				},
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
				}
			});


		});
	
		$.ajax({
				
			type: "POST",
			url: "product_dropdown.php",
			success: function(result) {
				var product_id=result.product_id;
				var product_name=result.product_name;
				var d_length=result.product_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+product_id[i]+'">'+product_name[i]+'</option>';
					
				}
				$("#product_id").removeAttr("disabled");
				$("#product_id").append(d_data);
				$(".page-loader").hide();	
			}							
		});

		$.ajax({
			
			type: "POST",
			url: "vechicle_dropdown.php",
			success: function(result) {
				var vechicle_id=result.vechicle_id;
				var vechicle_name=result.vechicle_name;
				var d_length=result.vechicle_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+vechicle_id[i]+'">'+vechicle_name[i]+'</option>';
					
				}
				$("#vechicle_id").removeAttr("disabled");
				$("#vechicle_id").append(d_data);
				$(".page-loader").hide();	
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
		url: "gate_pass_service.php",
		dataType:'json',
		data: {gate_pass_id:ids_string,req:"AUB"},
		success: function(result) {

			setTimeout(function(){
				$("#customer_id").val(result.op[0]['customer_name']);
			},1000);
			setTimeout(function(){
				$("#driver_id").val(result.op[0]['driver_name']);
			},1000);
			setTimeout(function(){
				$("#vechicle_id").val(result.op[0]['vechicle_number']);
			},1000);
			setTimeout(function(){
				$("#product_id").val(result.op[0]['product_name']);
			},1000);

			
			
			$("#qty").val(result.op[0]['qty']);
			
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
		if($("#driver_name").val()==''){
			$("#msg").css("color","red").html('* Enter driver name');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		if($("#vechicle_number").val()==''){
			$("#msg").css("color","red").html('* Enter vechicle number');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		if($("#product_name").val()==''){
			$("#msg").css("color","red").html('* Enter Product Name');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		if($("#qty").val()==''){
			$("#msg").css("color","red").html('* Enter Qty');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			$(".page-loader").show();
			$("#req").val('UPD');
			$.ajax({
					type: "POST",
					url: "gate_pass_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						$(".page-loader").hide();
						if(result.op==1){
							swal("Success!", "Successfully Updated !", "success");
							setTimeout(function(){
								window.location.href="gate_pass_details.php";
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