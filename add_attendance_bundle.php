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
	#tablemainbind{

		padding: 0.2rem!important;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 36px;
}
	</style>
<!-- begin::main content -->
<main class="main-content">

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4> Add bundle Attendance</h4>
        </div>
    </div>
	<div class="row">
        <div class="col-md-6">
			<div class="card">
                <div class="card-body">
                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">		
							<div class="row">
								<div class="col-md-6">
									<div class="input-block">
										<input type="text" id="attendance_date" class="form-control" placeholder="Date" name="attendance_date" >
										<span class="placeholder">
										Attedance Date
										</span>
									</div>
								
								</div>
								<?php
									$sql_present= "select count(attendance_id) as present from tbl_attendance_bundle where attendance_date='".date('Y-m-d')."' and delete_status='NDL'and attendance_status='Present' GROUP BY attendance_status";
									$exec_query_present=mysqli_query($conn, $sql_present);
									$fetch_present=mysqli_fetch_assoc($exec_query_present);
									$sql_absent="select count(attendance_id) as absent from tbl_attendance_bundle where attendance_date='".date('Y-m-d')."' and delete_status='NDL'and attendance_status='Absent' GROUP BY attendance_status";
									$exec_query_absent=mysqli_query($conn, $sql_absent);
									$fetch_absent=mysqli_fetch_assoc($exec_query_absent);

									if(!empty($fetch_present['present'])){ $present=$fetch_present['present']; }else{ $present=0; }
									if(!empty($fetch_absent['absent'])){ $absent=$fetch_absent['absent']; }else{ $absent=0; }

								?>
								<!--div class="col-sm-6">								
										<span>Tot.Present : <span style="color:green;font-weight:bold; font-size:25px;" id="total_present"><?php //echo $present; ?></span>	</span>
										<span style="margin-left:0px;">&nbsp;&nbsp; Tot.Absent: <span style="color:red;font-weight:bold;font-size:25px;" id="total_absent"><?php //echo $absent; ?></span>	</span>
								</div-->
								
								
							</div>
							
						<div class="row" style="margin-top:20px;">
							<div class="col-sm-12">
								<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="display:block;margin-bottom:0;overflow-x:scroll;border: none;">
									<thead>
										<tr>
											<th style="width: 2%;color:#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc;">S.No</th>
											<th style="width: 10%;color:#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc;">E.Name</th>
											<th style="width: 10%;color:#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc;">bundle(s)</th>
											<!--th style="width: 10%;text-align:center;color:#ffffffcc#ffffffcc#ffffffcc#ffffffcc#ffffffcc;">Present<br><input type="radio"  id="attendance_present"></th>
											<th style="width: 10%;text-align:center;color:#ffffffcc#ffffffcc#ffffffcc#ffffffcc;">Absent<br><input type="radio" id="attendance_absent"></th>
											<th style="width: 10%;text-align:center;color:#ffffffcc#ffffffcc#ffffffcc;">Halfday<br><input type="radio" id="attendance_halfday"></th>
											<th style="width: 10%;text-align:center;color:#ffffffcc;">Festival <br><input type="radio" id="attendance_festival"> </th>
											<th style="width: 10%;text-align:center;color:#ffffffcc#ffffffcc;">Sunday <br><input type="radio" id="attendance_sunday"> </th-->
										</tr>
									</thead>

									<tbody id="tablemainbind">
									<?php 
									 $employee_sql="select * from tbl_employee_details where delete_status='NDL' and emp_salary_type='4' order by emp_id desc";
										$employee_query=mysqli_query($conn,$employee_sql);
										$i=0;
										while($employee_fetch_results=mysqli_fetch_array($employee_query)){
											$cur_date = date('Y-m-d');
											$sql_attendance= "select t1.* from tbl_attendance_bundle t1  where t1.attendance_date='".$cur_date."' and emp_id=".$employee_fetch_results['emp_id']." and t1.delete_status='NDL'";
											$exec_query_attendance=mysqli_query($conn, $sql_attendance);
											$fetch_results_attendance=mysqli_fetch_array($exec_query_attendance);
											$attendance_status = (!empty($fetch_results_attendance) && isset($fetch_results_attendance['attendance_status'])) ? $fetch_results_attendance['attendance_status'] : '';

											?>
										<tr>
											<td><?php echo $i+1;;?></td>
											<td style="color:#795548;font-weight:bold;">

											<?php echo $employee_fetch_results['emp_name'];?> <input type="hidden" name="emp_id[]" value="<?php echo  $employee_fetch_results['emp_id']; ?>">
											</td>
											<td align="center">

												<input type="number" name="attendance_status<?php echo  $i; ?>[]"  id="attendance_present<?php echo  $i; ?>" value="<?php echo  $attendance_status; ?>" >
											</td>
											
										</tr>	
									
										
									<?php	$i++;} ?>							
									</tbody>
								
								</table>
							</div>
						</div>						
						
							<div class="col-md-12 text-center" style="margin-top:20px;">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<button type="submit" name="submit" id="submit" class="btn btn-success">Save</button>									
									<a href="add_attendance_bundle.php"><button type="button" id="cansubmit" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</div>
					</div>
				
                    </form>					
		
                </div>
            </div>
		</div>
	</div>
	
