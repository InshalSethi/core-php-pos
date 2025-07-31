<?php 
$main_site = 'https://clubroad.madinapaints.com/';
define ('WP_HOME',$main_site);



function baseurl($ur){
   $url=WP_HOME.$ur;
   return $url;
}
function base_url($ur){
   $url=WP_HOME.$ur;
   return $url;
}

function CheckPermission($data,$search){
  
  foreach($data as $da){
    if($da['name']==$search){
      $is_found=1;
      break;
    } else{
      $is_found=0;
    }

  }
  return $is_found;
}




function GetProductSupplierDetail($pro_id,$db){
    
    $data=array();
    
    $invoiceData = $db->rawQueryOne("SELECT MIN(supplier_price) as price,pur_in_id FROM tbl_purchase_invoice_pro WHERE pro_id='".$pro_id."'");
    $data['price']=$invoiceData['price'];
    if($invoiceData['pur_in_id'] != ''){
        
        $db->where('pur_in_id',$invoiceData['pur_in_id']);
        $supplierId=$db->getValue('tbl_purchase_invoice','supplier_id');
        
        
        $db->where('cus_id',$supplierId);
        $supData=$db->getOne('tbl_customer');
        
        
        $data['sup_name']=$supData['cus_name'];
        $data['contact']=$supData['cus_mobile'];
        
    } else{
        
        $data['price']='';
        $data['sup_name']='';
        $data['contact']='';
        
    }
    
    
    return $data;
    
    
}


function GetAccountBalance($account_id,$openingBalance,$db){
    
    $CurrentBalance = 0;
    $TotalBalance = 0;
    
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
    $CurrentBalance = $Balance + $openingBalance;
    $TotalBalance += $CurrentBalance;
    
    return $CurrentBalance;
    
    
}

function GetBarCode($db){

  $randon_num=rand(1111111,9999999);

    $db->where('pro_code',$randon_num);
    $pro_code=$db->getOne('tbl_products');

    if ( !empty($pro_code) ) {
      
      GetBarCode($db);
    } 
    else{

      return $randon_num;
    }

}


function DeleteCashReceived_Voucher($db,$clientPayID){

  $db->where('client_payment',$clientPayID);
  $data=$db->get('journal_tbl');
  foreach($data as $ja){
    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_meta');
  }

  $db->where('client_payment',$clientPayID);
  $db->delete('journal_tbl');

  $db->where('client_pay_id',$clientPayID);
  $db->delete('transactions');

  $db->where('id',$clientPayID);
  $db->delete('client_payments');



}


function DeleteCashPayment_Voucher($db,$SupplierPayID){

  $db->where('supplier_payment_id',$SupplierPayID);
  $data=$db->get('journal_tbl');
  foreach($data as $ja){
    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_meta');
  }

  $db->where('supplier_payment_id',$SupplierPayID);
  $db->delete('journal_tbl');

  $db->where('supplier_payment_id',$SupplierPayID);
  $db->delete('transactions');

  $db->where('id',$SupplierPayID);
  $db->delete('supplier_payments');



}

function EditCashReceivedVoucherJV($ClientPayID,$db,$clientID,$amount,$vou_date,$bank_account,$note){


  $current_date=date("Y-m-d");
  $coaID=GetCOA_Account($db,$bank_account);
  $paymentArray=array(  
                        'account_id'=>$bank_account,
                        'payment_note'=>$note,
                        'date'=>$vou_date,
                        'amount'=>$amount,
                        'updated_at'=>$current_date
                      );
  $db->where('id',$ClientPayID);
  $db->update('client_payments',$paymentArray);


  $transactions_array=array(
                            
                            'account'=>$bank_account,
                            'date'=>$vou_date,
                            'amount'=>$amount,
                            'updated_at'=>$current_date
                            );
  $db->where('client_pay_id',$ClientPayID);
  $db->update('transactions',$transactions_array);

  // linking of sale invoice with payment
  $journal_tbl_arr=array(
                      'date'=>$vou_date,
                      'total_debit'=>$amount,
                      'total_credit'=>$amount,
                      'updated_at'=>$current_date
                    );
  $db->where('client_payment',$ClientPayID);
  $db->update('journal_tbl',$journal_tbl_arr);


  $db->where('client_payment',$ClientPayID);
  $Jdata=$db->getOne('journal_tbl');
  $jId=$Jdata['j_id'];

  $db->where('id',"1");
  $GlSale = $db->getOne("gl_sales_default");
  $COARece = $GlSale['receivable_acc'];

  //meta credit entry only sale invoice
  //Get JVMeta Data for first entry
  $db->where('j_id',$jId);
  $db->orderBy ("jm_id","asc");
  $JvMetaOldDataCli1 = $db->getOne("journal_meta");
  $JmId1 = $JvMetaOldDataCli1['jm_id'];

  $journal_metaDebit = array( 
                        'chrt_id'=>$coaID,
                        'debit'=>$amount,
                        'updated_at'=>$current_date,
                      );
  $db->where('jm_id',$JmId1);
  $db->update('journal_meta',$journal_metaDebit);

  // meta debit entry on sale invoice

  //Get JVMeta Data for second entry
  $db->where('j_id',$jId);
  $db->orderBy ("jm_id","desc");
  $JvMetaOldDataCli2 = $db->getOne("journal_meta");
  $JmId2 = $JvMetaOldDataCli2['jm_id'];

  $journal_metaCredit = array( 
                        'chrt_id'=>$COARece,
                        'credit'=>$amount,
                        'updated_at'=>$current_date,
                      );
  $db->where('jm_id',$JmId2);
  $db->update('journal_meta',$journal_metaCredit);



}


