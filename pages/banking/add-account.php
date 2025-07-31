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
    <title>POS | Add Account</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddAccountId = 15;

      $accessAddAcc = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddAccountId){
            $accessAddAcc =1;
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
            <?php if($accessAddAcc == 1){ ?>
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h4 class="card-title">Add Account</h4>
              </div>
              <?php 
              if (isset($_POST['add-account'])) {
                $name = $_POST['account_name'];
                $account_number = $_POST['account_number'];
                $account_balance = $_POST['account_balance'];
                $bank_address = $_POST['bank_address'];
                $bank_name = $_POST['bank_name'];
                $bank_phone = $_POST['bank_phone'];
                $coa_id = $_POST['chrt_acc'];
                $status = $_POST['status'];
                $created_at = date("Y-m-d");
                $CountDefault= 0;
                
                if (!empty($status)) {
                  $status = '1';
                }else{
                  $status = '0';
                }
                if (isset($_POST['default_acc'])) {
                  $default_acc = $_POST['default_acc'];
                }
                
                if ($default_acc == 1) {
                  $db->where("default_account",'1');
                  $db->get("account");
                  $CountDefault = $db->count;

                }
               // die(); 
                if ($CountDefault <= 0) {
                
                $ins_account = array("coa_id"=>$coa_id,"name"=>$name,"account_number"=>$account_number,"balance"=>$account_balance,"opening_balance"=>$account_balance,"bank_name"=>$bank_name,"bank_phone"=>$bank_phone,"bank_address"=>$bank_address,"status"=>$status,"default_account"=>$default_acc,"created_at"=>$created_at);

                
                  $account = $db->insert("account",$ins_account);

                  if (!empty($account)){
                      echo "<div class='alert alert-success' id='success-alert' role='alert'>Data inserted successfully .</div>";
                      ?>
                      <script>window.location.href="<?php echo baseurl('pages/banking/add-account.php'); ?>";</script>
                      <?php 
                        } else{
                          echo "<div class='alert alert-danger' role='alert'>Alert! Data not inserted.</div>";
                        }
                }else{
                    echo "<div class='alert alert-danger' role='alert'>Alert! More Than 1 accounts should not be default accounts.</div>";
                }
                

                
              }
               ?>
              <div class="col-lg-12">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Name</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <input type="text" name="account_name" class="form-control" required id="accountnamefield" placeholder="Account Name"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Number</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-pencil"></i></span>
                                    </div>
                                    <input type="text" name="account_number" class="form-control" required id="accountnumberfield" placeholder="Account Number"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Opening Balance</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-cash"></i></span>
                                    </div>
                                    <input type="text" name="account_balance" class="form-control" required id="accountbalancefield" placeholder="Enter Account Balance"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Address</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-google-maps"></i></span>
                                    </div>
                                    <input type="text" name="bank_address" class="form-control" required id="bank_addressfield" placeholder="Enter Bank Address"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Name</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-bank"></i></span>
                                    </div>
                                    <input type="text" name="bank_name" class="form-control" required id="bank_namefield" placeholder="Enter Bank Name"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Phone</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-phone"></i></span>
                                    </div>
                                    <input type="text" name="bank_phone" class="form-control" required id="bank_phonefield" placeholder="Enter Bank Phone"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Bank Account GL</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-bank"></i></span>
                                    </div>
                                    <select name="chrt_acc" class="form-control" required value="">
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
                                        <option value="<?php echo $ChartID; ?>"><?php echo $ChartName; ?></option>
                                      <?php } ?>
                                      </optgroup>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label class="col-form-label" style="padding-top: 10px!important;">Default</label>
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <div class='switch'><div class='quality'>
                                    <input  class="default_acc" id='q1' name='default_acc' type='radio' value="1">
                                    <label class="pad-fnt" for='q1'>Yes</label>
                                  </div><div class='quality'>
                                    <input checked class="default_acc"  id='q2' name='default_acc' type='radio' value="0" id="statusfield">
                                    <label class="pad-fnt" for='q2'>No</label>
                                  </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 no-side-padding-left">
                                <div class="form-group row">
                                  <div class="col-sm-12 set-check-col">
                                    <div class="form-check form-check-flat form-check-primary">
                                      <label class="form-check-label">
                                        Active
                                        <input type="checkbox" name="status" class="form-check-input" id="statusfield" value="1">
                                      <i class="input-helper"></i></label>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-right" style="margin-top: 5px;">
                                    <button type="submit" name="add-account" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                                    <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
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
  <script>
    $("#success-alert").fadeTo(4000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    $("#success-alert").hide();
    });
</script>
</html>