<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    if (isset($_REQUEST['id'])) {
    $x=$_REQUEST['id'];
    if ( $x != '') {
    $db->where("role_id",$x);
    $db->delete('role_permissions');

    $db->where("id",$x);
    $db->delete('roles');
 ?>
<script>
  window.location.href="roles.php";
</script>
    <?php
    }      
    }
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS | Roles</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddRolesId = 69;
      $ReadRolesId = 70;
      $UpdateRolesId = 71;
      $DeleteRolesId = 72;

      $accessAddRoles = 0;
      $accessReadRoles = 0;
      $accessUpdateRoles = 0;
      $accessDeleteRoles = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddRolesId){
            $accessAddRoles =1;
          }
          if($UsrPer['permission_id'] == $ReadRolesId){
            $accessReadRoles =1;
          }
          if($UsrPer['permission_id'] == $UpdateRolesId){
            $accessUpdateRoles =1;
          }
          if($UsrPer['permission_id'] == $DeleteRolesId){
            $accessDeleteRoles =1;
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
                  <h4 class="card-title">Roles</h4>
                  <?php if($accessAddRoles == 1){ ?>
                  <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-roles.php'"><i class="mdi mdi-plus"></i> Add New</button>
                <?php } ?>
                </div>
              </div>
              <div class="col-lg-12">
                 <div class="card card-border-color">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="table-responsive">
                          <table id="order-listing" class="table table-striped">
                            <thead>
                              <tr>
                                  <th class="th-set text-center">SR#</th>
                                  <th class="th-set text-center">Name</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php 
                              $ro = 1;
                              $rolesdata = $db->get('roles');
                              foreach ($rolesdata as $roles) {
                                $roleid = $roles['id'];
                                $encrypt = encode($roleid);
                                $rolename = $roles['name'];
                               ?>
                              <tr>
                                  <td class="td-set text-center"><?php echo $ro; ?></td>
                                  <td class="td-set text-center"><?php echo $rolename; ?></td>
                                  <td class="td-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        <?php if($accessUpdateRoles == 1){ ?>
                                        <a class="dropdown-item" href="<?php echo baseurl('pages/settings/edit-roles.php'); echo '?ro='.$encrypt; ?>"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <?php }if($accessDeleteRoles == 1){ ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $roleid; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php $ro++; } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Roles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="edit-roles-file">
                          
                        </div>
                      </div>
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
  function myFunction(clicked_id) {
  var txt;
  var r = confirm(" Are you sure to delete this Role ?");
  if (r == true) { 
  txt = "You pressed OK!";

  var stateID = clicked_id;

  window.location = "roles.php?id="+clicked_id; 

  } else {


  }

  }
//////////edit
function editmodal(id){
  $.ajax({
  type: "POST",
  url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
  data: {role_id:id,action:'edit_roles_modal',authkey:'dabdsjjI81sa'},
  cache: false,
  success: function(result){
  $('.edit-roles-file').html(result);
  }
  });
}
function edit_roles(){
  $("#edit_roles").submit(function(){
    var role_idfield = $(".role_idfield").val();
    var role_namefield = $(".role_namefield").val();

  var edit_role_ar = [];
  edit_role_ar.push({

       authkey:'dabdsjjI81sa',
       action_role:'edit_form_role',
       role_idfield:role_idfield,
       role_namefield:role_namefield


  });
  $.ajax({
    type: "POST",
    url: "../../libraries/ajaxsubmit.php",
    data: {edit_role_ar:edit_role_ar},
    cache: false,
    success: function(result){
    
      $(".edit-exp-type").html("<div class='alert alert-success' id='success' role='alert'>Role Updated Successfully .</div>");
      $(".alert-success").fadeTo(2500, 500).slideUp(500, function(){
      $(".alert-success").slideUp(500);
      $(".alert-success").remove();
      });
    }
    });
    return false;
    });
}
</script>
</html>