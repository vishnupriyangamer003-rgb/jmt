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
            <h4>Bank Income Expense Details</h4>
           
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
									<label for="staticEmail" class="col-sm-5 col-form-label text-right">Select Bank :</label>
									<div class="col-sm-5">
											<select  class="form-control js-example-basic-single select2-hidden-accessible" id="bank_id" name="bank_id" >
											
											</select>
									</div>
								</div>	

								

                                    
                            </div>													

							<div class="col-md-6">
									
									
										
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-right">Date :</label>
									<div class="col-sm-5">
										<input type="text" id="order_date" class="form-control" placeholder="Date" name="order_date" >
										<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
									</div>
								</div>	
																		
                                    
                            </div>

							<div class="col-md-6">

								<table id="detailsgrid1" class="table table-striped table-bordered" width="50%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
										<thead>
											<tr>
												<th style="width: 15%">Income Details <a href="income_header_details.php">&nbsp;<i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a></th>	
												<th style="width: 5%">Amount</th>
												<th style="width: 5%">Action</th>
											</tr>
										</thead>
										<tbody id="tablemainbind1">
											<tr class="trtag" id="trtag0">
											
												<td style="padding:5px">
													<select class="form-control js-example-basic-single select2-hidden-accessible income_header_id" id="income_header_id_0" name="income_header_id[]">
													</select>
													
													
												</td>
												<td style="padding:5px">
													<input type="text" id="income_amount_0" class="form-control income_amount" name="income_amount[]" >
													
													
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
												<th colspan="1" style="border:none">
													<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc1()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
												</th>
											
											</tr>
										
											

										</tfoot>			


									</table>

								</div>

								<div class="col-md-6">

								<table id="detailsgrid1" class="table table-striped table-bordered" width="50%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
										<thead>
											<tr>
												<th style="width: 15%">Expense Details <a href="income_header_details.php">&nbsp;<i class="fa fa-plus-circle" style="font-size:25px; position:absolute; margin-left:2px;color:red;"></i></a></th>	
												<th style="width: 5%">Amount</th>
												<th style="width: 5%">Action</th>
											</tr>
										</thead>
										<tbody id="tablemainbind2">
											<tr class="trtag" id="trtag0">
											
												<td style="padding:5px">
													<select class="form-control js-example-basic-single select2-hidden-accessible expense_header_id" id="expense_header_id_0" name="expense_header_id[]">
													</select>
													
													
												</td>
												<td style="padding:5px">
													<input type="text" id="expense_amount_0" class="form-control expense_amount" name="expense_amount[]" >
													
													
												</td>
												
												<td style="padding:5px;text-align:center">
													<a href="#" class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
												</td>
											</tr>
										</tbody>
										<tfoot id="taxbind2">
											<tr class="taxdiv" id="taxdiv0">
												<th></th>
												<th></th>										
												<th colspan="1" style="border:none">
													<a href="javascript:void(0)" class="btn btn-success trtag1" onclick="qualaddfunc2()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
												</th>
											
											</tr>
										
											

										</tfoot>			


									</table>

								</div>

							
							
							
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


	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                   <table id="detailsgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
						<tr>
							<th>S.no</th> 
							<th>Date</th> 
							<th>Income&nbsp;Amount</th>    
							<th>Expense&nbsp;Amount</th>    
							
							<th>Action</th>
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
							<td><div class="btn-group" role="group" aria-label="Basic example">
									<button type="button" class="btn btn-success">
										<i class="fa fa-edit" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
									</button>
									<button type="button" class="btn btn-danger">
										<i class="fa fa-trash" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
									</button>
								</div>
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Suresh</td>
							<td>Mahesh</td>
							
							<td>TN44 CG 1589</td>
							<td>002</td>
							<td>25-01-2023</td>
							<td>2500</td>
							<td><div class="btn-group" role="group" aria-label="Basic example">
									<button type="button" class="btn btn-success">
										<i class="fa fa-edit" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
									</button>
									<button type="button" class="btn btn-danger">
										<i class="fa fa-trash" style="color: #fff;padding: 0;margin: 0;font-size: 18px;"></i>
									</button>
								</div>
							</td>
						</tr-->
					</tbody>
					
                </table>
                </div>
            </div>
		</div>
	</div>

</main>
<!-- end::main content -->

