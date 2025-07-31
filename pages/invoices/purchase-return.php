<?php 
include '../../include/functions.php';
include '../../include/MysqliDb.php';
include '../../include/config.php';
include '../../include/permission.php';

$page_title='Inventory | Purchase Return';

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

  $purchase_re_id=$db->insert('tbl_purchase_return',$invoice_array);

  AddPurchaseReturnJV($purchase_re_id,$invoice_date,$supplier_name,$grand_total,$db);




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
        "pur_re_id"=>$purchase_re_id,
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
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/vendors/select2/select2.min.css'); ?>">
      <link rel="stylesheet" href="<?php echo base_url('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css'); ?>"> -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2.min.css" integrity="sha512-iVAPZRCMdOOiZWYKdeY78tlHFUKf/PqAJEf/0bfnkxJ8MHQHqNXB/wK2y6RH/LmoQ0avRlGphSn06IMMxSW+xw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2-bootstrap.min.css" integrity="sha512-eNfdYTp1nlHTSXvQD4vfpGnJdEibiBbCmaXHQyizI93wUnbCZTlrs1bUhD7pVnFtKRChncH5lpodpXrLpEdPfQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                
                
                
                
                <div class="col-12 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Purchase Return</h4>
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
                                    <option value="<?php echo $sup['cus_id'] ?>" ><?php echo $sup['cus_name'] ?></option>

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
                              <input type="date" name="inv_date" value="<?php echo date("Y-m-d"); ?>" class="form-control form-control-sm" autocomplete="off">
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 inv-col">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Detail</label>
                            <div class="col-sm-9">
                              <input type="text" name="bill_detail" class="form-control form-control-sm" autocomplete="off">
                              
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
                              $cols=array(
                                "pro.*",
                                "cat.name as cat_name",
                                "br.name as brand_name",
                                "tu.unit_name as unitname"
                              );
                              $db->join("tbl_units tu", "pro.pro_unit=tu.un_id", "LEFT");
                              $db->join("brands br", "pro.company_name=br.id", "LEFT");
                              $db->join("categories cat", "pro.category_id=cat.id", "LEFT");
                              $db->where('pro.is_delete','0');
                              $db->orderBy("pro_name",'asc');
                              $products=$db->get('tbl_products pro',null,$cols);
                              foreach($products as $pro){
                               ?>

                               <option 
                               value="<?php echo $pro['pro_id']; ?>" 
                               product-qty="<?php echo $pro['pro_qty']; ?>" 
                               product-name="<?php echo $pro['pro_name']; ?>" 
                               product-code="<?php echo $pro['pro_code']; ?>" 
                               price="<?php echo $pro['sell_price']; ?>" 
                               price-supplier="<?php echo $pro['supplier_price']; ?>" 
                               cat-name="<?php echo $pro['cat_name']; ?>" 
                               brand-name="<?php echo $pro['brand_name']; ?>" 
                               unit-name="<?php echo $pro['unitname']; ?>" 
                               unit-qty="<?php echo $pro['unit_qty']; ?>"
                               >
                               <?php echo $pro['pro_name'].' '.$pro['brand_name'].' '.$pro['cat_name'].' '.$pro['unit_qty'].' '.$pro['unitname'].' '.$pro['pro_code']; ?>
                             </option>


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
                              
                              
                              <th class="text-center">Available Qty</th>
                              <!-- <th class="text-center">Sell Price <i class="text-danger">*</i></th> -->
                              <th class="text-center">Supplier Price <i class="text-danger">*</i> </th>
                              <th class="text-center">Quantity <i class="text-danger">*</i></th>
                              <th class="text-center">Total</th>
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody id="addinvoiceItem">
                            
                          </tbody>
                          <tfoot>
                            
                            <tr style="display: none;">
                              <td style="text-align:right;" colspan="3"><b>Total Discount:</b></td>
                              <td class="text-right" colspan="2">
                                <input onkeyup="DiscountCal();" id="total_discount_ammount" class="form-control form-control-sm" name="total_discount" tabindex="-1" value="0" autocomplete="off"  type="text">
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="text-align:right;"><b>Grand Total:</b></td>
                              <td class="text-right" colspan="2" >
                                <input id="grandTotal" class="form-control form-control-sm" name="grand_total_price" value="0.00" tabindex="-1"  type="text" readonly>
                              </td>
                            </tr>
                            <tr style="display: none;">
                              <td style="text-align:right;" colspan="3"><b>Paid Amount:</b></td>
                              <td class="text-right" colspan="2">
                                <input id="paidAmount" autocomplete="off" class="form-control form-control-sm" name="paid_amount" onkeyup="invoice_paidamount();" value="0" placeholder="0.00" tabindex="7" type="text">
                              </td>
                            </tr>
                            <tr style="display: none;">                               
                              <td style="text-align:right;" colspan="3"><b>Total Due:</b></td>
                              <td class="text-right" colspan="2">
                                <input id="dueAmmount" class="form-control form-control-sm" name="due_amount" value="0" readonly="" type="text">
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
  <!-- <script src="<?php echo base_url('assets/vendors/select2/select2.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/select2.js'); ?>"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2.min.js" integrity="sha512-nwnflbQixsRIWaXWyQmLkq4WazLLsPLb1k9tA0SEx3Njm+bjEBVbLTijfMnztBKBoTwPsyz4ToosyNn/4ahTBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    

    

    <script>
      $(document).on('keydown', function(e) {
        // Trigger on alt + s key press
        if (e.altKey && e.key === 's') {
            // Open Select2 dropdown
          $('.js-example-basic-single').select2('open');
        }
        if (e.altKey && e.key === 'a') {
            // Open Select2 dropdown
          $('.js-example-basic-single').select2('close');
        }
      });
      $(document).ready(function() { $(".js-example-basic-single").select2(); $('.js-example-basic-single').select2('open'); });
      $(".js-example-basic-single").change(function(){
        var pro_id = $(this).children("option:selected").val();
        if ( pro_id != '' ) {

         
          var pro_price = $('option:selected', this).attr('price');   
          var pro_qty=$('option:selected', this).attr('product-qty');
          var pro_name=$('option:selected', this).attr('product-name');
          var pro_price_supplier=$('option:selected', this).attr('price-supplier');
          var brand_name=$('option:selected', this).attr('brand-name');
          var cat_name=$('option:selected', this).attr('cat-name');
          var unit_qty=$('option:selected', this).attr('unit-qty');
          var unit_name=$('option:selected', this).attr('unit-name');

          var pro_full_name = pro_name + " " + brand_name + " " + cat_name + " " + unit_qty + " " + unit_name

          if ($('tr').hasClass('invoice-row'+pro_id+'')) {
            alert("This Product already selected");
          } else{


            $("#addinvoiceItem").append('<tr class="invoice-row'+pro_id+'"><td style="width: 500px"><input name="product_name[]"  class="form-control form-control-sm productSelection" placeholder="Products" required="" id="product_name" value="'+pro_full_name+'" autocomplete="off" tabindex="1" type="text"><input type="hidden" class="autocomplete_hidden_value product_id_1" value="'+pro_id+'" name="product_id[]" id="product_id"></td><td style="width: 80px;"><input name="product_quantity[]" autocomplete="off" class="form-control form-control-sm" id="total_qty_'+pro_id+'" readonly value="'+pro_qty+'" required="" placeholder="0.00" tabindex="3" type="text"></td><td style="width: 150px;display:none;"><input name="product_sell_rate[]" value="'+pro_price+'" id="item_price_'+pro_id+'" class="item_price_1 price_item form-control form-control-sm" tabindex="7"  type="text"></td><td style="width: 150px;"><input name="product_supplier_rate[]" id="supplier_rate'+pro_id+'" class="form-control form-control-sm" value="'+pro_price_supplier+'" onkeyup="NewQuntity('+pro_id+');" autocomplete="off"  tabindex="4"  placeholder="0.00" type="text"></td><td style="width: 175px"><input class="form-control form-control-sm" name="new_product_quantity[]" id="new_product_quantity'+pro_id+'" onkeyup="NewQuntity('+pro_id+');" value="0"  type="text" autocomplete="off" ></td><td><input class="total_price form-control form-control-sm" name="product_total[]" value="0" id="product_total'+pro_id+'"  type="text"></td><td><button  class="btn btn-danger btn-rounded btn-icon btn-del" type="button" onclick="deleteRow('+pro_id+')" value="Delete" tabindex="5"><i class="mdi mdi-delete"></i></button></td></tr>');

            CalculateTotal();
          }

        } else{
          alert("Please Select Valid Item ! ");
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
        new_amount=grand_amount - rece_amount;

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