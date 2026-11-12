<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php 
include('sessionservices.php');
include('phpservices/connection.php');
?>
<!doctype html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>Jayam Hydraulic Engineering (Services)</title>
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
 <h4>Services - Non-GST</h4>
 
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
										<p style="margin-bottom: 0rem;"><b>GST :</b> <?php echo $admin_fetch_sql['gstno']; ?>
									</div>
								</div>
								
								

								<div class="form-group row">
 <label for="staticEmail" class="col-sm-5 col-form-label text-left">Select Customer : <a href="javascript:void(0)" id="color_add_but" data-toggle="modal" data-target="#customerModalCenter">&nbsp;<i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a></label>
 <div class="col-md-5">
										<select class="form-control js-example-basic-single select2-hidden-accessible" id="customer_id" name="customer_id" >
										
									
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-5 ">
											
									</div>
									<div class="col-md-5" id="customer_details" style="display:none;margin-bottom:5px;">								
										
									</div>

								</div>

								<div id="customer_details1" style="display:none;">

									<!--div class="form-group row">
										
										<label class="col-sm-5 col-form-label">Customer Name :</label>
										<div class="col-md-5">
											<input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Customer Name">
										</div>
										
									</div-->
										<div class="col-md-5">
											<input type="hidden" class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name">
										</div>

										
										<div class="col-md-5">
											<input type="hidden" class="form-control" id="mblno" name="mblno" placeholder="Enter Mobile Number">
										</div>

										
										<div class="col-md-5">
											<input type="hidden" class="form-control" id="email" name="email" placeholder="Enter Email Id">
										</div>

										
										<div class="col-md-5">
											<textarea style="visibility: hidden;" class="form-control" id="address" name="address" placeholder="Enter Address"></textarea>
										</div>

										
										<div class="col-md-5">
											<input type="hidden" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number">
										</div>

										
										<div class="col-md-5">
											<input type="hidden" class="form-control" id="state" name="state" placeholder="Enter state">
										</div>

										
										<div class="col-md-5">
											<input type="hidden" class="form-control" id="state_code" name="state_code" placeholder="Enter state code">
										</div>
								</div>



								
	 
 
 
 </div>
													


								<div class="col-md-6">
									
									

										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Bill No :</label>
											<div class="col-sm-5">
												<?php
												
												$sql = "select * from tbl_services_non_dc";
												$exec_sql = mysqli_query($conn, $sql);
												$fetch_sql = mysqli_fetch_array($exec_sql);
												$rows_sql = mysqli_num_rows($exec_sql);
												if ($rows_sql) { $firstPart = 'SVC-00' . ($rows_sql + 1); } else { $firstPart = 'SVC-001'; }
												?>
												<input type="text" class="form-control" id="dc_no" name="dc_no" value="<?php echo $firstPart; ?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Date :</label>
											<div class="col-sm-5">
												<input type="text" id="order_date" class="form-control" placeholder="Pick Order Date" name="order_date" value='<?php echo date('d/m/Y h:i:s a'); ?>'>
												<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
											</div>
										</div>
																				

										

										


										<div class="form-group row">
											<label class="col-sm-5 col-form-label text-right">Vehicle NO :</label>
											<div class="col-sm-5">
												<input type="text" id="vechicle_number" class="form-control" placeholder="Enter Vehicle NO" name="vechicle_number" oninput="var r=document.getElementById('refrence_name');if(r)r.value=this.value;">
												<input type="hidden" id="refrence_name" name="refrence_name" value="">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-5 col-form-label text-right">Remarks :</label>
											<div class="col-sm-5">
												<textarea type="text" id="delivery_address" class="form-control" name="delivery_address" placeholder="Enter Remarks"></textarea>
												
											</div>
										</div>										
 
 </div>
 </div>

							
							<datalist id="service_product_list">
								<?php
								$pq = mysqli_query($conn, "SELECT product_id, product_name, sale_price FROM tbl_products WHERE delete_status='NDL' ORDER BY product_name ASC");
								$prod_rate_map = [];
								if ($pq) {
									while ($pr = mysqli_fetch_assoc($pq)) {
										$p_name = $pr['product_name'];
										$p_rate = $pr['sale_price'];
										$prod_rate_map[$p_name] = $p_rate;
										echo '<option value="' . htmlspecialchars($p_name, ENT_QUOTES) . '" data-rate="' . htmlspecialchars($p_rate, ENT_QUOTES) . '">';
									}
								}
								?>
							</datalist>

							<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
							<thead>
								<tr>
									<th style="width: 50%">Service Description</th>
									<th style="display:none;">UOM</th>								
									<th style="width: 12%">Quantity</th>
									<th style="width: 14%">Rate</th>
									<th style="width: 16%">Amount</th>
									<th style="width: 8%">Action</th>
								</tr>
							</thead>
							<tbody id="tablemainbind">
								<tr class="trtag" id="trtag0">
								
									<td style="padding:5px">
										<textarea rows="4" cols="50" wrap="soft" class="form-control product_id" id="product_id_0" name="product_id[]" placeholder="Enter full service description / passage content..." style="margin:0;width:100%;resize:vertical;min-height:90px;font-size:13px;line-height:1.5;white-space:pre-wrap;word-break:break-word;"></textarea>
									</td>

									<td style="display:none;"><input type="hidden" name="uom_id[]" id="uom_id_0" value="0"></td>
									
									
									<td style="padding:5px">
										<input type="number" class="form-control qty" name="qty[]" id="qty_0" placeholder="Enter Qty" style="margin:0;">
									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control product_rate" name="product_rate[]" id="product_rate_0" placeholder="Enter Rate" style="margin:0;">

									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control rate" name="rate[]" id="rate_0" placeholder="Enter Amount" style="margin:0;" readonly>

									</td>
									<td style="padding:5px;text-align:center">
										<a href="#" class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
									</td>
								</tr>
							</tbody>
							<tfoot id="taxbind1">
																<tr class="taxdiv" id="taxdiv0">
									<th colspan="4" style="border:none"></th>										
									<th style="border:none; text-align:center;">
										<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
									</th>
								
								</tr>
							
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right">Total</th>
 <th colspan="2"><input type="text" class="form-control" id="total_amount" name="total_amount" placeholder="Enter Total" style="margin:0;" value=""></th>
 </tr>
								

								
								<!--tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right"></th>
 <th colspan="2" class="text-left" >
 Print Cost : <input type="number" class="form-control print_cost" id="print_cost" name="print_cost" placeholder="Print cost" style="margin:0;">
 </th>
									<th class="text-left">
 Packing Cost : <input type="number" class="form-control packing_cost" id="packing_cost" name="packing_cost" placeholder="Packing Cost" style="margin:0;">
 </th>
 <th colspan="2">Advance Amount: <input type="text" class="form-control" id="advance_amount" name="advance_amount" placeholder="Advance Amount" style="margin:0;"></th>
 </tr-->
 
 <!--tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right"></th>
 <th colspan="2" class="text-left" style="color:green">
 CGST In (%) : <input type="number" class="form-control cgst" id="cgst" name="cgst" placeholder="CGST" style="margin:0;" value="9" >
 </th>
									<th class="text-left" style="color:green">
 SGST In (%) : <input type="number" class="form-control sgst" id="sgst" name="sgst" placeholder="SGST" style="margin:0;" value="9" >
 </th>
 <th colspan="2">GST Total: <input type="text" class="form-control" id="gst_total_amount" name="gst_total_amount" placeholder="GST Total" style="margin:0;" value="" readonly></th>
 </tr-->
 
 <!--tr class="taxdiv" id="taxdiv0" style="display: none">
 <th colspan="3" class="text-right" style="font-size:16px;color:#5700f0">
 Discount</th>
 <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control discount" id="discount" name="discount" placeholder="Discount in Rs." style="margin:0;"></th>
 </tr-->
 
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right" style="font-size:16px;color:#5700f0">
 Discount</th>
 <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control discount" id="discount" name="discount" placeholder="Discount in Rs." style="margin:0;" value="0"></th>
 </tr>

 <tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right" style="font-size:16px;color:red">
 Grand Total Amount</th>
 <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control grand_total_amount" id="grand_total_amount" name="grand_total_amount" placeholder="Grand Total" style="margin:0;" value="" readonly></th>
 </tr>
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right" style="font-size:16px;color:#0e5f6b">
 Advance Received</th>
 <th colspan="2"><input type="number" min="0" step="0.01" class="form-control" id="advance_amount" name="advance_amount" placeholder="Advance in Rs." style="margin:0;" value="0"></th>
 </tr>
 
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right" style="font-size:16px;color:#0e5f6b">Service Place :</th>
 <th colspan="2"><input type="hidden" name="is_service_bill" value="1"><select class="form-control" id="service_place" name="service_place" style="margin:0;"><option value="Workshop" selected>Workshop</option><option value="Outdoor">Outdoor</option></select></th>
 </tr>

 </tfoot>


						</table>
						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-top:32px;">Save</button>									
									<button type="reset" name="resetbut" id="resetbut" class="btn btn-danger" style="margin-top:32px;">Reset</button>
								</div>
							</div>
							<div class="col-md-2">
							<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						</div>
						
 </form>
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


	$('input[name="order_date"]').daterangepicker({
 
	 singleDatePicker: true,
	 showDropdowns: true,
	 locale: {
		 format: 'DD/MM/YYYY'
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

	

	$('#mainform').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) { 
			e.preventDefault();
			return false;
		}
	});


	

	$("#customer_submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#customer_mainform #m_customer_name").val()==''){
				swal("Error!", " Enter customer Name !", "warning");
				return false;
			}
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
	

	

	$("#resetbut").click(function(){

		setTimeout(function(){
			window.location.href='non_sales_add_details.php';
			
		},500);


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
			if(!customer_id){
				$("#customer_details").hide().html('');
				var _d1=$("#customer_details1"); if(_d1.length){_d1.hide();}
				$("#mainform #company_name").val('');$("#mainform #mblno").val('');$("#mainform #email").val('');
				$("#mainform #address").val('');$("#mainform #gst_no").val('');$("#mainform #state").val('');$("#mainform #state_code").val('');
				return;
			}
			$.ajax({
				type: "POST",
				url: "phpservices/customer_dropdown.php",
				dataType: 'json',
				data: {
					customer_id: customer_id
				},
				success: function(result) {
					console.log(result);
					$("#customer_details1").show();
					$("#customer_details").show();
					var customer_details = '';
					function pick(v){ return Array.isArray(v) ? (v[0] ?? '') : (v ?? ''); }
					var cn = pick(result.customer_name), rf = pick(result.reference_name),
					    co = pick(result.company_name), ad = pick(result.address),
					    st = pick(result.state), mb = pick(result.mblno),
					    em = pick(result.email), sc = pick(result.state_code),
					    gs = pick(result.gst_no);
					if (cn != '') {

						customer_details += cn +'<br>';
					}
					if (rf != '') {
						customer_details += rf +'<br>';
					}
					if (co != '') {

						customer_details += co +'<br>';
						$("#mainform #company_name").val(co);
					}
					if (ad != '') {
						customer_details += ad + '<br>';
						$("#mainform #address").val(ad);
					}
					
					if (st != '') {
						customer_details += st + '<br>';
						$("#mainform #state").val(st);
					}
					if (mb != '') {
						customer_details += mb + '<br>';
						$("#mainform #mblno").val(mb);
					}
					if (em != '') {
						customer_details += em + '<br>';
						$("#mainform #email").val(em);
					}
					if (sc != '') {
						customer_details += sc + '<br>';
						$("#mainform #state_code").val(sc);
					}
					if (gs != '') {
						customer_details += gs + '<br>';
						$("#mainform #gst_no").val(gs);
					}
					
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
			url: "uom_dropdown.php",
			success: function(result) {
				var uom_id=result.uom_id;
				var uom_name=result.uom_name;
				var d_length=result.uom_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+uom_id[i]+'">'+uom_name[i]+'</option>';
					
				}
				$(".uom_id").removeAttr("disabled");
				$(".uom_id").append(d_data);
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



		$(document).on('input change', '.product_id', function() {	
			var id = this.id;
			var val = $(this).val();
			var splitid = id.split('_');
			var index = splitid[2];
			if(index === undefined || index === ''){ return; }
			
			var opt = $('#service_product_list option').filter(function(){
				return $(this).val().toLowerCase() === (val || '').trim().toLowerCase();
			});
			if(opt.length && opt.attr('data-rate')){
				var pr = parseFloat(opt.attr('data-rate')) || 0;
				if(pr > 0){
					$("#product_rate_"+index).val(pr);
					var q = parseFloat($("#qty_"+index).val() || 0);
					if(q <= 0){
						$("#qty_"+index).val(1);
						q = 1;
					}
					$("#rate_"+index).val((pr * q).toFixed(2));
					get_total_amount();
				}
			}
		});

		$(document).on('input keyup change', '.qty, .product_rate', function() {
			var $tr = $(this).closest('tr');
			var qty = parseFloat($tr.find('.qty').val()) || 0;
			var rate = parseFloat($tr.find('.product_rate').val()) || 0;
			var amt = qty * rate;
			$tr.find('.rate').val(amt > 0 ? amt.toFixed(2) : '');
			get_total_amount();
		});

		$(document).on('input keyup change', '#discount', function() {
			get_total_amount();
		});

		function get_total_amount() {
			var total_amount = 0;
			$(".rate").each(function() {
				var v = parseFloat($(this).val()) || 0;
				total_amount += v;
			});
			$("#total_amount").val(total_amount.toFixed(2));
			var discount = parseFloat($("#discount").val()) || 0;
			var grand_total = total_amount - discount;
			if (grand_total < 0) grand_total = 0;
			$("#grand_total_amount").val(grand_total.toFixed(2));
		}
		function totcalc() { get_total_amount(); }

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
			else if($.trim($("#product_id_0").val())==''){
				swal("Error!", "Enter Service details !", "warning");
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
			else if(parseFloat($("#advance_amount").val()||0) > parseFloat($("#grand_total_amount").val()||0)){
				swal("Error!", "Advance cannot exceed Grand Total !", "warning");
				return false;
			}
			else if($("#service_place").val()==''){
				swal("Error!", "Select Service Place (Outdoor / Workshop) !", "warning");
				return false;
			}
			else{
				$("#req").val('ADDINS');
				$("#msg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "services_non_sales_details_service.php",
						dataType:'json',
						data: $("#mainform").serialize(),
						success: function(result) {
							if(result.op==1){
								swal("Success!", "Successfully Saved !", "success");
								setTimeout(function(){
									window.location.href='services_non_sales_details.php';
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
	$("#tablemainbind").append('<tr class="trtag" id="trtag'+count+'">' +
		'<td style="padding:5px">' +
			'<textarea rows="4" cols="50" wrap="soft" class="form-control product_id" name="product_id[]" id="product_id_'+count+'" placeholder="Enter full service description / passage content..." style="margin:0;width:100%;resize:vertical;min-height:90px;font-size:13px;line-height:1.5;white-space:pre-wrap;word-break:break-word;"></textarea>' +
		'</td>' +
		'<td style="display:none;"><input type="hidden" name="uom_id[]" id="uom_id_'+count+'" value="0"></td>' +
		'<td style="padding:5px"><input type="number" class="form-control qty" name="qty[]" id="qty_'+count+'" placeholder="Enter Qty" style="margin:0;"></td>' +
		'<td style="padding:5px"><input type="number" class="form-control product_rate" name="product_rate[]" id="product_rate_'+count+'" placeholder="Enter Rate" style="margin:0;"></td>' +
		'<td style="padding:5px"><input type="number" class="form-control rate" name="rate[]" id="rate_'+count+'" placeholder="Enter Amount" style="margin:0;" readonly></td>' +
		'<td style="padding:5px;text-align:center">' +
			'<a href="#" data-value="'+count+'" class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a>' +
		'</td>' +
	'</tr>');
}
</script>
</html>
