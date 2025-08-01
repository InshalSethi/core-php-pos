<?php 

	

	include '../../include/config_new.php';

    include '../../include/functions.php';

    include '../../include/MysqliDb.php';

    include '../../include/config.php';





    ## Read value

	$draw = $_POST['draw'];
	$row = $_POST['start'];
	$rowperpage = $_POST['length']; // Rows display per page
	$columnIndex = $_POST['order'][0]['column']; // Column index
	$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
	$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
	$searchValue = $_POST['search']['value']; // Search value
    $AccountNo=$_POST['account_no'];



    

    $Balance =0;

    $Balance =GetTransactionBalance(0,$_POST['start'],$AccountNo,$columnSortOrder,$db);

    $cols=array("COUNT(trs.transaction_id) as total_count");
    $db->join("account acc", "trs.account=acc.id", "INNER");

    if( isset($_POST['date_fr'])  && $_POST['date_fr'] != '' && isset($_POST['date_to'])  &&  $_POST['date_to'] != ''  ){

        $from_date=$_POST['date_fr'];
        $to_date=$_POST['date_to'];
        $db->where('trs.date', Array ($from_date, $to_date ), 'BETWEEN');
    }

    if (isset($searchValue) && $searchValue != '') {
        $db->where("acc.account_number", '%'.$searchValue.'%', 'like');
    }

    $db->where("acc.id",$AccountNo);
    $db->orderBy("transaction_id",$columnSortOrder);
    $Result = $db->get("transactions trs",NULL,$cols);



    foreach($Result as $res){
        $totalRecords=$res['total_count'];
    }

	$data = array();
	$trns = $row+1;

	$cols=array("acc.id","acc.account_number","acc.name","acc.bank_name","trs.category","trs.date","trs.amount","trs.exp_id","trs.salary_id","trs.sale_invoice_id","trs.client_id","trs.supplier_id");

    $db->join("account acc", "trs.account=acc.id", "INNER");



    if( isset($_POST['date_fr'])  && $_POST['date_fr'] != '' && isset($_POST['date_to'])  &&  $_POST['date_to'] != ''  ){

        $from_date=$_POST['date_fr'];
        $to_date=$_POST['date_to'];
        $db->where('trs.date', Array ($from_date, $to_date ), 'BETWEEN');
    }


    if (isset($searchValue) && $searchValue != '') {

        $db->where("acc.account_number", '%'.$searchValue.'%', 'like');
    }

    $db->where("acc.id",$AccountNo);
    $db->orderBy("transaction_id",$columnSortOrder);
    $transfersdata = $db->get("transactions trs",Array ($row, $rowperpage),$cols);

    

    

    // $OpeningBalance = 0;

    // $accountID='';

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
            $ClientName = ($CusData && isset($CusData['cus_name'])) ? $CusData['cus_name'] : 'Unknown Client';
        } else if($transfers['supplier_id'] != ''){

            $ClientId = $transfers['supplier_id'];
            $db->where("cus_id",$ClientId);
            $CusData = $db->getOne("tbl_customer");
            $ClientName = ($CusData && isset($CusData['cus_name'])) ? $CusData['cus_name'] : 'Unknown Supplier';
        } else{
            $ClientName = '';
        }

/////////////////////////Get Expense Name///////////////////////////////

        if($transfers['salary_id'] != ''){
            $expenseName = 'Salary';
        } else if($transfers['exp_id'] != ''){

            $db->where("id",$transfers['exp_id']);
            $ExpData = $db->getOne("expenses");

            if ($ExpData && isset($ExpData['exp_type_id'])) {
                $expTypeId = $ExpData['exp_type_id'];

                $db->where("id",$expTypeId);
                $ExpTypeData = $db->getOne("exp_type");
                $expenseName = ($ExpTypeData && isset($ExpTypeData['type_name'])) ? $ExpTypeData['type_name'] : 'Unknown Expense';
            } else {
                $expenseName = 'Unknown Expense';
            }

        } else{
            $expenseName = '';
        }

///////////////////////Get Receipt And Payment Name////////////////////

        if($transfers['category'] == 'sale invoice'){
            // $receipt = 'Income';
            $Forreceipt = number_format((float)$transfers['amount']);
            $receipt = (float)$transfers['amount'];
            $Balance += $receipt;

        } elseif ($transfers['category'] == 'receipt voucher') {

            $Forreceipt = number_format((float)$transfers['amount']);
            $receipt = (float)$transfers['amount'];
            $Balance += $receipt;

        } elseif ($transfers['category'] == 'Funds Transfer To') {

            $Forreceipt = number_format((float)$transfers['amount']);
            $receipt = (float)$transfers['amount'];
            $Balance += $receipt;
        } else{
            $Forreceipt = '';
        }

        if($transfers['category'] == 'Expense'){
            // $payments = 'Expense';
            $Forpayments = number_format((float)$transfers['amount']);
            $payments = (float)$transfers['amount'];
            $Balance -= $payments;

        } elseif($transfers['category'] == 'purchase invoice'){

            // $payments = 'Expense';
            $Forpayments = number_format((float)$transfers['amount']);
            $payments = (float)$transfers['amount'];
            $Balance -= $payments;
        } elseif($transfers['category'] == 'payment voucher'){

            // $payments = 'Expense';
            $Forpayments = number_format((float)$transfers['amount']);
            $payments = (float)$transfers['amount'];
            $Balance -= $payments;

        } elseif ($transfers['category'] == 'Funds Transfer From') {

            $Forpayments = number_format((float)$transfers['amount']);
            $payments = (float)$transfers['amount'];
            $Balance -= $payments;

        } else{
            $Forpayments = '';
        }
        $BalanceHtml = number_format((float)$Balance);

////////////////////////////////////////////////////////////////

    $AccHtml = $transfers['account_number'].'-'.$transfers['bank_name'].'-'.$transfers['name'];
    $Category = $transfers['category'];

    	$data[] = array(

    		'sr_no'=>$trns,
    		'date'=>$set_date,
            'client'=>$ClientName,
            'exp_name'=>$expenseName,
    		'account'=>$AccHtml,
    		'type'=>$Category,
            'receipts'=>$Forreceipt,
            'payments'=>$Forpayments,
    		'balance'=>$BalanceHtml,
    	);



    	$trns++;







    }





    $response = array(

    "draw" => intval($draw),

    "iTotalRecords" => $totalRecords,

    "iTotalDisplayRecords" => $totalRecords,

    "data" => $data

	);



	echo json_encode($response);













?>