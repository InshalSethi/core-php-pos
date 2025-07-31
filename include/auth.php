<?php
// var_dump($_SESSION);die();
if(!isset($_SESSION['login_user']) && !isset($_SESSION['user_type']) && !isset($_SESSION['login_id']) && !isset($_SESSION['is_loggedin'])){
 ?>
    <script>
        window.location ="<?php echo baseurl('login.php');?>";
    </script>
   <?php
}
 ?>
