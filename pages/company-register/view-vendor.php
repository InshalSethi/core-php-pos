<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    
    if (isset($_REQUEST['vn'])) {
        
        $v_id = $_REQUEST['vn'];
        $vendor_id = decode($v_id);
        $db->where('id',$vendor_id);
        $vendor = $db->getOne("vendors");
        $name = $vendor['name'];
        $email = $vendor['email'];
        $phone = $vendor['phone'];
        $website = $vendor['website'];
        $address = $vendor['address'];
        $picture = $vendor['picture'];
        $status = $vendor['status'];
        $reference = $vendor['reference'];
        
    }
    ?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MAC | View Vendor</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
  </head>
  <style>
  .img-ven{
        border: 2px solid #6da252;
        border-radius: 5px;
        width: 175px;
        box-shadow: 0 2px 2px 0 rgba(96, 97, 96, 0.14), 0 3px 1px -2px rgba(99, 105, 103, 0.2), 0 1px 5px 0 rgba(98, 107, 104, 0.12);
  }
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
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h4 class="card-title">View Vendor</h4>
              </div>
              <div class="col-lg-12">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Name</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                    </div>
                                    <input type="text" name="vendor_name" class="form-control" required id="vendornamefield" readonly placeholder="Enter Name" value="<?php echo $name; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Email</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-email"></i></span>
                                    </div>
                                    <input type="text" name="vendor_email" class="form-control" id="vendor_emailfield" readonly placeholder="Enter Email" value="<?php echo $email; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Phone</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-phone"></i></span>
                                    </div>
                                    <input type="text" name="vendor_phone" class="form-control" id="vendorphonefield" readonly placeholder="Enter Phone" value="<?php echo $phone; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Website</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-web"></i></span>
                                    </div>
                                    <input type="text" name="vendor_website" class="form-control" id="vendorwebsitefield" readonly placeholder="Enter Website" value="<?php echo $website; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Address</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-home-map-marker"></i></span>
                                    </div>
                                    <input type="text" name="vendor_address" class="form-control" id="vendoraddressfield" readonly placeholder="Enter Address" value="<?php echo $address; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Reference</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-note-text"></i></span>
                                    </div>
                                    <input type="text" name="vendor_reference" class="form-control" id="vendorreferencefield" readonly placeholder="Enter Reference" value="<?php echo $reference; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                  <div class="col-sm-12 set-check-col">
                                    <div class="form-check form-check-flat form-check-primary">
                                      <label class="form-check-label">
                                        Active
                                        <input type="checkbox" name="status" class="form-check-input" id="statusfield" value="1" <?php if($status == '1'){echo 'checked';} ?>>
                                      <i class="input-helper"></i></label>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <?php if($picture != ''){ ?>
                                    <img class="img-ven" src="../../assets/images/vendors/<?php  echo $picture; ?>" />
                                    <?php }else{  ?>
                                    <img class="img-ven" src="../../assets/images/vendors/im-not-found.png" />
                                    <?php } ?>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
              
           
          </div>
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