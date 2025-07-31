<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    
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
    <title>MAC | Edit Vendor</title>
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
                  <h4 class="card-title">Edit Vendor</h4>
              </div>
              <?php 
              if (isset($_POST['edit-vendor'])) {
                  
                $vendor_name = $_POST['vendor_name'];
                $vendor_email = $_POST['vendor_email'];
                $vendor_phone = $_POST['vendor_phone'];
                $vendor_website = $_POST['vendor_website'];
                $vendor_address = $_POST['vendor_address'];
                $vendor_reference = $_POST['vendor_reference'];
                if($_FILES['vendor_picture']['name']) {
                        list($file,$error) = upload('vendor_picture','../../assets/images/vendors','jpg,jpeg,gif,png');
                        if($error) print $error;
                        }
                $status = $_POST['status'];
                
                if (!empty($status)) {
                  $status = '1';
                }else{
                  $status = '0';
                }
                $updated_at = date("Y-m-d");
                if (isset($file)) {
                    $up_vendor = array("name"=>$vendor_name,"email"=>$vendor_email,"phone"=>$vendor_phone,"website"=>$vendor_website,"address"=>$vendor_address,"picture"=>$file,"status"=>$status,"reference"=>$vendor_reference,"updated_at"=>$updated_at);
                    
                    $Path = '../../assets/images/vendors/'.$picture;
                    if (file_exists($Path)){
                        if (unlink($Path)) {   
                            //echo "success";
                        } else {
                            echo "Failed to unlink previous image";    
                        }   
                    } else {
                        echo "Unlinked file does not exist";
                    }
                }else{
                    $up_vendor = array("name"=>$vendor_name,"email"=>$vendor_email,"phone"=>$vendor_phone,"website"=>$vendor_website,"address"=>$vendor_address,"status"=>$status,"reference"=>$vendor_reference,"updated_at"=>$updated_at);
                }
                
                $vendors = $db->update("vendors",$up_vendor);

                if (!empty($vendors)){
                      echo "<div class='alert alert-success' id='success-alert' role='alert'>Data updated successfully .</div>";
                      ?>
                      <script>window.location.href="<?php echo baseurl('pages/company-register/vendors.php'); ?>";</script>
                      <?php 
                        } else{
                          echo "<div class='alert alert-danger' role='alert'>Alert! Data not updated.</div>";
                        }
              }
               ?>
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
                                    <input type="text" name="vendor_name" class="form-control" required id="vendornamefield" placeholder="Enter Name" value="<?php echo $name; ?>"/>
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
                                    <input type="text" name="vendor_email" class="form-control" id="vendor_emailfield" placeholder="Enter Email" value="<?php echo $email; ?>"/>
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
                                    <input type="text" name="vendor_phone" class="form-control" id="vendorphonefield" placeholder="Enter Phone" value="<?php echo $phone; ?>"/>
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
                                    <input type="text" name="vendor_website" class="form-control" id="vendorwebsitefield" placeholder="Enter Website" value="<?php echo $website; ?>"/>
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
                                    <input type="text" name="vendor_address" class="form-control" id="vendoraddressfield" placeholder="Enter Address" value="<?php echo $address; ?>"/>
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
                                    <input type="text" name="vendor_reference" class="form-control" id="vendorreferencefield" placeholder="Enter Reference" value="<?php echo $reference; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-sm-12">
                                  <label class="col-form-label">Picture</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text in-grp"><i class="mdi mdi-folder-image"></i></span>
                                    </div>
                                    <input type="file" name="vendor_picture" class="form-control" id="vendorpicturefield" value="<?php echo $picture; ?>"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row" style="margin-top: 25px;">
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
                            <div class="col-md-6">
                                <?php if($picture != ''){ ?>
                                    <img class="img-ven" src="../../assets/images/vendors/<?php  echo $picture; ?>" />
                                    <?php }else{  ?>
                                    <img class="img-ven" src="../../assets/images/vendors/im-not-found.png" />
                                    <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-right" style="margin-top: 5px;">
                                    <button type="submit" name="edit-vendor" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                                    <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                                </div>
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