<?php

  include '../../include/functions.php';



  include '../../include/MysqliDb.php';



  include '../../include/config.php';



  include '../../include/permission.php';



    ?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Profit & Loss</title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>

  </head>

  <style>

    .set-card-body{

          padding-left: 10px!important;

          padding-right: 10px!important;

    }

    .set-mr-btm{

      margin-bottom: 10px;

    }

    .acc-typ{

      text-align: center;

      border: 1px solid;

      padding: 5px;

      font-size: 15px;

      margin-bottom: 1px;

      background: floralwhite;

    }

    .acc-grp{

      border: 1px solid;

      padding: 5px;

      padding-left: 10px;

      padding-right: 10px;

      margin-bottom: 0px;

      font-size: 14px;

      background: floralwhite;

    }

    .inline{

      display: inline-block;

    }

    .flt-rt{

      float: right;

    }

    .chrt-dv{

      padding-left: 0px;

      padding-right: 0px;

    }

    .chrt-fn{

      font-size: 14px;

      color: grey;

    }

    .total-chr{

      padding-left: 10px;

      padding-right: 10px;

    }

    .total-fn{

      font-size: 16px;

      font-weight: 600;

    }

    .table thead th, .jsgrid .jsgrid-table thead th{

      width: 15%;

      padding: 0.875rem 0rem;

    }

    .table td, .jsgrid .jsgrid-table td{

      width: 15%;

    }

    .st-td{

      padding: 5px !important;

    }

    .td-bg{

      background: #6da252;

    }

    .total-end{

      background: floralwhite;

    }

    .bold{

      font-weight: 600;

    }

  </style>

  <body>

    <div class="container-scroller">

      <!-- partial:partials/_navbar.html -->

 <?php include '../../libraries/nav.php'; ?>

      <!-- partial -->

      <div class="container-fluid page-body-wrapper">

        <!-- partial:partials/_settings-panel.html -->

        

        <!-- partial -->

        <!-- partial:partials/_sidebar.html -->

        <?php include '../../libraries/sidebar.php'; ?>

        <!-- partial -->

        <div class="main-panel">

          <div class="content-wrapper">

            <div class="row">

              <div class="col-lg-12 set-mr-btm">

                <div class="d-lg-flex align-items-baseline set-mr-btm">

                  <h4 class="card-title">Profit & Loss</h4>
                  <button class="btn btn-success btn-mac" onclick="
                window.location.href='profit-loss-product.php'"><i class="mdi mdi-eye"></i> Profit Loss With Product</button>

                </div>

              </div>

              <div class="col-lg-12">

                 <div class="card card-border-color">

                  <div class="card-body">

                    <div class="row">

                      

                      <div class="col-md-12">

                        <h3 class="acc-typ">Income</h3>

                        <div class="row">

                          <?php



                          $total_balance = 0;

                          $Credit = 0;

                          $TotalExpenses = 0;

                          $NetProfit = 0;

                          

                          ?>

                        </div>

                      </div>

                      <?php 

                          $db->where("id",'4');

                          $AccTypeData = $db->get("account_type");

                            foreach ($AccTypeData as $AccType) {



                              $AccTypeId = $AccType['id'];

                              $AccTypeName = $AccType['name'];



                              $db->where("acc_type_id",$AccTypeId);

                              $AccGroupData = $db->get("account_group");



                              foreach ($AccGroupData as $AccGroup) {

                                $AccGroupId = $AccGroup['id'];

                                $AccGroupName = $AccGroup['account_group_name'];



                                  $db->where("acc_group",$AccGroupId);

                                  $ChartAccData = $db->get("chart_accounts");



                                  $SingleCredit=0;

                                  foreach ($ChartAccData as $ChartAcc) {



                                    $ChartAccId = $ChartAcc['chrt_id'];

                                    $ChartAccName = $ChartAcc['account_name'];



                                      $db->where("chrt_id",$ChartAcc['chrt_id']);

                                      $TotalCredit=$db->getValue('journal_meta','SUM(credit)');

                                      $SingleCredit += (int)$TotalCredit;

                                      $Credit += (int)$TotalCredit;



                                  }



                      ?>

                      <div class="col-md-12">

                        <div class="chrt-dv">

                          <div class="table-responsive">

                            <table class="table table-striped">

                              <thead>

                                <tr>

                                </tr>

                              </thead>

                              <tbody>

                                <tr>

                                  <td class="st-td"><?php echo $AccGroupName; ?></td>

                                  <td class="text-center st-td"><?php echo number_format($SingleCredit); ?></td>

                                </tr>

                              </tbody>

                            </table>

                          </div>

                        </div>

                      </div>

                      <?php

                              }



                            } 

                      ?>

                      

                      <div class="col-md-12">

                        <div class="chrt-dv">

                          <div class="table-responsive">

                            <table class="table table-striped">

                              <thead>

                                <tr>

                                </tr>

                              </thead>

                              <tbody>

                                <tr>

                                  <td class="st-td bold">Total Income</td>

                                  <td class="text-center st-td bold"><?php echo number_format($Credit); ?></td>

                                </tr>

                              </tbody>

                            </table>

                          </div>

                        </div>

                      </div>



                      <div class="col-md-12">

                        <h3 class="acc-typ">Expense</h3>

                        <div class="row">

                          <?php 

                            

                            $db->where("id",'5');

                            $AccTypeData = $db->get("account_type");

                              foreach ($AccTypeData as $AccType) {



                                $AccTypeId = $AccType['id'];

                                $AccTypeName = $AccType['name'];



                                $db->where("acc_type_id",$AccTypeId);

                                $AccGroupData = $db->get("account_group");



                                foreach ($AccGroupData as $AccGroup) {

                                  $AccGroupId = $AccGroup['id'];

                                  $AccGroupName = $AccGroup['account_group_name'];



                                    $db->where("acc_group",$AccGroupId);

                                    $ChartAccData = $db->get("chart_accounts");

                                    

                                    $SingleExp = 0;

                                    foreach ($ChartAccData as $ChartAcc) {



                                      $ChartAccId = $ChartAcc['chrt_id'];

                                      $ChartAccName = $ChartAcc['account_name'];



                                        $db->where("chrt_id",$ChartAcc['chrt_id']);

                                        $TotalDebit = $db->getValue('journal_meta','SUM(debit)');

                                         $SingleExp += (int)$TotalDebit;

                                         $TotalExpenses += (int)$TotalDebit;



                                    }

                    ?>

                      <div class="col-md-12">

                        <div class="chrt-dv">

                          <div class="table-responsive">

                            <table class="table table-striped">

                              <thead>

                                <tr>

                                </tr>

                              </thead>

                              <tbody>

                                <tr>

                                  <td class="st-td"><?php echo $AccGroupName; ?></td>

                                  <td class="text-center st-td"><?php echo number_format($SingleExp); ?></td>

                                </tr>

                              </tbody>

                            </table>

                          </div>

                        </div>

                      </div>

                  <?php              }

                      

                   } ?>

                      </div>

                      </div>

                      <div class="col-md-12">

                        <div class="chrt-dv">

                          <div class="table-responsive">

                            <table class="table table-striped">

                              <thead>

                                <tr>

                                </tr>

                              </thead>

                              <tbody>

                                <tr>

                                  <td class="st-td bold">Total Expenses</td>

                                  <td class="text-center st-td bold"><?php echo number_format($TotalExpenses); ?></td>

                                </tr>

                              </tbody>

                            </table>

                          </div>

                        </div>

                      </div>

                      <div class="col-md-12">

                        <h3 class="total-end">

                          <div class="table-responsive">

                            <table class="table table-striped">

                              <thead>

                                <tr>

                                </tr>

                              </thead>

                              <tbody>

                                <tr>

                                  <td class="st-td td-bg bold">Total</td>

                                  <td class="text-center st-td td-bg bold">

                                    <?php

                                      $NetProfit = $Credit - $TotalExpenses;

                                      echo number_format($NetProfit); 

                                    ?> 

                                  </td>

                                </tr>

                              </tbody>

                            </table>

                          </div>

                        </h3>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

            </div>

            

              

           

          </div>

          <!-- content-wrapper ends -->

          <!-- partial:partials/_footer.html -->

          <?php include '../../libraries/footer.php'; ?>

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

</html>