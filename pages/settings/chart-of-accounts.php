<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    if (isset($_REQUEST['id'])) {
    $x=$_REQUEST['id'];
    if ( $x != '') {
    $db->where("chrt_id",$x);
    $db->delete('chart_accounts');
 ?>
<script>
  window.location.href="chart-of-accounts.php";
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
    <title>POS | Chart Of Accounts</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddCOAccId = 63;
      $ReadCOAccId = 64;
      $UpdateCOAccId = 65;
      $DeleteCOAccId = 66;

      $accessAddCOAcc = 0;
      $accessReadCOAcc = 0;
      $accessUpdateCOAcc = 0;
      $accessDeleteCOAcc = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddCOAccId){
            $accessAddCOAcc =1;
          }
          if($UsrPer['permission_id'] == $ReadCOAccId){
            $accessReadCOAcc =1;
          }
          if($UsrPer['permission_id'] == $UpdateCOAccId){
            $accessUpdateCOAcc =1;
          }
          if($UsrPer['permission_id'] == $DeleteCOAccId){
            $accessDeleteCOAcc =1;
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
                  <h4 class="card-title">Chart Of Accounts</h4>
                  <?php if($accessAddCOAcc == 1){ ?>
                  <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-chart-of-account.php'"><i class="mdi mdi-plus"></i> Add New</button>
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
                                  <th class="th-set text-center">Account Name</th>
                                  <th class="th-set text-center">Account Group</th>
                                  <th class="th-set text-center">Status</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php 
                              $chrt = 1;
                              $chart_accountsdata = $db->get('chart_accounts');
                              foreach ($chart_accountsdata as $chart_accounts) {
                                $chart_accountid = $chart_accounts['chrt_id'];
                                $encrypt = encode($chart_accountid);
                                $acc_groupId = $chart_accounts['acc_group'];
                                $AccountName = $chart_accounts['account_name'];
                                $status = $chart_accounts['status'];

                                $db->where("id",$acc_groupId);
                                $accGroup = $db->getOne("account_group");
                                $AccountGroupName = $accGroup['account_group_name'];
                               ?>
                              <tr>
                                  <td class="td-set text-center"><?php echo $chrt; ?></td>
                                  <td class="td-set text-center"><?php echo $AccountName; ?></td>
                                  <td class="td-set text-center"><?php echo $AccountGroupName; ?></td>
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
                                        <?php if($accessUpdateCOAcc == 1){ ?>
                                        <a class="dropdown-item" onclick="editmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#exampleModal"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <?php }if($accessDeleteCOAcc == 1){ ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $chart_accountid; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php $chrt++; } ?>
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
                        <h5 class="modal-title" id="exampleModalLabel">Edit Chart Of Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="edit-chart-account">
                          
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
var r = confirm(" Are you sure to delete this Chart Of Account ?");
if (r == true) { 
txt = "You pressed OK!";

var stateID = clicked_id;

window.location = "chart-of-accounts.php?id="+clicked_id; 

} else {


}

}
//////////edit
function editmodal(id){
  $.ajax({
  type: "POST",
  url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
  data: {chart_acc_id:id,action:'edit_chart_account',authkey:'dabdsjjI81sa'},
  cache: false,
  success: function(result){
  $('.edit-chart-account').html(result);
  }
  });
}
function edit_chrtAcc(){
  $("#edit_chrtAcc").submit(function(){
    
    var account_groupfield = $("#account_groupfield").val();
    var pre_chrt_id = $(".pre_chrt_id").val();
    var account_namefield = $("#account_namefield").val();
    var statusyes = $("#q1").val();
    if ($('#q1').is(':checked')) {statusyes = '1'}else{statusyes = ''}

    var statusno = $("#q2").val();
    if ($('#q2').is(':checked')) {statusno = '0'}else{statusno = ''}

  var edit_chrtAcc_ar = [];
  edit_chrtAcc_ar.push({

       authkey:'dabdsjjI81sa',
       action:'edit_form_chrtAcc',
       account_groupfield:account_groupfield,
       pre_chrt_id:pre_chrt_id,
       account_namefield:account_namefield,
       statusyes:statusyes,
       statusno:statusno


  });
  $.ajax({
    type: "POST",
    url: "../../libraries/ajaxsubmit.php",
    data: {chrtAcc_ar:edit_chrtAcc_ar},
    cache: false,
    success: function(result){
    
      $(".edit-ChrAc").html("<div class='alert alert-success' id='success' role='alert'>Chart Of Account Updated Successfully .</div>");
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