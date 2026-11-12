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
            <h4>Staff Rights</h4>
                    </div>
    </div>
	<div class="row">
        <div class="col-md-12">
			<div class="card">
                <div class="card-body" style="padding-top:10px;padding-bottom:5px;">
					<form id="mainform" method="POST" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-12 col-lg-12 col-xs-12">
								<div class="card" style="margin-bottom:10px">
									<div class="card-header text-center" style="padding:3px"><h4 style="font-weight:bold;margin-bottom:0"></h4></div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Staff Name :</label>
									<select class="form-control js-example-basic-single select2-hidden-accessible" name="emp_id" id="emp_id" style="padding-top:2px">
										<option value="">Select Staff</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Username : <span id="unameshow" style="color:red">@jmt</span></label>
									<input type="text" class="form-control" placeholder="Enter Username" name="uname" id="uname">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Password :</label>
									<input type="text" class="form-control" placeholder="Enter Password" name="pass" id="pass" autocomplete="off">
								</div>
							</div>
							<div class="col-md-12">
								<hr style="margin-top:10px;margin-bottom:15px;border-color:#fff"/>
							</div>
							<div class="col-md-12">
                        <div class="table-responsive" style="width:100%;display:block;overflow-x:auto">
							<table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col"><h5 style="font-weight:bold;position:relative;top:3px">Module</h5></th>
                                    <th scope="col"><h5 style="font-weight:bold;position:relative;top:3px">Add</h5></th>
                                    <th scope="col"><h5 style="font-weight:bold;position:relative;top:3px">Update</h5></th>
                                    <th scope="col"><h5 style="font-weight:bold;position:relative;top:3px">Delete</h5></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-master" value="N" name="chk-module[]" data-emprid=""  data-id="1" data-name="MASTER"><label class="custom-control-label" for="chk-master"><h5 style="font-weight:bold;position:relative;top:3px">Master</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-master-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-master-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-master-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-master-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-master-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-master-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-staff" value="N" name="chk-module[]" data-emprid=""  data-id="2" data-name="STAFF"><label class="custom-control-label" for="chk-staff"><h5 style="font-weight:bold;position:relative;top:3px">Staff</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-staff-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-staff-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-staff-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-staff-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-staff-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-staff-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-Raw_material_purchase" value="N" name="chk-module[]" data-emprid=""  data-id="3" data-name="RAWMATERIALPURCHASE"><label class="custom-control-label" for="chk-Raw_material_purchase"><h5 style="font-weight:bold;position:relative;top:3px">Raw Material Purchase</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-Raw_material_purchase-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-Raw_material_purchase-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-Raw_material_purchase-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-Raw_material_purchase-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-Raw_material_purchase-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-Raw_material_purchase-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-production" value="N" name="chk-module[]" data-emprid=""  data-id="4" data-name="PRODUCTION"><label class="custom-control-label" for="chk-production"><h5 style="font-weight:bold;position:relative;top:3px">Production</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-production-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-production-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-production-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-production-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-production-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-production-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>

								<tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-dc" value="N" name="chk-module[]" data-emprid=""  data-id="5" data-name="DC"><label class="custom-control-label" for="chk-dc"><h5 style="font-weight:bold;position:relative;top:3px">DC</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-dc-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-dc-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-dc-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-dc-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-dc-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-dc-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-gate_pass" value="N" name="chk-module[]" data-emprid=""  data-id="6" data-name="GATEPASS"><label class="custom-control-label" for="chk-gate_pass"><h5 style="font-weight:bold;position:relative;top:3px">Gate Pass</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-gate_pass-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-gate_pass-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-gate_pass-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-gate_pass-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-gate_pass-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-gate_pass-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
								<tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-gst_invoide" value="N" name="chk-module[]" data-emprid=""  data-id="7" data-name="GSTINVOICE"><label class="custom-control-label" for="chk-gst_invoide"><h5 style="font-weight:bold;position:relative;top:3px">GST Invoice</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-gst_invoide-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-gst_invoide-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-gst_invoide-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-gst_invoide-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-gst_invoide-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-gst_invoide-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-receipt" value="N" name="chk-module[]" data-emprid=""  data-id="8" data-name="RECEIPT"><label class="custom-control-label" for="chk-receipt"><h5 style="font-weight:bold;position:relative;top:3px">Receipt</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-receipt-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-receipt-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-receipt-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-receipt-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-receipt-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-receipt-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-eway" value="N" name="chk-module[]" data-emprid=""  data-id="9" data-name="EWAY"><label class="custom-control-label" for="chk-eway"><h5 style="font-weight:bold;position:relative;top:3px">E-Way</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-eway-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-eway-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-eway-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-eway-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-eway-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-eway-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
                                <tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-attendance" value="N" name="chk-module[]" data-emprid=""  data-id="10" data-name="ATTENDANCE"><label class="custom-control-label" for="chk-attendance"><h5 style="font-weight:bold;position:relative;top:3px">Attendance</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-attendance-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-attendance-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-attendance-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-attendance-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-attendance-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-attendance-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
								<tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-income_expense" value="N" name="chk-module[]" data-emprid=""  data-id="11" data-name="INCOMEEXPENSE"><label class="custom-control-label" for="chk-income_expense"><h5 style="font-weight:bold;position:relative;top:3px">Income Expense</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-income_expense-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-income_expense-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-income_expense-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-income_expense-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-income_expense-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-income_expense-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
								<tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-bank_income_expense" value="N" name="chk-module[]" data-emprid=""  data-id="12" data-name="BANKINCOMEEXPENSE"><label class="custom-control-label" for="chk-bank_income_expense"><h5 style="font-weight:bold;position:relative;top:3px">Bank Income Expense</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-bank_income_expense-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-bank_income_expense-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-bank_income_expense-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-bank_income_expense-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-bank_income_expense-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-bank_income_expense-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>
								<tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-entry_details" value="N" name="chk-module[]" data-emprid=""  data-id="13" data-name="ENTRYDETAILS"><label class="custom-control-label" for="chk-entry_details"><h5 style="font-weight:bold;position:relative;top:3px">Entry Details</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-entry_details-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-entry_details-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-entry_details-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-entry_details-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-entry_details-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-entry_details-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>

								<tr>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-report" value="N" name="chk-module[]" data-emprid=""  data-id="14" data-name="REPORT"><label class="custom-control-label" for="chk-report"><h5 style="font-weight:bold;position:relative;top:3px">Report</h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-report-ins" value="N" name="chk-ins[]"><label class="custom-control-label" for="chk-report-ins"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-report-upd" value="N" name="chk-upd[]"><label class="custom-control-label" for="chk-report-upd"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                    <td><div class="custom-control custom-checkbox custom-checkbox-success"><input type="checkbox" class="custom-control-input" id="chk-report-del" value="N" name="chk-del[]"><label class="custom-control-label" for="chk-report-del"><h5 style="font-weight:bold;position:relative;top:3px"></h5></label></div></td>
                                </tr>

								
                                </tbody>
                            </table>
						</div>
							</div>
						<div class="col-md-12 text-center">
							<span id="msg" style="font-weight:bold;color:red"></span>
						</div>
						<div class="col-md-12 text-center">
							<button type="button" name="submit" id="submit" class="btn btn-success" style="margin-bottom:5px;font-weight:bold;">Save</button>
							<button type="button" id="submitdel" class="btn btn-danger" style="margin-bottom:5px;display:none;font-weight:bold;">Delete</button>
						</div>
						</div>
                    </form>
				</div>
				<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
				<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
            </div>
		</div>
	</div>
