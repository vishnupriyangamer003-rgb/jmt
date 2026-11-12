<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Spares)</title>

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
<style>
	.no-wrap{
			word-break: break-all;
		}
	label{
		color:#fff;
	}
	a:not(.active.list-group-item), a:not(.btn):active, a:not(.btn):focus, a:not(.btn):hover {
		text-decoration: none!important;
		color: #000000;
		outline: 0;
	}
</style>
<?php
	/*$dql="select cr_cus_id,sum(total_amt) as total_purchased_amt,sum(total_received_amt) as total_received_amt,(sum(total_amt)-sum(total_received_amt)) as total_pending_amt from tbl_delivery_challan where delete_status='NDL' and cr_cus_id is not null group by cr_cus_id";
	$exec_dql=mysqli_query($conn,$dql);
	$d=0;
	while($fetch_dql=mysqli_fetch_array($exec_dql)){
		$fql="update tbl_credit_customers set total_pur_amt='".$fetch_dql['total_purchased_amt']."',total_rec_amt='".$fetch_dql['total_received_amt']."',total_pen_amt='".$fetch_dql['total_pending_amt']."' where cr_cus_id='".$fetch_dql['cr_cus_id']."'";
		$exec_fql=mysqli_query($conn,$fql);
		$d++;
	}*/
	
	/*$dql="SELECT t1.cr_cus_id as cr_cus_id,t2.payment_date as payment_date,received_amt as received_amt,t2.discount as discount_amt,t2.mode_of_payment as payment_mode,t2.descp as payment_descp FROM tbl_delivery_challan t1 inner join tbl_customer_billing_payment_details t2 on t1.dc_id=t2.dc_id where t1.delete_status='NDL' and t2.delete_status='NDL' and t1.cr_cus_id is not null";
	$exec_dql=mysqli_query($conn,$dql);
	$d=0;
	while($fetch_dql=mysqli_fetch_array($exec_dql)){
		$sum_amt=$fetch_dql['received_amt']+$fetch_dql['discount_amt'];
		$fql="insert into tbl_customer_payment_details (cr_cus_id,payment_date,payment_mode,received_amt,discount_amt,total_amt) values('".$fetch_dql['cr_cus_id']."','".$fetch_dql['payment_date']."','".$fetch_dql['payment_mode']."','".$fetch_dql['received_amt']."','".$fetch_dql['discount_amt']."','".$sum_amt."')";
		$exec_fql=mysqli_query($conn,$fql);
		$d++;
	}*/
