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
            <h4>Receipt Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Receipt</a></li>
                    <li class="breadcrumb-item active" aria-current="page">	Details</li>
                </ol>
            </nav>
        </div>
    </div>

	<form id="mainform" method="POST" action="" enctype="multipart/form-data">

	<div class="row">
        <div class="col-md-4">
			<div class="card">
                <div class="card-body">
								
								
						<?php
							// Legacy product-receipt header query removed: live tbl_sky_receipt has no
							// receipt_no/total_amount/grand_total_amount columns and this page uses
							// $_GET['id'] as customer_id (multi-pay flow). Customer block below loads it safely.
							$fetch_sql = null; ?>
									
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">Customer Detail:</label>
										<div class="col-md-5">
											<?php
												$customer_sql = "select * from tbl_customer where delete_status='NDL' and customer_id='".mysqli_real_escape_string($conn, $_GET['id'])."'";
												$customer_exec_sql = mysqli_query($conn, $customer_sql);
												$customer_fetch_sql = $customer_exec_sql ? mysqli_fetch_array($customer_exec_sql) : null;
											?>
											<p style="margin-bottom: 0rem;"><b><?php echo htmlspecialchars($customer_fetch_sql['customer_name'] ?? ''); ?></b></p>
											<p style="margin-bottom: 0rem;"><?php echo htmlspecialchars($customer_fetch_sql['address'] ?? ''); ?></p>
												

											
										</div>
								</div> 
								   
								<div id='proforma'>
									
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-5 col-form-label text-right">Billing Date :</label>
										<div class="col-sm-6">
											<input type="text" name="single-date-picker" class="form-control" id="date1" value="<?php echo date('d/m/Y'); ?>">
											<input type="hidden" value="<?php echo date('d/m/Y'); ?>" name="billing_date" id="billing_date" >
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-5 col-form-label text-right">Payment Mode :</label>
										<div class="col-sm-6">
											<select  class="form-control js-example-basic-single select2-hidden-accessible" id="payment_mode" name="payment_mode">
												<option value='3'>Cash</option>
												<option value='1'>UPI</option>
												<option value='2'>Card</option>
												<option value='4'>Bank Transfer</option>
												<option value='5'>Cheque</option>
												<option value='6'>Other</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-5 col-form-label text-right">Ref / Txn No :</label>
										<div class="col-sm-6">
											<input type="text" name="ref_no" class="form-control" id="ref_no" placeholder="UPI ref / cheque no.">
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-5 col-form-label text-right">Remarks :</label>
										<div class="col-sm-6">
											<input type="text" name="remarks" class="form-control" id="remarks" placeholder="Remarks">
										</div>
									</div>

									
									<div class="form-group row" id='bank_option'>
										<label for="staticEmail" class="col-sm-5 col-form-label text-right">Bank Name :</label>
										<div class="col-sm-6">
											<select  class="form-control js-example-basic-single select2-hidden-accessible" id="bank_id" name="bank_id" >
												
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-5 col-form-label text-right">Amount :</label>
										<div class="col-sm-6">
											<input type="number" name="pay_amount" class="form-control pay_amount" id="pay_amount" >

											<input type="hidden" name="customer_id" class="form-control customer_id" id="customer_id" value="<?php echo $_GET['id'];?>" >

											
											
										</div>
									</div>

								</div>
								
							<div class="col-md-4 text-center">
								<div class="form-group row">
									<input type="hidden" name="req" id="req">
									<button type="submit" name="submit" id="submit" class="btn btn-success" style="margin-left:100px;">Save</button>									
									
								</div>
							</div>
							<div class="col-md-4">
								<span id="msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
							</div>
						
                    
                
                </div>
            </div>
		</div>

		

		<div class="col-md-8">
			<div class="card">
				<div class="card-body">	
				
				<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
					<thead>
						<tr>
							<th style="width: 5%">Slno</th>
							<th style="width: 15%">	Bill Date</th>
							<th style="width: 10%">Dc No</th>
							<th style="width: 10%">Amount</th>
							<th style="width: 10%">Discount</th>
							<th style="width: 15%">Paid Amount</th>
							<th style="width: 15%">Balance Amount</th>
							<!--th style="width: 15%">Pay Now</th-->	
																
						</tr>
					</thead>
					<tbody id="tablemainbind">
						<?php
							$grand_total_amount=0;
							$pay_amount=0;
							$pay_count=0;
							$discount_total_amount=0;
							$total_amount=0;

							$req_dc_id = isset($_GET['dc_id']) ? (int)$_GET['dc_id'] : 0;
							$cust_id = mysqli_real_escape_string($conn, (string)($_GET['id'] ?? ''));
							$order_by = ($req_dc_id > 0) ? " ORDER BY (a.dc_id = '$req_dc_id') DESC, a.billing_date ASC, a.dc_id ASC " : " ORDER BY a.billing_date ASC, a.dc_id ASC ";

							$sql="SELECT b.rate,a.dc_id,a.dc_no,a.discount,a.total_amount,a.grand_total_amount,date_format(a.create_date,'%d/%m/%Y') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_sky_gst_invoice  a 
							inner join tbl_sky_gst_invoice_details b on a.dc_id=b.dc_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.customer_id='".$cust_id."'   group by b.dc_id" . $order_by;
							$exec_sql=mysqli_query($conn,$sql);
							$i=1;
							while($fetch_zql=mysqli_fetch_array($exec_sql)){


								$gql3 = "SELECT sum(pay_amount) as pay_amount1 FROM tbl_sky_receipt where delete_status='NDL' and customer_id='".$_GET['id']."' and dc_id='".$fetch_zql['dc_id']."'";
								//print_r($gql3);	
								$exec_query3=mysqli_query($conn, $gql3);
								$rows=mysqli_num_rows($exec_query3);
								if($rows>0){
									
									$exec_gql3 = mysqli_fetch_array($exec_query3);
									$pay_count=$exec_gql3['pay_amount1'];
								}else{
									$pay_count=0;
								}

								$total_amount=$total_amount+$fetch_zql['total_amount'];

								// grand_total_amount is stored already net of discount (see
								// sky_gst_invoice add/edit: grand_total_amount = grand_total - discount),
								// so it must not be subtracted again here.
								$grand_total_amount=$grand_total_amount+$fetch_zql['grand_total_amount'];
								$discount_total_amount=$discount_total_amount+$fetch_zql['discount'];
								$pay_amount=$pay_amount+$pay_count;

								$total_balance=$fetch_zql['grand_total_amount']-$pay_count;

								if($total_balance!=0){								

						?>
							<?php $is_target = ($req_dc_id > 0 && (int)$fetch_zql['dc_id'] === $req_dc_id); ?>
							<tr class="trtag <?php echo $is_target ? 'table-warning' : ''; ?>" id="trtag<?php echo $i;?>" <?php echo $is_target ? 'style="background-color:#fef9c3;"' : ''; ?>>
							
								<td style="padding:5px" class="text-center">
									<input type="checkbox" id="dc_<?php echo $i;?>" name="row_selected[<?php echo $i;?>]" value="<?php echo $i;?>" class="dc_checkbox">
								</td>

								<td style="padding:5px">
									<?php echo $fetch_zql['create_date'];?>
								</td>
								
								<td style="padding:5px">
									<b><?php echo $fetch_zql['dc_no'];?></b>
									<?php if($is_target){ echo '<br><span class="badge badge-primary" style="font-size:10px;">Selected Bill</span>'; } ?>
								</td>
								
								<td style="padding:5px">
									<?php echo number_format($fetch_zql['grand_total_amount']+$fetch_zql['discount'], 2, '.', '')?>
								</td>

								<td style="padding:5px">
									
									<input type="number" name="amount_discount[]" class="form-control amount_discount"  value="<?php echo $fetch_zql['discount'];?>" id="amount_discount_<?php echo $i; ?>" >

								</td>
								
								<td style="padding:5px">
									<a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-customer_id='<?php echo $_GET['id'];?>' data-dc_id="<?php echo $fetch_zql['dc_id'];?>" data-dc_no='<?php echo $fetch_zql['dc_no'];?>' data-balance='<?php echo number_format($fetch_zql['grand_total_amount']-$pay_count, 2, '.', '')?>'><button type='button'   class='btn btn-warning' style='padding:4px 5px; 5px; 2px; color:#fff'><?php echo $pay_count;?></button></a>
									
								</td>

								<td style="padding:5px">
									<span id="balance2_<?php echo $i; ?>"><?php echo number_format($fetch_zql['grand_total_amount']-$pay_count, 2, '.', '')?></span>
									
									<input type="hidden" name="row_dc_id[<?php echo $i;?>]" class="form-control dc_id"  value="<?php echo $fetch_zql['dc_id'];?>" id="dc_id_<?php echo $i; ?>" >

									<input type="hidden" name="row_dc_no[<?php echo $i;?>]" class="form-control dc_no"  value="<?php echo $fetch_zql['dc_no'];?>" id="dc_no_<?php echo $i; ?>" >

									<input type="hidden" name="row_balance[<?php echo $i;?>]" class="form-control balance"  value="<?php echo number_format($fetch_zql['grand_total_amount']-$pay_count, 2, '.', '')?>" id="balance_<?php echo $i; ?>" >

									<input type="hidden" name="row_extra[<?php echo $i;?>]" readonly class="form-control extra" id="extra_<?php echo $i; ?>" >

									<input type="hidden" name="row_balance1[<?php echo $i;?>]" class="form-control balance1"   id="balance1_<?php echo $i; ?>" >
									
								</td>
								
							</tr>
						<?php $i++; }else{

						?>
						<tr class="trtag" id="trtag">

							<td style="padding:5px" class="text-center">
								
							</td>

							<td style="padding:5px">
								<?php echo $fetch_zql['create_date'];?>
							</td>
							
							<td style="padding:5px">
								<?php echo $fetch_zql['dc_no'];?>
							</td>
							
							<td style="padding:5px">
								<?php echo number_format($fetch_zql['grand_total_amount']+$fetch_zql['discount'], 2, '.', '')?>
							</td>
							<td style="padding:5px">
								<?php echo !empty($fetch_zql['discount']) ? $fetch_zql['discount'] : 0;?>
							</td>
							
							<td style="padding:5px">
								<a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-customer_id='<?php echo $_GET['id'];?>' data-dc_id=<?php echo $fetch_zql['dc_id']?> data-dc_no='<?php echo $fetch_zql['dc_no'];?>' data-balance='<?php echo number_format($fetch_zql['grand_total_amount']-$pay_count, 2, '.', '')?>'><button type='button'   class='btn btn-warning' style='padding:4px 5px; 5px; 2px; color:#fff'><?php echo $pay_count;?></button></a>
								
							</td>

							<td style="padding:5px">
								<span >0</span>
								
								
								
								
								
							</td>
							
						</tr>
						<?php 
						} } ?>
						</tbody>
						<tfoot id="taxbind1">					
						

							<tr class="taxdiv" id="taxdiv0">
								<th colspan="3" class="text-right" style="font-size:16px;color:red">
												Grand Total Amount</th>
								<th  style="font-size: 18px;"><?php echo $grand_total_amount;?></th>
								<th  style="font-size: 18px;"><?php echo $discount_total_amount;?></th>
								<th  style="font-size: 18px;"><?php echo $pay_amount;?></th>
								<th  style="font-size: 18px;"><span id="grand_total_amount2"><?php echo number_format( $grand_total_amount-$pay_amount, 2, '.', '')?></span>

								<?php //echo $grand_total_amount.'+'.$pay_amount.'+'.$discount_total_amount;?>

									<input type="hidden" name="grand_total_amount" class="form-control grand_total_amount" value="<?php echo number_format( $grand_total_amount-$pay_amount, 2, '.', '')?>"   id="grand_total_amount" >
								</th>

								
							</tr>

						</tfoot>
					</table>
				</form>
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
					<h5 class="modal-title" id="exampleModalCenterTitle" style="color:#000">Receipt details</h5>

					<!--span class="badge badge-info" style="margin-left:400px;">Gayathri</span-->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="color:#000">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="singlePayForm">
					<div class="row" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:12px;margin-bottom:12px;">
						<div class="col-md-12"><h6 style="color:#000;font-weight:700;">Single Pay for this bill</h6></div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Billing Date :</label>
								<input type="text" name="single_billing_date" class="form-control" id="single_billing_date" value="<?php echo date('d/m/Y'); ?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Payment Mode :</label>
								<select class="form-control" id="single_payment_mode" name="single_payment_mode">
									<option value='3'>Cash</option>
									<option value='1'>UPI</option>
									<option value='2'>Card</option>
									<option value='4'>Bank Transfer</option>
									<option value='5'>Cheque</option>
									<option value='6'>Other</option>
								</select>
							</div>
						</div>
						<div class="col-md-4" id="single_bank_wrap">
							<div class="form-group">
								<label>Bank Name :</label>
								<select class="form-control" id="single_bank_id" name="single_bank_id"></select>
							</div>
						</div>
						<div class="col-md-4" id="single_ref_wrap">
							<div class="form-group">
								<label>Ref / Txn No :</label>
								<input type="text" name="single_ref_no" class="form-control" id="single_ref_no" placeholder="UPI ref / cheque no.">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Remarks :</label>
								<input type="text" name="single_remarks" class="form-control" id="single_remarks" placeholder="Remarks">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Amount :</label>
								<input type="number" min="1" step="0.01" name="single_pay_amount" class="form-control" id="single_pay_amount">
								<input type="hidden" id="single_dc_id" name="single_dc_id">
								<input type="hidden" id="single_dc_no" name="single_dc_no">
								<input type="hidden" id="single_customer_id" name="single_customer_id" value="<?php echo $_GET['id']; ?>">
							</div>
						</div>
						<div class="col-md-12 text-right">
							<span id="singlePayMsg" style="font-weight:bold;margin-right:10px;"></span>
							<button type="button" id="singlePaySubmit" class="btn btn-success">Save Single Pay</button>
						</div>
					</div>
					</form>
					<div class="row">
						<div class="col-md-12">
							
							<table id="receiptgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>S.no</th>
										<th>Payment Date</th>
										<th>Bank Name</th>
										<th>Payment Type</th>
										<th>Amount</th>
										<th>Action</th>
										
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



