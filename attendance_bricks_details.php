<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Spares)</title>
    <link rel="icon" type="image/x-icon" href="images/logo.png">

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




		<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		<script src="https://www.jqueryscript.net/demo/Week-Picker-Plugin-jQuery-UI/jquery.weekpicker.js"></script>
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css">
      


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

<style>
@media (max-width: 2000px){

table td{
	border:1px solid #000;
}
table th{
	border:1px solid #000;
}
table {
	border:1px solid #000;
	width:50%
	
}
.name{
	text-align:center;
}
.sunday{
	background-color:#2ea3f5;
	color:white;
	width:27px
}
.Festival{
	background-color:#ff4b4b;
	color:white;
	width:27px
}
.halfday{
	background-color:#FFFF00;
	color:black;
	width:27px
	
}
.details ul{
	display:flex;
}
.details ul li{
    padding-right:24px;
	padding-bottom:10px;
	font-weight:bold;
}
.total_employees{
	border:none;
	background-color:#cf5688;
	padding:4px;
	border-radius:4px;
	color:white;
}
main.main-content{
	padding:12px 10px;
}
.page-header{
    margin-bottom:7px;
	padding:12px
}
.datepicker .datepicker-days .table-condensed tr:hover {
  background-color: #808080;
}

}
</style>



