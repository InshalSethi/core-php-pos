<?php

    include '../../include/config_new.php';

    include '../../include/functions.php';

    include '../../include/MysqliDb.php';

    include '../../include/config.php';
    include '../../include/permission.php';



    $page_title='Inventory | Print';



    $in_id=decode($_REQUEST['in']);

    $x=encode( $in_id);

    $db->where('pur_in_id',$in_id);

    $in_data=$db->getOne('tbl_purchase_invoice');
    




    $db->where('pur_in_id',$in_id);

    $item_data=$db->get('tbl_purchase_invoice_pro');

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

                        <h1 class="text-center black-color">GSS</h1>

                        <div class="fot-set">

                            <div class="inline">

                              <div class="pr-date">

                                <p class="no-mr-btm text-center black-color"><?php echo date("d-m-Y");?></p>

                                <p class="border-tp text-center black-color">Print Date</p>

                              </div>

                            </div>

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

                    <div class="customer-basic">

                      <div class="table-responsive pt-3 set-mr-btm" style="overflow-x: hidden;">

                        <table class="table table-bordered">

                          <thead>

                            <tr>

                            </tr>

                          </thead>

                          <tbody> 

                            <tr>

                              <td class="set-padd text-center tbl-con"><?php echo $newDate = date("d-m-Y", strtotime($in_data['in_date'])); ?></td>

                              <td class="set-padd text-center tbl-head bold">تاریخ</td>

                              <td class="set-padd text-center tbl-con"><?php $db->where('cus_id',$in_data['supplier_id']); $cusName=$db->getOne('tbl_customer'); echo $cusName['cus_name']; ?></td>

                              <td class="set-padd text-center tbl-head bold">پارٹی کا نام</td>

                            </tr>

                            <tr>

                              <td class="set-padd text-center tbl-con"><?php echo $in_data['inv_id']; ?></td>

                              <td class="set-padd text-center tbl-head bold">بل نمبر</td>

                              <td class="set-padd text-center tbl-con"><?php echo $cusName['cus_phone']; ?></td>

                              <td class="set-padd text-center tbl-head bold">فون نمبر</td>

                            </tr>

                            <tr>

                              <td class="set-padd text-center tbl-con"></td>

                              <td class="set-padd text-center tbl-head bold"></td>

                              <td class="set-padd text-center tbl-con"><?php echo $cusName['cus_city']; ?></td>

                              <td class="set-padd text-center tbl-head bold">ایڈریس</td>

                            </tr>

                          </tbody>

                        </table>

                      </div>

                      <div class="table-responsive pt-3 set-mr-btm" style="overflow-x: hidden;">

                        <table class="table table-bordered">

                          <thead>

                            <tr>

                            </tr>

                          </thead>

                          <tbody>

                            <tr>

                              <td class="set-padd text-center tbl-head bold">رقم</td>

                              <td class="set-padd text-center tbl-head bold">ریٹ</td>

                              <td class="set-padd text-center tbl-head bold">تعداد</td>

                              <td class="set-padd text-center tbl-head bold">تفصیل</td>

                              <td class="set-padd text-center tbl-head bold">نمبر</td>

                            </tr>

                            <?php

                            $i=1;

                              foreach($item_data as $it_da){ 

                              $db->where('pro_id',$it_da['pro_id']);

                              $proNameUrdu=$db->getValue('tbl_products','pro_name_urdu');

                              ?>

                            <tr>

                              <td class="set-padd text-center tbl-con">
                              	<?php echo $it_da['pro_total']; ?>
                              
                              </td>

                              <td class="set-padd text-center tbl-con">
                              	<?php echo $it_da['supplier_price']; ?>
                             
                              </td>

                              <td class="set-padd text-center tbl-con">
                              	<?php echo $it_da['new_add_qty']; ?>
                             
                              </td>

                              <td class="set-padd text-center tbl-con in-no">
                              	<table style="width: 100%;">
                              		<tbody>
                              			<tr>
                              				<td style="border:0px; padding: 0px 0px;"><b><?php echo $it_da['pro_name']; ?></b></td>
                              				<td style="border:0px;padding: 0px 0px;"><b><?php echo $proNameUrdu; ?></b></td>
                              			</tr>
                              			
                              			
                              		</tbody>
                              	</table>

                                  

                              </td>

                              <td class="set-padd text-center tbl-con"><?php echo $i; ?></td>

                            </tr>

                          <?php  $i++; }  ?>



                            <tr>

                              <td class="set-padd text-center tbl-head bold"><?php echo number_format($in_data['grand_total']); ?></td>

                              <td class="set-padd text-center tbl-head bold">کل رقم</td>

                              <td class="set-padd text-center tbl-head bold"></td>

                              <td class="set-padd text-center tbl-head bold"></td>

                              <td class="set-padd text-center tbl-head bold"></td>

                            </tr>

                            

                            

                            

                            

                           


                            

                              

                            

                            

                          </tbody>

                        </table>

                      </div>

                      <?php 

                          $companydata = $db->getOne('company');

                          $company_name = $companydata['name']; 

                       ?>

                      

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