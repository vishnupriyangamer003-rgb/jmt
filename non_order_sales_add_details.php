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
 <h4>Order Quotation DC Details</h4>
 <nav aria-label="breadcrumb">
 <ol class="breadcrumb m-t-0">
 <li class="breadcrumb-item"><a href="#">DC</a></li>
 <li class="breadcrumb-item active" aria-current="page">Order Quotation DC Details</li>
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

							<div class="col-md-6">

								<div class="form-group row">
 <label for="staticEmail" class="col-sm-5 col-form-label text-left">Service Provider:</label>
 <div class="col-md-5">
										<?php
										$admin_sql = "select * from tbl_admin where admin_id='1'";
										$admin_exec_sql = mysqli_query($conn, $admin_sql);
										$admin_fetch_sql = mysqli_fetch_array($admin_exec_sql);
										?>
										<p style="margin-bottom: 0rem;"><b><?php echo $admin_fetch_sql['cname']; ?></b></p>
										<p style="margin-bottom: 0rem;"><?php echo $admin_fetch_sql['addr']; ?></p>
										<p style="margin-bottom: 0rem;"><b>GST :</b> <?php echo $admin_fetch_sql['gstno']; ?></p>
									</div>
								</div> 
								<?php
									$sql1="SELECT *,a.order_id,a.order_no,a.order_date,a.customer_id FROM tbl_order a 
									inner join tbl_order_details b on a.order_id=b.order_id 
									left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' and b.delete_status!='0' and d.delete_status!='0' and a.order_id='".$_GET['id']."'";
									$exec_sql1=mysqli_query($conn,$sql1);
									$fetch_sql1=mysqli_fetch_array($exec_sql1);?>
									
								<div class="form-group row">
 <label for="staticEmail" class="col-sm-5 col-form-label text-left">Customer Detail : </label>
 <div class="col-md-5">
									<input type="hidden" class="form-control" id="order_id" name="order_id" value="<?php echo $_GET['id'];?>" readonly>
									<input type="hidden" class="form-control" id="customer_id" name="customer_id" value="<?php echo $fetch_sql1['customer_id'];?>" >

									<?php
										$cus_sql = "select * from tbl_customer where customer_id='".$fetch_sql1['customer_id']."'";
										$cus_exec_sql = mysqli_query($conn, $cus_sql);
										$cus_fetch_sql = mysqli_fetch_array($cus_exec_sql);
										?>
										<p style="margin-bottom: 0rem;"><b><?php echo $cus_fetch_sql['customer_name']; ?></b></p>
										<p style="margin-bottom: 0rem;"><?php echo $cus_fetch_sql['address']; ?></p>
										<p style="margin-bottom: 0rem;"><b>GST :</b> <?php echo $cus_fetch_sql['gstno']; ?>

									</div>

									

								</div> 
								 
 </div>

								
								<div class="col-md-6">
									
									
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Order No :</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="order_no" name="order_no" value="<?php echo $fetch_sql1['order_no'];?>" readonly>
											</div>
										</div>

										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">DC No :</label>
											<div class="col-sm-5">
											<?php
												
												$sql = "select * from tbl_non_dc where delete_status='NDL'";
												$exec_sql = mysqli_query($conn, $sql);
												$fetch_sql = mysqli_fetch_array($exec_sql);
												$rows_sql = mysqli_num_rows($exec_sql);
												if ($rows_sql) {
													$firstPart ='00'.($rows_sql + 1);
												} else {
													$firstPart ='001';
												}
												?>
												<input type="text" class="form-control" id="dc_no" name="dc_no" value="<?php echo $firstPart; ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right"> Date :</label>
											<div class="col-sm-5">
											<input type="text" id="order_date" class="form-control" placeholder="Pick Invoice Date" name="order_date" >
												
											</div>
										</div>

										


										<div class="form-group row">
											<label class="col-sm-5 col-form-label text-right">Refrence Name</label>
											<div class="col-sm-5">
												<input type="text" id="refrence_name" class="form-control" placeholder="Enter refrence name" name="refrence_name" value="<?php echo $fetch_sql['refrence_name'];?>">
												
											</div>
										</div>	
									
 
 </div>

							
							
							<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
							<thead>
								<tr>
									<th style="width: 25%">Product</th>
									<th style="width: 15%">UOM</th>								
									<th style="width: 10%">Quantity</th>
									<th style="width: 20%">Rate</th>
									<th style="width: 25%">Amount</th>
									<th style="width: 10%">Action</th>
								</tr>
							</thead>
							<tbody id="tablemainbind">
							<?php
								$sql="SELECT b.*,a.order_id FROM tbl_order a 
								inner join tbl_order_details b on a.order_id=b.order_id 
								left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' and b.delete_status!='0' and d.delete_status!='0' and b.order_id='".$_GET['id']."'";
								$exec_sql=mysqli_query($conn,$sql);
								$i=0;
								while($fetch_zql=mysqli_fetch_array($exec_sql)){
							?>
								<tr class="trtag" id="trtag<?php echo $i+1;?>">
								
								
									<td style="padding:5px">
										 <select class="form-control" id="product_id_<?php echo $i;?>" name="product_id[]" style="margin:0;">
											<option value="">Select product</option>
												<?php
													$sql_product="select * from tbl_products where delete_status='NDL'";
													$exec_sql_product=mysqli_query($conn,$sql_product); 
													while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
													<option value="<?php echo $fetch_sql_product['product_id'] ?>"<?php if(($fetch_sql_product['product_id']) ==(($fetch_zql['product_id']))) echo "selected" ?>><?php echo $fetch_sql_product['product_name'] ?></option>
													<?php } ?>
										</select>
									</td>


									<td style="padding:5px">
										 <select class="form-control" id="uom_id_<?php echo $i;?>" name="uom_id[]" style="margin:0;">
											<option value="">Select uom</option>
												<?php
													$sql_uom="select * from tbl_uom where delete_status='NDL'";
													$exec_sql_uom=mysqli_query($conn,$sql_uom); 
													while($fetch_sql_uom=mysqli_fetch_array($exec_sql_uom)){?>
													<option value="<?php echo $fetch_sql_uom['uom_id'] ?>"<?php if(($fetch_sql_uom['uom_id']) ==(($fetch_zql['uom_id']))) echo "selected" ?>><?php echo $fetch_sql_uom['uom_name'] ?></option>
													<?php } ?>
										</select>
									</td>

									
									<td style="padding:5px">
										<input type="number" class="form-control qty" name="qty[]" id="qty_<?php echo $i;?>" placeholder="Enter Qty" value="<?php echo $fetch_zql['qty'];?>">
									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control product_rate" name="product_rate[]" id="product_rate_<?php echo $i;?>" placeholder="Enter Rate" value="<?php echo $fetch_zql['product_rate'];?>">

									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control rate" name="rate[]" id="rate_<?php echo $i;?>" placeholder="Enter Amount" value="<?php echo $fetch_zql['rate'];?>" readonly>

									</td>
									
									<td style="padding:5px;text-align:center">
										<a href="#" class="trtag1" data-value=<?php echo $i+1;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
									</td>
									
								</tr>
							<?php $i++; } ?>
							</tbody>
							<tfoot id="taxbind1">
								<tr class="taxdiv" id="taxdiv0">
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>										
									<th colspan="3" style="border:none">
										<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
									</th>
								
								</tr>
							
							
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="4" class="text-right">Total</th>
 <th colspan="2"><input type="text" class="form-control" id="total_amount" name="total_amount" value="<?php echo $fetch_sql['total_amount'];?>" style="margin:0;"></th>
 </tr>
 
 
 <tr class="taxdiv" id="taxdiv0" style="display: none">
 <th colspan="4" class="text-right" style="font-size:16px;color:#5700f0">
 Discount</th>
 <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control discount" id="discount" name="discount" value="<?php echo $fetch_sql['discount'];?>" placeholder="Discount in Rs." style="margin:0;"></th>
 </tr>
 
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="4" class="text-right" style="font-size:16px;color:red">
 Grand Total Amount</th>
 <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control grand_total_amount" id="grand_total_amount" name="grand_total_amount" placeholder="Grand Total" style="margin:0;" value="<?php echo $fetch_sql['grand_total_amount'];?>" readonly></th>
 </tr>

 </tfoot>


						</table>
						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" class="form-control" id="dc_type" name="dc_type" value="dc">
									
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
<div class="modal fade" id="customerModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Add Customer</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="customer_mainform" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Customer Name :</label><span style="color:red">*</span>
										<input type="text" class="form-control" id="m_customer_name" name="customer_name" placeholder="Enter Customer Name">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Company Name :</label>
										<input type="text" class="form-control" id="m_company_name" name="company_name" placeholder="Enter Company Name">
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Mobile Number :</label><span style="color:red">*</span>
										<input type="number" class="form-control" id="m_mblno" name="mblno" placeholder="Enter Mobile Number">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Email Id :</label>
										<input type="email" class="form-control" id="m_email" name="email" placeholder="Enter Email Id">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Address :</label><span style="color:red">*</span>
										<textarea class="form-control" id="m_address" name="address" placeholder="Enter Address"></textarea>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>GST Number :</label>
										<input type="text" class="form-control" id="m_gst_no" name="gst_no" placeholder="Enter GST Number">
									</div>
								</div>



								
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Reference Name :</label>
										<input type="text" class="form-control" id="m_reference_name" name="reference_name" placeholder="Enter Reference Name">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Owner Name :</label>
										<input type="text" class="form-control" id="m_owner_name" name="owner_name" placeholder="Enter Owner Name">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Owner Contact Number :</label>
										<input type="number" class="form-control" id="m_owner_contact" name="owner_contact" placeholder="Enter Owner Contact">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Reference Details :</label>
										<textarea class="form-control" id="m_reference_details" name="reference_details" placeholder="Enter Reference Details"></textarea>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>State :</label>
										<input type="text" class="form-control" id="m_state" name="state" placeholder="Enter State">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>State Code :</label>
										<input type="text" class="form-control" id="m_state_code" name="state_code" placeholder="Enter state code">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Status :</label>
										<select class="form-control" id="m_status" name="status">
											<option value="Active" selected>Active</option>
											<option value="Inactive">Inactive</option>
										</select>
									</div>
								</div>
