<?php
  //if (isset($_POST['logout'])) {
  session_start();
  unset($_SESSION['login_user']);
  unset($_SESSION['user_type']);
  unset($_SESSION['login_id']);
  unset($_SESSION['LastLoginDate']);
  unset($_SESSION['LastLoginTime']);
  unset($_SESSION['is_loggedin']);
  session_destroy();
//   header("Location:../../login.php");
 ?>
  <script type="text/javascript">
    window.location.href="login.php";
  </script>
  <?
  exit();

  //}
?>