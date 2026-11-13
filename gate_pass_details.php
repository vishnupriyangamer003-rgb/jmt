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
            <h4>Gate Pass Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gate Pass Details</li>
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

							

							
							<div class="col-md-2">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-top:32px;">Save</button>
									<button type="reset" name="submit" id="submit" class="btn btn-danger" style="margin-top:32px;">Reset</button>
								</div>
							</div>
							<div class="col-md-2">
								<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>
                    </form>
				
				<hr style="margin-top:0;margin-bottom:10px;border-color:#e6cece"/>
                   <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Cus Name</th>
						<th>Driver Name</th>
						<th>Vechicle Number</th>
						<th>Product Name</th>
                        
						<th>Qty</th>						
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                    </thead>
					<tbody>
						<!--tr>
							<td>1</td>
							<td>Manikandan</td>
							<td>Vel</td>
							<td>Brick</td>
							<td>TN57 AZ 9090</td>
							<td>1000</td>
							<td>Admin</td>
							<td><div class="btn-group" role="group" aria-label="Basic example">
									<button type="button" class="btn btn-success">
										<i class="fa fa-edit" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
									</button>
									<button type="button" class="btn btn-danger">
										<i class="fa fa-trash" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
									</button>
								</div>
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Suresh</td>
							<td>Mahesh</td>
							<td>Brick</td>
							<td>TN66 MK 1286</td>
							<td>200</td>
							<td>Admin</td>
							<td><div class="btn-group" role="group" aria-label="Basic example">
									<button type="button" class="btn btn-success">
										<i class="fa fa-edit" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
									</button>
									<button type="button" class="btn btn-danger">
										<i class="fa fa-trash" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
									</button>
								</div>
							</td>
						</tr-->
					</tbody> 
                </table>
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
<!-- START::select2 -->
<script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<!-- end::select2 -->

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

<script>
$(document).ready(function(){

	
	$("#resetbut").click(function(){

		setTimeout(function(){
			window.location.href='gate_pass_details.php';
			
		},500);


	});


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
			$("#req").val('ADDINS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "gate_pass_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='gate_pass_details.php';
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
	}

	else{
		swal("Error!", "Access Denied! Contact Admin...", "error");
		return false;
	}
	});

	$('#detailsgrid').DataTable({
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"gate_pass_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
          }
		 }
    });	

	$(document).on('click','.deleteTriger', function(){
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		var delid=$(this).data('value');

		swalConfirm("Do you want to Delete ?", function(){
			$.ajax({
					type: "POST",
					url: "gate_pass_service.php",
					dataType:'json',
					data: {delid:delid,req:"DEL"},
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Deleted !", "success");
							setTimeout(function(){
								$("#msg").html('');
							},2000);
							$('#detailsgrid').DataTable().ajax.reload();
						}
						else{
							alert($("#msg").html(result.op));
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