<!-- begin::main content -->
<main class="main-content">

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h5>Attedance report</h5>
            <nav aria-label="breadcrumb">
			<a href="add_attendance_bricks.php" class="btn btn-warning"><i class="fa fa-plus-circle" style="color:white;"></i>
									<span style="color:white">&nbsp;ADD ATTENDANCE BRICKS</span></a>
									
            </nav>
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
					<div class="details">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="form-group">
										<label for="week_ww_yyyy">Select a week</label>
											<input type="text" class="form-control select_week"  id="select_week" name="select_week" value="<?php echo date('d/m/Y'); ?>">

											<input type="hidden" class="form-control"  id="select_week1" name="select_week1" value="<?php echo date('d/m/Y'); ?>">
											
									</div>
									
									
									<script>
										(function ( $ ) {
											//$(".select_week").value('13/2023');
											$("#select_week").weekpicker();
											
										} )(jQuery)
									</script>

									<div class="col-md-4 col-sm-12">
										<button id="search" name="search" class="btn btn-success"   >Search</span></button>
							
									</div>

									
								</div>
							</div>

							


							
						</div>
					<div>
					
					<div  class="attendance_bind"style="overflow-x:auto;">
						<table style="width:100%;text-align:center">
							<thead class="jhe-thead">
								<tr>
									<th>No</th>
									<th class="name" style="width:130px">Name</th>
									<th class="name" style="width:130px">Salary</th>
									<?php 
									
									

									// set current date
									$date = date('Y-m-d');
									// parse about any English textual datetime description into a Unix timestamp 
									$ts = strtotime($date);
									// find the year (ISO-8601 year number) and the current week
									$year = date('o', $ts);
									$week = date('W', $ts);
									
									

									// print week for the current date
									for($i = 1; $i <= 7; $i++) {
										// timestamp from ISO week date format
										$ts = strtotime($year.'W'.$week.$i);
										//print date("m/d/Y l", $ts) . "\n";?>
										<th><?php echo date("d/m/Y", $ts); ?></th><?php
									}

									$start_date=strtotime($year.'W'.$week.'1');
									$end_date=strtotime($year.'W'.$week.'7');

									$start_date1=date("Y-m-d", $start_date);
									$end_date1=date("Y-m-d", $end_date);
								
								

									//$days = date("t");
									//for($i=1;$i<=$days;$i++){ ?>
										<!--th><?php echo $i; ?></th-->
									<?php //} ?>
									<th class="name" style="width:80px">Tot.Hr</th>	
									<th class="name" style="width:80px">Tot.Salary</th>							
									<th class="name" style="width:80px">Tot.Paid</th>
									<th class="name" style="width:80px">Balance</th>							
								</tr>
							</thead>
							<tbody>
								<?php 							
								$sql= "select * from tbl_employee_details where delete_status='NDL' and emp_salary_type='3'";
								$exec_query=mysqli_query($conn, $sql);
								
								$j=0;
								while($fetch=mysqli_fetch_array($exec_query)){
								?>
								<tr>
									<td  style="font-weight:bold;"><?php   echo  $j+1;; ?></td>
									<td  style="font-weight:bold;"><?php   echo  $fetch['emp_name']; ?></td>
									<td  style="font-weight:bold;"><?php   echo  $fetch['salary']; ?></td>
										<?php 	
										//$days = date("t");
										//$month = date('m');
										//$year = date('Y');
										//$start_date=$year.'-'.$month.'-1';

										// set current date
									$date = date('Y-m-d');
									// parse about any English textual datetime description into a Unix timestamp 
									$ts = strtotime($date);
									// find the year (ISO-8601 year number) and the current week
									//$year = date('o', $ts);
									//$week = date('W', $ts);
									// print week for the current date

									//$days = date("t");							

									for($z = 1; $z <= 7; $z++) {

										$ts = strtotime($year.'W'.$week.$z);

										$month = date('m', $ts);
										$year = date('Y', $ts);
										$date = date('d', $ts);
										
										$sql_sql= "select t1.*,t2.emp_name from tbl_attendance_bricks t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t1.delete_status='NDL' and t2.emp_salary_type='3' and t1.attendance_date='$year-$month-$date' and t1.emp_id=".$fetch['emp_id']."";


										
										$exec_query_sql=mysqli_query($conn, $sql_sql);
										$num_rows=mysqli_num_rows($exec_query_sql);
										if($num_rows > 0){

											
											while($fetch_sql=mysqli_fetch_array($exec_query_sql)){ 
											// print_r($fetch_sql['attendance_status'].$fetch_sql['attendance_date']);
											
											?>
												<?php if(!empty($fetch_sql['attendance_status'])){?>

													<td style="color:green;"><?php echo $fetch_sql['attendance_status']; ?></td>
													
												<?php }
												else{?> <td>-</td> <?php  } ?>										
										
											<?php } ?>
										<?php } else{?> <td  style="font-weight:bold;">-</td> <?php  } ?>
									<?php } ?>



									<?php 	

										//$end_date=$year.'-'.$month.'-'.($z-1);
									 							
										$sql_sql1= "select sum(attendance_status) as total_hour,t2.salary,t2.emp_id from tbl_attendance_bricks t1 inner join tbl_employee_details t2 on t1.emp_id=t2.emp_id  where  t2.delete_status='NDL' and t1.emp_id=".$fetch['emp_id']." and t2.emp_salary_type='3' and t1.attendance_date between '" . $start_date1 . "' and '" . $end_date1 . "'";

										
										$exec_query_sql1=mysqli_query($conn, $sql_sql1);
											$tot_present1=0;
											$k=1;
											while($fetch_sql1=mysqli_fetch_array($exec_query_sql1)){ 	
												

												$salary_sql1= "select sum(pay_amount) as total_amount from tbl_emp_bricks_salary  where  delete_status='NDL' and emp_id=".$fetch['emp_id']." and start_date ='" . $start_date1 . "' and  end_date='" . $end_date1 . "'";										
												$salary_query_sql1=mysqli_query($conn, $salary_sql1);
												$fetch_salary=mysqli_fetch_array($salary_query_sql1);

												
												?><td><?php echo $fetch_sql1['total_hour']; ?></td>
												<td><a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-week_date='<?php echo date('Y-m-d');?>' data-emp_id=<?php echo $fetch_sql1['emp_id']?>><button type='button'   class='btn btn-warning' style='padding:4px 5px; 5px; 2px; color:#fff'><?php echo $fetch_sql1['total_hour']*$fetch_sql1['salary']; ?></button></a></td>
												<td><a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-week_date='<?php echo date('Y-m-d');?>' data-emp_id=<?php echo $fetch_sql1['emp_id']?>><button type='button'   class='btn btn-success' style='padding:4px 5px; 5px; 2px; color:#fff'><?php echo $fetch_salary['total_amount']; ?></button></a></td>
												<td><button type='button'   class='btn btn-danger' style='padding:4px 5px; 5px; 2px; color:#fff'><?php echo ($fetch_sql1['total_hour']*$fetch_sql1['salary'])-$fetch_salary['total_amount']; ?></button></td><?php
																		
											}$k++;	
											?>						
											
										
								</tr>

							<?php $j++;} ?>
							</tbody>
							
						</table>
					</div>
                </div>
            </div>
		</div>
	</div>