?>
<!-- begin::main content -->
<main class="main-content">
			<div class="card">
        <div class="card-body" style="padding-top:10px;padding-bottom:5px;">
			<div class="row">
				<div class="col-md-12 col-lg-12 col-xs-12">
					<div class="card" style="margin-bottom:10px">
						<div class="card-header text-center" style="padding:3px"><h4 style="font-weight:bold;margin-bottom:0">Reports</h4></div>
					</div>
				</div>
        		<div class="col-md-12">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
                            <!--<li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                   aria-controls="home" aria-selected="true"><b>Products Import</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="dc-tab" data-toggle="tab" href="#dc" role="tab"
                                   aria-controls="dc" aria-selected="false"><b>Delivery Challan</b></a>
                            </li>-->
                            <li class="nav-item">
                                <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                                   aria-controls="pending" aria-selected="false"><b>Total Pending Amount</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="allpending-tab" data-toggle="tab" href="#allpending" role="tab"
                                   aria-controls="allpending" aria-selected="false"><b>GST Pending Amount</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="allreceived-tab" data-toggle="tab" href="#allreceived" role="tab"
                                   aria-controls="allreceived" aria-selected="false"><b>Quotation Pending Amount</b></a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent" style="border-style:solid;border-color:#dee2e6;border-width:0 1px 1px 1px;padding:15px;border-bottom-left-radius: .25rem;border-bottom-right-radius: .25rem;">
                            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form id="mainform" method="POST" action="" enctype="multipart/form-data">
								   <div class="row" style="margin-bottom:10px">
									<div class="col-md-3">
										<label>From</label>
										<input type="text" id="import_fdate" name="single-date-picker" class="form-control">
									</div>
									<div class="col-md-3">
										<label>To</label>
										<input type="text" id="import_tdate" name="single-date-picker" class="form-control">
									</div>
									<div class="col-md-3">
										<button type="button" id="importsearch" class="btn btn-success searchbut">Search</button>
									</div>
								   </div>
								   <table id="importgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
										<thead>
										<tr>
											<th>S.no</th>
											<th>Import&nbsp;Date</th>
											<th>Godown</th>
											<th>Category</th>
											<th>Design</th>
											<th>Qty</th>
											<th>Units/Box/Sqft/Nos/Bag</th>
											<th>Total&nbsp;Boxes</th>
											<th>Total&nbsp;Units</th>
										</tr>
										</thead>
									</table>
								</form>
                            </div>
                             
                            
							<div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                <form id="mainform" method="POST" action="" enctype="multipart/form-data">
								   <!--<div class="row" style="margin-bottom:10px">
									<div class="col-md-3">
										<label>From</label>
										<input type="text" id="import_fdate" name="single-date-picker" class="form-control">
									</div>
									<div class="col-md-3">
										<label>To</label>
										<input type="text" id="import_tdate" name="single-date-picker" class="form-control">
									</div>
									<div class="col-md-3">
										<button type="button" id="importsearch" class="btn btn-success searchbut">Search</button>
									</div>
								   </div>-->
								   <button class="btn btn-success" onclick="printDiv('printdiv')" style="margin-bottom:10px"><i class="fa fa-print" style="font-weight:bold"> Print</i></button>
								   <div id="printdiv">
								   <h5 style="color:#fff;font-weight:bold;" id="titlehead"> Pending Details</h5>
								   <table id="printdivgrid1" class="table table-striped table-bordered" width="100%" cellspacing="0">
										<thead>
										<tr>
											<th id="firstth">S.no</th>
											<th id="secondth">Customer&nbsp;Name</th>
											<th id="thirdth">Pending&nbsp;Amount</th>
										</tr>
										<tbody>
										<?php
											//$sql="SELECT t1.cr_cus_id as cr_cus_id,t1.cr_cus_name as cus_name,sum(t2.total_amt-t2.total_received_amt) as pending_amt FROM tbl_credit_customers t1 inner join tbl_delivery_challan t2 on t1.cr_cus_id=t2.cr_cus_id where t1.delete_status='NDL' and t2.delete_status='NDL' and (t2.total_amt-t2.total_received_amt) is not null and (t2.total_amt-t2.total_received_amt)<>0 group by t2.cr_cus_id order by t1.cr_cus_name asc";
											/****changed on 25-09-2020*******/
											$sql = "SELECT *,a.dc_id,a.dc_no,a.total_amount,a.grand_total_amount,d.customer_id,d.customer_name,d.mblno FROM tbl_non_dc  a inner join tbl_non_dc_details b on a.dc_id=b.dc_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and  d.delete_status!='0'";

											//$sql="SELECT * FROM tbl_credit_customers where delete_status='NDL' and total_pen_amt is not null and total_pen_amt<>0 order by cr_cus_name asc";
											/****changed on 25-09-2020*******/
											$exec_sql=mysqli_query($conn,$sql);
											$i=0;
											while($fetch_sql=mysqli_fetch_array($exec_sql)){
										?>
											<tr>
												<td id="firsttd<?php echo $i;?>"><?php echo $i+1;?></td>
												<td id="secondtd<?php echo $i;?>" style="text-align:left"><span style="cursor:pointer" class="cusnamedetailstrigger" data-cr_cus_id=<?php echo $fetch_sql['customer_id'];?> data-cus_name="<?php echo $fetch_sql['customer_name'];?>"><?php echo $fetch_sql['customer_name'];?> <br> <?php echo $fetch_sql['mblno'];?></span></td>
												<td id="thirdtd<?php echo $i;?>" style="text-align:right"><?php echo $fetch_sql['grand_total_amount'];?></td>
											</tr>
											<?php
												$i++;
											}
											?>
										</tbody>
										<tfoot>
											<?php
											$rql = "SELECT sum(grand_total_amount) as tot_pending_amt FROM tbl_non_dc  a inner join tbl_non_dc_details b on a.dc_id=b.dc_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and  d.delete_status!='0'";

												//$rql="SELECT sum(total_pen_amt) as tot_pending_amt FROM tbl_credit_customers where delete_status='NDL'";
												$exec_rql=mysqli_query($conn,$rql);
												$fetch_rql=mysqli_fetch_array($exec_rql);
											?>
											<tr style="border-bottom:1px solid #000">
												<th colspan="1" style="border:none;padding-bottom:0"></th>
												<th style="border:none;"><label style="color:#000;font-size:17px;float:right;margin-bottom:0" id="totpendinglabel">Total Pending Amount</label></th>
												<th style="border:none;padding-bottom:0;text-align:right"><label style="text-align:center;margin-bottom:0"><span style="color:#000;font-size:17px" id="totpending"><?php echo $fetch_rql['tot_pending_amt'];?></span></label></th>
											</tr>
										</tfoot>
										</thead>
									</table>
									</div>
								</form>
                            </div>
							<div class="tab-pane fade" id="allpending" role="tabpanel" aria-labelledby="allpending-tab">
                                <form id="allpendingmainform" method="POST" action="" enctype="multipart/form-data">
								   <!--<div class="row" style="margin-bottom:10px">
									<div class="col-md-3">
										<label>From</label>
										<input type="text" id="import_fdate" name="single-date-picker" class="form-control">
									</div>
									<div class="col-md-3">
										<label>To</label>
										<input type="text" id="import_tdate" name="single-date-picker" class="form-control">
									</div>
									<div class="col-md-3">
										<button type="button" id="importsearch" class="btn btn-success searchbut">Search</button>
									</div>
								   </div>-->
								   <button class="btn btn-success" onclick="printDiv('printdiv1')" style="margin-bottom:10px"><i class="fa fa-print" style="font-weight:bold"> Print</i></button>
								   <div id="printdiv1">
								   <h5 style="color:#fff;font-weight:bold;" id="titlehead"> All Credit Customers</h5>
								   <table id="printdivgrid2" class="table table-striped table-bordered" width="100%" cellspacing="0">
										<thead>
										<tr>
											<th id="firstth">S.no</th>
											<th id="secondth">Customer&nbsp;Name</th>
											<th id="thirdth">Pending&nbsp;Amount</th>
										</tr>
										<tbody>
										<?php
											//$sql="SELECT t1.cr_cus_id as cr_cus_id,t1.cr_cus_name as cus_name,sum(t2.total_amt-t2.total_received_amt) as pending_amt FROM tbl_credit_customers t1 inner join tbl_delivery_challan t2 on t1.cr_cus_id=t2.cr_cus_id where t1.delete_status='NDL' and t2.delete_status='NDL' and (t2.total_amt-t2.total_received_amt) is not null and (t2.total_amt-t2.total_received_amt)<>0 group by t2.cr_cus_id order by t1.cr_cus_name asc";
											/****changed on 25-09-2020*******/
											$sql = "SELECT *,a.dc_id,a.dc_no,a.total_amount,a.grand_total_amount,d.customer_id,d.customer_name,d.mblno FROM tbl_gst_invoice  a inner join tbl_gst_invoice_details b on a.dc_id=b.dc_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and  d.delete_status!='0'";
											/****changed on 25-09-2020*******/
											$exec_sql=mysqli_query($conn,$sql);
											$i=0;
											while($fetch_sql=mysqli_fetch_array($exec_sql)){
										?>
											<tr>
												<td id="firsttd<?php echo $i;?>"><?php echo $i+1;?></td>
												<td id="secondtd<?php echo $i;?>" style="text-align:left"><span style="cursor:pointer" class="cusnamedetailstrigger" data-cr_cus_id=<?php echo $fetch_sql['customer_id'];?> data-cus_name="<?php echo $fetch_sql['customer_name'];?>"><?php echo $fetch_sql['customer_name'];?> <br> <?php echo $fetch_sql['mblno'];?></span></td>
												<td id="thirdtd<?php echo $i;?>" style="text-align:right"><?php echo $fetch_sql['grand_total_amount'];?></td>
											</tr>
											<?php
												$i++;
											}
											?>
										</tbody>
										<tfoot>
											<?php
											$rql = "SELECT sum(grand_total_amount) as tot_pending_amt FROM tbl_gst_invoice  a inner join tbl_gst_invoice_details b on a.dc_id=b.dc_id left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and  d.delete_status!='0'";

												//$rql="SELECT sum(total_pen_amt) as tot_pending_amt FROM tbl_credit_customers where delete_status='NDL'";
												$exec_rql=mysqli_query($conn,$rql);
												$fetch_rql=mysqli_fetch_array($exec_rql);
											?>
											<tr style="border-bottom:1px solid #000">
												<th colspan="1" style="border:none;padding-bottom:0"></th>
												<th style="border:none;"><label style="color:#000;font-size:17px;float:right;margin-bottom:0" id="totpendinglabel">Total Pending Amount</label></th>
												<th style="border:none;padding-bottom:0;text-align:right"><label style="text-align:center;margin-bottom:0"><span style="color:#000;font-size:17px" id="totpending"><?php echo $fetch_rql['tot_pending_amt'];?></span></label></th>
											</tr>
										</tfoot>
										</thead>
									</table>
									</div>
								</form>
                            </div>
							<div class="tab-pane fade" id="allreceived" role="tabpanel" aria-labelledby="allreceived-tab">
										<form id="mainform" method="POST" action="" enctype="multipart/form-data">
										   <div class="row" style="margin-bottom:10px">
											<div class="col-md-3">
												<label>From</label>
												<input type="text" name="single-date-picker" id="allreceived_fdate" class="form-control">
											</div>
											<div class="col-md-3">
												<label>To</label>
												<input type="text" name="single-date-picker" id="allreceived_tdate" class="form-control">
											</div>
											<div class="col-md-3">
												<button type="button" id="allreceivedsearch" class="btn btn-success searchbut">Search</button>
											</div>
										   </div>
										   <div id="DivIdToPrint">
										   <button class="btn btn-success" id="printClick" style="font-weight:bold;" onclick="printDivAllPayment(DivIdToPrint);"><i class="fa fa-print"></i>&nbsp;Print</button>
										   <table id="allreceivedgrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th>S.no</th>
														<th>Payment&nbsp;Date</th>
														<th>Customer&nbsp;Name</th>
														<th>Received&nbsp;Amount</th>
													</tr>
												</thead>
											</table>
											</div>
										</form>
									</div>
                        </div>
                </div>
            </div>
		</div>
	</div>
