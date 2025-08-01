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

    <title>POS | Transactions</title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>

    <?php

      $ReadTransactionId = 23;



      $accessReadTran = 0;

      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);



     

        foreach ($UserDataAccess as $UsrPer) {

          if($UsrPer['permission_id'] == $ReadTransactionId){

            $accessReadTran =1;

          }

        }  

    ?>

    <link rel="stylesheet" href="<?php echo baseurl('assets/css/vertical-layout-light/jquery-ui.css');?>">



  </head>

<style>

  .bal{

    font-weight: 600;

  }

  table.dataTable td{

    padding: 5px!important;

    font-size: 13px!important;

    text-align: center !important;

  }

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

          <div class="content-wrapper">

            <?php 
            $transaction_view=CheckPermission($permissions,'transaction_view');
            if($transaction_view == 1){ ?>

            <div class="row">

              <div class="col-lg-12 set-mr-btm">

                <h4 class="card-title">Transactions</h4>

                <a class="btn btn-success btn-mac" id="transaction-filter"><i class="mdi mdi-magnify"></i> Search</a>
                <a class="btn btn-success btn-mac" onclick="PrintSheet()"><i class="mdi mdi-printer"></i> Print</a>

              </div> 

              <div class="col-lg-12">

                <div class="card card-border-color">

                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-12">

                        <div class="advance-search-main">

                          <form>

                            <div class="row advance-search-row">

                              <div class="col-md-2 no-side-padding-first">

                                  <div class="form-group row no-mar-btm">

                                    <div class="col-sm-12">

                                      <label class="col-form-label advance-lable-padding no-mar-btm">Date From</label>

                                      <div class="input-group">

                                          <input type="date" id="date_from_adsr" name="date_from_adsr" class="form-control advance-input-padding" placeholder=""/>

                                      </div>

                                    </div>

                                  </div>

                              </div>

                              <div class="col-md-2 no-side-padding">

                                  <div class="form-group row no-mar-btm">

                                    <div class="col-sm-12">

                                      <label class="col-form-label advance-lable-padding no-mar-btm">Date to</label>

                                      <div class="input-group">

                                          <input type="date" id="date_to_adsr" name="date_to_adsr" class="form-control advance-input-padding" placeholder=""/>

                                      </div>

                                    </div>

                                  </div>

                              </div>

                              <div class="col-md-2 no-side-padding-first">

                                  <div class="form-group row no-mar-btm">

                                    <div class="col-sm-12">

                                      <label class="col-form-label advance-lable-padding no-mar-btm">Account</label>

                                      <div class="input-group">

                                          <select class="form-control set-drop" id="paid_from_adsr">

                                              <option value="">Paid From</option>

                                              <?php 

                                                $account_data = $db->get('account');

                                                foreach ($account_data as $ac_data) {

                                                    

                                                  $account_id = $ac_data['id'];

                                                  $acc_account_name = $ac_data['name'];

                                                  $acc_bank = $ac_data['bank_name'];

                                                  $acc_account_number = $ac_data['account_number'];

                                                  $acc_balance = $ac_data['balance'];

                                                  $Opening_balance = $ac_data['opening_balance'];





                                                  $cols=array("acc.account_number","trs.category","trs.amount",);



                                                  $db->where("acc.id", $account_id);



                                                  $db->join("account acc", "trs.account=acc.id", "INNER");



                                                  $transfersdata = $db->get("transactions trs",null,$cols);

                                                  $Balance = 0;

                                                  foreach($transfersdata as $transfers){



                                                    if($transfers['category'] == 'sale invoice'){

                                                          // $receipt = 'Income';

                                                          $receipt = (float)$transfers['amount'];

                                                          $Balance += $receipt;

                                                      }else{

                                                          $receipt = '';

                                                      }



                                                      if($transfers['category'] == 'receipt voucher'){

                                                          // $receipt = 'Income';

                                                          $receipt = (float)$transfers['amount'];

                                                          $Balance += $receipt;

                                                      }else{

                                                          $receipt = '';

                                                      }



                                                      if($transfers['category'] == 'payment voucher'){

                                                          $payments = (float)$transfers['amount'];

                                                          $Balance -= $payments;

                                                      }else{

                                                          $payments = '';

                                                      }



                                                      if($transfers['category'] == 'Expense'){

                                                          // $payments = 'Expense';

                                                          $payments = (float)$transfers['amount'];

                                                          $Balance -= $payments;

                                                      }else{

                                                          $payments = '';

                                                      }



                                                      if($transfers['category'] == 'purchase invoice'){

                                                          // $payments = 'Expense';

                                                          $payments = (float)$transfers['amount'];

                                                          $Balance -= $payments;

                                                      }else{

                                                          $payments = '';

                                                      }



                                                      if($transfers['category'] == 'Funds Transfer From'){

                                                        

                                                          $transferAmountFrom = (float)$transfers['amount'];

                                                          $Balance -= $transferAmountFrom;

                                                      }else{

                                                          $transferAmountFrom = '';

                                                      }



                                                      if ($transfers['category'] == 'Funds Transfer To') {



                                                          $transferAmount = (float)$transfers['amount'];

                                                          $Balance += $transferAmount;

                                                      }else{

                                                          $transferAmount = '';

                                                      }



                                                      



                                                      



                                                  }

                                                  $CurrentBalance = $Balance + $Opening_balance;

                                                  

                                                 ?>

                                                 <option value="<?php echo $account_id; ?>"><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($CurrentBalance).') '; ?></option>

                                               <?php } ?>

                                              

                                          </select> 

                                      </div>

                                    </div>

                                  </div>

                              </div>

                            </div>

                          </form>

                        </div>

                      </div>

                      <div class="col-12">

                          

                        

                        <div class="table-responsive">

                          <table id="transactions-table" class="table table-striped">

                            <thead>

                              <tr>

                                  <th class="th-set text-center">Sr#</th>

                                  <th class="th-set text-center">Date</th>

                                  <th class="th-set text-center">Client</th>

                                  <th class="th-set text-center">Exp. Name</th>

                                  <th class="th-set text-center">Account</th>

                                  <th class="th-set text-center">Type</th>

                                  <th class="th-set text-center">Receipts</th>

                                  <th class="th-set text-center">Payment</th>

                                  <th class="th-set text-center">Balance</th>

                              </tr>

                            </thead>

                            <tbody class="table-body">

                                  



                                

                                

                              

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

          <?php }else{ echo "<h5 class='text-danger'>You Don't have permission to use this page contact with admin. Thank You</h5>";} ?>

          <!-- content-wrapper ends -->

          <!-- partial:partials/_footer.html -->

          <?php include '../../libraries/footer.php'; ?>

          <!-- partial -->

        </div>

        <!-- main-panel ends -->

      </div>

      <!-- page-body-wrapper ends -->

    </div>

    <?php

    $db->where('default_account','1');

    $acc=$db->getOne('account');

    // If no default account exists, get the first available account
    if (!$acc) {
        $acc = $db->getOne('account');
    }

      

     ?>

    <!-- container-scroller -->

    <!-- base:js -->

    <?php include '../../libraries/js_libs.php'; ?>

    <script>



      var acc_no='<?php echo isset($acc['id']) ? $acc['id'] : ''; ?>';

      

      $('#transactions-table').DataTable({



          'processing': true,

          'serverSide': true,

          'serverMethod': 'post',

          'pageLength':50,

          'ajax': {

              'url':'transactions-ajax.php',

              'data':{

                'account_no':acc_no

              }

              

          },
          'lengthMenu':[[50,100,150,200,500],[50,100,150,200,500]],
          'language': {
            'searchPlaceholder': 'Search...'
          },
          'columns': [
            { data: 'sr_no' },
            { data: 'date' },
            { data: 'client' },
            { data: 'exp_name' },
            { data: 'account' },
            { data: 'type' },
            { data: 'receipts' },
            { data: 'payments' },
            { data: 'balance' },
          ],
          rowCallback: function (row, data) {
          },
          fnPreDrawCallback: function( oSettings ) {
          }
        });



      //////////Search

      $("#transaction-filter").click(function(){

            var table = $('#transactions-table').DataTable();

            table.destroy();

            var paid_from = $('#paid_from_adsr option:selected').val();

            if(paid_from != ''){
              var acc_no=paid_from;
            } else{
              var acc_no='<?php echo isset($acc['id']) ? $acc['id'] : ''; ?>';
            }
            
            var date_from=$("#date_from_adsr").val();
            var date_to=$("#date_to_adsr").val();

            $('#transactions-table').DataTable({

                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'pageLength':50,
                'ajax': {
                    'url':'transactions-ajax.php',
                    'data':{
                      'account_no':acc_no,
                      'date_fr':date_from,
                      'date_to':date_to
                    }
                },
                'language': {
                  'searchPlaceholder': 'Search...'
                },
                'columns': [
                  { data: 'sr_no' },
                  { data: 'date' },
                  { data: 'client' },
                  { data: 'exp_name' },
                  { data: 'account' },
                  { data: 'type' },
                  { data: 'receipts' },
                  { data: 'payments' },
                  { data: 'balance' },
                ],

                rowCallback: function (row, data) {
                },

                fnPreDrawCallback: function( oSettings ) {

                }





              });

        

        });

      function PrintSheet(){

      var base_url='<?php echo base_url('pages/banking/transactions-sheet.php'); ?>';
      
      var account_id  = $('#paid_from_adsr').val();

      var date_from = $('#date_from_adsr').val();
      var date_to = $('#date_to_adsr').val();

      
      if (account_id != '') {
        var link = base_url+'?acc='+account_id+'&date_from='+date_from+'&date_to='+date_to;
        window.open(link,'_blank');
      } else{
        alert('Please Select The Account First!');
      }
        
  
    }

    </script>
      }

  </body>

</html>