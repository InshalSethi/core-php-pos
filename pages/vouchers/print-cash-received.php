<?php

    include '../../include/config_new.php';

    include '../../include/functions.php';

    include '../../include/MysqliDb.php';

    include '../../include/config.php';
    include '../../include/permission.php';



    $page_title='Inventory | Print';

    $cash_id=$_REQUEST['cash'];

    $db->where('id',$cash_id);
    $data=$db->getOne('client_payments'); 

    // Get customer data if client_id exists
    if ($data && isset($data['client_id'])) {
        $db->where('cus_id',$data['client_id']);
        $cus=$db->getOne('tbl_customer');
    } else {
        $cus = null;
    }

    // Get company data for header
    $companydata = $db->getOne('company');
    $company_name = ($companydata && isset($companydata['name'])) ? $companydata['name'] : 'Company Name';

    // Set default values for customer data if not found
    $cus_name = ($cus && isset($cus['cus_name'])) ? $cus['cus_name'] : 'Unknown Customer';
    $cus_phone = ($cus && isset($cus['cus_phone'])) ? $cus['cus_phone'] : 'N/A';
    $cus_city = ($cus && isset($cus['cus_city'])) ? $cus['cus_city'] : 'N/A';









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
                        <h1 class="text-center black-color">CASH RECEIVED</h1>

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

                              <td class="set-padd text-center tbl-con"><?php echo $newDate = date("d-m-Y", strtotime($data['date'])); ?></td>

                              <td class="set-padd text-center tbl-head bold">تاریخ</td>

                              <td class="set-padd text-center tbl-con"><?php echo $cus_name; ?></td>

                              <td class="set-padd text-center tbl-head bold">پارٹی کا نام</td>

                            </tr>

                            <tr>

                              <td class="set-padd text-center tbl-con"><?php echo $cash_id; ?></td>

                              <td class="set-padd text-center tbl-head bold">بل نمبر</td>

                              <td class="set-padd text-center tbl-con"><?php echo $cus_phone; ?></td>

                              <td class="set-padd text-center tbl-head bold">فون نمبر</td>

                            </tr>

                            <tr>

                              <td class="set-padd text-center tbl-con"></td>

                              <td class="set-padd text-center tbl-head bold"></td>

                              <td class="set-padd text-center tbl-con"><?php echo $cus_city; ?></td>

                              <td class="set-padd text-center tbl-head bold">ایڈریس</td>

                            </tr>
                            <tr>

                              <td class="set-padd text-center tbl-con"></td>

                              <td class="set-padd text-center tbl-head bold"></td>

                              <td class="set-padd text-center tbl-con"><?php echo $data['payment_note']; ?></td>

                              <td class="set-padd text-center tbl-head bold"> نوٹ</td>

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

                              <td class="set-padd text-center tbl-head bold">پارٹی کا نام</td>

                              <td class="set-padd text-center tbl-head bold">نمبر</td>

                            </tr>

              

                            <tr>
                              <td class="set-padd text-center tbl-con">
                              	<?php echo $data['amount']; ?>
                              </td>

                              <td class="set-padd text-center tbl-con in-no">
                                <?php echo $cus_name; ?>
                              </td>

                              <td class="set-padd text-center tbl-con"><?php echo $cash_id; ?></td>
                            </tr>

                          



                            

                            

                            

                            

                            

                           


                            

                              

                            

                            

                          </tbody>

                        </table>

                      </div>

                      <?php
                          // Company data already loaded at the top of the file
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