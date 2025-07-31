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
    <title>ERP | Add Type Of Expense</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddExpTypeId = 51;

      $accessAddExpType = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddExpTypeId){
            $accessAddExpType =1;
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
            <?php if($accessAddExpType == 1){ ?>
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h4 class="card-title">Add Type Of Expense</h4>
              </div>
              <?php 
              if (isset($_POST['add-exp-type'])) {
                $name = $_POST['exp_type_name'];
                $coa = $_POST['chrt_acc'];
                if (isset($_POST['status'])) {
                  $status = $_POST['status'];
                }
                $created_at = date("Y-m-d");
                
                $ins_exp_type = array("chrt_id"=>$coa,"type_name"=>$name,"status"=>$status,"created_at"=>$created_at);
                $exp_type = $db->insert("exp_type",$ins_exp_type);

                if (!empty($exp_type)){
                      echo "<div class='alert alert-success' id='success-alert' role='alert'>Data inserted successfully .</div>";
                        } else{
                          echo "<div class='alert alert-danger' role='alert'>Alert! Data not inserted.</div>";
                        }
              }
               ?>
              <div class="col-lg-12">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <form action="" method="POST">
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label class="col-form-label">Type of Exp.</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                </div>
                                <input type="text" name="exp_type_name" class="form-control" required id="exp_type_namefield" placeholder="Enter Type Of Exp."/>
                              </div>
                            </div>
                          </div>
                          </div>
                          <div class="col-md-5">
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <label class="col-form-label">Gl Account (Link this type with COA)</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                  </div>
                                  <select name="chrt_acc" class="form-control chrt_acc" required value="">
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
                          <div class="col-md-2">
                            <label class="col-form-label" style="padding-top: 10px!important;">Active</label>
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <div class='switch'><div class='quality'>
                                  <input checked class="status" id='q1' name='status' type='radio' value="1">
                                  <label class="pad-fnt" for='q1'>Yes</label>
                                </div><div class='quality'>
                                  <input class="status"  id='q2' name='status' type='radio' value="0" id="statusfield">
                                  <label class="pad-fnt" for='q2'>No</label>
                                </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                          <div class="btn-right">
                            <button type="submit" name="add-exp-type" class="btn btn-success btn-mac" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
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