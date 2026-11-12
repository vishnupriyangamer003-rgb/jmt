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
            <h4>Bank Income Expense Details Details</h4>
           
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body">
                    <form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">

								<?php
									$sql="select date_format(billing_date,'%d/%m/%Y') as billing_date,bank_id from tbl_bank_income_expense_details where delete_status='NDL' and billing_date='".$_GET['id']."'";
									$exec_sql=mysqli_query($conn,$sql);
									$fetch_sql=mysqli_fetch_array($exec_sql);
								?>


							<div class="col-md-6">								                          
                                    
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-right">Select Bank :</label>
									<div class="col-sm-5">
										<select class="form-control bank_id" id="bank_id" name="bank_id" style="margin:0;">
											<option value="">Select </option>
												<?php
													$sql_product="select * from tbl_bank_details where delete_status='NDL'";
													$exec_sql_product=mysqli_query($conn,$sql_product); 
													while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
													<option value="<?php  echo $fetch_sql_product['id'] ?>"<?php if(($fetch_sql_product['id']) ==(($fetch_sql['bank_id']))) echo "selected" ?>><?php echo $fetch_sql_product['bank_name'] ?></option>
													<?php }  ?>
										</select>
									</div>
								</div>	
                                    
                            </div>													

							<div class="col-md-6">
									
								
								

										
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-5 col-form-label text-right">Date :</label>
									<div class="col-sm-5">
										<input type="text" id="order_date" class="form-control" placeholder="Date" name="order_date" value="<?php echo $fetch_sql['billing_date']; ?>" >
										<!-- <input type="hidden" name="service_order_date" id="service_order_date"> -->
									</div>
								</div>	
																		
                                    
                            </div>

							<div class="col-md-6">

								<table id="detailsgrid1" class="table table-striped table-bordered" width="50%" cellspacing="0" style="overflow-x:auto;display:block;margin-bottom:0;border: none;">
										<thead>
											<tr>
												<th style="width: 15%">Income Details</th>	
												<th style="width: 5%">Amount</th>
												<th style="width: 5%">Action</th>
											</tr>
										</thead>
										<tbody id="tablemainbind1">
										<?php
											$sql="SELECT a.*  FROM tbl_bank_income_expense_details  a WHERE  a.delete_status!='0' and a.income_expense_type='Income' and a.billing_date='".$_GET['id']."'";
											$exec_sql=mysqli_query($conn,$sql);
											$i=0;
											
											while($fetch_zql=mysqli_fetch_array($exec_sql)){
										?>

											<tr class="trtag" id="trtag<?php echo $i+1;?>">
											
												<td style="padding:5px">
													<select class="form-control" id="income_header_id_0" name="income_header_id[]">
													<option value="">Select product</option>
														<?php
															$sql_product="SELECT id,income_header_name FROM tbl_income_header where delete_status='NDL' order by id desc";
															$exec_sql_product=mysqli_query($conn,$sql_product); 
															while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
															<option value="<?php  echo $fetch_sql_product['id'] ?>"<?php if(($fetch_sql_product['id']) ==(($fetch_zql['header_id']))) echo "selected" ?>><?php echo $fetch_sql_product['income_header_name'] ?></option>
															<?php }  ?>

													</select>
													
													
												</td>
												<td style="padding:5px">
													<input type="text" id="income_amount_0" class="form-control income_amount" name="income_amount[]" value="<?php echo $fetch_zql['amount'];?>" >
													
													
												</td>
												
												<td style="padding:5px;text-align:center">
													<a href="#" class="trtag1" data-value=<?php echo $i+1;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
												</td>
											</tr>
											<?php  $i++; }?>
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
												<th style="width: 15%">Expense Details</th>	
												<th style="width: 5%">Amount</th>
												<th style="width: 5%">Action</th>
											</tr>
										</thead>
										<tbody id="tablemainbind2">
										<?php
											$sql="SELECT a.*  FROM tbl_bank_income_expense_details  a WHERE  a.delete_status!='0' and a.income_expense_type='Expense' and a.billing_date='".$_GET['id']."'";
											$exec_sql=mysqli_query($conn,$sql);
											$j=50;
											
											while($fetch_zql=mysqli_fetch_array($exec_sql)){
										?>
											<tr class="trtag" id="trtag<?php echo $j+1;?>">
											
												<td style="padding:5px">
													<select class="form-control" id="expense_header_id_0" name="expense_header_id[]">
													<option value="">Select product</option>
														<?php
															$sql_product="SELECT id,income_header_name FROM tbl_income_header where delete_status='NDL' order by id desc";
															$exec_sql_product=mysqli_query($conn,$sql_product); 
															while($fetch_sql_product=mysqli_fetch_array($exec_sql_product)){?>
															<option value="<?php  echo $fetch_sql_product['id'] ?>"<?php if(($fetch_sql_product['id']) ==(($fetch_zql['header_id']))) echo "selected" ?>><?php echo $fetch_sql_product['income_header_name'] ?></option>
															<?php }  ?>

													</select>
													
													
												</td>

												
												<td style="padding:5px">
													<input type="text" id="expense_amount_0" class="form-control expense_amount" name="expense_amount[]" value="<?php echo $fetch_zql['amount'];?>" >
													
													
												</td>
												
												<td style="padding:5px;text-align:center">
													<a href="#" class="trtag1" data-value=<?php echo $j+1;?>><i class="fa fa-trash" style="color:red;font-size:22px;margin-top:5px;text-align:center"></i></a>
												</td>
											</tr>
											<?php  $j++; }?>
										</tbody>
										<tfoot id="taxbind2">
											<tr class="taxdiv" id="taxdiv0">
												<th></th>
												<th></th>										
												<th colspan="1" style="border:none">
													<a href="javascript:void(0)" class="btn btn-success trtag2" onclick="qualaddfunc2()" ><i class="fa fa-plus-circle" style="color:white;"></i><span style="color:white">&nbsp;Add</span></a>
												</th>
											
											</tr>
										
											

										</tfoot>			


									</table>

								</div>

							
							
							
						<br>
							<div class="col-md-12 text-center">
								<div class="form-group">
									<input type="hidden" name="req" id="req">
									<input type="hidden" name="billing_date" id="billing_date" value=<?php echo $_GET['id'];?>>
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



	

	$("#resetbut").click(function(){
		$("#gal_cat_id").val('');
		$("#title").val('');
		$("#photo").val('');
		$("#photo_name").val('');
		$("#imgpreview").html('<label>Image Preview :</label><img src="media/image/no_image.png" style="width:100px;margin-left:4px">');
		$("#resetbut").css('outline','none');
		$("#resetbut").css('box-shadow','none');
	});


		var ids_string='<?php echo $_GET['id']; ?>';
		console.log(ids_string);
		$(".page-loader").show();
		$.ajax({
			type: "POST",
			url: "bank_income_expense_service.php",
			dataType:'json',
			data: {billing_date:ids_string,req:"AUB"},
			success: function(result) {						
				console.log(result);
				//$("#order_date").val(result.op[0]['billing_date']);
				
				$(".page-loader").hide();
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});

		

	$(".income_header_id").empty();
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
			$("#req").val('UPD');
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

	

	
		
 	
	

		
		
});

function qualaddfunc1(){
	var count = document.getElementsByClassName("trtag").length;
	$("#tablemainbind1").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control income_labour_id" name="income_header_id[]" id="income_header_id_'+count+'"></select></td>	 <td style="padding:5px;text-align:center"><input type="text" id="income_amount_'+count+'" class="form-control income_amount" name="income_amount[]" ></td>	<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');

	$("#income_header_id_"+count).empty();
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
	$("#tablemainbind2").append('<tr class="trtag" id="trtag'+count+'"> <td style="padding:5px"><select class="form-control expense_header_id" name="expense_header_id[]" id="expense_header_id_'+count+'"></select></td>	 <td style="padding:5px;text-align:center"><input type="text" id="expense_amount_'+count+'" class="form-control expense_amount" name="expense_amount[]" ></td>	<td style="padding:5px;text-align:center"> 										<a href="#"  data-value='+count+' class="trtag1"><i class="fa fa-trash" style="color:red;font-size:22px;margin:0.75rem 0"></i></a> 									</td> 								</tr>');
	
	$("#expense_header_id_"+count).empty();
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