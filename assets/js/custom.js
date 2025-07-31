

function DeletePurchaseReturn(clicked_id){
    var r = confirm(" Are You Sure To Delete This Purchase Return?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "all-purchase-return.php?del_id="+clicked_id; 
    } 
}

function DeleteSaleReturn(clicked_id){
    var r = confirm(" Are You Sure To Delete This Sale Return?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "all-sale-return.php?del_id="+clicked_id; 
    } 
}

function Remove_Unit(clicked_id){
    var r = confirm(" Are You Sure To Delete This Unit?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "units-list.php?del_id="+clicked_id; 
    } 
}


function DeletePackageInvoice(clicked_id,order_id){
    var r = confirm(" Are You Sure To Delete This Invoice?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "all-invoices.php?del_id="+clicked_id; 
    } 
}

function DeleteOrder(clicked_id){
  var r = confirm(" Are You Sure To Delete This Order?");
  if (r == true) { 
  var stateID = clicked_id;
  window.location = "all-sale-orders.php?del_id="+clicked_id; 
  }
}




function CashRecDeleteVoucher(clicked_id) {
  var r = confirm(" Are You Sure To Delete This CashReceived Voucher?");
  if (r == true) { 
  var stateID = clicked_id;
  window.location = "all-cash-received.php?del_id="+clicked_id; 
  }  
}

function CashDeleteVoucher(clicked_id) {
  var r = confirm(" Are You Sure To Delete This CashPayment Voucher?");
  if (r == true) { 
  var stateID = clicked_id;
  window.location = "all-cash-payment.php?del_id="+clicked_id; 
  }  
}

function DeletePurchaseInvoice(clicked_id){
  var r = confirm(" Are You Sure To Delete This Invoice?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "purchase-invoices.php?del_id="+clicked_id; 
    }

}

function Remove_Supplier(clicked_id){
    var r = confirm(" Are You Sure To Delete This Supplier?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "supplier-list.php?del_id="+clicked_id; 
    } 
}

function Remove_ExpenseType(clicked_id){
    var r = confirm(" Are You Sure To Delete This Expense Type?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "exp-type-list.php?del_id="+clicked_id; 
    } 
}

function Remove_AssetsType(clicked_id){
    var r = confirm(" Are You Sure To Delete This Asset Type?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "assets-type-list.php?del_id="+clicked_id; 
    } 
}

function Remove_Asset(clicked_id){
    var r = confirm(" Are You Sure To Delete This Asset ?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "all-assets-list.php?del_id="+clicked_id; 
    } 
}

function Remove_Expense(clicked_id){
    var r = confirm(" Are You Sure To Delete This Expense?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "all-exp-list.php?del_id="+clicked_id; 
    } 
}

function RemoveEmp(clicked_id){
    var r = confirm(" Are You Sure To Delete This Employee?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "employees-list.php?del_id="+clicked_id; 
    } 
}

function Remove_customer(clicked_id){
    var r = confirm(" Are You Sure To Delete This Customer?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "customer-list.php?del_id="+clicked_id; 
    } 
}

function RemoveMeterial(clicked_id){
    var r = confirm(" Are You Sure To Delete This Product Domain?");
    if (r == true) { 
    var stateID = clicked_id;
    window.location = "product-domain-list.php?del_id="+clicked_id; 
    } 
}
function showToast(type,text,heading) {
     resetToastPosition();
    $.toast({
      heading: heading,
      text: text,
      showHideTransition: 'slide',
      icon: type,
      loaderBg: '#f96868',
      position: 'top-right',
      hideAfter: 5000
    })
  };

  resetToastPosition = function() {
    $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
    $(".jq-toast-wrap").css({
      "top": "",
      "left": "",
      "bottom": "",
      "right": ""
    }); //to remove previous position style
  }









