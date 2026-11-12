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
		.onepage_p, .table td, .table th{
			font-size: 14px!important;
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

    <style>
        body {
            color: black;
        }

        #tablemainbind {
            vertical-align: bottom;
            padding: 0.2rem !important;
        }

        .table td {
            vertical-align: bottom !important;

        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 36px;
        }
        .watermark {
            position: absolute;
            opacity: 0.10;
            font-size: 3em;
            width: 30%;
            text-align: center;
            z-index: 1000;
            top: 60%;
            left: 35%;
            transform: translate(-50%, -50%);
        }

        @media print {
            footer {
                position: fixed;
                bottom: 0;
                /* text-align: center; */
                width: 100%;

            }
        }
        .table-striped tbody tr:nth-of-type(odd){
	background-color: #fff;
}
.table-bordered thead td, .table-bordered thead th{
	background: #fef9c3!important;
    color: #000000!important;
}
.table thead th {
    vertical-align: bottom;
    border: 1px solid #00000030;
}
    </style>
    <!-- begin::main content -->
    <main class="main-content" style="padding-top:0px">
        <?php
            /*$booking_id = $_GET['id'];
            $sql_customer = "SELECT *,a.booking_type,a.billing_no,a.billing_type,date_format(a.billing_date,'%d/%m/%Y') as billing_date,d.customer_id,d.customer_name,d.company_name,d.gst_no,d.address FROM tbl_booking  a  
            left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  d.delete_status!='0' and a.booking_id='$booking_id'";
            $query_customer = mysqli_query($conn, $sql_customer);
            $row_customer = mysqli_fetch_array($query_customer);

            $booking_type=$row_customer['booking_type'];
            $billing_no=$row_customer['billing_no'];
            $billing_date=$row_customer['billing_date'];
            $customer_company=$row_customer['company_name'];
            $customer_address=$row_customer['address'];
            $customer_gst_no=$row_customer['gst_no'];
            $cgst=$row_customer['cgst'];
            $sgst=$row_customer['sgst'];*/



            

        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-right d-print-none" style="text-align: center!important;margin-top:0px">
                            <a href="javascript:window.print()" class="btn btn-success m-l-5 text-right" style="margin-top:0px;margin-right:15px;color: #fff"> <i class="fa fa-print m-r-5"></i> Print
                            </a>
                        </div>
                        <div class="watermark"><img src="images/sm_logo.jpeg" alt=""></div>
                        

                        <!--div class="row" style="margin-top: 50px;">
                            <div class="col-sm-12">
							<?php //if($row_customer['billing_type']=='1'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">PRO FORMA</h3>
							<?php //} else if($row_customer['billing_type']=='2'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">INVOICE</h3>
							<?php //} else if($row_customer['billing_type']=='3'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">DEBIT NOTE</h3>
							<?php //} else if($row_customer['billing_type']=='4'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">CREDIT NOTE</h3>
							<?php //} else if($row_customer['billing_type']=='5'){ ?>
							<h3 style="text-align: center;padding: 5px;font-size: 20px;border: solid;border-color: #f0f0f0;margin-top: -20px;">PURCHASE INVOICE</h3>
							<?php //} ?>
							
                            <div class="col-md-12" style="border: solid;border-color: #f0f0f0;margin-top: -11px;">
					 
                    <div class="row">
                        <div class="col-md-6" style="border-right: solid;border-color: #f0f0f0">
							<p><b>Service Provider :</b><br>
							<?php                           
							  //$sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
							  //$resul = $conn->query($sql);  
							  //$row = $resul->fetch_assoc();
							 ?>
								<b><?php //echo $row['cname']; ?></b>,<br>
								<?php //echo nl2br ($row['addr']);?><br>
								<b>GST No :</b> <?php //echo $row['gstno']; ?>
							</p><hr>
                            <p><b>Consin :</b><br>
								<?php //if(!empty($customer_company)){ ?>
								<?php //echo $customer_company; ?><br>
								<?php //} ?>                                                
								<?php //if(!empty($customer_address)){ ?>
								<?php //echo $customer_address; ?>
								<?php //} ?><br>
								<?php //if(!empty($customer_gst_no)){ ?> 
								GST No : <?php //echo $customer_gst_no ?>
								<?php //} ?>
							</p>
						</div>
                        <div class="col-md-6">
							<p><b>Invoice No. & Date </b>: <?php //echo $billing_no ?> & <?php //echo $billing_date ?><br>
								Buyer's Order No. : <?php //echo nl2br ($row_customer['order_detail']); ?> <br>
							</p>
						</div>
					</div>
					</div-->


                    <style>
                        .report-footer{
                            position: fixed;
                            bottom: 0;
                            background:red;
                            display: block;
                        }
                    </style>


                    <div class="row" style="margin-top: 25px;">
                            

                            <?php                           
                                $sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
                                $resul = $conn->query($sql);  
                                $row = $resul->fetch_assoc();
                            ?>

                            <div class="col-sm-12" style="border: 1px #00000030 solid">
								<div class="row" style="padding-bottom: 5px;padding-top: 15px;">
                                    <div class="col-sm-12" style="text-align: center;">
                                        <img src="userdata/images/jayam_logo.png" alt="Jayam Hydraulics Engineering" style="max-height: 68px; margin-bottom: 6px; display: inline-block;"><br>
                                        <h2 style="font-size: 26px;font-weight: 800;color: #08444d;margin: 0 0 5px 0;">Jayam Hydraulic Engineering</h2>
                                        <p style="font-size: 15px;color: #333;line-height: 22px;margin: 0 0 8px 0;">
                                            <?php echo nl2br($row['addr']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div> 
                            
							
                                <div class="col-sm-12" style="">
                        
                                    <div class="row">
                                        <div class="col-sm-6" style="border: 1px #00000030 solid">                                          
                                            
                                            <p><b>Supplier Details :</b><br>
                                            <?php                           
                                                $sql_cus = "SELECT * FROM tbl_supplier WHERE  supplier_id='".$_GET['id']."'";
                                                $resul_cus = $conn->query($sql_cus);  
                                                $row_cus = $resul_cus->fetch_assoc();
                                                ?>
                                                <b><?php echo $row_cus['supplier_name']; ?></b>,<br>
                                                <b><?php echo $row_cus['company_name']; ?></b>,<br>
                                                <?php echo nl2br ($row_cus['address']);?><br>
                                                <?php echo nl2br ($row_cus['mblno']);?><br>
                                                GST : <?php echo $row_cus['gst_no ']; ?>,<br>
                                            
                                        </div>
                                        <div class="col-sm-6" style="border: 1px #00000030 solid">                                            

                                            <!--p><b>Date From</b>: 01/11/2022<br>
                                            <b>Date To</b> : 30/11/2022<br>
                                            </p-->
                                        </div>
                                    </div>
                                </div>

                                <table  class="table table-striped table-bordered" width="100%"  style="border: none;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;text-align: center">S.No</th>
                                            <th style="width: 10%;text-align: center">Date</th>
                                            <th style="width: 35%;text-align: center">Description</th>
                                            <th style="width: 10%;text-align: center">DOC TYPE</th>
                                            
                                            <th style="width: 10%;text-align: center">Debit</th>
                                            <th style="width: 10%; text-align: center;">Credit</th>
                                            <th style="width: 10%; text-align: center;">Balance&nbsp;(INR)</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                        $sql = "select create_date,purchase_id,date_format(billing_date,'%d/%m/%Y') as billing_date,dc_no,grand_total_amount as amount,total_amount,1 from tbl_raw_purchase where delete_status='NDL' and supplier_id='".$_GET['id']."'   UNION ALL select create_date,purchase_id,date_format(billing_date,'%d/%m/%Y') as billing_date,dc_no,pay_amount as amount,NULL as total_amount,2 from tbl_payment where delete_status='NDL' and supplier_id='".$_GET['id']."' order by create_date ASC";

                                        $query=mysqli_query($conn, $sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys");
                                        $i=1;
                                        $balance=0;
                                        while( $row=mysqli_fetch_array($query) ) {  // preparing an array
                                        

                                        if($row['1']=='1'){



                                            $pur_sql = "select *,sum(qty) as total_qty,uom_id from tbl_raw_purchase_details where delete_status='NDL'  and purchase_id='".$row['purchase_id']."'";
                                            $pur_query=mysqli_query($conn, $pur_sql);
                                            $pur_row=mysqli_fetch_array($pur_query);
                                            
                                            $balance=$balance+$row['amount'];


                                            $raw_sql = "SELECT *,group_concat(b.raw_material_id SEPARATOR ',<br/>') as raw_material_id FROM tbl_raw_purchase  a 
inner join tbl_raw_purchase_details b on a.purchase_id=b.purchase_id  WHERE  a.delete_status!='0' and  b.delete_status!='0' and b.purchase_id='".$row['purchase_id']."' ";
$raw_query=mysqli_query($conn, $raw_sql);
$raw_row=mysqli_fetch_array($raw_query);

$product_list1=explode(",<br/>",$raw_row['raw_material_id']);

		$excess1=NULL;
		$excess1.='';		
		$j=0;
		foreach($product_list1 as $product){			
		
			$gql3 = "SELECT * FROM tbl_raw_material where delete_status='NDL' and id='".$product."' ";

			$exec_gql3 = mysqli_query($conn, $gql3);
			
			while ($fetch_gql3 = mysqli_fetch_array($exec_gql3)) {
				$excess1.= $fetch_gql3["name"];
				
			}
			if(!empty($excess)){
				$excess1.="<br>";
				
			}
			else{
				$excess1.='';				
			}

		$j++;
		}


                                        $uom_sql = "SELECT * FROM  tbl_uom   where uom_id='".$pur_row["uom_id"]."' and delete_status='NDL'";

                                        $uom_query=mysqli_query($conn, $uom_sql) or die("tbl_prpty-grPrpty_Id-data.php: get tbl_prptys4");
                                        $uom_row=mysqli_fetch_array($uom_query);


                                            ?>
                                            <tr style="page-break-inside: avoid">
                                                <td class="text-center"><?php echo $i; ?></td>
                                                <td class="text-center"><?php echo $row['billing_date']; ?></td>
                                                <td class="text-center"><b>Invoice No :</b><?php echo $row['dc_no']; ?><br> <b>Raw Product : </b><?php echo $excess1; ?><br><b> Qty : </b><?php echo $pur_row['total_qty']; ?> (<?php echo $uom_row['uom_name']; ?>)<br><b> Rate : </b><?php echo $raw_row['rate_tax']; ?></td>
                                                <td class="text-center">Purchase</td>                                              
                                                <td class="text-center"><?php echo $row['amount']; ?></td>
                                                <td class="text-center" style="width: 15%; text-align: right;"></td>
                                                <td class="text-center" style="width: 15%; text-align: right;"><?php echo $balance; ?></td>
                                                
                                            </tr>

                                        <?php } 
                                        if($row['1']=='2'){

                                            $pay_sql = "select * from tbl_payment where delete_status='NDL'  and purchase_id='".$row['purchase_id']."'";
                                            $pay_query=mysqli_query($conn, $pay_sql);
                                            $pay_row=mysqli_fetch_array($pay_query);


                                            if($pay_row['payment_mode']==1){
                                                $payment_mode='UPI';
                                            }else if($pay_row['payment_mode']==2){
                                                $payment_mode='Card';
                                            }else if($pay_row['payment_mode']==3){
                                                $payment_mode='Cash';
                                            }else if($pay_row['payment_mode']==4){
                                                $payment_mode='Bank Transfer';
                                            }else if($pay_row['payment_mode']==5){
                                                $payment_mode='Cheque';
                                            }else if($pay_row['payment_mode']==6){
                                                $payment_mode='Other';
                                            }else{
                                                $payment_mode='-';
                                            }


                                            $bank_sql = "SELECT * FROM tbl_bank_details WHERE  delete_status!='0' and  id='".$pay_row['bank_id']."'";

                                            $bank_query=mysqli_query($conn, $bank_sql);
                                            $bank_row=mysqli_fetch_array($bank_query);


                                            $balance=$balance-$row['amount'];
                                            ?>
                                            <tr style="page-break-inside: avoid">
                                                <td class="text-center"><?php echo $i; ?></td>
                                                <td class="text-center"><?php echo $row['billing_date']; ?></td>
                                                <td class="text-center"><b>Invoice No :</b><?php echo $row['dc_no']; ?><br> <b>Payment Mode : </b><?php echo $payment_mode; ?> <b>Bank Name : </b><?php echo $bank_row['bank_name']; ?></td>
                                                <td class="text-center">Payment</td>                                              
                                                <td class="text-center"></td>
                                                <td class="text-center" style="width: 15%; text-align: right;"><?php echo $row['amount']; ?></td>
                                                <td class="text-center" style="width: 15%; text-align: right;"><?php echo $balance; ?></td>
                                                
                                            </tr>

                                        <?php }  $i++; }?>

                                        

                                        <tr style="page-break-inside: avoid">
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center" colspan="4"><b>Out Standing Balance :</b></td>
                                            
                                            <td class="text-center" style="width: 15%; text-align: right;"><b><?php echo $balance; ?></b></td>
                                                
                                        </tr>
                                            

                                    </tbody>                                   
                                    				
									
									
                                </table>


                                
                                


                                
                            </div>

                        </div>



                    </div>
                </div>
            </div>
        </div>
    </main>




    <!-- end::main content -->
    <style>
        .dataTables_length {
            text-align: left;
        }

        .dataTables_filter {
            text-align: left;
        }
    </style>
    <!-- begin::global scripts -->
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
<style>
    .card .card-body,
    .page-header .card-body {
        padding: 17px;
        padding-bottom: 0px;
    }

    @media print {
        .bottomdiv {
            display: none !important;
        }

        body {
            padding: 0;
        }
    }

    @media(min-width:992px) {
        .navbar-nav {
            display: block !important;
            width: 100%;
        }

        .userdiv {
            float: right;
        }

        .mybut {
            margin-top: 33px;
        }
    }

    @media(max-width:480px) {
        nav.navbar .header-logo a img {
            width: 180px;
        }
    }

    .table td {
        vertical-align: bottom !important;
        padding: 5px;
    }
</style>


<script>

</script>

</html>