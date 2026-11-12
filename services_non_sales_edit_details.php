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
 <h4>Edit Service Bill</h4>
 <nav aria-label="breadcrumb">
 <ol class="breadcrumb m-t-0">
 <li class="breadcrumb-item"><a href="services_non_sales_details.php">Services Bills</a></li>
 <li class="breadcrumb-item active" aria-current="page">Edit Service Bill</li>
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
									$sql="SELECT *,a.dc_id,a.dc_no,a.driver_id,a.driver_name,a.vechicle_number,a.driver_type,a.total_amount,a.grand_total_amount,d.customer_id,d.customer_name,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tbl_services_non_dc a 
									inner join tbl_services_non_dc_details b on a.dc_id=b.dc_id 
									left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' and b.delete_status!='0' and d.delete_status!='0' and a.dc_id='".$_GET['id']."'";
									$exec_sql=mysqli_query($conn,$sql);
									$fetch_sql=mysqli_fetch_array($exec_sql);
									$customer_id = $fetch_sql['customer_id'];?>
									
								<div class="form-group row">
 <label for="staticEmail" class="col-sm-5 col-form-label text-left">Select Customer :<a href="javascript:void(0)" id="color_add_but" data-toggle="modal" data-target="#customerModalCenter"><i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a></label>
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




	

								 
 </div>

								
								<div class="col-md-6">
									
									
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Bill No :</label>
											<div class="col-sm-5">
												<input type="text" class="form-control" id="dc_no" name="dc_no" value="<?php echo $fetch_sql['dc_no'];?>">
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right"> Date :</label>
											<div class="col-sm-5">
											<input type="text" id="invoice_date" class="form-control" placeholder="Pick Invoice Date" name="invoice_date" value='<?php echo $fetch_sql['billing_date'];?>'>
												<!--input type="text" name="single-date-picker" class="form-control" id="date1" value="<?php //echo $fetch_sql['billing_date'];?>">
												<input type="hidden" name="order_date" id="order_date" value="<?php //echo $fetch_sql['billing_date'];?>"-->
											</div>
										</div>

										
 


										<div class="form-group row">
											<label class="col-sm-5 col-form-label text-right">Vehicle NO :</label>
											<div class="col-sm-5">
												<?php $cur_veh = !empty($fetch_sql['vechicle_number']) ? $fetch_sql['vechicle_number'] : ($fetch_sql['refrence_name'] ?? ''); ?>
												<input type="text" id="vechicle_number" class="form-control" placeholder="Enter Vehicle NO" name="vechicle_number" value="<?php echo htmlspecialchars($cur_veh); ?>" oninput="var r=document.getElementById('refrence_name');if(r)r.value=this.value;">
												<input type="hidden" id="refrence_name" name="refrence_name" value="<?php echo htmlspecialchars($cur_veh); ?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-5 col-form-label text-right">Remarks :</label>
											<div class="col-sm-5">
												<textarea type="text" id="delivery_address" class="form-control" name="delivery_address" placeholder="Enter Remarks"><?php echo $fetch_sql['delivery_address'];?></textarea>
												
											</div>
										</div>										
									
 
 </div>
 </div>

							
							<datalist id="service_product_list">
								<?php
								$pq = mysqli_query($conn, "SELECT product_id, product_name, sale_price FROM tbl_products WHERE delete_status='NDL' ORDER BY product_name ASC");
								$prod_lookup = [];
								if ($pq) {
									while ($pr = mysqli_fetch_assoc($pq)) {
										$p_name = $pr['product_name'];
										$p_rate = $pr['sale_price'];
										$prod_lookup[$pr['product_id']] = $p_name;
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
							<?php
								$sql="SELECT b.*,a.total_amount,a.grand_total_amount FROM tbl_services_non_dc a 
								inner join tbl_services_non_dc_details b on a.dc_id=b.dc_id 
								left join tbl_customer d on d.customer_id=a.customer_id WHERE a.delete_status!='0' and b.delete_status!='0' and d.delete_status!='0' and b.dc_id='".$_GET['id']."'";
								$exec_sql=mysqli_query($conn,$sql);
								$i=1;
								while($fetch_zql=mysqli_fetch_array($exec_sql)){
									$raw_pid = $fetch_zql['product_id'] ?? '';
									$display_prod_name = $prod_lookup[$raw_pid] ?? $raw_pid;
							?>
								<tr class="trtag" id="trtag<?php echo $i;?>">
								
								
									<td style="padding:5px">
										<textarea rows="4" cols="50" wrap="soft" class="form-control product_id" id="product_id_<?php echo $i;?>" name="product_id[]" placeholder="Enter full service description / passage content..." style="margin:0;width:100%;resize:vertical;min-height:90px;font-size:13px;line-height:1.5;white-space:pre-wrap;word-break:break-word;"><?php echo htmlspecialchars($display_prod_name, ENT_QUOTES); ?></textarea>
									</td>

									<td style="display:none;"><input type="hidden" id="uom_id_<?php echo $i;?>" name="uom_id[]" value="<?php echo (int)($fetch_zql['uom_id'] ?? 0); ?>"></td>

									
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
										<a href="#" class="trtag1" data-value=<?php echo $i;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
									</td>
									
								</tr>
							<?php $i++; } ?>

							<input type="hidden" class="form-control total_data" name="total_data" id="total_data" value="<?php echo $i;?>">

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
 <th colspan="2"><input type="text" class="form-control" id="total_amount" name="total_amount" value="<?php echo $fetch_sql['total_amount'];?>" style="margin:0;"></th>
 </tr>
 
 
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right" style="font-size:16px;color:#5700f0">
 Discount</th>
 <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control discount" id="discount" name="discount" value="<?php echo $fetch_sql['discount'];?>" placeholder="Discount in Rs." style="margin:0;"></th>
 </tr>
 
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right" style="font-size:16px;color:red">
 Grand Total Amount</th>
 <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control grand_total_amount" id="grand_total_amount" name="grand_total_amount" placeholder="Grand Total" style="margin:0;" value="<?php echo $fetch_sql['grand_total_amount'];?>" readonly></th>
 </tr>
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right" style="font-size:16px;color:#0e5f6b">
 Advance Received</th>
 <th colspan="2"><input type="number" min="0" step="0.01" class="form-control" id="advance_amount" name="advance_amount" placeholder="Advance in Rs." style="margin:0;" value="<?php echo htmlspecialchars($fetch_sql['advance_amount'] ?? '0'); ?>"></th>
 </tr>
 
 <tr class="taxdiv" id="taxdiv0">
 <th colspan="3" class="text-right" style="font-size:16px;color:#0e5f6b">
 <label style="margin:0;"><input type="checkbox" id="is_service_bill" name="is_service_bill" value="1" <?php echo !empty($fetch_sql['is_service_bill']) ? 'checked' : ''; ?> style="width:18px;height:18px;vertical-align:middle;"> This is a Service Bill</label></th>
 <th colspan="2"><select class="form-control" id="service_place" name="service_place" style="margin:0;">
 <option value="">-- Service Place --</option>
 <option value="Outdoor" <?php echo (($fetch_sql['service_place'] ?? '')==='Outdoor') ? 'selected' : ''; ?>>Outdoor</option>
 <option value="Workshop" <?php echo (($fetch_sql['service_place'] ?? '')==='Workshop') ? 'selected' : ''; ?>>Workshop</option>
 </select></th>
 </tr>

 </tfoot>


						</table>
						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" class="form-control" id="dc_type" name="dc_type" value="dc">
									<input type="hidden" name="dc_id" id="dc_id" value=<?php echo $_GET['id'];?>>
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
	

	$(document).on('change', '#customer_id', function() {

		var customer_id = $("#customer_id").val();
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
					var customer_details = 'Customer Name : '+ cn + '<br>';
					if (rf != '') {

						customer_details += 'Reference : '+ rf +'<br>';
					}
					if (co != '') {

						customer_details += 'Company Name : '+ co +'<br>';
					}
					if (ad != '') {
						customer_details += 'Address : '+ ad + '<br>';
					}
					
					if (st != '') {
						customer_details += 'State : '+ st + '<br>';
					}
					if (mb != '') {
						customer_details += 'Mobile No : '+ mb + '<br>';
					}
					if (em != '') {
						customer_details += 'Email : '+ em + '<br>';
					}
					if (sc != '') {
						customer_details += 'State Code : '+ sc + '<br>';
					}
					customer_details += 'GST No : '+ gs;
					console.log(customer_details);
					$("#customer_details").html(customer_details);

			},
			error: function(xhr, status, error) {
				console.log(JSON.stringify(xhr, status, error));
			}
		});





	});


