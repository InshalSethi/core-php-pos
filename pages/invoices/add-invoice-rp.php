<?php 
include '../../include/functions.php';
include '../../include/MysqliDb.php';
include '../../include/config.php';
include '../../include/permission.php';

$page_title='Inventory | Create Invoice(RP)';

if ( isset($_POST['add_invoice']) ) {


  $current_date=date("Y-m-d");
  
  $db->where('retail_cus','1');
  $account=$db->getOne('tbl_customer');
  $cus_account=$account['cus_id'];
  $customer_name=$_POST['cus_name'];
  $invoice_date=$_POST['inv_date'];
  $customer_contact=$_POST['phone_num'];
  $customer_address=$_POST['cus_address'];
  
  $grand_total=$_POST['grand_total_price'];
  $total_discount=$_POST['flat_discount'];
  $total_perc_discount=$_POST['perc_discount'];
  $total_ammount_after_dis=$_POST['total_ammount_after_dis'];
  $paid_amount=$_POST['paid_amount'];
  $due_amount=$_POST['due_amount'];
  $inv_for=$_POST['inv_for'];
  $gst=$_POST['gst'];
  $wh_tax=$_POST['wh_tax'];



  

  $invoice_array=array( 
    "sale_type"=>'2',
    "cus_name"=>$cus_account,
    "re_cus_name"=>$customer_name,
    "re_cus_mobile"=>$customer_contact,
    "re_cus_address"=>$customer_address,
    "p_inv_date"=>$invoice_date,
    "grand_total"=>$grand_total,
    "grand_total_w_dis"=>$total_ammount_after_dis,
    "paid_amount"=>$paid_amount,
    "total_dis"=>$total_discount,
    "total_perc_dis"=>$total_perc_discount,
    "total_due"=>$due_amount,
    "inv_for"=>$inv_for,
    "gst"=>$gst,
    "wh_tax"=>$wh_tax,

  );

  $invoice_id=$db->insert('tbl_invoice',$invoice_array);
  $enc=encode($invoice_id);


  if($paid_amount > 0){
    SaleInvoiceEnteryNoPayment($db,$current_date,$invoice_id,$invoice_date,$total_ammount_after_dis);
    SaleInvoiceEnteryWithPayment($db,$current_date,$invoice_id,$invoice_date,$total_ammount_after_dis,$paid_amount,$cus_account);
    
  } else{
    SaleInvoiceEnteryNoPayment($db,$current_date,$invoice_id,$invoice_date,$total_ammount_after_dis);
  }


  

  $pro_id=$_POST['package_id'];
  $pro_name=$_POST['package_name'];
  $pro_quantity=$_POST['package_quantity'];
  $pro_rate=$_POST['package_rate'];
  $pro_dis_perc=$_POST['pro_dis_perc'];
  $pro_dis_flat=$_POST['pro_dis_flat'];
  $total_price=$_POST['total_price'];


  $total_pkg=count($pro_id);
  for ($i=0; $i < $total_pkg; $i++) { 

    if( $pro_id[$i] != '' ){
      $invoice_pkg_arr=array( 
        "inv_id"=>$invoice_id,
        "pro_id"=>$pro_id[$i],
        "pro_name"=>$pro_name[$i],
        "pro_qty"=>$pro_quantity[$i],
        "pro_rate"=>$pro_rate[$i],
        "perc_discount"=>$pro_dis_perc[$i],
        "flat_discount"=>$pro_dis_flat[$i],
        "total_price"=>$total_price[$i]
      );
      $db->insert('tbl_invoice_detail',$invoice_pkg_arr);
      RemoveStockQty($pro_id[$i],$pro_quantity[$i],$db);
    }
    
  }


  
  

  header("LOCATION:all-invoices.php");

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
  <!-- <link rel="stylesheet" href="<?php //echo baseurl('assets/vendors/select2/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?php //echo baseurl('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css'); ?>"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2.min.css" integrity="sha512-iVAPZRCMdOOiZWYKdeY78tlHFUKf/PqAJEf/0bfnkxJ8MHQHqNXB/wK2y6RH/LmoQ0avRlGphSn06IMMxSW+xw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2-bootstrap.min.css" integrity="sha512-eNfdYTp1nlHTSXvQD4vfpGnJdEibiBbCmaXHQyizI93wUnbCZTlrs1bUhD7pVnFtKRChncH5lpodpXrLpEdPfQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />



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




            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"> Invoice -RP</h4>
                  <form action=""  method="POST" class="form-sample">



                    <div class="row">
                      <div class="col-md-6 inv-col">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Customer Name</label>
                          <div class="col-sm-9">
                            <input type="text" name="cus_name" class="form-control form-control-sm">
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
                          <label class="col-sm-3 col-form-label">Mobile</label>
                          <div class="col-sm-9">
                            <input type="text" id="phone_num" name="phone_num" class="form-control form-control-sm" autocomplete="off">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 inv-col">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address</label>
                          <div class="col-sm-9">
                            <input type="text" id="cus_address" name="cus_address" class="form-control form-control-sm" autocomplete="off" >

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

                      <div class="col-md-6 inv-col">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Invoice For</label>
                          <div class="col-sm-9">
                            <select    name="inv_for" class="form-control form-control-sm"  >
                              <option value="" >Select </option>
                              <option value="mp_paint" >Madina Paint</option>
                              <option value="vhr_div" >Vehari Devision</option>
                            </select>

                          </div>
                        </div>
                      </div>
                    </div>











                    <div class="row slct-rw">
                      <div class="col-md-3">
                        <div class="form-group row">
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
                          $packages=$db->get('tbl_products pro',null,$cols);
                          ?>
                          <label>Select Products</label>
                          <select class="js-example-basic-single w-100">
                            <option value=""  >Select Product</option>
                            <?php
                            foreach($packages as $pac){
                             ?>
                             <option 
                             value="<?php echo $pac['pro_id']; ?>" 
                             product-code="<?php echo $pac['pro_code']; ?>"  
                             package-name="<?php echo $pac['pro_name']; ?>" 
                             package-price="<?php echo $pac['retail_price']; ?>" 
                             stock-qty=<?php echo $pac['pro_qty']; ?> 
                             cat-name="<?php echo $pac['cat_name']; ?>" 
                             brand-name="<?php echo $pac['brand_name']; ?>" 
                             unit-name="<?php echo $pac['unitname']; ?>" 
                             unit-qty="<?php echo $pac['unit_qty']; ?>" 
                             >

                              <?php echo $pac['pro_name'].' '.$pac['brand_name'].' '.$pac['cat_name'].' '.$pac['unit_qty'].' '.$pac['unitname'].' '.$pac['pro_code']; ?>  

                            </option>
                             <?php
                           } ?>
                          </select>
                        </div>

                      </div>


                      <div class="col-md-9">
                        <div class="table-responsive" >
                          <table class="table table-bordered table-hover" id="normalinvoice">
                            <thead>
                              <tr>
                                <th class="text-center">Product Name<i class="text-danger">*</i></th>

                                <th class="text-center">Quantity</th>
                                <th class="text-center">Rate <i class="text-danger">*</i></th>
                                <th class="text-center">Dis. % </th>
                                <th class="text-center">Dis. Flat </th>
                                <th class="text-center">Total </th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody id="addinvoiceItem">

                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="5" style="text-align:right;"><b>Sub Total:</b></td>
                                <td class="text-right" colspan="2" >
                                  <input id="grandTotal" class="form-control form-control-sm" name="grand_total_price" value="0.00" tabindex="-1"  type="number" readonly="">
                                </td>
                              </tr>
                              <tr>
                                <td style="text-align:right;" colspan="5"><b>Flat Discount:</b></td>
                                <td class="text-right" colspan="2">
                                  <input id="flat_discount" autocomplete="off" onkeyup="calculations();" class="form-control form-control-sm" name="flat_discount" tabindex="-1" value="0" type="number" >
                                </td>
                              </tr>
                              <tr>
                                <td style="text-align:right;" colspan="5"><b>% Discount:</b></td>
                                <td class="text-right" colspan="2">
                                  <input id="perc_discount" autocomplete="off" onkeyup="calculations();" class="form-control form-control-sm" name="perc_discount" tabindex="-1" value="0" type="number" >
                                </td>
                              </tr>
                              <tr>
                                <td style="text-align:right;" colspan="5"><b>GST:</b></td>
                                <td class="text-right" colspan="2">
                                  <input id="gst" autocomplete="off" onkeyup="calculations();" class="form-control form-control-sm" name="gst" tabindex="-1" value="0" type="number" >
                                </td>
                              </tr>

                              <tr>
                                <td style="text-align:right;" colspan="5"><b>WH Tax:</b></td>
                                <td class="text-right" colspan="2">
                                  <input id="wh_tax" autocomplete="off" onkeyup="calculations();" class="form-control form-control-sm" name="wh_tax" tabindex="-1" value="0" type="number" >
                                </td>
                              </tr>

                              <tr>
                                <td style="text-align:right;" colspan="5"><b>Grand Total:</b></td>
                                <td class="text-right" colspan="2">
                                  <input id="total_ammount_after_dis" class="form-control form-control-sm" name="total_ammount_after_dis" tabindex="-1" value="0.00" readonly="" type="number">
                                </td>
                              </tr>

                              <tr>
                                <td style="text-align:right;" colspan="5"><b>Paid Amount:</b></td>
                                <td class="text-right" colspan="2">
                                  <input id="paidAmount" autocomplete="off" class="form-control form-control-sm" name="paid_amount" onkeyup="invoice_paidamount();" value="0" value="" placeholder="0.00" tabindex="7" type="number">
                                </td>
                              </tr>
                              <tr>                               
                                <td style="text-align:right;" colspan="5"><b>Balance:</b></td>
                                <td class="text-right" colspan="2">
                                  <input id="dueAmmount" class="form-control form-control-sm" name="due_amount" value="0.00"  type="number" readonly="">
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
<!-- <script src="<?php //echo baseurl('assets/vendors/select2/select2.min.js'); ?>"></script>
<script src="<?php //echo baseurl('assets/js/select2.js'); ?>"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2.min.js" integrity="sha512-nwnflbQixsRIWaXWyQmLkq4WazLLsPLb1k9tA0SEx3Njm+bjEBVbLTijfMnztBKBoTwPsyz4ToosyNn/4ahTBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url('assets/js/jquery.scannerdetection.js'); ?>"></script>

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

  function calculations () {
    var subTotal            = 0
    var grand_total         = 0
    var tempResult          = 0
    var balance             = 0
    var flat_discount       = parseFloat( $("#flat_discount").val() );
    var percentage_discount = parseFloat($("#perc_discount").val()); 
    var gst                 = parseFloat( $("#gst").val() );
    var wh_tax              = parseFloat( $("#wh_tax").val() );
    var paidAmount          = parseFloat( $("#paidAmount").val() );



    $(".total_price").each(function(){
      subTotal += + parseFloat($(this).val());
    });
    tempResult = subTotal;
    //Flat Discount Calculation
    if (!flat_discount) { 
      flat_discount = 0;
      $("#perc_discount").removeAttr("readonly");
    }else{
      $("#perc_discount").attr("readonly", true);
      tempResult = subTotal - flat_discount; 
    }

    //Percentage Discount Calculation
    if (!percentage_discount) { 
      percentage_discount = 0;
      $("#flat_discount").removeAttr("readonly");
    }else{
      $("#flat_discount").attr("readonly", true);
      let discount_amount = (percentage_discount / 100) * subTotal;
      tempResult = subTotal - discount_amount;
    }


    //GST Calculation
    if (!gst) { gst = 0; }
    let temp1 = (gst / 100) * tempResult;
    let grandTemp1 = tempResult + temp1;

    //WH Tax Calculation
    if (!wh_tax) { wh_tax = 0; }
    let temp2 = (wh_tax / 100) * grandTemp1;
    grand_total = grandTemp1 + temp2;

    console.log('tempResult',grandTemp1,grand_total)

    $("#total_ammount_after_dis").val(Math.round(grand_total));

    balance = grand_total - paidAmount
    $("#dueAmmount").val(Math.round(balance));


  }

  function  FlatDiscount() {
    var total_price_update=0;
    var flat_discount=parseFloat( $("#flat_discount").val() );
    var gst = parseFloat( $("#gst").val() );
    if (!flat_discount || flat_discount == 0) { 
      flat_discount = 0;
      // $("#flat_discount").val(flat_discount);
      $("#perc_discount").removeAttr("readonly");
    }else{
      $("#perc_discount").attr("readonly", true);
    }
    $(".total_price").each(function(){
      total_price_update += + parseFloat($(this).val());
    });
    var grand_total=total_price_update
    
    var result=grand_total-flat_discount; 
    $("#total_ammount_after_dis").val(result);
    $("#grandTotal").val(grand_total);
    invoice_paidamount();
  }

  function  proflatDiscount(pro_id) {

    var flatDiscount = $("#pro_dis_flat"+pro_id+"").val();

    if (!flatDiscount || flatDiscount == 0) { 
      flatDiscount = 0;
      // $("#pro_dis_flat"+pro_id+"").val(flatDiscount);
      $("#pro_dis_perc"+pro_id+"").removeAttr("readonly");
    }else{
      $("#pro_dis_perc"+pro_id+"").attr("readonly", true);
    }

    var pro_qty=parseInt( $("#total_qty_"+pro_id+"").val() );
    var StockQty=parseInt( $("#stock_qty"+pro_id+"").val() );
    if(pro_qty < StockQty ){
      var pro_price=$("#item_price_"+pro_id+"").val();
      var new_total=parseFloat(pro_qty) * parseFloat(pro_price);
      var g_total=parseFloat(new_total) - parseFloat(flatDiscount);
      $("#total_price_"+pro_id+"").val(g_total);
      CalculateTotalAmount();
    } else{
      var pro_price=$("#item_price_"+pro_id+"").val();
      alert('Stock Quantity of This Product is '+StockQty+'');
      $("#total_qty_"+pro_id+"").val(StockQty);
      var new_total=parseFloat(StockQty) * parseFloat(pro_price);
      var g_total=parseFloat(new_total) - parseFloat(flatDiscount);
      $("#total_price_"+pro_id+"").val(g_total);
      CalculateTotalAmount();
    }
    calculations()
  }

  function percentageDiscount()
  {
    var total_price_update = 0;
    var percentage_discount = parseFloat($("#perc_discount").val()); 
    var gst = parseFloat( $("#gst").val() );
    if (!percentage_discount) { 
      percentage_discount = 0;
      // $("#perc_discount").val(percentage_discount) ;
      $("#flat_discount").removeAttr("readonly");
    }else{
      $("#flat_discount").attr("readonly", true);
    }
    $(".total_price").each(function () {
      total_price_update += +parseFloat($(this).val());
    });

    var grand_total = total_price_update;
    var discount_amount = (percentage_discount / 100) * grand_total;
    var result = grand_total - discount_amount;

    $("#total_ammount_after_dis").val(result);
    $("#grandTotal").val(grand_total);
    invoice_paidamount();
  }

  function proPercDiscount(pro_id)
  {
    var percentageDiscount = $("#pro_dis_perc"+pro_id+"").val(); // Assuming you have a field for percentage discount

    if (!percentageDiscount || percentageDiscount == 0) { 
      percentageDiscount = 0;
      // $("#pro_dis_perc"+pro_id+"").val(percentageDiscount);
      $("#pro_dis_flat"+pro_id+"").removeAttr("readonly");
    }else{
      $("#pro_dis_flat"+pro_id+"").attr("readonly", true);
    }
    

    var pro_qty = parseInt($("#total_qty_"+pro_id+"").val());
    var StockQty = parseInt($("#stock_qty"+pro_id+"").val());

    if (pro_qty < StockQty) {
      var pro_price = $("#item_price_"+pro_id+"").val();
      var new_total = parseFloat(pro_qty) * parseFloat(pro_price);
      
      // Calculate the discount amount based on the percentage
      var discountAmount = (parseFloat(percentageDiscount) / 100) * new_total;
      
      var g_total = new_total - discountAmount;
      
      $("#total_price_"+pro_id+"").val(g_total);
      CalculateTotalAmount();
    } else {
      var pro_price = $("#item_price_"+pro_id+"").val();
      alert('Stock Quantity of This Product is '+StockQty+'');
      $("#total_qty_"+pro_id+"").val(StockQty);
      
      var new_total = parseFloat(StockQty) * parseFloat(pro_price);
      
      // Calculate the discount amount based on the percentage
      var discountAmount = (parseFloat(percentageDiscount) / 100) * new_total;
      
      var g_total = new_total - discountAmount;
      
      $("#total_price_"+pro_id+"").val(g_total);
      CalculateTotalAmount();
    }
    calculations()
  }

  $("#cus_name").change(function(){
    var cus_id = $(this).children("option:selected").val();
    $.ajax({
      url:"../ajax/ajax-show-detail.php",
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
      var stockQty = $('option:selected', this).attr('stock-qty');
      var pac_name=$('option:selected', this).attr('package-name');
      var brand_name=$('option:selected', this).attr('brand-name');
      var cat_name=$('option:selected', this).attr('cat-name');
      var unit_qty=$('option:selected', this).attr('unit-qty');
      var unit_name=$('option:selected', this).attr('unit-name');

      var pro_full_name = pac_name + " " + brand_name + " " + cat_name + " " + unit_qty + " " + unit_name

      if ($('tr').hasClass('invoice-row'+pac_id+'')) {
        alert("This Product Already Added In Invoice");
      } else{



        $("#addinvoiceItem").append('<tr class="invoice-row'+pac_id+'"><td style="width: 500px"><input name="package_name[]"  class="form-control form-control-sm productSelection"  required="" value="'+pro_full_name+'" autocomplete="off" tabindex="1" type="text"><input type="hidden" class="autocomplete_hidden_value" value="'+pac_id+'" name="package_id[]" ></td><td style="width: 150px;"><input name="package_quantity[]" autocomplete="off" class="total_qty_1 form-control form-control-sm" id="total_qty_'+pac_id+'" onkeyup="quantity_calculate('+pac_id+');" value="1" required="" placeholder="0.00" tabindex="3" type="text"><input type="hidden" id="stock_qty'+pac_id+'" value="'+stockQty+'"/> </td><td style="width: 150px;"><input name="package_rate[]" value="'+pac_price+'" id="item_price_'+pac_id+'" class=" price_item form-control form-control-sm" tabindex="7" readonly="" type="text"></td><td style="width: 120px"><input class="pro_dis_perc form-control form-control-sm" name="pro_dis_perc[]" onkeyup="proPercDiscount('+pac_id+')" id="pro_dis_perc'+pac_id+'" tabindex="-1" type="number" min="0" value="0"></td><td style="width: 120px"><input class="pro_dis_flat form-control form-control-sm" name="pro_dis_flat[]" onkeyup="proflatDiscount('+pac_id+')" id="pro_dis_flat'+pac_id+'" tabindex="-1" type="number" min="0" value="0"></td><td style="width: 242px"><input class="total_price form-control form-control-sm" name="total_price[]" id="total_price_'+pac_id+'" value="'+pac_price+'" tabindex="-1" readonly="" type="text"></td><td><button  class="btn btn-danger btn-rounded btn-icon btn-del" type="button" onclick="deleteRow('+pac_id+')" value="Delete" tabindex="5"><i class="mdi mdi-delete"></i></button></td></tr>');

        
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
    var new_amount=0;
    var result_dis=0;
    var grandTotal = parseFloat( $("#total_ammount_after_dis").val() );
    var rece_amount=parseFloat( $("#paidAmount").val() );
    new_amount = grandTotal - rece_amount
    // var grandTotal = parseFloat( $("#grandTotal").val() );
    // var gst = parseFloat( $("#gst").val() );
    // var rece_amount=parseInt( $("#paidAmount").val() );
    // if (!rece_amount || rece_amount == 0) { 
    //   rece_amount = 0;
    //   $("#paidAmount").val(rece_amount);
    // }
    // $(".total_price").each(function(){
    //   grand_amount += + parseFloat($(this).val());
    // });
    // var flat_discount=parseFloat( $("#flat_discount").val() );
    // var perc_discount=parseFloat( $("#perc_discount").val() );
    // if (flat_discount || flat_discount > 0) { 
    //   result_dis=grand_amount-flat_discount;
    //   new_amount=result_dis - rece_amount;
    // }
    // else if(perc_discount || perc_discount > 0)
    // {
    // var discount_amount = (perc_discount / 100) * grand_amount;
    // result_dis  = grand_amount - discount_amount;
    // new_amount = result_dis - rece_amount;
    // }
    // else {
    //   new_amount = grand_amount - rece_amount
    // }
    // new_amount = new_amount+gst
    $("#dueAmmount").val(new_amount);

  }


  function quantity_calculate(pro_id){

    var pro_qty  = parseFloat($("#total_qty_"+pro_id+"").val());
    var StockQty = parseFloat($("#stock_qty"+pro_id+"").val()) ;
    
    if(!pro_qty)
    {
      pro_qty = 0
    }
      if(pro_qty <= StockQty ){
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
      var flatDiscount = $("#pro_dis_flat"+pro_id+"").val();
      if(flatDiscount > 0)
      {
        proflatDiscount(pro_id)
      }
      var percentageDiscount = $("#pro_dis_perc"+pro_id+"").val();
      if(percentageDiscount > 0)
      {
        proPercDiscount(pro_id)
      }
      calculations()
      console.log('-->',pro_qty,StockQty)
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
  function BarCodeSelectedProduct(pac_id,pac_price,stockQty,pac_name){


    if (pac_id != '') {




      if ($('tr').hasClass('invoice-row'+pac_id+'')) {
        alert("This Product Already Added In Invoice");
      } else{



        $("#addinvoiceItem").append('<tr class="invoice-row'+pac_id+'"><td style="width: 500px"><input name="package_name[]"  class="form-control form-control-sm productSelection"  required="" value="'+pac_name+'" autocomplete="off" tabindex="1" type="text"><input type="hidden" class="autocomplete_hidden_value" value="'+pac_id+'" name="package_id[]" ></td><td style="width: 150px;"><input name="package_quantity[]" autocomplete="off" class="total_qty_1 form-control form-control-sm" id="total_qty_'+pac_id+'" onkeyup="quantity_calculate('+pac_id+');" value="1" required="" placeholder="0.00" tabindex="3" type="text"><input type="hidden" id="stock_qty'+pac_id+'" value="'+stockQty+'"/> </td><td style="width: 150px;"><input name="package_rate[]" value="'+pac_price+'" id="item_price_'+pac_id+'" class=" price_item form-control form-control-sm" tabindex="7" readonly="" type="text"></td><td style="width: 242px"><input class="total_price form-control form-control-sm" name="total_price[]" id="total_price_'+pac_id+'" value="'+pac_price+'" tabindex="-1" readonly="" type="text"></td><td><button  class="btn btn-danger btn-rounded btn-icon btn-del" type="button" onclick="deleteRow('+pac_id+')" value="Delete" tabindex="5"><i class="mdi mdi-delete"></i></button></td></tr>');
        
        CalculateTotalAmount();
        
      }
    } else{
      var text='Please Select Valid Item!';
      showToast('error',text,'Notification');
    }

  }







</script>
<script >


  $('#scannerInput-new').scannerDetection({
    timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    avgTimeByChar: 100, // it's not a barcode if a character takes longer than 100ms
    onComplete: function(barcode, qty){



      var pro_id = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('value');
      console.log(pro_id);
      var pro_price = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('package-price');
      console.log(pro_price);
      var stock_qty = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('stock-qty');
      console.log(stock_qty);
      var pro_name = $(".js-example-basic-single option[product-code='"+barcode+"']").attr('package-name');
      console.log(pro_name);

      BarCodeSelectedProduct(pro_id,pro_price,stock_qty,pro_name);
      $('#scannerInput-new').val('');



    } // main callback function 
  });

</script>
</body>
</html>