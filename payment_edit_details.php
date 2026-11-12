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
            <h4>Payment Details</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-t-0">
                    <li class="breadcrumb-item"><a href="#">Payment</a></li>
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
							// Legacy product-payment header query removed: live tbl_payment has no
							// total_amount/grand_total_amount columns and no tbl_payment_details table;
							// this page uses $_GET['id'] as supplier_id (multi-pay flow). Supplier block below loads it safely.
							$fetch_sql = null; ?>
									
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-left">Supplier Detail:</label>
										<div class="col-md-5">
											<?php
												$supplier_sql = "select * from tbl_supplier where delete_status='NDL' and supplier_id='".mysqli_real_escape_string($conn, $_GET['id'])."'";
												$supplier_exec_sql = mysqli_query($conn, $supplier_sql);
												$supplier_fetch_sql = $supplier_exec_sql ? mysqli_fetch_array($supplier_exec_sql) : null;
											?>
												<p style="margin-bottom: 0rem;"><b><?php echo htmlspecialchars($supplier_fetch_sql['supplier_name'] ?? ''); ?></b></p>
												<p style="margin-bottom: 0rem;"><?php echo htmlspecialchars($supplier_fetch_sql['address'] ?? ''); ?></p>
												

											
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
									<div class="form-group row" id="ref_wrap">
										<label for="staticEmail" class="col-sm-5 col-form-label text-right">Ref / Txn No :</label>
										<div class="col-sm-6">
											<input type="text" name="ref_no" class="form-control" id="ref_no" placeholder="UPI ref / cheque no.">
										</div>
									</div>
									<div class="form-group row" id="remarks_wrap">
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

											<input type="hidden" name="supplier_id" class="form-control supplier_id" id="supplier_id" value="<?php echo $_GET['id'];?>" >
											
											
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
							<th style="width: 15%">Date</th>
							<th style="width: 10%">Dc No</th>
							<th style="width: 10%">Amount</th>
							<th style="width: 15%">Paid Amount</th>
							<th style="width: 15%">Balance Amount</th>
							<!--th style="width: 15%">Pay Now</th>	
							<th style="width: 15%">Action</th-->									
						</tr>
					</thead>
					<tbody id="tablemainbind">
						<?php
							$grand_total_amount=0;
							$pay_amount=0;
							$pay_count=0;

							$sql="SELECT b.rate_tax,a.purchase_id,a.dc_no,a.total_amount,a.grand_total_amount,date_format(a.create_date,'%d/%m/%Y') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date FROM tbl_raw_purchase  a 
							inner join tbl_raw_purchase_details b on a.purchase_id=b.purchase_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and a.supplier_id='".$_GET['id']."' group by b.purchase_id";
							$exec_sql=mysqli_query($conn,$sql);
							$i=1;
							while($fetch_zql=mysqli_fetch_array($exec_sql)){


								$gql3 = "SELECT sum(pay_amount) as pay_amount1 FROM tbl_payment where delete_status='NDL' and supplier_id='".$_GET['id']."' and  purchase_id='".$fetch_zql['purchase_id']."' and  delete_status!='0'  ";
								//print_r($gql3);	
								$exec_query3=mysqli_query($conn, $gql3);
								$rows=mysqli_num_rows($exec_query3);
								if($rows>0){
									
									$exec_gql3 = mysqli_fetch_array($exec_query3);
									$pay_count=$exec_gql3['pay_amount1'];
								}else{
									$pay_count=0;
								}

								
								$grand_total_amount=$grand_total_amount+$fetch_zql['grand_total_amount'];
								$pay_amount=$pay_amount+$pay_count;

								//$grand_total_amount=$grand_total_amount+$fetch_zql['grand_total_amount'];
								//$pay_amount=$pay_amount+$pay_count;

								$total_balance=$fetch_zql['grand_total_amount']-$pay_count;

								if($total_balance!=0){	


						?>
							<tr class="trtag" id="trtag<?php echo $i+1;?>">
							
								<td style="padding:5px" class="text-center">
									<?php //echo $i;?>
									<input type="checkbox" id="dc_<?php echo $i;?>" name="dc[]" value="<?php echo $fetch_zql['dc_no'];?>">
								</td>

								<td style="padding:5px">
									<?php echo $fetch_zql['create_date'];?>
								</td>
								
								<td style="padding:5px">
									<?php echo $fetch_zql['dc_no'];?>
								</td>
								
								<td style="padding:5px">
									<?php echo $fetch_zql['grand_total_amount'];?>
								</td>
								
								<td style="padding:5px">
									<a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-supplier_id='<?php echo $_GET['id'];?>' data-purchase_id=<?php echo $fetch_zql['purchase_id']?> data-dc_no='<?php echo $fetch_zql['dc_no'];?>' data-balance='<?php echo number_format($fetch_zql['grand_total_amount']-$pay_count, 2, '.', '')?>'><button type='button'   class='btn btn-warning' style='padding:4px 5px; 5px; 2px; color:#fff'><?php echo $pay_count;?></button></a>
									
								</td>

								<td style="padding:5px">
									<span id="balance2_<?php echo $i; ?>"><?php echo $fetch_zql['grand_total_amount']-$pay_count;?></span>
									
									
									<input type="hidden" name="purchase_id[]" class="form-control purchase_id"  value="<?php echo $fetch_zql['purchase_id'];?>" id="purchase_id_<?php echo $i; ?>" >

									<input type="hidden" name="balance[]" class="form-control balance"  value="<?php echo $fetch_zql['grand_total_amount']-$pay_count;?>" id="balance_<?php echo $i; ?>" >

									<input type="hidden" name="extra[]" readonly class="form-control extra" id="extra_<?php echo $i; ?>" >

									<input type="hidden" name="balance1[]" class="form-control balance1"   id="balance1_<?php echo $i; ?>" >
									
									
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
									<?php echo $fetch_zql['grand_total_amount'];?>
								</td>
								
								<td style="padding:5px">
									<a href="javascript:void(0)" class="innerid" data-toggle="modal" data-target="#exampleModalCenter6" data-supplier_id='<?php echo $_GET['id'];?>' data-purchase_id=<?php echo $fetch_zql['purchase_id']?> data-dc_no='<?php echo $fetch_zql['dc_no'];?>' data-balance='<?php echo number_format($fetch_zql['grand_total_amount']-$pay_count, 2, '.', '')?>'><button type='button'   class='btn btn-warning' style='padding:4px 5px; 5px; 2px; color:#fff'><?php echo $pay_count;?></button></a>
									
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
								<th  style="font-size: 18px;"><?php echo $pay_amount;?></th>
								<th  style="font-size: 18px;"><span id="grand_total_amount2"><?php echo $grand_total_amount-$pay_amount;?></span>
							
								

									<input type="hidden" name="grand_total_amount" class="form-control grand_total_amount" value="<?php echo $grand_total_amount-$pay_amount;?>"   id="grand_total_amount" >
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
					<h5 class="modal-title" id="exampleModalCenterTitle" style="color:#000">Payment details</h5>

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
								<input type="hidden" id="single_purchase_id" name="single_purchase_id">
								<input type="hidden" id="single_dc_no" name="single_dc_no">
								<input type="hidden" id="single_supplier_id" name="single_supplier_id" value="<?php echo $_GET['id']; ?>">
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
							
							<table id="paymentgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>S.no</th>
										<th>Date</th>
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



<input type="hidden" name="modulenamebox" id="modulenamebox" value="3">
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
			$("#ref_wrap").hide(); $("#ref_no").val('');
			$("#remarks_wrap").show();
		} else {
			$("#bank_option").show(); $("#ref_wrap").show(); $("#remarks_wrap").show();
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

			
		var purchase_id = $(this).attr('data-purchase_id');	
		$("#single_purchase_id").val(purchase_id);
		$("#single_dc_no").val($(this).attr('data-dc_no'));
		$("#single_supplier_id").val($(this).attr('data-supplier_id'));
		$("#single_pay_amount").val($(this).attr('data-balance'));
		$("#singlePayMsg").html('');
		//alert(dc_id);

		$("#paymentgrid").dataTable().fnDestroy();
		$('#paymentgrid').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"language": { "emptyTable": "No payments yet for this bill" },
			"ajax": {
				url: "payment_details_model_grid.php", // json datasource
				type: "post", // type of method  ,GET/POST/DELETE
				data: {
					purchase_id: purchase_id,
					supplier_id: '<?php echo (int)$_GET['id']; ?>'
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
		if(!$("#single_purchase_id").val() || !(amt>0)){ swal("Error!", "Select bill and enter valid amount !", "warning"); return false; }
		$("#singlePayMsg").css("color","green").html("Processing . . .");
		applySinglePayMode($("#single_payment_mode").val());
		if(!payModeValid($("#single_payment_mode").val(), $("#single_bank_id").val(), $("#single_ref_no").val())){ $("#singlePayMsg").html(''); return false; }
		$.ajax({
			type: "POST",
			url: "payment_details_service.php",
			dataType:'json',
			data: {
				req:'ADDINS',
				supplier_id: $("#single_supplier_id").val(),
				billing_date: $("#single_billing_date").val(),
				payment_mode: $("#single_payment_mode").val(),
				bank_id: $("#single_bank_id").val(),
				ref_no: $("#single_ref_no").val(),
				remarks: $("#single_remarks").val(),
				'dc[]': [$("#single_dc_no").val()],
				'purchase_id[]': [$("#single_purchase_id").val()],
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

	$(document).on('click','.payment_deleteTriger', function(){
		var delid=$(this).data('value');
		var alertmsg=confirm("Do you want to Delete ?");
		if (alertmsg == true) {
			$.ajax({
					type: "POST",
					url: "payment_details_service.php",
					dataType:'json',
					data: {delid:delid,req:"ADDDEL"},
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Deleted !", "success");
							setTimeout(function(){
								window.location.href='payment_edit_details.php?id=<?php echo $_GET['id']; ?>';
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

	/*$(".update").click(function(e){		

		e.preventDefault();
		//var pay_amount = $(this).attr('data-pay_amount');
		var supplier_id = $(this).attr('data-supplier_id');
		var purchase_id = $(this).attr('data-purchase_id');	
		var billing_date = $("#billing_date").val();
		var payment_mode = $("#payment_mode").val();
		var bank_id = $("#bank_id").val();
		var dc_no = $(this).attr('data-dc_no');
		$("#req").val('ADDINS');	
		

		var pay_amount =$('#pay_now'+purchase_id).val();

		if($('#pay_now'+purchase_id).val()==''){
			swal("Error!", "Invalid amount", "error");
			return false;
		}
		else{
			
			$("#msg").css("color","green").html("Processing . . .");

			//console.log(supplier_id + purchase_id + dc_no + pay_amount + billing_date);
			$.ajax({
				type: "POST",
				url: "payment_details_service.php",
				dataType:'json',
				data: {supplier_id:supplier_id,purchase_id:purchase_id,dc_no:dc_no,pay_amount:pay_amount,billing_date:billing_date,payment_mode:payment_mode,bank_id:bank_id},
				success: function(result) {
					console.log(result);
					if(result.op==1){
						swal("Success!", "Successfully Saved !", "success");
						setTimeout(function(){
							window.location.href='payment_details.php';
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
		


				
	});*/


	$("#submit").click(function(e){
		e.preventDefault();
		
		var grand_total_amount=Number($("#grand_total_amount").val());
		var pay_amount=Number($("#pay_amount").val());

		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){

		if($("#supplier_id").val()==''){
			swal("Error!", "Select supplier !", "warning");
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
					url: "payment_details_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='payment_details.php';
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


	function balance_amount() {
		var row_count = (document.getElementsByClassName("purchase_id").length);	
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

				//$("#dc_"+i).is(':checked', true);

			}else if($("#balance_"+i).val() > $("#extra_"+i).val()){
				//$("#dc_"+i).attr('checked', true);
				$("#dc_"+i).prop("checked", true);
				//$("#dc_"+i).is(":checked", true);
				

			}else{
				//$("#dc_"+i).attr('checked', false);
				$("#dc_"+i).prop("checked", false);
				//$("#dc_"+i).is(':checked', false);
			}
					
			
            
        }

        
	}


	
	

	

	/*$("#submit").click(function(e){
		e.preventDefault();
		
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php //echo $log;?>' == 'admin'){
		if($("#supplier_id").val()==''){
			swal("Error!", "Select supplier !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#pay_amount").val()==''){
			swal("Error!", "Select product !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else if($("#pay_amount").val()>$("#grand_total_amount").val()){
			swal("Error!", "Enter Inspection !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}
		else{
			
			$("#req").val('ADDUPD');
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
								window.location.href='packing_details.php';
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
	});*/

	
});
	

	
	
		
 	

</script>
</html>