<div class="modal fade" id="incomeModalCenter" tabindex="-1" role="dialog"
		aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #000321;color: #fff;">
				<h5 class="modal-title" id="exampleModalCenterTitle">Bank Income Expense Header Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<form id="income_mainform" method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Name :</label><span style="color:red">*</span>
										<input type="text" class="form-control" id="income_header_name" name="income_header_name" placeholder="Enter Income and Expense Header">
									</div>
								</div>								

								
								<div class="col-md-3">
									<span id="cus_msg" style="font-weight:bold;float:right;margin-top:27px;"></span>
								</div>
							</div>
							<div class='row'>
							
								<div class="col-md-4">
									<div class="form-group">
										<input type="hidden" name="req" id="income_req">
										<button type="submit" name="income_submit" id="income_submit" class="btn btn-success">Save</button>									
										
									</div>
								</div>
							</div>
						</form>
						<hr style="margin:15px 0 10px 0;"/>
						<table id="incomeheadergrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Name</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
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


<input type="hidden" name="modulenamebox" id="modulenamebox" value="12">
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

	
	function reloadIncomeDropdowns() {
		$.ajax({
			type: "POST",
			url: "income_expense_dropdown.php",
			success: function(result) {
				if(result && result.income_header_id) {
					var income_header_id=result.income_header_id;
					var income_header_name=result.income_header_name;
					var d_data="<option value=\"\">Select Income Header</option>";
					for(var i=0;i<income_header_id.length;i++){
						d_data +="<option value=\""+income_header_id[i]+"\">"+income_header_name[i]+"</option>";
					}
					$(".income_header_id").empty().append(d_data).removeAttr("disabled");
					
					var d_exp="<option value=\"\">Select Expense Header</option>";
					for(var i=0;i<income_header_id.length;i++){
						d_exp +="<option value=\""+income_header_id[i]+"\">"+income_header_name[i]+"</option>";
					}
					$(".expense_header_id").empty().append(d_exp).removeAttr("disabled");
				}
				$(".page-loader").hide();	
			}							
		});
	}

	if (!$.fn.DataTable.isDataTable("#incomeheadergrid")) {
		$("#incomeheadergrid").DataTable({
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"ajax": {
				url: "income_header_grid.php",
				type: "post",
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
				}
			}
		});
	}

	$("#incomeModalCenter").on("shown.bs.modal", function() {
		if ($.fn.DataTable.isDataTable("#incomeheadergrid")) {
			$("#incomeheadergrid").DataTable().columns.adjust().responsive.recalc();
		}
	});

	$(document).on("click", "#incomeheadergrid .deleteTriger", function(e) {
		e.preventDefault();
		e.stopPropagation();
		var delid = $(this).attr("data-value") || $(this).data("value") || $(this).closest("[data-value]").attr("data-value");
		var alertmsg = confirm("Do you want to Delete this Header?");
		if (alertmsg == true) {
			$.ajax({
				type: "POST",
				url: "income_header_service.php",
				dataType: "json",
				data: { delid: delid, req: "DEL" },
				success: function(result) {
					if (result.op == 1 || result.op == true) {
						if (typeof swal === "function") {
							swal("Success!", "Successfully Deleted !", "success");
						} else {
							alert("Successfully Deleted !");
						}
						$("#incomeheadergrid").DataTable().ajax.reload(null, false);
						if ($.fn.DataTable.isDataTable("#detailsgrid")) {
							$("#detailsgrid").DataTable().ajax.reload(null, false);
						}
						if (typeof reloadIncomeDropdowns === "function") {
							reloadIncomeDropdowns();
						}
					} else {
						alert("Delete failed");
					}
				},
				error: function(xhr, status, error) {
					console.log(JSON.stringify(xhr, status, error));
				}
			});
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


	$('#detailsgrid').DataTable({
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"bank_income_expense_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data: {stock_type:"Stock"},
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
		url: "bank_income_expense_dropdown.php",
		success: function(result) {
			var income_header_id=result.income_header_id;
			var income_header_name=result.income_header_name;
			var d_length=result.income_header_id.length;
			var d_data='<option value="">Select Income Header </option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+income_header_id[i]+'">'+income_header_name[i]+'</option>';
				
			}
			$(".income_header_id").removeAttr("disabled");
			$(".income_header_id").append(d_data);
			$(".page-loader").hide();	
		}							
	});

	$.ajax({
		
		type: "POST",
		url: "bank_income_expense_dropdown.php",
		success: function(result) {
			var income_header_id=result.income_header_id;
			var income_header_name=result.income_header_name;
			var d_length=result.income_header_id.length;
			var d_data='<option value="">Select Expense Header </option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+income_header_id[i]+'">'+income_header_name[i]+'</option>';
				
			}
			$(".expense_header_id").removeAttr("disabled");
			$(".expense_header_id").append(d_data);
			$(".page-loader").hide();	
		}							
	});
	

	$.ajax({
		
		type: "POST",
		url: "bank_dropdown.php",
		success: function(result) {
			var bank_id=result.bank_id;
			var bank_name=result.bank_name;
			var d_length=result.bank_id.length;
			var d_data='<option value="">Select Bank Name </option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+bank_id[i]+'">'+bank_name[i]+'</option>';
				
			}
			$("#bank_id").removeAttr("disabled");
			$("#bank_id").append(d_data);
			$(".page-loader").hide();	
		}							
	});


	
	$("#income_submit").click(function(e){
		e.preventDefault();
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
			if($("#income_header_name").val()==''){
				swal("Error!", " Enter Income Expense Name !", "warning");
				return false;
			}
			else{
				$("#income_req").val('ADDINCOMEINS');
				$.ajax({
					type: "POST",
					url: "income_expense_service.php",
					dataType:'json',
					data: $("#income_mainform").serialize(),
					success: function(result) {
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							$("#income_header_name").val("");
							$("#incomeheadergrid").DataTable().ajax.reload();
							reloadIncomeDropdowns();
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


			

	
	

	$("#submit").click(function(e){
		e.preventDefault();
		
		//alert($("#order_date").val());
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin'){
		if($("#order_date").val()==''){
			swal("Error!", "Select Date !", "warning");
			setTimeout(function(){$("#msg").html('')},3000);
			return false;
		}else{
			$("#req").val('ADDINS');
			//$("#req").val('PACKING_PRINTING_INS');
			$("#msg").css("color","green").html("Processing . . .");
			$.ajax({
					type: "POST",
					url: "bank_income_expense_service.php",
					dataType:'json',
					data: $("#mainform").serialize(),
					success: function(result) {
						//console.log(result.op);
						if(result.op==1){
							swal("Success!", "Successfully Saved !", "success");
							setTimeout(function(){
								window.location.href='bank_income_expense_details.php';
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

	

	
		
 	$(document).on('click','.income_expensedeleteTriger', function(){
		var delid=$(this).data('value');
		var alertmsg=confirm("Do you want to Delete ?");
		if (alertmsg == true) {
			$.ajax({
					type: "POST",
					url: "bank_income_expense_service.php",
					dataType:'json',
					data: {delid:delid,req:"DEL"},
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
		}
	});
	

		
		
});

function qualaddfunc1(){
	var count = document.getElementsByClassName("trtag").length;
	$("#tablemainbind1").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control js-example-basic-single select2-hidden-accessible income_labour_id" name="income_header_id[]" id="income_header_id_'+count+'"></select></td>	 <td style="padding:5px;text-align:center"><input type="text" id="income_amount_'+count+'" class="form-control income_amount" name="income_amount[]" ></td>	<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');

	$("#income_header_id_"+count).empty();
	$("#income_header_id_" + count).select2({});
	$.ajax({		
		type: "POST",
		url: "bank_income_expense_dropdown.php",
		success: function(result) {
			var income_header_id=result.income_header_id;
			var income_header_name=result.income_header_name;
			var d_length=result.income_header_id.length;
			var d_data='<option value="">Select Income Header </option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+income_header_id[i]+'">'+income_header_name[i]+'</option>';
				
			}
			$("#income_header_id_"+count).removeAttr("disabled");
			$("#income_header_id_"+count).append(d_data);
			$(".page-loader").hide();	
		}							
	});
	

}
function qualaddfunc2(){
	var count = document.getElementsByClassName("trtag").length;
	$("#tablemainbind2").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control js-example-basic-single select2-hidden-accessible expense_header_id" name="expense_header_id[]" id="expense_header_id_'+count+'"></select></td>	 <td style="padding:5px;text-align:center"><input type="text" id="expense_amount_'+count+'" class="form-control expense_amount" name="expense_amount[]" ></td>	<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');
	
	$("#expense_header_id_"+count).empty();
	$("#expense_header_id_" + count).select2({});
	$.ajax({		
		type: "POST",
		url: "bank_income_expense_dropdown.php",
		success: function(result) {
			var income_header_id=result.income_header_id;
			var income_header_name=result.income_header_name;
			var d_length=result.income_header_id.length;
			var d_data='<option value="">Select Expense Header </option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+income_header_id[i]+'">'+income_header_name[i]+'</option>';
				
			}
			$("#expense_header_id_"+count).removeAttr("disabled");
			$("#expense_header_id_"+count).append(d_data);
			$(".page-loader").hide();	
		}							
	});

}
</script>
</html>