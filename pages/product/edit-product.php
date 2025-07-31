<?php 
include '../../include/functions.php';
include '../../include/MysqliDb.php';
include '../../include/config.php';
include '../../include/permission.php';

$page_title='Inventory | Edit Product';

$x=$_REQUEST['pro'];
$product_id=decode($x);


if ( isset($_POST['add_product']) ) {


  $current_date=date("Y-m-d");
  
  $pro_name=$_POST['pro_name'];
  $pro_name_urdu=$_POST['pro_name_urdu'];
  $pro_discription=$_POST['pro_discription'];
  $pro_code=$_POST['pro_code'];
  $pro_domain=$_POST['pro_domain'];
  
  $pro_unit=$_POST['pro_unit'];
  $pro_qty=$_POST['pro_qty'];
  $whole_sell_price=$_POST['whole_sell_price'];
  $retail_sell_price=$_POST['retail_sell_price'];
  $supplier_price=$_POST['supplier_price'];

  $rack_num=$_POST['rack_num'];
  $row_num=$_POST['row_num'];
  $reorder_num=$_POST['reorder_num'];
  $company_name=$_POST['company'];
  $unit_qty=$_POST['unit_qty'];



  $product_array=array( 
    "pro_name"=>$pro_name,
    "pro_name_urdu"=>$pro_name_urdu,
    "pro_description"=>$pro_discription,
    "pro_domain"=>$pro_domain,
    "pro_code"=>$pro_code,
    "pro_unit"=>$pro_unit,
    "pro_qty"=>$pro_qty,
    "sell_price"=>$whole_sell_price,
    "retail_price"=>$retail_sell_price,
    "company_name"=>$company_name,
    "unit_qty"=>$unit_qty,
    "supplier_price"=>$supplier_price,
    "rack_num"=>$rack_num,
    "pro_reorder"=>$reorder_num,
    "row_num"=>$row_num,
    "last_update"=>$current_date
    



  );


  $db->where('pro_id',$product_id);
  $db->update('tbl_products',$product_array);

  header("LOCATION:edit-product.php?pro=$x");









  
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

</head>
<body>
  <div class="container-scroller">
    <?php include '../../libraries/nav.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include '../../libraries/sidebar.php'; ?>
      
      
      
      
      
      <div class="main-panel" style="width: 100%;">        
        <div class="content-wrapper">
          <div class="row">

            <?php 
            $db->where('is_delete','0');
            $db->where('pro_id',$product_id);
            $product=$db->getOne('tbl_products');


            ?>
            
            
            
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Products</h4>
                  <form action=""  method="POST" class="form-sample">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Product Name <i class="text-danger">*</i></label>
                          <div class="col-sm-9">
                            <input type="text" name="pro_name" value="<?php echo $product['pro_name']; ?>" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Product Name(Urdu)</label>
                          <div class="col-sm-9">
                            <input type="text" style='height: 46px;color:black;font-size: 25px;font-weight: 600;font-family: Jameel Noori Nastaleeq, serif;' name="pro_name_urdu" class="form-control" id="txtStudentNameUrdu" value="<?php echo $product['pro_name_urdu']; ?>" dir="rtl" autocomplete="off">
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-md-6" >
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Product Code</label>
                          <div class="col-sm-9">
                            <input type="text" id="pro_code" name="pro_code" value="<?php echo $product['pro_code']; ?>" class="form-control" autocomplete="off">
                            <input id="scannerInput" class="form-control" style="display:none;" type="text"  autofocus/>
                            <a class="btn btn-danger" style="color:white; margin-top: 7px;" onclick="GenrateBarCode('barocode_get')">Get Barcode</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Description</label>
                          <div class="col-sm-9">
                            <textarea type="text" name="pro_discription" rows="6" class="form-control"><?php echo $product['pro_description']; ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Product Domain <i class="text-danger">*</i></label>
                          <div class="col-sm-9">
                            <select name="pro_domain" class="form-control">
                              <option value="" >Select Domain</option>
                              <?php
                              $sup_Data=$db->get('tbl_product_domain');
                              foreach($sup_Data as $s_da){ ?>

                                <option value="<?php echo $s_da['dom_id']; ?>" <?php if( $s_da['dom_id'] == $product['pro_domain'] ) { echo "selected"; } ?> ><?php echo $s_da['dom_name']; ?></option>


                                <?php

                              }

                              ?>
                              
                              
                            </select>
                          </div>



                          
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Product Company <i class="text-danger">*</i></label>
                          <div class="col-sm-9">
                            <select name="company" class="form-control" required>
                              <option value="" >Select Company</option>
                              <?php
                              $db->where ("deleted_at", NULL, 'IS');
                              $db->orderBy("name",'asc');
                              $brands=$db->get('brands');
                              foreach($brands as $brand){ 
                                ?>

                                <option value="<?php echo $brand['id']; ?>" <?php if($product['company_name']==$brand['id']){ echo "selected";} ?> ><?php echo $brand['name']; ?></option>
                              <?php } ?>

                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 mt-2">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Brand Category <i class="text-danger">*</i></label>
                          <div class="col-sm-9">
                            <select name="category" id="categoryDropdown" class="form-control" required>
                              <option value="" >Select Category</option>
                              <?php
                              $db->where ("deleted_at", NULL, 'IS');
                              $db->orderBy("name",'asc');
                              $categories=$db->get('categories');
                              foreach($categories as $category){ 
                                ?>

                                <option value="<?php echo $category['id']; ?>" <?php if($product['category_id']==$category['id']){ echo "selected";} ?>><?php echo $category['name']; ?></option>
                              <?php } ?>

                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Unit <i class="text-danger">*</i></label>
                          <div class="col-sm-9">
                            <select name="pro_unit" id="pro_unit" class="form-control">
                              <option value="" <?php if( $product['pro_unit'] == '' ){ echo "selected"; } ?> >Select Unit</option>
                              <?php
                              $unit_data=$db->get('tbl_units');
                              foreach($unit_data as $u_da){ ?>

                                <option value="<?php echo $u_da['un_id']; ?>" <?php if( $u_da['un_id'] == $product['pro_unit'] ){ echo "selected"; } ?>  ><?php echo $u_da['unit_name']; ?></option>

                                <?php
                              } 
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Unit Qty</label>
                          <div class="col-sm-9">
                            <input type="text"  name="unit_qty" id="unit_qty" value="<?php echo $product['unit_qty']; ?>" class="form-control" autocomplete="off">
                          </div>
                        </div>
                      </div>
                    </div>

                    

                    <div class="row">
                      <div class="col-md-12">

                        <table class="table table-bordered mb-0">
                          <thead>
                            <tr>
                              <th>Quantity <i class="text-danger">*</i></th>
                              <th>Purchase Price <i class="text-danger">*</i></th>
                              <th>Whole Sale Price <i class="text-danger">*</i></th>
                              <th>Retail Sale Price <i class="text-danger">*</i></th>
                              
                              
                              <th>Rack No. </th>
                              <th>Row </th>
                              <th>Re-Order </th>

                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>
                                <div class="form-group row">                                               
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control text-danger" value="<?php echo $product['pro_qty']; ?>" name="pro_qty" autocomplete="off" required="">
                                  </div>
                                </div>
                              </td>
                              <td >
                                <div class="form-group row">                                               
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control text-danger" value="<?php echo $product['supplier_price']; ?>" id="purchase_price"  name="supplier_price" autocomplete="off" >
                                  </div>
                                </div>
                              </td>
                              <td>
                                <div class="form-group row">                                               
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control text-danger" value="<?php echo $product['sell_price']; ?>" id="wholesale_price"  name="whole_sell_price" autocomplete="off" required="">
                                  </div>
                                </div>
                              </td>
                              <td>
                                <div class="form-group row">                                               
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control text-danger" value="<?php echo $product['retail_price']; ?>" id="retail_price"  name="retail_sell_price" autocomplete="off" required>
                                  </div>
                                </div>
                              </td>
                              
                              
                              <td>
                                <div class="form-group row">                                               
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control text-danger" value="<?php echo $product['rack_num']; ?>"   name="rack_num" autocomplete="off">
                                  </div>
                                </div>
                              </td>
                              <td >
                                <div class="form-group row">                                               
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control text-danger" value="<?php echo $product['row_num']; ?>"  name="row_num" autocomplete="off">
                                  </div>
                                </div>
                                
                              </td>
                              <td >
                                <div class="form-group row">                                               
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control text-danger" value="<?php echo $product['pro_reorder']; ?>"  name="reorder_num" autocomplete="off" >
                                  </div>
                                </div>
                                
                              </td>
                            </tr>                     
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="row" style="margin-top: 30px;">
                      <div class="col-md-12">
                        <div class="text-center">
                          <input class="btn btn-primary" name="add_product" type="submit" value="Update">
                          
                        </div>
                      </div>
                    </div>


                    

                    
                    
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        </div>
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
  <script src='<?php echo base_url('assets/js/urdutext.js'); ?>' type="text/javascript"></script>
  <script> 
    window.onload = myOnload;
    function myOnload(evt) {
        MakeTextBoxUrduEnabled(txtStudentNameUrdu);//enable Urdu in html text box
      }
      function GenrateBarCode(string_val) {

        if ( string_val != '' ) {

          $.ajax({
            url: '../ajax/ajax-show-detail.php',
            type: 'post',
            data: { action:'get_barcode' },
            success: function(barcode){ 

              $("#pro_code").val(barcode);

            }
            
          });


        }
        
      }
      $("#categoryDropdown").on("change", function() {
        var id = $(this).val();

        if(id)
        {
          $.ajax({
            url: '../ajax/ajax-show-detail.php',
            type: 'post',
            data: { action: 'get_category_info', id: id },
            success: function(response) {
              var categoryInfo = JSON.parse(response);
              $("#pro_unit").val(categoryInfo.unit_id);
              $("#unit_qty").val(categoryInfo.package_qty);
              $("#purchase_price").val(categoryInfo.purchase_price);
              $("#wholesale_price").val(categoryInfo.wholesale_price);
              $("#retail_price").val(categoryInfo.retail_price);
            }
          });
        }else{
          $("#pro_unit").val(null);
          $("#unit_qty").val(null);
        }


      });
    </script>
    
  </body>
  </html>