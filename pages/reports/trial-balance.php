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
    <title>POS | Trial Balance</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <link rel="stylesheet" media="print" href="<?php echo baseurl('assets/css/vertical-layout-light/trial-print.css');?>">
    <link rel="stylesheet" media="screen" href="<?php echo baseurl('assets/css/vertical-layout-light/trial-screen.css');?>">
    <?php
      $AddTrialBalId = 32;

      $accessAddTrialBal = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddTrialBalId){
            $accessAddTrialBal =1;
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
    .mr-top{
      margin-top: 10px;
    }
    .acc-typ{
      border: 1px solid;
      padding: 10px;
      font-size: 15px;
      margin-bottom: 1px;
      background: floralwhite;
      color: green;
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
            <?php if($accessAddTrialBal == 1){ ?>
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h4 class="card-title">Trial Balance</h4>
                    <div class="noprint">
                      <a id="trial-filter" class="btn btn-success btn-mac"><i class="mdi mdi-magnify"></i> Search</a>
                      <a onclick="myFunction()" class="btn btn-success btn-mac mr-lf"><i class="mdi mdi-printer"></i> Print</a>
                    </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="noprint">
                  <div class="card card-border-color">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="advance-search-main">
                            <form>
                              <div class="row advance-search-row">                           
                                <div class="col-md-2 no-side-padding-first">
                                    <div class="form-group row no-mar-btm">
                                      <div class="col-sm-12">
                                        <label class="col-form-label advance-lable-padding no-mar-btm">Date From</label>
                                        <div class="input-group">
                                            <input type="date" id="date_from" name="date_from" class="form-control advance-input-padding" placeholder=""/>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-2 no-side-padding">
                                    <div class="form-group row no-mar-btm">
                                      <div class="col-sm-12">
                                        <label class="col-form-label advance-lable-padding no-mar-btm">Date to</label>
                                        <div class="input-group">
                                            <input type="date" id="date_to" name="date_to" class="form-control advance-input-padding" placeholder=""/>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 mr-top">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <h3 class="">
                          <div class="table-responsive">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th class="">
                                    Account Name
                                  </th>
                                  <th class="text-center">
                                    Debit
                                  </th>
                                  <th class="text-center">
                                    Credit
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </h3>
                      </div>
                      <div class="outer-trial">
                        <div class="trial">
                          <?php  
                            $ac_tp = 1;
                            $AccTypeData = $db->get("account_type");
                            foreach ($AccTypeData as $AccType) {
                              $AccTypeId = $AccType['id'];
                              $AccTypeName = $AccType['name'];
                          ?>
                          <div class="col-md-12">
                            <h3 class="acc-typ"><?php echo 'Type - '.$ac_tp.' : '.$AccTypeName; ?></h3>
                            <div class="row">
                              <?php 
                                $ac_grp = 1;
                                $db->where("acc_type_id",$AccTypeId);
                                $AccGroupData = $db->get("account_group");
                                foreach ($AccGroupData as $AccGroup) {
                                  $AccGroupId = $AccGroup['id'];
                                  $AccGroupName = $AccGroup['account_group_name']; 

                              ?>
                              <div class="col-md-12">
                                <h4 class="acc-grp"><?php echo 'Group - '.$ac_grp.' : '.$AccGroupName; ?></h4>
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
                                      foreach ($JournalMetaData as $JournalMeta) {

                                        $Debit += $JournalMeta['debit'];
                                        $Credit += $JournalMeta['credit'];
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
                                              <td class="st-td"><?php echo $ChartAccName; ?></td>
                                              <td class="text-center st-td"><?php echo number_format($Debit); ?></td>
                                              <td class="text-center st-td"><?php echo number_format($Credit); ?></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                  <?php } ?>
                                </div>
                              </div>
                              <?php $ac_grp++; } ?>
                            </div>
                          </div>
                          <?php $ac_tp++; } ?>
                          <div class="col-md-12">
                            <h3 class="total-end">
                              <div class="table-responsive">
                                <table class="table table-striped">
                                  <thead>
                                    <tr>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php

                                      $JMetaTotal = $db->get("journal_meta");

                                      $TotalDebit = 0;
                                      $TotalCredit = 0;
                                      foreach ($JMetaTotal as $JMeta) {

                                        $TotalDebit += $JMeta['debit'];
                                        $TotalCredit += $JMeta['credit'];
                                      }  
                                    ?>
                                    <tr>
                                      <td class="st-td td-bg">Total</td>
                                      <td class="text-center st-td td-bg"><?php echo number_format($TotalDebit); ?></td>
                                      <td class="text-center st-td td-bg"><?php echo number_format($TotalCredit); ?></td>
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
              <div class="ln-br"></div>
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
    $("#trial-filter").click(function(){
            
            var date_from=$("#date_from").val();
            
            var date_to=$("#date_to").val();
            


            $.ajax({
                type: "POST",
                url: "search.php",
                data: { 
                        date_from:date_from,
                        date_to:date_to,
                        action:'trial_search',
                        authkey:'dabdsjjI81sa'
                },
                cache: false,
                success: function(result){
                    
                    $(".trial").remove();
                    $(".outer-trial").html(result);
                    
                    
                    
                }  
                
            });
        
        });

function myFunction() {
    window.print();
}
</script>
</html>