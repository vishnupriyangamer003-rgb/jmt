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
    <link rel="stylesheet" href="vendors/vmap/jqvmap.min.css">
	<link rel="stylesheet" href="vendors/select2/css/select2.min.css" type="text/css">
    <!-- begin::custom styles -->
    <link rel="stylesheet" href="css/app.min.css" type="text/css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
    <link rel="stylesheet" href="css/themify-icons.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- end::custom styles -->

</head>
<body>
<?php 
include('sessionservices.php');
$customer_id = intval($_GET['id'] ?? 0);

$customer_sql = "SELECT * FROM tbl_customer WHERE customer_id='" . $customer_id . "'";
$customer_exec = mysqli_query($conn, $customer_sql);
$customer_data = $customer_exec ? mysqli_fetch_assoc($customer_exec) : null;
$validCustomer = !empty($customer_data);
?>

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
            <h4>Receipt & Payment Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="receipt_details.php">Receipts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customer Payment</li>
                </ol>
            </nav>
        </div>
    </div>

	<form id="mainform" method="POST" action="" enctype="multipart/form-data">

	<div class="row">
        <div class="col-md-4">
			<div class="card">
                <div class="card-body">
								
					<div class="form-group row" style="background:#f1f5f9;border-radius:6px;padding:10px 5px;margin-bottom:15px;">
						<label class="col-sm-4 col-form-label text-left"><strong>Customer :</strong></label>
						<div class="col-sm-8">
							<?php if ($validCustomer) { ?>
							<p style="margin-bottom: 2px;font-size:16px;"><b><?php echo htmlspecialchars($customer_data['customer_name'] ?? 'Unknown Customer', ENT_QUOTES, 'UTF-8'); ?></b></p>
							<p style="margin-bottom: 0rem;color:#64748b;font-size:13px;"><?php echo htmlspecialchars($customer_data['address'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
							<?php } else { ?>
							<p style="margin-bottom: 2px;font-size:16px;color:red;"><b>Invalid customer selected</b></p>
							<p style="margin-bottom: 0rem;color:#64748b;font-size:13px;">Open this page from the Receipts list View / Pay button.</p>
							<?php } ?>
						</div>
					</div> 
					   
					<div id='proforma'>
						
						<div class="form-group row">
							<label class="col-sm-5 col-form-label text-right">Billing Date :</label>
							<div class="col-sm-7">
								<input type="text" name="single-date-picker" class="form-control" id="date1" value="<?php echo date('d/m/Y'); ?>">
								<input type="hidden" value="<?php echo date('d/m/Y'); ?>" name="billing_date" id="billing_date" >
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-5 col-form-label text-right">Payment Mode :</label>
							<div class="col-sm-7">
								<select class="form-control" id="payment_mode" name="payment_mode">
									<option value='3'>Cash</option>
									<option value='1'>UPI</option>
									<option value='2'>Card</option>
									<option value='4'>Bank Transfer</option>
									<option value='5'>Cheque</option>
									<option value='6'>Other</option>
								</select>
							</div>
						</div>
						<div class="form-group row" id='bank_option' style="display:none;">
							<label class="col-sm-5 col-form-label text-right">Bank Name :</label>
							<div class="col-sm-7">
								<select class="form-control" id="bank_id" name="bank_id">
									<option value="">Select Bank</option>
								</select>
							</div>
						</div>
						<div class="form-group row" id="ref_wrap" style="display:none;">
							<label class="col-sm-5 col-form-label text-right">Ref / Txn No :</label>
							<div class="col-sm-7">
								<input type="text" name="ref_no" class="form-control" id="ref_no" placeholder="UPI ref / cheque no.">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-5 col-form-label text-right">Remarks :</label>
							<div class="col-sm-7">
								<input type="text" name="remarks" class="form-control" id="remarks" placeholder="Remarks">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-sm-5 col-form-label text-right"><strong>Pay Amount :</strong></label>
							<div class="col-sm-7">
								<input type="number" step="any" min="0" name="pay_amount" class="form-control pay_amount" id="pay_amount" placeholder="Enter amount">
								<input type="hidden" name="customer_id" class="form-control customer_id" id="customer_id" value="<?php echo $customer_id; ?>" >
							</div>
						</div>

					</div>
					
					<div class="col-md-12 text-center" style="margin-top:15px;">
						<input type="hidden" name="req" id="req">
						<button type="submit" name="submit" id="submit" class="btn btn-success" style="min-width:120px;">Save Payment</button>									
						<a href="receipt_details.php" class="btn btn-danger" style="min-width:100px;">Back</a>
					</div>
					<div class="col-md-12 text-center" style="margin-top:10px;">
						<span id="msg" style="font-weight:bold;"></span>
					</div>
                </div>
            </div>
		</div>

		<div class="col-md-8">
			<div class="card">
				<div class="card-body">	
				
				<table id="detailsgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th style="width: 5%">Slno</th>
							<th style="width: 15%">Bill Date</th>
							<th style="width: 15%">Dc No</th>
							<th style="width: 15%">Amount</th>
							<th style="width: 12%">Discount</th>
							<th style="width: 18%">Paid Amount</th>
							<th style="width: 20%">Balance Amount</th>
						</tr>
					</thead>
					<tbody id="tablemainbind">
						<?php
							$grand_total_amount = 0;
							$pay_amount_sum = 0;
							$discount_total_amount = 0;
							$total_amount_sum = 0;

							$sql = "SELECT a.dc_id, a.dc_no, a.discount, a.total_amount, a.grand_total_amount, 
							               DATE_FORMAT(a.create_date,'%d/%m/%Y') as create_date, 
							               DATE_FORMAT(a.billing_date,'%d/%m/%Y') as billing_date,
							               COUNT(b.dc_id) AS item_count
							        FROM tbl_gst_invoice a 
							        LEFT JOIN tbl_gst_invoice_details b ON a.dc_id = b.dc_id AND b.delete_status != '0' 
							        WHERE a.delete_status != '0' AND a.customer_id = '" . $customer_id . "' 
							        GROUP BY a.dc_id 
							        ORDER BY a.billing_date ASC, a.dc_id ASC";

							$exec_sql = mysqli_query($conn, $sql);
							$i = 1;
							$hasBills = false;
							if ($exec_sql) {
								while($fetch_zql = mysqli_fetch_array($exec_sql)){
									$hasBills = true;
									$dc_id = intval($fetch_zql['dc_id']);

									$gql3 = "SELECT COALESCE(SUM(pay_amount), 0) as pay_amount1 
									         FROM tbl_receipt 
									         WHERE delete_status='NDL' AND customer_id='" . $customer_id . "' AND dc_id='" . $dc_id . "'";
									$exec_query3 = mysqli_query($conn, $gql3);
									$exec_gql3 = $exec_query3 ? mysqli_fetch_assoc($exec_query3) : null;
									$pay_count = floatval($exec_gql3['pay_amount1'] ?? 0);

									$bill_total = floatval($fetch_zql['grand_total_amount']) + floatval($fetch_zql['discount']);
									$discount_val = floatval($fetch_zql['discount']);
									$bill_grand = floatval($fetch_zql['grand_total_amount']);
									$total_balance = $bill_grand - $pay_count;

									$total_amount_sum += $bill_total;
									$discount_total_amount += $discount_val;
									$pay_amount_sum += $pay_count;

									if($total_balance > 0){								
						?>
							<tr class="trtag" id="trtag<?php echo $i;?>">
								<td style="padding:5px" class="text-center">
									<input type="checkbox" id="dc_<?php echo $i;?>" name="dc[]" value="<?php echo htmlspecialchars($fetch_zql['dc_no'], ENT_QUOTES, 'UTF-8');?>">
								</td>

								<td style="padding:5px">
									<?php echo htmlspecialchars($fetch_zql['billing_date'] ?? $fetch_zql['create_date'], ENT_QUOTES, 'UTF-8');?>
								</td>
								
								<td style="padding:5px">
									<b><?php echo htmlspecialchars($fetch_zql['dc_no'], ENT_QUOTES, 'UTF-8');?></b>
								</td>
								
								<td style="padding:5px">
									<?php echo number_format($bill_total, 2, '.', ''); ?>
								</td>

								<td style="padding:5px">
									<input type="number" step="any" name="amount_discount[]" class="form-control amount_discount" value="<?php echo $discount_val; ?>" id="amount_discount_<?php echo $i; ?>" style="max-width:90px;">
								</td>
								
								<td style="padding:5px">
									<a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-customer_id="<?php echo $customer_id;?>" data-dc_id="<?php echo $dc_id;?>" data-dc_no="<?php echo htmlspecialchars($fetch_zql['dc_no'], ENT_QUOTES, 'UTF-8');?>" data-balance="<?php echo number_format($total_balance, 2, '.', '');?>">
										<button type="button" class="btn btn-warning" style="padding:3px 8px;color:#fff;font-weight:bold;"><?php echo number_format($pay_count, 2, '.', '');?></button>
									</a>
								</td>

								<td style="padding:5px">
									<span id="balance2_<?php echo $i; ?>" style="color:red;font-weight:bold;"><?php echo number_format($total_balance, 2, '.', '');?></span>
									
									<input type="hidden" name="dc_id[]" class="form-control dc_id" value="<?php echo $dc_id;?>" id="dc_id_<?php echo $i; ?>" >
									<input type="hidden" name="dc_no[]" value="<?php echo htmlspecialchars($fetch_zql['dc_no'], ENT_QUOTES, 'UTF-8');?>" id="dc_no_<?php echo $i; ?>" >
									<input type="hidden" name="balance[]" class="form-control balance" value="<?php echo number_format($total_balance, 2, '.', '');?>" id="balance_<?php echo $i; ?>" >
									<input type="hidden" name="extra[]" readonly class="form-control extra" id="extra_<?php echo $i; ?>" >
									<input type="hidden" name="balance1[]" class="form-control balance1" id="balance1_<?php echo $i; ?>" >
								</td>
							</tr>
						<?php 
										$i++; 
									} else {
						?>
							<tr class="trtag" id="trtag_paid_<?php echo $i;?>" style="background:#f8fafc;opacity:0.8;">
								<td style="padding:5px" class="text-center">
									<i class="fa fa-check-circle" style="color:green;font-size:18px;"></i>
								</td>

								<td style="padding:5px">
									<?php echo htmlspecialchars($fetch_zql['billing_date'] ?? $fetch_zql['create_date'], ENT_QUOTES, 'UTF-8');?>
								</td>
								
								<td style="padding:5px">
									<?php echo htmlspecialchars($fetch_zql['dc_no'], ENT_QUOTES, 'UTF-8');?>
								</td>
								
								<td style="padding:5px">
									<?php echo number_format($bill_total, 2, '.', ''); ?>
								</td>
								<td style="padding:5px">
									<?php echo number_format($discount_val, 2, '.', ''); ?>
								</td>
								
								<td style="padding:5px">
									<a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-customer_id="<?php echo $customer_id;?>" data-dc_id="<?php echo $dc_id;?>" data-dc_no="<?php echo htmlspecialchars($fetch_zql['dc_no'], ENT_QUOTES, 'UTF-8');?>" data-balance="0">
										<button type="button" class="btn btn-info" style="padding:3px 8px;color:#fff;"><?php echo number_format($pay_count, 2, '.', '');?></button>
									</a>
								</td>

								<td style="padding:5px">
									<span style="color:green;font-weight:bold;">0.00 (Paid)</span>
								</td>
							</tr>
						<?php 
										$i++; 
									} 
								}
							}
							if (!$hasBills) {
						?>
							<tr>
								<td colspan="7" class="text-center" style="padding:20px;color:#64748b;">No bills found for this customer.</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot id="taxbind1">					
							<tr class="taxdiv" id="taxdiv0" style="background:#f1f5f9;font-weight:bold;">
								<th colspan="3" class="text-right" style="font-size:15px;color:red;">Grand Total :</th>
								<th style="font-size:16px;color:blue;"><?php echo number_format($total_amount_sum, 2, '.', '');?></th>
								<th style="font-size:16px;"><?php echo number_format($discount_total_amount, 2, '.', '');?></th>
								<th style="font-size:16px;color:green;"><?php echo number_format($pay_amount_sum, 2, '.', '');?></th>
								<th style="font-size:16px;color:red;">
									<span id="grand_total_amount2"><?php echo number_format($total_amount_sum - ($pay_amount_sum + $discount_total_amount), 2, '.', '');?></span>
									<input type="hidden" name="grand_total_amount" class="form-control grand_total_amount" value="<?php echo number_format($total_amount_sum - ($pay_amount_sum + $discount_total_amount), 2, '.', '');?>" id="grand_total_amount" >
								</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>

	</form>

</main>
<!-- end::main content -->

<div class="modal fade" id="exampleModalCenter6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background:#1e293b;color:#fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle" style="color:#fff;">Payment Details for Bill</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="singlePayForm">
				<div class="row" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:12px;margin-bottom:15px;">
					<div class="col-md-12"><h6 style="color:#1e293b;font-weight:700;">Single Pay for this bill</h6></div>
					<div class="col-md-4"><div class="form-group"><label>Billing Date :</label><input type="text" id="single_billing_date" class="form-control" value="<?php echo date('d/m/Y'); ?>"></div></div>
					<div class="col-md-4"><div class="form-group"><label>Payment Mode :</label><select class="form-control" id="single_payment_mode"><option value='3'>Cash</option><option value='1'>UPI</option><option value='2'>Card</option><option value='4'>Bank Transfer</option><option value='5'>Cheque</option><option value='6'>Other</option></select></div></div>
					<div class="col-md-4" id="single_bank_wrap" style="display:none;"><div class="form-group"><label>Bank Name :</label><select class="form-control" id="single_bank_id"><option value="">Select Bank</option></select></div></div>
					<div class="col-md-4" id="single_ref_wrap" style="display:none;"><div class="form-group"><label>Ref / Txn No :</label><input type="text" id="single_ref_no" class="form-control" placeholder="UPI ref / cheque no."></div></div>
					<div class="col-md-4"><div class="form-group"><label>Remarks :</label><input type="text" id="single_remarks" class="form-control" placeholder="Remarks"></div></div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Amount :</label>
							<input type="number" min="0.01" step="any" id="single_pay_amount" class="form-control" placeholder="Amount">
							<input type="hidden" id="single_dc_id">
							<input type="hidden" id="single_dc_no">
							<input type="hidden" id="single_customer_id" value="<?php echo $customer_id; ?>">
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
						<h6 style="font-weight:bold;margin-bottom:10px;">Payment History</h6>
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
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="modulenamebox" id="modulenamebox" value="8">
<input type="hidden" name="rightsbox" id="rightsbox">

<?php include("footer.php") ?>

<script src="vendors/dataTable/jquery.dataTables.min.js"></script>
<script src="vendors/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="vendors/dataTable/dataTables.responsive.min.js"></script>
<script src="js/examples/datatable.js"></script>
<script src="vendors/charts/chartjs/chart.min.js"></script>
<script src="vendors/charts/peity/jquery.peity.min.js"></script>
<script src="js/examples/charts/chartjs.js"></script>
<script src="js/examples/charts/peity.js"></script>
<script src="vendors/datepicker/daterangepicker.js"></script>
<script src="js/examples/dashboard.js"></script>
<script src="vendors/vmap/jquery.vmap.min.js"></script>
<script src="vendors/vmap/maps/jquery.vmap.usa.js"></script>
<script src="js/examples/vmap.js"></script>
<script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>

</body>

<script>
$(document).ready(function(){
	$(".page-loader").hide();

	$('input[name="single-date-picker"], #single_billing_date').daterangepicker({
	  singleDatePicker: true,
	  showDropdowns: true,
	  locale: {
		  format: 'DD/MM/YYYY'
	  }
  	});

	function toggleMainPaymentMode(mode) {
		if (String(mode) === '3') {
			$("#bank_option").hide();
			$("#bank_id").val('');
			$("#ref_wrap").hide();
			$("#ref_no").val('');
		} else {
			$("#bank_option").show();
			$("#ref_wrap").show();
		}
	}

	function toggleSinglePaymentMode(mode) {
		if (String(mode) === '3') {
			$("#single_bank_wrap").hide();
			$("#single_bank_id").val('');
			$("#single_ref_wrap").hide();
			$("#single_ref_no").val('');
		} else {
			$("#single_bank_wrap").show();
			$("#single_ref_wrap").show();
		}
	}

	$(document).on('change', '#payment_mode', function() {
		toggleMainPaymentMode(this.value);
	});
	toggleMainPaymentMode($("#payment_mode").val());

	$(document).on('change', '#single_payment_mode', function() {
		toggleSinglePaymentMode(this.value);
	});
	toggleSinglePaymentMode($("#single_payment_mode").val());

	$.ajax({
		type: "POST",
		url: "bank_dropdown.php",
		success: function(result) {
			if (result && result.bank_id && result.bank_id.length) {
				var d_data = '<option value="">Select Bank</option>';
				for(var i = 0; i < result.bank_id.length; i++){
					d_data += '<option value="' + result.bank_id[i] + '">' + result.bank_name[i] + '</option>';
				}
				$("#bank_id, #single_bank_id").empty().append(d_data).removeAttr("disabled");
			}
		}
	});

	if('<?php echo $log;?>' != "admin"){
		$.ajax({
			type: "POST",
			url: "phpservices/employee_rights.php",
			dataType:'JSON',
			data: {empid: <?php echo intval($login_id ?? 0); ?>, moduleid: $("#modulenamebox").val()},
			success: function(result) {
				$("#rightsbox").val(result.rights);
			}
		});
	}

	$(document).on('click', '.innerid', function() {
		var dc_id = $(this).attr('data-dc_id');
		var dc_no = $(this).attr('data-dc_no');
		var cust_id = $(this).attr('data-customer_id') || '<?php echo $customer_id; ?>';
		var balance = $(this).attr('data-balance') || '';

		$("#single_dc_id").val(dc_id);
		$("#single_dc_no").val(dc_no);
		$("#single_customer_id").val(cust_id);
		$("#single_pay_amount").val(balance);
		$("#singlePayMsg").html('');

		if ($.fn.DataTable.isDataTable("#receiptgrid")) {
			$("#receiptgrid").DataTable().destroy();
		}

		$('#receiptgrid').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"ajax": {
				url: "receipt_details_model_grid.php",
				type: "post",
				data: {
					dc_id: dc_id,
					customer_id: cust_id
				},
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
				}
			}
		});
	});

	$(document).on('click', '#singlePaySubmit', function() {
		var amt = parseFloat($("#single_pay_amount").val() || 0);
		var dc_id = $("#single_dc_id").val();
		var dc_no = $("#single_dc_no").val();

		if (!dc_id || amt <= 0) {
			swal("Error!", "Enter a valid payment amount!", "warning");
			return false;
		}

		$("#singlePayMsg").css("color", "green").html("Processing . . .");

		$.ajax({
			type: "POST",
			url: "receipt_details_service.php",
			dataType: 'json',
			data: {
				req: 'ADDINS',
				customer_id: $("#single_customer_id").val(),
				billing_date: $("#single_billing_date").val(),
				payment_mode: $("#single_payment_mode").val(),
				bank_id: $("#single_bank_id").val(),
				ref_no: $("#single_ref_no").val(),
				remarks: $("#single_remarks").val(),
				'dc[]': [dc_no],
				'dc_no[]': [dc_no],
				'dc_id[]': [dc_id],
				'balance[]': [amt],
				'balance1[]': [0],
				'extra[]': [0]
			},
			success: function(result) {
				if (result.op == 1 || result.op == true) {
					swal("Success!", "Payment successfully saved!", "success");
					setTimeout(function(){
						window.location.reload();
					}, 1200);
				} else {
					$("#singlePayMsg").css("color", "red").html("Save failed!");
				}
			},
			error: function(xhr, status, error) {
				console.log(JSON.stringify(xhr, status, error));
				$("#singlePayMsg").css("color", "red").html("Save failed!");
			}
		});
	});

	$(document).on('click', '.receipt_deleteTriger', function(){
		var delid = $(this).data('value');
		var alertmsg = confirm("Do you want to Delete this payment record?");
		if (alertmsg == true) {
			$.ajax({
				type: "POST",
				url: "receipt_details_service.php",
				dataType: 'json',
				data: { delid: delid, req: "ADDDEL" },
				success: function(result) {
					if(result.op == 1 || result.op == true){
						swal("Success!", "Successfully Deleted!", "success");
						setTimeout(function(){
							window.location.reload();
						}, 800);
					} else {
						alert("Delete failed");
					}
				},
				error: function(xhr, status, error){
					console.log(JSON.stringify(xhr, status, error));
				}
			});
		}
	});

	$(document).on('blur', '.amount_discount', function() {
		var id = this.id;
		var splitid = id.split('_');
		var index = splitid[2];

		var balance = parseFloat($("#balance_" + index).val() || 0);	
		var amount_discount = parseFloat($("#amount_discount_" + index).val() || 0);
		var dc_id = $("#dc_id_" + index).val();

		if (amount_discount > balance) {
			swal("Warning!", "Discount cannot exceed balance of " + balance + "!", "warning");
			return false;
		}

		$.ajax({
			type: "POST",
			url: "sales_discount_update.php",
			dataType: 'json',
			data: { dc_id: dc_id, req: 'DISUPD', amount_discount: amount_discount },
			success: function(result) {
				if(result.op == 1 || result.op == true){
					setTimeout(function(){
						window.location.reload();
					}, 300);
				}
			},
			error: function(xhr, status, error){
				console.log(JSON.stringify(xhr, status, error));
			}
		});
    });

	$("#submit").click(function(e){
		e.preventDefault();

		var grand_total_amount = Number($("#grand_total_amount").val() || 0);
		var pay_amount = Number($("#pay_amount").val() || 0);
		
		var emprights = $("#rightsbox").val();
		if(emprights == '1' || emprights == '2' || emprights == '6' || emprights == '8' || '<?php echo $log;?>' == 'admin'){

			if($("#customer_id").val() === '' || $("#customer_id").val() == null){
				swal("Error!", "Select valid customer!", "warning");
				return false;
			} else if(pay_amount <= 0){
				swal("Error!", "Enter valid payment amount!", "warning");
				return false;
			} else {
				balance_amount(); // ensure allocation even if keyup/change never fired
				$("#req").val('ADDINS');
				$("#msg").css("color", "green").html("Processing . . .");
				$.ajax({
					type: "POST",
					url: "receipt_details_service.php",
					dataType: 'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						if(result.op == 1 || result.op == true){
							swal("Success!", "Successfully Saved!", "success");
							setTimeout(function(){
								window.location.href = 'receipt_details.php';
							}, 1500);
						} else {
							var em = "Save failed — payment may already be recorded or amount exceeds balance.";
							$("#msg").css("color","red").html(em);
							swal("Error!", em, "error");
						}
					},
					error: function(xhr, status, error){
						console.log(JSON.stringify(xhr,status,error));
						var em = "Server error while saving. Please retry.";
						$("#msg").css("color","red").html(em);
						swal("Error!", em, "error");
					}
				});
			}
		} else {
			swal("Error!", "Access Denied! Contact Admin...", "error");
			return false;
		}
	});

	$(document).on('keyup change', '.pay_amount', function() {		
		balance_amount();
    });

	function balance_amount() {
		var row_count = document.getElementsByClassName("dc_id").length;	
		var pay_amount = parseFloat($("#pay_amount").val() || 0);
		var grand_total_amount = parseFloat($("#grand_total_amount").val() || 0);		
			
		var remaining_grand = grand_total_amount - pay_amount;
		if (remaining_grand < 0) remaining_grand = 0;
		$("#grand_total_amount2").html(remaining_grand.toFixed(2));
		
		var remaining_pay = pay_amount;

		// Row indexes start at 1 (trtag1/dc_1/balance_1) to match server render
		for (var idx = 1; idx <= row_count; idx++) {	
			var orig_bal = parseFloat($("#balance_" + idx).val() || 0);

			if (remaining_pay >= orig_bal) {
				$("#balance1_" + idx).val(0);
				$("#balance2_" + idx).html('0.00');
				$("#dc_" + idx).prop("checked", true);
				remaining_pay -= orig_bal;
			} else if (remaining_pay > 0) {
				var new_bal = orig_bal - remaining_pay;
				$("#balance1_" + idx).val(new_bal.toFixed(2));
				$("#balance2_" + idx).html(new_bal.toFixed(2));
				$("#dc_" + idx).prop("checked", true);
				remaining_pay = 0;
			} else {
				$("#balance1_" + idx).val(orig_bal.toFixed(2));
				$("#balance2_" + idx).html(orig_bal.toFixed(2));
				$("#dc_" + idx).prop("checked", false);
			}
        }
	}
});
</script>
</html>