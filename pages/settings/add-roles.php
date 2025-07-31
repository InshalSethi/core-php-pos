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
    <title>POS | Add Roles</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddRolesId = 69;

      $accessAddRoles = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddRolesId){
            $accessAddRoles =1;
          }
        }  
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
    .nav-pills-success .nav-link.active{
      background: #6da252 !important;
    }
    .nav-pills-success .nav-link{
      color: #6da252;
    }
    .rw-r{
      width: 100%;
      padding-right: 10px;
      padding-left: 10px;
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
            <?php if($accessAddRoles == 1){ ?>
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h4 class="card-title">Add Roles</h4>
              </div>
              <?php 
              if (isset($_POST['add-roles'])) {

                $name = $_POST['roles_name'];

                $created_at = date("Y-m-d");
                
                $ins_roles = array("name"=>$name,"created_at"=>$created_at);
                $roleID = $db->insert("roles",$ins_roles);

//////////////////////Read Permission /////////////////////////////////////////////////////

                if(isset($_POST['readpermission'])) {
                    $readPer = $_POST['readpermission'];

                    foreach ($readPer as $read){

                      $RolPermissionRead = array("role_id"=>$roleID,"permission_id"=>$read,"created_at"=>$created_at);
                     $db->insert("role_permissions",$RolPermissionRead);
                    }
                }
//////////////////////Create Permissions ///////////////////////////////////////////////////

                if(isset($_POST['createpermission'])) {
                    $createPer = $_POST['createpermission'];

                    foreach ($createPer as $create){

                      $RolPermissionCreate = array("role_id"=>$roleID,"permission_id"=>$create,"created_at"=>$created_at);
                     $db->insert("role_permissions",$RolPermissionCreate);
                    }
                }
//////////////////////Update Permissions //////////////////////////////////////////////////
                if(isset($_POST['updatepermission'])) {
                    $updatePer = $_POST['updatepermission'];

                    foreach ($updatePer as $update){

                      $RolPermissionUpdate = array("role_id"=>$roleID,"permission_id"=>$update,"created_at"=>$created_at);
                     $db->insert("role_permissions",$RolPermissionUpdate);
                    }
                }
/////////////////////Delete Permissions ///////////////////////////////////////////////////
                if(isset($_POST['deletepermission'])) {
                    $deletePer = $_POST['deletepermission'];

                    foreach ($deletePer as $delete){

                      $RolPermissionDelete = array("role_id"=>$roleID,"permission_id"=>$delete,"created_at"=>$created_at);
                     $db->insert("role_permissions",$RolPermissionDelete);
                    }
                }
                //die();
                
                

                if (!empty($roleID)){
                      echo "<div class='alert alert-success' id='success-alert' role='alert'>Data inserted successfully .</div>";
                        } else{
                          echo "<div class='alert alert-danger' role='alert'>Alert! Data not inserted.</div>";
                        }
              }
               ?>
              <div class="col-lg-12">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <form action="" method="POST">
                      <div class="row set-mr-btm rw-r">
                        <div class="col-md-5">
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label class="col-form-label">Name</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                                </div>
                                <input type="text" name="roles_name" class="form-control" required id="roles_namefield" placeholder="Enter Name"/>
                              </div>
                            </div>
                          </div>
                          </div>
                      </div>
                      <div class="row set-mr-btm rw-r">
                        <div class="col-md-12 set-mr-btm">
                          <span class="btn btn-light btn-set" id="CheckAll">Select All</span>
                        </div>
                        <div class="col-md-12">
                          <ul class="nav nav-pills nav-pills-success" id="pills-tab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-Read-tab" data-toggle="pill" href="#pills-Read" role="tab" aria-controls="pills-Read" aria-selected="true">Read</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-Create-tab" data-toggle="pill" href="#pills-Create" role="tab" aria-controls="pills-Create" aria-selected="false">Create</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-Update-tab" data-toggle="pill" href="#pills-Update" role="tab" aria-controls="pills-Update" aria-selected="false">Update</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="pills-Delete-tab" data-toggle="pill" href="#pills-Delete" role="tab" aria-controls="pills-Delete" aria-selected="false">Delete</a>
                            </li>
                          </ul>
                          <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-Read" role="tabpanel" aria-labelledby="pills-Read-tab">
                              <div class="media">
                                <div class="row rw-r">
                                  <?php
                                    $db->where("type",'1');
                                    $PermissionsData = $db->get("permissions");
                                      foreach ($PermissionsData as $Permission) {
                                        $PerId = $Permission['id'];
                                        $PerName = $Permission['name'];
                                  ?>
                                  <div class="col-md-4 no-side-padding">
                                    <div class="form-group row">
                                      <div class="col-sm-12 set-check-col">
                                        <label class="col-form-label"></label>
                                        <div class="form-check form-check-flat form-check-primary">
                                          <label class="form-check-label">
                                            <?php echo $PerName; ?>
                                            <input type="checkbox" name="readpermission[]" class="form-check-input" id="readpermissionfield<?php echo $PerId; ?>" value="<?php echo $PerId; ?>">
                                          <i class="input-helper"></i></label>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php }?>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="pills-Create" role="tabpanel" aria-labelledby="pills-Create-tab">
                              <div class="media">
                                <div class="row rw-r">
                                  <?php
                                    $db->where("type",'2');
                                    $PermissionsData = $db->get("permissions");
                                      foreach ($PermissionsData as $Permission) {
                                        $PerId = $Permission['id'];
                                        $PerName = $Permission['name'];
                                  ?>
                                  <div class="col-md-4 no-side-padding">
                                    <div class="form-group row">
                                      <div class="col-sm-12 set-check-col">
                                        <label class="col-form-label"></label>
                                        <div class="form-check form-check-flat form-check-primary">
                                          <label class="form-check-label">
                                            <?php echo $PerName; ?>
                                            <input type="checkbox" name="createpermission[]" class="form-check-input" id="createpermissionfield<?php echo $PerId; ?>" value="<?php echo $PerId; ?>">
                                          <i class="input-helper"></i></label>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php }?>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="pills-Update" role="tabpanel" aria-labelledby="pills-Update-tab">
                              <div class="media">
                                <div class="row rw-r">
                                  <?php
                                    $db->where("type",'3');
                                    $PermissionsData = $db->get("permissions");
                                      foreach ($PermissionsData as $Permission) {
                                        $PerId = $Permission['id'];
                                        $PerName = $Permission['name'];
                                  ?>
                                  <div class="col-md-4 no-side-padding">
                                    <div class="form-group row">
                                      <div class="col-sm-12 set-check-col">
                                        <label class="col-form-label"></label>
                                        <div class="form-check form-check-flat form-check-primary">
                                          <label class="form-check-label">
                                            <?php echo $PerName; ?>
                                            <input type="checkbox" name="updatepermission[]" class="form-check-input" id="updatepermissionfield<?php echo $PerId; ?>" value="<?php echo $PerId; ?>">
                                          <i class="input-helper"></i></label>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php }?>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="pills-Delete" role="tabpanel" aria-labelledby="pills-Delete-tab">
                              <div class="media">
                                <div class="row rw-r">
                                  <?php
                                    $db->where("type",'4');
                                    $PermissionsData = $db->get("permissions");
                                      foreach ($PermissionsData as $Permission) {
                                        $PerId = $Permission['id'];
                                        $PerName = $Permission['name'];
                                  ?>
                                  <div class="col-md-4 no-side-padding">
                                    <div class="form-group row">
                                      <div class="col-sm-12 set-check-col">
                                        <label class="col-form-label"></label>
                                        <div class="form-check form-check-flat form-check-primary">
                                          <label class="form-check-label">
                                            <?php echo $PerName; ?>
                                            <input type="checkbox" name="deletepermission[]" class="form-check-input" id="deletepermissionfield<?php echo $PerId; ?>" value="<?php echo $PerId; ?>">
                                          <i class="input-helper"></i></label>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php }?>
                                </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row set-mr-btm rw-r">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                          <div class="btn-right">
                            <button type="submit" name="add-roles" class="btn btn-success btn-mac" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
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
          <?php }else{ echo "<h5 class='text-danger'>You are not allowed to use this feature, Contact main admin.</h5>";} ?>
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
    $(document).ready(function() {
    $("#success-alert").fadeTo(4000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    $("#success-alert").hide();
    });

    ///////
    $("#CheckAll").click(function(){

      if ($('.form-check-input').is(':checked')) {
        $('.form-check-input').prop('checked',false);
      }else{
        $('.form-check-input').prop('checked',true);
      }
    });
  });
</script>
</html>