function CashReceivedVoucherJV($db,$clientID,$amount,$vou_date,$bank_account,$note){

  $current_date=date("Y-m-d");
  $coaID=GetCOA_Account($db,$bank_account);
  $paymentArray=array(  'client_id'=>$clientID,
                        'payment_note'=>$note,
                        'account_id'=>$bank_account,
                        'date'=>$vou_date,
                        'amount'=>$amount,
                        'created_at'=>$current_date
                      );
  $ClientPayID=$db->insert('client_payments',$paymentArray);

  $transactions_array=array(
                            
                            'client_pay_id'=>$ClientPayID,
                            'client_id'=>$clientID,
                            'account'=>$bank_account,
                            'category'=>'receipt voucher',
                            'date'=>$vou_date,
                            'amount'=>$amount,
                            'created_at'=>$current_date
                            );
  $db->insert('transactions',$transactions_array);

  // linking of sale invoice with payment
  $vocherNum=GetJvVocherNum($db);
  $journal_tbl_arr=array(
                      'gl_type'=>'3',
                      'voucher_no'=>$vocherNum,
                      'client_payment'=>$ClientPayID,
                      'date'=>$vou_date,
                      'total_debit'=>$amount,
                      'total_credit'=>$amount,
                      'created_at'=>$current_date
                    );
  $jId=$db->insert('journal_tbl',$journal_tbl_arr);

  $db->where('id',"1");
  $GlSales = $db->getOne("gl_sales_default");
  $COARece = $GlSales['receivable_acc'];

  //meta credit entry only sale invoice
  $journal_metaDebit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$coaID,
                        'debit'=>$amount,
                        'created_at'=>$current_date,
                      );
  $JVSalesDebit =$db->insert('journal_meta',$journal_metaDebit);

  // meta debit entry on sale invoice
  $journal_metaCredit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$COARece,
                        'credit'=>$amount,
                        'created_at'=>$current_date,
                      );
  $JVSalesCredit =$db->insert('journal_meta',$journal_metaCredit);

}


function EditCashPaymentVoucherJV($SupplierPayID,$db,$clientID,$amount,$vou_date,$bank_account,$note){

  $current_date=date("Y-m-d");
  $coaID=GetCOA_Account($db,$bank_account);
  $paymentArray=array(  
                        'account_id'=>$bank_account,
                        'date'=>$vou_date,
                        'amount'=>$amount,
                        'payment_note'=>$note,
                        'updated_at'=>$current_date
                      );
  $db->where('id',$SupplierPayID);
  $db->update('supplier_payments',$paymentArray);


  $transactions_array=array(
                            
                            'account'=>$bank_account,
                            'date'=>$vou_date,
                            'amount'=>$amount,
                            'updated_at'=>$current_date
                            );
  $db->where('supplier_payment_id',$SupplierPayID);
  $db->update('transactions',$transactions_array);

  // linking of sale invoice with payment
  $vocherNum=GetJvVocherNum($db);
  $journal_tbl_arr=array(
                      'date'=>$vou_date,
                      'total_debit'=>$amount,
                      'total_credit'=>$amount,
                      'updated_at'=>$current_date
                    );
  $db->where('supplier_payment_id',$SupplierPayID);
  $db->update('journal_tbl',$journal_tbl_arr);


  $db->where('supplier_payment_id',$SupplierPayID);
  $Jdata=$db->getOne('journal_tbl');
  $jId=$Jdata['j_id'];

  $db->where('id',"1");
  $GlPurchase = $db->getOne("gl_purchase_default");
  $COAPayable = $GlPurchase['payable_acc'];

  //meta credit entry only sale invoice
  //Get JVMeta Data for first entry
  $db->where('j_id',$jId);
  $db->orderBy ("jm_id","asc");
  $JvMetaOldDataCli1 = $db->getOne("journal_meta");
  $JmId1 = $JvMetaOldDataCli1['jm_id'];

  $journal_metaDebit = array( 
                        'chrt_id'=>$COAPayable,
                        'debit'=>$amount,
                        'updated_at'=>$current_date,
                      );
  $db->where('jm_id',$JmId1);
  $db->update('journal_meta',$journal_metaDebit);

  // meta debit entry on sale invoice

  //Get JVMeta Data for second entry
  $db->where('j_id',$jId);
  $db->orderBy ("jm_id","desc");
  $JvMetaOldDataCli2 = $db->getOne("journal_meta");
  $JmId2 = $JvMetaOldDataCli2['jm_id'];

  $journal_metaCredit = array( 
                        'chrt_id'=>$coaID,
                        'credit'=>$amount,
                        'updated_at'=>$current_date,
                      );
  $db->where('jm_id',$JmId2);
  $db->update('journal_meta',$journal_metaCredit);



}


function GetCOA_Account($db,$bank_account){
  $db->where('id',$bank_account);
  $coaID=$db->getValue('account','coa_id');
  return $coaID;
}


