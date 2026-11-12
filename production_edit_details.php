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

   <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="vendors/clockpicker/bootstrap-clockpicker.min.css" type="text/css">
    <!-- begin::datepicker -->
    <link rel="stylesheet" href="vendors/datepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css">
    <!-- begin::vmap -->
    <link rel="stylesheet" href="vendors/vmap/jqvmap.min.css">
    <!-- begin::vmap -->
	<link rel="stylesheet" href="vendors/select2/css/select2.min.css" type="text/css">
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
            <h4>Update Production</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Production</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update Production</li>
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


								<?php
									$sql="SELECT *,date_format(a.production_date,'%d/%m/%Y') as production_date FROM tbl_production_details  a  WHERE   a.delete_status!='0' and a.id='".$_GET['id']."'";
									$exec_sql=mysqli_query($conn,$sql);
									$fetch_sql=mysqli_fetch_array($exec_sql); 

									
								?>


							<div class="col-md-6">
									
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-5 col-form-label text-left">Select Operator : <!--a href="javascript:void(0)" id="color_add_but" data-toggle="modal" data-target="#supplierModalCenter">&nbsp;<i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a--></label>
										<div class="col-md-5">

											<select  class="form-control" id="operator_id" name="operator_id" >
												
											</select>

											
										</div>
									</div> 
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-5 col-form-label text-left">Select Product : <!--a href="javascript:void(0)" id="color_add_but" data-toggle="modal" data-target="#supplierModalCenter">&nbsp;<i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a--></label>
										<div class="col-md-5">

											<select  class="form-control" id="product_id" name="product_id" >
												
											</select>

											
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-5 col-form-label text-left">Qty :</label>
										<div class="col-sm-5">										
											<input type="text" class="form-control" id="qty" name="qty" >
										</div>
									</div>
															
										
										
								</div>

													


								<div class="col-md-6">
									
									
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Production No :</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="production_no" name="production_no"  readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Date :</label>
											<div class="col-sm-5">
												<input type="text" id="order_date" class="form-control" placeholder="Date" name="order_date"  value="<?php echo $fetch_sql['production_date']; ?>" >
												<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
											</div>
										</div>	
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Remarks :</label>
											<div class="col-sm-5">
												<textarea type="text" id="remarks" class="form-control" name="remarks" ></textarea>
											</div>
										</div>									
                                    
                                </div>

							

								
								

						<div class="col-md-6">	

							<table id="detailsgrid1" class="table table-striped table-bordered" width="50%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
								<thead>
									<tr>
										<th style="width: 15%">Labour Name</th>	
										
										<th style="width: 5%">Action</th>
									</tr>
								</thead>
								<tbody id="tablemainbind1">
								<?php
									$sql="SELECT b.* FROM tbl_production_details  a 
									inner join tbl_production_labour_details b on a.id=b.production_id 
									left join  tbl_employee_details e on e.emp_id=b.labour_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and   e.delete_status!='0' and b.production_id='".$_GET['id']."'";
									$exec_sql=mysqli_query($conn,$sql);
									$i=0;
									while($fetch_zql=mysqli_fetch_array($exec_sql)){
								?>
									<tr class="trtag" id="trtag<?php echo $i+1;?>">					
										
										
										<td style="padding:5px">
											<select class="form-control" id="labour_id<?php echo $i;?>" name="labour_id[]" style="margin:0;">
												<option value="">Select labour</option>
													<?php
														$sql_product="select * from tbl_employee_details where delete_status='NDL'";
														$exec_sql_product=mysqli_query($conn,$sql_product); 
														while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
														<option value="<?php  echo $fetch_sql_product['emp_id'] ?>"<?php if(($fetch_sql_product['emp_id']) ==(($fetch_zql['labour_id']))) echo "selected" ?>><?php echo $fetch_sql_product['emp_name'] ?></option>
														<?php }  ?>
											</select>
										</td>
										<td style="padding:5px;text-align:center">
											<a href="#" class="trtag1" data-value=<?php echo $i+1;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
										</td>
										
									</tr>
								<?php $i++; } ?>
								</tbody>
								<tfoot id="taxbind1">
																						<tr class="taxdiv" id="taxdiv0">
												<th style="border:none"></th>										
												<th style="border:none; text-align:center;">
													<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc1()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
												</th>
											
											</tr>	
									

								</tfoot>	


							</table>

						</div>


						<div class="col-md-6">

									<table id="detailsgrid1" class="table table-striped table-bordered" width="50%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
										<thead>
											<tr>
												<th style="width: 15%">Shift</th>
												<th style="width: 15%">Start Time</th>	
												<th style="width: 15%">End Time</th>
												<th style="width: 5%">Action</th>
											</tr>
										</thead>
										<tbody id="tablemainbind2">

										<?php
											$sql3="SELECT b.* FROM tbl_production_details  a 
											inner join tbl_production_shift_details b on a.id=b.production_id  WHERE  a.delete_status!='0' and  b.delete_status!='0'  and b.production_id='".$_GET['id']."'";
											$exec_sql3=mysqli_query($conn,$sql3);
											$j=0;
											while($fetch_zql3=mysqli_fetch_array($exec_sql3)){
										?>
										<?php echo $fetch_zql3['start_time'];?>

											<tr class="trtagm" id="trtagm<?php echo $j+1;?>">
												<td style="padding:5px">												
												</td>
												<td style="padding:5px">
												<input type="text" id="start_time_<?php echo $j;?>" class="form-control start_time" placeholder="Start Time" name="start_time[]" value="<?php echo $fetch_zql3['start_time'];?>" >
													
													
												</td>
												<td style="padding:5px">
												<input type="text" id="end_time_<?php echo $j;?>" class="form-control end_time" placeholder="End Time" name="end_time[]" value="<?php echo $fetch_zql3['end_time'];?>" >
													
													
												</td>
												
												<td style="padding:5px;text-align:center">
													<a href="#" class="trtagm1" data-value=<?php echo $j+1;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
												</td>
											</tr>
											<?php $j++; } ?>
										</tbody>
										
										<tfoot id="taxbind1">
																						<tr class="taxdiv" id="taxdiv0">
												<th colspan="3" style="border:none"></th>										
												<th style="border:none; text-align:center;">
													<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc2()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
												</th>
											
											</tr>
										
											

										</tfoot>			


									</table>

								</div>

						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" class="form-control" id="stock_type" name="stock_type" value="Stock">
									<input type="hidden" name="production_id" id="production_id" value=<?php echo $_GET['id'];?>>
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-top:32px;">Save</button>									
									<button type="reset" name="resetbut" id="resetbut" class="btn btn-danger" style="margin-top:32px;">Reset</button>
								</div>
							</div>
							<div class="col-md-2">
							<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>
						
                    </form>
                </table>
                </div>
            </div>
		</div>
	</div>
