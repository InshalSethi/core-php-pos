<?php
  //if (isset($_POST['logout'])) {
  session_start();
  session_unset();
  session_destroy();
 ?>
 <script type="text/javascript">
 	window.location='../index.php';
 </script>

 <?php
  exit();

  //}
?>