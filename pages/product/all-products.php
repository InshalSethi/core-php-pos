<?php 

  include '../../include/functions.php';

  include '../../include/MysqliDb.php';

  include '../../include/config.php';

  include '../../include/permission.php';



if (isset($_REQUEST['pid'])) {



  $pro_id=$_REQUEST['pid'];



  

  $update=array("is_delete"=>1);

  $db->where("pro_id",$pro_id);

  $db->update('tbl_products',$update);



  header("LOCATION:all-products.php");



}



$page_title='Inventory | All Products';



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



  </head>

  <style>

    .th-set{

      padding: 3px!important;

    }

    .table td, .jsgrid .jsgrid-table td{

      font-size: 0.875rem;

      line-height: 2.2rem!important;

      padding: 0px 26px!important;

    }

    td{

      text-align: center;

    }

  </style>

  <body>

    <div class="container-scroller">

    <?php include '../../libraries/nav.php'; ?>

      <div class="container-fluid page-body-wrapper">

        <?php include '../../libraries/sidebar.php'; ?>



      <div class="modal fade" id="invoice_detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

          <div class="modal-content">

            <div class="modal-header">

              <h3 class="modal-title" id="exampleModalLabel">Product Detail</h3>

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
        $product_view=CheckPermission($permissions,'product_view');
        if($product_view ==1){ ?>

        

        <div class="content-wrapper">

          <div class="card">

            <div class="card-body">

              <div class="row" style="padding: 8px;">

                <div class="col-md-4">

                  <?php 
                  $add_product=CheckPermission($permissions,'add_product');
                  if($add_product == 1){ ?>
                    <a href="add-products.php" class="btn btn-dark">Add Product</a>

                    <?php

                  }

                  ?>

                  

                  

                </div>

                

              </div>

              <div class="row">

                <div class="col-md-4">

                  <h4 class="card-title">All Products</h4>

                </div>

                <div class="col-md-8">

                  <div class="float-right">

                    <h3>Available Stock Amount : <span id="total_expense" style="color: red;"></span></h3>

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col-md-12">

                    <div class="row">

                        <div class="col-md-3">

                            <div class="form-group row">

                                <div class="col-sm-12">

                                    <?php 
                                                $db->orderBy("dom_name",'asc');
                                    $domainData=$db->get('tbl_product_domain');

                                    

                                    ?>

                                    <select id="domain" class="form-control date_from inp-pad">

                                    <option value="">Select Domain</option>

                                    <?php 

                                    foreach($domainData as $dom){ ?>

                                    

                                    <option value="<?php echo $dom['dom_id']; ?>"><?php echo $dom['dom_name']; ?></option>

                                    <?php

                                        

                                    }

                                    ?>

                                    

                                    </select>

                                    

                                </div>

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group row">

                                <div class="col-sm-12">

                                    <?php 

                                    $db->where ("deleted_at", NULL, 'IS');
                                    $db->where ("status",'1');
                                    $db->orderBy("name",'asc');
                                    $categories = $db->get("categories"); 

                                    

                                    ?>

                                    <select id="category" class="form-control inp-pad">

                                    <option value="">Select Category</option>

                                    <?php 

                                    foreach($categories as $category){ ?>

                                    

                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>

                                    <?php

                                        

                                    }

                                    ?>

                                    

                                    </select>

                                    

                                </div>

                            </div>

                        </div>

                        <div class="col-md-3">

                            <div class="form-group row">

                                <div class="col-sm-12">

                                    <?php 

                                    $db->where ("deleted_at", NULL, 'IS');
                                    $db->where ("status",'1');
                                    $db->orderBy("name",'asc');
                                    $brands = $db->get("brands"); 

                                    

                                    ?>

                                    <select id="brand" class="form-control inp-pad">

                                    <option value="">Select Brand</option>

                                    <?php 

                                    foreach($brands as $brand){ ?>

                                    

                                    <option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>

                                    <?php

                                        

                                    }

                                    ?>

                                    

                                    </select>

                                    

                                </div>

                            </div>

                        </div>

                        

                        <div class="col-md-2">

                            <button class="btn btn-success search_filter btn-saerch btn-sm" id="btn_search" title="click here to search">Search</button>

                            

                        </div>

                        

                    </div>

                  

                </div>

                

              </div>

              <div class="row">

                <div class="col-12">

                  <div class="table-responsive">

                    <table id="product-tbl" class="table">

                      <thead>

                        <tr>

                          <th class="th-set text-center">NO #</th>

                          <th class="th-set text-center">Product Name</th>

                          <th class="th-set text-center">Category</th>

                          <th class="th-set text-center">Domain</th>

                          <th class="th-set text-center">Company</th>

                          <th class="th-set text-center">Quntity</th>

                          <th class="th-set text-center">Retail Price</th>

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

  

  <script>



    $('#product-tbl').DataTable({



      'processing': true,

      'serverSide': true,

      'serverMethod': 'post',

      "bFilter": true,

      'pageLength':50,

      'ajax': {

          'url':'../ajax/ajax-datatable.php', 

          'data':{

                      'action':'product_table'

                  }        

      },

      'columns': [

        { data: 'serial_no' },

        { data: 'product_name' },

        { data: 'category_name' },

        { data: 'met_name' },

        { data: 'company' },

        { data: 'qty' },

        { data: 'retail_price' },

        { data: 'action' }

      ],



      rowCallback: function (row, data) {},

      initComplete: function( settings, json ) {
         $("#total_expense").text(json.stock_amount);
      },

      "drawCallback": function(settings) {
        // This is called every time the table is redrawn (e.g., after searching, sorting, pagination)
        var api = this.api();
        var json = api.ajax.json();
        $("#total_expense").text(json.stock_amount);
      }

    });

    

    

    $( "#btn_search" ).click(function () {

      

    var domain_id = $('#domain').val();
    var category_id = $('#category').val();
    var brand_id = $('#brand').val();



    // if(domain_id !='' || category_id || brand_id) {



      // Reset the Data Table

      var table = $('#product-tbl').DataTable();

      table.destroy();



      $('#product-tbl').DataTable({



      'processing': true,

      'serverSide': true,

      'serverMethod': 'post',

      "bFilter": true,

      'pageLength':50,

      'ajax': {

          'url':'../ajax/ajax-datatable.php', 

          'data':{

                      'action':'product_table',

                      'domain_id':domain_id,

                      'category_id':category_id,

                      'brand_id':brand_id

                  }        

      },

      'columns': [

        { data: 'serial_no' },

        { data: 'product_name' },

        { data: 'category_name' },

        { data: 'met_name' },

        { data: 'company' },

        { data: 'qty' },

        { data: 'retail_price' },

        { data: 'action' }

      ],



      rowCallback: function (row, data) {},

      initComplete: function( settings, json ) {
         $("#total_expense").text(json.stock_amount);
      },

      "drawCallback": function(settings) {
        // This is called every time the table is redrawn (e.g., after searching, sorting, pagination)
        var api = this.api();
        var json = api.ajax.json();
        $("#total_expense").text(json.stock_amount);
    }

    });

        

    // }

  });

    function ShowProductDetail(product_id){

     // AJAX request

    $.ajax({

    url: '../ajax/ajax-show-detail.php',

    datatype: 'html',

    type: 'post',

    data: {pro_id: product_id,action:'show_product'},

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