<input type="hidden" name="modulenamebox" id="modulenamebox" value="2">
<input type="hidden" name="rightsbox" id="rightsbox">
</main>
<!-- end::main content -->
<?php include("footer.php") ?>
<!-- end::main content -->

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

<!-- begin::custom scripts -->
<script src="js/custom.js"></script>
<script src="js/app.min.js"></script>
<script src="js/examples/sweet-alert.js"></script>
<!-- end::custom scripts -->

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
}

@media(max-width:480px){
	nav.navbar .header-logo a img{
		width:180px;
	}
}

</style>
<script>
function rightsValidation(){
	$('input[name="chk-module[]"],input[name="chk-ins[]"],input[name="chk-upd[]"],input[name="chk-del[]"]').prop('checked',false);
	$('input[name="chk-ins[]"],input[name="chk-upd[]"],input[name="chk-del[]"]').attr('disabled','disabled');
	$('input[name="chk-module[]"]').data("emprid","");
	$("#submitdel").hide();
}
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
	
$('input[name="chk-ins[]"],input[name="chk-upd[]"],input[name="chk-del[]"]').attr('disabled','disabled');
$('input[name="chk-module[]"]').click(function(){
	var i=$('input[name="chk-module[]"]').index(this);
	if(this.checked){
		$('input[name="chk-ins[]"]').eq(i).removeAttr('disabled');
		$('input[name="chk-ins[]"]').eq(i).prop('checked',true);
		$('input[name="chk-upd[]"]').eq(i).removeAttr('disabled');
		$('input[name="chk-upd[]"]').eq(i).prop('checked',true);
		$('input[name="chk-del[]"]').eq(i).removeAttr('disabled');
		$('input[name="chk-del[]"]').eq(i).prop('checked',true);
	}
	else{
		$('input[name="chk-ins[]"]').eq(i).prop('checked',false);
		$('input[name="chk-ins[]"]').eq(i).attr('disabled','disabled');
		$('input[name="chk-upd[]"]').eq(i).prop('checked',false);
		$('input[name="chk-upd[]"]').eq(i).attr('disabled','disabled');
		$('input[name="chk-del[]"]').eq(i).prop('checked',false);
		$('input[name="chk-del[]"]').eq(i).attr('disabled','disabled');
	}
});

