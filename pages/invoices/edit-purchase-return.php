<?php 
  include '../../include/functions.php';
  include '../../include/MysqliDb.php';
  include '../../include/config.php';
  include '../../include/permission.php';


$x=$_REQUEST['in'];
$in_id=$_REQUEST['in'];

$page_title='Inventory | Edit Purchase Return';

if ( isset($_POST['add_invoice']) ) {


  
  
  $supplier_name=$_POST['sup_name'];
  $invoice_date=$_POST['inv_date'];
  $bill_detail=$_POST['bill_detail'];
  $grand_total=$_POST['grand_total_price'];
  $invoice_array=array( 
                        "supplier_id"=>$supplier_name,
                        "in_date"=>$invoice_date,
                        "bill_detail"=>$bill_detail,
                        "grand_total"=>$grand_total

                      );
  $db->where("pur_re_id",$in_id);
  $db->update('tbl_purchase_return',$invoice_array);

  UpdatePurchaseInvoice_Return($in_id,$grand_total,$invoice_date,$db);



  if (isset($_POST['old_product_id'])) {

    $old_pur_pro_id=$_POST['old_pur_pro_id'];

    $old_product_id=$_POST['old_product_id'];
    $old_product_name=$_POST['old_product_name'];
    
    $old_product_quantity=$_POST['old_product_quantity'];

    $old_supplier_rate=$_POST['old_product_supplier_rate'];
    
    
    $old_new_product_quantity=$_POST['old_new_product_quantity'];
    $pre_product_qt=$_POST['pre_product_qty'];

    $old_product_total=$_POST['old_product_total'];

    $old_pro_count=count($old_pur_pro_id);

    for ($i=0; $i <$old_pro_count ; $i++) { 
      $pre_pro_arr=array(
                          
                          "supplier_price"=>$old_supplier_rate[$i],
                          "return_qty"=>$old_new_product_quantity[$i],
                          "pro_total"=>$old_product_total[$i]
                        );
    
      $db->where("meta_pro_id",$old_pur_pro_id[$i]);
      $db->update("tbl_purchase_return_detail",$pre_pro_arr);

      if($pre_product_qt[$i] != $old_new_product_quantity[$i] ){
        // update the stock with qty
        $db->where("pro_id",$old_product_id[$i]);
        $product=$db->getOne("tbl_products");
        $new_qty=$product['pro_qty']+$pre_product_qt[$i];
        $up_qty=$new_qty-$old_new_product_quantity[$i];
        $update_pro=array("pro_qty"=>$up_qty);
        $db->where("pro_id",$old_product_id[$i]);
        $db->update("tbl_products",$update_pro);
      } 
    } 
  }




  if (isset($_POST['pur_inv_product_del_id'])) {

    $pur_del_id=$_POST['pur_inv_product_del_id'];
    $pur_pro_del=$_POST['product_del_id'];
    $del_qty=$_POST['pro_del_qty'];


    $count_del=count($pur_del_id);

    for ($i=0; $i <$count_del ; $i++) { 
      // update the stock by removing item
      ReutrnProductInStock_Edit($pur_del_id[$i],$db);

      // remove from purchase products
      $db->where("meta_pro_id",$pur_del_id[$i]);
      $db->delete("tbl_purchase_return_detail");
    }

    
  }



  // add the new products in invoice
  if( isset($_POST['product_id']) ){
  
    $productId=$_POST['product_id'];
    $productName=$_POST['product_name'];
    $preProductQuantity=$_POST['product_quantity'];
    $product_sell_rate=$_POST['product_sell_rate'];
    $productSupplierRate=$_POST['product_supplier_rate'];
    $returnQuantity=$_POST['new_product_quantity'];
    $productTotal=$_POST['product_total'];

    $total_products=count($productId);
    for ($i=0; $i < $total_products; $i++) { 
      if( $productId[$i] != '' ){
        $purchase_re_pro=array( 
                              "pur_re_id"=>$in_id,
                              "pro_id"=>$productId[$i],
                              "pro_name"=> $productName[$i],
                              "last_avl_qty"=>$preProductQuantity[$i],
                              "supplier_price"=>$productSupplierRate[$i],
                              "return_qty"=>$returnQuantity[$i],
                              "pro_total"=>$productTotal[$i]          
                        );
        $db->insert('tbl_purchase_return_detail',$purchase_re_pro);
        
        RemoveStockQty($productId[$i],$returnQuantity[$i],$db);
      }
    }
  }
  

  header("LOCATION:all-purchase-return.php");

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
    <link rel="stylesheet" href="<?php echo baseurl('assets/vendors/select2/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo baseurl('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css'); ?>">
    <style>
      .slct-rw{
        padding-left: 10px;
        padding-right: 10px;
      }
      .inv-col{
        height: 50px;
      }
      .select2-container .select2-selection--single{
            height: 55px;
      }
      .select2-container--default .select2-results>.select2-results__options{
        max-height: 280px;
      }
      .table td, .jsgrid .jsgrid-table td{
        padding: 0px 0px;
      }
      .btn-del{
        margin-left: 25px;
        width: 25px!important;
        height: 25px!important;
        padding: 2px!important;
      }
      .select2-container--default .select2-results__option[aria-disabled=true]{
        color: #f00;
      }
      .del-row{
        display: none;
      }
      .table thead th{
        padding: 12px 12px;
      }
    </style>

  </head>
  <body>
    <div class="container-scroller">
    <?php include '../../libraries/nav.php'; ?>
      <div class="container-fluid page-body-wrapper">
        <?php include '../../libraries/sidebar.php'; ?>
        
        
        
        <!-- partial -->
        
  <div class="main-panel" style="width: 100%;">        
  <div class="content-wrapper" style="padding: 0px 0px;">
    <div class="row">
    <?php 
    $db->where("pur_re_id",$in_id);
    $purchase_data=$db->getOne("tbl_purchase_return");
    ?>
    
            
            
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Purchase Invoice</h4>
        <form action=""  method="POST" class="form-sample">
                    
    <div class="row">
      <div class="col-md-6 inv-col">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Supplier Name</label>
          <div class="col-sm-9">
            <select name="sup_name" class="form-control form-control-sm" required>
              <option value="" > Select Supplier </option>
              <?php
              $db->where("cus_type",'2');
              $supplier=$db->get("tbl_customer");

              foreach($supplier as $sup){ ?>
                  <option value="<?php echo $sup['cus_id'] ?>" <?php if($purchase_data['supplier_id']==$sup['cus_id']  ){ echo "selected"; } ?> ><?php echo $sup['cus_name'] ?></option>

                <?php

              }
               ?>
              }
            </select>
            
          </div>
        </div>
      </div>
      <div class="col-md-6 inv-col">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label"> Date</label>
          <div class="col-sm-9">
            <input type="date" name="inv_date" value="<?php echo $purchase_data['in_date']; ?>" class="form-control form-control-sm" autocomplete="off">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      
      <div class="col-md-6 inv-col">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Detail</label>
          <div class="col-sm-9">
            <input type="text" name="bill_detail" value="<?php echo $purchase_data['bill_detail']; ?>" class="form-control form-control-sm" autocomplete="off">
            
          </div>
        </div>
      </div>
      <div class="col-md-6 inv-col">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">BarCode</label>
          <div class="col-sm-9">
            <input type="text" id="scannerInput-new" name="" class="form-control form-control-sm" autocomplete="off" >
            
          </div>
        </div>
      </div>
    </div>

    

    

    

    

    

    <div class="row slct-rw">
      <div class="col-md-4">
        <div class="form-group row">
          <label>Select Products</label>
          <select class="js-example-basic-single w-100">
            <option value=""  >Select Product</option>
            <?php
            $cols=array("");
            $db->where('is_delete','0');
            $products=$db->get('tbl_products');
            foreach($products as $pro){
               ?>

                <option value="<?php echo $pro['pro_id']; ?>" product-qty="<?php echo $pro['pro_qty']; ?>" product-name="<?php echo $pro['pro_name']; ?>" product-code="<?php echo $pro['pro_code']; ?>" price="<?php echo $pro['sell_price']; ?>" retail-price="<?php echo $pro['retail_price']; ?>"  price-supplier="<?php echo $pro['supplier_price']; ?>" ><?php echo $pro['pro_name']; ?>  (<?php echo $pro['pro_qty']; ?>) </option>


                <?php

              

             

            }

             ?>
          </select>
        </div>
        
      </div>


  <div class="col-md-8">
    <div class="table-responsive" >
      <table class="table table-bordered table-hover" id="normalinvoice">
        <thead>
          <tr>
            <th class="text-center">Product Name<i class="text-danger">*</i></th>
           
            
            <th class="text-center">Stock Qty</th>
            <th class="text-center">Supplier Price <i class="text-danger">*</i> </th>
            
            <th class="text-center">New Qty <i class="text-danger">*</i></th>
            <th class="text-center">Total</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody id="addinvoiceItem">
          <?php

          $db->where("pur_re_id",$in_id); 
          $in_item=$db->get("tbl_purchase_return_detail");
          foreach($in_item as $item){

          ?>





          <tr class="invoice-row<?php echo $item['pro_id']; ?>">
            <td style="width: 500px">
              <input name="old_product_name[]" class="form-control form-control-sm productSelection" placeholder="Products" required="" id="product_name" value="<?php echo $item['pro_name']; ?>" autocomplete="off"  type="text" readonly >
              <input type="hidden" class="autocomplete_hidden_value" value="<?php echo $item['pro_id']; ?>" name="old_product_id[]" id="product_id">
              <input type="hidden" class="autocomplete_hidden_value" value="<?php echo $item['meta_pro_id']; ?>" name="old_pur_pro_id[]" >
            </td>
            <td style="width: 80px;">
              <input name="old_product_quantity[]" autocomplete="off" class=" form-control form-control-sm" id="total_qty_<?php echo $item['pro_id']; ?>" value="<?php echo $item['last_avl_qty']; ?>" required="" placeholder="0.00" type="text" readonly>
            </td>
            <td style="width: 100px;">
              <input name="old_product_supplier_rate[]"  id="supplier_rate<?php echo $item['pro_id']; ?>"  onkeyup="NewQuntity('<?php echo $item['pro_id']; ?>');" class=" price_item form-control form-control-sm"  value="<?php echo $item['supplier_price']; ?>" type="text">
            </td>
            
            <td style="width: 150px">
              <input class="form-control form-control-sm" name="old_new_product_quantity[]" id="new_product_quantity<?php echo $item['pro_id']; ?>" onkeyup="NewQuntity('<?php echo $item['pro_id']; ?>');" value="<?php echo $item['return_qty']; ?>" type="text">

              <input type="hidden" class="autocomplete_hidden_value" value="<?php echo $item['return_qty']; ?>" name="pre_product_qty[]" >

            </td>
            <td style="width: 150px">
              <input class="total_price form-control form-control-sm" name="old_product_total[]" value="<?php echo $item['pro_total']; ?>" id="product_total<?php echo $item['pro_id']; ?>" type="text">
            </td>
            <td>
              <button class="btn btn-danger btn-rounded btn-icon btn-del" type="button" onclick="deletePreviousRow('<?php echo $item['pro_id']; ?>','<?php echo $item['meta_pro_id']; ?>','<?php echo $item['return_qty']; ?>')" value="Delete" ><i class="mdi mdi-delete"></i>
              </button>
            </td>
          </tr>


            <?php
          }
          ?>          
        </tbody>
    <tfoot>
                    
      
      <tr>
        <td colspan="3" style="text-align:right;"><b>Grand Total:</b></td>
        <td class="text-right" colspan="2" >
            <input id="grandTotal" class="form-control form-control-sm" name="grand_total_price" value="<?php echo $purchase_data['grand_total']; ?>" tabindex="-1" readonly="" type="text">
        </td>
      </tr>
    </tfoot>
  </table>                            
        </div>
      </div>
      
    </div>

                    

                    

    

    <div class="row" style="margin-top: 30px;">
      <div class="col-md-12">
        <div class="text-center">
          <input class="btn btn-primary" name="add_invoice" type="submit" value="Create Invoice">
          
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
  <script src="<?php echo baseurl('assets/vendors/select2/select2.min.js'); ?>"></script>
  <script src="<?php echo baseurl('assets/js/select2.js'); ?>"></script>
 



  <script>
    $(".js-example-basic-single").change(function(){
        var pro_id = $(this).children("option:selected").val();
        var pro_price = $('option:selected', this).attr('price');
        
        var pro_qty=$('option:selected', this).attr('product-qty');
        var pro_name=$('option:selected', this).attr('product-name');
        var pro_price_supplier=$('option:selected', this).attr('price-supplier');
        var retail_price=$('option:selected', this).attr('retail-price');



        if ($('tr').hasClass('invoice-row'+pro_id+'')) {

          alert("This Product already selected");

       
        } else{


         $("#addinvoiceItem").append('<tr class="invoice-row'+pro_id+'"><td style="width: 500px"><input name="product_name[]"  class="form-control form-control-sm productSelection" placeholder="Products" required="" id="product_name" value="'+pro_name+'" autocomplete="off" tabindex="1" type="text" readonly><input type="hidden" class="autocomplete_hidden_value product_id_1" value="'+pro_id+'" name="product_id[]" id="product_id"></td><td style="width: 80px;"><input name="product_quantity[]" autocomplete="off" class="form-control form-control-sm" id="total_qty_'+pro_id+'" readonly value="'+pro_qty+'" required="" placeholder="0.00" tabindex="3" type="text"></td><td style="width: 150px;display:none;"><input name="product_sell_rate[]" value="'+pro_price+'" id="item_price_'+pro_id+'" class="item_price_1 price_item form-control form-control-sm" tabindex="7"  type="text"></td><td style="width: 150px;"><input name="product_supplier_rate[]" id="supplier_rate'+pro_id+'" class="form-control form-control-sm" value="'+pro_price_supplier+'" onkeyup="NewQuntity('+pro_id+');" autocomplete="off"  tabindex="4"  placeholder="0.00" type="text"></td><td style="width: 175px"><input class="form-control form-control-sm" name="new_product_quantity[]" id="new_product_quantity'+pro_id+'" onkeyup="NewQuntity('+pro_id+');" value="0"  type="text" autocomplete="off" ></td><td><input class="total_price form-control form-control-sm" name="product_total[]" value="0" id="product_total'+pro_id+'"  type="text"></td><td><button  class="btn btn-danger btn-rounded btn-icon btn-del" type="button" onclick="deleteRow('+pro_id+')" value="Delete" tabindex="5"><i class="mdi mdi-delete"></i></button></td></tr>');

          CalculateTotal();

        }
        



    });


    function CalculateTotal() {

      // calculate the grand total
      var total_price_update=0;
      $(".total_price").each(function(){
              total_price_update += + parseFloat($(this).val());
      });
      $("#grandTotal").val(total_price_update);
      var total_paid=$("#paidAmount").val();

      var total_due_amount=0;
      total_due_amount=total_price_update-total_paid;

      $("#dueAmmount").val(total_due_amount);


      
    }



    function deletePreviousRow(pro_id,pur_pro_id,del_qty){


      $(".js-example-basic-single").on("select2-closed", function(e) {
      $(".js-example-basic-single").select2("open");
      });

      $(".invoice-row"+pro_id+"").remove();

      
      CalculateTotal();
      $("#addinvoiceItem").append('<tr class="del-row invoice-row-del'+pro_id+'"><td style="width: 500px"><input name="product_del_id[]"  class="form-control form-control-sm"  value="'+pro_id+'" type="text"><input type="hidden" class="autocomplete_hidden_value" value="'+pur_pro_id+'" name="pur_inv_product_del_id[]" ><input type="hidden" class="autocomplete_hidden_value" value="'+del_qty+'" name="pro_del_qty[]" ></td></tr>');



    }

    function NewQuntity(pro_id) {
      
      var sup_rate=parseFloat($("#supplier_rate"+pro_id+"").val());
      var pro_qty=parseFloat($("#new_product_quantity"+pro_id+"").val());

      var result=sup_rate*pro_qty;
      var set_price=parseFloat(result).toFixed(2);

      $("#product_total"+pro_id+"").val(result);

      CalculateTotal();
        



    }



    function DiscountCal() {
      
      var discount=parseInt( $("#total_discount_ammount").val() );

      var total_price_update=0;
      $(".total_price").each(function(){
          total_price_update += + parseFloat($(this).val());
      });

      var result=total_price_update-discount;
      var paid_amount=$("#paidAmount").val();
      var set_amount=result-paid_amount;

      $("#grandTotal").val(result);
      $("#dueAmmount").val(set_amount);
    }

    

    function invoice_paidamount(){

      var grand_amount=parseInt( $("#grandTotal").val() );
      var rece_amount=parseInt( $("#paidAmount").val() );

      var new_amount=0;
      new_amount=grand_amount- rece_amount;

      $("#dueAmmount").val(new_amount);

    }



    


    



    function deleteRow(rem_id) {

      $(".js-example-basic-single").on("select2-closed", function(e) {
      $(".js-example-basic-single").select2("open");
      });


      $(".invoice-row"+rem_id+"").remove();

      // update grand total 
      CalculateTotal();

      
    }
    function BarCodeSelectedProduct(pro_id,pro_price,pro_qty,pro_name,pro_price_supplier,retail_price){


      if (pro_id != '') {


        

        if ($('tr').hasClass('invoice-row'+pro_id+'')) {
          alert("This Product Already Added In Invoice");
        } else{



        $("#addinvoiceItem").append('<tr class="invoice-row'+pro_id+'"><td style="width: 500px"><input name="product_name[]"  class="form-control form-control-sm productSelection" placeholder="Products" required="" id="product_name" value="'+pro_name+'" autocomplete="off" tabindex="1" type="text"><input type="hidden" class="autocomplete_hidden_value product_id_1" value="'+pro_id+'" name="product_id[]" id="product_id"></td><td style="width: 80px;"><input name="product_quantity[]" autocomplete="off" class="form-control form-control-sm" id="total_qty_'+pro_id+'" value="'+pro_qty+'" required=""   type="text" readonly ></td><td style="width: 100px;"><input name="product_supplier_rate[]" value="'+pro_price_supplier+'" id="supplier_rate'+pro_id+'" onkeyup="NewQuntity('+pro_id+');" class="form-control form-control-sm"   type="text"></td><td style="width: 100px;"><input name="ws_price[]" value="'+pro_price+'" id="ws_price'+pro_id+'" class="price_item form-control form-control-sm"   type="text"></td>    <td style="width: 100px;"><input name="retail_price[]" value="'+retail_price+'" id="retail_price'+pro_id+'" class="price_item form-control form-control-sm"   type="text"></td><td style="width: 175px"><input class="form-control form-control-sm" name="new_product_quantity[]" id="new_product_quantity'+pro_id+'" onkeyup="NewQuntity('+pro_id+');" value="0" autocomplete="off"  type="text"></td><td style="width: 150px;" ><input class="total_price form-control form-control-sm" name="product_total[]" value="0" id="product_total'+pro_id+'"  type="text"></td><td><button  class="btn btn-danger btn-rounded btn-icon btn-del" type="button" onclick="deleteRow('+pro_id+')" value="Delete" ><i class="mdi mdi-delete"></i></button></td></tr>');

          CalculateTotal();
        
        }
        } else{
          alert("Please Select Valid Item ! ");
        }

    }


  </script>
  <script src="<?php echo base_url('assets/js/jquery.scannerdetection.js'); ?>">
  </script >
  <script>
      
    
    $('#scannerInput-new').scannerDetection({
    timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    avgTimeByChar: 100, // it's not a barcode if a character takes longer than 100ms
    onComplete: function(barcode, qty){

    
 
    var pro_id = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('value');
    
    var pro_price = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('price');
    
    var pro_qty = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('product-qty');
    
    var pro_name = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('product-name');
    
    var pro_price_supplier = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('price-supplier');
    
    var retail_price = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('retail-price');
    
    
    BarCodeSelectedProduct(pro_id,pro_price,pro_qty,pro_name,pro_price_supplier,retail_price);

    $('#scannerInput-new').val('');

    
    
    } // main callback function 
    });

    </script>
  </body>
</html>