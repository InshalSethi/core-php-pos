<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    if (isset($_REQUEST['id'])) {
    $x=$_REQUEST['id'];
    if ( $x != '') {
    $db->where("id",$x);
    $db->delete('account_type');
 ?>
<script>
  window.location.href="account-type.php";
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
    <title>POS | Account Type</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddAccTypeId = 55;
      $ReadAccTypeId = 56;
      $UpdateAccTypeId = 57;
      $DeleteAccTypeId = 58;

      $accessAddAccType = 0;
      $accessReadAccType = 0;
      $accessUpdateAccType = 0;
      $accessDeleteAccType = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddAccTypeId){
            $accessAddAccType =1;
          }
          if($UsrPer['permission_id'] == $ReadAccTypeId){
            $accessReadAccType =1;
          }
          if($UsrPer['permission_id'] == $UpdateAccTypeId){
            $accessUpdateAccType =1;
          }
          if($UsrPer['permission_id'] == $DeleteAccTypeId){
            $accessDeleteAccType =1;
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
                  <h4 class="card-title">Account Type</h4>
                  <?php if($accessAddAccType == 1){ ?>
                  <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-account-type.php'"><i class="mdi mdi-plus"></i> Add New</button>
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
                                  <th class="th-set text-center">Type</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php 
                              $at = 1;
                              $account_typedata = $db->get('account_type');
                              foreach ($account_typedata as $account_type) {
                                $account_typeid = $account_type['id'];
                                $encrypt = encode($account_typeid);
                                $TypeName = $account_type['name'];
                               ?>
                              <tr>
                                  <td class="td-set text-center"><?php echo $at; ?></td>
                                  <td class="td-set text-center"><?php echo $TypeName; ?></td>
                                  <td class="td-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        <?php if($accessUpdateAccType == 1){ ?>
                                        <a class="dropdown-item" onclick="editmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#exampleModal"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <?php }if($accessDeleteAccType == 1){ ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $account_typeid; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php $at++; } ?>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Account Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="edit-account-type">
                          
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
var r = confirm(" Are you sure to delete this Account Type ?");
if (r == true) { 
txt = "You pressed OK!";

var stateID = clicked_id;

window.location = "account-type.php?id="+clicked_id; 

} else {


}

}
//////////edit
function editmodal(id){
  $.ajax({
  type: "POST",
  url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
  data: {acc_type_id:id,action:'edit_account_type',authkey:'dabdsjjI81sa'},
  cache: false,
  success: function(result){
  $('.edit-account-type').html(result);
  }
  });
}
function edit_accountType(){
  $("#edit_AccType").submit(function(){
    var account_type_idfield = $("#account_type_idfield").val();
    var accounttypefield = $("#accounttypefield").val();

  var edit_AccType_ar = [];
  edit_AccType_ar.push({

       authkey:'dabdsjjI81sa',
       action:'edit_form_AccountType',
       account_type_idfield:account_type_idfield,
       accounttypefield:accounttypefield


  });
  $.ajax({
    type: "POST",
    url: "../../libraries/ajaxsubmit.php",
    data: {AccType_ar:edit_AccType_ar},
    cache: false,
    success: function(result){
    
      $(".edit-AccTy").html("<div class='alert alert-success' id='success' role='alert'>Account Type Updated Successfully .</div>");
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