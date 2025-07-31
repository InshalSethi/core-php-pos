<?php
    include 'include/config_new.php';
    include 'include/functions.php';
    include 'include/MysqliDb.php';
    include 'include/config.php';
    if (isset($_SESSION['login_id'])) {
      $user_id = $_SESSION['login_id'];
    }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>POS - Change Password</title>
    <!-- base:css -->
    <?php include 'include/auth.php'; ?>
    <?php include 'libraries/libs.php'; ?>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth lock-full-bg">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-transparent text-left p-5 text-center">
              <?php
                if (isset($_POST['change-password'])) {

                      $old_password = $_POST['old_password'];
                      $new_password = $_POST['new_password'];

                      $db->where("id",$user_id);
                      $admin_data = $db->getOne("users_tbl");
                      $ol_pass = $admin_data['password'];

                      if ($old_password == $ol_pass) {

                      $up_user = array("password"=>$new_password);
                      // var_dump($up_user);
                      // die();

                      $db->where("id",$user_id);
                      $us_id = $db->update ('users_tbl', $up_user);

                      if (!empty($us_id)){
                          echo "<div class='alert alert-success' id='success-alert' role='alert'>Password Updated Successfully.</div>";
                        }else{
                          echo "<div class='alert alert-danger' id='danger-alert' role='alert'>Password Not Updated .</div>";
                        }

                    }else{
                      echo "<div class='alert alert-danger' id='danger-alert' role='alert'>Alert! Old Password Not Matching.</div>";
                    }

                      
                  }
               ?>
              <form class="pt-5" action="" method="POST">
                <div class="form-group">
                  <label class="col-form-label">Old Password</label>
                  <input name="old_password" type="text" class="form-control text-center">
                </div>
                <div class="form-group">
                  <label class="col-form-label">New Password</label>
                  <input name="new_password" type="password" class="form-control text-center">
                </div>
                <div class="mt-5">
                  <button name="change-password" type="submit" class="btn btn-block btn-success btn-lg font-weight-medium" >Save</button>
                </div>
                <div class="mt-3 text-center">
                  <a href="<?php echo baseurl('index.php'); ?>" class="auth-link">Go to home</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <?php include 'libraries/js_libs.php'; ?>
  <!-- endinject -->
</body>

</html>
