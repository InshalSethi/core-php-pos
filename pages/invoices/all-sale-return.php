<?php 

  include '../../include/functions.php';

  include '../../include/MysqliDb.php';

  include '../../include/config.php';

  include '../../include/permission.php';



$page_title='Inventory | All Sale Return  ';



if (isset($_REQUEST['del_id'])  ) {



  $del_id=$_REQUEST['del_id'];



  $cols=array("pkg_meta_item","pro_id","pro_qty");

  $db->where('inv_id',$del_id);

  $items=$db->get('tbl_salereturn_detail',null,$cols);

  foreach($items as  $it){



    SalaReturnDelete($it['pro_id'],$it['pro_qty'],$db);

    $db->where('pkg_meta_item',$it['pkg_meta_item']);

    $db->delete('tbl_salereturn_detail');

  }



  DeleteSaleReturn($del_id,$db);



  $db->where('inv_id',$del_id);

  $db->delete('tbl_salereturn_invoice');





  header("LOCATION:all-sale-return.php");

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

      .bdg-tbl{

        margin-top: 9px;

      }

      .th-set{

        padding: 3px!important;

      }

      table.dataTable td{

        padding: 1px!important;

        font-size: 14px!important;

        text-align: center !important;

      }

      .table td, .jsgrid .jsgrid-table td{

        font-size: 0.875rem;

        line-height: 2.2rem!important;

        padding: 0px 26px!important;

      }

      .mr-l{

          margin-left:10px;

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

                <h3 class="modal-title" id="exampleModalLabel">Sale Return Detail</h3>

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





        <div class="modal fade" id="deliveryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">

        <div class="modal-dialog" role="document">

          <div class="modal-content">

            <div class="modal-header">

              <h5 class="modal-title" id="exampleModalLabel-2">Package Delivery</h5>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                <span aria-hidden="true">&times;</span>

              </button>

            </div>

            <div class="modal-body" id="modal-body-del" >

              <div class="row">

                <div class="col-md-12">

                  <div class="form-group">

                    <label>Date</label>

                    <input type="date" class="form-control" id="del_date">

                    <input type="hidden" class="form-control" id="hide_pac_id">

                  </div>

                </div>

              </div>    

            </div>

            <div class="modal-footer">

              <button onclick="PackageDelivery()" type="button" class="btn btn-success">Submit</button>

              <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>

            </div>

          </div>

        </div>

      </div>

                  







         <!-- partial -->

      <div class="main-panel" style="width: 100%;">

        <?php 
        

        $sale_return_view=CheckPermission($permissions,'sale_return_view');
        if($sale_return_view ==1){ ?>

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

                  <div class="col-lg-4">

                        <div class="row">

                            <div class="col-md-9">

                                <h4 class="card-title">All Sale Return</h4>

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

                                    

                                    <button class="btn btn-primary btn-saerch" onclick="PrintSaleBook()" title="click to Print Sale Book">Print</button>

                                </div>

                            </div>

                      </div>

                  </div>

              

              </div>

              <div class="row">

                <div class="col-12">

                  <div class="table-responsive">

                    <table id="sale-return-tbl" class="table">

                      <thead>

                        <tr>

                          <th class="th-set text-center">No.</th>

                          <th class="th-set text-center" >Name</th>

                          <th class="th-set text-center" >Date</th>

                          <th class="th-set text-center" >Total</th>

                          <th class="th-set text-center" >Actions</th>

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



    $('#sale-return-tbl').DataTable({



      'processing': true,

      'serverSide': true,

      'serverMethod': 'post',

      "bFilter": true,

      'pageLength':50,

      'ajax': {

          'url':'../ajax/ajax-datatable.php', 

          'data':{

                      'action':'sale_return_table'

                  }        

      },

      'columns': [

        { data: 'serial_no' },

        { data: 'name' },

        { data: 'date' },

        { data: 'total' },

        { data: 'action' },

      ],



      rowCallback: function (row, data) {

        

      },

      initComplete: function( settings, json ) {

        $("#grand-total").text(json.grand_total);

      }



    });







    



    



    function ShowSaleReturn(invoice_id){

     // AJAX request

      $.ajax({

        url: '../ajax/ajax-show-detail.php',

        datatype: 'html',

        type: 'post',

        data: {in_id: invoice_id,action:'show_sale_return'},

        success: function(html){ 

          $('#modal-body').html(html);

          $('#invoice_detailModal').modal('show'); 

        }

      });   

    }

  



    $( "#btn_search" ).click(function () {

      

    var date_from_s = $('.date_from').val();

    var date_to_s = $('.date_to').val();



    if(date_from_s !='' && date_to_s != '') {



      // Reset the Data Table

      var table = $('#sale-return-tbl').DataTable();

      table.destroy();



      $('#sale-return-tbl').DataTable({



        'processing': true,

        'serverSide': true,

        'serverMethod': 'post',

        "bFilter": true,

        'pageLength':50,

        'ajax': {

            'url':'../ajax/ajax-datatable.php', 

            'data':{

                    'action':'sale_return_table',

                    'from_date':date_from_s,

                    'to_date':date_to_s

                  }        

        },

        'columns': [

          { data: 'serial_no' },

          { data: 'name' },

          { data: 'date' },

          { data: 'total' },

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



    function PrintSaleBook(){



      var date_from_s = $('.date_from').val();

      var date_to_s = $('.date_to').val();





      var link = '<?php echo baseurl('pages/sale-return-print.php');?>?from='+date_from_s+'&to='+date_to_s+'';

      window.open(link,'_blank');



    }

  </script>

  </body>

</html>