$(document).ready(function(){

	//$(window).load(function(){

		var customer_id='<?php echo $customer_id; ?>';
		$.ajax({
				type: "POST",
				url: "phpservices/customer_dropdown.php",
				dataType:'json',
				data: {customer_id:customer_id},
				success: function(result) {
					console.log(result);
					$("#customer_details").show();
					function pick(v){ return Array.isArray(v) ? (v[0] ?? '') : (v ?? ''); }
					var cn = pick(result.customer_name), rf = pick(result.reference_name),
					    co = pick(result.company_name), ad = pick(result.address),
					    st = pick(result.state), mb = pick(result.mblno),
					    em = pick(result.email), sc = pick(result.state_code),
					    gs = pick(result.gst_no);
					var customer_details = 'Customer Name : '+ cn + '<br>';
					if (rf != '') {

						customer_details += 'Reference : '+ rf +'<br>';
					}
					if (co != '') {

						customer_details += 'Company Name : '+ co +'<br>';
					}
					if (ad != '') {
						customer_details += 'Address : '+ ad + '<br>';
					}
					
					if (st != '') {
						customer_details += 'State : '+ st + '<br>';
					}
					if (mb != '') {
						customer_details += 'Mobile No : '+ mb + '<br>';
					}
					if (em != '') {
						customer_details += 'Email : '+ em + '<br>';
					}
					if (sc != '') {
						customer_details += 'State Code : '+ sc + '<br>';
					}
					customer_details += 'GST No : '+ gs;
					console.log(customer_details);
					$("#customer_details").html(customer_details);
			

				},error:function(xhr,status,error){
					console.log(JSON.stringify(xhr,status,error));
				}
			});


	//	});

	$(document).on('change', '#driver_type', function() {

		if( this.value == '1'){
			$("#driver_own").show();
			
			$("#driver_other").hide();

			
			
		}else if( this.value == '2'){
			$("#driver_other").show();
			
			$("#driver_own").hide();
			
			
			
		}
	});

	$('input[name="invoice_date"]').daterangepicker({
 
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
									
									swal("Success!", "Successfully Saved !", "success");
									setTimeout(function(){
										window.location.href='non_sales_edit_details.php?id=<?php echo $_GET['id'];?>';
										
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

	

	

		var ids_string=<?php echo $_GET['id']; ?>;
		$(".page-loader").show();
		$.ajax({
			type: "POST",
			url: "services_non_sales_details_service.php",
			dataType:'json',
			data: {dc_id:ids_string,req:"AUB"},
			success: function(result) {		
						console.log(result)
				
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
				// #customer_id's own change handler independently empties and re-populates
				// #customer_id (see the "change" handler bound to #customer_id
				// above), which races with -- and can wipe out -- the direct population
				// below if both run at the same delay. Trigger the customer change first
				// and set values only after that handler's own ajax calls
				// have had time to finish.
				setTimeout(function(){
					$("#customer_id").val(result.op[0]['customer_id']).trigger('change');

				},300);



					setTimeout(function(){
					},1800);



				setTimeout(function(){
				},1800);

				

				$("#vechicle_no").val(result.op[0]['vechicle_number']);
				$("#vechicle_id").val(result.op[0]['vechicle_id']);

				$("#refrence_name").val(result.op[0]['refrence_name']);
				$("#dc_no").val(result.op[0]['dc_no']);
				
				$("#total_amount").val(result.op[0]['total_amount']);
				$("#grand_total_amount").val(result.op[0]['grand_total_amount']);

				
				setTimeout(function(){
					$("#driver_id").val(result.op[0]['driver_id']);
				},1000);




				

				

				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
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
			else if($.trim($(".product_id:first").val()||'')==''){
				swal("Error!", "Enter Service details !", "warning");
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}
			
			else if($(".qty:first").val()==''){
				swal("Error!", "Enter Quantity !", "warning");
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}
			else if($(".product_rate:first").val()==''){
				swal("Error!", "Enter Rate !", "warning");
				setTimeout(function(){$("#msg").html('')},3000);
				return false;
			}
			else{
				$("#req").val('UPD');
				$("#msg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "services_non_sales_details_service.php",
						dataType:'json',
						data: $("#mainform").serialize(),
						success: function(result) {
							if(result.op==1){
								swal("Success!", "Successfully Updated !", "success");
								setTimeout(function(){
									window.location.href='services_non_sales_details.php';
								},1500);
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
	var count = $("#total_data").val();
	$("#tablemainbind").append('<tr class="trtag" id="trtag'+count+'">' +
		'<td style="padding:5px">' +
			'<textarea rows="4" cols="50" wrap="soft" class="form-control product_id" name="product_id[]" id="product_id_'+count+'" placeholder="Enter full service description / passage content..." style="margin:0;width:100%;resize:vertical;min-height:90px;font-size:13px;line-height:1.5;white-space:pre-wrap;word-break:break-word;"></textarea>' +
		'</td>' +
		'<td style="display:none;"><input type="hidden" name="uom_id[]" id="uom_id_'+count+'" value="0"></td>' +
		'<td style="padding:5px"><input type="number" class="form-control qty" name="qty[]" id="qty_'+count+'" placeholder="Enter Qty" style="margin:0;"></td>' +
		'<td style="padding:5px"><input type="number" class="form-control product_rate" name="product_rate[]" id="product_rate_'+count+'" placeholder="Enter Rate" style="margin:0;"></td>' +
		'<td style="padding:5px"><input type="number" class="form-control rate" name="rate[]" id="rate_'+count+'" placeholder="Enter Amount" style="margin:0;" readonly></td>' +
		'<td style="padding:5px;text-align:center">' +
			'<a href="#" data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a>' +
		'</td>' +
	'</tr>');

	var datacount=parseInt(count)+parseInt(1);
	$("#total_data").val(datacount);
}
</script>
</html>