<div class="col-md-3">
									<span id="cus_msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
								</div>
							</div>
							<div class='row'>
							
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="customer_req" id="customer_req">
										<button type="submit" name="customer_submit" id="customer_submit" class="btn btn-success">Save</button>									
										<button type="reset" name="customer_reset" id="customer_reset" class="btn btn-danger">Reset</button>
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

<input type="hidden" name="modulenamebox" id="modulenamebox" value="1">
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


<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script>
	

$(document).ready(function(){

	$(document).on('change', '#driver_type', function() {

		if( this.value == '1'){
			$("#driver_own").show();
			
			$("#driver_other").hide();

			
			
		}else if( this.value == '2'){
			$("#driver_other").show();
			
			$("#driver_own").hide();
			
			
			
		}
	});

	$('input[name="order_date"]').daterangepicker({
 
	 singleDatePicker: true,
	 showDropdowns: true,
	 locale: {
		 format: 'DD/MM/YYYY'
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

	
	$(document).on('click', '.trtag1', function () {
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


	$("#customer_submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#customer_mainform #m_customer_name").val()==''){
				swal("Error!", " Enter Customer Name !", "warning");
				return false;
			}
			/*else if($("#company_name").val()==''){
				swal("Error!", " Enter Company Name !", "warning");
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}*/
			else if($("#customer_mainform #m_mblno").val()==''){
				swal("Error!", " Enter Mobile No. !", "warning");
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}
			else if($("#customer_mainform #m_address").val()==''){
				swal("Error!", " Enter Customer Address !", "warning");
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}
			else{
				$("#customer_req").val('ADDINS');
				$.ajax({
						type: "POST",
						url: "customer_service.php",
						dataType:'json',
						data: $("#customer_mainform").serialize(),
						success: function(result) {
							console.log(result.op);
							if(result.op=='' || result.op==null){
									swal("Error!", " Customer Name already exists ! !", "warning");
								setTimeout(function(){$("#msg").html('')},3000);
								return false;
							}else{
								if(result.op==1){
									var newId = result.customer_id;
									var newName = $("#customer_mainform #m_customer_name").val();
									$("#customerModalCenter").modal('hide');
									if(newId){
										var opt = new Option(newName, newId, true, true);
										$("#customer_id").append(opt).val(newId).trigger('change');
									}
									$("#customer_mainform")[0].reset();
									swal("Success!", "Customer added and selected !", "success");
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


	
	
/*setTimeout(function(){
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
});*/
	

	$("#resetbut").click(function(){
		$("#gal_cat_id").val('');
		$("#title").val('');
		$("#photo").val('');
		$("#photo_name").val('');
		$("#imgpreview").html('<label>Image Preview :</label><img src="media/image/no_image.png" style="width:100px;margin-left:4px">');
		$("#resetbut").css('outline','none');
		$("#resetbut").css('box-shadow','none');
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
				$(".driver_id").removeAttr("disabled");
				$(".driver_id").append(d_data);
				$(".page-loader").hide();	
			}							
		});

		/*var ids_string=<?php //echo $_GET['id']; ?>;
		$(".page-loader").show();
		$.ajax({
			type: "POST",
			url: "non_sales_details_service.php",
			dataType:'json',
			data: {dc_id:ids_string,req:"AUB"},
			success: function(result) {		
						
				
				setTimeout(function(){
					$("#driver_type").val(result.op[0]['driver_type']);
				},1000);


				if(result.op[0]['driver_type'] == '1'){
					$("#driver_own").show();					
					$("#driver_other").hide();					
					
				}else if( result.op[0]['driver_type'] == '2'){
					$("#driver_other").show();					
					$("#driver_own").hide();			
					
				}


				$("#driver_name").val(result.op[0]['driver_name']);
				
				$("#vechicle_no").val(result.op[0]['vechicle_number']);
				$("#vechicle_id").val(result.op[0]['vechicle_id']);

				$("#refrence_name").val(result.op[0]['refrence_name']);
				$("#dc_no").val(result.op[0]['dc_no']);
				$("#customer_id").val(result.op[0]['customer_id']);
				$("#total_amount").val(result.op[0]['total_amount']);
				$("#grand_total_amount").val(result.op[0]['grand_total_amount']);

				
				setTimeout(function(){
					$("#driver_id").val(result.op[0]['driver_id']);
				},1000);

				

				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});*/



		$(".product_id").empty();	
		$.ajax({
			type: "POST",
			url: "product_dropdown.php",
			success: function(result) {
				if(result.product_id){
					var product_id=result.product_id;
					var product_name=result.product_name;
					
					var d_length=result.product_id.length;
					var d_data='<option value="">Select Product</option>';
					if(result.product_id!="select Product"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option value="'+product_id[i]+'">'+product_name[i]+'</option>';
						}
					}

					$(".product_id").append(d_data);
					$("#grid-loader").hide();
				}
				else{
					$("#grid-loader").hide();
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});	


		$(".uom_id").empty();	
		$.ajax({
			type: "POST",
			url: "uom_dropdown.php",
			success: function(result) {
				if(result.uom_id){
					var uom_id=result.uom_id;
					var uom_name=result.uom_name;
					
					var d_length=result.uom_id.length;
					var d_data='<option value="">Select uom</option>';
					if(result.uom_id!="select uom"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option value="'+uom_id[i]+'">'+uom_name[i]+'</option>';
						}
					}

					$(".uom_id").append(d_data);
					$("#grid-loader").hide();
				}
				else{
					$("#grid-loader").hide();
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});	

	

		$(document).on('change', '.product_id', function() {	
			var id = this.id;
			var product_id=$("#"+id).val();
			var splitid = id.split('_');
			var index = splitid[2];
			if(index === undefined || index === ''){ return; }
			if(!product_id && product_id !== 0 && product_id !== '0'){
				$("#product_rate_"+index).val('');
				$("#uom_id_"+index).val(0);
				$("#rate_"+index).val('');
				if(typeof get_total_amount === 'function'){ get_total_amount(); }
				return;
			}
			
			$.ajax({
				type: "POST",
				url: "get_product_rate.php",
				dataType:'json',
				data: {product_id:product_id},
				success: function(result) {
					if(!result || typeof result !== 'object'){ $("#grid-loader").hide(); return; }
					var pr = Array.isArray(result.product_rate) ? result.product_rate[0] : result.product_rate;
					var um = Array.isArray(result.uom_id) ? result.uom_id[0] : result.uom_id;
					if(pr !== undefined && pr !== null && pr !== ''){
						$("#product_rate_"+index).val(pr);
						var q = parseFloat($("#qty_"+index).val() || 0);
						if(q > 0){ $("#rate_"+index).val((parseFloat(pr) * q).toFixed(2)); if(typeof get_total_amount === 'function'){ get_total_amount(); } }
						if(um !== undefined && um !== null && um !== ''){ $("#uom_id_"+index).val(um); }
						$("#grid-loader").hide();
					}
					else{
						$("#product_rate_"+index).val(0);
						$("#grid-loader").hide();
					}
				},error:function(xhr,status,error){
					console.log(JSON.stringify(xhr,status,error));
					$("#grid-loader").hide();
				}
			});
		});



		$(document).on('keyup', '.qty', function() {
			var id = this.id;
			//var product_id=$("#"+id).val();
			var splitid = id.split('_');
			var index = splitid[1];
			var qty = $("#qty_"+index).val();
			var product_rate = $("#product_rate_"+index).val();
			
			
				price = product_rate * qty;
				discount = price;
					
			//$("#total_amount").val(price.toFixed(2));
			$("#rate_"+index).val(discount);
		});

	
	$(document).on('keyup', '.product_rate', function() {
		var id = this.id;
		var product_id=$("#"+id).val();
		var splitid = id.split('_');
		var index = splitid[2];

 var product_rate = $("#product_rate_"+index).val();
 var qty = $("#qty_"+index).val();
 
 price = product_rate * qty;
 discount = price;
 		
		//$("#total_amount").val(price.toFixed(2));
 $("#rate_"+index).val(discount);
 });

	$(".qty").blur(function(){
		
			var id = this.id;
			//var product_id=$("#"+id).val();			
			var splitid = id.split('_');
			var index = splitid[1];	
			var qty = $("#qty_"+index).val();
			var product_rate = $("#product_rate_"+index).val();			
			
				price = product_rate * qty;
				discount = price;
					
			//$("#total_amount").val(price.toFixed(2));
			$("#rate_"+index).val(discount); 

 get_total_amount();
 }); 

	

	$(document).on('keyup', '.qty', function() {
		get_total_amount();
 });

	$(document).on('keyup', '.product_rate', function() {
		get_total_amount();
 });
	
	

	$(document).on('keyup', '.total_amount', function() {
		get_total_amount();
 });

	
	function get_total_amount() {
		var row_count = (document.getElementsByClassName("rate").length);		
 countofamount = 0;		
 for (i = 0; i < row_count; i++) {	
 if (($("#rate_"+i).val() != '')) { 				
				countofamount += +$("#rate_"+i).val();		
 }
 }
 if (isNaN(countofamount)) {
			countofamount =0;
		}	
 total_amount = countofamount;		
		
 $("#total_amount").val(total_amount.toFixed(2));
		grand_total = total_amount;
		$("#grand_total").val(grand_total.toFixed(2));
		
		
		if ($("#discount").val() == '') {
			var discount = 0;
		} else {
			var discount = $("#discount").val();
		}
		var grand_total_amount = grand_total;
		$("#grand_total_amount").val(grand_total_amount.toFixed());
	}

	
	

	

	$("#submit").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#customer_id").val()==''){
			swal("Error!", "Select Customer !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#order_date").val()==''){
			swal("Error!", "Select Date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#product_id_0").val()==''){
			swal("Error!", "Select product !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		
		else if($("#qty_0").val()==''){
			swal("Error!", "Enter Quantity !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#rate_0").val()==''){
			swal("Error!", "Enter Rate !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			//$("#req").val('PACKING_PRINTING_UPD');
			$("#req").val('ADDINS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "non_sales_details_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='non_sales_details.php';
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
function qualaddfunc(){
	var count = document.getElementsByClassName("trtag").length;
	$("#tablemainbind").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control product_id" name="product_id[]" id="product_id_'+count+'"></select></td><td style="padding:5px"><select class="form-control uom_id" name="uom_id[]" id="uom_id_'+count+'"></select></td>	<td style="padding:5px"><input type="number" class="form-control qty" name="qty[]" id="qty_'+count+'" placeholder="Enter Qty" style="margin:0;"></td>	<td style="padding:5px"><input type="number" class="form-control product_rate" name="product_rate[]" id="product_rate_'+count+'" placeholder="Enter Rate" style="margin:0;">	</td><td style="padding:5px"> 				<input type="number" class="form-control rate" name="rate[]" id="rate_'+count+'" placeholder="Enter Amount" style="margin:0;" readonly>			</td>				<td style="padding:5px;text-align:center"> 										<a href="#" data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');
	$("#product_id_"+count).empty();	
		$.ajax({
			type: "POST",
			url: "product_dropdown.php",
			success: function(result) {
				if(result.product_id){
					var product_id=result.product_id;
					var product_name=result.product_name;
					
					var d_length=result.product_id.length;
					var d_data='<option value="">Select Product</option>';
					if(result.product_id!="select Product"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option value="'+product_id[i]+'">'+product_name[i]+'</option>';
						}
					}

					$("#product_id_"+count).append(d_data);
					$("#grid-loader").hide();
				}
				else{
					$("#grid-loader").hide();
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});


		//$("#uom_id_" + count).select2({});

		$("#uom_id_"+count).empty();
		$.ajax({			
			type: "POST",
			url: "uom_dropdown.php",
			success: function(result) {

				console.log(result);
				if(result.uom_id){
					var uom_id=result.uom_id;
					var uom_name=result.uom_name;
					var d_length=result.uom_id.length;
					var d_data='';
					for(var i=0;i<=d_length-1;i++){
						d_data +='<option value="'+uom_id[i]+'">'+uom_name[i]+'</option>';
						
					}
					//$(".uom_id").removeAttr("disabled");
					$("#uom_id_"+count).append(d_data);
					$(".page-loader").hide();	
				}
				else{
					$("#grid-loader").hide();
				}
			}							
		});

	
		
}
</script>
</html>
