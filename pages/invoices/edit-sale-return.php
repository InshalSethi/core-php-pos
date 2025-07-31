<?php 
  include '../../include/functions.php';
  include '../../include/MysqliDb.php';
  include '../../include/config.php';
  include '../../include/permission.php';

  $page_title='Inventory | Edit Sale Return';
  
  $p_in_id=$_REQUEST['inv'];

if ( isset($_POST['add_invoice']) ) {


  $customer_name=$_POST['cus_name'];
  $invoice_date=$_POST['inv_date'];
  $customer_contact=$_POST['phone_num'];
  $customer_address=$_POST['cus_address'];
  
  
  $grand_total=$_POST['grand_total_price'];
  $total_discount=$_POST['flat_discount'];
  $total_ammount_after_dis=$_POST['total_ammount_after_dis'];
  $paid_amount=$_POST['paid_amount'];
  $due_amount=$_POST['due_amount'];

  
  


  $invoice_array=array( 
                        
                        "cus_name"=>$customer_name,
                        "cus_mobile"=>$customer_contact,
                        "cus_address"=>$customer_address,
                        "p_inv_date"=>$invoice_date,
                        "grand_total"=>$grand_total,
                        "grand_total_w_dis"=>$total_ammount_after_dis,
                        "paid_amount"=>$paid_amount,
                        "total_dis"=>$total_discount,
                        "total_due"=>$due_amount
                      );

  $db->where("inv_id",$p_in_id);
  $db->update('tbl_salereturn_invoice',$invoice_array);
  UpdateSaleInvoice_Return($p_in_id,$total_ammount_after_dis,$invoice_date,$db);

  if (isset($_POST['del_item_id'])) {
    $del_id=$_POST['del_item_id'];
    $del_count=count($del_id);
    for ($i=0; $i <$del_count ; $i++) {

      ReverseTheProductItem_Return($del_id[$i],$db);
      $db->where("pkg_meta_item",$del_id[$i]);
      $db->delete("tbl_salereturn_detail");    
    }
  }

  if (isset($_POST['package_item_id'])) {

    $package_item_id=$_POST['package_item_id'];
    $old_pro_id=$_POST['old_package_id'];
    $old_pro_name=$_POST['old_package_name'];
    $old_pro_quantity=$_POST['old_package_quantity'];
    $pre_old_pro_quantity=$_POST['pre_old_package_quantity'];
    $old_pro_rate=$_POST['old_package_rate'];
    $old_total_price=$_POST['old_total_price'];

    $order_count_pkg=count($package_item_id);
    for ($i=0; $i < $order_count_pkg; $i++) {

      // if quntity of the package is changed
      if ($old_pro_quantity[$i] != $pre_old_pro_quantity[$i]) {
        ChangeInProductInvoice_Return($pre_old_pro_quantity[$i],$old_pro_quantity[$i],$package_item_id[$i],$old_pro_id[$i],$db);
      }

      $invoice_pkg_arr_old=array(  
                              "pro_name"=>$old_pro_name[$i],
                              "pro_qty"=>$old_pro_quantity[$i],
                              "pro_rate"=>$old_pro_rate[$i],
                              "total_price"=>$old_total_price[$i] 
                            );
      $db->where("pkg_meta_item",$package_item_id[$i]);
      $db->update('tbl_salereturn_detail',$invoice_pkg_arr_old);

    }
  }
  
  // update the stock by adding item in stock
  if (isset($_POST['package_id'])) {

    $pro_id=$_POST['package_id'];
    $pro_name=$_POST['package_name'];
    $pro_quantity=$_POST['package_quantity'];
    $pro_rate=$_POST['package_rate'];
    $total_price=$_POST['total_price'];

    $total_pkg=count($pro_id);
    for ($i=0; $i < $total_pkg; $i++) { 
      if( $pro_id[$i] != '' ){
        $invoiceArr=array( 
                            "inv_id"=>$p_in_id,
                            "pro_id"=>$pro_id[$i],
                            "pro_name"=>$pro_name[$i],
                            "pro_qty"=>$pro_quantity[$i],
                            "pro_rate"=>$pro_rate[$i],
                            "total_price"=>$total_price[$i]
                          );
        $db->insert('tbl_salereturn_detail',$invoiceArr);
        AddStockQty($pro_id[$i],$pro_quantity[$i],$db); 
      } 
    }
  }




 
  
  

  header("LOCATION:all-sale-return.php");

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
      .btn-ntf{
         cursor: pointer;
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
        <!-- partial:partials/_settings-panel.html -->
        
        <?php include '../../libraries/sidebar.php'; ?>
        
        <!-- partial -->
        
  <div class="main-panel" style="width: 100%;">        
  <div class="content-wrapper" style="padding: 0px 0px;">
  <div class="row">
    <?php
    $db->where("inv_id",$p_in_id);
    $data=$db->getOne("tbl_salereturn_invoice");

     ?>
            
            
            
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Edit Sale Return</h4>
        <form action=""  method="POST" class="form-sample">
    
    

    

    <div class="row">
      <div class="col-md-6 inv-col">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Customer Name</label>
          <div class="col-sm-9">
            <?php
            $db->where("cus_type",'1');
            $customer=$db->get("tbl_customer");

             ?>
            <select  id="cus_name"  name="cus_name" class="form-control form-control-sm" required >
              <option value="" >Select Customer</option>
              <?php 
              foreach($customer as $cus ){ ?>
                <option value="<?php echo $cus['cus_id']; ?>" <?php if($data['cus_name'] == $cus['cus_id']){ echo "selected";} ?> ><?php echo $cus['cus_name']; ?></option>
                <?php

              }

              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6 inv-col">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label"> Date</label>
          <div class="col-sm-9">
            <input type="date" name="inv_date" value="<?php echo $data['p_inv_date']; ?>" class="form-control form-control-sm" autocomplete="off">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 inv-col">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Mobile</label>
          <div class="col-sm-9">
            <input type="text" id="phone_num" name="phone_num" value="<?php echo $data['cus_mobile']; ?>" class="form-control form-control-sm" autocomplete="off">
            
          </div>
        </div>
      </div>
      <div class="col-md-6 inv-col">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Address</label>
          <div class="col-sm-9">
            <input type="text" id="cus_address" name="cus_address" value="<?php echo $data['cus_address']; ?>" class="form-control form-control-sm" autocomplete="off" >
            
          </div>
        </div>
      </div>
    </div>

    

    

    

    

    

    <div class="row slct-rw">
      <div class="col-md-4">
        <div class="form-group row">
          <?php 
          
          $db->where('is_delete','0');
          $packages=$db->get('tbl_products');
          ?>
          <label>Select Products</label>
          <select class="js-example-basic-single w-100">
            <option value=""  >Select Product</option>
            <?php
            foreach($packages as $pac){
               ?>
                <option value="<?php echo $pac['pro_id']; ?>"  package-name="<?php echo $pac['pro_name']; ?>" package-price="<?php echo $pac['sell_price']; ?>" stock-qty=<?php echo $pac['pro_qty']; ?> ><?php echo $pac['pro_name']; ?>  </option>
            <?php
            } ?>
          </select>
        </div>
        
      </div>


  <div class="col-md-8">
    <div class="table-responsive" >
      <table class="table table-bordered table-hover" id="normalinvoice">
        <thead>
          <tr>
            <th class="text-center">Package Name<i class="text-danger">*</i></th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Rate <i class="text-danger">*</i></th>
            <th class="text-center">Total </th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody id="addinvoiceItem">

          <?php 
          
          $db->where("inv_id",$p_in_id);
          $detail=$db->get("tbl_salereturn_detail");
          foreach($detail as $de){ ?>




           <tr class="invoice-row<?php echo $de['pro_id']; ?>">
            <td style="width: 500px">
              <input name="old_package_name[]" class="form-control form-control-sm productSelection" required="" value="<?php echo $de['pro_name']; ?>" autocomplete="off" tabindex="1" type="text">
              <input type="hidden" name="package_item_id[]" class="autocomplete_hidden_value" value="<?php echo $de['pkg_meta_item']; ?>" >
              <input type="hidden"  value="<?php echo $de['pro_id']; ?>" name="old_package_id[]">
            </td>
            
            <td style="width: 150px;">
              <input name="pre_old_package_quantity[]" class=" form-control form-control-sm"  value="<?php echo $de['pro_qty']; ?>" type="hidden">

              <input name="old_package_quantity[]" autocomplete="off" class="total_qty_1 form-control form-control-sm" id="total_qty_<?php echo $de['pro_id']; ?>" onkeyup="quantity_calculate(<?php echo $de['pro_id']; ?>);" value="<?php echo $de['pro_qty']; ?>" required="" placeholder="0.00" tabindex="3" type="text"> 
              <input type="hidden" id="stock_qty<?php echo $de['pro_id']; ?>" value="<?php $db->where('pro_id',$de['pro_id']); echo $stockQty=$db->getValue('tbl_products','pro_qty'); ?>"/>
            </td>
            <td style="width: 150px;">
              <input name="old_package_rate[]" value="<?php echo $de['pro_rate']; ?>" id="item_price_<?php echo $de['pro_id']; ?>" class=" price_item form-control form-control-sm" tabindex="7" readonly="" type="text">
            </td>
            <td style="width: 242px">
              <input class="total_price form-control form-control-sm" name="old_total_price[]" id="total_price_<?php echo $de['pro_id']; ?>" value="<?php echo $de['total_price']; ?>" tabindex="-1" readonly="" type="text">
            </td>
            <td>
              <button class="btn btn-danger btn-rounded btn-icon btn-del" type="button" onclick="deleteRowOld('<?php echo $de['pro_id']; ?>','<?php echo $de['pkg_meta_item']; ?>')" value="Delete" tabindex="5"><i class="mdi mdi-delete"></i></button>
            </td>
          </tr> 

           <?php

          }

          ?>
          
        </tbody>
    <tfoot>
      <tr >
        <td colspan="3" style="text-align:right;"><b>Grand Total:</b></td>
        <td class="text-right" colspan="2" >
            <input id="grandTotal" class="form-control form-control-sm" name="grand_total_price" value="<?php echo $data['grand_total']; ?>" tabindex="-1" readonly="" type="text">
        </td>
      </tr>
      <tr style="display: none;" >
        <td style="text-align:right;" colspan="3"><b>Flat Discount:</b></td>
        <td class="text-right" colspan="2">
            <input id="flat_discount" autocomplete="off" onkeyup="FlatDiscount();" class="form-control form-control-sm" name="flat_discount" tabindex="-1" value="<?php echo $data['total_dis']; ?>" type="text" >
        </td>
      </tr>

      <tr style="display: none;" >
        <td style="text-align:right;" colspan="3"><b>Grand Total(With Dis):</b></td>
        <td class="text-right" colspan="2">
            <input id="total_ammount_after_dis" class="form-control form-control-sm" name="total_ammount_after_dis" tabindex="-1" value="<?php echo $data['grand_total_w_dis']; ?>" readonly="" type="text">
        </td>
      </tr>
      
      <tr style="display: none;" >
        <td style="text-align:right;" colspan="3"><b>Paid Amount:</b></td>
        <td class="text-right" colspan="2">
            <input id="paidAmount" autocomplete="off" class="form-control form-control-sm" name="paid_amount" onkeyup="invoice_paidamount();" value="<?php echo $data['paid_amount']; ?>" value="" placeholder="0.00" tabindex="7" type="text" readonly>
        </td>
      </tr>
      <tr style="display: none;">                               
          <td style="text-align:right;" colspan="3"><b>Total Due:</b></td>
          <td class="text-right" colspan="2">
              <input id="dueAmmount" class="form-control form-control-sm" name="due_amount" value="<?php echo $data['total_due']; ?>" readonly="" type="text">
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
          <input class="btn btn-primary" name="add_invoice" id="add_invoice" type="submit" value="Create Invoice">
          
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
    
    function  FlatDiscount() {
      var total_price_update=0;
      $(".total_price").each(function(){
              total_price_update += + parseFloat($(this).val());
      });
      var grand_total=total_price_update;
      var flat_discount=parseFloat( $("#flat_discount").val() );
      var result=grand_total-flat_discount; 
      $("#total_ammount_after_dis").val(result);
      $("#grandTotal").val(grand_total);
      invoice_paidamount();
    }

    
    $("#cus_name").change(function(){
      var cus_id = $(this).children("option:selected").val();
      $.ajax({
          url:"ajax-show-detail.php",
          async: false,
          data:{cus_id:cus_id,action:'get_customer_data'},
          type: "POST",
          dataType: "json",
          success:function(data) {
            var jsondata=JSON.parse(JSON.stringify(data));
            var cus_mob=jsondata["customer_mobile"];
            var cus_city=jsondata["customer_city"];
            
            $("#phone_num").val(cus_mob);
            $("#cus_address").val(cus_city);
              
          }
       });


    });

    
    $(".js-example-basic-single").change(function(){
        var pac_id = $(this).children("option:selected").val();
        if (pac_id != '') {


        var pac_price = $('option:selected', this).attr('package-price');
        var pac_name=$('option:selected', this).attr('package-name');
        var stockQty = $('option:selected', this).attr('stock-qty');
        if ($('tr').hasClass('invoice-row'+pac_id+'')) {
          alert("This Product Already Added In Invoice");
        } else{



        $("#addinvoiceItem").append('<tr class="invoice-row'+pac_id+'"><td style="width: 500px"><input name="package_name[]"  class="form-control form-control-sm productSelection"  required="" value="'+pac_name+'" autocomplete="off" tabindex="1" type="text"><input type="hidden" class="autocomplete_hidden_value" value="'+pac_id+'" name="package_id[]" ></td><td style="width: 150px;"><input name="package_quantity[]" autocomplete="off" class="total_qty_1 form-control form-control-sm" id="total_qty_'+pac_id+'" onkeyup="quantity_calculate('+pac_id+');" value="1" required="" placeholder="0.00" tabindex="3" type="text"><input type="hidden" id="stock_qty'+pac_id+'" value="'+stockQty+'"/> </td><td style="width: 150px;"><input name="package_rate[]" value="'+pac_price+'" id="item_price_'+pac_id+'" class=" price_item form-control form-control-sm" tabindex="7" readonly="" type="text"></td><td style="width: 242px"><input class="total_price form-control form-control-sm" name="total_price[]" id="total_price_'+pac_id+'" value="'+pac_price+'" tabindex="-1" readonly="" type="text"></td><td><button  class="btn btn-danger btn-rounded btn-icon btn-del" type="button" onclick="deleteRow('+pac_id+')" value="Delete" tabindex="5"><i class="mdi mdi-delete"></i></button></td></tr>');

        
        $(".select2-search__field").val('');
        
        CalculateTotalAmount();
        $(".js-example-basic-single").select2("open");

        }
        } else{
          var text='Please Select Valid Item!';
          showToast('error',text,'Notification');
        }

    });



   

    function CalculateTotalAmount(){

      var total_price_update=0;
      $(".total_price").each(function(){
              total_price_update += + parseFloat($(this).val());
      });
      var flat_discount=parseFloat( $("#flat_discount").val() );
      var result_dis=total_price_update-flat_discount;
      $("#total_ammount_after_dis").val(result_dis);
      $("#grandTotal").val(total_price_update);
      invoice_paidamount();

    }


    function invoice_paidamount(){

      var grand_amount=0;
      $(".total_price").each(function(){
              grand_amount += + parseFloat($(this).val());
      });
      var flat_discount=parseFloat( $("#flat_discount").val() );
      var result_dis=grand_amount-flat_discount;
      var rece_amount=parseInt( $("#paidAmount").val() );
      var new_amount=0;
      new_amount=result_dis - rece_amount;
      $("#dueAmmount").val(new_amount);

    }


    function quantity_calculate(pro_id){

      var pro_qty=parseInt( $("#total_qty_"+pro_id+"").val() );
      var StockQty=parseInt( $("#stock_qty"+pro_id+"").val() );
      if(pro_qty < StockQty ){
        var pro_price=$("#item_price_"+pro_id+"").val();
          var new_total=parseFloat(pro_qty) * parseFloat(pro_price);
          $("#total_price_"+pro_id+"").val(new_total);
          CalculateTotalAmount();
      } else{
        var pro_price=$("#item_price_"+pro_id+"").val();
        alert('Stock Quantity of This Product is '+StockQty+'');
        $("#total_qty_"+pro_id+"").val(StockQty);
        var new_total=parseFloat(StockQty) * parseFloat(pro_price);
        $("#total_price_"+pro_id+"").val(new_total);
        CalculateTotalAmount();
      }
    }

    


    function deleteRow(rem_id) {

      $(".js-example-basic-single").on("select2-closed", function(e) {
      $(".js-example-basic-single").select2("open");
      });
      $(".invoice-row"+rem_id+"").remove();
      // update grand total 
      CalculateTotalAmount();
      // set discount price given
      var total_dis_update=0;
      $(".total_discount").each(function(){
          total_dis_update += + parseFloat($(this).val());
      });
      $("#total_discount_ammount").val(total_dis_update);

    }

    function deleteRowOld(rem_id,meta_id) {

      $(".js-example-basic-single").on("select2-closed", function(e) {
      $(".js-example-basic-single").select2("open");
      });
      $("#addinvoiceItem").append('<input type="hidden" value="'+meta_id+'" name="del_item_id[]">');
      $(".invoice-row"+rem_id+"").remove();
      CalculateTotalAmount();
      
    }

    


    

  </script>
  </body>
</html>