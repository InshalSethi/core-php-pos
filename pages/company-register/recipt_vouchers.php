<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';

    if (isset($_REQUEST['id'])) {
    $x=$_REQUEST['id'];
    if ( $x != '') {

    $db->where("id",$x);
    $recpt_data = $db->getOne('recipt_voucher');
    $acc_id = $recpt_data['account_id'];
    $recp_amount = $recpt_data['amount'];

    $db->where("id",$acc_id);
    $account_data = $db->getOne('account');
    $balance = $account_data['balance'];

    $new_balance = $balance - $recp_amount;

    $up_acc = array("balance"=>$new_balance);
    $db->where("id",$acc_id);
    $account_updated = $db->update("account",$up_acc);
     

    $db->where("recp_id",$x);
    $db->delete('transactions');

    $db->where("id",$x);
    $db->delete('recipt_voucher');
    ?>
<script>
  window.location.href="recipt_vouchers.php";
</script>
<?php
    }      
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MAC | Receipt</title>
    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>
    <link rel="stylesheet" href="<?php echo baseurl('assets/css/vertical-layout-light/jquery-ui.css');?>">

  </head>
  <style>
  .free-cus{
      color:blue;
  }
  .cus-inactive{
      color:red;
  }
  .today-hear{
      background-color:#6da252!important;
      color: white;
  }
  .td1-set{
  padding: 5px!important;
  font-size: 13px!important;
  
    }
  .inactive-alert{
      display:none; 
  }
  .ui-autocomplete{
    z-index: 9999999999!important;
  }
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
    .set-drop{
        height: 31px;
        margin-top: 1px;
    }
    .set-drop1{
        height: 34px;
        margin-top: 1px;
    }
    .set-card-body{
          padding-left: 10px!important;
          padding-right: 10px!important;
    }
    .set-mr-btm{
      margin-bottom: 10px;
    }
    .no-mar-btm{
      margin-bottom: 0px!important;
    }
    .clr{
      color: white!important;
    }
    .advance-search-main{
      background: #ecf0f8;
      padding: 5px;
      margin-bottom: 5px;
      border-radius: 5px;
      box-shadow: 0 2px 2px 0 rgba(92, 59, 196, 0.14), 0 3px 1px -2px rgba(92, 59, 196, 0.2), 0 1px 5px 0 rgba(92, 59, 196, 0.12);
    }
    .advance-search-row{
      margin-bottom: 5px;
    }
    .advance-lable-padding{
      padding: 0px!important;
    }
    .advance-input-padding{
      padding: 5px!important;
    }
    .advance-search-radio{
      margin-left: 25px;
      margin-top: 5px;
    }
    .no-side-padding{
      padding-left: 0px!important;
      padding-right: 0px!important;
    }
    .no-side-padding-first{
      padding-right: 0px!important;
    }
    .no-side-padding-last{
      padding-left: 0px!important;
    }
    @media only screen and (min-width: 320px) and (max-width: 480px){
      .no-side-padding{
      padding-left: 15px!important;
      padding-right: 15px!important;
    }
    .no-side-padding-first{
      padding-right: 15px!important;
      padding-left: 15px!important;
    }
    .no-side-padding-last{
      padding-right: 15px!important;
      padding-left: 15px!important;
    }
    }
  </style>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
 <?php include '../../libraries/nav.php'; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        <?php include '../../libraries/sidebar.php'; ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 set-mr-btm">
                <h4 class="card-title">Receipt</h4>
                <button class="btn btn-success btn-mac" onclick="
                window.location.href='add-receipt-voucher.php'"><i class="mdi mdi-plus"></i> Add New</button>
                <a class="btn btn-success btn-mac" id="receipt-vou-filters"><i class="mdi mdi-magnify"></i> Search</a>
              </div> 
              <div class="col-lg-12">
                <div class="card card-border-color">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="advance-search-main">
                          <form>
                            <div class="row advance-search-row">
                              <div class="col-md-2 no-side-padding-first">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <input  type="text" id="voucher_no_adsr" name="voucher_no_adsr" class="form-control" placeholder="Voucher No." />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <input type="text" id="" name="" class="form-control" placeholder="" />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <select class="form-control set-drop" id="receivedin_adsr">
                                              <option value="">Received In</option>
                                              <?php 
                                                $account_data = $db->get('account');
                                                foreach ($account_data as $ac_data) {
                                                    
                                                  $account_id = $ac_data['id'];
                                                  $acc_account_name = $ac_data['name'];
                                                  $acc_bank = $ac_data['bank_name'];
                                                  $acc_account_number = $ac_data['account_number'];
                                                  $acc_balance = $ac_data['balance'];
                                                  
                                                 ?>
                                                 <option value="<?php echo $account_id; ?>"><?php echo $acc_account_name.' - '.$acc_bank.' - '.$acc_account_number.'  ('.number_format($acc_balance).') '; ?></option>
                                               <?php } ?>
                                              
                                          </select>
                                          
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <input type="text" id="recipient_name" name="recipient_name" class="form-control recipient_name" placeholder="Recipient Name" />
                                          
                                      </div>
                                    </div>
                                  </div>
                              </div> 
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <input type="text" id="amount_from_adsr" name="amount_from_adsr" class="form-control" placeholder="Amount From" />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding-last">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <div class="input-group">
                                          <input type="text" id="amount_to_adsr" name="amount_to_adsr" class="form-control" placeholder="Amount To" />
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <div class="row advance-search-row">
                              <div class="col-md-2 no-side-padding-first">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <label class="col-form-label advance-lable-padding no-mar-btm">Date From</label>
                                      <div class="input-group">
                                          <input type="date" id="date_from_adsr" name="date_from_adsr" class="form-control advance-input-padding" placeholder=""/>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-2 no-side-padding">
                                  <div class="form-group row no-mar-btm">
                                    <div class="col-sm-12">
                                      <label class="col-form-label advance-lable-padding no-mar-btm">Date to</label>
                                      <div class="input-group">
                                          <input type="date" id="date_to_adsr" name="date_to_adsr" class="form-control advance-input-padding" placeholder=""/>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="table-responsive">
                          <table id="order-listing" class="table">
                            <thead>
                              <tr>
                                  <th class="th-set text-center">Voucher No.</th>
                                  <th class="th-set text-center">Date</th>
                                  <th class="th-set text-center">Recipient Name</th>
                                  <th class="th-set text-center">Detail</th>
                                  <th class="th-set text-center">Received In</th>
                                  <th class="th-set text-center">Amount</th>
                                  <th class="th-set text-center">Actions</th>
                              </tr>
                            </thead>
                            <tbody class="table-body">
                                      
                                <?php
                                    $recipt_voucherdata = $db->get("recipt_voucher");
                                    foreach ($recipt_voucherdata as $recipt_voucher) {
                                    $recipt_voucher_id = $recipt_voucher['id'];
                                    $encrypt = encode($recipt_voucher_id);
                                    $recipt_voucher_vo = $recipt_voucher['voucher'];
                                    $recipt_voucher_recipient_name = $recipt_voucher['recipient_name'];
                                    $recipt_voucher_acc = $recipt_voucher['account_number'];
                                    $recipt_voucher_payment_date = $recipt_voucher['payment_date'];
                                    $recipt_voucher_description = $recipt_voucher['description'];
                                    $recipt_voucher_amount = $recipt_voucher['amount'];
                                ?>
                                <tr>
                                  <td class="td1-set text-center"><?php echo $recipt_voucher_vo;?></td>
                                  <td class="td1-set text-center"><?php echo date("d-m-Y", strtotime($recipt_voucher_payment_date)); ?></td>
                                  <td class="td1-set text-center"><?php echo $recipt_voucher_recipient_name; ?></td>
                                  <td class="td1-set text-center"><?php echo $recipt_voucher_description; ?></td>
                                  <td class="td1-set text-center"><?php echo $recipt_voucher_acc; ?></td>
                                  <td class="td1-set text-center"><?php echo number_format($recipt_voucher_amount); ?></td>
                                  <td class="td1-set text-center">
                                    <div class="dropdown">
                                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                                        <a class="dropdown-item" onclick="viewmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#viewModal"><i class="mdi mdi-eye text-dark"></i>View</a>
                                        <a class="dropdown-item" onclick="editmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#exampleModal"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" onclick="myFunction('<?php echo $recipt_voucher_id; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                                      </div>
                                    </div>
                                  </td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Edit-->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Receipt</h5>
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
                          <!--<div id="inactive-alert" class="alert alert-danger inactive-alert">-->
                          <!--  Selected Account Is Inactive! -->
                          <!--</div>-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="edit-receipt-file">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- View -->
                <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">View Receipt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="view-receipt-voucher-file">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <?php include '../../libraries/footer.php'; ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <?php include '../../libraries/js_libs.php'; ?>
  </body>
  <script>
        function SetDataTable() {
    	
    	$('#order-listing').DataTable({
	      "aLengthMenu": [
	        [50, 100, 150, -1],
	        [50, 100, 150, "All"]
	      ],
	      "iDisplayLength": 50,
	      "language": {
	        search: ""
	      }
    	});

	    $('#order-listing').each(function() {
	      var datatable = $(this);
	      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
	      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
	      search_input.attr('placeholder', 'Search');
	      search_input.removeClass('form-control-sm');
	      // LENGTH - Inline-Form control
	      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
	      length_sel.removeClass('form-control-sm');
	    });
    	
        }
        var paid_from;
        $("#paid_from_adsr").change(function(){
        paid_from = $(this).children("option:selected").val();
        
        });
        
  
    $("#receipt-vou-filters").click(function(){

            var voucher_no=$("#voucher_no_adsr").val();
            
            var receivedin_adsr =$("#receivedin_adsr").val();
            
            var recipient_name=$("#recipient_name").val();
            
            var amount_from=$("#amount_from_adsr").val();
           
            var amount_to=$("#amount_to_adsr").val();
            
            var date_from=$("#date_from_adsr").val();
            
            var date_to=$("#date_to_adsr").val();
            


            $.ajax({
                type: "POST",
                url: "../../libraries/ajaxsearch.php",
                data: { 
                        voucher_no:voucher_no,
                        receivedin_adsr:receivedin_adsr,
                        recipient_name:recipient_name,
                        amount_from:amount_from,
                        amount_to:amount_to,
                        date_from:date_from,
                        date_to:date_to,
                        action:'receipt_vou_search',
                        authkey:'dabdsjjI81sa'
                },
                cache: false,
                success: function(result){
                    
                    $(".table").remove();
                    $(".table-responsive").html(result);
                    
                    
                    
                }
                
                
                
            });
          
          
          
         
          
            
            
            
            
            
            
        
        
        });
  
  
    function myFunction(clicked_id) {
    var txt;
    var r = confirm(" Are you sure you want to delete this receipt voucher data ?");
    if (r == true) { 
    txt = "You pressed OK!";
    
    var stateID = clicked_id;
    
    
    window.location = "recipt_vouchers.php?id="+clicked_id; 
    
    } else {
    
    
    }
    
    }
    ///////view
    function viewmodal(id){
      $.ajax({
      type: "POST",
      url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
      data: {receipt_id_view:id,action:'view_receipt_modal',authkey:'dabdsjjI81sa'},
      cache: false,
      success: function(viewresult){
      $('.view-receipt-voucher-file').html(viewresult);
      
      }
      });
    }
    //////////edit
    function editmodal(id){
      $.ajax({
      type: "POST",
      url: '<?php echo baseurl('libraries/ajaxsubmit.php'); ?>',
      data: {receipt_edit_id:id,action:'edit_receipt_modal',authkey:'dabdsjjI81sa'},
      cache: false,
      success: function(result){
      $('.edit-receipt-file').html(result);
      autofetch();
      
      }
      });
    }
    function edit_receipt(){
      $("#editreceipt").submit(function(){
        var voucher_id = $(".voucher_id").val();
        var voucher_nofield = $(".voucher_nofield").val();
        var account_balance_old = $(".account_balance_old").val();
        var account_balance = $(".account_balance").val();
        var account_number = $(".account_number").val();
        var account_id_old = $(".account_id_old").val();
        var acc_id = $(".acc_num").val();
        var payment_datefield = $(".payment_datefield").val();
        var recipient_namefield = $(".recipient_namefield").val();
        var receipt_des = $(".receipt_des").val();
        var receipt_amount_pre = $(".receipt_amount_pre").val();
        var receipt_amount = $(".receipt_amount").val();
    
        var ary_receipt = [];
    
        ary_receipt.push({
    
           authkey:'dabdsjjI81sa',
           action:'edit_form_receipt',
           voucher_id:voucher_id,
           voucher_nofield:voucher_nofield,
           account_balance_old:account_balance_old,
           account_balance:account_balance,
           account_number:account_number,
           account_id_old:account_id_old,
           acc_id:acc_id,
           payment_datefield:payment_datefield,
           recipient_namefield:recipient_namefield,
           receipt_des:receipt_des,
           receipt_amount_pre:receipt_amount_pre,
           receipt_amount:receipt_amount
      });
        // AJAX Code To Submit Form.
        $.ajax({
        type: "POST",
        url: "../../libraries/ajaxsubmit.php",
        data: {receipt_edit_data:ary_receipt},
        cache: false,
        success: function(result){
        $(".receipt-success").html("<div class='alert alert-success' id='success' role='alert'>Receipt Voucher Data Updated Successfully .</div>");
        $("#success").fadeTo(2500, 500).slideUp(500, function(){
        $("#success").slideUp(500);
        $("#success").remove();
        setTimeout(function(){
          $('#exampleModal').modal('toggle')
        }, 3000);

        });
        }
        });
      return false;
    
      });
      }
  ///
    function autofetch(){
    $('.acc_num').change(function() {
    var acc_num = $(".acc_num option:selected").val();
    if(acc_num) {
      $(".no-loader").show();
      setTimeout(function(){
        $.ajax({

            url: "<?php echo baseurl('libraries/ajaxsubmit.php'); ?>",
            type: "POST",

            dataType: 'json',

            data: {acc_num:acc_num,action:'find_account',authkey:'dabdsjjI81sa'},

            success: function(result) { 

            var obj = JSON.parse(JSON.stringify(result));
            
             $('.account_balance').val(obj[0].balance);
             $('.account_number').val(obj[0].account_number);
             

            },
            complete:function(data){
              
              $(".no-loader").hide();
             },
            
        });
     },1000);
    }
  });
  
  }
</script>
</html>