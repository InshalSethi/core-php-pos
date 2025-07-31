<?php

    include '../../include/config_new.php';

    include '../../include/functions.php';

    include '../../include/MysqliDb.php';

    include '../../include/config.php';
    include '../../include/permission.php';

    $x=$_REQUEST['cus'];

    $cus_id=decode($x);

?>

<!DOCTYPE html>

<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Required meta tags -->

    

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>POS | Customer Ledger</title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>

    <link rel="stylesheet" href="<?php echo baseurl('assets/vendors/jquery-toast-plugin/jquery.toast.min.css');?>">

<style>

  .td-remarks{

    width: 200px;

  }

    .mr-tp-s{

        margin-top:10px;

    }

    .mr-tp-i{

        margin-top:10px;

    }

    .no-pd-btm{

        padding-bottom:0px !important;

    }

    .fnt-sz{

        font-size:23px!important;

    }

  table.dataTable td{

  padding: 5px!important;

  font-size: 13px!important;

  text-align: center !important;

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

    /**/

        .inactive-cus{

            color: red;

        }

        .free-cus{

            color: blue;

        }

        .drop-set{

            margin-top: 1px;

            height: 31px;

        }

        .mr-btm{

            margin-bottom: 20px;

        }

        .brd-btm{

            border-bottom: 1px solid silver;

        }

        .fnt-h{

            font-size: 15px;

            font-weight: 500;

            color: black!important;

        }

        .fnt-c{

            font-size: 14px;

            color: #5d8fcc!important;

        }

        @media only screen and (min-width: 320px) and (max-width: 480px){

        .col4{

            padding-right: 15px!important;

        }

        .col8{

            padding-left: 15px!important;

        }

        }

        .col4{

            padding-right: 0px;

        }

        .col8{

            padding-left: 0px;

        }

        .set-card-body{

          padding-left: 5px!important;

          padding-right: 5px!important;

          padding-top: 20px!important;

          padding-bottom: 20px!important

        }

        .income-box{

          height: 100%;

          background: #00c0ef !important;

          text-align: center;

          font-size: 73px;

          color: white;

          border-radius: 5px;

        }

        .expenses-box{

          height: 100%;

          background: linear-gradient(87deg, #ef3232 0, #ff7d66 100%);

          text-align: center;

          font-size: 73px;

          color: white;

          border-radius: 5px;

        }

        .profit-box{

          height: 100%;

          background: linear-gradient(87deg, #6da252 0, #b8d3a9 100%);

          text-align: center;

          font-size: 73px;

          color: white;

          border-radius: 5px;

        }

        .customers-box{

          height: 100%;

          background: linear-gradient(87deg, #f6b200 0, #fcce5e87 100%);

          text-align: center;

          font-size: 73px;

          color: white;

          border-radius: 5px;

        }

        .employees-box{

          height: 100%;

          background: #58aaaf !important;

          text-align: center;

          font-size: 73px;

          color: white;

          border-radius: 5px;

        }

        .sm-bx-fn{

            font-size: 12px!important;

            font-weight: 500;

        }

        .sm-am-fn{

            font-size: 19px!important;

            font-weight: 500;

        }

        .pd-sd{

            padding-top: 10px;

            padding-bottom: 10px;

        }

        .pd-tp{

            padding-top: 0px!important;

        }

        .pd-bt{

            padding-bottom: 0px!important;

        }

        .th-pd{

            padding-top: 5px!important;

            padding-bottom: 5px!important;

            padding-left:3px!important;

            padding-right:3px!important;

        }

        .td-pd{

            padding-top: 3px!important;

            padding-bottom: 3px!important;

            padding-left:2px!important;

            padding-right:2px!important;

        }

        .pd-st{

            padding-bottom: 1px;

            padding-top: 1px;



        }

        .min-ht{

            min-height: 200px;

        }

        .tra-pd{

            padding:10px;

        }

        .no-mr-bt{

            margin-bottom:0px!important;

        }

        .no-sd-pad{

            padding-left: 5px!important;

            padding-right: 5px!important;

        }

        .td-date{

            width:80px;

        }

</style>



  </head>

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

                    <?php $db->where('cus_id',$cus_id);

                          $Customer=$db->getOne('tbl_customer');



                     ?>

                      <h4 class="card-title">Customer Name : <?php echo $Customer['cus_name']; ?></h4>

                  </div> 

                  <div class="col-lg-6">

                  </div>

                  <div class="col-lg-12">

                      <div class="row">

                          <div class="col-12 col-sm-6 col-md-6 col-xl-4 grid-margin stretch-card">

                              <div class="card">

                                <div class="row">

                                  <div class="col-md-4 col4">

                                    <div class="profit-box">

                                      <i class="mdi mdi-cash"></i>

                                    </div>

                                  </div>

                                  <div class="col-md-8 col8">

                                      <div class="card-body set-card-body">

                                      <h4 class="card-title sm-bx-fn">Total Amount</h4>

                                      <div class="d-flex justify-content-between">

                                        <p class="text-dark sm-am-fn" >Rs <span id="total_receiveable" ></span>   

                                           

                                        </p>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                                

                              </div>

                          </div>

                          <div class="col-12 col-sm-6 col-md-6 col-xl-4 grid-margin stretch-card">

                              <div class="card">

                                <div class="row">

                                  <div class="col-md-4 col4">

                                    <div class="customers-box">

                                      <i class="mdi mdi-near-me"></i>

                                    </div>

                                  </div>

                                  <div class="col-md-8 col8">

                                      <div class="card-body set-card-body">

                                      <h4 class="card-title sm-bx-fn">Received</h4>

                                      <div class="d-flex justify-content-between">

                                        <p class="text-dark sm-am-fn">Rs  <span id="total_received" ></span>  

                                            

                                        </p>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                                

                              </div>

                          </div>

                          <div class="col-12 col-sm-6 col-md-6 col-xl-4 grid-margin stretch-card">

                              <div class="card">

                                <div class="row">

                                  <div class="col-md-4 col4">

                                    <div class="expenses-box">

                                      <i class="mdi mdi-alert"></i>

                                    </div>

                                  </div>

                                  <div class="col-md-8 col8">

                                      <div class="card-body set-card-body">

                                      <h4 class="card-title sm-bx-fn">Balance</h4>

                                      <div class="d-flex justify-content-between">

                                        <p class="text-dark sm-am-fn">Rs  <span id="total_balance" ></span>

                                         

                                          </p>

                                      </div>

                                    </div>

                                  </div>

                                </div>

                                

                              </div>

                          </div>

                      </div>

                      <div class="row">

                          <div class="col-md-12">

                              <div class="card card-border-color mr-btm min-ht" style="width: 100%;">

                                  <div class="row">

                                      <div class="col-md-2">

                                          <h4 class="card-title tra-pd no-mr-bt fnt-sz">Ledger</h4>

                                      </div>

                                      <div class="col-md-10">

                                          <div class="mr-tp-s">

                                          <div class="form-group" style="display: inline-block;">

                                              <input type="date" name="from_date" id="from_date" class="form-control" style="padding:7px;" />

                                          </div>

                                          <div class="form-group" style="display: inline-block;">

                                              <input type="date" name="to_date" id="to_date" class="form-control" style="padding:7px;" />

                                          </div>

                                          <a class="btn btn-success btn-mac" id="search_filter" style="display: inline-block;padding:10px;margin-left: 5px;"><i class="mdi mdi-magnify"></i> Search</a>

                                          <a class="btn btn-primary btn-mac" onclick="Print()" style="display: inline-block;padding:10px;margin-left: 5px;"><i class="mdi mdi-printer"></i> Print</a>

                                          </div>

                                      </div>

                                  </div>

                                  <div class="card-body pd-tp pd-bt">

                                      <div class="table-responsive min-ht">

                                          <table id="supplier-detail-tbl" class="table table-striped" style="width:100%;">

                                            <thead>

                                              <tr>

                                                <th class="th-pd text-center">Invoice No.</th>

                                                 <th class="th-pd text-center">Invoice Type</th>

                                                <th class="th-pd text-center">Invoice Date</th>

                                                <th class="th-pd text-center">Total Amount</th>

                                                <th class="th-pd text-center">Reveived</th>

                                                

                                                <th class="th-pd text-center">Balance</th>

                                                

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

    </div>

    <!-- base:js -->

    <?php include '../../libraries/js_libs.php'; ?>

    <script src="<?php echo baseurl('assets/vendors/jquery-toast-plugin/jquery.toast.min.js'); ?>"></script>
    <script>
      var cus_id='<?php echo $cus_id ?>';
      $('#supplier-detail-tbl').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "bFilter": true,
        'pageLength':50,
        'ajax': {
            'url':'../ajax/ajax-datatable.php', 
            'data':{
                    'action':'customer_detail_table',
                    'cus_id':cus_id,
                    'date_from':'',
                    'date_to':''
                  }        
        },
        'columns': [
          { data: 'inv_no' },
          { data: 'inv_type' },
          { data: 'inv_date' },
          { data: 'total_amount' },
          { data: 'paid_amount' },
          { data: 'balance' },
        ],
        rowCallback: function (row, data) {
        },

        initComplete: function( settings, json ) {
          
          $("#total_receiveable").text(json.total_amount);
          $("#total_received").text(json.total_paid);
          $("#total_balance").text(json.total_balance);
        }

      });



      $( "#search_filter" ).click(function () {

        var date_from = $('#from_date').val();
        var date_to = $('#to_date').val();
        if(date_from != '' && date_to !='' ){

          // Reset the Data Table
          var table = $('#supplier-detail-tbl').DataTable();
          table.destroy();

          $('#supplier-detail-tbl').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          "bFilter": true,
          'pageLength':50,
          'ajax': {
              'url':'../ajax/ajax-datatable.php', 
              'data':{
                      'action':'customer_detail_table',
                      'cus_id':cus_id,
                      'date_from':date_from,
                      'date_to':date_to
                    }        
          },
          'columns': [
            { data: 'inv_no' },
            { data: 'inv_type' },
            { data: 'inv_date' },
            { data: 'total_amount' },
            { data: 'paid_amount' },
            { data: 'balance' },
          ],
          rowCallback: function (row, data) {
          },

          initComplete: function( settings, json ) {
            
            $("#total_receiveable").text(json.total_amount);
            $("#total_received").text(json.total_paid);
            $("#total_balance").text(json.total_balance);
          }

        });



        }

      });

    function Print(){

      var base_url='<?php echo base_url('pages/customers/customer-sheet.php'); ?>';
      
      var customer_id  = '<?php echo $x; ?>';

      var date_from = $('#from_date').val();
      var date_to = $('#to_date').val();

      
      if (customer_id != '') {
        var link = base_url+'?cus='+customer_id+'&date_from='+date_from+'&date_to='+date_to;
        window.open(link,'_blank');
      }
        
  
}
    </script>



  </body>




</html>