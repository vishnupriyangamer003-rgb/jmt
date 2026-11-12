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
        <div class="page-header d-md-flex justify-content-between align-items-center align-items-center   alert-with-border alert-dismissible">
            <h4>Vechicle Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0" >
                    <li class="breadcrumb-item"><a href="#" >Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page" >Vechicle Details</li>
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
									<label>Vechicle Number :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="vechicle_name" name="vechicle_name" placeholder="Enter Vechicle Number">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Insurance Number  :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="insurance_number" name="insurance_number" placeholder="Enter Vechicle Number">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Insurance From :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="insurance_from" name="insurance_from" placeholder="Enter Vechicle Number">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Insurance To  :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="insurance_to" name="insurance_to" placeholder="Enter Vechicle Number">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>FC Number :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="fc_number" name="fc_number" placeholder="Enter FC Number">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>FC From :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="fc_from" name="fc_from" placeholder="Enter FC From">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>FC To :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="fc_to" name="fc_to" placeholder="Enter FC To">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Tax From :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="tax_from" name="tax_from" placeholder="Enter Tax From">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Tax To :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="tax_to" name="tax_to" placeholder="Enter Tax To">
								</div>
							</div>
						</div>
						<div class="row">
							
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
				<!--hr style="margin-top:0;margin-bottom:10px;border-color:#e6cece"/>
                    <form id="vechicleimportform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Sample Excel File :</label>
									<a href="media/sample_vechicle.xlsx" type="button" class="btn btn-success" download style="color:#fff;font-weight:bold"><i class="fa fa-download"></i>&nbsp;Download Here</a>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>vechicle Excel Upload :</label>
									<input type="file" class="form-control" name="vechicleimportfile" id="vechicleimportfile">
								</div>
							</div>
							<input type="hidden" name="vechicle_import_name" id="vechicle_import_name">
							<div class="col-md-2">
								<div class="form-group">
									<button type="submit" name="submit" id="vechicleimportsubmit" class="btn btn-success" style="margin-top:25px;">Import</button>
								</div>
							</div>
							<div class="col-md-2">
									<span id="vechicle_import_msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>
                    </form-->
				<hr style="margin-top:0;margin-bottom:10px;border-color:#e6cece"/>
                   <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>S.no</th>
                        
                        <th>Vechicle&nbsp;Number</th>
						<th>Insurance&nbsp;Number</th>
						<th>Insurance&nbsp;Date</th>
						<th>FC&nbsp;Number</th>
						<th>FC&nbsp;Date</th>
						<th>Tax&nbsp;Date</th>						
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                    </thead>
					 <tbody>
						<!--tr>
							<td>1</td>
							<td>Unit</td>
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
							<td>KG</td>
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
<!-- end::custom scripts -->

</body>

<script>
$(document).ready(function(){

	$('input[name="fc_from"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});
	$('input[name="fc_to"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});


	$('input[name="insurance_from"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});
	$('input[name="insurance_to"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});

	$('input[name="tax_from"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});
	$('input[name="tax_to"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
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
		
		if($("#vechicle_name").val()==''){
			$("#msg").css("color","red").html('* Enter vechicle number');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#insurance_number").val()==''){
			$("#msg").css("color","red").html('* Enter insurance numbe');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#insurance_from").val()==''){
			$("#msg").css("color","red").html('* Enter insurance from date');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#insurance_to").val()==''){
			$("#msg").css("color","red").html('* Enter insurance to date');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#fc_number").val()==''){
			$("#msg").css("color","red").html('* Enter FC Number');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#fc_from").val()==''){
			$("#msg").css("color","red").html('* Enter FC from date');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#fc_to").val()==''){
			$("#msg").css("color","red").html('* Enter FC to date');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#tax_from").val()==''){
			$("#msg").css("color","red").html('* Enter tax from date');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#tax_to").val()==''){
			$("#msg").css("color","red").html('* Enter tax to date');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}		
		else{
			$("#req").val('ADDINS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "vechicle_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='vechicle_details.php';
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
            url :"vechicle_grid.php", // json datasource
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

		var alertmsg=confirm("Do you want to Delete ?");
		if (alertmsg == true) {
			$.ajax({
					type: "POST",
					url: "vechicle_service.php",
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