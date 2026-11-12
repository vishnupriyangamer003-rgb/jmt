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
            <h4>All Report Details</h4>
			
            <!--nav aria-label="breadcrumb">
				<a href="receipt_add_details.php" class="btn btn-warning" style="background: #000642;border-color: #000642;"><i class="fa fa-plus-circle" style="color:white;"></i>
					<span style="color:white">&nbsp;&nbsp;ADD Receipt DETAILS</span></a>
			</nav-->
        </div>
    </div>


						<ul class="nav nav-tabs" id="myTab" role="tablist" >
							<li class="nav-item">
								<a class="nav-link active"  id="alllist-tab"  href="sky_customer_all_report.php" role="tab"
								aria-controls="allist" aria-selected="false"><b>All</b></a>
							</li>
							<li class="nav-item" >
								<a class="nav-link " id="paidlist-tab"  href="sky_customer_ledger_paid_report.php" role="tab"
								aria-controls="paidlist" aria-selected="false"><b>Current Week</b></a>
							</li>
							<li class="nav-item">
								<a class="nav-link "  id="pendinglist-tab"  href="sky_customer_ledger_pending_report.php" role="tab"
								aria-controls="pendinglist" aria-selected="true"><b>Pending</b></a>
							</li>
							
						</ul>
						<div class="tab-content" id="myTabContent" style="border-style:solid;border-color:#dee2e6;border-width:0 1px 1px 1px;padding:15px;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;">
							<div class="tab-pane fade " id="pendinglist" role="tabpanel" aria-labelledby="pendinglist-tab">
							

								
							</div>
							<div class="tab-pane fade show active" id="alllist" role="tabpanel" aria-labelledby="alllist-tab">
								<div class="row">
									<div class="col-md-12">
										<div class="card">
											<div class="card-body">
											<table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th>S.no</th>   
														<th>Customer</th> 
														<th>Amount</th>
														<th>Paid&nbsp;Amount</th>
														<th>Balance&nbsp;Amount</th>
													</tr>
												</thead>
												
											</table>

											</div>
										</div>
									</div>
								</div>
									
							</div>
							
						</div>
					</div>
				</div>

	
</main>

<input type="hidden" name="modulenamebox" id="modulenamebox" value="14">
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

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script> 

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

	$('#detailsgrid').DataTable({
				dom: 'Blfript', // Blfrtip
				buttons:
				[
					
					{
						extend: 'excel',
						footer: true, 
						className: 'green glyphicon glyphicon-list-alt',
						title: 'Report',
						filename: 'Report',
						pageSize: 'LEGAL',
						exportOptions:
						{
							columns: [0, 1, 2, 3,4,5,6]
						}
					},
					
						{
							extend: 'print',
							footer: true,
							className: 'green glyphicon glyphicon-print',
							text: 'Print',
							title: ' ',
							autoPrint: true,
							orientation: 'landscape',
							pageSize: 'LEGAL',
							exportOptions:
							{
								columns: [0, 1, 2, 3,4,5,6]
							},
							// Format exported footer (NOT WORKING)
							/*customize: function (win)
							{
								var body = $(win.document.body).find('table tfoot');
								$(body).append($(body).find('tr:eq(0)').clone());
								var row = $(body).find('tr').last();
								//$(row).find('th').text('NEW');
								$(row).find('th:eq(7)').text('First column');
							}, */                     
						}
					],
				"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				"pageLength": -1,
				"bProcessing": true,
				"serverSide": true,
				"responsive": true,
				"ajax":{
					url :"sky_customer_all_grid.php", // json datasource
					type: "post",  // type of method  ,GET/POST/DELETE
					data: {receipt_type:"receipt"},
					error:function(xhr,status,error){
								console.log(JSON.stringify(xhr,status,error));
				}
				},
			
        });

		$(".dataTables_wrapper").addClass('row');
		$(".dataTables_length").addClass('col-md-6 col-xs-12').css('margin-top','50px');
		$(".dataTables_filter").addClass('col-md-6 col-xs-12').css('margin-top','50px');
		$(".buttons-html5").addClass('btn btn-success');
		$(".dt-button").addClass('btn btn-success');
		$(".dt-buttons").css('position','absolute').css('left','20px');

		/*$('#detailsgrid').DataTable({
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"sky_customer_all_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data: {receipt_type:"receipt"},
            error:function(xhr,status,error){
						console.log(JSON.stringify(xhr,status,error));
          }
		 }
        });	*/

$(document).on('click','.innerid', function(){
		$("#receipt_id").val($(this).data('receipt_id'));
		$("#expanse_amt").val($("#ta_"+$(this).data('receipt_id')).html());
});


$("#innersubmit").click(function(e){
		e.preventDefault();
		if($("#expanse_amt").val()==""){
			swal("Error!", "Enter Expense Amount !", "warning");
			return false;
		}
		else{
			$("#req").val('EXPANSE');
			//console.log($("#innerform").serialize());
			$.ajax({
				type: "POST",
				url: "expanse_amount_services.php",
				dataType:'json',
				data: $("#innerform").serialize(),
				//data:{receipt_id:$("#receipt_id").val()},
				success: function(result) {
					if(result.op==1){
							swal("Success!", "Saved Successfully !", "success");
							setTimeout(function(){
								window.location.href='sky_receipt_details.php';
							},500);
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
	
	$(document).on('click','.receiptdeleteTriger', function(){
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
		}
	});

});	
</script>
</html>