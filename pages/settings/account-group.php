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
    $db->delete('account_group');
 ?>
<script>
  window.location.href="account-group.php";
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
    <title>POS | Account Group</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddAccGroupId = 59;
      $ReadAccGroupId = 60;
      $UpdateAccGroupId = 61;
      $DeleteAccGroupId = 62;

      $accessAddAccGroup = 0;
      $accessReadAccGroup = 0;
      $accessUpdateAccGroup = 0;
      $accessDeleteAccGroup = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddAccGroupId){
            $accessAddAccGroup =1;
          }
          if($UsrPer['permission_id'] == $ReadAccGroupId){
            $accessReadAccGroup =1;
          }
          if($UsrPer['permission_id'] == $UpdateAccGroupId){
            $accessUpdateAccGroup =1;
          }
          if($UsrPer['permission_id'] == $DeleteAccGroupId){
            $accessDeleteAccGroup =1;
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
                  <h4 class="card-title">Account Group</h4>
                  <?php if($accessAddAccGroup == 1){ ?>
                  <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-account-group.php'"><i class="mdi mdi-plus"></i> Add New</button>
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
                                  <th class="th-set text-center">Account Group</th>
                                  <th class="th-set text-center">Type</th>
                                  <th class="th-set text-center">Status</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php 
                              $ag = 1;
                              $account_groupdata = $db->get('account_group');
                              foreach ($account_groupdata as $account_group) {
                                $account_groupid = $account_group['id'];
                                $encrypt = encode($account_groupid);
                                $AccountTypeId = $account_group['acc_type_id'];
                                $AccountGroupName = $account_group['account_group_name'];
                                $status = $account_group['status'];

                                $db->where("id",$AccountTypeId);
                                $AccTypeData = $db->getOne("account_type");
                                $TypeName = $AccTypeData['name'];
                               ?>
                              <tr>
                                  <td class="td-set text-center"><?php echo $ag; ?></td>
                                  <td class="td-set text-center"><?php echo $AccountGroupName; ?></td>
                                  <td class="td-set text-center"><?php echo $TypeName; ?></td>
                                  <td class="td-set text-center">
                                    <?php if ($status == '1') { ?>
                                    <button type="button" class="mac-badge">Active</button>
                                    <?php }elseif ($status == '0') { ?>
                                    <button type="button" class="mac-badge-inactive">Inactive</button>
                                  <?php } ?>
                                  </td>
                                  <td class="td-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        <?php if($accessUpdateAccGroup == 1){ ?>
                                        <a class="dropdown-item" onclick="editmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#exampleModal"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <?php }if($accessDeleteAccGroup == 1){ ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $account_groupid; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php $ag++; } ?>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Account Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="edit-account-group">
                          
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
var r = confirm(" Are you sure to delete this Account Group ?");
if (r == true) { 
txt = "You pressed OK!";

var stateID = clicked_id;

window.location = "account-group.php?id="+clicked_id; 

} else {


}

}
//////////edit
function editmodal(id){
  $.ajax({
  type: "POST",
  url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
  data: {acc_group_id:id,action:'edit_account_group',authkey:'dabdsjjI81sa'},
  cache: false,
  success: function(result){
  $('.edit-account-group').html(result);
  }
  });
}
function edit_accountGroup(){
  $("#edit_AccGroup").submit(function(){
    var account_group_idfield = $("#account_group_idfield").val();
    var accountTypeIdfield = $("#accountTypeIdfield").val();
    var accountGroupNamefield = $("#accountGroupNamefield").val();
    var statusyes = $("#q1").val();
    if ($('#q1').is(':checked')) {statusyes = '1'}else{statusyes = ''}

    var statusno = $("#q2").val();
    if ($('#q2').is(':checked')) {statusno = '0'}else{statusno = ''}

  var edit_AccGroup_ar = [];
  edit_AccGroup_ar.push({

       authkey:'dabdsjjI81sa',
       action:'edit_form_AccountGroup',
       account_group_idfield:account_group_idfield,
       accountTypeIdfield:accountTypeIdfield,
       accountGroupNamefield:accountGroupNamefield,
       statusyes:statusyes,
       statusno:statusno


  });
  $.ajax({
    type: "POST",
    url: "../../libraries/ajaxsubmit.php",
    data: {AccGroup_ar:edit_AccGroup_ar},
    cache: false,
    success: function(result){
    
      $(".edit-AccGr").html("<div class='alert alert-success' id='success' role='alert'>Account Group Updated Successfully .</div>");
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