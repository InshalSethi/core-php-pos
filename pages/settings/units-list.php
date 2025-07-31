<?php 

  include '../../include/functions.php';

  include '../../include/MysqliDb.php';

  include '../../include/config.php';

  include '../../include/permission.php';




  $page_title='Inventory | Units List';



  if ( isset($_REQUEST['del_id']) ) {

    $x=$_REQUEST['del_id'];

    $del_id= decode( $x );



    $db->where('un_id',$del_id);

    $db->delete('tbl_units');

    header("LOCATION:units-list.php");

  }



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

                <div class="col-md-2">
                  <?php 
                  $add_unit=CheckPermission($permissions,'add_unit');
                  if($add_unit == 1){ ?>
                   <a href="add-unit.php" class="btn btn-dark">Add New Unit</a>

                    <?php

                  }

                  ?>

                  

                </div>

                

              </div>

              <h4 class="card-title">Units</h4>

              <div class="row">

                <div class="col-12">

                  <?php

                  

                  $sup_data=$db->get('tbl_units');



                   ?>

                  <div class="table-responsive">

                    <table id="order-listing" class="table">

                      <thead>

                        <tr>

                            <th>NO.</th>

                            <th>Unit Name</th>

                            <th>Unit Symbol</th>

                            <th>Actions</th>

                        </tr>

                      </thead>

                      <tbody>

                        <?php 

                        $i=1;

                        foreach($sup_data as $sup_da){

                          $enc=encode($sup_da['un_id']);



                         ?>



                          <tr>

                            <td><?php echo $i ?></td>

                            <td><?php echo $sup_da['unit_name']; ?></td>

                            <td><?php echo $sup_da['unit_symbol']; ?></td>

                            

                            

                            <td>

                              
                              <a href="<?php echo baseurl('pages/settings/edit-unit.php'); echo '?un='.$enc; ?>" class="btn btn-outline-info">Edit</a> 
                              
                              <?php 
                              $units_delete=CheckPermission($permissions,'units_delete');
                              if($units_delete == 1){ ?>
                              <a onclick="Remove_Unit('<?php echo $enc; ?>')" class="btn btn-outline-danger">Delete</a>

                              <?php } ?>
                              

                            </td>

                          </tr>





                          <?php

                          $i++;

                        }





                        ?>

                        

                        

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





  </body>

</html>