</main>
<button id="mybtn">mybtn</button>
<!-- end::main content -->
				<button type="button" class="btn btn-success sweet-delete" style="display:none"></button>
				<button type="button" class="btn btn-success sweet-insert" style="display:none"></button>
				<button type="button" class="btn btn-danger sweet-error" style="display:none"></button>
				<button data-toggle="modal" data-target=".bd-example-modal-xl" id="fulldetailstriggerbutton" style="display:none"></button>
                            <!--<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document" style="border:1px solid #fff">
                                    <div class="modal-content" style="background:#484848">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle" style="color:#fff">Payment&nbsp;Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color:#fff">&times;</span>
                                            </button>
                                        </div>
										<form id="paymentform" method="POST" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label>Total Amount : </label>
														<input type="text" placeholder="Enter Receiving Amount" name="total_amt" id="total_amt" class="form-control" disabled style="background:#484848">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Receiving Amount :</label>
														<input type="text" placeholder="Receiving Amt" name="receiving_amt" id="receiving_amt" class="form-control">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Pending Amount : </label>
														<input type="text" placeholder="Enter Receiving Amt" id="pending_amt" name="pending_amt" class="form-control" disabled style="background:#484848">
														<input type="hidden" name="pending_amt_main" id="pending_amt_main">
													</div>
												</div>
												<div class="col-md-7">
													<div class="form-group">
														<label>Mode of Payment :</label><br/>
														<input type="radio" id="cash" name="cashbybank" placeholder="Enter Account Number" value="bycash" style="width:20px" checked>
														<label for="cash"> Cash </label>
														<input type="radio" id="bybank" name="cashbybank" value="bybank" placeholder="Enter Account Number" style="width:20px">
														<label for="bybank"> By Bank </label>
														<input type="radio" id="bycheque" name="cashbybank" value="bycheque" placeholder="Enter Account Number" style="width:20px">
														<label for="bycheque"> By Cheque </label>
													</div>
												</div>
												<div class="col-md-5">
													<div class="form-group">
														<label>Transaction Date :</label>
														<input type="text" class="form-control" type="text" name="single-date-picker" id="pdate" placeholder="Enter Product Name">
														<input type="hidden" name="payment_date" id="payment_date">
														<input type="hidden" name="dc_id" id="dc_id">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label>Description :</label>
														<textarea class="form-control" id="descp" name="descp" placeholder="Enter Transaction Description"></textarea>
													</div>
												</div>
											</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <button type="button" id="paymentsubmit" class="btn btn-primary">Submit</button>
                                        </div>
										</form>
                                    </div>
                                </div>
                            </div>-->
							
							<div class="modal fade" id="exampleModalCenter_new" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document" style="border:1px solid #fff">
                                    <div class="modal-content" style="background:#484848">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle" style="color:#fff">Payment&nbsp;Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color:#fff">&times;</span>
                                            </button>
                                        </div>
										<form id="paymentform" method="POST" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Total&nbsp;Pending&nbsp;:</label>
														<input type="text" placeholder="Enter Receiving Amount" name="total_pending1" id="total_pending1" class="form-control" disabled style="background:#484848">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Receiving&nbsp;Amt&nbsp;:</label>
														<input type="text" placeholder="Receiving Amt" name="receiving_amt" id="receiving_amt" class="form-control">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Discount :</label>
														<input type="text" placeholder="Receiving Amt" name="discount" id="discount" class="form-control">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Pending&nbsp;Amt&nbsp;: </label>
														<input type="text" placeholder="Enter Receiving Amt" id="pending_amt" name="pending_amt" class="form-control" disabled style="background:#484848">
														<input type="hidden" name="pending_amt_main" id="pending_amt_main">
													</div>
												</div>
												<div class="col-md-7">
													<div class="form-group">
														<label>Mode of Payment :</label><br/>
														<input type="radio" id="cash" name="cashbybank" placeholder="Enter Account Number" value="bycash" style="width:20px" checked>
														<label for="cash"> Cash </label>
														<input type="radio" id="bybank" name="cashbybank" value="bybank" placeholder="Enter Account Number" style="width:20px">
														<label for="bybank"> By Bank </label>
														<input type="radio" id="bycheque" name="cashbybank" value="bycheque" placeholder="Enter Account Number" style="width:20px">
														<label for="bycheque"> By Cheque </label>
													</div>
												</div>
												<div class="col-md-5">
													<div class="form-group">
														<label>Payment Date :</label>
														<input type="text" class="form-control" type="text" name="single-date-picker" id="pdate" placeholder="Enter Product Name">
														<input type="hidden" name="payment_date" id="payment_date">
														<input type="hidden" name="cr_id" id="cr_id">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label>Description :</label>
														<textarea class="form-control" id="descp" name="descp" placeholder="Enter Transaction Description"></textarea>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<span id="pmsg" style="font-weight:bold"></span>
													</div>
												</div>
											</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <button type="button" id="paymentsubmit" class="btn btn-primary">Submit</button>
                                        </div>
										</form>
                                    </div>
                                </div>
                            </div>
							
							<div class="modal fade" id="update_payment_modal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document" style="border:1px solid #fff">
                                    <div class="modal-content" style="background:#484848">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle" style="color:#fff">Update Payment&nbsp;Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color:#fff">&times;</span>
                                            </button>
                                        </div>
										<form id="updatepaymentform" method="POST" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Receiving&nbsp;Amt&nbsp;:</label>
														<input type="text" placeholder="Receiving Amt" name="upd_receiving_amt" id="upd_receiving_amt" class="form-control">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Discount :</label>
														<input type="text" placeholder="Receiving Amt" name="upd_discount" id="upd_discount" class="form-control">
													</div>
												</div>
												<div class="col-md-7">
													<div class="form-group">
														<label>Mode of Payment :</label><br/>
														<input type="radio" id="upd_cash" name="upd_cashbybank" placeholder="Enter Account Number" value="bycash" style="width:20px" checked>
														<label for="upd_cash"> Cash </label>
														<input type="radio" id="upd_bybank" name="upd_cashbybank" value="bybank" placeholder="Enter Account Number" style="width:20px">
														<label for="upd_bybank"> By Bank </label>
														<input type="radio" id="upd_bycheque" name="upd_cashbybank" value="bycheque" placeholder="Enter Account Number" style="width:20px">
														<label for="upd_bycheque"> By Cheque </label>
													</div>
												</div>
												<div class="col-md-5">
													<div class="form-group">
														<label>Payment Date :</label>
														<input type="text" class="form-control" type="text" name="single-date-picker" id="upd_pdate" placeholder="Enter Product Name">
														<input type="hidden" name="upd_payment_date" id="upd_payment_date">
														<input type="hidden" name="pay_id" id="pay_id">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label>Description :</label>
														<textarea class="form-control" id="upd_descp" name="upd_descp" placeholder="Enter Transaction Description"></textarea>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<span id="upd_pmsg" style="font-weight:bold"></span>
													</div>
												</div>
											</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <button type="button" id="upd_paymentsubmit" class="btn btn-primary">Submit</button>
                                        </div>
										</form>
                                    </div>
                                </div>
                            </div>

						<div class="modal fade bd-example-modal-xl" id="exampleModalCenter" tabindex="-1" role="dialog"
                             aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" style="border:1px solid #fff">
                                <div class="modal-content" style="background:#484848">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="color:#fff">Full Transaction Details of <span id="cus_name" style="color:#f60e0e"></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" style="color:#fff;z-index:99999">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
										<input type="hidden" id="cr_cus_id">
                                        <div class="row">
											<div class="col-md-4">
												<h6 style="font-weight:bold;color:#fff">Total Purchased Amount : <span id="total_purchased_amt" class="badge badge-danger" style="font-weight:bold;font-size:15px"></span></h6>
											</div>
											<div class="col-md-4">
												<h6 style="font-weight:bold;color:#fff">Total Received Amount : <span id="total_received_amt" class="badge badge-danger" style="font-weight:bold;font-size:15px"></span></h6>
											</div>
											<div class="col-md-4">
												<h6 style="font-weight:bold;color:#fff;cursor:pointer">Total Pending Amount : <span id="total_pending_amt" class="badge badge-danger" style="font-weight:bold;font-size:15px" data-toggle='modal' data-target='#exampleModalCenter_new'></span></h6>
											</div>
										</div>
										<hr style="border-color:#fff"/>
										<!--<table id="fulltransactiongrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>S.no</th>
													<th>DC&nbsp;No.</th>
													<th>Challan&nbsp;Date</th>
													<th>Category</th>
													<th>Design</th>
													<th>Qty</th>
													<th>Total&nbsp;Amt</th>
													<th>Received&nbsp;Amt</th>
													<th>Pending&nbsp;Amt</th>
													<th>Action</th>
												</tr>
											</thead>
										</table>-->
										<div class="row">
											<div class="col-md-3">
												<button class="btn btn-success" id="indiprintclick" style="margin-bottom:10px"><i class="fa fa-print" style="font-weight:bold"> Print</i></button>
											</div>
											<div class="col-md-3">
												<div class="form-group row">
													<label for="cus_fdate" class="col-sm-2 col-form-label col-form-label-sm">From</label>
													<div class="col-sm-10">
														<input type="text" id="cus_fdate" name="single-date-picker" class="form-control">
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group row">
													<label for="cus_tdate" class="col-sm-2 col-form-label col-form-label-sm">To</label>
													<div class="col-sm-10">
														<input type="text" id="cus_tdate" name="single-date-picker" class="form-control">
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<button type="button" id="cuspaysearch" class="btn btn-success">Search</button>
											</div>
										</div>
										<hr style="border-color:#fff;margin-top:5px"/>
										<div id="individualDetailsdiv">
										<h5 style="color:#fff;font-weight:bold;" id="th1">Full Transaction Details of <span id="cus_name3"></span></h5>
										<table id="fulltransactiongrid_new" class="table table-striped table-bordered" width="100%" cellspacing="0">
											<thead>
												<tr>
													<th id="fth">S.no</th>
													<th id="sth">DC&nbsp;No</th>
													<th id="tth">Date</th>
													<th id="foth">Voucher&nbsp;Type</th>
													<th id="fith">Sales&nbsp;Amount</th>
													<th id="sith">Received&nbsp;Amount</th>
													<th id="seth" style="width:15%">Action</th>
												</tr>
											</thead>
											<tbody id="fulltransdt">
											</tbody>
										</table>
										</div>
                                    </div>
                                    <!--<div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>-->
                                </div>
                            </div>
                        </div>							
							