</main>


<input type="hidden" name="modulenamebox" id="modulenamebox" value="10">
<input type="hidden" name="rightsbox" id="rightsbox">


<!-- end::main content -->
<style>
.dataTables_length{
	text-align:left;
}
.dataTables_filter{
	text-align:left;
}
td{
	color:#795548;
	font-weight:bold;
}
</style>
<!-- begin::global scripts -->
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
<style>
@media(min-width:992px){
	.navbar-nav{
		display:block!important;
		width:100%;
	}
	.userdiv{
		float:right;
	}
	.mybut{
		margin-top:33px;
	}
}

@media(max-width:480px){
	nav.navbar .header-logo a img{
		width:180px;
	}
}
</style>


<script>

$(document).ready(function() {

	$('input[name="attendance_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});


	var attendance_date=$("#attendance_date").val();


	function  attendance1(){
		var attendance_date=$("#attendance_date").val();
		$.ajax({
			type: "POST",
			url: "attendance_bundle_service.php",
			dataType:'json',
			data: {attendance_date:attendance_date,req:"AUB"},
			success: function(result) {
				console.log(result.op.result.length);		
			
				if(result.op.result.length >0){
				if(result.op['total_present']!=null){
				$("#total_present").html(result.op['total_present']);
				}
				else{
					$("#total_present").html("0");
				}
				if(result.op['total_absent']!=null){

					$("#total_absent").html(result.op['total_absent']);
				}
				else{
					$("#total_absent").html("0");
				}
				var html='';
				for(i=0;i<result.op.result.length;i++)
				{
					
					
					attendance=result.op.result[i]['attendance_status'];
					
					emp_name=result.op.result[i]['emp_name'];
					emp_id=result.op.result[i]['emp_id'];	
					emp_name=result.op.result[i]['emp_name'];
					emp_id=result.op.result[i]['emp_id'];
					
					
					html+='<tr><td>'+parseInt(i+1)+'</td><td>'+emp_name+'<input type="hidden" name="emp_id[]" value="'+emp_id+'"></td><td align="center"><input type="number" name="attendance_status'+i+'[]"  id="attendance_present'+i+'" value="'+attendance+'" ></td></tr>';	


					
							
				}
				$("#tablemainbind").html(html);
			
				}
				else{
					$("#total_present").html("0");
					$("#total_absent").html("0");
					html='<tr><td colspan="5" class="text-center">No Result Found</td></tr>';
				$("#tablemainbind").html(html);
			}

			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});	
	}
	/*setTimeout(function(){
		$('#attendance_absent').prop('checked',false);
	 $('#attendance_festival').prop('checked',false);
	 $('#attendance_sunday').prop('checked',false);
	 $('#attendance_present').prop('checked',false);
	 $('#attendance_halfday').prop('checked',false);
		var datefullvalue= $("#a_date").val();
		var datevalue = datefullvalue.split('/')[0];
		var monthvalue = datefullvalue.split('/')[1];
		var yearvalue = datefullvalue.split('/')[2];
		$("#attendance_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);

		// attendance1();
	},100); */
	
	/*$("#a_date").change(function(){

	$('#attendance_absent').prop('checked',false);
	 $('#attendance_festival').prop('checked',false);
	 $('#attendance_sunday').prop('checked',false);
	 $('#attendance_present').prop('checked',false);
	 $('#attendance_halfday').prop('checked',false);
		var datefullvalue= $("#a_date").val();
		var datevalue = datefullvalue.split('/')[0];
		var monthvalue = datefullvalue.split('/')[1];
		var yearvalue = datefullvalue.split('/')[2];
		$("#attendance_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);
	
		attendance1()
	}); */

	$("#attendance_date").change(function(){		
		attendance1()
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
			var count = document.getElementsByClassName("trtag").length;
			var check_count=count-1;
			console.log(count);		
	
	 if($("#attendance_date").val()==''){
			$("#msg").css("color","red").html('* Enter Work Order Date');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}		
		else{
			$("#req").val('ADDINS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "attendance_bundle_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						if(result.op==2){
							swal("Already Exist");
							// $("#msg").css("color","red").html("already Exist");
						}
						else if(result.op==1){
							$("#msg").css("color","green").html("Successfully Saved !");
							setTimeout(function(){
								window.location.href='add_attendance_bundle.php';
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