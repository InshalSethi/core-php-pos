<?php 

  include '../../include/functions.php';

  include '../../include/MysqliDb.php';

  include '../../include/config.php';

  include '../../include/permission.php';






$page_title='Inventory | All Cash Received';

if (isset($_REQUEST['del_id'])) {

  $ClientPaymentID=$_REQUEST['del_id'];

  DeleteCashReceived_Voucher($db,$ClientPaymentID);

  header("LOCATION:all-cash-received.php");

}



?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $page_title; ?></title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>

    <style>

      table.dataTable td{

            padding: 2px!important;

            font-size: 14px!important;

            text-align: center !important;

      }

      .dataTables_wrapper .dataTable thead th{

        width: 13%!important;

      }

    </style>



  </head>

  <body>

    <div class="container-scroller">

    <?php include '../../libraries/nav.php'; ?>

      <div class="container-fluid page-body-wrapper">

        <?php include '../../libraries/sidebar.php'; ?>



        <div class="modal fade" id="invoice_detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

          <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h3 class="modal-title" id="exampleModalLabel">Cash Received Detail</h3>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body" id="modal-body" >

                

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>



        



         <!-- partial -->

      <div class="main-panel" style="width: 100%;">

        <?php 
        

        $cash_received_view=CheckPermission($permissions,'cash_received_view');
        if($cash_received_view ==1){ ?>

        <div class="content-wrapper">

          <div class="card">

            

            <div class="card-body">

              <div class="row" style="margin: 11px 0px;">

                <div class="col-md-4">

                  

                </div>

                <div class="col-md-2">

                  <h6>Grand Total <span id="grand-total" class="text-danger"></span></h6>

                </div>

              </div>

              <div class="row">

                <div class="col-lg-6">

                  <h4 class="card-title">All Cash Received Vouchers</h4>

                  

                </div>

                <div class="col-lg-6">

                      <div class="form-sample" id="date_filter">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group row">

                                        <div class="col-sm-12">

                                            <input type="date" name="date_from" class="form-control date_from inp-pad">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="form-group row">

                                        <div class="col-sm-12">

                                            <input type="date" name="date_to" class="form-control date_to inp-pad">

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-2">

                                    <button class="btn btn-success search_filter btn-saerch" id="btn_search" title="click here to search">Search</button> 

                                </div>

                                

                            </div>

                      </div>

                </div>


                <div class="col-md-4">
                  <a href="<?php echo baseurl('pages/vouchers/cash-received.php');?>" class="btn btn-dark">Add  Cash Received</a>
                </div>

                

              </div>

              

              <div class="row">

                

                <div class="col-12">

                  

                  <div class="table-responsive">

                    <table id="cash-rece-table" class="table table-striped">

                      <thead>

                        <tr>

                            <th> NO #</th>

                            <th>Client Name</th>

                            <th>Date</th>

                            <th>Note</th>

                            <th>Total Amount</th>

                            <th>Actions</th>

                        </tr>

                      </thead>

                      <tbody>

                      </tbody>

                    </table>

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

        <!-- partial:../../partials/_footer.html -->

        <?php include '../../libraries/footer.php'; ?>

        <!-- partial -->

      </div>

      <!-- main-panel ends -->

      

        



        



      </div>

      <!-- page-body-wrapper ends -->

    </div>

    <!-- container-scroller -->

  <?php include '../../libraries/js_libs.php'; ?>

  

  <script>



    $('#cash-rece-table').DataTable({



      'processing': true,

      'serverSide': true,

      'serverMethod': 'post',

      "bFilter": false,

      'pageLength':50,

      'ajax': {

          'url':'../ajax/ajax-datatable.php', 

          'data':{

                      'action':'cash_received_table'

                  }        

      },

      'columns': [

        { data: 'voc_num' },

        { data: 'party_name' },

        { data: 'date' },

        { data: 'note' },

        { data: 'total_amount' },

        { data: 'action' },

      ],



      rowCallback: function (row, data) {

        

      },

      initComplete: function( settings, json ) {

        $("#grand-total").text(json.grand_total);

       

      }

    });





    $( "#btn_search" ).click(function () {

      var date_from_s = $('.date_from').val();

      var date_to_s = $('.date_to').val();



      if(date_from_s !='' && date_to_s != '') {

        // Reset the Data Table

        var table = $('#cash-rece-table').DataTable();

        table.destroy();



      $('#cash-rece-table').DataTable({



      'processing': true,

      'serverSide': true,

      'serverMethod': 'post',

      "bFilter": false,

      'pageLength':50,

      'ajax': {

          'url':'../ajax/ajax-datatable.php', 

          'data':{

                      'action':'cash_received_table',

                      'from_date':date_from_s,

                      'to_date':date_to_s

                  }        

      },

      'columns': [

        { data: 'voc_num' },

        { data: 'party_name' },

        { data: 'date' },

        { data: 'note' },

        { data: 'total_amount' },

        { data: 'action' },

      ],



      rowCallback: function (row, data) {

        

      },

      initComplete: function( settings, json ) {

        $("#grand-total").text(json.grand_total);

       

      }

    });

        



      }





    });









    function ShowCashReceivedVoucher(voc_id){

    

      $.ajax({

        url: '../ajax/ajax-show-detail.php',

        datatype: 'html',

        type: 'post',

        data: {voc_id: voc_id,action:'show_cash_received_voucher'},

        success: function(html){ 



        $('#modal-body').html(html);

        $('#invoice_detailModal').modal('show'); 



        }

      });

       

    }



    function DeleteProduct(del_id){

      var r= confirm("Are you sure to delete the product?");

      if (r == true) {

        if ( del_id != '' ) {

          window.location.href='all-products.php?pid='+del_id;

        }

      }

    }

  </script>



  </body>

</html>