<input type="hidden" name="modulenamebox" id="modulenamebox" value="6">
<input type="hidden" name="rightsbox" id="rightsbox">
<!-- begin::global scripts -->

<?php include("footer.php") ?>




<script src="js/app.min.js"></script>
<!-- end::global scripts -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
<script src="js/examples/sweet-alert.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!-- end::custom scripts -->

</body>

<script>
function printDivAllPayment(DivIdToPrint){

  var divToPrint=document.getElementById('DivIdToPrint');
$("#allreceivedgrid_length").css('display','none');
$("#allreceivedgrid_filter").css('display','none');
$("#allreceivedgrid_info").css('display','none');
$("#allreceivedgrid_paginate").css('display','none');
  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><head><link rel="stylesheet" href="vendors/bundle.css" type="text/css"><link rel="stylesheet" href="vendors/dataTable/responsive.bootstrap.min.css" type="text/css"></head><body onload="window.print()"><style>#printClick{display:none}</style><h3>Amount Received from Credit Customers</h3>'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
	 $("#firstth").css('color','#000000');
		$("#firstth").css('font-size','22px');
	 $("#secondth").css('color','#000000');
		$("#secondth").css('font-size','22px');
	 $("#thirdth").css('color','#000000');
		$("#thirdth").css('font-size','22px');
	 $("#titlehead").css('color','#000000');
		$("#titlehead").css('font-size','22px');
	 $("#totpendinglabel").css('color','#000000');
		$("#totpendinglabel").css('font-size','22px');
		$("#totpending").css('color','#000000');
		$("#totpending").css('font-size','22px');
	 $("#printdivgrid_length").hide();
	 $("#printdivgrid_filter").hide();
	 $("#printdivgrid_info").hide();
	 $("#printdivgrid_paginate").hide();
	for(var i=0;i<<?php echo $i;?>;i++){
		$("#firsttd"+i).css('color','#000000');
		$("#firsttd"+i).css('font-size','22px');
		$("#secondtd"+i).css('color','#000000');
		$("#secondtd"+i).css('font-size','22px');
		$("#thirdtd"+i).css('color','#000000');
		$("#thirdtd"+i).css('font-size','22px');
	}
     window.print();

     document.body.innerHTML = originalContents;
	 //location.reload();
}
function printIndiDiv(divName,count) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
	 $("#fth").css('color','#000000');
		$("#fth").css('font-size','22px');
	 $("#sth").css('color','#000000');
		$("#sth").css('font-size','22px');
	 $("#tth").css('color','#000000');
		$("#tth").css('font-size','22px');
	 $("#foth").css('color','#000000');
		$("#foth").css('font-size','22px');
	 $("#fith").css('color','#000000');
		$("#fith").css('font-size','22px');
	 $("#sith").css('color','#000000');
		$("#sith").css('font-size','22px');
		$("#seth").css('display','none');
	 $("#th1").css('color','#000000');
		$("#th1").css('font-size','22px');
	for(var i=0;i<count;i++){
		$("#ftd"+i).css('color','#000000');
		$("#ftd"+i).css('font-size','22px');
		$("#std"+i).css('color','#000000');
		$("#std"+i).css('font-size','22px');
		$("#ttd"+i).css('color','#000000');
		$("#ttd"+i).css('font-size','22px');
		$("#eitd"+i).css('color','#000000');
		$("#eitd"+i).css('font-size','22px');
		$("#fotd"+i).css('color','#000000');
		$("#fotd"+i).css('font-size','22px');
		$("#fitd"+i).css('color','#000000');
		$("#fitd"+i).css('font-size','22px');
		$('#fitd'+i+' span').css('color','#000000');
		$("#fitd"+i+" span").css('font-size','22px');
		$("#fitd"+i+" span").css('border','none');
		$("#fitd"+i+" span").css('font-weight','normal');
		$("#sitd"+i+" span").css('border','none');
		$("#sitd"+i+" span").css('font-weight','normal');
		$("#sitd"+i).css('color','#000000');
		$("#sitd"+i).css('font-size','22px');
		$('#sitd'+i+' span').css('color','#000000');
		$("#sitd"+i+" span").css('font-size','22px');
		$("#setd"+i).css('display','none');
	}
     window.print();

     document.body.innerHTML = originalContents;
	 //$('#exampleModalCenter').modal('hide');
	 location.reload();
}
function creditprintDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
	 $("#creditfirstth").css('color','#000000');
		$("#creditfirstth").css('font-size','22px');
	 $("#creditsecondth").css('color','#000000');
		$("#creditsecondth").css('font-size','22px');
	 $("#creditthirdth").css('color','#000000');
		$("#creditthirdth").css('font-size','22px');
	 $("#creditfourthth").css('color','#000000');
		$("#creditfourthth").css('font-size','22px');
	 $("#creditfifthth").css('color','#000000');
		$("#creditfifthth").css('font-size','22px');
	 $("#creditsixthth").css('color','#000000');
		$("#creditsixthth").css('font-size','22px');
	 $("#creditseventhth").css('color','#000000');
		$("#creditseventhth").css('font-size','22px');
	 $("#crediteighthth").css('color','#000000');
		$("#crediteighthth").css('font-size','22px');
	 $("#creditninethth").css('color','#000000');
		$("#creditninethth").css('font-size','22px');
	 $("#credittenthth").css('color','#000000');
		$("#credittenthth").css('font-size','22px');
	 $("#crediteleventhth").css('color','#000000');
		$("#crediteleventhth").css('font-size','22px');
	 $("#credittitlehead").css('color','#000000');
	 $("#credittitlehead").css('display','block');
	 $("#billcreditgrid_length").hide();
	 $("#billcreditgrid_filter").hide();
	 $("#billcreditgrid_info").hide();
	 $("#billcreditgrid_paginate").hide();
	for(var i=1;i<=<?php echo $i;?>;i++){
		$("#creditfirsttd"+i).css('color','#000000');
		$("#creditfirsttd"+i).css('font-size','22px');
		$("#creditsecondtd"+i).css('color','#000000');
		$("#creditsecondtd"+i).css('font-size','22px');
		$("#creditthirdtd"+i).css('color','#000000');
		$("#creditthirdtd"+i).css('font-size','22px');
		$("#creditfourthtd"+i).css('color','#000000');
		$("#creditfourthtd"+i).css('font-size','22px');
		$("#creditfifthtd"+i).css('color','#000000');
		$("#creditfifthtd"+i).css('font-size','22px');
		$("#creditsixthtd"+i).css('color','#000000');
		$("#creditsixthtd"+i).css('font-size','22px');
		$("#creditseventhtd"+i).css('color','#000000');
		$("#creditseventhtd"+i).css('font-size','22px');
		$("#crediteightthtd"+i).css('color','#000000');
		$("#crediteightthtd"+i).css('font-size','22px');
		$("#creditninethtd"+i).css('color','#000000');
		$("#creditninethtd"+i).css('font-size','22px');
		$("#credittenthtd"+i).css('color','#000000');
		$("#credittenthtd"+i).css('font-size','22px');
		$("#crediteleventhtd"+i).css('color','#000000');
		$("#crediteleventhtd"+i).css('font-size','22px');
	}
     window.print();

     document.body.innerHTML = originalContents;
	 location.reload();
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

	/*$('#importgrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/products_import_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond:"reports"},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
    });	*/
		
	$('#dccashgrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/delivery_challan_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"firstbind",cond_two:"dccash"},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
    });
		
	$('#dccreditgrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/delivery_challan_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"firstbind",cond_two:"dccredit"},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
    });
		
	$('#billcashgrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
			"bProcessing": true,
			"serverSide": true,
			"responsive": true,
			"ajax":{
			url :"phpservices/customer_billing_grid_search.php", // json datasource
			type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"firstbind",cond_two:"billcash"},
			error: function(){
				$("#detailsgrid").css("display","none");
			}
			}
	});	


	$('#sanitarybillcashgrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/sanitary_customer_billing_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"firstbind",cond_two:"billcash"},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
    });	

	$('#billcreditgrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/customer_billing_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"firstbind",cond_two:"billcredit"},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
    });	
	$('#sanitarybillcreditgrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/sanitary_customer_billing_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"firstbind",cond_two:"billcredit"},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
    });	
		
	$('#allreceivedgrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/credit_customer_received_amount_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond:"firstbind"},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
    });
		
	$("#allreceivedsearch").click(function(e){
		e.preventDefault();
		$("#allreceivedgrid").dataTable().fnDestroy();
		
		var fdatefullvalue= $("#allreceived_fdate").val();
		var fdatevalue = fdatefullvalue.split('/')[0];
		var fmonthvalue = fdatefullvalue.split('/')[1];
		var fyearvalue = fdatefullvalue.split('/')[2];
		
		var tdatefullvalue= $("#allreceived_tdate").val();
		var tdatevalue = tdatefullvalue.split('/')[0];
		var tmonthvalue = tdatefullvalue.split('/')[1];
		var tyearvalue = tdatefullvalue.split('/')[2];
		
		$('#allreceivedgrid').DataTable({
			aLengthMenu: [
				[50, 100, 500, 1000],
				[50, 100, 500, 1000]
			],
			"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/credit_customer_received_amount_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond:"searchbind",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
        });	
	});
		
	$("#importsearch").click(function(e){
		e.preventDefault();
		
		var fdatefullvalue= $("#import_fdate").val();
		var fdatevalue = fdatefullvalue.split('/')[0];
		var fmonthvalue = fdatefullvalue.split('/')[1];
		var fyearvalue = fdatefullvalue.split('/')[2];
		
		var tdatefullvalue= $("#import_tdate").val();
		var tdatevalue = tdatefullvalue.split('/')[0];
		var tmonthvalue = tdatefullvalue.split('/')[1];
		var tyearvalue = tdatefullvalue.split('/')[2];
		
		$("#importgrid").dataTable().fnDestroy();
		$('#importgrid').DataTable({
			aLengthMenu: [
				[50, 100, 500, 1000],
				[50, 100, 500, 1000]
			],
			"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/products_import_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
        });	
	});
		
	$("#dccashsearch").click(function(e){
		e.preventDefault();
		$("#dccashgrid").dataTable().fnDestroy();
		
		var fdatefullvalue= $("#dccash_fdate").val();
		var fdatevalue = fdatefullvalue.split('/')[0];
		var fmonthvalue = fdatefullvalue.split('/')[1];
		var fyearvalue = fdatefullvalue.split('/')[2];
		
		var tdatefullvalue= $("#dccash_tdate").val();
		var tdatevalue = tdatefullvalue.split('/')[0];
		var tmonthvalue = tdatefullvalue.split('/')[1];
		var tyearvalue = tdatefullvalue.split('/')[2];
		
		$('#dccashgrid').DataTable({
			aLengthMenu: [
				[50, 100, 500, 1000],
				[50, 100, 500, 1000]
			],
			"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/delivery_challan_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"searchbind",cond_two:"dccash",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
        });	
	});
		
	$("#dccreditsearch").click(function(e){
		e.preventDefault();
		$("#dccreditgrid").dataTable().fnDestroy();
		
		var fdatefullvalue= $("#dccredit_fdate").val();
		var fdatevalue = fdatefullvalue.split('/')[0];
		var fmonthvalue = fdatefullvalue.split('/')[1];
		var fyearvalue = fdatefullvalue.split('/')[2];
		
		var tdatefullvalue= $("#dccredit_tdate").val();
		var tdatevalue = tdatefullvalue.split('/')[0];
		var tmonthvalue = tdatefullvalue.split('/')[1];
		var tyearvalue = tdatefullvalue.split('/')[2];
		
		$('#dccreditgrid').DataTable({
			aLengthMenu: [
				[50, 100, 500, 1000],
				[50, 100, 500, 1000]
			],
			"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/delivery_challan_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"searchbind",cond_two:"dccredit",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
        });	
	});
		
	$("#billcashsearch").click(function(e){
		e.preventDefault();
		$("#billcashgrid").dataTable().fnDestroy();
		
		var fdatefullvalue= $("#billcash_fdate").val();
		var fdatevalue = fdatefullvalue.split('/')[0];
		var fmonthvalue = fdatefullvalue.split('/')[1];
		var fyearvalue = fdatefullvalue.split('/')[2];
		
		var tdatefullvalue= $("#billcash_tdate").val();
		var tdatevalue = tdatefullvalue.split('/')[0];
		var tmonthvalue = tdatefullvalue.split('/')[1];
		var tyearvalue = tdatefullvalue.split('/')[2];
		
		$('#billcashgrid').DataTable({
			aLengthMenu: [
				[50, 100, 500, 1000],
				[50, 100, 500, 1000]
			],
			"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/customer_billing_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"searchbind",cond_two:"billcash",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
        });	
	});
		
	$("#sanitarybillcreditsearch").click(function(e){
		e.preventDefault();
		$("#sanitarybillcreditgrid").dataTable().fnDestroy();
		
		var fdatefullvalue= $("#sanitarybillcredit_fdate").val();
		var fdatevalue = fdatefullvalue.split('/')[0];
		var fmonthvalue = fdatefullvalue.split('/')[1];
		var fyearvalue = fdatefullvalue.split('/')[2];
		
		var tdatefullvalue= $("#sanitarybillcredit_tdate").val();
		var tdatevalue = tdatefullvalue.split('/')[0];
		var tmonthvalue = tdatefullvalue.split('/')[1];
		var tyearvalue = tdatefullvalue.split('/')[2];
		
		$('#sanitarybillcreditgrid').DataTable({
			aLengthMenu: [
				[50, 100, 500, 1000],
				[50, 100, 500, 1000]
			],
			"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/sanitary_customer_billing_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"searchbind",cond_two:"billcredit",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
        });	
	});

	$("#sanitarybillcashsearch").click(function(e){
		e.preventDefault();
		$("#sanitarybillcashgrid").dataTable().fnDestroy();
		
		var fdatefullvalue= $("#sanitarybillcash_fdate").val();
		var fdatevalue = fdatefullvalue.split('/')[0];
		var fmonthvalue = fdatefullvalue.split('/')[1];
		var fyearvalue = fdatefullvalue.split('/')[2];
		
		var tdatefullvalue= $("#sanitarybillcash_tdate").val();
		var tdatevalue = tdatefullvalue.split('/')[0];
		var tmonthvalue = tdatefullvalue.split('/')[1];
		var tyearvalue = tdatefullvalue.split('/')[2];
		
		$('#sanitarybillcashgrid').DataTable({
			aLengthMenu: [
				[50, 100, 500, 1000],
				[50, 100, 500, 1000]
			],
			"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/sanitary_customer_billing_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"searchbind",cond_two:"billcash",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
        });	
	});
		
	$("#sanitarybillcreditsearch").click(function(e){
		e.preventDefault();
		$("#sanitarybillcreditgrid").dataTable().fnDestroy();
		
		var fdatefullvalue= $("#sanitarybillcredit_fdate").val();
		var fdatevalue = fdatefullvalue.split('/')[0];
		var fmonthvalue = fdatefullvalue.split('/')[1];
		var fyearvalue = fdatefullvalue.split('/')[2];
		
		var tdatefullvalue= $("#sanitarybillcredit_tdate").val();
		var tdatevalue = tdatefullvalue.split('/')[0];
		var tmonthvalue = tdatefullvalue.split('/')[1];
		var tyearvalue = tdatefullvalue.split('/')[2];
		
		$('#sanitarybillcreditgrid').DataTable({
			aLengthMenu: [
				[50, 100, 500, 1000],
				[50, 100, 500, 1000]
			],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/sanitary_customer_billing_grid_search.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cond_one:"searchbind",cond_two:"billcredit",fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
        });	
	});
		
	$('#printdivgrid1').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
		"responsive" : true
	});
		
	$('#printdivgrid2').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
		"responsive" : true
	});
		
	/*$('#pendingamtgrid').DataTable({
				 dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            }
        ],
				aLengthMenu: [
						[10, 25, 50, 100, 200, 1000],
						[10, 25, 50, 100, 200, 1000]
					],
				 "bProcessing": true,
				 "serverSide": true,
				 "responsive": true,
				 "ajax":{
					url :"phpservices/customer_pending_amt_grid.php", // json datasource
					type: "post",  // type of method  ,GET/POST/DELETE
					error: function(){
					  $("#detailsgrid").css("display","none");
					}
				  }
			});	*/
			
