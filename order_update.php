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
        <div class="page-header d-md-flex justify-content-between align-items-center alert alert-danger  alert-with-border alert-dismissible">
            <h4>Order Entry Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#" >Master</a></li>
                    <li class="breadcrumb-item active" aria-current="page" >Order Entry Details</li>
                </ol>
            </nav>
        </div>
    </div>

	<?php
		$sql="SELECT * FROM tbl_order   WHERE  delete_status!='0'and order_id='".$_GET['id']."'";
		$exec_sql=mysqli_query($conn,$sql);
		$fetch_sql=mysqli_fetch_array($exec_sql);
		$customer_id = $fetch_sql['customer_id'];
	?>

	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">

							<div class="col-md-6">

								
								<div class="form-group row">
                                    <label for="staticEmail" class="col-sm-5 col-form-label text-left">Select Customer : <a href="javascript:void(0)" id="color_add_but" data-toggle="modal" data-target="#customerModalCenter">&nbsp;<i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a></label>
                                    <div class="col-md-5">
										<select  class="form-control" id="customer_id" name="customer_id" >
										
									
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
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Order No :</label>
											<div class="col-sm-5">
												<?php
												
												$sql = "select * from tbl_order where delete_status='NDL'";
												$exec_sql = mysqli_query($conn, $sql);
												$fetch_sql = mysqli_fetch_array($exec_sql);
												$rows_sql = mysqli_num_rows($exec_sql);
												if ($rows_sql) {
													$firstPart ='00'.($rows_sql + 1);
												} else {
													$firstPart ='001';
												}
												?>
												<input type="text" class="form-control" id="order_no" name="order_no" value="<?php echo $firstPart; ?>" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Order  Date :</label>
											<div class="col-sm-5">
												<input type="text" id="order_date" class="form-control" placeholder="Date" name="order_date" >
												<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
											</div>
										</div>	
										<div class="form-group row">
											<label for="staticEmail" class="col-sm-5 col-form-label text-right">Delivery  Date :</label>
											<div class="col-sm-5">
												<input type="text" id="delivery_date" class="form-control" placeholder="Date" name="delivery_date" >
												<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
											</div>
										</div>									
                                    
                                </div>

								<div class="col-md-12">

								<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
									<thead>
										<tr>
											<th style="width: 15%">Product Name</th>
											<th style="width: 15%">UOM</th>	
											<th style="width: 15%">Qty</th>									
											
											<th style="width: 5%">Action</th>
										</tr>
									</thead>
									<tbody id="tablemainbind">
									<?php
										$sql="SELECT b.* FROM tbl_order  a 
										inner join tbl_order_details b on a.order_id=b.order_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and b.order_id='".$_GET['id']."'";
										$exec_sql=mysqli_query($conn,$sql);
										$i=0;
										while($fetch_zql=mysqli_fetch_array($exec_sql)){
									?>

										<tr class="trtag" id="trtag<?php echo $i+1;?>">
										
											<td style="padding:5px">
												
												<select class="form-control product_id" id="product_id_<?php echo $i;?>" name="product_id[]">
													<option value="">Select product</option>
													<?php
														$sql_product="select * from tbl_products where delete_status='NDL'";
														$exec_sql_product=mysqli_query($conn,$sql_product); 
														while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
														<option value="<?php  echo $fetch_sql_product['product_id'] ?>"<?php if(($fetch_sql_product['product_id']) ==(($fetch_zql['product_id']))) echo "selected" ?>><?php echo $fetch_sql_product['product_name'] ?></option>
														<?php }  ?>

												</select>
												
											</td>
											<td style="padding:5px">
												
												<select class="form-control" id="uom_id_<?php echo $i;?>" name="uom_id[]">
													<option value="">Select uom</option>
													<?php
														$sql_uom="select * from tbl_uom where delete_status='NDL'";
														$exec_sql_uom=mysqli_query($conn,$sql_uom); 
														while($fetch_sql_uom=mysqli_fetch_array($exec_sql_uom)){?>
														<option value="<?php  echo $fetch_sql_uom['uom_id'] ?>"<?php if(($fetch_sql_uom['uom_id']) ==(($fetch_zql['uom_id']))) echo "selected" ?>><?php echo $fetch_sql_uom['uom_name'] ?></option>
														<?php }  ?>

												</select>
												
											</td>
											<td style="padding:5px">
												
												<input type="text" id="qty_<?php echo $i;?>"  name="qty[]" class="form-control qty" placeholder="Qty " value="<?php echo $fetch_zql['qty'];?>" />
																						
											</td>									
											
											
											<td style="padding:5px;text-align:center">
												<a href="#" class="trtag1" data-value=<?php echo $i+1;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
											</td>
										</tr>
										<?php $i++; } ?>
									</tbody>
									<tfoot id="taxbind1">
																				<tr class="taxdiv" id="taxdiv0">
											<th colspan="3" style="border:none"></th>										
											<th style="border:none; text-align:center;">
												<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
											</th>
										
										</tr>
									
										

									</tfoot>


								</table>

								</div>

								

							
							
							
						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" name="order_id" id="order_id" value=<?php echo $_GET['id'];?>>
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