function CashPaymentVoucherJV($db,$clientID,$amount,$vou_date,$bank_account,$note){
  $current_date=date("Y-m-d");
  $coaID=GetCOA_Account($db,$bank_account);
  $paymentArray=array(  'supplier_id'=>$clientID,
                        'account_id'=>$bank_account,
                        'date'=>$vou_date,
                        'amount'=>$amount,
                        'payment_note'=>$note,
                        'created_at'=>$current_date
                      );
  $SupplierPayID=$db->insert('supplier_payments',$paymentArray);


  $transactions_array=array(
                            
                            'supplier_payment_id'=>$SupplierPayID,
                            'supplier_id'=>$clientID,
                            'account'=>$bank_account,
                            'category'=>'payment voucher',
                            'date'=>$vou_date,
                            'amount'=>$amount,
                            'created_at'=>$current_date
                            );
  $db->insert('transactions',$transactions_array);


  // linking of sale invoice with payment
  $vocherNum=GetJvVocherNum($db);
  $journal_tbl_arr=array(
                      'gl_type'=>'10',
                      'voucher_no'=>$vocherNum,
                      'supplier_payment_id'=>$SupplierPayID,
                      'date'=>$vou_date,
                      'total_debit'=>$amount,
                      'total_credit'=>$amount,
                      'created_at'=>$current_date
                    );
  $jId=$db->insert('journal_tbl',$journal_tbl_arr);

  $db->where('id',"1");
  $GlPurchase = $db->getOne("gl_purchase_default");
  $COAPayable = $GlPurchase['payable_acc'];

  //meta credit entry only sale invoice
  $journal_metaDebit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$COAPayable,
                        'debit'=>$amount,
                        'created_at'=>$current_date,
                      );
  $JVSalesDebit =$db->insert('journal_meta',$journal_metaDebit);

  // meta debit entry on sale invoice
  $journal_metaCredit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$coaID,
                        'credit'=>$amount,
                        'created_at'=>$current_date,
                      );
  $JVSalesCredit =$db->insert('journal_meta',$journal_metaCredit);

}


function SalaReturnDelete($pro_id,$oldQty,$db){
  $newQty=0;
  $db->where('pro_id',$pro_id);
  $stock_qty=$db->getValue('tbl_products','pro_qty');

  $newQty= $stock_qty- $oldQty;
  $arry_up=array('pro_qty'=>$newQty);
  $db->where('pro_id',$pro_id);
  $db->update('tbl_products',$arry_up);

}

function AddPurchaseReturnJV($invoice_id,$invoice_date,$ClientID,$Amount,$db){

    $current_date=date("Y-m-d");
    $PurchaseData=GetPurchaseDefault($db);
    $PayAccount=$PurchaseData['payable_acc'];
    $PurchaseReturn=$PurchaseData['purchases_returns'];

    $vocherNum=GetJvVocherNum($db);

    $jvTable=array( 
                    "gl_type"=>'12',
                    "purchase_return_id"=>$invoice_id,
                    "voucher_no"=>$vocherNum,
                    "date"=>$invoice_date,
                    "total_debit"=>$Amount,
                    "total_credit"=>$Amount,
                    "created_at"=>$current_date
                    );
    $jId=$db->insert('journal_tbl',$jvTable);


    //meta debit entry only Purchase return invoice
    $journal_metaDebit = array( 
                          'j_id'=>$jId,
                          'chrt_id'=>$PayAccount,
                          'debit'=>$Amount,
                          'created_at'=>$current_date,
                        );
    $JVPurchaseDebit =$db->insert('journal_meta',$journal_metaDebit);

    // meta credit entry on Purchase return invoice
    $journal_metaCredit = array( 
                          'j_id'=>$jId,
                          'chrt_id'=>$PurchaseReturn,
                          'credit'=>$Amount,
                          'created_at'=>$current_date,
                        );
    $JVPurchaseCredit =$db->insert('journal_meta',$journal_metaCredit);



  }


  function AddSaleReturnJV($invoice_id,$invoice_date,$ClientID,$Amount,$db){

    $current_date=date("Y-m-d");
    $SaleData=GetDefaultSale($db);
    $recAccount=$SaleData['receivable_acc'];
    $saleReturn=$SaleData['sales_return'];

    $vocherNum=GetJvVocherNum($db);

    $jvTable=array( 
                    "gl_type"=>'11',
                    "sale_return_id"=>$invoice_id,
                    "voucher_no"=>$vocherNum,
                    "date"=>$invoice_date,
                    "total_debit"=>$Amount,
                    "total_credit"=>$Amount,
                    "created_at"=>$current_date
                    );
    $jId=$db->insert('journal_tbl',$jvTable);


    //meta debit entry only sale invoice
    $journal_metaDebit = array( 
                          'j_id'=>$jId,
                          'chrt_id'=>$saleReturn,
                          'debit'=>$Amount,
                          'created_at'=>$current_date,
                        );
    $JVSalesDebit =$db->insert('journal_meta',$journal_metaDebit);

    // meta credit entry on sale invoice
    $journal_metaCredit = array( 
                          'j_id'=>$jId,
                          'chrt_id'=>$recAccount,
                          'credit'=>$Amount,
                          'created_at'=>$current_date,
                        );
    $JVSalesCredit =$db->insert('journal_meta',$journal_metaCredit);



  }


function ReutrnProductInStock_Edit($meta_id,$db){
  $new_qty=0;

  // get data of the product
  $db->where("meta_pro_id",$meta_id);
  $pro_data=$db->getOne("tbl_purchase_return_detail");
  


  $db->where('pro_id',$pro_data['pro_id']);
  $StockQty=$db->getValue('tbl_products','pro_qty');


  // set new Quantity
  $new_qty= $StockQty + $pro_data['return_qty'];


  // update in product table
  $up_qty=array("pro_qty"=>$new_qty);
  $db->where('pro_id',$pro_data['pro_id']);
  $db->update("tbl_products",$up_qty);
}