$("#pendingamtgrid_wrapper").addClass('row');			
$(".dt-buttons").addClass('col-md-6 col-xs-12');			
$("#pendingamtgrid_filter").addClass('col-md-6 col-xs-12');			
$(".buttons-print").addClass('btn btn-success');			
$(".buttons-print").css('margin-top','15px');			
$("#pendingamtgrid").css('margin-left', '15px');
$("#pendingamtgrid").css('margin-right', '15px');
	
	$(document).on('click','.buttons-print', function(){
		$("#sno1").css('color','red');
	});
	$(document).on('click','.deleteTriger', function(){
		var delid=$(this).data('value');
		$.ajax({
					type: "POST",
					url: "phpservices/sender_delete.php",
					dataType:'json',
					data: {delid:delid},
					success: function(result) {
						console.log(result.op);
						if(result.op==1){
							$("#msg").css("color","green").html("Successfully Deleted !");
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
$("input[type='radio']").click(function(){
            var radioValue = $("input[name='cashbybank']:checked").val();
            if(radioValue=='bybank'){
                $("#moneydescp").show();
            }
			else if(radioValue=='bycheque'){
				$("#moneydescp").show();
            }
			else{
				$("#moneydescp").hide();
			}
});	

$("#receiving_amt").keyup(function(){
	var tot_rec_amt=0;
	if($("#discount").val()==''){
		tot_rec_amt=parseInt($("#receiving_amt").val());
	}
	else{
		tot_rec_amt=parseInt($("#receiving_amt").val())+parseInt($("#discount").val());
	}
	if(tot_rec_amt>parseInt($("#pending_amt_main").val())){
		$(".sweet-error").click();
		$("#receiving_amt").val('');
		$("#discount").val('');
		$("#receiving_amt").css('border-color','red');
		$("#pending_amt").val($("#pending_amt_main").val());
	}
	else{
		if($("#discount").val()==''){
			$("#pending_amt").val($("#pending_amt_main").val()-$("#receiving_amt").val());
		}
		else{
			$("#pending_amt").val($("#pending_amt_main").val()-$("#receiving_amt").val()-$("#discount").val());
		}
	}
});
	
$("#discount").keyup(function(){
	var tot_rec_amt=0;
	if($("#receiving_amt").val()==''){
		tot_rec_amt=parseInt($("#discount").val());
	}
	else{
		tot_rec_amt=parseInt($("#receiving_amt").val())+parseInt($("#discount").val());
	}
	if(tot_rec_amt>parseInt($("#pending_amt_main").val())){
		swal("Error!", "Discount Amount Not Greater than Pending Amount!", "error");
		$("#receiving_amt").val('');
		$("#discount").val('');
		$("#discount").css('border-color','red');
		$("#pending_amt").val($("#pending_amt_main").val());
	}
	else{
		if($("#receiving_amt").val()==''){
			$("#pending_amt").val($("#pending_amt_main").val()-$("#discount").val());
		}
		else{
			$("#pending_amt").val($("#pending_amt_main").val()-$("#receiving_amt").val()-$("#discount").val());
		}
	}
});

$(document).on('click','.addamount', function(){
		var cus_bill_id=$(this).data('cus_bill_id'),tot_amt=$(this).data('tot_amt'),pen_amt=$(this).data('pen_amt'),dc_id=$(this).data('dc_id');
		$("#receiving_amt").val('');
		$("#discount").val('');
		$("#cus_bill_id").val(cus_bill_id);
		$("#tot_amt").val(tot_amt);
		$("#total_amt").val(tot_amt);
		$("#pen_amt").val(pen_amt);
		$("#pending_amt").val(pen_amt);
		$("#pending_amt_main").val(pen_amt);
		$("#dc_id").val(dc_id);
	});

setTimeout(function(){
	var datefullvalue= $("#pdate").val();
	var datevalue = datefullvalue.split('/')[0];
	var monthvalue = datefullvalue.split('/')[1];
	var yearvalue = datefullvalue.split('/')[2];
	$("#payment_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);
},500); 
 
$("#pdate").change(function(){
	var datefullvalue= $("#pdate").val();
	var datevalue = datefullvalue.split('/')[0];
	var monthvalue = datefullvalue.split('/')[1];
	var yearvalue = datefullvalue.split('/')[2];
	$("#payment_date").val(monthvalue+'/'+datevalue+'/'+yearvalue);
}); 
	
$("#paymentsubmit").click(function(){
	if($("#receiving_amt").val()==''){
		$("#pmsg").css("color","red").html("* Enter Receiving Amount");
		setTimeout(function(){$("#pmsg").html('')},3000);
		return false;
	}
	else{
		$.ajax({
			type: "POST",
			url: "phpservices/customer_billing_payment_insert.php",
			dataType:'json',
			data: $("#paymentform").serialize(),
			success: function(result) {
				console.log(result.op1);
				if(result.op==1){
					$("#pmsg").css("color","#fff").html("Successfully Added !");
					$(".sweet-insert").click();
					setTimeout(function(){
						location.reload();
					},1500);
				}
				else{
					alert($("#pmsg").html(result.op));
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	}
});	
	
$("#upd_paymentsubmit").click(function(){
	if($("#upd_receiving_amt").val()==''){
		$("#upd_pmsg").css("color","red").html("* Enter Receiving Amount");
		setTimeout(function(){$("#upd_pmsg").html('')},3000);
		return false;
	}
	else{
		$.ajax({
			type: "POST",
			url: "phpservices/customer_billing_payment_update_in_popup.php",
			dataType:'json',
			data: $("#updatepaymentform").serialize(),
			success: function(result) {
				console.log(result.op1);
				if(result.op==1){
					$("#upd_pmsg").css("color","#fff").html("Successfully Added !");
					$(".sweet-update").click();
					setTimeout(function(){
						location.reload();
					},1500);
				}
				else{
					alert($("#upd_pmsg").html(result.op));
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	}
});	

/*
	$(document).on('click','.convertTriger', function(){
		var dc_id=$(this).data('value');
		var emprights=$("#rightsbox").val();
		if (emprights=='1' || emprights=='2' || emprights=='6' || emprights=='8' || '<?php echo $log;?>' == 'admin') {
			var alertmsg=confirm("Do you want to change status ?");
			if (alertmsg == true) {
				$.ajax({
							type: "POST",
							url: "phpservices/report_dc_status_changer.php",
							dataType:'json',
							data: {dc_id:dc_id},
							success: function(result) {
								console.log(result.op);
								if(result.op[0]==true){
									$("#msg").css("color","#fff").html("Successfully Converted !");
									swal("Converted!", "Successfully Converted!", "success");
									setTimeout(function(){
										window.location.href='report.php';
									},1500);
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
	
	
$(document).on('click','.convertTriger', function(){
	var dc_id=$(this).data('value');
	var alertmsg=confirm("Do you want to Change the Status ?");
	if (alertmsg == true) {
		$.ajax({
			type: "POST",
			url: "phpservices/report_dc_status_changer.php",
			dataType:'json',
			data: {dc_id:dc_id},
			success: function(result) {
				$.ajax({
			type: "POST",
			url: "phpservices/customer_full_transaction_details.php",
			dataType:'json',
			data: {
                cr_cus_id: $("#cr_cus_id").val()
            },
			success: function(result) {
				console.log(result);
				$("#total_purchased_amt").html(result.total_purchased_amt);
				$("#total_received_amt").html(result.total_received_amt);
				$("#total_pending_amt").html(result.total_pending_amt);
				$("#dc_status").html(result.dc_status);
				$("#fulltransdt").html('');
				for(var i=0;i<result.rows;i++){
					$("#fulltransdt").append('<tr role="row" class="odd"><td class="sorting_1" tabindex="0" id="ftd'+i+'">#'+(parseInt(i)+parseInt('1'))+'</td><td id="std'+i+'">'+result.dc_no[i]+'</td><td id="ttd'+i+'">'+result.date[i]+'</td><td id="fotd'+i+'">'+result.mycol[i]+'</td><td id="fitd'+i+'">'+result.stotal_amt[i]+'</td><td id="sitd'+i+'">'+result.ptotal_amt[i]+'</td><td id="setd'+i+'">'+result.action[i]+'</td></tr>');
				}
				$("#indiprintclick").click(function(){
					printIndiDiv('individualDetailsdiv',result.rows);
				});
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
	}
});

	
$(document).on('click','.cusnamedetailstrigger', function(){
	var cr_cus_id=$(this).data('cr_cus_id'), cus_name=$(this).data('cus_name');
	$("#fulldetailstriggerbutton").click();
	$("#cus_name").html(cus_name);
	$("#cus_name3").html(cus_name);
	$("#cr_cus_id").val(cr_cus_id);
	$.ajax({
			type: "POST",
			url: "phpservices/customer_full_transaction_details.php",
			dataType:'json',
			data: {cr_cus_id:cr_cus_id},
			success: function(result) {
				$("#total_purchased_amt").html(result.total_purchased_amt);
				$("#total_received_amt").html(result.total_received_amt);
				$("#total_pending_amt").html(result.total_pending_amt);
				$("#dc_status").html(result.dc_status);
				$("#fulltransdt").html('');
				for(var i=0;i<result.rows;i++){
					$("#fulltransdt").append('<tr role="row" class="odd"><td class="sorting_1" tabindex="0" id="ftd'+i+'">#'+(parseInt(i)+parseInt('1'))+'</td><td id="std'+i+'">'+result.dc_no[i]+'</td><td id="ttd'+i+'">'+result.date[i]+'</td><td id="fotd'+i+'">'+result.mycol[i]+'</td><td id="fitd'+i+'">'+result.stotal_amt[i]+'</td><td id="sitd'+i+'">'+result.ptotal_amt[i]+'</td><td id="setd'+i+'">'+result.action[i]+'</td></tr>');
				}
				$("#indiprintclick").click(function(){
					printIndiDiv('individualDetailsdiv',result.rows);
				});
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
		
	$("#fulltransactiongrid").dataTable().fnDestroy();

	$('#fulltransactiongrid').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
	     "bProcessing": true,
         "serverSide": true,
		 "responsive": true,
         "ajax":{
            url :"phpservices/customer_full_transaction_grid.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
			data:{cr_cus_id:cr_cus_id},
            error: function(){
              $("#detailsgrid").css("display","none");
            }
          }
        });	
		
	//$("#fulltransactiongrid_new").dataTable().fnDestroy();

	/*$('#fulltransactiongrid_new').DataTable({
		aLengthMenu: [
			[50, 100, 500, 1000],
			[50, 100, 500, 1000]
		],
		"pageLength": 50,
		 "responsive": true
        });	*/
});	

$("#total_pending_amt").click(function(){
	$("#total_amt").val($("#total_purchased_amt").html());
	$("#pending_amt").val($("#total_pending_amt").html());
	$("#total_pending1").val($("#total_pending_amt").html());
	$("#receiving_amt").css('border','1px solid #ced4da');
	$("#discount").css('border','1px solid #ced4da');
	$("#pending_amt_main").val($("#total_pending_amt").html());
	$("#cr_id").val($("#cr_cus_id").val());
});

$(document).on('click','.addamount', function(){
		var cus_bill_id=$(this).data('cus_bill_id'),tot_amt=$(this).data('tot_amt'),pen_amt=$(this).data('pen_amt'),dc_id=$(this).data('dc_id');
		$("#cus_bill_id").val(cus_bill_id);
		$("#tot_amt").val(tot_amt);
		$("#total_amt").val(tot_amt);
		$("#pen_amt").val(pen_amt);
		$("#pending_amt").val(pen_amt);
		$("#pending_amt_main").val(pen_amt);
		$("#dc_id").val(dc_id);
	});

$("#cuspaysearch").click(function(){
	var fdatefullvalue= $("#cus_fdate").val();
	var fdatevalue = fdatefullvalue.split('/')[0];
	var fmonthvalue = fdatefullvalue.split('/')[1];
	var fyearvalue = fdatefullvalue.split('/')[2];
		
	var tdatefullvalue= $("#cus_tdate").val();
	var tdatevalue = tdatefullvalue.split('/')[0];
	var tmonthvalue = tdatefullvalue.split('/')[1];
	var tyearvalue = tdatefullvalue.split('/')[2];
	console.log($("#cr_cus_id").val());
	console.log(fmonthvalue+'/'+fdatevalue+'/'+fyearvalue);
	console.log(tmonthvalue+'/'+tdatevalue+'/'+tyearvalue);
	$.ajax({
			type: "POST",
			url: "phpservices/customer_full_transaction_details_search.php",
			dataType:'json',
			data: {cr_cus_id:$("#cr_cus_id").val(),fdate:fmonthvalue+'/'+fdatevalue+'/'+fyearvalue,tdate:tmonthvalue+'/'+tdatevalue+'/'+tyearvalue},
			success: function(result) {
				$("#fulltransdt").html('');
				if(result.rows){
					for(var i=0;i<result.rows;i++){
						$("#fulltransdt").append('<tr role="row" class="odd"><td class="sorting_1" tabindex="0" id="ftd'+i+'">#'+(parseInt(i)+parseInt('1'))+'</td><td id="std'+i+'">'+result.dc_no[i]+'</td><td id="ttd'+i+'">'+result.date[i]+'</td><td id="fotd'+i+'">'+result.mycol[i]+'</td><td id="fitd'+i+'">'+result.stotal_amt[i]+'</td><td id="sitd'+i+'">'+result.ptotal_amt[i]+'</td><td id="setd'+i+'">'+result.action[i]+'</td></tr>');
					}
					$("#indiprintclick").click(function(){
						printIndiDiv('individualDetailsdiv',result.rows);
					});
				}
				else{
					$("#fulltransdt").html('<tr><td colspan="7">** No Results Found **</td></tr>');
				}
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
});
	
$(document).on('click','.payupdateTrigger', function(){
	var pay_id=$(this).data('pay_id');
	$("#pay_id").val(pay_id);
	$.ajax({
			type: "POST",
			url: "phpservices/customer_payment_details_update_bind.php",
			dataType:'json',
			data: {pay_id:pay_id},
			success: function(result) {
				$("#upd_payment_date").val(result.payment_date_new);
				$("#upd_pdate").val(result.payment_date);
				$("#upd_discount").val(result.discount_amt);
				$("#upd_receiving_amt").val(result.received_amt);
				$("#upd_descp").val(result.payment_descp);
				if(result.payment_mode=='bycash'){
					$("#upd_cash").prop('checked',true);
				}
				else if(result.payment_mode=='bybank'){
					$("#upd_bybank").prop('checked',true);
				}
				else if(result.payment_mode=='bycheque'){
					$("#upd_bycheque").prop('checked',true);
				}
				//$("#upd_").html(result.payment_mode);
			},error:function(xhr,status,error){
				console.log(JSON.stringify(xhr,status,error));
			}
		});
});	
		
	$(document).on('click','.paydeleteTrigger', function(){
		var delid=$(this).data('pay_id');
		var emprights=$("#rightsbox").val();
		if(emprights=='1' || emprights=='5' || emprights=='2' || emprights=='3' || '<?php echo $log;?>' == 'admin'){
			var alertmsg=confirm("Do you want to Delete ?");
			if (alertmsg == true) {
				$.ajax({
							type: "POST",
							url: "phpservices/customer_payment_billing_delete.php",
							dataType:'json',
							data: {delid:delid},
							success: function(result) {
								console.log(result.op);
								if(result.op==1){
									$("#msg").css("color","#fff").html("Successfully Deleted !");
									$(".sweet-delete").click();
									setTimeout(function(){
										location.reload();
									},1500);
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
</script>
</html>