</div>



</div>

<!-- end::main content -->

<?php include("footer.php") ?>


<input type="hidden" name="modulenamebox" id="modulenamebox" value="13">
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

	//$(window).load(function(){

		var customer_id='<?php echo $customer_id;  ?>';
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
					var customer_details = '';
					if (cn != '') { customer_details += cn + '<br>'; }
					if (rf != '') { customer_details += rf + '<br>'; }
					if (co != '') {

						customer_details += co +'<br>';
					}
					if (ad != '') {
						customer_details += ad + '<br>';
					}
					
					if (st != '') {
						customer_details += st + '<br>';
					}
					if (mb != '') {
						customer_details += mb + '<br>';
					}
					if (em != '') {
						customer_details += em + '<br>';
					}
					if (sc != '') {
						customer_details += sc + '<br>';
					}
					if (gs != '') { customer_details += gs + '<br>'; }
							console.log(customer_details);
							$("#customer_details").html(customer_details);
					

						},error:function(xhr,status,error){
							console.log(JSON.stringify(xhr,status,error));
						}
					});


	//	});


	$('input[name="order_date"]').daterangepicker({
      
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});

	$('input[name="delivery_date"]').daterangepicker({
      
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
		if(!customer_id){ $("#customer_details").hide().html(''); return; }
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
				var customer_details = result.customer_name + '<br>';
				if (result.company_name != '') {

					customer_details += result.company_name +'<br>';
				}
				if (result.address != '') {
					customer_details += result.address + '<br>';
				}
				
				if (result.state != '') {
					customer_details += result.state + '<br>';
				}
				if (result.mblno != '') {
					customer_details += result.mblno + '<br>';
				}
				customer_details += result.gst_no;
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

	

		


	$("#customer_submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#customer_mainform #m_customer_name").val()==''){
				swal("Error!", " Enter customer Name !", "warning");
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
	
	
	$(document).on('change', '.product_id', function() {	
			var id = this.id;
			var product_id=$("#"+id).val();
			var splitid = id.split('_');
			var index = splitid[2];
			$("#product_rate_"+index).empty();	
			
			$.ajax({
				type: "POST",
				url: "get_product_rate.php",
				dataType:'json',
				data: {product_id:product_id},
				success: function(result) {
					if(result.product_rate){
						var product_rate=result.product_rate[0];
							

						$("#product_rate_"+index).val(product_rate);
						setTimeout(function(){
							$("#uom_id_"+index).val(result.uom_id);
							
						},1000);
						
						
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






	

	$("#submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		if($("#customer_id").val()==''){
			$("#msg").css("color","red").html('* Select customer name');
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			$("#req").val('UPD');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "order_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='order_details.php';
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

	
		var ids_string=<?php echo $_GET['id']; ?>;
		$(".page-loader").show();
		$.ajax({
			type: "POST",
			url: "order_service.php",
			dataType:'json',
			data: {order_id:ids_string,req:"AUB"},
			success: function(result) {		
						
				
				setTimeout(function(){
					$("#customer_id").val(result.op[0]['customer_id']);
				},1000);

				setTimeout(function(){
				},1000);


				setTimeout(function(){
				},1000);
				$("#order_no").val(result.op[0]['order_no']);
				$("#delivery_date").val(result.op[0]['delivery_date']);
				$("#order_date").val(result.op[0]['order_date']);
				
				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});

	





	
	
});



function qualaddfunc(){
		var count = document.getElementsByClassName("trtag").length;
		$("#tablemainbind").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control product_id" name="product_id[]" id="product_id_'+count+'"></select></td><td style="padding:5px"> 	<select class="form-control  uom_id" name="uom_id[]" id="uom_id_'+count+'"></select>	</td><td style="padding:5px"><input type="text" id="qty_'+count+'" name="qty[]" placeholder="Qty " class="form-control qty" /></td> 				<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');
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