function ReutrnProductInStock($meta_id,$db){
  $new_qty=0;

  // get data of the product
  $db->where("pur_pro_id",$meta_id);
  $pro_data=$db->getOne("tbl_purchase_invoice_pro");


  $db->where('pro_id',$pro_data['pro_id']);
  $StockQty=$db->getValue('tbl_products','pro_qty');


  // set new Quantity
  $new_qty= $StockQty - $pro_data['new_add_qty'];
  // update in product table
  $up_qty=array("pro_qty"=>$new_qty);
  $db->where('pro_id',$pro_data['pro_id']);
  $db->update("tbl_products",$up_qty);
}

function DeletePurchaseReturn($invoiceId,$db){

  $db->where('purchase_return_id',$invoiceId);
  $jTable=$db->get('journal_tbl');
  foreach( $jTable as $ja){

    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_meta');

    $db->where('purchase_return_id',$invoiceId);
    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_tbl');

  }

}


function DeleteSaleReturn($invoiceId,$db){
 

  $db->where('sale_return_id',$invoiceId);
  $jTable=$db->get('journal_tbl');
  foreach( $jTable as $ja){

    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_meta');

    $db->where('sale_return_id',$invoiceId);
    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_tbl');
  }

}

function DeletePurchaseInvoice($invoiceId,$db){

  $db->where('purchase_invoice_id',$invoiceId);
  $jTable=$db->get('journal_tbl');
  foreach( $jTable as $ja){

    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_meta');

    $db->where('purchase_invoice_id',$invoiceId);
    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_tbl');

  }

  $db->where('purchase_invoice_id',$invoiceId);
  $SupplierPayment=$db->get('supplier_payments');

  foreach($SupplierPayment as $cp){
    $db->where('purchase_invoice_id',$invoiceId);
    $db->where('supplier_payment_id',$cp['id']);
    $db->delete('transactions');

    $db->where('purchase_invoice_id',$invoiceId);
    $db->delete('supplier_payments');
  }


}


function DeleteSaleInvoice($invoiceId,$db){

  $db->where('invoice_id',$invoiceId);
  $jTable=$db->get('journal_tbl');
  foreach( $jTable as $ja){

    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_meta');

    $db->where('invoice_id',$invoiceId);
    $db->where('j_id',$ja['j_id']);
    $db->delete('journal_tbl');

  }

  $db->where('invoice_id',$invoiceId);
  $ClientPayment=$db->get('client_payments');

  foreach($ClientPayment as $cp){
    $db->where('sale_invoice_id',$invoiceId);
    $db->where('client_pay_id',$cp['id']);
    $db->delete('transactions');

    $db->where('invoice_id',$invoiceId);
    $db->delete('client_payments');
  }

}

function GetDefaultSale($db){

  $db->where('id','1');
  $SaleData=$db->getOne('gl_sales_default');

  return $SaleData;

}

function GetPurchaseDefault($db){
  $db->where('id','1');
  $PurchaseData=$db->getOne('gl_purchase_default');

  return $PurchaseData;

}


function UpdatePurchaseInvoice($invoiceId,$amount,$invoiceDate,$db){
  $current_date=date("Y-m-d");
  $db->where('gl_type','8');
  $db->where('purchase_invoice_id',$invoiceId);
  $jTable=$db->getOne('journal_tbl');


  // update j table
  $updateGlTable=array( 
                        'total_debit'=>$amount,
                        'total_credit'=>$amount,
                        "updated_at"=>$current_date,
                        "date"=>$invoiceDate
                      );
  $db->where('purchase_invoice_id',$invoiceId);
  $db->where('gl_type','8');
   $db->update('journal_tbl',$updateGlTable);


  // get journal Id
  $j_Id=$jTable['j_id'];

  // update credit in j_meta
  $PurchaseDefault=GetPurchaseDefault($db);
  $upDate_credit=array('credit'=>$amount,'updated_at'=>$current_date);
  $db->where('chrt_id',$PurchaseDefault['payable_acc']);
  $db->where('j_id',$j_Id);
  $db->update('journal_meta',$upDate_credit);

  // update debit in j_meta
  $upDate_debit=array('debit'=>$amount,'updated_at'=>$current_date);
  $db->where('chrt_id',$PurchaseDefault['purchases_acc']);
  $db->where('j_id',$j_Id);
  $db->update('journal_meta',$upDate_debit);
}

function UpdatePurchaseInvoice_Return($invoiceId,$amount,$invoiceDate,$db){

  $current_date=date("Y-m-d");
  $db->where('gl_type','12');
  $db->where('purchase_return_id',$invoiceId);
  $jTable=$db->getOne('journal_tbl');


  // update j table
  $updateGlTable=array( 
                        'total_debit'=>$amount,
                        'total_credit'=>$amount,
                        "updated_at"=>$current_date,
                        "date"=>$invoiceDate
                      );
  $db->where('gl_type','12');
  $db->where('purchase_return_id',$invoiceId);
  $db->update('journal_tbl',$updateGlTable);


  // get journal Id
  $j_Id=$jTable['j_id'];

  
  $PurchaseDefault=GetPurchaseDefault($db);
  // update debit in j_meta
  $upDate_debit=array('debit'=>$amount,'updated_at'=>$current_date);
  $db->where('chrt_id',$PurchaseDefault['payable_acc']);
  $db->where('j_id',$j_Id);
  $db->update('journal_meta',$upDate_debit);

  // update credit in j_meta
  $upDate_credit=array('credit'=>$amount,'updated_at'=>$current_date);
  $db->where('chrt_id',$PurchaseDefault['purchases_returns']);
  $db->where('j_id',$j_Id);
  $db->update('journal_meta',$upDate_credit);

  
}

