<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Karur Chambers</title>
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
	background: #9e9e9e66!important;
    color: #000000!important;
}
.table thead th {
    vertical-align: bottom;
    border: 1px solid #00000030;
}
    </style>
    <!-- begin::main content -->
    <main class="main-content" style="padding-top:0px">
        

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-right d-print-none" style="text-align: center!important;margin-top:0px">
                            <a href="javascript:window.print()" class="btn btn-success m-l-5 text-right" style="margin-top:0px;margin-right:15px;color: #fff"> <i class="fa fa-print m-r-5"></i> Print
                            </a>
                        </div>
                        <div class="watermark"><img src="images/sm_logo.jpeg" alt=""></div>
                        

                        


                    <style>
                        .report-footer{
                            position: fixed;
                            bottom: 0;
                            background:red;
                            display: block;
                        }
                    </style>


                    <div class="row" style="margin-top: 50px;">
                            
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
                                            <?php echo isset($row['addr']) ? nl2br($row['addr']) : ''; ?>
                                        </p>
                                        <h3 style="font-size: 22px;font-weight: 700;margin: 0;color: #000;">Customer wise Outstanding Report</h3>
                                    </div>
                                </div>  
								<div class="row" style="border-top: 1px #00000030 solid">							
									<div class="col-sm-4">
										<p style="margin-top: 3px;margin-bottom: 3px!important;float: left"><b>Phone :</b> 70314 12345, 70316 12345</p></p>
									</div>						
									<div class="col-sm-4">
										<p style="margin-top: 3px;margin-bottom: 3px!important;text-align: center">
										</p>
									</div>						
									<div class="col-sm-4">
										<p style="margin-top: 3px;margin-bottom: 3px!important;float: right"><b>Prop :</b> S. Sudarsan</p>
									</div>
								</div>   
                            </div>
                            
							
                                <div class="col-sm-12" style="">
                        
                                    <div class="row">
                                    <div class="col-sm-6" style="border: 1px #00000030 solid">                                              
                                            
                                            <p><b>Service Provider :</b><br>
                                            <?php                           
                                            $sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
                                            $resul = $conn->query($sql);  
                                            $row = $resul->fetch_assoc();
                                            ?>
                                                <b><?php echo $row['cname']; ?></b>,<br>
                                                <?php echo nl2br ($row['addr']);?><br>
                                                <b>GST No :</b> <?php echo $row['gstno']; ?>
                                            </p>
                                            
                                        </div>
                                        <div class="col-sm-6" style="border: 1px #00000030 solid">                                            

                                            <p><b>Customer Detail :</b><br>
                                                <?php                           
                                                $sql_cus = "SELECT * FROM tbl_customer WHERE customer_id='".intval($_GET['id'])."'";
                                                $resul_cus = $conn->query($sql_cus);  
                                                $row_cus = $resul_cus ? $resul_cus->fetch_assoc() : null;
                                                ?>
                                                <b><?php echo htmlspecialchars($row_cus['customer_name'] ?? ''); ?></b>,<br>
                                                <?php echo nl2br(htmlspecialchars($row_cus['address'] ?? '')); ?><br>
                                            </p>
                                        </div>
                                    </div>
                                </div>


                                <table id='detailsgrid' class="table table-striped table-bordered" width="100%" style="border: none;">
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
                                        $sql = "SELECT create_date, dc_id, DATE_FORMAT(billing_date,'%d/%m/%Y') AS billing_date, dc_no, grand_total_amount AS amount, total_amount, 1 
                                                FROM tbl_gst_invoice 
                                                WHERE delete_status='NDL' AND customer_id='".intval($_GET['id'])."' 
                                                UNION 
                                                SELECT create_date, dc_id, DATE_FORMAT(billing_date,'%d/%m/%Y') AS billing_date, dc_no, pay_amount AS amount, NULL AS total_amount, 2 
                                                FROM tbl_receipt 
                                                WHERE delete_status='NDL' AND customer_id='".intval($_GET['id'])."' 
                                                ORDER BY STR_TO_DATE(billing_date, '%d/%m/%Y') ASC, create_date ASC";

                                        $query=mysqli_query($conn, $sql);
                                        $i=1;
                                        $balance=0;
                                        $total_debit=0;
                                        $total_credit=0;
                                        while( $row = $query ? mysqli_fetch_array($query) : null ) {
                                            $row_amount = floatval($row['amount'] ?? 0);

                                            if($row['1']=='1'){
                                                $balance += $row_amount;
                                                $total_debit += $row_amount;
                                                ?>
                                                <tr style="page-break-inside: avoid">
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($row['billing_date']); ?></td>
                                                    <td><b>Invoice No : </b><?php echo htmlspecialchars($row['dc_no']); ?></td>                                              
                                                    <td class="text-center">Bill</td>
                                                    <td style="text-align: right;"><?php echo number_format($row_amount, 2, '.', ''); ?></td>
                                                    <td style="text-align: right;">-</td>
                                                    <td style="text-align: right;"><?php echo number_format($balance, 2, '.', ''); ?></td>
                                                </tr>
                                            <?php } else if($row['1']=='2'){
                                                $balance -= $row_amount;
                                                $total_credit += $row_amount;

                                                $pay_sql = "SELECT * FROM tbl_receipt WHERE delete_status='NDL' AND dc_id='".intval($row['dc_id'])."'";
                                                $pay_query=mysqli_query($conn, $pay_sql);
                                                $pay_row = $pay_query ? mysqli_fetch_array($pay_query) : null;

                                                $pm = $pay_row['payment_mode'] ?? '';
                                                if($pm == 1 || $pm == '1') $payment_mode = 'UPI';
                                                else if($pm == 2 || $pm == '2') $payment_mode = 'Card';
                                                else if($pm == 3 || $pm == '3') $payment_mode = 'Cash';
                                                else if($pm == 4 || $pm == '4') $payment_mode = 'Bank Transfer';
                                                else if($pm == 5 || $pm == '5') $payment_mode = 'Cheque';
                                                else if($pm == 6 || $pm == '6') $payment_mode = 'Other';
                                                else $payment_mode = '-';

                                                $bank_name = '-';
                                                if(!empty($pay_row['bank_id'])){
                                                    $bank_sql = "SELECT bank_name FROM tbl_bank_details WHERE delete_status!='0' AND id='".intval($pay_row['bank_id'])."'";
                                                    $bank_query=mysqli_query($conn, $bank_sql);
                                                    if($bank_query && $bank_r = mysqli_fetch_array($bank_query)){
                                                        $bank_name = $bank_r['bank_name'] ?? '-';
                                                    }
                                                }
                                                ?>
                                                <tr style="page-break-inside: avoid">
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($row['billing_date']); ?></td>
                                                    <td><b>Invoice No : </b><?php echo htmlspecialchars($row['dc_no']); ?><br><b>Payment Mode : </b><?php echo $payment_mode; ?><?php if($bank_name !== '-'){ ?> <b>Bank Name : </b><?php echo htmlspecialchars($bank_name); ?><?php } ?></td>
                                                    <td class="text-center">Receipt</td>                                              
                                                    <td style="text-align: right;">-</td>
                                                    <td style="text-align: right;"><?php echo number_format($row_amount, 2, '.', ''); ?></td>
                                                    <td style="text-align: right;"><?php echo number_format($balance, 2, '.', ''); ?></td>
                                                </tr>
                                            <?php }
                                            $i++;
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align:right;font-size: 18px !important;">Total:</th>
                                            <th style="text-align:right;color: red;font-size: 18px !important;"><?php echo number_format($total_debit, 2, '.', ''); ?></th>
                                            <th style="text-align:right;color: red;font-size: 18px !important;"><?php echo number_format($total_credit, 2, '.', ''); ?></th>
                                            <th style="text-align:right;color: red;font-size: 18px !important;"><?php echo number_format($balance, 2, '.', ''); ?></th>
                                        </tr>
                                    </tfoot>
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