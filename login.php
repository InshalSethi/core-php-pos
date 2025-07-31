<?php

    
    include 'include/functions.php';
    include 'include/MysqliDb.php';
    include 'include/config.php';
    
     

?>
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!-- Required meta tags -->
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>POS | Login</title>
  <!-- base:css -->
  <?php include 'libraries/libs.php'; ?>
</head>
<style>
  body {
  background-image: url("<?php echo baseurl('assets/images/login/tax-login.jpg');?>");
    background-size: cover;
    /*background-position: center;*/
}
.no-bg{
  background: none!important;
}
.bg-set{
  background: #04040457!important;
  border-radius: 10px;
}
.color-set{
  color: white!important;
}
input:focus {
  background-color: transparent;
  color: white!important;
}
input::-webkit-input-placeholder {
    font-size: 16px;
    color: white!important;
    
    
}
.input-set{
  color: white;
  font-weight: 500;
}
.logo-set{
    border-radius: 5px;
}
</style>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0 no-bg" >
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 bg-set">
              <div class="brand-logo text-center">
                <img class="logo-set" src="<?php echo baseurl('assets/images/zedtechlogo.png');?>" alt="MAC logo">
              </div>
              <h4 class="color-set">Hello! let's get started</h4>
              <?php 
              if(isset($_POST['login'])){
                if((isset($_POST['uname']) && $_POST['uname']!='' ) && (isset($_POST['password']) &&  $_POST['password']!='' ) ){
                  $name_us = $_POST['uname']; 
                  $password = $_POST['password'];
                  $username=sanitize_text_input($name_us);
                  $db->where("name",$username);
                  $db->where("password",$password);
                  $login=$db->getOne("users_tbl");
                  $user_id = $login['id'];
                  $userType = $login['type'];
                  $LastLoginDate = $login['login_date'];
                  $LastLoginTime = $login['login_time'];

                  
              if ($db->count>0) {
                  //if ($login['type']=='master') {
                    
                    $_SESSION['login_user']='1';
                    $_SESSION['alert']='1';
                    $_SESSION['user_type']=$userType;
                    $_SESSION['login_id']= $user_id;
                    $_SESSION['LastLoginDate']= $LastLoginDate;
                    $_SESSION['LastLoginTime']= $LastLoginTime;
                    $_SESSION['is_loggedin']='true';
// var_dump($_SESSION);die();
                  //To store the last login details//
                  $LoginDate = date("d-m-Y");
                  date_default_timezone_set("Asia/Karachi");
                  $LoginTime = date("h:i:sa");
                  $UsrArr = array("login_date"=>$LoginDate,"login_time"=>$LoginTime);
                  $db->where("id",$user_id);
                  $db->update("users_tbl",$UsrArr);
                  ////////////////////////////////
                    echo "<div class='alert alert-success color-set message' role='alert'>Login Successfully.</div>";
                    ?>
                <script>
                  window.location.href="index.php";
                </script>
                <?php 
                      //}   
                     }elseif($db->count==0){
                      echo "<div class='alert alert-danger color-set message' role='alert'>No Such User Found! Enter Correct User Name Or Password.</div>";
                      }
                    }
                  }
               ?>
              <h6 class="font-weight-light color-set" >Sign in to continue.</h6>
              <form class="pt-3" action="" method="POST">
                <div class="form-group">
                  <input type="text" name="uname" class="form-control form-control-lg input-set"  placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg input-set"  placeholder="Password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="login">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check" style="display: none;">
                    <label class="form-check-label text-muted color-set">
                      <input type="checkbox" class="form-check-input ">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black color-set" style="display:none;">Forgot password?</a>
                </div>
                <!-- <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="mdi mdi-facebook mr-2"></i>Connect using facebook
                  </button>
                </div> 
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.html" class="text-primary">Create</a>
                </div>-->
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
  <!-- endinject -->
  <!-- inject:js -->
  <?php include 'libraries/js_libs.php'; ?>
  <!-- endinject -->
</body>
<script>
  $(function() {
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // $("#successMessage").hide() function
    setTimeout(function(){  $(".message").hide();   }, 5000);
});
</script>

</html>