function UpdateSaleInvoice_Return($invoiceId,$amount,$invoiceDate,$db){

  $current_date=date("Y-m-d");
  $db->where('gl_type','11');
  $db->where('sale_return_id',$invoiceId);
  $jTable=$db->getOne('journal_tbl');


  // update j table
  $updateGlTable=array( 
                        'total_debit'=>$amount,
                        'total_credit'=>$amount,
                        "updated_at"=>$current_date,
                        "date"=>$invoiceDate
                      );
  $db->where('gl_type','11');
  $db->where('sale_return_id',$invoiceId);
  $db->update('journal_tbl',$updateGlTable);


  // get journal Id
  $j_Id=$jTable['j_id'];

  // update credit in j_meta
  $saleDefault=GetDefaultSale($db);
  $upDate_credit=array('credit'=>$amount,'updated_at'=>$current_date);
  $db->where('chrt_id',$saleDefault['receivable_acc']);
  $db->where('j_id',$j_Id);
  $db->update('journal_meta',$upDate_credit);

  // update debit in j_meta
  $upDate_debit=array('debit'=>$amount,'updated_at'=>$current_date);
  $db->where('chrt_id',$saleDefault['sales_return']);
  $db->where('j_id',$j_Id);
  $db->update('journal_meta',$upDate_debit);
}


function UpdateSaleInvoice($invoiceId,$amount,$invoiceDate,$db){

  $current_date=date("Y-m-d");
  $db->where('gl_type','5');
  $db->where('invoice_id',$invoiceId);
  $jTable=$db->getOne('journal_tbl');


  // update j table
  $updateGlTable=array( 
                        'total_debit'=>$amount,
                        'total_credit'=>$amount,
                        "updated_at"=>$current_date,
                        "date"=>$invoiceDate
                      );
  $db->where('invoice_id',$invoiceId);
  $db->where('gl_type','5');
   $db->update('journal_tbl',$updateGlTable);


  // get journal Id
  $j_Id=$jTable['j_id'];

  // update credit in j_meta
  $saleDefault=GetDefaultSale($db);
  $upDate_credit=array('credit'=>$amount,'updated_at'=>$current_date);
  $db->where('chrt_id',$saleDefault['sale_acc']);
  $db->where('j_id',$j_Id);
  $db->update('journal_meta',$upDate_credit);

  // update debit in j_meta
  $upDate_debit=array('debit'=>$amount,'updated_at'=>$current_date);
  $db->where('chrt_id',$saleDefault['receivable_acc']);
  $db->where('j_id',$j_Id);
  $db->update('journal_meta',$upDate_debit);
}


function ChangeInProductInvoice_Return($oldQty,$newQty,$metaID,$proId,$db){
 
  $tempQty=0;
  $updateQty=0;
  $db->where('pro_id',$proId);
  $proQty=$db->getValue('tbl_products','pro_qty');
  $tempQty=$proQty - $oldQty;
  $updateQty= $tempQty + $newQty;

  $proArray=array( 'pro_qty' =>$updateQty );
  $db->where('pro_id',$proId);
  $db->update('tbl_products',$proArray);
}


function ChangeInProductInvoice($oldQty,$newQty,$metaID,$proId,$db){
 
 
  $tempQty=0;
  $updateQty=0;
  $db->where('pro_id',$proId);
  $proQty=$db->getValue('tbl_products','pro_qty');
  $tempQty=$proQty + $oldQty;


  $updateQty= $tempQty - $newQty;


  $proArray=array( 'pro_qty' =>$updateQty );
  $db->where('pro_id',$proId);
  $db->update('tbl_products',$proArray);
}

function ReverseTheProductItem_Return($meta_id,$db){

  // get meta row value
  $db->where('pkg_meta_item',$meta_id);
  $item=$db->getOne('tbl_salereturn_detail');

  // get qty of package
  $no_of_item=$item['pro_qty'];

  if ($no_of_item > 0) {
      $db->where('pro_id',$item['pro_id']);
      $stock_qty=$db->getOne('tbl_products');
      // available qty
      $set_qty=0;
      $pkg_pro_qty=$stock_qty['pro_qty'];
      $new_qty= $pkg_pro_qty - $no_of_item;
      
      // new updated qty
      $update_arr=array("pro_qty" =>$new_qty);
      $db->where('pro_id',$item['pro_id']);
      $db->update('tbl_products',$update_arr);
       

       
  }
}



function ReverseTheProductItem($meta_id,$db){

  // get meta row value
  $db->where('pkg_meta_item',$meta_id);
  $item=$db->getOne('tbl_invoice_detail');

  // get qty of package
  $no_of_item=$item['pro_qty'];

  if ($no_of_item > 0) {
      $db->where('pro_id',$item['pro_id']);
      $stock_qty=$db->getOne('tbl_products');
      // available qty
      $set_qty=0;
      $pkg_pro_qty=$stock_qty['pro_qty'];
      $new_qty= $pkg_pro_qty + $no_of_item;
      
      // new updated qty
      $update_arr=array("pro_qty" =>$new_qty);
      $db->where('pro_id',$item['pro_id']);
      $db->update('tbl_products',$update_arr);
       

       
  }
}


function AddStockQty($pro_id,$pro_qty,$db){
  $new_qty=0;
  $db->where('pro_id',$pro_id);
  $old_qty=$db->getValue('tbl_products','pro_qty');

  $new_qty= $old_qty +$pro_qty;
  $update=array("pro_qty"=>$new_qty);
  $db->where('pro_id',$pro_id);
  $db->update('tbl_products',$update);

}



