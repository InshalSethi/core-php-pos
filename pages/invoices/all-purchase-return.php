<?php 

  include '../../include/functions.php';

  include '../../include/MysqliDb.php';

  include '../../include/config.php';

  include '../../include/permission.php';




$page_title='Inventory | Purchase Return';



if (isset($_REQUEST['del_id'])) {



    $pur_id=$_REQUEST['del_id'];



    $cols=array("meta_pro_id","pro_id","return_qty");

    $db->where("pur_re_id",$pur_id);

    $del_items=$db->get("tbl_purchase_return_detail",null,$cols);

    

    foreach($del_items as $item){

      AddStockQty($item['pro_id'],$item['return_qty'],$db);

      $db->where('meta_pro_id',$item['meta_pro_id']);

      $db->delete('tbl_purchase_return_detail');

    }



    DeletePurchaseReturn($pur_id,$db);

    

    $db->where("pur_re_id",$pur_id);

    $db->delete("tbl_purchase_return");



    header("LOCATION:all-purchase-return.php");



}



?>

<!DOCTYPE html>

<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Required meta tags -->

    

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $page_title; ?></title>

    <?php include '../../include/auth.php'; ?>

    <?php include '../../libraries/libs.php'; ?>

    <style>

      .th-set{

        padding: 3px!important;

      }

      table.dataTable td{

        padding: 1px!important;

        font-size: 14px!important;

        text-align: center !important;

      }

      .btn-saerch{

          padding-top:8px;

          padding-bottom:8px;

      }

      .btn-outline-danger{

          padding:5px;

      }

      .btn-outline-primary{

          padding:5px;

      }

      /*Loader*/

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

       .dataTables_wrapper .dataTable thead th{

        width: 4%!important;

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

                <h3 class="modal-title" id="exampleModalLabel">Purchase Return Detail</h3>

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
        

        $purchase_return_view=CheckPermission($permissions,'purchase_return_view');
        if($purchase_return_view ==1){ ?>

        <div class="content-wrapper">

          <div class="card">

            <div class="card-body">

              <div class="row" style="margin: 11px 0px;">

                <div class="col-md-5">

                  

                </div>

                <div class="col-md-2">

                  <h6>Grand Total <span id="grand-total" class="text-danger"></span></h6>

                </div>

                

               

                

              </div>

              <div class="row">

                  <div class="col-lg-5">

                        <div class="row">

                            <div class="col-md-9">

                                <h4 class="card-title">Purchase Return</h4>

                            </div>

                            <div class="col-md-3">

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

                        </div>

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

                                <div class="col-md-2">

                                    <button class="btn btn-primary search_filter btn-saerch" onclick="PrintPurchaseReturn()"  title="Click here to Print">Print</button>

                                </div>

                            </div>

                      </div>

                  </div>

              

                </div>

              <div class="row">

                <div class="col-12">

                  

                  <div class="table-responsive">

                    <table id="purchase-return-tbl" class="table">

                      <thead>

                        <tr>

                            <th class="th-set text-center" class="th-set text-center">No.</th>

                            <th class="th-set text-center">Invoice No.</th>

                            <th class="th-set text-center">Supplier Name</th>

                            <th class="th-set text-center">Invoice Date</th>

                            <th class="th-set text-center">Total Amount</th>  

                            <th class="th-set text-center">Actions</th>

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

  <script src="<?php echo base_url('js/data-table.js'); ?>"></script>



  <script>



     $('#purchase-return-tbl').DataTable({



      'processing': true,

      'serverSide': true,

      'serverMethod': 'post',

      "bFilter": true,

      'pageLength':50,

      'ajax': {

          'url':'../ajax/ajax-datatable.php', 

          'data':{

                      'action':'purchase_return_table'

                  }        

      },

      'columns': [

        { data: 'serial_no' },

        { data: 'invoice_no' },

        { data: 'sup_name' },

        { data: 'inv_date' },

        { data: 'total_amount' },

        { data: 'action' }

      ],



      rowCallback: function (row, data) {

        

      },

      initComplete: function( settings, json ) {

        $("#grand-total").text(json.grand_total);

       

      }



    });





    function ShowPurchaseReturn(invoice_id){

     // AJAX request

    $.ajax({

        url: '../ajax/ajax-show-detail.php',

        datatype: 'html',

        type: 'post',

        data: {in_id: invoice_id,action:'show_purchase_return'},

        success: function(html){ 



          $('#modal-body').html(html);

          $('#invoice_detailModal').modal('show'); 



        }

        

      });  

    }



    function PrintPurchaseReturn() {



      var date_from_p = $('.date_from').val();

      var date_to_p = $('.date_to').val();

      var link = '<?php echo base_url('pages/purchase-return-print.php');?>?from='+date_from_p+'&to='+date_to_p+'';

      window.open(link,'_blank');

    }

  

    $( "#btn_search" ).click(function () {

      

    var date_from_p = $('.date_from').val();

    var date_to_p = $('.date_to').val();

    

    if(date_from_p !='' && date_to_p != '') {



      // Reset the Data Table

      var table = $('#purchase-return-tbl').DataTable();

      table.destroy();

      $('#purchase-return-tbl').DataTable({



        'processing': true,

        'serverSide': true,

        'serverMethod': 'post',

        "bFilter": true,

        'pageLength':50,

        'ajax': {

            'url':'../ajax/ajax-datatable.php', 

            'data':{

                      'action':'purchase_return_table',

                      'from_date':date_from_p,

                      'to_date':date_to_p

                    }        

        },

        'columns': [

          { data: 'serial_no' },

          { data: 'invoice_no' },

          { data: 'sup_name' },

          { data: 'inv_date' },

          { data: 'total_amount' },

          { data: 'action' }

        ],

        rowCallback: function (row, data) {

          

        },

        initComplete: function( settings, json ) {

          $("#grand-total").text(json.grand_total);

          

        }



      });

    }

    });

  </script>

  </body>

</html>