</main>
<!-- end::main content -->
<div class="modal fade" id="supplierModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Supplier</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="supplier_mainform" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Supplier Name :</label><span style="color:red">*</span>
										<input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter supplier Name">
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

								
								<div class="col-md-3">
									<span id="cus_msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
								</div>
							</div>
							<div class='row'>
							
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="req" id="supplier_req">
										<button type="submit" name="supplier_submit" id="supplier_submit" class="btn btn-success">Save</button>									
										<button type="reset" name="supplier_submit" id="supplier_submit" class="btn btn-danger">Reset</button>
									</div>
								</div>
							</div>
						</form>
						<!--<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
						<hr style="padding-top:0;margin-top:0"/>
						<table id="colorgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Color</th>
								<th>Action</th>
							</tr>
						</thead>
					
					</table>-->
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background: #000321;color: #fff;">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
				</button>
			</div>
		</div>
	</div>
</div>
<!--<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Design</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="mainformwork" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
									<input type="hidden" name="design_id" id="work_design_id" >
										<label>Design:</label>
										<input type="text" placeholder="Design" id="design" name="design"  class="form-control">
									
									</div>
								</div>
							
								<input type="hidden" name="req" id="designreq">
								<span id="designmsg" style="font-weight:bold;float:left;margin-top:7px;"></span>
								<div class="col-md-2">
									<div class="form-group" style="padding-top: 25px;">
										<button type="button" name="submit" id="submitwork" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;">Save</button>
										<button type="button" name="submit" id="updatework" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;display:none;">Update</button>
									</div>
								</div>
							</div>
						</form>
						<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
						<hr style="padding-top:0;margin-top:0"/>
						<table id="defgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Design</th>
								<th>Action</th>
							</tr>
						</thead>
					
					</table>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background: #000321;color: #fff;">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Size</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="sizeformwork" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
									<input type="hidden" name="size_id" id="work_size_id" >
										<label>Size:</label>
										<input type="text" placeholder="Size" id="size" name="size"  class="form-control">
									
									</div>
								</div>
							
								<input type="hidden" name="req" id="sizereq">
								<span id="sizemsg" style="font-weight:bold;float:left;margin-top:7px;"></span>
								<div class="col-md-2">
									<div class="form-group" style="padding-top: 25px;">
										<button type="button" name="submit" id="submitsize" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;">Save</button>
										<button type="button" name="submit" id="updatesize" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;display:none;">Update</button>
									</div>
								</div>
							</div>
						</form>
						<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-update" style="display:none"></button>
						<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
						<hr style="padding-top:0;margin-top:0"/>
						<table id="sizegrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>S.no</th>
								<th>Size</th>
								<th>Action</th>
							</tr>
						</thead>
					
					</table>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background: #000321;color: #fff;">

				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close
				</button>
			</div>
		</div>
	</div>
