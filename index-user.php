<?php
    include 'include/config_new.php';
    include 'include/functions.php';
    include 'include/MysqliDb.php';
    include 'include/config.php';
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Town</title>
    <?php include 'libraries/libs.php'; ?>
    <?php include 'include/auth.php'; ?>
  </head>
  <style>
    .set-card-body{
          padding-left: 10px!important;
          padding-right: 10px!important;
    }
  </style>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
 <?php include 'libraries/nav.php'; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        
        <?php include 'libraries/color-changer.php'; ?>
        
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        <?php include 'libraries/sidebar.php'; ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <?php  ?>
            <?php $type = $_SESSION['user_type']; 
            if ($type == 'user') {
            ?>
              <div class="col-lg-12">
                <div class="d-lg-flex align-items-baseline">
                  <h5 class="text-dark mb-0">
                    <?php 
                    $uid = $_SESSION['login_id'];
                    $db->where("id",$uid);
                    $user_data=$db->getOne("user_town");
                    $customer_id = $user_data['customer_id'] ;

                    echo 'Hi, '.$user_data['name'].' welcome back!';
                     ?>
                  </h5>
                  <!-- <p class="ml-md-3 font-weight-light mb-0 mt-1">Last login was 23 hours ago. View details</p> -->
                </div>
              </div>
              
            </div>
            <!-- 4 Boxed -->
            <div class="row mt-4">
              <h4>Plots List</h4>
            </div>
            <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Plot Serial</th>
                            <th>Total Price</th>
                            <th>Remaining Payment</th>
                            <th>Recived Payment</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $i=1;
                        $db->where("customer_id",$customer_id);
                        $meta_data=$db->get("customers_meta");
                        foreach ($meta_data as $meta) {
                        $pl_id = $meta['plot_id'];
                        $db->where("plot_id",$pl_id);
                        $plot_data=$db->get("plots");
                        foreach ($plot_data as $data) {

                          $plot_id=$data['plot_id'];
                          $plot_serial=$data['plot_serial'];

                          $db->where("plot_id",$plot_id);
                          $ins_data=$db->getOne("registry_details");
                          
                      ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                            <?php echo $plot_serial; ?>
                            </td>
                            <td><?php echo $ins_data['plot_price']; ?></td>
                            <td><?php echo $ins_data['remaining_payment']; ?></td>
                            <td><?php echo $ins_data['total_recived']; ?></td>
                            <td>
                              <div class="btn-group" role="group" aria-label="Basic example">
                               <a href="<?php echo baseurl('pages/customers/view-registry.php?pl-id='.$plot_id.''); ?>" class="btn btn-success">View</a>
                              </div>
                            </td>
                        </tr>
                        <?php  }  $i++;}  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <!--<div class="row">
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-lg-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-wrap justify-content-between">
                        <h5 class="card-title">Installments</h5>
                      </div>
                      <p class="text-muted mb-4 pb-4">Reemaining installments and Paid installments are shown bellow.</p>
                      <canvas id="barChart" class="mt-4"></canvas>
                      <div id="chart-legendsBar"></div>
                    </div>
                  </div>
                </div>
                  <div class="col-sm-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between">
                          <h5 class="card-title pb-md-3">Payment Chart</h5>
                        </div>
                        <canvas id="productCategory"></canvas>
                        <div id="chart-legendsproduct" class="chart-legendsproduct"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>-->
            <?php }else{ ?>
            <div class="col-lg-12">
                <div class="d-lg-flex align-items-baseline">
                  <h5 class="text-dark mb-0">
                    Error 404
                  </h5>
                  
                </div>
              </div>
            <?php  } ?>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <?php include 'libraries/footer.php'; ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <?php include 'libraries/js_libs.php'; ?>
    <?php include 'libraries/data-table-js.php'; ?>
  </body>
</html>