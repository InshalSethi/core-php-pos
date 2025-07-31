<?php

    include '../../include/config_new.php';

    include '../../include/functions.php';

    include '../../include/MysqliDb.php';

    include '../../include/config.php';
    include '../../include/permission.php';

    $companydata = $db->getOne('company');
    $name = $companydata['name'];

    $page_title='Inventory | Print';



    $in_id=decode($_REQUEST['ci']);

    $x=encode( $in_id);

    $db->where('inv_id',$in_id);

    $in_data=$db->getOne('tbl_invoice');



    $db->where('inv_id',$in_id);

    $item_data=$db->get('tbl_invoice_detail');

    function CheckBalanceCustomer($cus_id,$today_date,$db){

    $total_received=0;

    $total_receiveAble=0;

    $Balance=0;

    $data = $db->rawQuery("SELECT inv_id as invoice_id,p_inv_date as date,paid_amount as received_amount,grand_total_w_dis as total_amount,CASE WHEN inv_id != '' THEN 'SALE' END as status FROM tbl_invoice WHERE cus_name='$cus_id' AND p_inv_date < '$today_date'  UNION ALL SELECT inv_id as invoice_id,p_inv_date as date,grand_total_w_dis as received_amount,CASE WHEN inv_id != '' THEN grand_total_w_dis END as total_amount,CASE WHEN inv_id != '' THEN 'SALE_RETURN' END as status FROM tbl_salereturn_invoice WHERE cus_name='$cus_id' AND p_inv_date < '$today_date' UNION ALL SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_RECEIVED' END as status FROM client_payments WHERE client_id='$cus_id' AND invoice_id IS NULL AND date < '$today_date' ");

    // echo "----".$db->getLastQuery();


    //var_dump($data);



    foreach($data as $da){ 

      if($da['status'] == 'SALE'){



        $total_receiveAble+=$da['total_amount'];

        $total_received+=$da['received_amount'];

      } 

      if ($da['status'] == 'CASH_RECEIVED') {

        $total_received+=$da['received_amount'];

      }

      if($da['status'] == 'SALE_RETURN'){

        $total_received+=$da['received_amount'];

      }



    }



    $Balance=$total_receiveAble-$total_received;

    return (int)$Balance;



  }







    ?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $page_title; ?></title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>

    <link rel="stylesheet" media="print" href="<?php echo baseurl('assets/css/vertical-layout-light/invoice-print.css');?>">

    <link rel="stylesheet" media="screen" href="<?php echo baseurl('assets/css/vertical-layout-light/invoice-screen.css');?>">

  </head>

  <style>

    .set-card-body{

          padding-left: 10px!important;

          padding-right: 10px!important;

    }

    .set-mr-btm{

      margin-bottom: 10px;

    }

     .setting-loader{

    border: none!important;

  }

  .dot-opacity-loader{

    width: 100%;

    height: auto;

    text-align: right;

  }

  .dot-opacity-loader span{

    margin: 2px 5px;

    background-color: #6da252;

  }

  .loader-demo-box{

    height: auto;

  }

  .no-loader{

    display: none;

  }

  .small-space{

    padding: 20px!important;

  }

  </style>

  <body>

    <div class="container-scroller">

      <!-- partial:partials/_navbar.html -->

      <div class="noprint">

        <?php include '../../libraries/nav.php'; ?>

      </div>

      <!-- partial -->

      <div class="container-fluid page-body-wrapper">

        <!-- partial:partials/_settings-panel.html -->

        

        <!-- partial -->

        <!-- partial:partials/_sidebar.html -->

      <div class="noprint">

        <?php include '../../libraries/sidebar.php'; ?>

      </div>

        <!-- partial -->

        <div class="main-panel">

          <div class="content-wrapper">

            <div class="row noprint set-mr-btm">

              <div class="col-md-12">

                <button onclick="myFunction()" class="btn btn-success btn-mac"><i class="mdi mdi-printer"></i> Print</button>

              </div>

            </div>

            <div class="row">

              <div class="col-lg-12 head"></div>

              <div class="col-lg-12">

                <div class="card">

                  <div class="card-body">

                    <div class="invoice-heading">

                        <h1 style="font-weight: 600;" class="text-center black-color">SALES INVOICE</h1>
                        
      <style>
      
      .container-custom  {
        color:black;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      width: 80%;
      margin: 20px auto;
      border-bottom: 1px solid #000;
    }

    .left-section {
      font-weight: bold;
          font-size: 18px;
    }

    .right-section {
      text-align: right;
    }

    .invoice-info {
      text-align: right;
      margin-bottom: 10px;
    }

    .vertical-line {
      border-left: 2px solid black;
      height: 80px;
      margin: 0 20px;
    }

    

    .small-text {
      font-size: 18px;
      line-height: 1.5;
    }
    }
  </style>
    <div class="container-custom">
    <div class="left-section">
      
      <?php 
      $db->where('cus_id',$in_data['cus_name']); $cusName=$db->getOne('tbl_customer');
      $db->where('cus_name',$in_data['re_cus_name']); $new_cusName=$db->getOne('tbl_customer');
      
      if( empty( $cusName['cus_name'])){ echo $in_data['re_cus_name'].'<br>'.$cusName['cus_phone'];  } else { echo $cusName['cus_name'].$cusName['cus_phone']; }  ?>
    </div>
    
    <div class="invoice-info">
      Invoice date<br> 
      <strong><?php echo $newDate = date("d-m-Y", strtotime($in_data['p_inv_date'])); ?></strong><br>
      Invoice number<br>
      <strong><?php echo $in_data['inv_id']; ?></strong>
    </div>

    <div class="vertical-line"></div>

    <div class="right-section store-info">
     <span style="font-size: 26px; font-weight: bold;"> Madina Paint House </span> <br>
      <span class="small-text">
        Branch #1 - 139-Club Road Vehari <br>  Branch #2 - 2km Burewala Road Vehari <br>
        Asghar Ali Bhatti 0321-7725584 <br> Arslan Asghar Bhatti 0321-7725547
      </span>
    </div>
  </div>
                         
                         <!--Print Date-->
                        <div class="fot-set">

                            <!--<div class="inline">-->

                            <!--  <div class="pr-date">-->

                            <!--    <p class="no-mr-btm text-center black-color"><?php echo date("d-m-Y");?></p>-->

                            <!--    <p class="border-tp text-center black-color">Print Date</p>-->
                                

                            <!--  </div>-->
                              
                              
                                

                            <!--</div>-->
                            <h5 style="margin-right: 35px;" class=" text-right black-color">خریدہ ہوا مال بغیر بل کے واپس یا تبدیل نہیں ہو گا</h5>
                                

                            <div class="inline flot-rt">

                                <div class="sign">

                                    <p class="no-mr-btm white-clr">.</p>

                                    <p class="border-tp text-center black-color"><?php echo $company_name; ?></p>

                                </div>

                            </div>

                            <!-- <div class="text-center">

                              <p class="black-color"><?php //echo $tag_line = $companydata['tag_line']; ?></p>

                            </div> -->

                        </div>

                    </div>

                    <div style="margin-right: 35px;" class="customer-basic">

                      <div class="table-responsive pt-3 set-mr-btm" style="overflow-x: hidden;">

                        <!--<table class="table table-bordered">-->

                        <!--  <thead>-->

                        <!--    <tr>-->

                        <!--    </tr>-->

                        <!--  </thead>-->

                        <!--  <tbody> -->

                        <!--    <tr>-->
                        <!--        <td class="set-padd text-center tbl-head bold">Date</td>-->
                                
                        <!--        <td class="set-padd text-center tbl-con" style="width: 33%;"></td>-->
                                
                        <!--        <td class="set-padd text-center tbl-head bold">Customer</td>-->
                                
                        <!--        <td class="set-padd text-center tbl-con"><?php $db->where('cus_id',$in_data['cus_name']); $cusName=$db->getOne('tbl_customer'); echo $cusName['cus_name']; ?></td>-->

                              

                        <!--    </tr>-->

                        <!--    <tr>-->
                        <!--        <td class="set-padd text-center tbl-head bold">Bill#</td>-->
                                
                        <!--        <td class="set-padd text-center tbl-con" style="width: 33%;"></td>-->

                        <!--        <td class="set-padd text-center tbl-head bold">Phone#</td>-->

                        <!--        <td class="set-padd text-center tbl-con"><?php echo $cusName['cus_phone']; ?></td>-->

                              

                        <!--    </tr>-->

                        <!--    <tr>-->
                              
                        <!--      <td class="set-padd text-center tbl-head bold">Address</td>-->

                        <!--      <td class="set-padd text-center tbl-con" colspan="3"><?php echo $cusName['cus_city']; ?></td>-->

                              

                        <!--    </tr>-->

                        <!--  </tbody>-->

                        <!--</table>-->

                      </div>

                      <div class="table-responsive pt-3 set-mr-btm" style="overflow-x: hidden;">

                        <table class="table table-bordered">

                          <thead>

                            <tr>

                            </tr>

                          </thead>

                          <tbody>

                            <tr>
                                <td class="set-padd text-center tbl-head bold">Sr#</td>
                                <td class="set-padd text-center tbl-head bold">Details</td>
                                <td class="set-padd text-center tbl-head bold">Qty</td>
                                <td class="set-padd text-center tbl-head bold">Rate</td>
                                <td class="set-padd text-center tbl-head bold">Dis%</td>
                                <td class="set-padd text-center tbl-head bold">Dis Flat</td>
                                <td class="set-padd text-center tbl-head bold">Amount</td>
                            </tr>

                            <?php

                            $i=1;

                              foreach($item_data as $it_da){ 

                              $db->where('pro_id',$it_da['pro_id']);

                              $proNameUrdu=$db->getValue('tbl_products','pro_name_urdu');

                              ?>

                            <tr>
                                
                                <td class="set-padd text-center tbl-con"><?php echo $i; ?></td>
                                
                                <td class="set-padd text-center tbl-con in-no">
                              	<table style="width: 100%;">
                              		<tbody>
                              			<tr>
                              				<td style="border:0px; padding: 0px 10px;text-align: left;"><b><?php echo $it_da['pro_name']; ?></b></td>
                              				<td style="border:0px;padding: 0px 0px;"><b><?php echo $proNameUrdu; ?></b></td>
                              			</tr>
                              			
                              			
                              		</tbody>
                              	</table>

                                  

                              </td>
                              
                              <td class="set-padd text-center tbl-con">
                              	<?php echo $it_da['pro_qty']; ?>
                             
                              </td>
                              
                              <td class="set-padd text-center tbl-con">
                              	<?php echo number_format($it_da['pro_rate']); ?>
                             
                              </td>

                              <td class="set-padd text-center tbl-con">
                                <?php echo $it_da['perc_discount']; ?>
                             
                              </td>

                              <td class="set-padd text-center tbl-con">
                                <?php echo $it_da['flat_discount']; ?>
                             
                              </td>

                              <td class="set-padd text-center tbl-con">
                              	<?php echo number_format($it_da['total_price']); ?>
                              
                              </td>
                              
                            </tr>

                          <?php  $i++; }  ?>



                            <tr>

                              <td class="set-padd text-center tbl-head bold" colspan="5"></td>
                              
                              <td class="set-padd text-center tbl-head bold">Total Amount</td>
                              
                              <td class="set-padd text-right tbl-head bold"><?php echo number_format(round((float)$in_data['grand_total']), 2, '.', ','); ?></td>

                            </tr>

                            <tr>
                                
                              <td class="set-padd text-center tbl-head bold" colspan="5"></td>
                              
                              <td class="set-padd text-center tbl-head bold">Discount</td>
                              
                              <td class="set-padd text-right tbl-head bold"><?php echo number_format((float)$in_data['total_dis'], 2, '.', ','); ?></td>

                            </tr>

                            

                            

                            <?php if($in_data['paid_amount'] > 0){ ?>



                              <tr>

                              <td class="set-padd text-center tbl-head bold" colspan="5"></td>
                              
                              <td class="set-padd text-center tbl-head bold">Received</td>
                              
                              <td class="set-padd text-right tbl-head bold"><?php echo number_format((float)$in_data['paid_amount'], 2, '.', ','); ?></td>

                            </tr>



                            

                              <?php



                            }



                            ?>

                            <tr>

                              <td class="set-padd text-center tbl-head bold" colspan="5"></td>
                              
                              <td class="set-padd text-center tbl-head bold">Remaining</td>
                              
                              <td class="set-padd text-right tbl-head bold"><?php echo number_format((float)$in_data['total_due'], 2, '.', ','); ?></td>

                            </tr>


                            <?php 
                            $customerBalance =0;
                            $customerBalance=CheckBalanceCustomer($in_data['cus_name'],$in_data['p_inv_date'],$db);
                            if ($customerBalance > 0) { ?>

                            <tr>

                              <td class="set-padd text-center tbl-head bold" colspan="5"></td>
                              
                              <td class="set-padd text-center tbl-head bold">Credit</td>
                              
                              <td class="set-padd text-right tbl-head bold"><?php echo number_format((float)$customerBalance, 2, '.', ','); ?></td>

                            </tr>

                            <?php
                            }

                            ?>

                            <tr>
                                
                              <td class="set-padd text-center tbl-head bold" colspan="5"></td>
                              
                              <td class="set-padd text-center tbl-head bold">Grand Total</td>
                              
                              <td class="set-padd text-right tbl-head bold"><?php 
                              $totalPending=$customerBalance + $in_data['total_due'];
                              echo number_format((float)$totalPending, 2, '.', ','); 

                              ?></td>

                            </tr>

                            

                            

                          </tbody>

                        </table>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              

            </div>

            

              

           

          </div>

          <!-- content-wrapper ends -->

          <!-- partial:partials/_footer.html -->

        <div class="noprint">

          <?php include '../../libraries/footer.php'; ?>

        </div>

          <!-- partial -->

        </div>

        <!-- main-panel ends -->

      </div>

      <!-- page-body-wrapper ends -->

    </div>

    <!-- container-scroller -->

    <!-- base:js -->

    <?php include '../../libraries/js_libs.php'; ?>

  </body>

  <script>

function myFunction() {

    window.print();

}

</script>

</html>