<input type="hidden" name="modulenamebox" id="modulenamebox" value="8">
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


<script>
$(document).ready(function(){
	$(document).on('click', '.trtag', function () {
		$("#trtag"+$(this).data('value')+"").remove();
		return false;
	});	


	function payRefMeta(mode){
		switch(String(mode)){
			case '1': return {ph:'UPI Ref / Txn No', req:true};
			case '2': return {ph:'Card Auth / Slip No', req:true};
			case '4': return {ph:'UTR No', req:true};
			case '5': return {ph:'Cheque No', req:true};
			case '6': return {ph:'Ref (optional)', req:false};
			default: return {ph:'UPI ref / cheque no.', req:false};
		}
	}
	function applyPayMode(mode){
		var meta = payRefMeta(mode);
		if(String(mode) === '3'){
			$("#bank_option").hide(); $("#bank_id").val('');
			if($("#ref_wrap").length){ $("#ref_wrap").hide(); $("#ref_no").val(''); }
			else { $("#ref_no").closest('.form-group.row').hide(); $("#ref_no").val(''); }
		} else {
			$("#bank_option").show();
			if($("#ref_wrap").length){ $("#ref_wrap").show(); }
			else { $("#ref_no").closest('.form-group.row').show(); }
			$("#ref_no").attr('placeholder', meta.ph);
		}
	}
	function payModeValid(mode, bank, ref){
		var m = String(mode);
		if(m === '3' || m === '6') return true;
		if(!bank){ swal("Error!", "Select Bank Name !", "warning"); return false; }
		if(!ref || !String(ref).trim()){
			var lbl = m==='1' ? 'UPI Ref' : m==='2' ? 'Card ref' : m==='4' ? 'UTR No' : 'Cheque No';
			swal("Error!", "Enter "+lbl+" !", "warning"); return false;
		}
		return true;
	}
	$(document).on('change', '#payment_mode', function() {
		applyPayMode(this.value);
	});
	applyPayMode($("#payment_mode").val());


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
			url: "bank_dropdown.php",
			success: function(result) {
				console.log(result);
				var bank_id=result.bank_id;
				var bank_name=result.bank_name;
				var d_length=result.bank_id.length;
				var d_data='';
				for(var i=0;i<=d_length-1;i++){
					d_data +='<option value="'+bank_id[i]+'">'+bank_name[i]+'</option>';
					
				}
				$("#bank_id").removeAttr("disabled");
				$("#bank_id").append(d_data);
				$(".page-loader").hide();	
			}							
		});


	$(document).on('click', '.innerid', function() {

			
		var dc_id = $(this).attr('data-dc_id');	
		$("#single_dc_id").val(dc_id);
		$("#single_dc_no").val($(this).attr('data-dc_no'));
		$("#single_customer_id").val($(this).attr('data-customer_id'));
		$("#single_pay_amount").val($(this).attr('data-balance'));
		$("#singlePayMsg").html('');
		//alert(dc_id);

		$("#receiptgrid").dataTable().fnDestroy();
		$('#receiptgrid').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"language": { "emptyTable": "No payments yet for this bill" },
			"ajax": {
				url: "sky_receipt_details_model_grid.php", // json datasource
				type: "post", // type of method  ,GET/POST/DELETE
				data: {
					dc_id: dc_id,
					customer_id: '<?php echo (int)$_GET['id']; ?>',
				},
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
					$("#singlePayMsg").css("color","red").html("Failed to load pay history. Please re-login and retry.");
				}
			}
		});
	});

	function applySinglePayMode(mode){
		var meta = payRefMeta(mode);
		if(String(mode) === '3'){
			$("#single_bank_wrap").hide(); $("#single_bank_id").val('');
			$("#single_ref_wrap").hide(); $("#single_ref_no").val('');
		} else {
			$("#single_bank_wrap").show(); $("#single_ref_wrap").show();
			$("#single_ref_no").attr('placeholder', meta.ph);
		}
	}
	$(document).on('change', '#single_payment_mode', function() {
		applySinglePayMode(this.value);
	});
	applySinglePayMode($("#single_payment_mode").val());
	$('#exampleModalCenter6').on('shown.bs.modal', function(){ applySinglePayMode($("#single_payment_mode").val()); });
	$('#exampleModalCenter6').on('shown.bs.modal', function(){ applySinglePayMode($("#single_payment_mode").val()); });
	$.ajax({
		type: "POST",
		url: "bank_dropdown.php",
		success: function(result) {
			$("#single_bank_id").empty().append('<option value="">Select Bank</option>');
			if(result && result.bank_id && result.bank_id.length){
				var d_data='';
				for(var i=0;i<result.bank_id.length;i++){
					d_data +='<option value="'+result.bank_id[i]+'">'+result.bank_name[i]+'</option>';
				}
				$("#single_bank_id").append(d_data);
			} else {
				$("#single_bank_id").append('<option value="" disabled>No banks found</option>');
			}
		},
		error: function(){ $("#single_bank_id").empty().append('<option value="">Select Bank</option>'); }
	});
	$(document).on('click', '#singlePaySubmit', function() {
		var amt = parseFloat($("#single_pay_amount").val()||0);
		if(!$("#single_dc_id").val() || !(amt>0)){ swal("Error!", "Select bill and enter valid amount !", "warning"); return false; }
		$("#singlePayMsg").css("color","green").html("Processing . . .");
		applySinglePayMode($("#single_payment_mode").val());
		if(!payModeValid($("#single_payment_mode").val(), $("#single_bank_id").val(), $("#single_ref_no").val())){ $("#singlePayMsg").html(''); return false; }
		$.ajax({
			type: "POST",
			url: "sky_receipt_details_service.php",
			dataType:'json',
			data: {
				req:'ADDINS',
				customer_id: $("#single_customer_id").val(),
				billing_date: $("#single_billing_date").val(),
				payment_mode: $("#single_payment_mode").val(),
				bank_id: $("#single_bank_id").val(),
				ref_no: $("#single_ref_no").val(),
				remarks: $("#single_remarks").val(),
				'dc[]': [$("#single_dc_no").val()],
				'dc_id[]': [$("#single_dc_id").val()],
				'balance[]': [amt],
				'balance1[]': [0],
				'extra[]': [0]
			},
			success: function(result) {
				if(result.op==1){
					swal("Success!", "Single pay saved !", "success");
					setTimeout(function(){ window.location.reload(); },1200);
				} else { $("#singlePayMsg").css("color","red").html("Save failed"); }
			},
			error:function(xhr,status,error){ console.log(JSON.stringify(xhr,status,error)); $("#singlePayMsg").css("color","red").html("Save failed"); }
		});
	});

	$(document).on('click','.receipt_deleteTriger', function(){
		var delid=$(this).data('value');
		var alertmsg=confirm("Do you want to Delete ?");
		if (alertmsg == true) {
			$.ajax({
					type: "POST",
					url: "sky_receipt_details_service.php",
					dataType:'json',
					data: {delid:delid,req:"ADDDEL"},
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Deleted !", "success");
							setTimeout(function(){
								window.location.href='sky_receipt_edit_details.php?id=<?php echo $_GET['id']; ?>';
							},500);

							
							//$('#detailsgrid').DataTable().ajax.reload();
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

	
	$(document).on('blur', '.amount_discount', function() {
		var id = this.id;
		var product_id=$("#"+id).val();
		var splitid = id.split('_');
		var index = splitid[2];
		//var amount_discount=$("#amount_discount_"+index).val();
		//$("#sale_rate"+count).empty();

		var balance=parseFloat($("#balance_"+index).val());	
		var amount_discount = parseFloat($("#amount_discount_"+index).val());
		var dc_id=$("#dc_id_"+index).val();
		


		if(amount_discount>balance){
			swal("Warning!", "Only "+balance+" Amount  !", "warning");

		}else{

			$.ajax({
				type: "POST",
				url: "sky_sales_discount_update.php",
				dataType:'json',
				data: {dc_id:dc_id,req:'DISUPD',amount_discount:amount_discount},
				success: function(result) {
						if(result.op==1){
							//swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='sky_receipt_edit_details.php?id=<?php echo $_GET['id'];?>&id1=<?php echo $_GET['id1']; ?>';
							},200);
						}
						else{
							alert($("#msg").html(result.op));
						}
				},error:function(xhr,status,error){
					console.log(JSON.stringify(xhr,status,error));
				}
			});

		}

		

		balance_amount();
    });


	$("#submit").click(function(e){
		e.preventDefault();

		var grand_total_amount=Number($("#grand_total_amount").val());
		var pay_amount=Number($("#pay_amount").val());
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){

		if($("#customer_id").val()==''){
			swal("Error!", "Select customer !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#pay_amount").val()==''){
			swal("Error!", "Enter Amount !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if(pay_amount > grand_total_amount){
			swal("Error!", "Invalid Amount1 !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if(!payModeValid($("#payment_mode").val(), $("#bank_id").val(), $("#ref_no").val())){
			return false;
		}
		else{
			applyPayMode($("#payment_mode").val());
			$("#req").val('ADDINS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "sky_receipt_details_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='sky_receipt_details.php';
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

	
	
	setTimeout(function(){
		var datefullvalue= $("#date1").val();
		var datevalue = datefullvalue.split('/')[0];
		var monthvalue = datefullvalue.split('/')[1];
		var yearvalue = datefullvalue.split('/')[2];
		$("#billing_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);
	},500);

	$("#date1").change(function(){
		var datefullvalue= $("#date1").val();
		var datevalue = datefullvalue.split('/')[0];
		var monthvalue = datefullvalue.split('/')[1];
		var yearvalue = datefullvalue.split('/')[2];
		$("#billing_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);
	});
	



	$(document).on('keyup', '.pay_amount', function() {		
		balance_amount();
    });


		// Deep-link from invoice details Pay button (?dc_id=...): preselect that bill.
	var deepDcId = "<?php echo isset($_GET['dc_id']) ? (int)$_GET['dc_id'] : 0; ?>";
	if(deepDcId && parseInt(deepDcId) > 0){
		setTimeout(function(){
			var found = false;
			$(".dc_id").each(function(){
				if($(this).val() == String(deepDcId)){
					var did = $(this).attr('id');
					var idx = did.split('_')[1];
					var bal = parseFloat($("#balance_"+idx).val()||0);
					if(bal > 0){
						$("#pay_amount").val(bal.toFixed(2));
						balance_amount();
					}
					if($(this).closest('tr')[0]){
						$(this).closest('tr')[0].scrollIntoView({behavior:'smooth', block:'center'});
					}
					found = true;
				}
			});
			if(!found){
				$("#msg").css("color","red").html("Linked bill not found / already paid.");
				setTimeout(function(){$("#msg").html('')},3000);
			}
		},300);
	}

	function balance_amount() {
		var row_count = (document.getElementsByClassName("dc_id").length);	
		var pay_amount = $("#pay_amount").val();
		var grand_total_amount = $("#grand_total_amount").val();		
			
		$("#grand_total_amount2").html(grand_total_amount-pay_amount);
		
		for (i = 1; i <= row_count; i++) {	

			balance=$("#balance_"+i).val();	 
			$("#balance1_"+i).val(balance-pay_amount);
			
			pay_amount=balance-pay_amount;

			

			if(pay_amount<0){
				
				pay_amount=(pay_amount*-1);
				balance=$("#extra_"+i).val('0');
				$("#balance2_"+i).html('0');				
				
				
			}else if(pay_amount>0){	
						
				balance=$("#extra_"+i).val(pay_amount);
				$("#balance2_"+i).html(pay_amount);	
				pay_amount=0;
			}else{
				$("#balance2_"+i).html('0');
				pay_amount=0;
			}


			if($("#balance_"+i).val() < $("#extra_"+i).val()){
				//$("#dc_"+i).attr('checked', true);
				$("#dc_"+i).prop("checked", true);

				if($("#balance1_"+i).val()==0){
					$("#dc_"+i).prop("checked", true);
				}

				//$("#dc_"+i).is(':checked', true);

			}else if($("#balance_"+i).val() > $("#extra_"+i).val()){
				//$("#dc_"+i).attr('checked', true);
				$("#dc_"+i).prop("checked", true);

				if($("#balance1_"+i).val()==0){
					$("#dc_"+i).prop("checked", true);
				}

				//$("#dc_"+i).is(":checked", true);
				

			}else{

				if($("#balance1_"+i).val()==0){
					$("#dc_"+i).prop("checked", true);
				}else{
					$("#dc_"+i).prop("checked", false);
				}

				
			}
					
			
            
        }

        
	}


	
	

	

	

	
});
	

	
	
		
 	

</script>
</html>