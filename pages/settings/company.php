<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Company Profile</title>
    <?php include '../../libraries/libs.php'; ?>
    <?php include '../../include/auth.php'; ?>
    <?php
      // $UpdateCompanyId = 67;

      // $accessUpdateCompany = 0;
      // $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
      //   foreach ($UserDataAccess as $UsrPer) {
      //     if($UsrPer['permission_id'] == $UpdateCompanyId){
      //       $accessUpdateCompany =1;
      //     }
      //   }  
    ?>
  </head>
  <style>
    .set-card-body{
          padding-left: 10px!important;
          padding-right: 10px!important;
    }
    .set-mr-btm{
      margin-bottom: 10px;
    }
     .setting-loader{
    border: none!important;
  }
  .dot-opacity-loader{
    width: 100%;
    height: auto;
    text-align: right;
  }
  .dot-opacity-loader span{
    margin: 2px 5px;
    background-color: #6da252;
  }
  .loader-demo-box{
    height: auto;
  }
  .no-loader{
    display: none;
  }
  .small-space{
    padding: 20px!important;
  }
  .img-ab{
        margin-top: 30px;
  }
  .img-set{
        border: 2px solid #6da252;
        border-radius:5px;
        width: 175px;
        box-shadow: 0 2px 2px 0 rgba(96, 97, 96, 0.14), 0 3px 1px -2px rgba(99, 105, 103, 0.2), 0 1px 5px 0 rgba(98, 107, 104, 0.12);
  }
  .file-up{
      width: 175px;
      padding: 0px!important;
      padding-top: 2px!important;
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
            <?php //if($accessUpdateCompany == 1){ ?>
            <div class="row">
              <div class="col-lg-6">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h5 class="text-dark mb-0">
                   Maintain Company Information
                  </h5>
                </div>
              </div>
              <div class="col-lg-6">
               <div class="no-loader">
                  <div class="loader-demo-box setting-loader">
                    <div class="dot-opacity-loader">
                      <span></span>
                      <span></span>
                      <span></span>
                      <span></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

    <?php 
      $companydata = $db->getOne('company');
      $id = $companydata['com_id'];
      $name = $companydata['name'];
      $address = $companydata['address'];
      $contact = $companydata['contact'];
      $owner = $companydata['owner'];
      $tag_line = $companydata['tag_line'];
      $note = $companydata['note'];
      $image = $companydata['image'];
     ?>
          <?php 
              if (isset($_POST['sav_company'])) {

                $co_name = $_POST['co_name'];
                $address = $_POST['address'];
                $ph_num = $_POST['ph_num'];
                $owner = $_POST['owner'];
                $tag_line = $_POST['tag_line'];
                $company_note = $_POST['company_note'];
                $updated_at = date("Y-m-d");
                
                if( $_FILES['com_logo']['name'] == '' ){
                $arr_company = array("name"=>$co_name,"address"=>$address,"contact"=>$ph_num,"owner"=>$owner,"tag_line"=>$tag_line,"note"=>$company_note,"updated_at"=>$updated_at);
               
                

                } else{
                   
                      $Path = '../../assets/images/'.$image.'';
                    //die();
                    if (file_exists($Path)){
                        if (unlink($Path)) {   
                            //echo "success";
                        } else {
                            echo "fail";    
                        }   
                    } else {
                        echo "file does not exist";
                    }
                    
                    if( $_FILES['com_logo']['name'] ) {
                        list($file_name,$error) = upload('com_logo','../../assets/images/','jpg,jpeg,gif,png');
                        if($error) print $error;
                    }

                    $arr_company = array("name"=>$co_name,"address"=>$address,"contact"=>$ph_num,"owner"=>$owner,"tag_line"=>$tag_line,"note"=>$company_note,"image"=>$file_name,"updated_at"=>$updated_at);
                    // var_dump($arr_company);
                    // die();
                  }
                  $db->where('com_id',$id);
                  $company = $db->update("company",$arr_company);

                if (!empty($company)){
                      echo "<div class='alert alert-success' id='success-alert' role='alert'>Data updated successfully .</div>";
                      ?>
                      <script>window.location.href="company.php";</script>
                      <?php
                        } else{
                          echo "<div class='alert alert-danger' role='alert'>Alert! Data not updated.</div>";
                        }
              }
               ?>


          <div class="row">
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
                                <span class="input-group-text in-grp"><i class="mdi mdi-account-box-outline"></i></span>
                              </div>
                              <input type="text" name="co_name" class="form-control" required placeholder="Enter Name" value="<?php echo $name; ?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <label class="col-form-label">Address</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text in-grp"><i class="mdi mdi-google-maps"></i></span>
                              </div>
                              <input type="text" name="address" class="form-control" placeholder="Enter Address" value="<?php echo $address; ?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <label class="col-form-label">Phone No</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text in-grp"><i class="mdi mdi-cellphone"></i></span>
                              </div>
                              <input type="text" name="ph_num" class="form-control" placeholder="Enter Phone Number" value="<?php echo $contact; ?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <label class="col-form-label">Owner Name</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text in-grp"><i class="mdi mdi-account"></i></span>
                              </div>
                              <input type="text" name="owner" class="form-control" placeholder="Enter Owner Name" value="<?php echo $owner; ?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <label class="col-form-label">Tag Line</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text in-grp"><i class="mdi mdi-pencil-box-outline"></i></span>
                              </div>
                              <input type="text" name="tag_line" class="form-control" placeholder="Enter Tag Line" value="<?php echo $tag_line; ?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <label class="col-form-label">Note</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text in-grp"><i class="mdi mdi-note-text"></i></span>
                              </div>
                              <input type="text" name="company_note" class="form-control" placeholder="Write Anything..." value="<?php echo $note; ?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="img-ab">
                          <?php if($image != ''){ ?>
                            <img class="img-set" src="<?php echo baseurl('assets/images/'); echo $image; ?>" alt="Company Logo"/>
                            <?php }else{ ?>
                            <img class="img-set" src="https://via.placeholder.com/25*25" alt="Company Logo"/>
                            <?php } ?>
                            <input type="file" name="com_logo" class="file-up"/>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                        <div class="btn-right">
                          <button type="submit" name="sav_company" class="btn btn-success btn-mac" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                          <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php //}else{ echo "<h5 class='text-danger'>You are not allowed to use this feature, Contact main admin.</h5>";} ?>
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
    $(".alert-success").fadeTo(4000, 500).slideUp(500, function(){
    $(".alert-success").slideUp(500);
    $(".alert-success").hide();
    });
</script>
</html>