<?php 

include '../../include/functions.php';

include '../../include/MysqliDb.php';

include '../../include/config.php';

include '../../include/permission.php';




$page_title='Inventory | Categories';



if (isset($_REQUEST['id'])) {
  $x=$_REQUEST['id'];
  if ( $x != '')   {
    date_default_timezone_set("Asia/Karachi");
    $delDate =  date("Y-m-d h:i:s");

    $uparr = array("deleted_at"=>$delDate);
    $db->where("id",$x);
    $db->update('categories',$uparr);
    ?>
    <script>  window.location.href="categories.php"; </script>
    <?php
  }    } 
  ?>

  <!DOCTYPE html>

  <html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $page_title; ?></title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>



  </head>

  <body>

    <div class="container-scroller">

      <?php include '../../libraries/nav.php'; ?>

      <div class="container-fluid page-body-wrapper">

        <?php include '../../libraries/sidebar.php'; ?>



        <!-- partial -->

        <div class="main-panel" style="width: 100%;">
          <?php 


          $units_view=CheckPermission($permissions,'units_view');
          if($units_view ==1){ ?>
            <div class="content-wrapper">

              <div class="card">

                <div class="card-body">

                  <div class="row" style="padding: 13px 0px;">

                    <div class="col-md-10"><h4 class="card-title">categories</h4></div>

                    <div class="col-md-2">
                      <?php 
                      $add_unit=CheckPermission($permissions,'add_unit');
                      if($add_unit == 1){ ?>
                       <a href="add-category.php" class="btn btn-dark float-right">Add New</a>

                       <?php

                     }

                     ?>



                   </div>



                 </div>

                 

                 <div class="row">

                  <div class="col-12">

                    <div class="table-responsive">

                      <table id="order-listing" class="table">

                        <thead>

                          <tr>

                            <th>ID</th>

                            <th>Name</th>

                            <th>Status</th>

                            <th>Actions</th>

                          </tr>

                        </thead>

                        <tbody>

                          <?php 
                          $db->where ("deleted_at", NULL, 'IS');
                          $db->orderBy("id",'desc');
                          $Data = $db->get("categories"); 
                          foreach ($Data as $row) {
                            $Id = $row['id'];
                            $encrypt = encode($Id);
                            $name = $row['name'];
                            $status = $row['status'];
                            ?>
                            <tr>

                              <td><?php echo $Id ?></td>

                              <td><?php echo $name; ?></td>

                              <td class="td-set text-center">
                                <?php if ($status == '1') { ?>
                                  <button type="button" class="mac-badge">Active</button>
                                <?php }elseif ($status == '0') { ?>
                                  <button type="button" class="mac-badge-inactive">Inactive</button>
                                <?php } ?>
                              </td>

                              <td> 
                                <a href="<?php echo baseurl('pages/settings/edit-category.php'); echo '?cat='.$encrypt; ?>" class="btn btn-outline-info">Edit</a> 
                                <a onclick="deleteRow('<?php echo $Id; ?>')" class="btn btn-outline-danger">Delete</a>
                              </td>

                            </tr>

                          <?php } ?>





                        </tbody>

                      </table>

                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>


        <?php } else{
          echo "<h2 class='text-danger'>You Don't have permission to use this page contact with admin. Thank You</h2>";
        } ?>

        <!-- content-wrapper ends -->

        <!-- partial:../../partials/_footer.html -->

        <?php include '../../libraries/footer.php'; ?>

        <!-- partial -->

      </div>

      <!-- main-panel ends -->

      









    </div>

    <!-- page-body-wrapper ends -->

  </div>

  <!-- container-scroller -->

  <?php include '../../libraries/js_libs.php'; ?>


  <script>
    function deleteRow(clicked_id) {
      var txt;
      var r = confirm(" Are you sure to delete this?");
      if (r == true) { 
        txt = "You pressed OK!";

        var stateID = clicked_id;

        window.location = "categories.php?id="+clicked_id; 

      } else {


      }

    }
  </script>


</body>

</html>