function RemoveStockQty($pro_id,$pro_qty,$db){
  $new_qty=0;
  $db->where('pro_id',$pro_id);
  $old_qty=$db->getValue('tbl_products','pro_qty');

  $new_qty= $old_qty -$pro_qty;

  if ($new_qty > 0) {
    $update=array("pro_qty"=>$new_qty);
    $db->where('pro_id',$pro_id);
    $db->update('tbl_products',$update);
  } else{
    $update=array("pro_qty"=>'0');
    $db->where('pro_id',$pro_id);
    $db->update('tbl_products',$update);
  }
}

function encode($value)
{
    $enc=base64_encode($value);
    return $enc;
}
function decode($value1)
{
    $dec=base64_decode($value1);
    return $dec;
}

function ChangeFormate($date){
  $newDate = date("d-m-Y", strtotime($date));

  return $newDate;
}


function CheckDefaultBank($db){

  $db->where('default_account','1');
  $bankData=$db->getOne('account');

  return $bankData;

}


function SaleInvoiceEnteryWithPayment($db,$current_date,$invoice_id,$invoice_date,$invoiceAmount,$paid_amount,$ClientId){

  $bankData=CheckDefaultBank($db);
  $paymentArray=array(  'invoice_id'=>$invoice_id,
                        'client_id'=>$ClientId,
                        'account_id'=>$bankData['id'],
                        'date'=>$invoice_date,
                        'amount'=>$paid_amount,
                        'created_at'=>$current_date
                      );
  $clientPayID=$db->insert('client_payments',$paymentArray);


  $transactions_array=array(
                            'sale_invoice_id'=>$invoice_id,
                            'client_pay_id'=>$clientPayID,
                            'client_id'=>$ClientId,
                            'account'=>$bankData['id'],
                            'category'=>'sale invoice',
                            'date'=>$invoice_date,
                            'amount'=>$paid_amount,
                            'created_at'=>$current_date
                            );
  $db->insert('transactions',$transactions_array);


  // linking of sale invoice with payment
  $vocherNum=GetJvVocherNum($db);
  $journal_tbl_arr=array(
                      'gl_type'=>'3',
                      'invoice_id'=>$invoice_id,
                      'voucher_no'=>$vocherNum,
                      'client_payment'=>$clientPayID,
                      'date'=>$invoice_date,
                      'total_debit'=>$paid_amount,
                      'total_credit'=>$paid_amount,
                      'created_at'=>$current_date
                    );
  $jId=$db->insert('journal_tbl',$journal_tbl_arr);

  $db->where('id',"1");
  $GlSales = $db->getOne("gl_sales_default");
  $COARece = $GlSales['receivable_acc'];

  //meta credit entry only sale invoice
  $journal_metaDebit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$bankData['coa_id'],
                        'debit'=>$paid_amount,
                        'created_at'=>$current_date,
                      );
  $JVSalesDebit =$db->insert('journal_meta',$journal_metaDebit);

  // meta debit entry on sale invoice
  $journal_metaCredit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$COARece,
                        'credit'=>$paid_amount,
                        'created_at'=>$current_date,
                      );
  $JVSalesCredit =$db->insert('journal_meta',$journal_metaCredit);

}


function PurchaseInvoiceEnteryWithPayment($db,$current_date,$invoice_id,$invoice_date,$invoiceAmount,$paid_amount,$supplierId){

  $bankData=CheckDefaultBank($db);
  $paymentArray=array(  'purchase_invoice_id'=>$invoice_id,
                        'account_id'=>$bankData['id'],
                        'supplier_id'=>$supplierId,
                        'date'=>$invoice_date,
                        'amount'=>$paid_amount,
                        'created_at'=>$current_date
                      );
  $SupplierPayID=$db->insert('supplier_payments',$paymentArray);


  $transactions_array=array(
                            'purchase_invoice_id'=>$invoice_id,
                            'supplier_payment_id'=>$SupplierPayID,
                            'supplier_id'=>$supplierId,
                            'account'=>$bankData['id'],
                            'category'=>'purchase invoice',
                            'date'=>$invoice_date,
                            'amount'=>$paid_amount,
                            'created_at'=>$current_date
                            );
  $db->insert('transactions',$transactions_array);


  // linking of sale invoice with payment
  $vocherNum=GetJvVocherNum($db);
  $journal_tbl_arr=array(
                      'gl_type'=>'10',
                      'purchase_invoice_id'=>$invoice_id,
                      'voucher_no'=>$vocherNum,
                      'supplier_payment_id'=>$SupplierPayID,
                      'date'=>$invoice_date,
                      'total_debit'=>$paid_amount,
                      'total_credit'=>$paid_amount,
                      'created_at'=>$current_date
                    );
  $jId=$db->insert('journal_tbl',$journal_tbl_arr);

  $db->where('id',"1");
  $GlPurchase = $db->getOne("gl_purchase_default");
  $COAPayable = $GlPurchase['payable_acc'];

  //meta credit entry only sale invoice
  $journal_metaDebit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$COAPayable,
                        'debit'=>$paid_amount,
                        'created_at'=>$current_date,
                      );
  $JVSalesDebit =$db->insert('journal_meta',$journal_metaDebit);

  // meta debit entry on sale invoice
  $journal_metaCredit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$bankData['coa_id'],
                        'credit'=>$paid_amount,
                        'created_at'=>$current_date,
                      );
  $JVSalesCredit =$db->insert('journal_meta',$journal_metaCredit);

}



