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
        <div class="page-header d-md-flex justify-content-between align-items-center alert alert-secondary alert-with-border alert-dismissible">
            <h4>Income and Expense Header Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Income and Expense Header Details</li>
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
									<label>Name :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="income_header_name" name="income_header_name" placeholder="Enter Income Header ">
								</div>
							</div>
							
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="min-width:120px;">Save</button>
									<button type="reset" name="reset" id="btnReset" class="btn btn-danger" style="min-width:120px;">Reset</button>
								</div>
							</div>
							<div class="col-md-12">
								<span id="msg" style="font-weight:bold;float:right;margin-top:10px;"></span>
							</div>
						</div>
                    </form>
				<!--hr style="margin-top:0;margin-bottom:10px;border-color:#e6cece"/>
                    <form id="uomimportform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Sample Excel File :</label>
									<a href="media/sample_uom.xlsx" type="button" class="btn btn-success" download style="color:#fff;font-weight:bold"><i class="fa fa-download"></i>&nbsp;Download Here</a>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>UOM Excel Upload :</label>
									<input type="file" class="form-control" name="uomimportfile" id="uomimportfile">
								</div>
							</div>
							<input type="hidden" name="uom_import_name" id="uom_import_name">
							<div class="col-md-2">
								<div class="form-group">
									<button type="submit" name="submit" id="uomimportsubmit" class="btn btn-success" style="margin-top:25px;">Import</button>
								</div>
							</div>
							<div class="col-md-2">
									<span id="uom_import_msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>
                    </form-->

					

				<hr style="margin-top:0;margin-bottom:10px;border-color:#e6cece"/>
                   <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>S.no</th>                        
                        <th>Name</th>						
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                    </thead>
					<tbody>
						<!--tr>
							<td>1</td>
							<td>Petrol</td>
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
							<td>Lunch</td>
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

	$("#resetbut").click(function(){

		setTimeout(function(){
			window.location.href='income_header_details.php';
			
		},500);


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
		
		if($("#income_header_name").val()==''){
			$("#msg").css("color","red").html('* Enter income header name');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}	
		else{
			$("#req").val('ADDINS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "income_header_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='income_header_details.php';
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
            url :"income_header_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
          }
		 }
    });	
	$(document).on("click", "#detailsgrid .deleteTriger", function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			var delid = $(this).attr("data-value") || $(this).data("value") || $(this).closest("[data-value]").attr("data-value");
			swalConfirm("Do you want to Delete this Header?", function(){
				$.ajax({
					type: "POST",
					url: "income_header_service.php",
					dataType: "json",
					data: {delid:delid, req:"DEL"},
					success: function(result) {
						if(result.op==1 || result.op==true){
							if(typeof swal === "function"){
								swal("Success!", "Successfully Deleted !", "success");
							} else {
								alert("Successfully Deleted !");
							}
							$("#detailsgrid").DataTable().ajax.reload(null, false);
						}
						else{
							alert("Delete failed");
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
	});});
</script>
</html>