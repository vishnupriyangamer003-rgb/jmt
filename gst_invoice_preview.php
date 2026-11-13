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
			font-size: 19px!important;
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

            $dc_id = $_GET['id'];
            $sql_customer = "SELECT *,a.dc_no,date_format(a.billing_date,'%d/%m/%Y') as billing_date,d.customer_id,d.customer_name,d.company_name,d.state_code,a.driver_type,d.state,d.gst_no,d.address FROM tbl_gst_invoice  a  
            left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  d.delete_status!='0' and a.dc_id='$dc_id'";
            $query_customer = mysqli_query($conn, $sql_customer);
            $row_customer = mysqli_fetch_array($query_customer);

            
            

            $vechicle_name = '';
            if (!empty($row_customer["vechicle_number"])) {
                $vechicle_name = $row_customer["vechicle_number"];
            } else if (!empty($row_customer["vechicle_id"])) {
                $gql_vechicle = "SELECT * FROM tbl_vechicle_details where vechicle_id='".mysqli_real_escape_string($conn, $row_customer["vechicle_id"])."' ";
                $exec_gql_vechicle = mysqli_query($conn, $gql_vechicle);
                $fetch_gql_vechicle = $exec_gql_vechicle ? mysqli_fetch_array($exec_gql_vechicle) : null;
                if (!empty($fetch_gql_vechicle["vechicle_name"])) {
                    $vechicle_name = $fetch_gql_vechicle["vechicle_name"];
                } else {
                    $vechicle_name = $row_customer["vechicle_id"];
                }
            } else if (!empty($row_customer["refrence_name"])) {
                $vechicle_name = $row_customer["refrence_name"];
            }

            if (empty($vechicle_name)) {
                $vechicle_name = '-';
            }

            $driver_name = '';
            if (!empty($row_customer["driver_name"])) {
                $driver_name = $row_customer["driver_name"];
            } else if (!empty($row_customer["driver_id"])) {
                $gql_driver = "SELECT * FROM tbl_employee_details where emp_id='".mysqli_real_escape_string($conn, $row_customer["driver_id"])."' ";
                $exec_gql_driver = mysqli_query($conn, $gql_driver);
                $fetch_gql_driver = $exec_gql_driver ? mysqli_fetch_array($exec_gql_driver) : null;
                if (!empty($fetch_gql_driver["emp_name"])) {
                    $driver_name = $fetch_gql_driver["emp_name"];
                }
            }
            if (empty($driver_name)) {
                $driver_name = '-';
            }

            if (($row_customer["driver_type"] ?? '') == '1') {
                $driver_type = 'Own';
            } else if (($row_customer["driver_type"] ?? '') == '2') {
                $driver_type = 'Other';
            } else {
                $driver_type = (!empty($vechicle_name) && $vechicle_name !== '-') ? 'Vehicle' : '-';
            }

            $billing_no=$row_customer['dc_no'];
            $billing_date=$row_customer['billing_date'];
            $customer_name=$row_customer['customer_name'];
            $customer_company=$row_customer['company_name'];
            $state_code=$row_customer['state_code'];
            $state=$row_customer['state'];
            $customer_address=$row_customer['address'];
            $customer_gst_no=$row_customer['gst_no'];
            $customer_state=$row_customer['state'];
            $cgst=(float)($row_customer['cgst'] ?? 0);
            $sgst=(float)($row_customer['sgst'] ?? 0);

            $discount=(float)($row_customer['discount'] ?? 0);

            $delivery_address=$row_customer['delivery_address'] ?? '';

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
                        

                    <div class="row" style="margin-top: 25px;">
                            
                            <?php                           
                                $sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
                                $resul = $conn->query($sql);  
                                $row = $resul->fetch_assoc();
                            ?>
                            <div class="col-sm-12" style="border: 1px #00000030 solid">
								<div class="row" style="padding-bottom: 0px;padding-top: 15px;">
									<div class="col-sm-12" style="text-align: center">
										<div class="col-sm-12" style="text-align: center;">
                                        <img src="userdata/images/jayam_logo.png" alt="Jayam Hydraulics Engineering" style="max-height: 68px; margin-bottom: 6px; display: inline-block;"><br>
                                        <h2 style="font-size: 26px;font-weight: 800;color: #08444d;margin: 0 0 5px 0;"><?php echo htmlspecialchars($row['cname'] ?: 'Jayam Hydraulic Engineering (Spares)'); ?></h2>
                                        <p style="font-size: 15px;color: #333;line-height: 22px;margin: 0 0 8px 0;">
                                            <?php echo nl2br(htmlspecialchars($row['addr'])); ?>
                                        </p>
                                        <h3 style="font-size: 22px;font-weight: 700;margin: 0;color: #000;">TAX INVOICE</h3>
                                    </div>
								<div class="row" style="border-top: 1px #00000030 solid">							
									<div class="col-sm-4">
										<p style="margin-top: 3px;margin-bottom: 3px!important;float: left"><b>GST No :</b> <?php echo $row['gstno']; ?></p>
									</div>						
									<div class="col-sm-4">
										<p style="margin-top: 3px;margin-bottom: 3px!important;text-align: center">
										<b>Phone :</b> 70314 12345, 70316 12345</p>
									</div>						
									<div class="col-sm-4">
										<p style="margin-top: 3px;margin-bottom: 3px!important;float: right"><b>Prop :</b> S. Sudarsan</p>
									</div>
								</div> 
                                </div>    
                            </div>
							
                                <div class="col-sm-12" style="">
                                    <div class="row">
                                        <div class="col-sm-6" style="border: 1px #00000030 solid"> 
                                           <p class="onepage_p" style="margin-top: 1rem;">
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Invoice No&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $billing_no ?></span>

                                                </br>

                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Invoice&nbsp;Date&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $billing_date ?></span>
                                                </br>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $row['adm_state']; ?></span></br>
                                                
                                                
                                            </p>
                                            
                                        </div>
                                        <div class="col-sm-6" style="border: 1px #00000030 solid"> 
                                           <p class="onepage_p" style="margin-top: 1rem;">
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Transportation Mode&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $driver_type; ?></span><br>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:black; font-weight: bold">Vechicle&nbsp;Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <span class="onepage_p" style="font-size: 15px; width: 15%;  color:#15803d; font-weight: bold"> : <?php echo $vechicle_name; ?></span>
                                            </p>
                                            
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6" style="border: 1px #00000030 solid">          
                                            
                                            <p class="onepage_p" style="margin-top: 1rem;margin-bottom: 2rem;"><b>Details of Receiver / Billed To:</b><br>
                                                <?php if(!empty($customer_name)){ ?>
                                                <?php echo $customer_name; ?><br>
                                                <?php } ?>
                                                <?php if(!empty($customer_company)){ ?>
                                                <?php echo $customer_company; ?><br>
                                                <?php } ?>                                                
                                                <?php if(!empty($customer_address)){ ?>
                                                <?php echo $customer_address; ?>
                                                <?php } ?> <br>                                             
                                                <?php if(!empty($customer_state)){ ?>
                                                <?php echo $customer_state; ?>
                                                <?php } ?>
                                                
												<br>
                                                <?php if(!empty($customer_gst_no)){ ?> 
                                                GST No : <?php echo $customer_gst_no ?>
                                                <?php } ?>

                                                <span class="onepage_p" style="font-size: 15px;  color:black; font-weight: bold; float:right;">State&nbsp;&nbsp;Code&nbsp; : <?php echo $state_code ?></span>
                                            </p>
                                        </div>
                                        <div class="col-sm-6" style="border: 1px #00000030 solid"> 
                                           
                                            <p class="onepage_p" style="margin-top: 1rem;margin-bottom: 2rem;"><b>Details of Consignee / Shipped To:</b><br>
                                                <?php if(!empty($delivery_address)){ ?>
                                                <?php echo $delivery_address; ?><br>
                                                <?php } ?>
                                                

                                                

                                            </p> 
                                            
                                        </div>
                                        
                                    </div>
                                </div>

                                <table  class="table table-striped table-bordered" width="100%"  style="border: none;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%; text-align:center;">S.no</th>
                                            <th style="width: 25%; text-align:center;">Product</th>
                                            <th style="width: 10%; text-align:center;">HSN&nbsp;Code</th>
                                            <th style="width: 5%; text-align:center;">Quantity</th>
                                            <th style="width: 20%; text-align:center;">Rate</th>
                                            <th style="width: 25%; text-align:center;">Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                            $sql="SELECT b.*,a.total_amount,a.grand_total_amount FROM tbl_gst_invoice  a 
                                            inner join tbl_gst_invoice_details b on a.dc_id=b.dc_id
                                            left join  tbl_customer d on d.customer_id=a.customer_id WHERE  a.delete_status!='0' and  b.delete_status!='0' and  d.delete_status!='0' and b.dc_id='".$_GET['id']."'";
                                            $query=mysqli_query($conn,$sql);
                                            
                                            $j=1;
                                            $total_amount=0;
                                            $total_qty=0;
                                            $total_product_rate=0;
                                        while ($fetch_booking_details = mysqli_fetch_array($query)) {
                                            
                                            $total_amount=$total_amount+(float)($fetch_booking_details['rate'] ?? 0);  
                                            $total_qty=$total_qty+(float)($fetch_booking_details['qty'] ?? 0); 
                                            $total_product_rate=$total_product_rate+(float)($fetch_booking_details['product_rate'] ?? 0);  
                                            
                                            $gql3 = "SELECT *, t2.uom_name FROM tbl_products t1 left join tbl_uom t2 on t1.uom_id=t2.uom_id where  product_id='".mysqli_real_escape_string($conn, $fetch_booking_details['product_id'])."' ";
											$exec_gql3 = mysqli_query($conn, $gql3);			
											$fetch_gql3 = $exec_gql3 ? mysqli_fetch_array($exec_gql3) : null;

                                            
                                        ?>


                                            <tr style="page-break-inside: avoid">
                                                <td class="text-center"><?php echo $j; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($fetch_gql3["product_name"] ?? '-'); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($fetch_gql3["hsn_code"] ?? '-'); ?></td>
                                                <td class="text-center" style="font-size: 15px; text-align: right; width: 15%;  color:#000; font-weight: bold"><?php echo $fetch_booking_details['qty']; ?></td>
                                                <td class="text-center"  style="font-size: 15px; text-align: right; width: 15%;  color:#000; font-weight: bold"><?php echo number_format((float) $fetch_booking_details['product_rate'], 2, '.', ''); ?></td>
                                                <td class="text-center" style="font-size: 15px; text-align: right; width: 15%;  color:#000; font-weight: bold"><?php echo number_format((float)$fetch_booking_details['rate'], 2, '.', ''); ?></td>
                                                
                                                
                                            </tr>

                                        <?php

                                            $j++;

                                            
                                        } ?>

                                        <?php

                                         $i = 7 - $j;
                                        for ($z = $j; $z < 7; $z++) { ?>

                                            <tr style="page-break-inside: avoid">
                                                
                                                <td>&nbsp;</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                
                                            </tr>


                                        <?php } ?>

											
                                                                                   
                                            

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
                                            // GST-inclusive: extract GST from the total
                                            $gst_rate_sum=(float)$cgst+(float)$sgst;
                                            $gst_incl=round((float)$total_amount * $gst_rate_sum / (100+$gst_rate_sum), 2);
                                            $cgst_amount=number_format($gst_rate_sum>0 ? round($gst_incl*$cgst/$gst_rate_sum,2) : 0, 2, '.', '');
                                            $sgst_amount=number_format($gst_incl-(float)$cgst_amount, 2, '.', '');
                                            $total_with_tax=number_format((float)$total_amount, 2, '.', '');
                                            $grand_total_calc=number_format((float)($total_with_tax-$discount), 2, '.', '');
                                            $total_amount_word=$grand_total_calc;
                                            
                                        ?>
                                        <tr>
                                                    <th colspan='4'; rowspan="1"><br>
													
													
                                                    </th>
                                                
                                                    
                                                    <td style="padding:2px; font-size: 16px;  width: 15%;  color:#000; font-weight: bold; text-align: center;
        vertical-align: middle!important;">Total  </td>                                               
												
                                                    <td  style="padding:2px; font-size: 15px;  width: 15%;  color:#ff6e38; font-weight: bold; text-align: center;
        vertical-align: middle!important;"><?php echo number_format((float)$total_amount, 2, '.', ''); ?></td>  

  
                                        </tr>

                                            
                                            
											<tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">
                                                

											<th colspan='4'; rowspan="1"><br>
													
													
                                                    </th>
												<th   style="padding:2px; font-size: 14px;  width: 15%;  color:#000; font-weight: bold; text-align: center;
        vertical-align: middle!important;">CGST <?php echo htmlspecialchars((string)$cgst); ?>%</th>											
                                                <th   style="padding:2px; font-size: 15px;  width: 15%;  color:#000; font-weight: bold; text-align: center;
        vertical-align: middle!important;"><?php echo $cgst_amount;?></th>

											</tr>
                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">
                                                

											<th colspan='4'; rowspan="1"><br>
													
													
                                                    </th>
												<th   style="padding:2px; font-size: 14px;  width: 15%;  color:#000; font-weight: bold; text-align: center;
        vertical-align: middle!important;">SGST <?php echo htmlspecialchars((string)$sgst); ?>%</th>												
                                                <th   style="padding:2px; font-size: 15px;  width: 15%;  color:#000; font-weight: bold; text-align: center;
        vertical-align: middle!important;"><?php echo $sgst_amount;?></th>

											</tr>

                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">                                              


											<th colspan='4'; rowspan="1"><br>
													
													
                                                    </th>
													
                                                <td    style="padding:2px; font-size: 15px;  width: 15%;  color:#000; font-weight: bold; text-align: center;
        vertical-align: middle!important;">Total + Tax</td>
                                                <td  style="padding:2px; font-size: 16px;  width: 15%;  color:#ff6e38; font-weight: bold; text-align: center;
        vertical-align: middle!important;"><?php echo $total_with_tax; ?></td>

												
											</tr>


                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">   

											<th colspan='4'; rowspan="1"><br>
													
													
                                                    </th>                                           

                                                <td    style="padding:2px; font-size: 15px;  width: 15%;  color:#000; font-weight: bold; text-align: center;
        vertical-align: middle!important;">Discount</td>
                                                <td   style="padding:2px; font-size: 15px;  width: 15%;  color:#000; font-weight: bold; text-align: center;
        vertical-align: middle!important;"><?php echo number_format((float)$discount, 2, '.', ''); ?></td>

												
											</tr>

                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">                                              

                                            <td colspan='4'>
												<p style="width: 65%;text-align: center;"><b>Rupees (In words) :</b> <?php  echo convertToIndianCurrency($total_amount_word);?></p> 
											</td>
                                            <td style="padding:2px; font-size: 15px;  width: 15%;  color:#000; font-weight: bold; text-align: center;vertical-align: middle!important;">Grand Total</td>
                                                <td    style="padding:2px; font-size: 16px;  width: 15%;  color:#ff6e38; font-weight: bold; text-align: center;
        vertical-align: middle!important;"><?php echo $grand_total_calc; ?></td>

												
											</tr>
											<?php $g_adv = (float)($row_customer['advance_amount'] ?? 0); $g_grand = (float)$grand_total_calc; ?>
                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">
                                            <td colspan='4'></td>
                                            <td style="padding:2px; font-size: 15px; color:#000; font-weight: bold; text-align: center;">Advance</td>
                                            <td style="padding:2px; font-size: 15px; color:#000; font-weight: bold; text-align: center;"><?php echo number_format($g_adv, 2, '.', ''); ?></td>
											</tr>
                                            <tr class="taxdiv" id="taxdiv0" style="page-break-inside: avoid">
                                            <td colspan='4'><?php if(!empty($row_customer['payment_terms_days'])){ echo '<p style="width:65%;text-align:center;"><b>Payment Terms:</b> '.((int)$row_customer['payment_terms_days']).' days</p>'; } ?></td>
                                            <td style="padding:2px; font-size: 15px; color:#000; font-weight: bold; text-align: center;">Balance</td>
                                            <td style="padding:2px; font-size: 16px; color:#b91c1c; font-weight: bold; text-align: center;"><?php echo number_format($g_grand - $g_adv, 2, '.', ''); ?></td>
											</tr>

                                           
                                            					
											
											
                                    </tbody>
                                    <tfoot >
										
										<tr style="page-break-inside: avoid">
										
											<td colspan="2" class="" style="vertical-align: top!important; padding:2px; ">
												<br>
												<?php                           
													$sql = "SELECT * FROM tbl_admin WHERE  admin_id='1'";
													$resul = $conn->query($sql);  
													$row = $resul->fetch_assoc();
												?>
												<p style="margin-left: 25px;float: left;">
													<span style="font-weight: 900;text-decoration: underline">Bank Details : </span><br>
													<b>Bank :</b> <?php echo $row['bank']; ?><br>
													<b>Branch :</b> <?php echo $row['branch']; ?><br>
													<b>A/C No :</b> <?php echo $row['acc_no']; ?><br>
													<b>Account Type :</b> <?php echo $row['acc_type']; ?><br>
													<b>IFSC  :</b> <?php echo $row['ifsc']; ?><br>
													<b>A/C Name  :</b> <?php echo $row['holder_name']; ?><br><br>
													<span>** Goods once sold will not be taken back</span>
												</p>
												<br>
											</td>

											
											<td colspan="2" style="text-align: center">
												<p style="margin-bottom: 0rem;font-size:15px"></p>
												<br>
												<br>
												<br>
												<br>
												<br>
												<p style="text-align:center;font-size:15px"><b>Customer Signature with seal</b></p>
											</td>

											
											<td colspan="2" style="text-align: center">
											<p style="margin-bottom: 0rem;font-size:15px"><b>For <?php echo htmlspecialchars($row['cname'] ?: 'Jayam Hydraulic Engineering (Spares)'); ?></b></p><br><br><br><br><br>
												<br>
												<br>
												<!--img src="images/no_image.png" style="width:130px;height:109px;text-align:center;object-fit:contain"-->
											<p style="text-align:center;font-size:15px">Authorized Signatory</p>
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