<?php

    

    include '../../include/functions.php';

    include '../../include/MysqliDb.php';

    include '../../include/config.php';

    include '../../include/permission.php';




    if (isset($_REQUEST['id'])) {

    $x=$_REQUEST['id'];

    if ( $x != '') {



    $db->where("id",$x);

    $db->delete('account');

    ?>

<script>

  window.location.href="accounts-list.php";

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

    <title>POS | Accounts</title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>


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

    .bold{

      font-weight: 600;

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
        

        $accounts_view=CheckPermission($permissions,'accounts_view');
        if($accounts_view ==1){ ?>

          <div class="content-wrapper">

            <div class="row">

              <div class="col-lg-12 set-mr-btm">

                <h4 class="card-title">Accounts</h4>

                <?php 
                  $add_supplier=CheckPermission($permissions,'add_account');
                  if($add_supplier == 1){ ?>
                   <button class="btn btn-success btn-mac" onclick="

                window.location.href='add-account.php'"><i class="mdi mdi-plus"></i> Add New</button>

                    <?php

                  }

                ?>

                

                

                

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

                                  <th class="th-set text-center">Number</th>

                                  <th class="th-set text-center">Bank</th>

                                  <th class="th-set text-center">Current Balance</th>

                                  <th class="th-set text-center">Status</th>

                                  <th class="th-set text-center">Actions</th>

                              </tr>

                            </thead>

                            <tbody class="table-body">

                                  

                              <?php

                              $ac = 1;

                              $CurrentBalance = 0;

                              $TotalBalance = 0;

                                $accountdata = $db->get("account");

                                foreach ($accountdata as $account) {

                                $account_id = $account['id'];

                                $encrypt = encode($account_id);

                                $account_name = $account['name'];

                                $account_number = $account['account_number'];

                                $bank_name = $account['bank_name'];

                                $account_balance = $account['balance'];

                                $Opening_balance = $account['opening_balance'];

                                

                                $account_status = $account['status'];



                                ///////////////////

    $cols=array("acc.account_number","trs.category","trs.amount",);



    $db->where("acc.id", $account_id);



    $db->join("account acc", "trs.account=acc.id", "INNER");



    $transfersdata = $db->get("transactions trs",null,$cols);

    $Balance = 0;

    foreach($transfersdata as $transfers){

          if($transfers['category'] == 'sale invoice'){

                // $receipt = 'Income';

                $receipt = $transfers['amount'];

                $Balance += $receipt;

            }else{

                $receipt = '';

            }



            if($transfers['category'] == 'receipt voucher'){

                // $receipt = 'Income';

                $receipt = $transfers['amount'];

                $Balance += $receipt;

            }else{

                $receipt = '';

            }



            if($transfers['category'] == 'payment voucher'){

                $payments = $transfers['amount'];

                $Balance -= $payments;

            }else{

                $payments = '';

            }



            if($transfers['category'] == 'Expense'){

                // $payments = 'Expense';

                $payments = $transfers['amount'];

                $Balance -= $payments;

            }else{

                $payments = '';

            }



            if($transfers['category'] == 'purchase invoice'){

                // $payments = 'Expense';

                $payments = $transfers['amount'];

                $Balance -= $payments;

            }else{

                $payments = '';

            }



            if($transfers['category'] == 'Funds Transfer From'){

              

                $transferAmountFrom = $transfers['amount'];

                $Balance -= $transferAmountFrom;

            }else{

                $transferAmountFrom = '';

            }



            if ($transfers['category'] == 'Funds Transfer To') {



                $transferAmount = $transfers['amount'];

                $Balance += $transferAmount;

            }else{

                $transferAmount = '';

            }

        }    $CurrentBalance = $Balance + $Opening_balance;

    $TotalBalance += $CurrentBalance;

                                ///////////////////

                                ?>

                                

                                <tr>

                                    <td class="td1-set text-center"> <?php echo $ac;  ?></td>

                                    <td class="td1-set text-center"> <?php echo $account_name;  ?></td>

                                    <td class="td1-set text-center"> <?php echo $account_number;  ?></td>

                                    <td class="td1-set text-center"> <?php echo $bank_name;  ?></td>

                                    <td class="td1-set text-center"> <?php echo number_format($CurrentBalance);  ?></td>

                                    <td class="td1-set text-center">

                                       <?php if ($account_status=='1') { ?>

                                    <button type="button" class="mac-badge">Active</button>

                                    <?php }elseif($account_status=='0'){ ?>

                                    <button type="button" class="mac-badge-inactive">Inactive</button>

                                    <?php } ?>

                                    </td>

                                    <td class="td1-set text-center">

                                    <div class="dropdown">

                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                      </button>

                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">

                                        

                                        <a class="dropdown-item" onclick="viewmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#viewModal"><i class="mdi mdi-eye text-dark"></i>View</a>

                                        
                                        <?php 
                                        $accounts_update=CheckPermission($permissions,'accounts_update');
                                        if($accounts_update == 1){ ?>
                                        <a class="dropdown-item" onclick="editmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#exampleModal"><i class="mdi mdi-pencil text-dark"></i>Edit</a>

                                        <?php } ?>

                                        <?php 
                                        $accounts_delete=CheckPermission($permissions,'accounts_delete');
                                        if($accounts_delete == 1){ ?>
                                       <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" onclick="myFunction('<?php echo $account_id; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>

                                        <?php } ?>
                                        

                                        
                                        

                                      </div>

                                      

                                    </div>

                                  </td>

                              </tr>

                              <?php $ac++; } ?>

                              

                            </tbody>

                          </table>

                          

                        </div>

                        <div class="table-responsive">

                          <table class="table table-striped">

                            <thead>

                              <tr>

                                <th></th>

                                <th></th>

                                <th></th>

                                <th></th>

                                <th></th>

                                <th></th>

                              </tr>

                            </thead>

                            <tbody class="table-body"> 

                              <tr>

                                <td class="td1-set text-center bold" colspan="4">Total</td>

                                <td class="td1-set text-center bold" ><?php echo number_format($TotalBalance); ?></td>

                                <td class="td1-set text-center" colspan="2"></td>

                              </tr>

                            </tbody>

                          </table>

                        </div>

                      </div>

                    </div>

                  </div>

                </div>

                <!--Edit-->

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                  <div class="modal-dialog modal-lg" role="document">

                    <div class="modal-content">

                      <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel">Edit Account</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                          <span aria-hidden="true">&times;</span>

                        </button>

                      </div>

                      <div class="modal-body">

                        <div class="edit-account">

                          

                        </div>

                      </div>

                    </div>

                  </div>

                </div>

                <!-- View -->

                <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">

                  <div class="modal-dialog modal-lg" role="document">

                    <div class="modal-content">

                      <div class="modal-header">

                        <h5 class="modal-title" id="viewModalLabel">View Account</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                          <span aria-hidden="true">&times;</span>

                        </button>

                      </div>

                      <div class="modal-body">

                        <div class="view-account">

                          

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

var r = confirm(" Are you sure you want to delete this account ?");

if (r == true) { 

txt = "You pressed OK!";



var stateID = clicked_id;





window.location = "accounts-list.php?id="+clicked_id; 



} else {





}



}

///////view

function viewmodal(id){

  $.ajax({

  type: "POST",

  url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',

  data: {account_id_view:id,action:'view_account_modal',authkey:'dabdsjjI81sa'},

  cache: false,

  success: function(viewresult){

  $('.view-account').html(viewresult);

  

  }

  });

}

//////////edit

function editmodal(id){

  $.ajax({

  type: "POST",

  url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',

  data: {account_id_edit:id,action:'edit_account_modal',authkey:'dabdsjjI81sa'},

  cache: false,

  success: function(result){

  $('.edit-account').html(result);

  

  }

  });

}

function edit_account(){

  $("#editaccountform").submit(function(){

    var accountidfield = $(".accountidfield").val();

    var accountnamefield = $(".accountnamefield").val();

    var accountnumberfield = $(".accountnumberfield").val();

    var accountbalancefield = $(".accountbalancefield").val();

    var bank_addressfield = $(".bank_addressfield").val();

    var bank_namefield = $(".bank_namefield").val();

    var bank_phonefield = $(".bank_phonefield").val();

    var chrt_accfield = $(".chrt_accfield").val();

    var statusfield = $("#statusfield").val();

    if ($('#statusfield').is(':checked')) {statusfield = '1'}else{statusfield = '0'}

    var defaultyes = $("#q1").val();

    if ($('#q1').is(':checked')) {defaultyes = '1'}else{defaultyes = ''}

      //alert(defaultyes);

    var defaultno = $("#q2").val();

    if ($('#q2').is(':checked')) {defaultno = '0'}else{defaultno = ''}

    

    var ary_account= [];



    ary_account.push({



       authkey:'dabdsjjI81sa',

       actioneditaccount:'edit_form_account',

       accountidfield:accountidfield,

       accountnamefield:accountnamefield,

       accountnumberfield:accountnumberfield,

       accountbalancefield:accountbalancefield,

       bank_addressfield:bank_addressfield,

       bank_namefield:bank_namefield,

       bank_phonefield:bank_phonefield,

       chrt_accfield:chrt_accfield,

       statusfield:statusfield,

       defaultyes:defaultyes,

       defaultno:defaultno

    





  });

    // AJAX Code To Submit Form.

    $.ajax({

    type: "POST",

    url: "../../libraries/ajaxsubmit.php",

    data: {account_edit_data:ary_account},

    cache: false,

    success: function(result){

    $(".account-success").html("<div class='alert alert-success' id='success' role='alert'>Account Data Updated Successfully .</div>");

    $("#success").fadeTo(2500, 500).slideUp(500, function(){

    $("#success").slideUp(500);

    $("#success").remove();

    });

    }

    });

  return false;



  });

  }

</script>

</html>