</div>-->
<input type="hidden" name="modulenamebox" id="modulenamebox" value="4">
<input type="hidden" name="rightsbox" id="rightsbox">


<?php include("footer.php") ?>



<!-- begin::global scripts -->

<!-- end::global scripts -->
<!--script src="vendors/bundle.js"></script-->
<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>
<!-- end::global scripts -->

<!-- begin::charts -->
<script src="vendors/charts/chartjs/chart.min.js"></script>
<script src="vendors/charts/peity/jquery.peity.min.js"></script>
<script src="js/examples/charts/chartjs.js"></script>
<script src="js/examples/charts/peity.js"></script>
<!-- end::charts -->

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
  <!-- START::select2 -->
  <script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<!-- end::select2 -->
<!-- begin::custom scripts -->
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>
<script src="js/examples/sweet-alert.js"></script>
<!-- end::custom scripts -->

</body>


<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>


<script>
$(document).ready(function(){


	$('input[name="order_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});



	  	$('.start_time1').timepicker({
			timeFormat: 'h:mm p',
			interval: 60,
			minTime: '1',
			maxTime: '11:00pm',
			defaultTime: '9',
			startTime: '01:00',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});

			
	   


		$('.end_time1').timepicker({
			timeFormat: 'h:mm p',
			interval: 60,
			minTime: '1',
			maxTime: '11:00pm',
			defaultTime: '9',
			startTime: '01:00',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});

	  $.ajax({
			
			type: "POST",
			url: "staff_operator_dropdown.php",
			success: function(result) {
				var emp_id=result.emp_id;
				var emp_name=result.emp_name;
				var d_length=result.emp_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+emp_id[i]+'">'+emp_name[i]+'</option>';
					
				}
				$("#operator_id").removeAttr("disabled");
				$("#operator_id").append(d_data);
				$(".page-loader").hide();	
			}							
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
			url: "staff_labour_dropdown.php",
			success: function(result) {
				var emp_id=result.emp_id;
				var emp_name=result.emp_name;
				var d_length=result.emp_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+emp_id[i]+'">'+emp_name[i]+'</option>';
					
				}
				$("#labour_id_0").removeAttr("disabled");
				$("#labour_id_0").append(d_data);
				$(".page-loader").hide();	
			}							
		});

		

	 

	$(document).on('click', '.trtag', function () {
		$("#trtag"+$(this).data('value')+"").remove();
		return false;
	});
	
	$(document).on('click', '.trtagm', function () {
		$("#trtagm"+$(this).data('value')+"").remove();
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


	var ids_string=<?php echo $_GET['id']; ?>;
		$(".page-loader").show();
		$.ajax({
			type: "POST",
			url: "production_details_service.php",
			dataType:'json',
			data: {production_id:ids_string,req:"AUB"},
			success: function(result) {
				
				$("#qty").val(result.op[0]['qty']);
				$("#remarks").val(result.op[0]['remarks']);
				//$("#order_date").val(result.op[0]['order_date']);
				$("#production_no").val(result.op[0]['production_no']);

				
				setTimeout(function(){
					$("#product_id").val(result.op[0]['product_id']);
				},1000);

				setTimeout(function(){
					$("#operator_id").val(result.op[0]['operator_id']);
				},1000);

				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});


	$("#supplier_submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#supplier_name").val()==''){
				$("#cus_msg").css("color","red").html('* Enter supplier Name');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else if($("#mblno").val()==''){
				$("#cus_msg").css("color","red").html('* Enter Mobileno');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else if($("#address").val()==''){
				$("#cus_msg").css("color","red").html('* Enter Address');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else{
				$("#supplier_req").val('ADDINS');
				$("#cus_msg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "supplier_service.php",
						dataType:'json',
						data: $("#supplier_mainform").serialize(),						
						success: function(result) {
							var supplier_name = $("#supplier_name").val();
							//console.log(supplier_name);
							//console.log(result.op);
							if(result.op=='' || result.op==null){
								$("#cus_msg").css("color","red").html('Duplicate supplier already exists !');
								setTimeout(function(){$("#cus_msg").html('')},3000);
								return false;
							}else{

								if(result.op==1){
									
									swal("Success!", "Successfully Saved !", "success");
									setTimeout(function(){
										window.location.href='production_edit_details.php?id=<?php echo $_GET['id'];?>';
									},2000);
								}
								else{
									alert($("#cus_msg").html(result.op));
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

	
	
setTimeout(function(){
	var datefullvalue= $("#date1").val();
	var datevalue = datefullvalue.split('/')[0];
	var monthvalue = datefullvalue.split('/')[1];
	var yearvalue = datefullvalue.split('/')[2];
	$("#order_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);
},500);

$("#date1").change(function(){
	var datefullvalue= $("#date1").val();
	var datevalue = datefullvalue.split('/')[0];
	var monthvalue = datefullvalue.split('/')[1];
	var yearvalue = datefullvalue.split('/')[2];
	$("#order_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);
});
	

	$("#resetbut").click(function(){
		$("#gal_cat_id").val('');
		$("#title").val('');
		$("#photo").val('');
		$("#photo_name").val('');
		$("#imgpreview").html('<label>Image Preview :</label><img src="media/image/no_image.png"  style="width:100px;margin-left:4px">');
		$("#resetbut").css('outline','none');
		$("#resetbut").css('box-shadow','none');
	});

	/*
	$.ajax({
			
			type: "POST",
			url: "staff_operator_dropdown.php",
			success: function(result) {
				var emp_id=result.emp_id;
				var emp_name=result.emp_name;
				var d_length=result.emp_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+emp_id[i]+'">'+emp_name[i]+'</option>';
					
				}
				$("#operator_id").removeAttr("disabled");
				$("#operator_id").append(d_data);
				$(".page-loader").hide();	
			}							
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
			url: "staff_labour_dropdown.php",
			success: function(result) {
				var emp_id=result.emp_id;
				var emp_name=result.emp_name;
				var d_length=result.emp_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+emp_id[i]+'">'+emp_name[i]+'</option>';
					
				}
				$("#labour_id_0").removeAttr("disabled");
				$("#labour_id_0").append(d_data);
				$(".page-loader").hide();	
			}							
		});*/

	
	

	

	$("#submit").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#operator_id").val()==''){
			swal("Error!", "Select Supplier !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}			
		else if($("#order_date").val()==''){
			swal("Error!", "Select Date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}	
		else if($("#product_id").val()==''){
			swal("Error!", "Select product !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}		
		else if($("#qty").val()==''){
			swal("Error!", "Enter Quantity !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			//$("#req").val('PACKING_PRINTING_UPD');
			$("#req").val('UPD');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "production_details_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='production_details.php';
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
function qualaddfunc1(){
	var count = document.getElementsByClassName("trtag").length;
	$("#tablemainbind1").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control js-example-basic-single select2-hidden-accessible labour_id" name="labour_id[]" id="labour_id_'+count+'"></select><div id="suggesstion-box_'+count+'"></div></td>		<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');


	$("#labour_id_" + count).select2({});


	$("#labour_id_"+count).empty();	
	$.ajax({
			
			type: "POST",
			url: "staff_labour_dropdown.php",
			success: function(result) {
				var emp_id=result.emp_id;
				var emp_name=result.emp_name;
				var d_length=result.emp_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+emp_id[i]+'">'+emp_name[i]+'</option>';
					
				}
				$("#labour_id_"+count).removeAttr("disabled");
				$("#labour_id_"+count).append(d_data);
				$(".page-loader").hide();	
			}							
		});

		

}
function qualaddfunc2(){
	var count = document.getElementsByClassName("trtagm").length;

	
	$("#tablemainbind2").append('<tr class="trtagm" id="trtagm'+count+'"><td style="padding:5px"></td> <td style="padding:5px"><input type="text" id="start_time_'+count+'" name="start_time[]" placeholder="Start Time" class="form-control start_time" /><div id="suggesstion-box_'+count+'"></div></td><td style="padding:5px"><input type="text" id="end_time_'+count+'" name="end_time[]" placeholder="End Time " class="form-control end_time" /><div id="suggesstion-box1_'+count+'"></div></td>		<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtagm1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');


	$('#start_time_'+count).timepicker({
			timeFormat: 'h:mm p',
			interval: 60,
			minTime: '1',
			maxTime: '11:00pm',
			defaultTime: '9',
			startTime: '01:00',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});   


		$('#end_time_'+count).timepicker({
			timeFormat: 'h:mm p',
			interval: 60,
			minTime: '1',
			maxTime: '11:00pm',
			defaultTime: '9',
			startTime: '01:00',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});
	

}
</script>
</html>