</main>
<!-- end::main content -->




<div class="modal fade" id="exampleModalCenter6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" style="border:1px solid #000">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle" style="color:#000">Attendance details</h5>

					<!--span class="badge badge-info" style="margin-left:400px;">Gayathri</span-->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="color:#000">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">


							<form id="mainform" method="POST" action="" enctype="multipart/form-data">
								<div class="row">

									<div class="col-md-6">	
										
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Amount :</label>
											<div class="col-sm-5">
												<input type="text" id="pay_amount" class="form-control" placeholder="Amount" name="pay_amount" >

												<input type="hidden" id="week_date" class="form-control"  name="week_date" >

												<input type="hidden" id="emp_id" class="form-control"  name="emp_id" >
												
											</div>


											<div class="form-group">
												<input type="hidden" name="req" id="req">
												<button type="submit" name="update" id="update" class="btn btn-success update" >Save</button>									
												
											</div>

										</div>	

										
											
											
									</div>

									
									<div class="col-md-2">
										<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
									</div>
								</div>
								
							</form>

							
							<table id="attendancegrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th width='5%'>S.no</th>
										<th width='35%'>Payment Date</th>
										<th width='35%'>Week Date</th>										
										<th width='25%'>Amount</th>
										<th width='25%'>Action</th>
										
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
					</button>
				</div>
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

	
	
	$(document).on('click', '.innerid', function() {

			
		var emp_id = $(this).attr('data-emp_id');
		$("#emp_id").val($(this).attr('data-emp_id'));
		$("#week_date").val($(this).attr('data-week_date'));

		$("#attendancegrid").dataTable().fnDestroy();
		$('#attendancegrid').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"ajax": {
				url: "attendance_bricks_details_model_grid.php", // json datasource
				type: "post", // type of method  ,GET/POST/DELETE
				data: {
					emp_id: emp_id
				},
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
				}
			}
		});
	});


	$(".update").click(function(e){		

		e.preventDefault();
		//var pay_amount = $(this).attr('data-pay_amount');
		//var week_date = $(this).attr('data-week_date');
		//var week_date = $(this).attr('data-week_date');	

		var pay_amount = $("#pay_amount").val();
		var emp_id = $("#emp_id").val();
		var week_date = $("#week_date").val();
		
		//var emp_id = $("#emp_id").val($(this).attr('data-emp_id'));
		$("#req").val('ADDINS');	
		

		//var pay_amount =$('#pay_now'+emp_id).val();

		if($('#pay_amount').val()==''){
			swal("Error!", "Invalid amount", "error");
			return false;
		}
		else{
			
			$("#msg").css("color","green").html("Processing . . .");

			//console.log(supplier_id + purchase_id + dc_no + pay_amount + billing_date);
			$.ajax({
				type: "POST",
				url: "attendance_bricks_details_service.php",
				dataType:'json',
				data: {emp_id:emp_id,pay_amount:pay_amount,week_date:week_date},
				success: function(result) {
					console.log(result);
					if(result.op==1){
						swal("Success!", "Successfully Saved !", "success");
						setTimeout(function(){
							window.location.href='attendance_bricks_details.php';
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

	$(document).on('click','.attendance_bricks_salarydeleteTriger', function(){
		var delid=$(this).data('value');
		var alertmsg=confirm("Do you want to Delete ?");
		if (alertmsg == true) {
			$.ajax({
					type: "POST",
					url: "attendance_bricks_service.php",
					dataType:'json',
					data: {delid:delid,req:"ATTSALARYDEL"},
					success: function(result) {
						//console.log(result.op);
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

	

	$("#submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if (emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin') {
		if($("#category").val()==''){
			$("#msg").css("color","red").html('* Enter Category');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else{
			$("#req").val('ADDINS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "phpservices/category_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='category.php';
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
            url :"phpservices/category_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
          }
		 }
    });	

	$(document).on('click','.deleteTriger', function(){
		var emprights=$("#rightsbox").val();
		if (emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin') {
		
		var delid=$(this).data('value');
		var alertmsg=confirm("Do you want to Delete ?");
		if (alertmsg == true) {
			$.ajax({
					type: "POST",
					url: "phpservices/category_service.php",
					dataType:'json',
					data: {delid:delid,req:"categoryDEL"},
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

	$(document).on('change','#select_month', function(){	
		// alert($("#select_year").val());
		$("#attendance_bind").empty();
		$(".page-loader").show();
		var select_month=$("#select_month").val();
		var select_year=$("#select_year").val();
		$.ajax({
			type: "POST",
			url: "attendance_bricks_search_bind.php",
			dataType:'json',
			data: {select_month:select_month,select_year:select_year},
			success: function(result) {
				console.log(result.attendance_bind);
				$(".attendance_bind").html(result.attendance_bind);
				$(".tot_days").html(result.tot_days);
				$(".tot_working").html(result.tot_working);

				$(".tot_employee").html(result.tot_employee);
				$(".tot_holiday").html(result.tot_holiday);
				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	});

	$(document).on('change','#select_year', function(){	
		// alert($("#select_year").val());
		$("#attendance_bind").empty();
		$(".page-loader").show();
		var select_month=$("#select_month").val();
		var select_year=$("#select_year").val();
		$.ajax({
			type: "POST",
			url: "attendance_bricks_search_bind.php",
			dataType:'json',
			data: {select_month:select_month,select_year:select_year},
			success: function(result) {
				console.log(result.attendance_bind);
				$(".attendance_bind").html(result.attendance_bind);
				$(".tot_days").html(result.tot_days);
				$(".tot_working").html(result.tot_working);

				$(".tot_employee").html(result.tot_employee);
				$(".tot_holiday").html(result.tot_holiday);
				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	});

	$(document).on('click','#search', function(){	
		// alert($("#select_year").val());

		
		$("#attendance_bind").empty();
		$(".page-loader").show();
		
		var select_week=$("#select_week").val();
			
		
		//var select_year=$("#select_year").val();
		$.ajax({
			type: "POST",
			url: "attendance_bricks_search_bind.php",
			dataType:'json',
			data: {select_week:select_week},
			success: function(result) {
				console.log(result.attendance_bind);
				$(".attendance_bind").html(result.attendance_bind);
				$(".tot_days").html(result.tot_days);
				$(".tot_working").html(result.tot_working);

				$(".tot_employee").html(result.tot_employee);
				$(".tot_holiday").html(result.tot_holiday);
				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	});

	$(document).on('change','#select_week', function(){	
		// alert($("#select_year").val());
		$("#attendance_bind").empty();
		$(".page-loader").show();
		
		var select_week=$("#select_week").val();
		if(select_week=='' || empty(select_week)){
			var select_week=$("#select_week1").val();
			alert(select_week);
		}
		//var select_year=$("#select_year").val();
		$.ajax({
			type: "POST",
			url: "attendance_bricks_search_bind.php",
			dataType:'json',
			data: {select_week:select_week},
			success: function(result) {
				console.log(result.attendance_bind);
				$(".attendance_bind").html(result.attendance_bind);
				$(".tot_days").html(result.tot_days);
				$(".tot_working").html(result.tot_working);

				$(".tot_employee").html(result.tot_employee);
				$(".tot_holiday").html(result.tot_holiday);
				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	});


	
});
</script>
</html>