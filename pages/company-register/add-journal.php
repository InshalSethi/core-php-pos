<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    ?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS | Add Journal</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddJournalId = 11;
      $accessAddJv = 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddJournalId){
            $accessAddJv =1;
          }
        }  
    ?>
  </head>
<style>
  #nagative-zero{
      display:none; 
  }
  .set-card-body{
    padding-left: 10px!important;
    padding-right: 10px!important;
  }
  .set-mr-btm{
    margin-bottom: 10px;
  }
  .inactive-alert{
    display:none; 
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
        <?php
          $db->orderBy("j_id","Desc");
          $journalData = $db->get("journal_tbl",1);
          foreach ($journalData as $journal) {
            $previousjournalid = $journal['j_id'];
            $previousvoucher = $journal['voucher_no'];
            
          }
          if(!empty($previousvoucher)){
            $newvoucher = $previousvoucher+1;
          }else{
            $newvoucher = 1;
          }
          
    ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <?php if($accessAddJv == 1){ ?>
            <div class="row">
              <div class="col-lg-6 set-mr-btm">
                <div class="d-lg-flex align-items-baseline set-mr-btm">
                  <h4 class="card-title">Add Journal</h4>
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
              <div class="col-lg-12">
                <?php 
                  if (isset($_POST['add-journal'])) {
                      
                    $voucher_no = $_POST['voucher_no'];
                    $jv_date = $_POST['jv_date'];
                    $chrt_acc = $_POST['chrt_acc'];
                    $remarks = $_POST['remarks'];
                    $debit = $_POST['debit'];
                    $credit = $_POST['credit'];
                    $total_debit = $_POST['total_debit'];
                    $total_credit = $_POST['total_credit'];

                    $countAccounts = count($chrt_acc);
                    $created_at = date("Y-m-d");

                    if($voucher_no != '' && $jv_date != ''){

                    if($total_debit == $total_credit){
                    
                    $ins_journal = array("voucher_no"=>$voucher_no,"gl_type"=>'1',"date"=>$jv_date,"total_debit"=>$total_debit,"total_credit"=>$total_credit,"created_at"=>$created_at);
                    
                    $Journal_id = $db->insert("journal_tbl",$ins_journal);

                    for ($i=0; $i < $countAccounts; $i++) { 
                      //Insert Meta table entry of JV

                      $ins_jvMeta = array("j_id"=>$Journal_id,"chrt_id"=>$chrt_acc[$i],"remarks"=>$remarks[$i],"debit"=>$debit[$i],"credit"=>$credit[$i],"created_at"=>$created_at);

                      $JournalMeta_id = $db->insert("journal_meta",$ins_jvMeta);

                    }
    
                    if (!empty($Journal_id)){
                          echo "<div class='alert alert-success' id='success-alert' role='alert'>Journal data inserted successfully .</div>";
                          ?>
                          <script>
                              window.location.href="<?php echo baseurl('pages/company-register/add-journal.php'); ?>";
                          </script>
                          <?php
                          }else{
                              echo "<div class='alert alert-danger' role='alert'>Alert! Data not inserted.</div>";}
                            
                          }else { echo "<div class='alert alert-danger' role='alert'>Alert! Debit and Credit are not equal, Fill data carefully.</div>"; }
                          }else{
                            echo "<div class='alert alert-danger' role='alert'>Alert! Please fill all fields carefully.</div>";
                          }
                        
                  }
                ?>
              <div class="card card-border-color">
                <div class="card-body">
                  <form class="addjournal" action="" method="POST">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <label class="col-form-label">Voucher No.</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                              </div>
                              <input type="text" name="voucher_no" class="form-control" required id="voucher_nofield" placeholder="Enter Voucher No." readonly value="<?php echo $newvoucher; ?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <label class="col-form-label">Date</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text in-grp"><i class="mdi mdi-account-card-details"></i></span>
                              </div>
                              <input type="date" name="jv_date" class="form-control" required id="jv_datefield" value="<?php  echo date("Y-m-d"); ?>" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--start here-->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive pt-3 set-tbl">
                          <table class="table table-bordered myTable" id="myTable">
                            <thead>
                              <tr>
                                <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                  Action
                                </th>
                                <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                  A/C Description
                                </th>
                                <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                  Remarks
                                </th>
                                <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                  Debit
                                </th>
                                <th class="bg-grey text-dark set-th-padding text-center set-th-font">
                                  Credit
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td class='set-td-padding bg-white text-center'></td>
                                <td class='set-td-padding bg-white text-center'>
                                  <div class="form-group row">
                                    <div class="col-sm-12">
                                      <select name="chrt_acc[]" class="form-control chrt_acc" required value="">
                                        <option value="">Select Any</option>
                                        <?php 
                                          $db->where("status",'1');
                                          $AccGroupData = $db->get("account_group");
                                          foreach ($AccGroupData as $AccGroup) {
                                            $accGroupId = $AccGroup['id'];
                                            $accGroupName = $AccGroup['account_group_name'];
                                        ?>
                                        <optgroup label="<?php echo $accGroupName; ?>">
                                          <?php 
                                            $db->where("acc_group",$accGroupId);
                                            $db->where("status",'1');
                                            $chartAccData = $db->get("chart_accounts");

                                            foreach ($chartAccData as $chartAcc) {
                                              $ChartID = $chartAcc['chrt_id'];
                                              $ChartName = $chartAcc['account_name'];
                                          ?>
                                          <option value="<?php echo $ChartID; ?>"><?php echo $ChartName; ?></option>
                                        <?php } ?>
                                        </optgroup>
                                      <?php } ?>
                                      </select>
                                    </div>
                                  </div>
                                </td>
                                <td class='set-td-padding bg-white text-center'>
                                  <div class="form-group row">
                                    <div class="col-sm-12">
                                      <input type="text" name="remarks[]" class="form-control remarks" value="" placeholder="Write Remarks"/>
                                    </div>
                                  </div>
                                </td>
                                <td class='set-td-padding bg-white text-center'>
                                  <div class="form-group row">
                                    <div class="col-sm-12">
                                      <input type="text" name="debit[]" class="form-control debit" value="0" Placeholder="Enter Debit"/>
                                    </div>
                                  </div>
                                </td>
                                <td class='set-td-padding bg-white text-center'>
                                  <div class="form-group row">
                                    <div class="col-sm-12">
                                      <input type="text" name="credit[]" class="form-control credit" value="0" Placeholder="Enter Credit"/>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="grand-total">
                                <td class='set-td-padding bg-white text-center'><a onclick="addmore()" class="badge badge-success" href="#"><i class="mdi mdi-plus"></i></a></td>
                                <td class='set-td-padding bg-white text-center' colspan="2">
                                  <div class="form-group row">
                                    <div class="col-sm-12">
                                      <h5>Total</h5>
                                  </div>
                                </td>
                                <td class='set-td-padding bg-white text-center'>
                                  <div class="form-group row">
                                    <div class="col-sm-12">
                                      <input type="text" name="total_debit" class="form-control total_debit" value="0" Placeholder="Total Debit" readonly=""/>
                                    </div>
                                  </div>
                                </td>
                                <td class='set-td-padding bg-white text-center'>
                                  <div class="form-group row">
                                    <div class="col-sm-12">
                                      <input type="text" name="total_credit" class="form-control total_credit" value="0" Placeholder="Total Credit" readonly=""/>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <!--end here-->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="btn-right" style="margin-top: 5px;">
                          <button type="submit" name="add-journal" class="btn btn-success btn-set btn-save-color" title="click here to save data"><i class="mdi mdi-content-save">Save</i></button>
                          <button class="btn btn-light btn-set" title="Click here to clear all fileds"><i class="mdi mdi-close-circle">Cancel</i></button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php  }else{ echo "<h5 class='text-danger'>You are not allowed to use this feature, Contact main admin.</h5>";} ?>
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
    <?php include '../../libraries/add_journal_js.php'; ?>
    
  </body>
  <script>
    $("#success-alert").fadeTo(5000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    $("#success-alert").hide();
    });
    $(".alert-danger").fadeTo(5000, 500).slideUp(500, function(){
    $(".alert-danger").slideUp(500);
    $(".alert-danger").hide();
    });
    
    var total_credit = 0;
    var total_debit = 0;
    $(document).ready(function(){

      $(".debit").keyup(function(){

            var sum_debit = 0;
            var sum_credit = 0;

            $(".debit").each(function(){
                sum_debit += +$(this).val();
            });

            $(".total_debit").val(sum_debit);

            $(".credit").each(function(){
                sum_credit += +$(this).val();
            });

            $(".total_credit").val(sum_credit);

            // var totalDebit = $(".total_debit").val();

            if(sum_debit == sum_credit){

              $(".total_credit").css("background", "#00b20094");
              $(".total_debit").css("background", "#00b20094");

            }else{
              $(".total_debit").css("background", "#ff5454");
              $(".total_credit").css("background", "#ff5454");
            }

      });

      $(".credit").keyup(function(){

            var sum_debit = 0;
            var sum_credit = 0;

            $(".debit").each(function(){
                sum_debit += +$(this).val();
            });

            $(".total_debit").val(sum_debit);

            $(".credit").each(function(){
                sum_credit += +$(this).val();
            });

            $(".total_credit").val(sum_credit);

            // var totalDebit = $(".total_debit").val();

            if(sum_debit == sum_credit){

              $(".total_credit").css("background", "#00b20094");
              $(".total_debit").css("background", "#00b20094");

            }else{
              $(".total_debit").css("background", "#ff5454");
              $(".total_credit").css("background", "#ff5454");
            }
          
      });

    });
</script>
</html>