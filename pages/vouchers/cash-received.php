<?php 
  include '../../include/functions.php';
  include '../../include/MysqliDb.php';
  include '../../include/config.php';
  include '../../include/permission.php';

$page_title='Inventory | Cash Received';

if ( isset($_POST['add_package']) ) {

  $vou_date=$_POST['vou_date'];
  $customer_id=$_POST['customer_id'];
  $customer_name=$_POST['customer_name'];
  $amount=$_POST['amount'];
  $bank_account=$_POST['account_id'];
  $note=$_POST['payment_note'];

  CashReceivedVoucherJV($db,$customer_id,$amount,$vou_date,$bank_account,$note);

  

  // header("LOCATION:edit-invoice.php?in=$enc");

}


function CheckBalanceCustomer($cus_id,$db){
    $total_received=0;
    $total_receiveAble=0;
    $Balance=0;
    $data = $db->rawQuery("SELECT inv_id as invoice_id,p_inv_date as date,paid_amount as received_amount,grand_total_w_dis as total_amount,CASE WHEN inv_id != '' THEN 'SALE' END as status FROM tbl_invoice WHERE cus_name='$cus_id' UNION ALL SELECT inv_id as invoice_id,p_inv_date as date,grand_total_w_dis as received_amount,CASE WHEN inv_id != '' THEN grand_total_w_dis END as total_amount,CASE WHEN inv_id != '' THEN 'SALE_RETURN' END as status FROM tbl_salereturn_invoice WHERE cus_name='$cus_id' UNION ALL SELECT id as invoice_id,date as date,amount as received_amount,CASE WHEN id != '' THEN amount END as total_amount,CASE WHEN id != '' THEN 'CASH_RECEIVED' END as status FROM client_payments WHERE client_id='$cus_id' AND invoice_id IS NULL ");
    //echo "----".$db->getLastQuery();
    //var_dump($data);

    foreach($data as $da){ 
      if($da['status'] == 'SALE'){

        $total_receiveAble+=$da['total_amount'];
        $total_received+=$da['received_amount'];
      } 
      if ($da['status'] == 'CASH_RECEIVED') {
        $total_received+=$da['received_amount'];
      }
      if($da['status'] == 'SALE_RETURN'){
        $total_received+=$da['received_amount'];
      }

    }

    $Balance=$total_receiveAble-$total_received;
    return (int)$Balance;

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
    <link rel="stylesheet" href="<?php echo base_url('assets/vendors/select2/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css'); ?>">
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
        
  <div class="main-panel" style="width: 100%;">        
  <div class="content-wrapper" style="padding: 0px 0px;">
    <div class="row">
            
            
            
            
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Cash Received Voucher</h4>
        <form action=""  method="POST" class="form-sample">
        <div class="row">
          <div class="col-md-6 inv-col">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Date</label>
              <div class="col-sm-9">
              <input type="date" value="<?php echo date("Y-m-d"); ?>"  name="vou_date" class="form-control form-control-sm" required  >
              </div>
            </div>
          </div>
          <div class="col-md-6 inv-col">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Note</label>
              <div class="col-sm-9">
                <textarea rows="3" name="payment_note" class="form-control form-control-sm" ></textarea>
              
              </div>
            </div>
          </div>
        </div>

    


    <div class="row slct-rw" style="margin-top: 50px;">
      <div class="col-md-4">
        <div class="form-group row">
          <label>Account Name</label>
          <select class="js-example-basic-single w-100">
            <option value=""  >Select Account</option>
            <?php
            $db->where('cus_type','1');
            $customer=$db->get('tbl_customer');
            foreach($customer as $cus){

            ?>

                <option value="<?php echo $cus['cus_id']; ?>" cus-name="<?php echo $cus['cus_name']; ?>" ><?php echo $cus['cus_name']; ?>  (<?php echo $cus['cus_city']; ?>) ( <?php echo CheckBalanceCustomer($cus['cus_id'],$db); ?>) </option>


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
                  <th class="text-center">Account Title</th>
                  <th class="text-center">Received IN</th>
                  <th class="text-center">Amount (Rs)</th>
                  
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody id="addinvoiceItem">
                
              </tbody>

              <tfoot>
                <tr>
                  <td colspan="2" style="text-align:left;"><b>Grand Total:</b></td>
                  <td class="text-right" colspan="1 " >
                      <input id="grandTotal" class="form-control form-control-sm" name="grand_total_price" value="0.00" tabindex="-1" readonly="" type="text">
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
            <input class="btn btn-primary" name="add_package"  type="submit" value="Create Cash Received Voucher">
            
          </div>
        </div>
      </div>


                    

                    
                    
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        
    <?php 
      $dropDown='<select class=" form-control form-control-sm" name="account_id" required ><option value="">Paid From</option>';
      $account_data = $db->get('account');
      foreach ($account_data as $ac_data) {
          
        $account_id = $ac_data['id'];
        $acc_account_name = $ac_data['name'];
        $acc_bank = $ac_data['bank_name'];
        $acc_account_number = $ac_data['account_number'];
        $acc_balance = $ac_data['balance'];
        $Opening_balance = $ac_data['opening_balance'];
        $cols=array("acc.account_number","trs.category","trs.amount",);
        $db->where("acc.id", $account_id);
        $db->join("account acc", "trs.account=acc.id", "INNER");
        $transfersdata = $db->get("transactions trs",null,$cols);
        $Balance = 0;
        foreach($transfersdata as $transfers){
          if($transfers['category'] == 'sale invoice'){
                // $receipt = 'Income';
                $receipt = $transfers['amount'];
                $Balance += $receipt;
            }else{
                $receipt = '';
            }

            if($transfers['category'] == 'receipt voucher'){
                // $receipt = 'Income';
                $receipt = $transfers['amount'];
                $Balance += $receipt;
            }else{
                $receipt = '';
            }

            if($transfers['category'] == 'payment voucher'){
                $payments = $transfers['amount'];
                $Balance -= $payments;
            }else{
                $payments = '';
            }

            if($transfers['category'] == 'Expense'){
                // $payments = 'Expense';
                $payments = $transfers['amount'];
                $Balance -= $payments;
            }else{
                $payments = '';
            }

            if($transfers['category'] == 'purchase invoice'){
                // $payments = 'Expense';
                $payments = $transfers['amount'];
                $Balance -= $payments;
            }else{
                $payments = '';
            }

            if($transfers['category'] == 'Funds Transfer From'){
              
                $transferAmountFrom = $transfers['amount'];
                $Balance -= $transferAmountFrom;
            }else{
                $transferAmountFrom = '';
            }

            if ($transfers['category'] == 'Funds Transfer To') {

                $transferAmount = $transfers['amount'];
                $Balance += $transferAmount;
            }else{
                $transferAmount = '';
            }
        }
        $CurrentBalance = $Balance + $Opening_balance;
        $string='<option value="'.$account_id.'">'.$acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.' ( '.$CurrentBalance.' )</option>';
        $dropDown.=$string;
        } 

        $dropDown.='</select> ';

        ?>
    

        
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
  <script src="<?php echo base_url('assets/vendors/select2/select2.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/select2.js'); ?>"></script>
  <script>


    var dropDown='<?php echo $dropDown; ?>';

    $(".js-example-basic-single").change(function(){

      var cus_id = $(this).children("option:selected").val();
      if( cus_id != '' ){

        var cus_name = $('option:selected', this).attr('cus-name');
        if ($('tr').hasClass('invoice-row'+cus_id+'')) {
          alert("This Account Already Added In Voucher!");
        } else{

          if( $('tr').hasClass('cash-payment') ){
            alert("You Can Create One Client Payment!");
          } else{

          

        $("#addinvoiceItem").append('<tr class="invoice-row'+cus_id+' cash-payment"><td style="width: 250px"><input name="customer_name"  class="form-control form-control-sm productSelection" placeholder="Products" required="" id="product_name" value="'+cus_name+'" autocomplete="off" tabindex="1" type="text" readonly ><input type="hidden" class="autocomplete_hidden_value " value="'+cus_id+'" name="customer_id" id="product_id"></td><td style="width: 260px;">'+dropDown+'</td><td style="width: 130px;"><input name="amount" value="0"  class="total_price form-control form-control-sm" id="amount_'+cus_id+'" onkeyup="GetAmount('+cus_id+')" tabindex="7"  type="text"></td><td><button  class="btn btn-danger btn-rounded btn-icon btn-del" type="button" onclick="deleteRow('+cus_id+')" value="Delete" tabindex="5"><i class="mdi mdi-delete"></i></button></td></tr>');

        // calculate the grand total
        $(".select2-search__field").val('');
        CalculateTotalAmount();
        }

        }

        } else{
          alert("Please Select A Valid Account!");
         }


    });

    function GetAmount(cus) {
      CalculateTotalAmount();
    }

    function CalculateTotalAmount(){

      var total_price_update=0;
      $(".total_price").each(function(){
          total_price_update += + parseFloat($(this).val());
      });
      $("#grandTotal").val(total_price_update);

    }

   


     function deleteRow(rem_id) {

      $(".invoice-row"+rem_id+"").remove();
      $(".js-example-basic-single").select2("open");
      CalculateTotalAmount();
      
    }


    

  </script>
  </body>
</html>