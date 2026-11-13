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
            <h4>User Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Details</li>
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
									<label>User Name :</label><span style="color:red">*</span>
									<input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User Name">
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
									<label>Email Id :</label><span style="color:red">*</span>
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Id">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Address :</label><span style="color:red">*</span>
									<textarea class="form-control" id="address" name="address" placeholder="Enter Address"></textarea>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>GST Number :</label>
									<input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number">
								</div>
							</div>

							
							<div class="col-md-2">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<button type="submit" name="submit" id="submit" class="btn btn-success">Save</button>									
									<button type="reset" name="submit" id="submit" class="btn btn-danger">Reset</button>
								</div>
							</div>
							<div class="col-md-3">
								<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>
                    </form>
				<!--<hr style="margin-top:0;margin-bottom:10px;border-color:#e6cece"/>
                    <form id="userimportform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Sample Excel File :</label>
									<a href="media/sample_user.xlsx" type="button" class="btn btn-success" download style="color:#fff;font-weight:bold"><i class="fa fa-download"></i>&nbsp;Download Here</a>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>user Details Excel Upload :</label>
									<input type="file" class="form-control" name="userimportfile" id="userimportfile">
								</div>
							</div>
							<input type="hidden" name="user_import_name" id="user_import_name">
							<div class="col-md-6">
								<div class="form-group">
									<button type="submit" name="submit" id="userimportsubmit" class="btn btn-success" style="margin-top:25px;">Import</button>
								</div>
							</div>
						</div>
						<span id="user_import_msg" style="font-weight:bold;float:right;margin-top:7px;"></span>
                    </form>
					-->
					<hr style="margin-top:0;margin-bottom:10px;border-color:#e6cece"/>
                   <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>S.no</th>
                        <th>User&nbsp;Name</th> 
						<th>Company&nbsp;Name</th>                       
                        <th>Mobile&nbsp;Number</th>
                        <th>Address</th>						
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                    </thead>
					<!-- <tbody>
						<tr>
							<td>1</td>
							<td>Mahesh. S</td>
							<td>Fabric Checking</td>
							<td>+91 9876543210</td>
							<td>No. 90, KK Nagar, Sengunthapuram, Karur - 639002.</td>
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
							<td>Siva Balan. R</td>
							<td>Cutting</td>
							<td>+91 9955421109</td>
							<td>22/40, Asian Complex, 2nd Floor, Vennaimalai - 639006</td>
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
					</tbody> -->
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
<!--<!--script src="vendors/bundle.js"></script-->-->
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
			if($("#user_name").val()==''){
				$("#msg").css("color","red").html('* Enter User Name');
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}else if($("#mblno").val()==''){
				$("#msg").css("color","red").html('* Enter Mobileno');
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}else if($("#email").val()==''){
				$("#msg").css("color","red").html('* Enter Email');
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}else if($("#address").val()==''){
				$("#msg").css("color","red").html('* Enter Address');
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}else{
				$("#req").val('ADDINS');
				$("#msg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "user_service.php",
						dataType:'json',
						data: $("#mainform").serialize(),
						success: function(result) {
							console.log(result.op);
							if(result.op=='' || result.op==null){
								$("#msg").css("color","red").html('Duplicate user already exists !');
								setTimeout(function(){$("#msg").html('')},3000);
								return false;
							}else{

								if(result.op==1){
									
									swal("Success!", "Successfully Saved !", "success");
									setTimeout(function(){
										window.location.href='user_details.php';
									},2000);
								}
								else{
									alert($("#msg").html(result.op));
								}
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
            url :"user_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
    });


$("#photo").change(function(){
	var numb = $(this)[0].files[0].size/1024/1024;
	numb = numb.toFixed(2);
	var fileName = $("#photo").val();
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png" || extFile=="JPG" || extFile=="JPEG" || extFile=="PNG"){
		if(numb <= 0.3){
			$(".page-loader").show();
			var fd=new FormData();
			fd.append('photo',$('#photo').prop('files')[0]);
			setTimeout(function(){	
				$.ajax({
						type:'POST',
						url:'phpservices/img_upload.php',
						data:fd ,
						cache:false,
						contentType:false,
						processData:false,
						dataType: 'JSON',
						success: function(result) {
							$(".page-loader").hide();
							$("#photo_name").val(result.op);
							$("#imgpreview").html('<label>Image Preview :</label><img src="temp/'+result.op+'" style="width:100px;margin-left:10px">');
						},
						async:false
				});
			},2000);
		}
		else{
			$("#photo").val('');
			$("#photo_name").val('');
			swal("Error!", "* Upload maximum 300 kb Image only !", "warning");
			return false;
		}
	}
	else{
		$("#photo").val('');
		$("#photo_name").val('');
		swal("Error!", "* Upload .png, .jpg, .jpeg, .PNG, .JPG, .JPEG type image only!", "warning");
		return false;
	}
 });	
				
 $(document).on('click','.deleteTriger', function(){
	var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		var delid=$(this).data('value');
		swalConfirm("Do you want to Delete ?", function(){
			$.ajax({
					type: "POST",
					url: "user_service.php",
					dataType:'json',
					data: {delid:delid,req:"USERDEL"},
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
	
$("#userimportfile").change(function(){
	var fileName = $("#userimportfile").val();
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="xlsx" || extFile=="xls"){
		$(".page-loader").css('z-index','9999').show();
		var fd=new FormData();
		fd.append('importfile',$('#userimportfile').prop('files')[0]);
		setTimeout(function(){	
			$.ajax({
					type:'POST',
					url:'phpservices/img_upload.php',
					data:fd ,
					cache:false,
					contentType:false,
					processData:false,
					dataType: 'JSON',
					success: function(result) {
						$(".page-loader").hide();
						$("#user_import_name").val(result.op2);
					},
					async:false
				});
				},2000);
	}
	else{
		$("#userimportfile").val('');
		$("#user_import_msg").css("color","red").html('* Upload .xlsx, .xls file type only');
		setTimeout(function(){$("#user_import_msg").html('');},3000);
		return false;
	}
 });


$("#userimportsubmit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		if($("#user_import_name").val()==''){
			$("#user_import_msg").css("color","red").html('* Upload Import File');
			setTimeout(function(){$("#user_import_msg").html('')},3000);
			return false;
		}
		else{
			$("#user_import_msg").css("color","green").html("Processing . . .");
			$(".page-loader").show();
			$.ajax({
					type: "POST",
					url: "phpservices/user_details_import.php",
					dataType:'json',
					data: $("#userimportform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							$("#msg").css("color","green").html("Successfully Saved !");
							setTimeout(function(){
								window.location.href='user_details.php';
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
	
});
</script>
</html>