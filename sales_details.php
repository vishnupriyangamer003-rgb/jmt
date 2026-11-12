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
	<style>
		.no-wrap{
			word-break: break-all;
		}
		</style>
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
            <h4>DC Details</h4>
            <nav aria-label="breadcrumb">
				<a href="sales_add_details.php" class="btn btn-warning" style="background: #000642;border-color: #000642;"><i class="fa fa-plus-circle" style="color:white;"></i>
					<span style="color:white">&nbsp;&nbsp;ADD DC DETAILS</span></a>

			</nav>
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">

					<form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>From :</label>
									<input type="text" class="form-control" name="single-date-picker" id="sfdate2" autocomplete="off">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>To :</label>
									<input type="text" class="form-control" name="single-date-picker" id="stdate2" autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Customer Name :</label>
									<select class="form-control js-example-basic-single select2-hidden-accessible" id="customer_id" name="customer_id" >
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
									<button type="submit" id="search" class="btn btn-success" style="margin-top:32px;">search</button>
							</div>
						</div>
						<span id="msg" style="font-weight:bold;float:right;margin-top:7px;"></span>
					</form>

                   <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
						<tr>
							<th>S.no</th> 
							<th>Date</th> 
							<th>DC&nbsp;No</th>     
							<th>Customer</th>       
							<th>Vechicle &nbsp;Number</th>
							<th>Products</th> 							
							<th>Qty</th>      
														
							<th>Total Amount</th>
							<th>Action</th>
						</tr>
                    </thead>
					<tbody>
						<!--tr>
							<td>1</td>
							<td>Manikandan</td>
							<td>Vel</td>
							
							<td>TN57 AZ 9090</td>
							<td>001</td>
							<td>20-01-2023</td>
							<td>5000</td>
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
							
							<td>TN44 CG 1589</td>
							<td>002</td>
							<td>25-01-2023</td>
							<td>2500</td>
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
<input type="hidden" name="modulenamebox" id="modulenamebox" value="5">
<input type="hidden" name="rightsbox" id="rightsbox">

<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Expense for Bill : </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form id="innerform" method="POST" action="" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Expense Amount :</label>
				</div>
			</div>
			<div class="col-md-5" style="margin-top:0px;text-align:center!important">
				<div class="form-group">	
					<input type="text" class="form-control" id="expanse_amt" name="expanse_amt" placeholder="Enter Expense Amount">	
					<input type="hidden" name="req" id="req">									
					<input type="hidden" id="booking_id" name="booking_id">
				</div>
			</div>
			<div class="col-md-1">
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" name="submit" id="innersubmit" class="btn btn-primary">Save changes</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<?php include("footer.php") ?>


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
<!-- START::select2 -->
<script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<!-- end::select2 -->
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
<!-- end::custom scripts -->

</body>

<script>
$(document).ready(function(){
	$(document).on('click', '.trtag', function () {
		$("#trtag"+$(this).data('value')+"").remove();
		return false;
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



	$('#detailsgrid').DataTable({
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"sales_details_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond:"firstbind"},
            error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
          }
		 }
    });	

	$("#search").click(function(e){
			e.preventDefault();
			var fdatefullvalue= $("#sfdate2").val();
			var fdatevalue = fdatefullvalue.split('/')[0];
			var fmonthvalue = fdatefullvalue.split('/')[1];
			var fyearvalue = fdatefullvalue.split('/')[2];
			
			var tdatefullvalue= $("#stdate2").val();
			var tdatevalue = tdatefullvalue.split('/')[0];
			var tmonthvalue = tdatefullvalue.split('/')[1];
			var tyearvalue = tdatefullvalue.split('/')[2];

			console.log(fmonthvalue+'/'+fdatevalue+'/'+fyearvalue);
			console.log(tmonthvalue+'/'+tdatevalue+'/'+tyearvalue);
			console.log($("#cuatomer_id").val());
		
		$("#detailsgrid").dataTable().fnDestroy();
		$('#detailsgrid').DataTable({
				
			"pageLength": 500,
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"ajax":{
				url :"sales_details_grid.php", // json datasource
				type: "post",  // type of method  ,GET/POST/DELETE
				data:{cond:"searchbind",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue,customer_id:$("#customer_id").val()},
					error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
			}
		});
	});

$(document).on('click','.innerid', function(){
		$("#booking_id").val($(this).data('booking_id'));
		$("#expanse_amt").val($("#ta_"+$(this).data('booking_id')).html());
});

$("#innersubmit").click(function(e){
		e.preventDefault();
		if($("#expanse_amt").val()==""){
			swal("Error!", "Enter Expense Amount !", "warning");
			return false;
		}
		else{
			$("#req").val('EXPANSE');
			//console.log($("#innerform").serialize());
			$.ajax({
				type: "POST",
				url: "expanse_amount_services.php",
				dataType:'json',
				data: $("#innerform").serialize(),
				//data:{booking_id:$("#booking_id").val()},
				success: function(result) {
					if(result.op==1){
							swal("Success!", "Saved Successfully !", "success");
							setTimeout(function(){
								window.location.href='sales_details.php';
							},500);
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

	
	$(document).on('click','.salesdeleteTriger', function(){
		var delid=$(this).data('value');
		var alertmsg=confirm("Do you want to Delete ?");
		if (alertmsg == true) {
			$.ajax({
					type: "POST",
					url: "sales_details_service.php",
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
	});

});	
</script>
</html>