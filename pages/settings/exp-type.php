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
    $db->delete('exp_type');
 ?>
<script>
  window.location.href="exp-type.php";
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
    <title>POS | Type Of Expense</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddExpTypeId = 51;
      $ReadExpTypeId = 52;
      $UpdateExpTypeId = 53;
      $DeleteExpTypeId = 54;

      $accessAddExpType = 0;
      $accessReadExpType = 0;
      $accessUpdateExpType = 0;
      $accessDeleteExpType = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddExpTypeId){
            $accessAddExpType =1;
          }
          if($UsrPer['permission_id'] == $ReadExpTypeId){
            $accessReadExpType =1;
          }
          if($UsrPer['permission_id'] == $UpdateExpTypeId){
            $accessUpdateExpType =1;
          }
          if($UsrPer['permission_id'] == $DeleteExpTypeId){
            $accessDeleteExpType =1;
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
                  <h4 class="card-title">Type Of Expense</h4>
                  <?php if($accessAddExpType == 1){ ?>
                  <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-exp-type.php'"><i class="mdi mdi-plus"></i> Add New</button>
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
                                  <th class="th-set text-center">Status</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php 
                              $c = 1;
                              $exp_typedata = $db->get('exp_type');
                              foreach ($exp_typedata as $exp_type) {
                                $exp_typeid = $exp_type['id'];
                                $encrypt = encode($exp_typeid);
                                $exp_typename = $exp_type['type_name'];
                                $exp_typestatus = $exp_type['status'];
                               ?>
                              <tr>
                                  <td class="td-set text-center"><?php echo $c; ?></td>
                                  <td class="td-set text-center"><?php echo $exp_typename; ?></td>
                                  <td class="td-set text-center">
                                    <?php if ($exp_typestatus == '1') { ?>
                                    <button type="button" class="mac-badge">Active</button>
                                    <?php }elseif ($exp_typestatus == '0') { ?>
                                    <button type="button" class="mac-badge-inactive">Inactive</button>
                                  <?php } ?>
                                  </td>
                                  <td class="td-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        <?php if($accessUpdateExpType == 1){ ?>
                                        <a class="dropdown-item" onclick="editmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#exampleModal"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <?php }if($accessDeleteExpType == 1){ ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $exp_typeid; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php $c++; } ?>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Type of Expense</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="edit-exp-type-file">
                          
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
var r = confirm(" Are you sure to delete this Type of Expense ?");
if (r == true) { 
txt = "You pressed OK!";

var stateID = clicked_id;

window.location = "exp-type.php?id="+clicked_id; 

} else {


}

}
//////////edit
function editmodal(id){
  $.ajax({
  type: "POST",
  url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
  data: {exp_type_id:id,action:'edit_exp_type_modal',authkey:'dabdsjjI81sa'},
  cache: false,
  success: function(result){
  $('.edit-exp-type-file').html(result);
  }
  });
}
function edit_exp_type(){
  $("#edit_exp_type").submit(function(){
    var exp_type_idfield = $(".exp_type_idfield").val();
    var exp_type_namefield = $(".exp_type_namefield").val();
    var chrt_acc = $(".chrt_acc").val();
    var statusyes = $("#q1").val();
    if ($('.q1').is(':checked')) {statusyes = '1'}else{statusyes = ''}

    var statusno = $("#q2").val();
    if ($('.q2').is(':checked')) {statusno = '0'}else{statusno = ''}

  var edit_exp_type_ar = [];
  edit_exp_type_ar.push({

       authkey:'dabdsjjI81sa',
       action_exp_type:'edit_form_exp_type',
       exp_type_idfield:exp_type_idfield,
       exp_type_namefield:exp_type_namefield,
       chrt_acc:chrt_acc,
       statusyes:statusyes,
       statusno:statusno


  });
  $.ajax({
    type: "POST",
    url: "../../libraries/ajaxsubmit.php",
    data: {exp_type_ar:edit_exp_type_ar},
    cache: false,
    success: function(result){
    
      $(".edit-exp-type").html("<div class='alert alert-success' id='success' role='alert'>Type Of Expense Updated Successfully .</div>");
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