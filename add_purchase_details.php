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
            <h4>Purchase Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">SM CUBE</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase Details</li>
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
										<p style="margin-bottom: 0rem;"><b>GST :</b> <?php echo $admin_fetch_sql['gstno']; ?>
									</div>
								</div> 
								<div class="form-group row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label text-left">Supplier Detail :<!--a href="javascript:void(0)" id="color_add_but" data-toggle="modal" data-target="#customerModalCenter"><i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a--></label>
                                    <div class="col-md-5">
										<select  class="form-control" id="supplier_id" name="supplier_id" >
										
									
										</select>
									</div>
								</div> 
								                          
                                    
                                    
                            </div>

													


								<div class="col-md-6">
									<div class="form-group row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label text-right">Order Details :</label>
                                        <div class="col-sm-5">
											<textarea  class="form-control" id="order_detail" name="order_detail"></textarea>
                                            
                                        </div>
                                    </div>
									<div class="form-group row">
                                        <label for="staticEmail" class="col-sm-5 col-form-label text-right">Billing Type :</label>
                                        <div class="col-sm-5">
										<input type="hidden" class="form-control" id="booking_type" name="booking_type" value="Purchase">
										<select  class="form-control" id="billing_type" name="billing_type" >
											<option value='0'>-- Select --</option>
											<option value='1'>Pro Forma</option>
											<option value='2'>Invoice</option>											
											<option value='3'>Debit Note</option>
											<option value='4'>Credit Note</option>
									
										</select>
                                            <!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
                                        </div>
                                    </div>
									<div id='proforma' style='display:none;'>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Pro Forma No :</label>
											<div class="col-sm-5">
												<?php
												
												$sql = "select * from tbl_booking where billing_type='1' and booking_type='Purchase' ";
												$exec_sql = mysqli_query($conn, $sql);
												$fetch_sql = mysqli_fetch_array($exec_sql);
												$rows_sql = mysqli_num_rows($exec_sql);
												if ($rows_sql) {
													$firstPart ='00'.($rows_sql + 1);
												} else {
													$firstPart ='001';
												}
												?>
												<input type="text" class="form-control" id="proforma_no" name="proforma_no" value="<?php echo $firstPart; ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Pro Forma Date :</label>
											<div class="col-sm-5">
												<input type="date" id="proforma_date" class="form-control" placeholder="Pick Proforma Date" name="proforma_date" value='<?php echo date('m/d/Y h:i:s a'); ?>'>
												<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
											</div>
										</div>

									</div>

									<div id='invoice' style='display:none;'>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Invoice No :</label>
											<div class="col-sm-5">
												<?php
												
												$invoice_sql = "select * from tbl_booking where billing_type='2'  and booking_type='Purchase'";
												$invoice_exec_sql = mysqli_query($conn, $invoice_sql);
												$invoice_fetch_sql = mysqli_fetch_array($invoice_exec_sql);
												$invoice_rows_sql = mysqli_num_rows($invoice_exec_sql);
												if($invoice_rows_sql) {
													$firstPart ='00'.($invoice_rows_sql + 1);
												} else {
													$firstPart ='001';
												}
												?>
												<input type="text" class="form-control" id="invoice_no" name="invoice_no" value="<?php echo $firstPart; ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Invoice Date :</label>
											<div class="col-sm-5">
												<input type="date" id="invoice_date" class="form-control" placeholder="Pick Invoice Date" name="invoice_date" value='<?php echo date('m/d/Y h:i:s a'); ?>'>
												<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
											</div>
										</div>

									</div>

									<div id='debitnote' style='display:none;'>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Debit Note No :</label>
											<div class="col-sm-5">
												<?php
												
												$sql = "select * from tbl_booking where billing_type='3' and booking_type='Purchase'";
												$exec_sql = mysqli_query($conn, $sql);
												$fetch_sql = mysqli_fetch_array($exec_sql);
												$rows_sql = mysqli_num_rows($exec_sql);
												if ($rows_sql) {
													$firstPart ='00'.($rows_sql + 1);
												} else {
													$firstPart ='001';
												}
												?>
												<input type="text" class="form-control" id="debit_no" name="debit_no" value="<?php echo $firstPart; ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Debit Note Date :</label>
											<div class="col-sm-5">
												<input type="date" id="debit_date" class="form-control" placeholder="Pick Debit Date" name="debit_date" value='<?php echo date('m/d/Y h:i:s a'); ?>'>
												<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
											</div>
										</div>

									</div>

									<div id='creditnote' style='display:none;'>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Credit Note No :</label>
											<div class="col-sm-5">
												<?php
												
												$sql = "select * from tbl_booking where billing_type='4' and booking_type='Purchase'";
												$exec_sql = mysqli_query($conn, $sql);
												$fetch_sql = mysqli_fetch_array($exec_sql);
												$rows_sql = mysqli_num_rows($exec_sql);
												if ($rows_sql) {
													$firstPart = $fetch_gql['credit_no'] . '00'.($rows_sql + 1);
												} else {
													$firstPart = $fetch_gql['invoice_no'] . '001';
												}
												?>
												<input type="text" class="form-control" id="credit_no" name="credit_no" value="<?php echo $firstPart; ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Credit Note Date :</label>
											<div class="col-sm-5">
												<input type="date" id="credit_date" class="form-control" placeholder="Pick Credit Date" name="credit_date" value='<?php echo date('m/d/Y h:i:s a'); ?>'>
												<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
											</div>
										</div>

									</div>                                    
									
                                    
                                </div>

							
							
							<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
							<thead>
								<tr>
									<th style="width: 20%">Item</th>
									<th style="width: 10%">Size</th>
									<th style="width: 10%">Composition</th>
									<th style="width: 10%">HSN Code</th>
									<th style="width: 10%">Units</th>
									<th style="width: 10%">Quantity</th>
									<th style="width: 15%">Amount</th>
									<th style="width: 15%">Rate</th>
									<th style="width: 5%">Action</th>
								</tr>
							</thead>
							<tbody id="tablemainbind">
								<tr class="trtag" id="trtag0">
								
									<td style="padding:5px">
										 <select class="form-control product_id" id="product_id_0" name="product_id[]" >
										</select>
									</td>

									<td style="padding:5px">
										<input type="text" class="form-control size" name="size[]" id="size_0"  placeholder="Enter Size" style="margin:0;">
									</td>

									<td style="padding:5px">
										<input type="text" class="form-control composition" name="composition[]" id="composition_0"  placeholder="Enter Composition" style="margin:0;">
									</td>
									
									<td style="padding:5px">
										<input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_0"  placeholder="Enter HSN code" style="margin:0;">
									</td>
									
									<td style="padding:5px">
										 <select class="form-control unit_id" id="unit_id_0" name="unit_id[]">
										</select>
									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control man_day" name="man_day[]" id="man_day_0"  placeholder="Enter Qty" style="margin:0;">
									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control product_rate" name="product_rate[]" id="product_rate_0"  placeholder="Enter Rate" style="margin:0;">

									</td>
									
									<td style="padding:5px">
										<input type="number" class="form-control rate" name="rate[]" id="rate_0"  placeholder="Enter Rate" style="margin:0;" readonly>

									</td>
									<td style="padding:5px;text-align:center">
										<a href="#" class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
									</td>
								</tr>
							</tbody>
							<tfoot id="taxbind1">
								<tr class="taxdiv" id="taxdiv0">
									<th></th>								
									<th></th>
									<th></th>
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
                                    <th colspan="7" class="text-right">Total</th>
                                    <th colspan="2"><input type="text" class="form-control" id="total_amount" name="total_amount" placeholder="Enter Total" style="margin:0;" value=""></th>
                                </tr>
                                            <!--tr class="taxdiv" id="taxdiv0">
											<th colspan="4" class="text-right">SGST</th>
											<th colspan="2">250</th>
										</tr-->
                                <tr class="taxdiv" id="taxdiv0">
                                    <th colspan="4" class="text-right"></th>
                                    <th colspan="2"  class="text-left" style="color:green">
                                                    CGST In (%) : <input type="number" class="form-control cgst" id="cgst" name="cgst" placeholder="CGST" style="margin:0;" value="9" >
                                    </th>
									<th class="text-left" style="color:green">
                                                    SGST In (%) : <input type="number" class="form-control sgst" id="sgst" name="sgst" placeholder="SGST" style="margin:0;" value="9" >
                                    </th>
                                    <th colspan="2">GST Total: <input type="text" class="form-control" id="gst_total_amount" name="gst_total_amount" placeholder="GST Total" style="margin:0;" value="" readonly></th>
                                </tr>
                                            
                                <tr class="taxdiv" id="taxdiv0" style="display: none">
                                    <th colspan="5" class="text-right" style="font-size:16px;color:#5700f0">
                                                    Discount</th>
                                    <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control discount" id="discount" name="discount" placeholder="Discount in Rs." style="margin:0;"></th>
                                </tr>
                                            
                                <tr class="taxdiv" id="taxdiv0">
                                    <th colspan="7" class="text-right" style="font-size:16px;color:red">
                                                    Grand Total Amount</th>
                                    <th colspan="2" style="font-weight: 900;font-size: 20px;"><input type="text" class="form-control grand_total_amount" id="grand_total_amount" name="grand_total_amount" placeholder="Grand Total" style="margin:0;" value="" readonly></th>
                                </tr>

                            </tfoot>


						</table>
						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<button type="submit" name="submit" id="submit" class="btn btn-success">Save</button>									
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
										<input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Customer Name">
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

								
								<div class="col-md-3">
									<span id="cus_msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
								</div>
							</div>
							<div class='row'>
							
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="req" id="customer_req">
										<button type="submit" name="customer_submit" id="customer_submit" class="btn btn-success">Save</button>									
										<button type="reset" name="customer_submit" id="customer_submit" class="btn btn-danger">Reset</button>
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

	


	$("#customer_submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#customer_name").val()==''){
				$("#cus_msg").css("color","red").html('* Enter Customer Name');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else if($("#mblno").val()==''){
				$("#cus_msg").css("color","red").html('* Enter Mobileno');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else if($("#email").val()==''){
				$("#cus_msg").css("color","red").html('* Enter Email');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else if($("#address").val()==''){
				$("#cus_msg").css("color","red").html('* Enter Address');
				setTimeout(function(){$("#cus_msg").html('')},3000);
				return false;
			}else{
				$("#customer_req").val('ADDINS');
				$("#cus_msg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "customer_service.php",
						dataType:'json',
						data: $("#customer_mainform").serialize(),						
						success: function(result) {
							var customer_name = $("#customer_name").val();
							//console.log(customer_name);
							//console.log(result.op);
							if(result.op=='' || result.op==null){
								$("#cus_msg").css("color","red").html('Duplicate customer already exists !');
								setTimeout(function(){$("#cus_msg").html('')},3000);
								return false;
							}else{

								if(result.op==1){
									
									swal("Success!", "Successfully Saved !", "success");
									setTimeout(function(){
										window.location.href='packing_details.php';
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

	$('#detailsgrid').DataTable({
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"booking_details_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data: {booking_type:"Purchase"},
            error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
          }
		 }
        });	
	

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
		url: "phpservices/supplier_dropdown.php",
		success: function(result) {
			var supplier_id=result.supplier_id;
			var supplier_name=result.supplier_name;
			var d_length=result.supplier_id.length;
			var d_data='<option value="">Select Supplier </option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+supplier_id[i]+'">'+supplier_name[i]+'</option>';
			}
			$("#supplier_id").removeAttr("disabled");
			$("#supplier_id").append(d_data);
			$(".page-loader").hide();	
		}							
	});



	$(".product_id").empty();	
		$.ajax({
			type: "POST",
			url: "phpservices/get_product.php",
			success: function(result) {
				if(result.product_id){
					var product_id=result.product_id;
					var product_name=result.product_name;
					
					var d_length=result.product_id.length;
					var d_data='<option value="">Select Product</option>';
					if(result.product_id!="select Product"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option  value="'+product_id[i]+'">'+product_name[i]+'</option>';
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

	$(".unit_id").empty();	
		$.ajax({
			type: "POST",
			url: "phpservices/unit_name_dropdown.php",
			success: function(result) {
				if(result.unit_id){
					var unit_id=result.unit_id;
					var unit_name=result.unit_name;
					
					var d_length=result.unit_id.length;
					var d_data='<option value="">Select Unit</option>';
					if(result.unit_id!="select Unit"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option  value="'+unit_id[i]+'">'+unit_name[i]+'</option>';
						}
					}

					$(".unit_id").append(d_data);
					$("#grid-loader").hide();
				}
				else{
					$("#grid-loader").hide();
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});	
		
		
	$(".color_id").empty();	
		$.ajax({
			type: "POST",
			url: "phpservices/color_name_dropdown.php",
			success: function(result) {
				if(result.color_id){
					var color_id=result.color_id;
					var color_name=result.color_name;
					
					var d_length=result.color_id.length;
					var d_data='<option value="">Select Color</option>';
					if(result.color_id!="select Color"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option  value="'+color_id[i]+'">'+color_name[i]+'</option>';
						}
					}

					$(".color_id").append(d_data);
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
		$("#hsn_code"+index).empty();		
		$.ajax({
			type: "POST",
			url: "phpservices/get_hsncode.php",
			dataType:'json',
			data: {product_id:product_id},
			success: function(result) {
				if(result.hsn_code){
					var hsn_code=result.hsn_code[0];
					var rate=result.rate[0];										
					var size=result.style_name[0];

   					$("#hsn_code_"+index).val(hsn_code);
					$("#rate_"+index).val(rate);
					$("#product_rate_"+index).val(rate);
					$("#size_"+index).val(size);
					$("#grid-loader").hide();
				}
				else{
					$("#grid-loader").hide();
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	});


	

	$(document).on('keyup', '.man_day', function() {
		var id = this.id;
		var product_id=$("#"+id).val();
		var splitid = id.split('_');
		var index = splitid[2];
        var man_day = $("#man_day_"+index).val();
        var product_rate = $("#product_rate_"+index).val();
        
        
            price = product_rate * man_day;
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
        var man_day = $("#man_day_"+index).val();
        
            price = product_rate * man_day;
            discount = price;
        		
		//$("#total_amount").val(price.toFixed(2));
        $("#rate_"+index).val(discount);
    });

	$(document).on('keyup', '.man_day', function() {
		get_total_amount();
    });

	$(document).on('keyup', '.product_rate', function() {
		get_total_amount();
    });
	
	$(document).on('keyup', '.sgst', function() {
		get_total_amount();
    });

	$(document).on('keyup', '.cgst', function() {
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
		
		cgst=total_amount * ($("#cgst").val() / 100);
		sgst=total_amount * ($("#sgst").val() / 100);

		gst_amount = cgst+sgst;
		$("#gst_total_amount").val(gst_amount.toFixed(2));
        $("#total_amount").val(total_amount.toFixed(2));
		grand_total = total_amount+gst_amount;
		$("#grand_total").val(grand_total.toFixed(2));
		
		
		if ($("#discount").val() == '') {
			var discount = 0;
		} else {
			var discount = $("#discount").val();
		}
		var grand_total_amount = grand_total - discount
		$("#grand_total_amount").val(grand_total_amount.toFixed());
	}

	
	$(document).on('change', '#billing_type', function() {

		if( this.value == '0'){
			$("#proforma").hide();
			$("#invoice").hide();
			$("#debitnote").hide();
			$("#creditnote").hide();

		}else if( this.value == '1'){
			$("#proforma").show();
			$("#invoice").hide();
			$("#debitnote").hide();
			$("#creditnote").hide();
		}else if( this.value == '2'){
			$("#proforma").hide();
			$("#invoice").show();
			$("#debitnote").hide();
			$("#creditnote").hide();
		}else if( this.value == '3'){
			$("#proforma").hide();
			$("#invoice").hide();
			$("#debitnote").show();
			$("#creditnote").hide();
		}else if( this.value == '4'){
			$("#proforma").hide();
			$("#invoice").hide();
			$("#debitnote").hide();
			$("#creditnote").show();
		}else if( this.value == '5'){
			$("#proforma").hide();
			$("#invoice").show();
			$("#debitnote").hide();
			$("#creditnote").hide();
		}else if( this.value == '0'){
			$("#proforma").hide();
			$("#invoice").hide();
			$("#debitnote").hide();
			$("#creditnote").hide();

		}else{
			$("#proforma").hide();
			$("#invoice").hide();
			$("#debitnote").hide();
			$("#creditnote").hide();
		}

		//$('#billing_label').text($('option:selected',this).text());
    });

	

	$("#submit").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		if($("#supplier_id").val()==''){
			swal("Error!", "Select Supplier !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#billing_type").val()=='0'){
			swal("Error!", "Select billing type !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#billing_type").val()=='1' && ($("#proforma_date").val()=='' || $("#proforma_no").val()=='') ){
			swal("Error!", "Enter Proforma date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;

		}
		else if($("#billing_type").val()=='2' && ($("#invoice_date").val()=='' || $("#invoice_no").val()=='') ){
			swal("Error!", "Enter Invoice date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;

		}
		else if($("#billing_type").val()=='3' && ($("#debit_date").val()=='' || $("#debit_no").val()=='')){
			swal("Error!", "Enter Debit date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;

		}
		else if($("#billing_type").val()=='4' && ($("#credit_date").val()=='' || $("#credit_no").val()=='')){
			swal("Error!", "Enter Credit date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		
		}
		else if($("#billing_type").val()=='5' && ($("#invoice_date").val()=='' || $("#invoice_no").val()=='') ){
			swal("Error!", "Enter Invoice date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;

		}
		else if($("#product_id_0").val()==''){
			swal("Error!", "Select Item !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#man_day_0").val()==''){
			swal("Error!", "Enter Quantity !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#style_0").val()==''){
			swal("Error!", "Enter Style !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#composition_0").val()==''){
			swal("Error!", "Enter Composition !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else if($("#rate_0").val()==''){
			swal("Error!", "Enter Rate !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			$("#req").val('ADDINS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "booking_details_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='purchase_details.php';
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

	

	$('#defgrid').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"responsive": true,
		"ajax":{
		url :"design_grid.php", // json datasource
		
		type: "post",  // type of method  ,GET/POST/DELETE
		error: function(){
					console.log(JSON.stringify(xhr,status,error));
		}
		}
    });
	$('#sizegrid').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"responsive": true,
		
		"ajax":{
		url :"size_grid.php", // json datasource
		data: {product:'product'},
		type: "post",  // type of method  ,GET/POST/DELETE
		error: function(){
					console.log(JSON.stringify(xhr,status,error));
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
		var delid=$(this).data('value');
		swalConfirm("Do you want to Delete ?", function(){
			$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: {delid:delid,req:"PRODEDEL"},
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
		});
	});
	$(document).on('change', '.department', function() {	
		var id = this.id;
		var department_id=$("#"+id).val();
		var splitid = id.split('_');
		var index = splitid[2];
		$("#sub_department_id_"+index).empty();		
		$.ajax({
			type: "POST",
			url: "phpservices/get_subdepartment.php",
			dataType:'json',
			data: {department_id:department_id},
			success: function(result) {
				if(result.s_id){
					var sid=result.s_id;
					var sname=result.s_name;
					var d_length=result.s_id.length;
					var d_data='<option value="">Select Subwork</option>';
					if(result.s_id!="select sub department"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
						}
					}
					$("#sub_department_id_"+index).append(d_data);
					$("#grid-loader").hide();
				}
				else{
					$("#grid-loader").hide();
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	});

		
		
	

	/******************design details*******************************/
	$("#design_id").empty();
	$.ajax({
		
		type: "POST",
		url: "design_dropdown.php",
		success: function(result) {
		
			var sid=result.s_id;
			var sname=result.s_name;
			var d_length=result.s_id.length;
			var d_data='<option value="">Select Design</option>';
		
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
			}
			$("#design_id").removeAttr("disabled");
			$("#design_id").append(d_data);
			$(".page-loader").hide();	
		}							
	});
	$("#submitwork").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#design").val()==''){
				$("#designmsg").css("color","red").html('* Enter Design');
				setTimeout(function(){$("#designmsg").html('')},3000);
				return false;
			}		
			else{
				$("#designreq").val('ADD_DESIGN');
				console.log($("#req").val('ADD_DESIGN'));
				$("#designmsg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "products_details_service.php",
						dataType:'json',
						data: $("#mainformwork").serialize(),
						success: function(result) {
							//console.log(result.op);
							if(result.op==1){
								$("#designmsg").css("color","green").html("Successfully Saved !");
									setTimeout(function(){$("#designmsg").html('')},1000);
								$('#detailsgrid').DataTable().ajax.reload();
								$('#defgrid').DataTable().ajax.reload();
								$("#design").val('');
								$("#work_design_id").val('');
								$("#design_id").empty();
								$.ajax({
			
									type: "POST",
									url: "design_dropdown.php",
									success: function(result) {
									
										var sid=result.s_id;
										var sname=result.s_name;
										var d_length=result.s_id.length;
										var d_data='<option value="">Select Design</option>';
									
										for(var i=0;i<=d_length-1;i++){
											d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
										}
										$("#design_id").removeAttr("disabled");
										$("#design_id").append(d_data);
										$(".page-loader").hide();	
									}							
								});
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
	$(document).on('click','.designdeleteTriger', function(){
		var delid=$(this).data('value');
			swalConfirm("Do you want to Delete ?", function(){
				$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: {delid:delid,req:"DESIGNDEL"},
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							$("#designmsg").css("color","green").html("Successfully Deleted !");
							$(".sweet-delete").click();
							setTimeout(function(){$('#defgrid').DataTable().ajax.reload()},3000);
							$("#design_id").empty();
							$.ajax({
		
								type: "POST",
								url: "design_dropdown.php",
								success: function(result) {
								
									var sid=result.s_id;
									var sname=result.s_name;
									var d_length=result.s_id.length;
									var d_data='<option value="">Select Design</option>';
								
									for(var i=0;i<=d_length-1;i++){
										d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
									}
									$("#design_id").removeAttr("disabled");
									$("#design_id").append(d_data);
									$(".page-loader").hide();	
								}							
							});
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
			});
	});
	
	$(document).on('click','.designupdateTriger', function(){
		$("#submitwork").hide();
		$("#updatework").show();
		var updid=$(this).data('value');
		$("#upd_cat_id").val(updid);
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
				$.ajax({
						type: "POST",
						url: "products_details_service.php",
						dataType:'json',
						data: {updid:updid,req:"DEDIGN_AUB"},
						success: function(result) {
								$("#design").val(result.op[0]['design']);						
								$("#work_design_id").val(result.op[0]['design_id']);
								$("#design_id").empty();
									$.ajax({
				
										type: "POST",
										url: "design_dropdown.php",
										success: function(result) {
										
											var sid=result.s_id;
											var sname=result.s_name;
											var d_length=result.s_id.length;
											var d_data='<option value="">Select Design</option>';
										
											for(var i=0;i<=d_length-1;i++){
												d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
											}
											$("#design_id").removeAttr("disabled");
											$("#design_id").append(d_data);
											$(".page-loader").hide();	
										}							
									});
							},error:function(xhr,status,error){
								console.log(JSON.stringify(xhr,status,error));
							}
					});
				}
		else{
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});

	$("#updatework").click(function(e){	
		e.preventDefault();
		// console.log("haiii");
		if($("#design").val()==''){
			$("#designmsg").css("color","red").html('* Enter Design');
			setTimeout(function(){$("#designmsg").html('')},3000);
			return false;
		}
		
		else{
			$("#designreq").val('ADD_DESIGN');
			$("#designmsg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: $("#mainformwork").serialize(),
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							$("#designmsg").css("color","green").html("Successfully Updated !");
							setTimeout(function(){$("#designmsg").html('')},1000);
							$(".sweet-update").click();
							$('#defgrid').DataTable().ajax.reload();
							$("#design").val('');
							$("#work_design_id").val('');
							$("#submitwork").show();
							$("#updatework").hide();
							$("#design_id").empty();
							$.ajax({
									type: "POST",
									url: "design_dropdown.php",
									success: function(result) {
										var sid=result.s_id;
										var sname=result.s_name;
										var d_length=result.s_id.length;
										var d_data='<option value="">Select Category</option>';
										for(var i=0;i<=d_length-1;i++){
											d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
										}
										$("#design_id").removeAttr("disabled");
										$("#design_id").append(d_data);
										$(".page-loader").hide();	
									}							
							});
						}
						else{
							alert($("#designmsg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
	});


	/***********************************SIZE*********************************************** */
	$("#submitsize").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#size").val()==''){
				$("#sizemsg").css("color","red").html('* Enter Size');
				setTimeout(function(){$("#sizemsg").html('')},3000);
				return false;
			}		
			else{
				$("#sizereq").val('ADD_SIZE');
				console.log($("#req").val('ADD_SIZE'));
				$("#sizemsg").css("color","green").html("Processing . . .");
				$.ajax({
						type: "POST",
						url: "products_details_service.php",
						dataType:'json',
						data: $("#sizeformwork").serialize(),
						success: function(result) {
							//console.log(result.op);
							if(result.op==1){
								$("#sizemsg").css("color","green").html("Successfully Saved !");
									setTimeout(function(){$("#designmsg").html('')},1000);
								$('#detailsgrid').DataTable().ajax.reload();
								$('#sizegrid').DataTable().ajax.reload();
								$("#size").val('');
								$("#work_size_id").val('');
								$("#size_id").empty();
								$.ajax({
		
										type: "POST",
										url: "phpservices/size_dropdown.php",
										success: function(result) {
											var sid=result.s_id;
											var sname=result.s_name;
											var d_length=result.s_id.length;
											var d_data='<option value="">Select Size </option>';
											for(var i=0;i<=d_length-1;i++){
												d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
												
											}
											$("#size_id").removeAttr("disabled");
											$("#size_id").append(d_data);
											$(".page-loader").hide();	
										}							
								});
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
	$(document).on('click','.sizedeleteTriger', function(){
		var delid=$(this).data('value');
			swalConfirm("Do you want to Delete ?", function(){
				$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: {delid:delid,req:"SIZEDEL"},
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							$("#sizemsg").css("color","green").html("Successfully Deleted !");
							$(".sweet-delete").click();
							setTimeout(function(){$('#sizegrid').DataTable().ajax.reload()},3000);
							$("#size_id").empty();
							$.ajax({
		
									type: "POST",
									url: "phpservices/size_dropdown.php",
									success: function(result) {
										var sid=result.s_id;
										var sname=result.s_name;
										var d_length=result.s_id.length;
										var d_data='<option value="">Select Size </option>';
										for(var i=0;i<=d_length-1;i++){
											d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
											
										}
										$("#size_id").removeAttr("disabled");
										$("#size_id").append(d_data);
										$(".page-loader").hide();	
									}							
							});
						}
						else{
							alert($("#msg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
			});
	});
	
	$(document).on('click','.sizeupdateTriger', function(){
		$("#submitsize").hide();
		$("#updatesize").show();
		var updid=$(this).data('value');
		$("#upd_cat_id").val(updid);
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
				$.ajax({
						type: "POST",
						url: "products_details_service.php",
						dataType:'json',
						data: {updid:updid,req:"SIZE_AUB"},
						success: function(result) {
								$("#size").val(result.op[0]['size']);						
								$("#work_size_id").val(result.op[0]['size_id']);
								$("#size_id").empty();
								$.ajax({
		
										type: "POST",
										url: "phpservices/size_dropdown.php",
										success: function(result) {
											var sid=result.s_id;
											var sname=result.s_name;
											var d_length=result.s_id.length;
											var d_data='<option value="">Select Size </option>';
											for(var i=0;i<=d_length-1;i++){
												d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
												
											}
											$("#size_id").removeAttr("disabled");
											$("#size_id").append(d_data);
											$(".page-loader").hide();	
										}							
								});
											},error:function(xhr,status,error){
								console.log(JSON.stringify(xhr,status,error));
							}
					});
				}
		else{
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});
	$("#updatesize").click(function(e){	
		e.preventDefault();
		// console.log("haiii");
		if($("#size").val()==''){
			$("#sizemsg").css("color","red").html('* Enter Size');
			setTimeout(function(){$("#sizemsg").html('')},3000);
			return false;
		}
		
		else{
			$("#sizereq").val('ADD_SIZE');
			$("#sizemsg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "products_details_service.php",
					dataType:'json',
					data: $("#sizeformwork").serialize(),
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							$("#sizemsg").css("color","green").html("Successfully Updated !");
							setTimeout(function(){$("#sizemsg").html('')},1000);
							$(".sweet-update").click();
							$('#sizegrid').DataTable().ajax.reload();
							$("#size").val('');
							$("#work_size_id").val('');
							$("#submitsize").show();
							$("#updatesize").hide();
							$("#size_id").empty();
							$.ajax({
		
									type: "POST",
									url: "phpservices/size_dropdown.php",
									success: function(result) {
										var sid=result.s_id;
										var sname=result.s_name;
										var d_length=result.s_id.length;
										var d_data='<option value="">Select Size </option>';
										for(var i=0;i<=d_length-1;i++){
											d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
											
										}
										$("#size_id").removeAttr("disabled");
										$("#size_id").append(d_data);
										$(".page-loader").hide();	
									}							
							});
													}
						else{
							alert($("#designmsg").html(result.op));
						}
					},error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
					}
				});
		}
	});
	
	/********************excel file**************************************** */
	$("#productsimportfile").change(function(){
		var fileName = $("#productsimportfile").val();
		var idxDot = fileName.lastIndexOf(".") + 1;
		var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
		if (extFile=="xlsx" || extFile=="xls"){
			$(".page-loader").css('z-index','9999').show();
			var fd=new FormData();
			fd.append('importfile',$('#productsimportfile').prop('files')[0]);
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
							$("#products_import_name").val(result.op2);
						},
						async:false
					});
					},2000);
		}
		else{
			$("#productsimportfile").val('');
			$("#products_import_msg").css("color","red").html('* Upload .xlsx, .xls file type only');
			setTimeout(function(){$("#products_import_msg").html('');},3000);
			return false;
		}
 	});

	$("#productsimportsubmit").click(function(e){
			e.preventDefault();
			var emprights=$("#rightsbox").val();
			if (emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin') {
				if($("#products_import_name").val()==''){
					$("#products_import_msg").css("color","red").html('* Upload Import File');
					setTimeout(function(){$("#products_import_msg").html('')},3000);
					return false;
				}
				else{
					$("#products_import_msg").css("color","green").html("Processing . . .");
					$(".page-loader").show();
					$.ajax({
							type: "POST",
							url: "phpservices/products_details_import.php",
							dataType:'json',
							data: $("#productsimportform").serialize(),
							success: function(result) {
								//console.log(result.op);
								if(result.op==1){
									$("#msg").css("color","green").html("Successfully Saved !");
									setTimeout(function(){
										window.location.href='products_details.php';
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
	$("#tablemainbind").append('<tr class="trtag" id="trtag'+count+'"> 				<td style="padding:5px"> 	<select class="form-control product_id" name="product_id[]" id="product_id_'+count+'"></select>												</td> 			<td style="padding:5px"> 									<input type="text" class="form-control size" name="size[]" id="size_'+count+'" placeholder="Enter size" style="margin:0;">			</td>		<td style="padding:5px"> 									<input type="text" class="form-control composition" name="composition[]" id="composition_'+count+'" placeholder="Enter Size" style="margin:0;">			</td>			<td style="padding:5px"> 									<input type="text" class="form-control hsn_code" name="hsn_code[]" id="hsn_code_'+count+'" placeholder="Enter HSN Code" style="margin:0;">			</td> <td style="padding:5px"> 	<select class="form-control unit_id" name="unit_id[]" id="unit_id_'+count+'"></select>												</td> 	<td style="padding:5px"> 										<input type="number" class="form-control man_day" name="man_day[]" id="man_day_'+count+'" placeholder="Enter Qty" style="margin:0;">			</td>								<td style="padding:5px"><input type="number" class="form-control product_rate" name="product_rate[]" id="product_rate_'+count+'" placeholder="Enter Rate" style="margin:0;">			</td><td style="padding:5px"> 										<input type="number" class="form-control rate" name="rate[]" id="rate_'+count+'" placeholder="Enter Rate" style="margin:0;" readonly>			</td>				<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');
	$("#product_id_"+count).empty();	
		$.ajax({
			type: "POST",
			url: "phpservices/get_product.php",
			success: function(result) {
				if(result.product_id){
					var product_id=result.product_id;
					var product_name=result.product_name;
					
					var d_length=result.product_id.length;
					var d_data='<option value="">Select Product</option>';
					if(result.product_id!="select Product"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option  value="'+product_id[i]+'">'+product_name[i]+'</option>';
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
		$("#unit_id_"+count).empty();	
		$.ajax({
			type: "POST",
			url: "phpservices/unit_name_dropdown.php",
			success: function(result) {
				if(result.unit_id){
					var unit_id=result.unit_id;
					var unit_name=result.unit_name;
					
					var d_length=result.unit_id.length;
					var d_data='<option value="">Select Unit</option>';
					if(result.unit_id!="select Unit"){
						for(var i=0;i<=d_length-1;i++){
							d_data +='<option  value="'+unit_id[i]+'">'+unit_name[i]+'</option>';
						}
					}

					$("#unit_id_"+count).append(d_data);
					$("#grid-loader").hide();
				}
				else{
					$("#grid-loader").hide();
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
}
</script>
</html>