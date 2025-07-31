<?php
    include '../../include/config_new.php';
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
    <title>POS | Balance Sheet</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <link rel="stylesheet" media="print" href="<?php echo baseurl('assets/css/vertical-layout-light/balance-print.css');?>">
    <link rel="stylesheet" media="screen" href="<?php echo baseurl('assets/css/vertical-layout-light/balance-screen.css');?>">
    <?php
      $AddBalSheetId = 33;

      $accessAddBalSheet = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddBalSheetId){
            $accessAddBalSheet =1;
          }
        }  
    ?>
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
      font-size: 18px;
    }
    .acc-grp{
      padding-left: 10px;
      padding-right: 10px;
      font-size: 16px;
    }
    .inline{
      display: inline-block;
    }
    .flt-rt{
      float: right;
    }
    .chrt-dv{
      padding-left: 20px;
      padding-right: 20px;
    }
    .chrt-fn{
      font-size: 14px;
      color: grey;
    }
    .total-chr{
      padding-left: 0px;
      padding-right: 0px;
      background: #6da252;
      color: white;
      padding: 5px;
      margin-bottom: 5px;
    }
    .total-fn{
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 0px;
    }
    .mr-lf{
      margin-left: 5px;
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
            <?php if($accessAddBalSheet == 1){ ?>
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h4 class="card-title">Balance Sheet</h4>
                  <div class="noprint">
                      <!-- <a id="balance-filter" class="btn btn-success btn-mac"><i class="mdi mdi-magnify"></i> Search</a> -->
                      <a onclick="myFunction()" class="btn btn-success btn-mac mr-lf"><i class="mdi mdi-printer"></i> Print</a>
                    </div>
                </div>
              </div>
              <div class="col-lg-12">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <div class="row">
                      <?php
                      $GrandTotal = 0;
                      $TotalLiabilities = 0;
/////////////////////////////Calculated Return///////////////////////////////////////////////
                      $total_balance = 0;
                      $SaleCredit = 0;
                      $TotalExpenses = 0;
                      $NetProfit = 0;

                      //Income Count
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

                              foreach ($ChartAccData as $ChartAcc) {

                                $ChartAccId = $ChartAcc['chrt_id'];
                                $ChartAccName = $ChartAcc['account_name'];

                                  $db->where("chrt_id",$ChartAcc['chrt_id']);
                                  $TotalCredit=$db->getValue('journal_meta','SUM(credit)');
                                  $SaleCredit += (int)$TotalCredit;

                              }
                          }

                        }
                        //Expenses count
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

                                foreach ($ChartAccData as $ChartAcc) {

                                  $ChartAccId = $ChartAcc['chrt_id'];
                                  $ChartAccName = $ChartAcc['account_name'];

                                    $db->where("chrt_id",$ChartAcc['chrt_id']);
                                    $TotalDebit = $db->getValue('journal_meta','SUM(debit)');
                                     $TotalExpenses += (int)$TotalDebit;

                                }
                            }
                  
                          }
///////////////////////////////////////////////////////////////////////////////////////////// 

///////////////////////////Getting Total Of Liabilities//////////////////////////////////////
                          $db->where("id",'2');
                          $AccTypeData = $db->get("account_type");
                          foreach ($AccTypeData as $AccType) {

                            $AccTypeId = $AccType['id'];
                            $AccTypeName = $AccType['name'];

                            $db->where("acc_type_id",$AccTypeId);
                            $AccGroupData = $db->get("account_group");
                            $total_balance = 0;
                            foreach ($AccGroupData as $AccGroup) {
                              $AccGroupId = $AccGroup['id'];
                              $AccGroupName = $AccGroup['account_group_name'];

                              $db->where("acc_group",$AccGroupId);
                                $ChartAccData = $db->get("chart_accounts");
                                
                                foreach ($ChartAccData as $ChartAcc) {
                                  $ChartAccId = $ChartAcc['chrt_id'];
                                  $ChartAccName = $ChartAcc['account_name'];

                                  $db->where("chrt_id",$ChartAccId);
                                  $JournalMetaData = $db->get("journal_meta");

                                  $LiDebit = 0;
                                  $LiCredit = 0;
                                  
                                  foreach ($JournalMetaData as $JournalMeta) {

                                    $LiDebit += $JournalMeta['debit'];
                                    $LiCredit += $JournalMeta['credit'];
                                  }

                                  $TotalLiabilities = $LiDebit - $LiCredit;
                                }
                              }
                            }