$("#uname").keyup(function(){
	$("#unameshow").html($("#uname").val()+"@jmt");
});	
	
		
$("#emp_id").empty();
$.ajax({
		type: "POST",
		url: "phpservices/staff_dropdown.php",
		success: function(result) {
		if(result.s_id){
			var sid=result.s_id;
			var sname=result.s_name;
			var d_length=result.s_id.length;
			var d_data='<option value="">Select Staff</option>';
			for(var i=0;i<=d_length-1;i++){
				d_data +='<option value="'+sid[i]+'">'+sname[i]+'</option>';
			}
			$("#emp_id").removeAttr("disabled");
			$("#emp_id").append(d_data);		
			$("#grid-loader").hide();
		}
		else{	
			$("#grid-loader").hide();
		}
		}							
});		
		
$("#emp_id").change(function(e){
		rightsValidation();
		$("#uname").val('');
		$("#unameshow").html('@jmt');
		$("#pass").val('');
		var empid=$(this).val();
		if(empid!=""){
			$.ajax({
				type:"POST",
				data:{req:"RAUB",empid:empid},
				url:"phpservices/employee_functions.php",
				dataType:"JSON",
				success:function(result){
					if(result.op!=''){
					$("#submitdel").show();
					$.each(result.op, function (key, val) {
					$("#unameshow").html(val['uname']);
					$("#uname").val(val['uname']);
					$("#pass").val(val['pass']);
					//alert(val['module_id']+'-'+val['module_status']+'-'+val['emprt_id']);
					$('input[name="chk-module[]"]').eq(val['module_id']).data("emprid",val['emprt_id']);
					  if(val['module_status']=='Y'){
						if(val['module_id']=='1'){
							  $('#chk-master').prop('checked',true);
							  $('#chk-master-ins').removeAttr('disabled');
							  $('#chk-master-upd').removeAttr('disabled');
							  $('#chk-master-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-master-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-master-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-master-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='2'){
							  $('#chk-staff').prop('checked',true);
							  $('#chk-staff-ins').removeAttr('disabled');
							  $('#chk-staff-upd').removeAttr('disabled');
							  $('#chk-staff-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-staff-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-staff-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-staff-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='3'){
							  $('#chk-stock').prop('checked',true);
							  $('#chk-stock-ins').removeAttr('disabled');
							  $('#chk-stock-upd').removeAttr('disabled');
							  $('#chk-stock-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-stock-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-stock-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-stock-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='4'){
							  $('#chk-purchase').prop('checked',true);
							  $('#chk-purchase-ins').removeAttr('disabled');
							  $('#chk-purchase-upd').removeAttr('disabled');
							  $('#chk-purchase-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-purchase-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-purchase-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-purchase-del').prop('checked',true);
							  }
						}
						
						if(val['module_id']=='5'){
							  $('#chk-dc').prop('checked',true);
							  $('#chk-dc-ins').removeAttr('disabled');
							  $('#chk-dc-upd').removeAttr('disabled');
							  $('#chk-dc-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-dc-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-dc-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-dc-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='6'){
							  $('#chk-payment').prop('checked',true);
							  $('#chk-payment-ins').removeAttr('disabled');
							  $('#chk-payment-upd').removeAttr('disabled');
							  $('#chk-payment-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-payment-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-payment-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-payment-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='7'){
							  $('#chk-receipt').prop('checked',true);
							  $('#chk-receipt-ins').removeAttr('disabled');
							  $('#chk-receipt-upd').removeAttr('disabled');
							  $('#chk-receipt-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-receipt-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-receipt-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-receipt-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='8'){
							  $('#chk-purchase_rpt').prop('checked',true);
							  $('#chk-purchase_rpt-ins').removeAttr('disabled');
							  $('#chk-purchase_rpt-upd').removeAttr('disabled');
							  $('#chk-purchase_rpt-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-purchase_rpt-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-purchase_rpt-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-purchase_rpt-del').prop('checked',true);
							  }
						}
						if(val['module_id']=='9'){
							  $('#chk-sales_rpt').prop('checked',true);
							  $('#chk-sales_rpt-ins').removeAttr('disabled');
							  $('#chk-sales_rpt-upd').removeAttr('disabled');
							  $('#chk-sales_rpt-del').removeAttr('disabled');
							   if(val['ins']=='Y'){
								$('#chk-sales_rpt-ins').prop('checked',true);
							  }
							  if(val['upd']=='Y'){
								$('#chk-sales_rpt-upd').prop('checked',true);
							  }
							  if(val['del']=='Y'){
								$('#chk-sales_rpt-del').prop('checked',true);
							  }
						}						
						
					  }
					});
					}
					else{
						$("#submitdel").hide();
					}
				},
				error:function(xhr,status,error){
					console.log(xhr.responseText + error);
					
				}
			});
		}
		else{
			rightsValidation();
		}
});

$("#uname").blur(function(e){
		e.preventDefault();
		var uname=$("#unameshow").html();
		if($("#uname").val()!=''){
			$.ajax({
						type: "POST",
						url: "phpservices/employee_username_check.php",
						dataType:'json',
						data: {uname:uname},
						success: function(result) {
							if(result.op==0){
								$("#msg").css("color","green").html("Username is Available");
								$("#unamecheck").val('1');
							}
							else if(result.op>0){
								$("#msg").css("color","red").html("Username Already Exists !");
								$("#unamecheck").val('');
							}
							else{
								$("#msg").html(result.op);
							}
						},error:function(xhr,status,error){
							console.log(JSON.stringify(xhr,status,error));
						}
					});
		}
});

$("#submit").click(function(e){
	e.preventDefault();		
	var emprights=$("#rightsbox").val();
	if (emprights == '1' || emprights == '5' || emprights == '6' || emprights == '7' || '<?php echo $log;?>' == 'admin') {
		if($("#emp_id").val()=='' || $("#emp_id").val()==null){
			$("#msg").html('* Choose Staff Name');
			setTimeout(function(){$("#msg").html('');},2500);
			return false;
		}
		else if($("#uname").val()==''){
			$("#msg").html('* Enter Username');
			setTimeout(function(){$("#msg").html('');},2500);
			return false;
		}
		else if($("#pass").val()==''){
			$("#msg").html('* Enter Password');
			setTimeout(function(){$("#msg").html('');},2500);
			return false;
		}
		else{
			$("#msg").html('* Processing. . .');
			$.ajax({
						type: "POST",
						url: "phpservices/employee_username_check.php",
						dataType:'json',
						data: {uname:$("#unameshow").html(),emp_id:$("#emp_id").val()},
						success: function(result) {
							if(result.op==0){
								$("#msg").css("color","green").html("Username is Available");
								var md_data=new Array();
								$('input[name="chk-module[]"]').each(function(i) {
									var mid=$('input[name="chk-module[]"]').eq(i).data('id');
									var mname=$('input[name="chk-module[]"]').eq(i).data('name');
									var memprid=$('input[name="chk-module[]"]').eq(i).data('emprid');
									var chkmod='N';
									var chkins='N';
									var chkupd='N';
									var chkdel='N';
									if(this.checked){
										chkmod='Y';
									}
									if($('input[name="chk-ins[]"').eq(i).prop('checked')==true){
										chkins='Y';
									}
									if($('input[name="chk-upd[]"').eq(i).prop('checked')==true){
										chkupd='Y';
									}
									if($('input[name="chk-del[]"').eq(i).prop('checked')==true){
										chkdel='Y';
									}
									md_data.push([mid,mname,chkmod,chkins,chkupd,chkdel,memprid]);
								});
								console.log(md_data);

								
								$.ajax({
										type: "POST",
										url: "phpservices/employee_functions.php",
										dataType:'JSON',
										data: {req:"ADDRIGHTS",data1:md_data,data2:$("#emp_id").val(),uname:$("#uname").val(),pass:$("#pass").val()},
										success: function(result) {
											if(result.op==1){
												$(".sweet-insert").click();
												$("#msg").html('Saved Successfully');
												setTimeout(function(){location.reload()},1500);
											}
											else{
												$("#msg").html(result.op);
											}
										},
										error:function(xhr,status,error){
											console.log(JSON.stringify(xhr,status,error));
										}
									});
							}
							else if(result.op>0){
								$("#msg").css("color","red").html("Username Already Exists !");
								$("#unamecheck").val('');
							}
							else{
								$("#msg").html(result.op);
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

$("#submitdel").click(function(e){
	e.preventDefault();		
	var emprights=$("#rightsbox").val();
	if(emprights=='1' || emprights=='5' || emprights=='2' || emprights=='3' || '<?php echo $log;?>' == 'admin'){
		var alertmsg=confirm("Do you want to Delete ?");
		if (alertmsg == true) {
			if($("#emp_id").val()=='' || $("#emp_id").val()==null){
				$("#msg").html('* Choose Employee Name');
				setTimeout(function(){$("#msg").html('');},2500);
				return false;
			}
			else{
				$.ajax({
						type: "POST",
						url: "phpservices/employee_functions.php",
						dataType:'JSON',
						data: {req:"DELRIGHTS",data1:$("#emp_id").val()},
						success: function(result) {
							if(result.op==1){
								$(".sweet-delete").click();
								$("#msg").html('Deleted Successfully');
								setTimeout(function(){location.reload()},2500);
							}
							else{
								$("#msg").html(result.op);
							}
						},
						error:function(xhr,status,error){
							console.log(JSON.stringify(xhr,status,error));
						}
					});
			}
		}
	}
	else{
		swal("Error!", "Access Denied! Contact Admin...", "error");
		return false;
	}
});	
	
});
</script>
</html>