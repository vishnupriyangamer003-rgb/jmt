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
    <!--link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css"-->
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


	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jszip-2.5.0,dt-1.10.9,b-1.0.3,b-flash-1.0.3,b-html5-1.0.3/datatables.min.css" />
    <!--link rel="stylesheet" type="text/css" href="~/Content/dataTables.bootstrap.css" /> 
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
    <link rel="stylesheet" href="/resources/demos/style.css"--> 


	
	

</head>
<body>
<?php include 'sessionservices.php';?>
<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>Loading ...</span>
</div>
<!-- end::page loader -->

<?php echo $header; ?>

<!-- begin::main content -->
<main class="main-content">

    <div class="container-fluid">
        <div class="page-header d-md-flex justify-content-between align-items-center">
            <h4>GST INVOICE Report</h4>

        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<form id="mainform" method="POST" action="" enctype="multipart/form-data">
											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<label>From :</label>
														<input type="text" class="form-control" name="single-date-picker" id="sfdate2" autocomplete="off">
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>To :</label>
														<input type="text" class="form-control" name="single-date-picker" id="stdate2" autocomplete="off">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Customer Name :</label>
														<select  class="form-control js-example-basic-single select2-hidden-accessible" id="customer_id" name="customer_id" >
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>Vehicle Number :</label>
														<input type="text" class="form-control" id="vehicle_no" name="vehicle_no" placeholder="Vehicle Number">
													</div>
												</div>

												<div class="col-md-2">
														<button type="submit" id="search" class="btn btn-success" style="margin-top:32px;">search</button>
												</div>
											</div>
											<span id="msg" style="font-weight:bold;float:right;margin-top:7px;"></span>
										</form>



										<table id="detailsgrid" class="table table-bordered display" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th>S.no</th> 
														<th>Date</th> 
														<th>Bill&nbsp;No</th>     
														<th>Customer</th>   
														<th>GSTNO</th>   
														<th>Address</th> 
														<th>Vechicle&nbsp;Number</th>
														<th>Products</th> 							
														<th>Qty</th>      
														<th>Tot&nbsp;Amt</th>
														<th>GST&nbsp;Amt</th>
														<th>Discount</th>
														<th>Grand&nbsp;Tot&nbsp;Amt</th>
														<!--th>Address</th>
														<th>GSTNO</th>
														<th>Mobile&nbsp;No</th-->
													</tr>										
													
												
												
												</thead>

												<tbody>
													<!--tr>
														<td>1</td>
														<td>Manikandan</td>
														<td>Vel</td>
														
														<td>TN57 AZ 9090</td>
														<td>001</td>
														<td>20-01-2023</td>
														<td>5000</td>
														
													</tr>
													<tr>
														<td>2</td>
														<td>Suresh</td>
														<td>Mahesh</td>
														
														<td>TN44 CG 1589</td>
														<td>002</td>
														<td>25-01-2023</td>
														<td>2500</td>
														
													</tr-->

												</tbody>
												<tfoot>
													
												
												<!--tr>
													<td></td>												
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													
														<td  style="text-align:right" rowspan="1">Total:</td>
														<td colspan="1"><span style="background: red;padding: 5px 5px;color: #fff;border-radius: 4px;" id="report_total_qty"></span></td>
														<td colspan="1"><span style="background: red;padding: 5px 5px;color: #fff;border-radius: 4px;" id="report_total_amount"></span></td>
														<td colspan="1"><span style="background: red;padding: 5px 5px;color: #fff;border-radius: 4px;" id="report_gst_total_amount"></span></td>														
														
														<td colspan="1"><span style="background: red;padding: 5px 5px;color: #fff;border-radius: 4px;" id="report_total_discount_amount"></span></td>

														<td colspan="1"><span style="background: red;padding: 5px 5px;color: #fff;border-radius: 4px;" id="report_grand_total_amount"></span></td>
														<td></td>
														<td></td>
														<td></td>
															
												</tr-->
													
												</tfoot>
												
											</table>
									</div>
								</div>
							</div>
						</div>
                        
                    </div>
                </div>
			</div>
		</div>
	</div>
</main>
<!-- end::main content -->





<?php include("footer.php") ?>


<input type="hidden" name="modulenamebox" id="modulenamebox" value="7">
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
<script src="js/examples/datepicker.js"></script>
<!-- end::daterangepicker -->

<!-- START::select2 -->
<script src="vendors/select2/js/select2.min.js"></script>
<script src="js/examples/select2.js"></script>
<!-- end::select2 -->

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
<style>
@media(min-width:992px){
	.navbar-nav{
		display:block!important;
		width:100%;
	}
	.userdiv{
		float:right;
	}
	#submit{
		margin-top:32px;
	}
}

@media(max-width:480px){
	nav.navbar .header-logo a img{
		width:180px;
	}
}
.table td, .table th{
	padding: 5px;
}