///////////////////////////////////////////////////////////////////////////////////////////// 

                        $AccTypeData = $db->get("account_type");
                        foreach ($AccTypeData as $AccType) {

                          $AccTypeId = $AccType['id'];
                          $AccTypeName = $AccType['name'];
                          if($AccTypeId != '4' && $AccTypeId != '5'){
                      ?>
                      <div class="col-md-12">
                        <h3 class="acc-typ"><?php echo $AccTypeName; ?></h3>
                        <div class="row">
                          <?php 
                            $db->where("acc_type_id",$AccTypeId);
                            $AccGroupData = $db->get("account_group");
                            $total_balance = 0;
                            foreach ($AccGroupData as $AccGroup) {
                              $AccGroupId = $AccGroup['id'];
                              $AccGroupName = $AccGroup['account_group_name']; 

                          ?>
                          <div class="col-md-12">
                            <h4 class="acc-grp"><?php echo $AccGroupName; ?></h4>
                            <div class="row">
                              <?php
                                $db->where("acc_group",$AccGroupId);
                                $ChartAccData = $db->get("chart_accounts");
                                
                                foreach ($ChartAccData as $ChartAcc) {
                                  $ChartAccId = $ChartAcc['chrt_id'];
                                  $ChartAccName = $ChartAcc['account_name'];

                                  $db->where("chrt_id",$ChartAccId);
                                  $JournalMetaData = $db->get("journal_meta");

                                  $Debit = 0;
                                  $Credit = 0;
                                  $Subbalance = 0;
                                  
                                  foreach ($JournalMetaData as $JournalMeta) {

                                    $Debit += $JournalMeta['debit'];
                                    $Credit += $JournalMeta['credit'];
                                  }

                                  $Subbalance = $Debit - $Credit;

                              ?>
                              <div class="col-md-12">
                                <div class="chrt-dv">
                                  <div class="inline">
                                    <p class="chrt-fn"><?php echo $ChartAccName; ?></p>
                                  </div>
                                  <div class="inline flt-rt">
                                    <p class="chrt-fn"><?php echo number_format($Subbalance); ?></p>
                                  </div>
                                </div>
                              </div>
                              <?php  $total_balance += $Subbalance;  }  ?>
                            </div>
                          </div>
                          <?php } ?>
                          
                          <div class="col-md-12">
                            <div class="total-chr">
                              <div class="inline">
                                <h5 class="total-fn">Total <?php echo $AccTypeName; ?></h5>
                              </div>
                              <div class="inline flt-rt">
                                <h5 class="total-fn"><?php echo number_format($total_balance); ?></h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php  } } ?>
                      <div class="col-md-12">
                        <div class="total-chr">
                          <div class="inline">
                            <h5 class="total-fn">Calculated Return</h5>
                          </div>
                          <div class="inline flt-rt">
                            <h5 class="total-fn">
                              <?php  $NetProfit = $SaleCredit - $TotalExpenses;
                                  echo number_format($NetProfit); ?>    
                            </h5>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="total-chr">
                          <div class="inline">
                            <h5 class="total-fn">Total Liabilities & Equity</h5>
                          </div>
                          <div class="inline flt-rt">
                            <h5 class="total-fn">
                              <?php  $GrandTotal = $NetProfit - $TotalLiabilities;
                                  echo number_format($NetProfit); ?>    
                            </h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
              
           
          </div>
          <?php }else{ echo "<h5 class='text-danger'>You are not allowed to use this feature, Contact main admin.</h5>";} ?>
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