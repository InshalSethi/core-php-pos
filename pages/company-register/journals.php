<?php

    include '../../include/config_new.php';

    include '../../include/functions.php';

    include '../../include/MysqliDb.php';

    include '../../include/config.php';

    include '../../include/permission.php';




    if (isset($_REQUEST['id'])) {

    $x=$_REQUEST['id'];

    if ( $x != '') {



    $db->where("j_id",$x);

    $db->delete('journal_meta');

    

    $db->where("j_id",$x);

    $db->delete('journal_tbl');

    ?>

<script>

  window.location.href="journals.php";

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

    <title>POS | Journal Voucher</title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>

    <?php

      $AddJournalId = 11;

      $ReadJournalId = 12;

      $UpdateJournalId = 13;

      $DeleteJournalId = 14;



      $accessAddJv = 0;

      $accessReadJv = 0;

      $accessUpdateJv = 0;

      $accessDeleteJv = 0;

      $UserDataAccess = MatchAccessPermission($db,$_SESSION['login_id']);



     

        foreach ($UserDataAccess as $UsrPer) {

          if($UsrPer['permission_id'] == $AddJournalId){

            $accessAddJv =1;

          }

          if($UsrPer['permission_id'] == $ReadJournalId){

            $accessReadJv =1;

          }

          if($UsrPer['permission_id'] == $UpdateJournalId){

            $accessUpdateJv =1;

          }

          if($UsrPer['permission_id'] == $DeleteJournalId){

            $accessDeleteJv =1;

          }

        }  

    ?>

    <link rel="stylesheet" href="<?php echo baseurl('assets/css/vertical-layout-light/jquery-ui.css');?>">



  </head>

<style>

  .td-date{

      width:80px;

  }

  .st-nam{

    width: 200px;

  }

  .td-remarks{

    width: 200px;

  }

  .td-employee{

    width: 105px;

  }

  table.dataTable td{

    padding: 5px!important;

    font-size: 13px!important;

    text-align: center !important;

    /*width: 16%;*/

  }

  .nrml{

      color:black!important;

  }

  .pd-lft{

      padding-right:1px!important;

  }

  .pd-mid{

      padding-right:1px!important;

      padding-left:1px!important;

  }

  .pd-rgt{

      padding-left:1px!important;

  }

  .free-cus{

      color:blue;

  }

  .cus-inactive{

      color:red;

  }

  .today-hear{

      background-color:#84c26491 !important;

      color: black;

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
            $journal_view=CheckPermission($permissions,'journal_view');
            if($journal_view == 1){ ?>

          <div class="content-wrapper">

            <div class="row">

              <div class="col-lg-12 set-mr-btm">

                <h4 class="card-title">Journal</h4>

                <?php if($accessAddJv == 1){ ?>

                <button class="btn btn-success btn-mac" onclick="

                window.location.href='add-journal.php'"><i class="mdi mdi-plus"></i> Add New</button>

                <?php } ?>

                <a id="journal-filters" class="btn btn-success btn-mac"><i class="mdi mdi-magnify"></i> Search</a>

                <a class="btn btn-success btn-mac" onclick="PrinJournalWindow()" title="Click here to print"><i class="mdi mdi-printer"></i> Print</a>

              </div> 

              <?php

                // $TotalDebit = 0;

                // $TotalCredit = 0;  

                // $journalData = $db->get("journal_tbl");

                // foreach ($journalData as $journal) {

                //   $journalId = $journal['j_id'];

                //   $journalDebit = $journal['total_debit'];

                //   $journalCredit = $journal['total_credit'];



                //   $TotalDebit += $journalDebit;

                //   $TotalCredit += $journalCredit;

                // }

              ?>

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

                                      <label class="col-form-label advance-lable-padding no-mar-btm"></label>

                                      <div class="input-group">

                                          <input  type="text" id="voucher_num" name="voucher_num" class="form-control" placeholder="Voucher No." />

                                      </div>

                                    </div>

                                  </div>

                              </div>

                              <div class="col-md-2 no-side-padding">

                                  <div class="form-group row no-mar-btm">

                                    <div class="col-sm-12">

                                      <label class="col-form-label advance-lable-padding no-mar-btm"></label>

                                      <div class="input-group">

                                          <select name="acc_dec" class="form-control acc_dec" id="acc_dec">

                                        <option value="">A/C Description</option>

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

                                  </div>

                              </div>

                              <div class="col-md-2 no-side-padding">

                                  <div class="form-group row no-mar-btm">

                                    <div class="col-sm-12">

                                      <label class="col-form-label advance-lable-padding no-mar-btm">Date From</label>

                                      <div class="input-group">

                                          <input type="date" id="date_from" name="date_from" class="form-control advance-input-padding" placeholder=""/>

                                      </div>

                                    </div>

                                  </div>

                              </div>

                              <div class="col-md-2 no-side-padding">

                                  <div class="form-group row no-mar-btm">

                                    <div class="col-sm-12">

                                      <label class="col-form-label advance-lable-padding no-mar-btm">Date to</label>

                                      <div class="input-group">

                                          <input type="date" id="date_to" name="date_to" class="form-control advance-input-padding" placeholder=""/>

                                      </div>

                                    </div>

                                  </div>

                              </div>

                              <div class="col-md-2 no-side-padding">

                                  <div class="form-group row no-mar-btm">

                                    <div class="col-sm-12">

                                      <label class="col-form-label advance-lable-padding no-mar-btm">Total Debit</label>

                                      <div class="input-group">

                                          <input type="text" id="debit_amount" name="debit_amount" class="form-control" placeholder="Debit Amount" readonly="" value="" />

                                      </div>

                                    </div>

                                  </div>

                              </div>

                              <div class="col-md-2 no-side-padding-last">

                                  <div class="form-group row no-mar-btm">

                                    <div class="col-sm-12">

                                      <label class="col-form-label advance-lable-padding no-mar-btm">Total Credit</label>

                                      <div class="input-group">

                                          <input type="text" id="credit_amount" name="credit_amount" class="form-control" placeholder="Credit Amount" readonly="" value=""/>

                                      </div>

                                    </div>

                                  </div>

                              </div>

                            </div>

                          </form>

                        </div>

                      </div>

                    </div>

                    <div class="row">

                      <div class="col-12">

                          

                          

                        <div class="table-responsive">

                          <table id="journal-table" class="table table-striped" style="width:100%;">

                            <thead>

                              <tr>

                                  <th class="th-set text-center">Voucher No.</th>

                                  <th class="th-set text-center">Type</th>

                                  <th class="th-set text-center">Date</th>

                                  <th class="th-set text-center">A/C Description</th>

                                  <th class="th-set text-center">Debit</th>

                                  <th class="th-set text-center">Credit</th>

                                  <th class="th-set text-center">Actions</th>

                              </tr>

                            </thead>

                            

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



      var view_per='<?php echo $accessReadJv; ?>';

      var edit_per='<?php echo $accessUpdateJv; ?>';

      var del_per='<?php echo $accessDeleteJv; ?>';

  $('#journal-table').DataTable({



    'processing': true,

    'serverSide': true,

    'serverMethod': 'post',

    'pageLength':50,

    'ajax': {

        'url':'ajax-journal.php',

        'data':{

              'view_permission':view_per,

              'edit_permission':edit_per,

              'delete_permission':del_per,

              }

               

    },

    'language': {

      'searchPlaceholder': 'Search...'

    },

    'columns': [

      { data: 'voucher_no' },

      { data: 'type' },

      { data: 'date' },

      { data: 'acc_desc' },

      { data: 'debit'},

      { data: 'credit'},

      { data: 'action'},

    ],



    rowCallback: function (row, data) {

    },

    initComplete: function( settings, json ) {

      var new_total_debit = new Intl.NumberFormat().format(json.total_debit);

      var new_total_credit = new Intl.NumberFormat().format(json.total_cedit);

      



        $("#debit_amount").val(new_total_debit);

        $("#credit_amount").val(new_total_credit);

    }

  }); 



  //Search Filter

  $("#journal-filters").click(function(){





            var table = $('#journal-table').DataTable();

            table.destroy();



            var date_from=$("#date_from").val();



            var date_to=$("#date_to").val();

            

            var voucher=$("#voucher_num").val();



            var acc_dec=$("#acc_dec").val();







            $('#journal-table').DataTable({



                'processing': true,

                'serverSide': true,

                'serverMethod': 'post',

                'pageLength':50,

                'ajax': {

                    'url':'ajax-journal.php',

                    'data':{

                      'view_permission':view_per,

                      'edit_permission':edit_per,

                      'delete_permission':del_per,

                      'voucher':voucher,

                      'acc_dec':acc_dec,

                      'date_from':date_from,

                      'date_to':date_to,



                    }

                },

                'language': {

                  'searchPlaceholder': 'Search...'

                },

                'columns': [

                  { data: 'voucher_no' },

                  { data: 'type' },

                  { data: 'date' },

                  { data: 'acc_desc' },

                  { data: 'debit'},

                  { data: 'credit'},

                  { data: 'action'},

                ],

                rowCallback: function (row, data) {

                  if (data.row_class) {

                      $(row).addClass(data.row_class);

                  }

                },

                initComplete: function( settings, json ) {





                  var new_total_debit = new Intl.NumberFormat().format(json.total_debit);

                  var new_total_credit = new Intl.NumberFormat().format(json.total_cedit);

                  



                    $("#debit_amount").val(new_total_debit);

                    $("#credit_amount").val(new_total_credit);

                }





              });





            



            

            

            

            

            

        

        

        });

  </script>

<script>

  function myFunction(clicked_id) {

      var txt;

      var r = confirm(" Are you sure you want to delete this Journal ?");

      if (r == true) { 

      txt = "You pressed OK!";



      var stateID = clicked_id;





      window.location = "journals.php?id="+clicked_id; 



      } else {





      }



  }

    //////////////////////Print JV List/////////////////////////

  function PrinJournalWindow(){



        var baseurl = '';

        var url = '';

        var date_from = '';

        var date_to = '';

        var voucher = '';

        var acc_dec = '';

        var search = '';



        search = $("input[type=search]").val();



        date_from=$("#date_from").val();



        date_to=$("#date_to").val();

            

        voucher=$("#voucher_num").val();



        acc_dec=$("#acc_dec").val();

        



        baseurl = '<?php echo baseurl('pages/company-register/journal-print.php'); ?>';

        url = baseurl + '?voucher=' + voucher + '&acc_dec=' + acc_dec + '&date_from=' + date_from + '&date_to=' + date_to + '&search=' + search;



        window.open(url,'GoogleWindow', 'width=1366, height=768');

  }

  //////////////////////////////////////////////////////////////////

  //Open New Window

  function NewWindow(url){

    window.open(url,'GoogleWindow', 'width=1366, height=768');

  }

  function printWindow(url){

    window.open(url,'GoogleWindow', 'width=1366, height=768');

  }

  //Open New Window

</script>

</html>