</style>
<style>
    #detailsgrid_wrapper {
        width: 100%;
        overflow-x: auto;
    }
</style>
<script>


$(document).ready(function(){

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
		// Engineer concept purged; customer change needs no dependent fill.
	});


	
	$('#detailsgrid').DataTable({
		
		dom: 'Blfript', // Blfrtip
            buttons:
            [
                {
                    extend: 'pdf',
                    footer: true,
                    className: 'green glyphicon glyphicon-file',
                    title: 'Report',
                    filename: 'Report',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions:
                    {
                        columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11,12]
                    }
                },
                {
                    extend: 'excel',
                    footer: true, 
                    className: 'green glyphicon glyphicon-list-alt',
                    title: 'Report',
                    filename: 'Report',
                    pageSize: 'LEGAL',
                    exportOptions:
                    {
                        columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11,12]
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
                            columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11,12]
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
				url :"gst_invoice_report_grid.php", // json datasource
				type: "post",  // type of method  ,GET/POST/DELETE
				data:{cond:"firstbind"},
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
	
		$.ajax({
			type: "POST",
			url: "gst_invoice_report_total_amount.php",
			dataType:'JSON',
			data:{cond:"firstbind"},
			success: function(result) {
					
				$("#report_total_amount").html(result.report_total_amount);
				$("#report_grand_total_amount").html(result.report_grand_total_amount);
				$("#report_total_qty").html(result.report_total_qty);
				$("#report_total_discount_amount").html(result.report_total_discount_amount);
				$("#report_gst_total_amount").html(result.report_gst_total_amount);

			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
		
		
		
		
		$("#search").click(function(e){
			e.preventDefault();
			var fdatefullvalue= $("#sfdate2").val();
			var fdatevalue = fdatefullvalue.split('/')[0];
			var fmonthvalue = fdatefullvalue.split('/')[1];
			var fyearvalue = fdatefullvalue.split('/')[2];
			
			var tdatefullvalue= $("#stdate2").val();
			var tdatevalue = tdatefullvalue.split('/')[0];
			var tmonthvalue = tdatefullvalue.split('/')[1];
			var tyearvalue = tdatefullvalue.split('/')[2];

			console.log(fmonthvalue+'/'+fdatevalue+'/'+fyearvalue);
			console.log(tmonthvalue+'/'+tdatevalue+'/'+tyearvalue);
			console.log($("#supplier_id").val());
		
		$("#detailsgrid").dataTable().fnDestroy();
		$('#detailsgrid').DataTable({
			dom: 'lBfrtip',
			buttons: [
				{
					extend: 'excel',
					title: 'Report Details',
					exportOptions: {
						columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11,12]
					}
				},
				'print',
				{
					extend: 'pdf',
					title: ' Report Details',
					exportOptions: {
						columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11,12]
					}
				}
			],
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"pageLength": -1,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
          "ajax":{
             url :"gst_invoice_report_grid.php", // json datasource
             type: "post",  // type of method  ,GET/POST/DELETE
 			data:{cond:"searchbind",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue,customer_id:$("#customer_id").val(),vehicle_no:$("#vehicle_no").val()},
				error:function(xhr,status,error){
					console.log(JSON.stringify(xhr,status,error));
				}
          }
		  });
		  
		$(".dataTables_wrapper").addClass('row');
		$(".dataTables_length").addClass('col-md-6 col-xs-12').css('margin-top','50px');
		$(".dataTables_filter").addClass('col-md-6 col-xs-12').css('margin-top','50px');
		$(".buttons-html5").addClass('btn btn-success');
		$(".dt-button").addClass('btn btn-success');
		$(".dt-buttons").css('position','absolute').css('left','20px');
		
		$.ajax({
			type: "POST",
			url: "gst_invoice_report_total_amount.php",
			dataType:'JSON',
			data:{cond:"searchbind",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue,customer_id:$("#customer_id").val(),vehicle_no:$("#vehicle_no").val()},
			success: function(result) {
					
				$("#report_total_amount").html(result.report_total_amount);
				$("#report_grand_total_amount").html(result.report_grand_total_amount);
				$("#report_total_qty").html(result.report_total_qty);
				$("#report_total_discount_amount").html(result.report_total_discount_amount);
				$("#report_gst_total_amount").html(result.report_gst_total_amount);

			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});

		

	});

		// $(".dataTables_wrapper").addClass('row');
		// $(".dataTables_length").addClass('col-md-6 col-xs-12').css('margin-top','50px');
		// $(".dataTables_filter").addClass('col-md-6 col-xs-12').css('margin-top','50px');
		// $(".buttons-html5").addClass('btn btn-success');
		// $(".dt-button").addClass('btn btn-success');
		// $(".dt-buttons").css('position','absolute').css('left','20px');
		
});
</script>



</html>