function SaleInvoiceEnteryNoPayment($db,$current_date,$invoice_id,$invoice_date,$invoiceAmount){

  // linking of sale invoice
  $vocherNum=GetJvVocherNum($db);
  $journal_tbl_arr=array(
                      'gl_type'=>'5',
                      'invoice_id'=>$invoice_id,
                      'voucher_no'=>$vocherNum,
                      'date'=>$invoice_date,
                      'total_debit'=>$invoiceAmount,
                      'total_credit'=>$invoiceAmount,
                      'created_at'=>$current_date
                    );
  $jId=$db->insert('journal_tbl',$journal_tbl_arr);

  $db->where('id',"1");
  $GlSales = $db->getOne("gl_sales_default");
  $COASales = $GlSales['sale_acc'];
  $COARece = $GlSales['receivable_acc'];

  //meta credit entry only sale invoice
  $journal_metaCredit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$COASales,
                        'credit'=>$invoiceAmount,
                        'created_at'=>$current_date,
                      );
  $JVSalesCredit =$db->insert('journal_meta',$journal_metaCredit);

  // meta debit entry on sale invoice
  $journal_metaDebit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$COARece,
                        'debit'=>$invoiceAmount,
                        'created_at'=>$current_date,
                      );
  $JVSalesDebit =$db->insert('journal_meta',$journal_metaDebit);

}

function PurchaseInvoiceEnteryNoPayment($db,$current_date,$invoice_id,$invoice_date,$invoiceAmount){

  // linking of Purchase invoice
  $vocherNum=GetJvVocherNum($db);
  $journal_tbl_arr=array(
                      'gl_type'=>'8',
                      'purchase_invoice_id'=>$invoice_id,
                      'voucher_no'=>$vocherNum,
                      'date'=>$invoice_date,
                      'total_debit'=>$invoiceAmount,
                      'total_credit'=>$invoiceAmount,
                      'created_at'=>$current_date
                    );
  $jId=$db->insert('journal_tbl',$journal_tbl_arr);

  $db->where('id',"1");
  $GlPurchase = $db->getOne("gl_purchase_default");
  $COAPayable = $GlPurchase['payable_acc'];
  $COAPurchase = $GlPurchase['purchases_acc'];


  // meta debit entry on sale invoice
  $journal_metaDebit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$COAPurchase,
                        'debit'=>$invoiceAmount,
                        'created_at'=>$current_date,
                      );
  $JVSalesDebit =$db->insert('journal_meta',$journal_metaDebit);

  //meta credit entry only sale invoice
  $journal_metaCredit = array( 
                        'j_id'=>$jId,
                        'chrt_id'=>$COAPayable,
                        'credit'=>$invoiceAmount,
                        'created_at'=>$current_date,
                      );
  $JVSalesCredit =$db->insert('journal_meta',$journal_metaCredit);

  

}


function GetJvVocherNum($db){
  $db->orderBy('j_id','desc');
  $num=$db->getValue('journal_tbl','voucher_no');
  if(empty($num)){
    $num=1;
  } else{
    $num++;
  }

  return $num;

}





function GetTransactionBalance($start,$limit,$account_no,$columnSortOrder,$db){

  $Balance =0;
  if ($limit == 0) {
    
    $db->where('id',$account_no);
    $OpeningBalance=$db->getValue('account','opening_balance');
    $Balance = $Balance + $OpeningBalance;
    return $Balance;
  }

  if ($limit > 0) {
    
    
    $OpeningBalance = 0;
    $accountID='';
    $cols=array("acc.id","acc.account_number","trs.category","trs.date","trs.amount","trs.exp_id","trs.dept_id","trs.salary_id","trs.invoice_id");
    $db->join("account acc", "trs.account=acc.id", "INNER");
    $db->where("acc.id",$account_no);
    $db->orderBy("transaction_id",$columnSortOrder);
    $transfersdata = $db->get("transactions trs",Array ($start, $limit),$cols);

    foreach($transfersdata as $transfers){

      if ($accountID != $transfers['id']) {
          
        $accountID=$transfers['id'];
        $db->where('id',$transfers['id']);
        $OpeningBalance=$db->getValue('account','opening_balance');
        $Balance = $Balance + $OpeningBalance;
      }


      ///////////////////////Get Receipt And Payment Name////////////////////
      if($transfers['category'] == 'Income'){
          $receipt = $transfers['amount'];
          $Balance += $receipt;
      }elseif ($transfers['category'] == 'Funds Transfer To') {
          $receipt = $transfers['amount'];
          $Balance += $receipt;
      }else{
          $Forreceipt = '';
      }

      

      if($transfers['category'] == 'Expense'){     
          $payments = $transfers['amount'];
          $Balance -= $payments;
      }elseif ($transfers['category'] == 'Funds Transfer From') {
          $payments = $transfers['amount'];
          $Balance -= $payments;
      }else{
          $Forpayments = '';
      }

    }

    return $Balance;
  }


}
/////////////////////////////////////////////////////////////
function MatchAccessPermission($db,$UserId){

    $db->where("id",$UserId);
    $AsUser = $db->getOne('users_tbl');
    $RLId = $AsUser['role_id'];

    $db->where("role_id",$RLId);
    $UsrPerData = $db->get("role_permissions");
      return $UsrPerData;
}
/////////////////////////////////////////////////////////////
function addCashInAccount($db,$AccountNumber,$Amount){

  $db->where('id',$AccountNumber);
  $acc_cp = $db->getOne("account");
  $AccCoaId = $acc_cp['coa_id'];
  $acc_cp_bal = $acc_cp['balance'];
  $account_new_balance_client = $acc_cp_bal + $Amount;
  
  $up_acc_client = array("balance"=>$account_new_balance_client);
  $db->where("id",$AccountNumber);
  $account_client = $db->update("account",$up_acc_client);

}
//////////////////////////////////////////////////////////////
function deductBankAmount($db,$AccountNumber,$Amount){

  $db->where('id',$AccountNumber);
  $acc_dp = $db->getOne("account");
  $AccCoaId = $acc_dp['coa_id'];
  $acc_dp_bal = $acc_dp['balance'];
  $acc_dp_account_number = $acc_dp['account_number'];
  $account_new_balance = $acc_dp_bal - $Amount;
  
  $up_acc_dept = array("balance"=>$account_new_balance);
  $db->where("id",$AccountNumber);
  $account_update = $db->update("account",$up_acc_dept);

}
//////////////////////////////////////////////////////////////
function AddandDeductAmount($db,$AccountNumber,$OldAmount,$NewAmount){

  $db->where('id',$AccountNumber);
  $acc_det=$db->getOne('account');
  $AccCoaId = $acc_det['coa_id'];
  $AccBal = $acc_det['balance'];
  $acc_dp_account_number = $acc_det['account_number'];
  
  $new_bal=$AccBal + $OldAmount;
  $after_bal=$new_bal - $NewAmount;
  
  //update the new balance
  $up_acc=array("balance"=>$after_bal);
  $db->where('id',$AccountNumber);
  $db->update('account',$up_acc);
}

