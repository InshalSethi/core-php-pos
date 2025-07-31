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
    <title>POS | Add Account Type</title>
    <?php include '../../libraries/libs.php'; ?>
    <?php include '../../include/auth.php'; ?>
    <?php
      $AddAccTypeId = 55;

      $accessAddAccType = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddAccTypeId){
            $accessAddAccType =1;
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
            <?php if($accessAddAccType == 1){ ?>
            <div class="row">
              <div class="col-lg-6">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h5 class="text-dark mb-0">
                   Add Account Type
                  </h5>
                </div>
              </div>
              <div class="col-lg-6">
               <div class="no-loader">
                  <div class="loader-demo-box setting-loader">
                    <div class="dot-opacity-loader">
                      <span></span>
                      <span></span>
                      <span></span>
                      <span></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php 
              if (isset($_POST['add-account-type'])) {

                $account_type = $_POST['account_type'];
                $created_at = date("Y-m-d");
                
                $ins_account_type = array("name"=>$account_type,"created_at"=>$created_at);

                $account_type = $db->insert("account_type",$ins_account_type);

                if (!empty($account_type)){
                      echo "<div class='alert alert-success' id='success-alert' role='alert'>Data inserted successfully .</div>";
                      ?>
                      <script>window.location.href="add-account-type.php";</script>
                      <?php
                        } else{
                          echo "<div class='alert alert-danger' role='alert'>Alert! Data not inserted.</div>";
                        }
              }
               ?>
          <div class="row">
            <div class="col-lg-12">
              <div class="card card-border-color">
                <div class="card-body">
                  <form action="" method="POST">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <label class="col-form-label">Account Type</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text in-grp"><i class="mdi mdi-rename-box"></i></span>
                              </div>
                              <input type="text" name="account_type" class="form-control" required id="account_typefield" placeholder="Enter Account Type"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                        <div class="btn-right">
                          <button type="submit" name="add-account-type" class="btn btn-success btn-mac" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                          <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                        </div>
                      </div>
                    </div>
                  </form>
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
    $(".alert-success").fadeTo(4000, 500).slideUp(500, function(){
    $(".alert-success").slideUp(500);
    $(".alert-success").hide();
    });
</script>
</html>