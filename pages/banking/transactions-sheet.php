<?php

    include '../../include/functions.php';

    include '../../include/MysqliDb.php';

    include '../../include/config.php';

    include '../../include/permission.php';


    $AccountNo=$_REQUEST['acc'];

    $cols=array("acc.id","acc.account_number","acc.name","acc.bank_name","trs.category","trs.date","trs.amount","trs.exp_id","trs.salary_id","trs.sale_invoice_id","trs.client_id","trs.supplier_id");
    $db->join("account acc", "trs.account=acc.id", "INNER");
    if ( $_REQUEST['date_from'] != '' && $_REQUEST['date_to'] != ''  ) {

        $date_from=$_REQUEST['date_from'];
        $date_to=$_REQUEST['date_to'];
        $db->where('trs.date',Array ($date_from, $date_to),'BETWEEN');
    }

    $db->where("acc.id",$AccountNo);
    $db->orderBy("trs.transaction_id",'asc');
    $transfersdata = $db->get("transactions trs",null,$cols);
    
    $account_name='';
    foreach($transfersdata as $trf){
      $account_name=$trf['name'];
    }




    ?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Transactions Print</title>

    <!-- base:css -->

    <?php include '../../include/auth.php'; ?>
    <?php include '../../libraries/libs.php'; ?>

    <link rel="stylesheet" media="print" href="<?php echo base_url('assets/css/sheet-print.css'); ?>">
    <link rel="stylesheet" media="screen" href="<?php echo base_url('assets/css/sheet-screen.css'); ?>">

  </head>

  <body>

  	<div class="outer">

  		<button onclick="myFunction()" class="btn btn-info noprint"><i class="mdi mdi-printer"></i> Print</button>

  	<div class="row">

      <div class="col-md-12">

        <h1 class="text-center pg-head">GSS</h1>

      </div>

  		<div class="col-md-12">

  			<h4 class="text-center pg-head"><?php echo $account_name; ?>-Transactions</h4>

  		</div>

  		<div class="col-md-12">

  			<!-- <div class="flt-l">

  				<span class="bold hd-u">Party: </span><span class="tx-co"><?php echo $Name; ?></span>

  			</div> -->

        

  			<div class="flt-r">





          <?php 

            if (isset($_REQUEST['date_from']) && $_REQUEST['date_from']!='' ) {

          ?>

  				<span class="bold hd-u">From </span><span class="tx-co"><?php echo ChangeFormate($_REQUEST['date_from']); ?></span>

  				<span class="bold hd-u">To </span><span class="tx-co"><?php echo ChangeFormate($_REQUEST['date_to']); ?></span>

          <?php } ?>





  			</div>

  		</div>

  		<div class="col-md-12">

  			<div class="table-responsive pt-3">

	            <table class="table table-bordered">
	              <thead>
  	              <tr>
                    <th class="th-set text-center">Sr#</th>
                    <th class="th-set text-center">Date</th>
                    <th class="th-set text-center">Client</th>
                    <th class="th-set text-center">Exp. Name</th>
                    <th class="th-set text-center">Account</th>
                    <th class="th-set text-center">Type</th>
                    <th class="th-set text-center">Receipts</th>
                    <th class="th-set text-center">Payment</th>
                    <th class="th-set text-center">Balance</th>
  	              </tr>
	              </thead>
	              <tbody>
                  <?php 
                    foreach($transfersdata as $transfers){

                    // if ($accountID != $transfers['id']) {   
                    //     $accountID=$transfers['id'];
                    //     $db->where('id',$transfers['id']);
                    //     $OpeningBalance=$db->getValue('account','opening_balance');
                    //     $Balance = $Balance + $OpeningBalance;
                    // }

                  if ($transfers['date'] != '') {
                        $set_date = date("d-m-Y",  strtotime($transfers['date']) );
                    } else{
                        $set_date = '';
                    }

                //////////////////////////////Get Client Name//////////////////////////

                    if ($transfers['client_id'] != '') {

                        // $db->where("inv_id",$transfers['sale_invoice_id']);
                        // $InvData = $db->getOne("tbl_invoice");
                        $ClientId = $transfers['client_id'];
                        $db->where("cus_id",$ClientId);
                        $CusData = $db->getOne("tbl_customer");
                        $ClientName = $CusData['cus_name'];
                    } else if($transfers['supplier_id'] != ''){

                        $ClientId = $transfers['supplier_id'];
                        $db->where("cus_id",$ClientId);
                        $CusData = $db->getOne("tbl_customer");
                        $ClientName = $CusData['cus_name'];
                    } else{
                        $ClientName = '';
                    }

            /////////////////////////Get Expense Name///////////////////////////////

                    if($transfers['salary_id'] != ''){
                        $expenseName = 'Salary';
                    } else if($transfers['exp_id'] != ''){

                        $db->where("id",$transfers['exp_id']);
                        $ExpData = $db->getOne("expenses");
                        $expTypeId = $ExpData['exp_type_id'];

                        $db->where("id",$expTypeId);
                        $ExpTypeData = $db->getOne("exp_type");
                        $expenseName = $ExpTypeData['type_name'];

                    } else{
                        $expenseName = '';
                    }

            ///////////////////////Get Receipt And Payment Name////////////////////

                    if($transfers['category'] == 'sale invoice'){
                        // $receipt = 'Income';
                        $Forreceipt = number_format($transfers['amount']);
                        $receipt = $transfers['amount'];
                        $Balance += $receipt;

                    } elseif ($transfers['category'] == 'receipt voucher') {

                        $Forreceipt = number_format($transfers['amount']);
                        $receipt = $transfers['amount'];
                        $Balance += $receipt;

                    } elseif ($transfers['category'] == 'Funds Transfer To') {

                        $Forreceipt = number_format($transfers['amount']);
                        $receipt = $transfers['amount'];
                        $Balance += $receipt;
                    } else{
                        $Forreceipt = '';
                    }

                    if($transfers['category'] == 'Expense'){
                        // $payments = 'Expense';
                        $Forpayments = number_format($transfers['amount']);
                        $payments = $transfers['amount'];
                        $Balance -= $payments;

                    } elseif($transfers['category'] == 'purchase invoice'){

                        // $payments = 'Expense';
                        $Forpayments = number_format($transfers['amount']);
                        $payments = $transfers['amount'];
                        $Balance -= $payments;
                    } elseif($transfers['category'] == 'payment voucher'){

                        // $payments = 'Expense';
                        $Forpayments = number_format($transfers['amount']);
                        $payments = $transfers['amount'];
                        $Balance -= $payments;

                    } elseif ($transfers['category'] == 'Funds Transfer From') {

                        $Forpayments = number_format($transfers['amount']);
                        $payments = $transfers['amount'];
                        $Balance -= $payments;

                    } else{
                        $Forpayments = '';
                    }
                    $BalanceHtml = number_format($Balance);

            ////////////////////////////////////////////////////////////////

                $AccHtml = $transfers['account_number'].'-'.$transfers['bank_name'].'-'.$transfers['name'];
                $Category = $transfers['category'];

                ?>

                <tr>
                    <td class="text-center st-td"><?php echo $trns; ?></td>
                    <td class="text-center st-td"><?php echo $set_date; ?></td>
                    <td class="text-center st-td"><?php echo $ClientName; ?></td>
                    <td class="text-center st-td"><?php echo $expenseName; ?></td>
                    <td class="text-center st-td"><?php echo $AccHtml; ?></td>
                    <td class="text-center st-td"><?php echo $Category; ?></td>
                    <td class="text-center st-td"><?php echo $Forreceipt; ?></td>
                    <td class="text-center st-td"><?php echo $Forpayments; ?></td>
                    <td class="text-center st-td"><?php echo $BalanceHtml; ?></td>

                </tr> 


                <?php
                    $trns++;
                  } ?>
                  
                 </tbody>

	            </table>

          	</div>

  		</div>

  	</div>

  	</div>

  </body>

  <script>

  function myFunction() {

      window.print();

  }

</script>

</html>