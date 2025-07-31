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
    <title>MAC | System and General GL Setup</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $UpdateSetupId = 68;

      $accessUpdateSetup = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $UpdateSetupId){
            $accessUpdateSetup =1;
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
            <?php if($accessUpdateSetup == 1){ ?>
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h4 class="card-title">System and General GL Setup</h4>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php  
                if (isset($_POST['setup-save'])) {

                  $retained_earnings = $_POST['retained_earnings'];
                  $pl_year = $_POST['pl_year'];
                  $exchange_variances = $_POST['exchange_variances'];
                  $gst_wht_acc = $_POST['gst_wht_acc'];
                  $payable_acc = $_POST['payable_acc'];
                  $purchases_default = $_POST['purchases_default'];
                  $purchases_returns = $_POST['purchases_returns'];
                  $pur_wht = $_POST['pur_wht'];
                  $cli_receivable_acc = $_POST['cli_receivable_acc'];
                  $cli_sale_acc = $_POST['cli_sale_acc'];
                  $cli_sales_return = $_POST['cli_sales_return'];
                  $cli_sales_discount = $_POST['cli_sales_discount'];
                  $cli_wht = $_POST['cli_wht'];
                  $it_sales_acc = $_POST['it_sales_acc'];
                  $it_inventory_acc = $_POST['it_inventory_acc'];
                  $it_cogs_acc = $_POST['it_cogs_acc'];
                  $it_inv_adj_acc = $_POST['it_inv_adj_acc'];
                  $it_item_as_cost = $_POST['it_item_as_cost'];
                  $it_department_exp = $_POST['it_department_exp'];
                  $it_wages_salary = $_POST['it_wages_salary'];
                  $updated_at = date("Y-m-d");

                  $up_arr1 = array("retained_earnings_acc"=>$retained_earnings,"pl_year_acc"=>$pl_year,"exchange_variances_acc"=>$exchange_variances,"gst_wht_acc"=>$gst_wht_acc,"updated_at"=>$updated_at);
                  $db->where("id",'1');
                  $update1 = $db->update("gl_general",$up_arr1);

                  $up_arr2 = array("payable_acc"=>$payable_acc,"purchases_acc"=>$purchases_default,"purchases_returns"=>$purchases_returns,"wht_acc"=>$pur_wht,"updated_at"=>$updated_at);
                  $db->where("id",'1');
                  $update2 = $db->update("gl_purchase_default",$up_arr2);

                  $up_arr3 = array("receivable_acc"=>$cli_receivable_acc,"sale_acc"=>$cli_sale_acc,"sales_return"=>$cli_sales_return,"sale_discount_acc"=>$cli_sales_discount,"wht_acc"=>$cli_wht,"updated_at"=>$updated_at);
                  $db->where("id",'1');
                  $update3 = $db->update("gl_sales_default",$up_arr3);

                  $up_arr4 = array("sale_acc"=>$it_sales_acc,"inventory_acc"=>$it_inventory_acc,"cogs_acc"=>$it_cogs_acc,"inventory_adj_acc"=>$it_inv_adj_acc,"item_assembly_cost_acc"=>$it_item_as_cost,"department_expense"=>$it_department_exp,"wages_salary"=>$it_wages_salary,"updated_at"=>$updated_at);
                  $db->where("id",'1');
                  $update4 = $db->update("gl_items_default",$up_arr4);

                  if (!empty($update4)) {
                    echo "<div class='alert alert-success' id='success-alert' role='alert'>Data Saved successfully .</div>";
                  }else{
                    echo "<div class='alert alert-danger' role='alert'>Alert! Data Not Saved.</div>";
                  }
                }
              ?>
              </div>
               <form action="" method="POST">
                <div class="col-md-12 set-mr-btm">
                  <div class="card card-border-color">
                    <div class="card-body">
                      <div class="row">
                        <?php 
                        $db->where("id",'1');
                        $data1 = $db->getOne("gl_general"); 
                        ?>
                        <div class="col-md-6 set-mr-btm">
                          <div class="row">
                            <div class="col-md-12">
                              <h5>General GL</h5>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Retained Earnings</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="retained_earnings" class="form-control">
                                          <option value="">Select Any</option>
                                          <?php 
                                            $db->where("status",'1');
                                            $AccGroupData = $db->get("account_group");
                                            foreach ($AccGroupData as $AccGroup) {
                                              $accGroupId = $AccGroup['id'];
                                              $accGroupName = $AccGroup['account_group_name'];
                                          ?>
                                          <optgroup label="<?php echo $accGroupName; ?>">
                                            <?php 
                                              $db->where("acc_group",$accGroupId);
                                              $db->where("status",'1');
                                              $chartAccData = $db->get("chart_accounts");

                                              foreach ($chartAccData as $chartAcc) {
                                                $ChartID = $chartAcc['chrt_id'];
                                                $ChartName = $chartAcc['account_name'];
                                            ?>
                                            <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data1['retained_earnings_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                          <?php } ?>
                                          </optgroup>
                                        <?php } ?>
                                        </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Profit/Loss Year</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="pl_year" class="form-control">
                                          <option value="">Select Any</option>
                                          <?php 
                                            $db->where("status",'1');
                                            $AccGroupData = $db->get("account_group");
                                            foreach ($AccGroupData as $AccGroup) {
                                              $accGroupId = $AccGroup['id'];
                                              $accGroupName = $AccGroup['account_group_name'];
                                          ?>
                                          <optgroup label="<?php echo $accGroupName; ?>">
                                            <?php 
                                              $db->where("acc_group",$accGroupId);
                                              $db->where("status",'1');
                                              $chartAccData = $db->get("chart_accounts");

                                              foreach ($chartAccData as $chartAcc) {
                                                $ChartID = $chartAcc['chrt_id'];
                                                $ChartName = $chartAcc['account_name'];
                                            ?>
                                            <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data1['pl_year_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                          <?php } ?>
                                          </optgroup>
                                        <?php } ?>
                                        </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Exchange Variances Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="exchange_variances" class="form-control">
                                          <option value="">Select Any</option>
                                          <?php 
                                            $db->where("status",'1');
                                            $AccGroupData = $db->get("account_group");
                                            foreach ($AccGroupData as $AccGroup) {
                                              $accGroupId = $AccGroup['id'];
                                              $accGroupName = $AccGroup['account_group_name'];
                                          ?>
                                          <optgroup label="<?php echo $accGroupName; ?>">
                                            <?php 
                                              $db->where("acc_group",$accGroupId);
                                              $db->where("status",'1');
                                              $chartAccData = $db->get("chart_accounts");

                                              foreach ($chartAccData as $chartAcc) {
                                                $ChartID = $chartAcc['chrt_id'];
                                                $ChartName = $chartAcc['account_name'];
                                            ?>
                                            <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data1['exchange_variances_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                          <?php } ?>
                                          </optgroup>
                                        <?php } ?>
                                        </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">GST WHT Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="gst_wht_acc" class="form-control">
                                          <option value="">Select Any</option>
                                          <?php 
                                            $db->where("status",'1');
                                            $AccGroupData = $db->get("account_group");
                                            foreach ($AccGroupData as $AccGroup) {
                                              $accGroupId = $AccGroup['id'];
                                              $accGroupName = $AccGroup['account_group_name'];
                                          ?>
                                          <optgroup label="<?php echo $accGroupName; ?>">
                                            <?php 
                                              $db->where("acc_group",$accGroupId);
                                              $db->where("status",'1');
                                              $chartAccData = $db->get("chart_accounts");

                                              foreach ($chartAccData as $chartAcc) {
                                                $ChartID = $chartAcc['chrt_id'];
                                                $ChartName = $chartAcc['account_name'];
                                            ?>
                                            <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data1['gst_wht_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                          <?php } ?>
                                          </optgroup>
                                        <?php } ?>
                                        </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php 
                        $db->where("id",'1');
                        $data2 = $db->getOne("gl_purchase_default"); 
                        ?>
                        <div class="col-md-6 set-mr-btm">
                          <div class="row">
                            <div class="col-md-12">
                              <h5>Suppliers and Purchasing Defaults</h5>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Payable Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="payable_acc" class="form-control">
                                          <option value="">Select Any</option>
                                          <?php 
                                            $db->where("status",'1');
                                            $AccGroupData = $db->get("account_group");
                                            foreach ($AccGroupData as $AccGroup) {
                                              $accGroupId = $AccGroup['id'];
                                              $accGroupName = $AccGroup['account_group_name'];
                                          ?>
                                          <optgroup label="<?php echo $accGroupName; ?>">
                                            <?php 
                                              $db->where("acc_group",$accGroupId);
                                              $db->where("status",'1');
                                              $chartAccData = $db->get("chart_accounts");

                                              foreach ($chartAccData as $chartAcc) {
                                                $ChartID = $chartAcc['chrt_id'];
                                                $ChartName = $chartAcc['account_name'];
                                            ?>
                                            <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data2['payable_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                          <?php } ?>
                                          </optgroup>
                                        <?php } ?>
                                        </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">WHT</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="pur_wht" class="form-control">
                                          <option value="">Select Any</option>
                                          <?php 
                                            $db->where("status",'1');
                                            $AccGroupData = $db->get("account_group");
                                            foreach ($AccGroupData as $AccGroup) {
                                              $accGroupId = $AccGroup['id'];
                                              $accGroupName = $AccGroup['account_group_name'];
                                          ?>
                                          <optgroup label="<?php echo $accGroupName; ?>">
                                            <?php 
                                              $db->where("acc_group",$accGroupId);
                                              $db->where("status",'1');
                                              $chartAccData = $db->get("chart_accounts");

                                              foreach ($chartAccData as $chartAcc) {
                                                $ChartID = $chartAcc['chrt_id'];
                                                $ChartName = $chartAcc['account_name'];
                                            ?>
                                            <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data2['wht_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                          <?php } ?>
                                          </optgroup>
                                        <?php } ?>
                                        </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Purchases Default</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="purchases_default" class="form-control">
                                          <option value="">Select Any</option>
                                          <?php 
                                            $db->where("status",'1');
                                            $AccGroupData = $db->get("account_group");
                                            foreach ($AccGroupData as $AccGroup) {
                                              $accGroupId = $AccGroup['id'];
                                              $accGroupName = $AccGroup['account_group_name'];
                                          ?>
                                          <optgroup label="<?php echo $accGroupName; ?>">
                                            <?php 
                                              $db->where("acc_group",$accGroupId);
                                              $db->where("status",'1');
                                              $chartAccData = $db->get("chart_accounts");

                                              foreach ($chartAccData as $chartAcc) {
                                                $ChartID = $chartAcc['chrt_id'];
                                                $ChartName = $chartAcc['account_name'];
                                            ?>
                                            <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data2['purchases_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                          <?php } ?>
                                          </optgroup>
                                        <?php } ?>
                                        </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Purchases Returns</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="purchases_returns" class="form-control">
                                          <option value="">Select Any</option>
                                          <?php 
                                            $db->where("status",'1');
                                            $AccGroupData = $db->get("account_group");
                                            foreach ($AccGroupData as $AccGroup) {
                                              $accGroupId = $AccGroup['id'];
                                              $accGroupName = $AccGroup['account_group_name'];
                                          ?>
                                          <optgroup label="<?php echo $accGroupName; ?>">
                                            <?php 
                                              $db->where("acc_group",$accGroupId);
                                              $db->where("status",'1');
                                              $chartAccData = $db->get("chart_accounts");

                                              foreach ($chartAccData as $chartAcc) {
                                                $ChartID = $chartAcc['chrt_id'];
                                                $ChartName = $chartAcc['account_name'];
                                            ?>
                                            <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data2['purchases_returns']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                          <?php } ?>
                                          </optgroup>
                                        <?php } ?>
                                        </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php 
                        $db->where("id",'1');
                        $data3 = $db->getOne("gl_sales_default"); 
                        ?>
                        <div class="col-md-6 set-mr-btm">
                          <div class="row">
                            <div class="col-md-12">
                              <h5>Client and Sales Default</h5>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Receivable Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="cli_receivable_acc" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data3['receivable_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Sales Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="cli_sale_acc" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data3['sale_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Sales Returns</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="cli_sales_return" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data3['sales_return']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Sales Discount Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="cli_sales_discount" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data3['sale_discount_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">WHT</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="cli_wht" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data3['wht_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php 
                        $db->where("id",'1');
                        $data4 = $db->getOne("gl_items_default"); 
                        ?>
                        <div class="col-md-6 set-mr-btm">
                          <div class="row">
                            <div class="col-md-12">
                              <h5>Items Default</h5>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Sales Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="it_sales_acc" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data4['sale_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Inventory Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="it_inventory_acc" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data4['inventory_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">C.O.G.S Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="it_cogs_acc" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data4['cogs_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Inventory Adjustment Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="it_inv_adj_acc" class="form-control">
                                          <option value="">Select Any</option>
                                          <?php 
                                            $db->where("status",'1');
                                            $AccGroupData = $db->get("account_group");
                                            foreach ($AccGroupData as $AccGroup) {
                                              $accGroupId = $AccGroup['id'];
                                              $accGroupName = $AccGroup['account_group_name'];
                                          ?>
                                          <optgroup label="<?php echo $accGroupName; ?>">
                                            <?php 
                                              $db->where("acc_group",$accGroupId);
                                              $db->where("status",'1');
                                              $chartAccData = $db->get("chart_accounts");

                                              foreach ($chartAccData as $chartAcc) {
                                                $ChartID = $chartAcc['chrt_id'];
                                                $ChartName = $chartAcc['account_name'];
                                            ?>
                                            <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data4['inventory_adj_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                          <?php } ?>
                                          </optgroup>
                                        <?php } ?>
                                        </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Item Assembly Costs Account</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="it_item_as_cost" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data4['item_assembly_cost_acc']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Department Expense</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="it_department_exp" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data4['department_expense']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Wages and Salaries</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <select name="it_wages_salary" class="form-control">
                                      <option value="">Select Any</option>
                                      <?php 
                                        $db->where("status",'1');
                                        $AccGroupData = $db->get("account_group");
                                        foreach ($AccGroupData as $AccGroup) {
                                          $accGroupId = $AccGroup['id'];
                                          $accGroupName = $AccGroup['account_group_name'];
                                      ?>
                                      <optgroup label="<?php echo $accGroupName; ?>">
                                        <?php 
                                          $db->where("acc_group",$accGroupId);
                                          $db->where("status",'1');
                                          $chartAccData = $db->get("chart_accounts");

                                          foreach ($chartAccData as $chartAcc) {
                                            $ChartID = $chartAcc['chrt_id'];
                                            $ChartName = $chartAcc['account_name'];
                                        ?>
                                        <option value="<?php echo $ChartID; ?>" <?php if($ChartID == $data4['wages_salary']){ echo 'selected';} ?>><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                    <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="btn-right" style="margin-top: 5px;">
                            <button type="submit" name="setup-save" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                            <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            
              
           
          </div>
          <?php }else{ echo "<h5 class='text-danger'>You are not allowed to use this feature, Contact main admin.</h5>";} ?>
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
  <script type="text/javascript">
    $("#success-alert").fadeTo(5000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    $("#success-alert").hide();
    });
    $(".alert-danger").fadeTo(5000, 500).slideUp(500, function(){
    $(".alert-danger").slideUp(500);
    $(".alert-danger").hide();
    });
  </script>
</html>