<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jayam Hydraulic Engineering (Spares)</title>
    <link rel="icon" type="image/x-icon" href="images/logo.png">

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

    <style>
        body {
            color: black;
        }

        #tablemainbind {
            vertical-align: center;
            padding: 0.2rem !important;
        }

        .table td {
            vertical-align: center !important;

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
/*.table-striped tbody tr:nth-of-type(odd){
	background-color: #fff;
}*/
    </style>

    <!-- begin::main content -->
    <main class="main-content" style="padding-top:0px">
        <?php

            /*$sql="SELECT *,a.dc_id,a.dc_no,a.total_amount,a.grand_total_amount,d.customer_id,d.customer_name,e.uom_id,e.uom_name,group_concat(b.raw_material_id SEPARATOR ',<br/>') as raw_material_id,group_concat(b.hsn_code SEPARATOR ',<br/>') as hsn_code,group_concat(b.purchase_rate SEPARATOR ',<br/>') as rate,date_format(a.create_date,'%d/%m/%Y %r') as create_date,date_format(a.billing_date,'%d/%m/%Y') as billing_date,date_format(a.update_date,'%d/%m/%Y %r') as update_date,a.created_by,a.updated_by FROM tb_dc  a 
            inner join tb_dc_details b on a.dc_id=b.dc_id 
            left join  tbl_uom e on e.uom_id=b.uom_id 
            left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and    d.delete_status!='0' and a.dc_id='".$_GET['id']."'";
            $exec_sql=mysqli_query($conn,$sql);
            $fetch_sql=mysqli_fetch_array($exec_sql);*/

            $dc_id = $_GET['id'];
            $sql_customer = "SELECT *,a.dc_no,date_format(a.billing_date,'%d/%m/%Y') as billing_date,d.customer_id,d.customer_name,d.company_name,d.gst_no,d.address FROM tbl_dc  a  
            left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  d.delete_status!='0' and a.dc_id='$dc_id'";
            $query_customer = mysqli_query($conn, $sql_customer);
            $row_customer = mysqli_fetch_array($query_customer);

            
            $billing_no=$row_customer['dc_no'];
            $billing_date=$row_customer['billing_date'];
            $customer_name=$row_customer['customer_name'];
            $customer_company=$row_customer['company_name'];
            $state_code=$row_customer['state_code'];
            $state=$row_customer['state'];
            $customer_address=$row_customer['address'];
            $customer_gst_no=$row_customer['gst_no'];
            $cgst=$row_customer['cgst'];
            $sgst=$row_customer['sgst'];

            if($row_customer["driver_type"]==1){ $driver_type='Own'; }else{ $driver_type='Other'; }

            if($row_customer["driver_type"]=='1'){

                $gql_driver = "SELECT * FROM tbl_employee_details where delete_status='NDL' and emp_id='".$row_customer["driver_id"]."' ";
                $exec_gql_driver = mysqli_query($conn, $gql_driver);
                $fetch_gql_driver = mysqli_fetch_array($exec_gql_driver);
        
                $driver_name = $fetch_gql_driver["emp_name"];
        
                $gql_vechicle = "SELECT * FROM tbl_vechicle_details where delete_status='NDL' and vechicle_id='".$row_customer["vechicle_id"]."' ";
                $exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
                $fetch_gql_vechicle = mysqli_fetch_array($exec_gql_vechicle);
        
                $vechicle_name = $fetch_gql_vechicle["vechicle_name"];
                
        
            }else if($row_customer["driver_type"]=='2'){
        
                $driver_name= $row_customer["driver_name"];	
        
                $vechicle_name = $row_customer["vechicle_number"];	
                
        
            }else{
                $driver_name = '-';
        
                $vechicle_name = '-';
            }

            

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
                        

                    <div class="row" style="margin-top: 10px;">
                            
                            <?php                           
                                $sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
                                $resul = $conn->query($sql);  
                                $row = $resul->fetch_assoc();
                            ?>

                            <div class="col-sm-12" style="border: solid;border-color: #f0f0f0; ">

                                
                                    <div class="row" style="padding-bottom: 25px;">
                                        <div class="col-sm-2">
                                            <img src="images/logo.png" width="100" alt="">
                                        </div>
                                        <div class="col-sm-4" style="float: left">
                                        <p style="font-size: 16px; color:black;font-weight: 900; margin-bottom: 0rem;">KARUR CHAMBERSS</p><span style="font-size: 16px; color:black;"><?php echo nl2br ($row['addr']);?><br>
                                                GST No : <?php echo $row['gstno']; ?></span>
        
                                        </div>
                                        <div class="col-sm-6">
                                        <span style="float:right; text-align: right; padding: 10px;font-size: 14px;margin-top: -20px;"> <br>
                                                <span style="font-size: 30px; width: 15%;  color:black; font-weight: bold">DC INVOICE</span>
                                            </span>
                                        </div>
                                    </div>

                            </div>                        
                            
							
                                <div class="col-sm-12" style="border: solid;border-color: #f0f0f0; margin-top: -11px;">
                        
                                    <div class="row">
                                        <div class="col-sm-6" style="border-right: solid;border-color: #f0f0f0">                                            
                                            
                                            <br>
                                            <p><b>Customer Details / Billed To:</b><br>
                                                <?php if(!empty($customer_name)){ ?>
                                                <?php echo $customer_name; ?><br>
                                                <?php } ?>
                                                <?php if(!empty($customer_company)){ ?>
                                                <?php echo $customer_company; ?><br>
                                                <?php } ?>                                                
                                                <?php if(!empty($customer_address)){ ?>
                                                <?php echo $customer_address; ?>
                                                <?php } ?><br>
                                                <?php if(!empty($customer_gst_no)){ ?> 
                                                GST No : <?php echo $customer_gst_no ?>
                                                <?php } ?>

                                                <span style="font-size: 15px;  color:black; font-weight: bold; float:right;">State&nbsp;&nbsp;Code&nbsp; : <?php echo $state_code ?></span>
                                            </p>
                                            
                                        </div>
                                        <div class="col-sm-6"> 
                                        <br>
                                        <p>
                                                <span style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Invoice No&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $billing_no ?></span>

                                                </br>

                                                <span style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Invoice&nbsp;Date&nbsp;&nbsp;</span>
                                                <span style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $billing_date ?></span>
                                                </br>
                                                <span style="font-size: 15px; width: 15%;  color:black; font-weight: bold">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $state; ?></span></br>
                                                
                                            <b>Transportation Mode: <?php echo $driver_type; ?></b><br>
                                                <span style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Vechicle&nbsp;Number&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $vechicle_name; ?></span>

                                                </br>

                                                <span style="font-size: 15px;   color:black; font-weight: bold">Driver&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span style="font-size: 15px;   color:#15803d; font-weight: bold"> : <?php echo $driver_name ?></span>
                                            </p>
                                            
                                        </div>
                                        
                                    </div>
                                   
                                </div>

                                <table  class="table table-striped table-bordered" width="100%"  style="border: none;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%; text-align:center;">Sl.no</th>
                                            <th style="width: 25%; text-align:center;">Product</th>                                         
                                            <th style="width: 20%; text-align:center;">Quantity</th>
                                            <th style="width: 25%; text-align:center;">Rate</th>
                                            <th style="width: 25%; text-align:center;">Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                            $sql="SELECT b.*,a.total_amount,a.grand_total_amount FROM tbl_dc  a 
                                            inner join tbl_dc_details b on a.dc_id=b.dc_id
                                            left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and  d.delete_status!='0' and b.dc_id='".$_GET['id']."'";
                                            $query=mysqli_query($conn,$sql);
                                            
                                            $j=1;
                                            $total_amount=0;
                                            $total_qty=0;
                                            $total_product_rate=0;
                                        while ($fetch_booking_details = mysqli_fetch_array($query)) {
                                            
                                            $total_amount=$total_amount+$fetch_booking_details['rate'];  
                                            $total_qty=$total_qty+$fetch_booking_details['qty']; 
                                            $total_product_rate=$total_product_rate+$fetch_booking_details['product_rate'];  
                                            
                                            $gql3 = "SELECT * FROM tbl_products  where delete_status='NDL' and product_id='".$fetch_booking_details['product_id']."' ";
											$exec_gql3 = mysqli_query($conn, $gql3);			
											$fetch_gql3 = mysqli_fetch_array($exec_gql3);

                                            
                                        ?>


                                            <tr style="page-break-inside: avoid">
                                                <td class="text-center"><?php echo $j; ?></td>
                                                <td class="text-center"><?php echo $fetch_gql3["product_name"]; ?></td>
                                                                                         
                                                
                                                <td class="text-center" style="font-size: 15px; text-align: right; width: 15%;  color:red; font-weight: bold"><?php echo $fetch_booking_details['qty']; ?></td>
                                                <td class="text-center"  style="font-size: 15px; text-align: right; width: 15%;  color:green; font-weight: bold"><?php echo number_format((float) $fetch_booking_details['product_rate'], 2, '.', ''); ?></td>
                                                <td class="text-center" style="font-size: 15px; text-align: right; width: 15%;  color:green; font-weight: bold"><?php echo number_format((float)$fetch_booking_details['rate'], 2, '.', ''); ?></td>
                                                
                                                
                                            </tr>

                                        <?php

                                            $j++;

                                            
                                        } ?>

                                        <?php

                                        //$i = $ten - $count;
                                       // for ($z = $count; $z < $ten; $z++) { ?>

                                            <tr style="page-break-inside: avoid">
                                                
                                                <td></td>
                                                <td></td>
                                                <td></td>
												<td></td>
                                                <td></td>
                                                
                                            </tr>


                                        <?php //} ?>

											
                                                                                   
                                            

                                            <?php
                                            
                                            function convertToIndianCurrency($number) {
                                                $no = round($number);
                                                $decimal = round($number - ($no = floor($number)), 2) * 100;    
                                                $digits_length = strlen($no);    
                                                $i = 0;
                                                $str = array();
                                                $words = array(
                                                    0 => '',
                                                    1 => 'One',
                                                    2 => 'Two',
                                                    3 => 'Three',
                                                    4 => 'Four',
                                                    5 => 'Five',
                                                    6 => 'Six',
                                                    7 => 'Seven',
                                                    8 => 'Eight',
                                                    9 => 'Nine',
                                                    10 => 'Ten',
                                                    11 => 'Eleven',
                                                    12 => 'Twelve',
                                                    13 => 'Thirteen',
                                                    14 => 'Fourteen',
                                                    15 => 'Fifteen',
                                                    16 => 'Sixteen',
                                                    17 => 'Seventeen',
                                                    18 => 'Eighteen',
                                                    19 => 'Nineteen',
                                                    20 => 'Twenty',
                                                    30 => 'Thirty',
                                                    40 => 'Forty',
                                                    50 => 'Fifty',
                                                    60 => 'Sixty',
                                                    70 => 'Seventy',
                                                    80 => 'Eighty',
                                                    90 => 'Ninety');
                                                $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
                                                while ($i < $digits_length) {
                                                    $divider = ($i == 2) ? 10 : 100;
                                                    $number = floor($no % $divider);
                                                    $no = floor($no / $divider);
                                                    $i += $divider == 10 ? 1 : 2;
                                                    if ($number) {
                                                        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
                                                        $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
                                                    } else {
                                                        $str [] = null;
                                                    }  
                                                }
                                                
                                                $Rupees = implode(' ', array_reverse($str));
                                                $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
                                                return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
                                            }
                                                ?>

                                        <?php  
                                            $cgst_amount=number_format((float)$total_amount * ($row_supplier['cgst'] / 100), 2, '.', '');
                                            $sgst_amount=number_format((float)$total_amount * ($row_supplier['sgst'] / 100), 2, '.', '');
                                            $total_amount1=number_format((float)(($total_amount+$row_customer['gst_total_amount'])-$discount), 2, '.', '');
                                            $total_amount_word=$total_amount1;
                                            
                                        ?>
                                      

                                        
                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">
                                                
												

											</tr>

                                            


                                           

                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">                                              

                                            <td colspan='3'   style="padding:2px; font-size: 20px;  width: 15%;  color:blue; font-weight: bold; text-align: center;
        vertical-align: middle!important;"></td>
                                                <td    style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold; text-align: center;
        vertical-align: middle!important;">Grand Total</td>
                                                <td    style="padding:2px; font-size: 15px;  width: 15%;  color:blue; font-weight: bold; text-align: center;
        vertical-align: middle!important;"><?php echo number_format((float)(($total_amount+$row_customer['gst_total_amount'])-$discount), 2, '.', ''); ?></td>

												
											</tr>

                                           
                                            					
											
											
                                    </tbody>
                                    <tfoot >
										
										<tr style="page-break-inside: avoid">
										
											<td colspan="3" class="text-center" style="vertical-align: top!important; padding:2px; font-size: 20px;  color:blue; font-weight: bold">
                                            <br>
                                                <p><b>Rupees :</b> <?php  echo convertToIndianCurrency($total_amount_word);?></p>
											</td>

                                            <td colspan="1" class="text-right">
											</td>
											
											<td colspan="4" style="text-align: center">
											<p style="margin-bottom: 0rem;font-size:15px"><b>FOR Karur Chamberss</b></p>
												<p style="width:130px; height:70px; text-align:center;object-fit:contain"></p>
											<p style="text-align:center;font-size:15px">Authorizes Signatory</p>
											</td>
											
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