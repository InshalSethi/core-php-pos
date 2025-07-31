<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';


    if (isset($_REQUEST['id'])) {
    $transfer_id = $_REQUEST['id'];
    if ( $transfer_id != '') {
        
    $db->where('id',$transfer_id);
    $transfers = $db->getOne("transfers");
    
    $from_account_id = $transfers['from_account'];
    $to_account_id = $transfers['to_account'];
    $amount = $transfers['amount'];
    $date = $transfers['date'];
    $description = $transfers['description'];
    $reference = $transfers['reference'];
    
    //From Account Data
    $db->where("id","$from_account_id");
    $fr_account = $db->getOne("account");
    $pre_fr_acc_balance = $fr_account['balance'];
    $pre_fr_account_number = $fr_account['account_number'];
    
    // To Account Data
    $db->where("id","$to_account_id");
    $to_account = $db->getOne("account");
    $pre_to_acc_balance = $to_account['balance'];
    $pre_to_account_number = $to_account['account_number'];
    
    //Add amount into selected account (from)
    
    $fr_acc_bal = $pre_fr_acc_balance + $amount;
                
    $up_acc_from_ol = array("balance"=>$fr_acc_bal);
    $db->where("id",$from_account_id);
    $db->update("account",$up_acc_from_ol);

    //Fetch Data from Journal_table to get J_Id for Journal_meta table

    $db->where("transfer_id",$transfer_id);
    $JvOldDataCli = $db->getOne("journal_tbl");
    $JIdCli = $JvOldDataCli['j_id'];

    //Delete this entry from JV Table
    $db->where("j_id",$JIdCli);
    $db->delete('journal_meta');

    //Delete this entry from JV Table
    $db->where("transfer_id",$transfer_id);
    $db->where("j_id",$JIdCli);
    $db->delete('journal_tbl');
    
    // Deduction of amount into old selected account (To)
    
    $to_acc_bal = $pre_to_acc_balance - $amount;
                
    $up_acc_to_ol = array("balance"=>$to_acc_bal);
    $db->where("id",$to_account_id);
    $db->update("account",$up_acc_to_ol);
    
    $db->where("transfer_id",$transfer_id);
    $db->delete('transactions');

    $db->where("id",$transfer_id);
    $db->delete('transfers');
    
    ?>
<script>
  window.location.href="transfers.php";
</script>
<?php
    }      
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS | Transfers</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <?php
      $AddTransferId = 19;
      $ReadTransferId = 20;
      $UpdateTransferId = 21;
      $DeleteTransferId = 22;

      $accessAddTrans = 0;
      $accessReadTrans = 0;
      $accessUpdateTrans = 0;
      $accessDeleteTrans= 0;
      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);

     
        foreach ($UserDataAccess as $UsrPer) {
          if($UsrPer['permission_id'] == $AddTransferId){
            $accessAddTrans =1;
          }
          if($UsrPer['permission_id'] == $ReadTransferId){
            $accessReadTrans =1;
          }
          if($UsrPer['permission_id'] == $UpdateTransferId){
            $accessUpdateTrans =1;
          }
          if($UsrPer['permission_id'] == $DeleteTransferId){
            $accessDeleteTrans =1;
          }
        }  
    ?>
    <link rel="stylesheet" href="<?php echo baseurl('assets/css/vertical-layout-light/jquery-ui.css');?>">

  </head>
  <style>
  .today-hear{
      background-color:#6da252!important;
      color: white;
  }
  .td1-set{
  padding: 5px!important;
  font-size: 13px!important;
  
    }
  .inactive-alert{
      display:none; 
  }
  .ui-autocomplete{
    z-index: 9999999999!important;
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
    .set-drop{
        height: 31px;
        margin-top: 1px;
    }
    .set-card-body{
          padding-left: 10px!important;
          padding-right: 10px!important;
    }
    .set-mr-btm{
      margin-bottom: 10px;
    }
    .no-mar-btm{
      margin-bottom: 0px!important;
    }
    .clr{
      color: white!important;
    }
    .advance-search-main{
      background: #ecf0f8;
      padding: 5px;
      margin-bottom: 5px;
      border-radius: 5px;
      box-shadow: 0 2px 2px 0 rgba(92, 59, 196, 0.14), 0 3px 1px -2px rgba(92, 59, 196, 0.2), 0 1px 5px 0 rgba(92, 59, 196, 0.12);
    }
    .advance-search-row{
      margin-bottom: 5px;
    }
    .advance-lable-padding{
      padding: 0px!important;
    }
    .advance-input-padding{
      padding: 5px!important;
    }
    .advance-search-radio{
      margin-left: 25px;
      margin-top: 5px;
    }
    .no-side-padding{
      padding-left: 0px!important;
      padding-right: 0px!important;
    }
    .no-side-padding-first{
      padding-right: 0px!important;
    }
    .no-side-padding-last{
      padding-left: 0px!important;
    }
    @media only screen and (min-width: 320px) and (max-width: 480px){
      .no-side-padding{
      padding-left: 15px!important;
      padding-right: 15px!important;
    }
    .no-side-padding-first{
      padding-right: 15px!important;
      padding-left: 15px!important;
    }
    .no-side-padding-last{
      padding-right: 15px!important;
      padding-left: 15px!important;
    }
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
          <?php 
            $transfers_view=CheckPermission($permissions,'transfers_view');
            if($transfers_view == 1){ ?>
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <h4 class="card-title">Transfers</h4>
                <?php if($accessAddTrans == 1){ ?>
                <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-transfer.php'"><i class="mdi mdi-plus"></i> Add New</button>
                <?php } ?>
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
                                  <th class="th-set text-center">Date</th>
                                  <th class="th-set text-center">From Account</th>
                                  <th class="th-set text-center">To Account</th>
                                  <th class="th-set text-center">Amount</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody class="table-body">
                                  
                              <?php
                                $db->orderBy("id","Asc");
                                $transfersdata = $db->get("transfers");
                                foreach ($transfersdata as $transfers) {
                                    
                                $transfer_id = $transfers['id'];
                                $encrypt = encode($transfer_id);
                                
                                $date = $transfers['date'];
                                $from_account_id = $transfers['from_account'];
                                $to_account_id = $transfers['to_account'];
                                $amount = $transfers['amount'];
                                
                                $db->where('id',$from_account_id);
                                $from_account_data = $db->getOne("account");
                                $fr_acc_name = $from_account_data['account_number'];
                                $fr_bank_name = $from_account_data['bank_name'];
                                $fr_name = $from_account_data['name'];
                                
                                $db->where('id',$to_account_id);
                                $to_account_data = $db->getOne("account");
                                $to_acc_name = $to_account_data['account_number'];
                                $to_bank_name = $to_account_data['bank_name'];
                                $to_name = $to_account_data['name'];
                                ?>
                                
                                <tr>
                                    <td class="td1-set text-center"> <?php echo date("d-m-Y", strtotime($date));  ?></td>
                                    <td class="td1-set text-center"> <?php echo $fr_acc_name.'-'.$fr_bank_name.'-'.$fr_name;  ?></td>
                                    <td class="td1-set text-center"> <?php echo $to_acc_name.'-'.$to_bank_name.'-'.$to_name;  ?></td>
                                    <td class="td1-set text-center"> <?php echo number_format($amount);  ?></td>
                                    <td class="td1-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        <?php if($accessUpdateTrans == 1){ ?>
                                        <a class="dropdown-item" href="edit-transfer.php?tra=<?php echo $encrypt; ?>"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <?php }if($accessDeleteTrans == 1){ ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $transfer_id; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <?php } else{
        echo "<h2 class='text-danger'>You Don't have permission to use this page contact with admin. Thank You</h2>";
        } ?>
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
var r = confirm(" Are you sure you want to delete this transfer ?");
if (r == true) { 
txt = "You pressed OK!";

var stateID = clicked_id;


window.location = "transfers.php?id="+clicked_id; 

} else {


}

}
</script>
</html>