//////////////////////////////////////////////////////////////
function DeductandAddAmount($db,$AccountNumber,$OldAmount,$NewAmount){
  $db->where('id',$AccountNumber);
  $acc_da_cl=$db->getOne('account');
  $AccBalCli = $acc_da_cl['balance'];
  $AccCoaIdCli = $acc_da_cl['coa_id'];
  
  $new_balnce_old= $AccBalCli - $OldAmount;
  $new_balnce = $new_balnce_old + $NewAmount;
  
  $cli_arr=array("balance"=>$new_balnce);
  $db->where('id',$AccountNumber);
  $db->update('account',$cli_arr);
}
//////////////////////////////////////////////////////////////
function GetExpenseVoucherNumber($db){

  $db->orderBy("id","Desc");
  $expensesData = $db->get("expenses",1);
  foreach ($expensesData as $expenses) {
  $previousexpensesid = $expenses['id'];
  $previousvoucher = $expenses['voucher'];
      
  }
  if(!empty($previousvoucher)){
      $newvoucher = $previousvoucher+1;
  }else{
      $newvoucher = 1;
  }
  return $newvoucher;
}

//////////////////////////////////////////////////////////////
function GetJvVoucherNumber($db){

  $db->orderBy("j_id","Desc");
  $journalData = $db->get("journal_tbl",1);
  foreach ($journalData as $journal) {
    $previousjournalid = $journal['j_id'];
    $previousvoucher = $journal['voucher_no'];
    
  }
  if(!empty($previousvoucher)){
    $newvoucher = $previousvoucher+1;
  }else{
    $newvoucher = 1;
  }
  return $newvoucher;
}
//////////////////////////////////////////////////////////////
function GetSalaryVoucherNumber($db){
  $db->orderBy("id","Desc");
  $employee_salaryData = $db->get("employee_salary",1);
  foreach ($employee_salaryData as $employee_salary) {
    $previousemployee_salaryid = $employee_salary['id'];
    $previousvoucher = $employee_salary['voucher_no'];
    
  }
  if(!empty($previousvoucher)){
    $newSalaryvoucher = $previousvoucher+1;
  }else{
    $newSalaryvoucher = 1;
  }
  return $newSalaryvoucher;
}
//////////////////////////////////////////////////////////////
function addSaleInvoiceGl($db,$InvoiceId,$Price,$Received,$Balance,$PaymentDate,$Date){
  //Check in which GL account we have to insert data
    $GlSaleDefault = $db->getOne("gl_sales_default");
    $saleAccount = $GlSaleDefault['sale_acc'];
    $receivableAccount = $GlSaleDefault['receivable_acc'];

  //Get Voucher number for JV
    $db->orderBy("j_id","Desc");
    $journalData = $db->get("journal_tbl",1);
    foreach ($journalData as $journal) {
      $previousjournalid = $journal['j_id'];
      $previousvoucher = $journal['voucher_no'];
      
    }
    if(!empty($previousvoucher)){
      $newvoucher = $previousvoucher+1;
    }else{
      $newvoucher = 1;
    }

    //Insert Data into JV

    $TotalDebit = $Received + $Balance;
    $GlSalJVarr = array("invoice_id"=>$InvoiceId,"gl_type"=>'5',"voucher_no"=>$newvoucher,"date"=>$PaymentDate,"total_debit"=>$TotalDebit,"total_credit"=>$Price,"created_at"=>$Date);
    $JVData = $db->insert("journal_tbl",$GlSalJVarr);

    //For Credit Account entry in JV Meta
    $JVMetaArrCredit = array("j_id"=>$JVData,"chrt_id"=>$saleAccount,"credit"=>$Price,"created_at"=>$Date);
    $MetaJvCreditInsert = $db->insert("journal_meta",$JVMetaArrCredit);

    //For Debit Account entry in JV Meta
    $JVMetaArrDebit = array("j_id"=>$JVData,"chrt_id"=>$receivableAccount,"debit"=>$Price,"created_at"=>$Date);
    $MetaJvDebitInsert = $db->insert("journal_meta",$JVMetaArrDebit);
}
//////////////////////////////////////////////////////////////





///////////////////////////////////////////////////////////////////
function sanitize_text_input($str){
    $str=strip_tags($str); 
   $newstr = filter_var($str, FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    return $newstr;


}

function matchproduct($product_name,$db){
        $db->where("product_name",$product_name);
        $product_data=$db->getOne("products");
        $product_id_data = $product_data['product_id'];
        return $product_id_data;
}


?>