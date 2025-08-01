<?php
    include '../include/config_new.php';
    include '../include/functions.php';
    include '../include/MysqliDb.php';
    include '../include/config.php';
    
    if($_POST['action']){
        $action=$_POST['action'];
        $authkey=$_POST['authkey'];
        
        if( $action == 'expense_search' &&  $authkey == 'dabdsjjI81sa' ){

            $view =$_POST['view_permission'];
            $edit= $_POST['edit_permission'];
            $delete=$_POST['delete_permission'];
            
            if( $_POST['voucher_no'] != '' ){
                $db->where('voucher',$_POST['voucher_no']);
            }
            if( $_POST['paid_from'] != '' ){
                $db->where('account_id',$_POST['paid_from']);
            }
            if( $_POST['expense_type'] != '' ){
                $db->where('exp_type_id',$_POST['expense_type']);
            }
            if( $_POST['amount_from'] != '' &&  $_POST['amount_to'] != '' ){
                
                $am_from=$_POST['amount_from'];
                $am_to=$_POST['amount_to'];
                $db->where ("amount BETWEEN ".$am_from." AND ".$am_to."  ");
                
            }
            if( $_POST['date_from'] != '' &&  $_POST['date_to'] != '' ){
                
                $date_from=$_POST['date_from'];
                $date_to=$_POST['date_to'];
                $db->where('exp_date', Array ($date_from, $date_to ), 'BETWEEN');
            }
            $Total_exp_amount = 0;
            $expensesValdata = $db->get("expenses");
            foreach ($expensesValdata as $expensesVal) {
              $Total_exp_amount += (float)$expensesVal['amount'];
            }
?>
<script type="text/javascript">
  $("#total_amount_adsr").val(<?php echo $Total_exp_amount; ?>);
</script>
            
<?php
            if( $_POST['voucher_no'] != '' ){
                $db->where('voucher',$_POST['voucher_no']);
            }
            if( $_POST['paid_from'] != '' ){
                $db->where('account_id',$_POST['paid_from']);
            }
            if( $_POST['expense_type'] != '' ){
                $db->where('exp_type_id',$_POST['expense_type']);
            }
            if( $_POST['amount_from'] != '' &&  $_POST['amount_to'] != '' ){
                
                $am_from=$_POST['amount_from'];
                $am_to=$_POST['amount_to'];
                $db->where ("amount BETWEEN ".$am_from." AND ".$am_to."  ");
                
            }
            if( $_POST['date_from'] != '' &&  $_POST['date_to'] != '' ){
                
                $date_from=$_POST['date_from'];
                $date_to=$_POST['date_to'];
                $db->where('exp_date', Array ($date_from, $date_to ), 'BETWEEN');
            }
            $expensesdata = $db->get("expenses");
            ?>
            <table id="order-listing" class="table">
                <thead>
                  <tr>
                      <th class="th-set text-center">Voucher No.</th>
                      <th class="th-set text-center">Date</th>
                      <th class="th-set text-center">Employee</th>
                      <th class="th-set text-center">Exp. Type</th>
                      <th class="th-set text-center">Exp. Detail</th>
                      <th class="th-set text-center">Paid from</th>
                      <th class="th-set text-center">Amount</th>
                      <th class="th-set text-center">Actions</th>
                  </tr>
                </thead>
                <tbody class="table-body">
            
            <?php
            foreach( $expensesdata as $expenses ){
                
                $expense_id = $expenses['id'];
                $encrypt = encode($expense_id);
                $exp_voucher = $expenses['voucher'];
                $client_id = $expenses['client_id'];
                $CliEncode = encode($client_id);
                $SalId = $expenses['salary_id'];
                $exp_name = $expenses['exp_type_name'];
                $exp_description = $expenses['description'];
                $exp_date = $expenses['exp_date'];
                $exp_acc_id = $expenses['account_id'];
                $AccEncode = encode($exp_acc_id);
                $exp_acc_num = $expenses['account_num'];
                $exp_amount = $expenses['amount'];
                $exp_type_id = $expenses['exp_type_id'];
                $ExpTyEncode = encode($exp_type_id);
                $exp_category = $expenses['category'];
                $db->where("id",$exp_type_id);
                $exp_typedata = $db->getOne("exp_type");
                $exp_type_name = ($exp_typedata && isset($exp_typedata['type_name'])) ? $exp_typedata['type_name'] : 'Unknown Type';


                $db->where("id",$exp_acc_id);
                $AccData = $db->getOne("account");
                $AccNumber = ($AccData && isset($AccData['account_number'])) ? $AccData['account_number'] : 'Unknown Account';

                $db->where("id",$SalId);
                $SalaryData = $db->getOne("employee_salary");
                $EmplId = ($SalaryData && isset($SalaryData['employee_id'])) ? $SalaryData['employee_id'] : null;
                $EmplEncode = $EmplId ? encode($EmplId) : '';

                if ($EmplId) {
                    $db->where("employee_id",$EmplId);
                    $EmplData = $db->getOne("employee");
                    $EmplName = ($EmplData && isset($EmplData['name'])) ? $EmplData['name'] : 'Unknown Employee';
                } else {
                    $EmplName = 'Unknown Employee';
                }
                ?>
                <tr>
                  <td class="td1-set text-center"><?php echo $exp_voucher;?></td>
                  <td class="td1-set text-center"><?php echo date("d-m-Y", strtotime($exp_date)); ?></td>
                  <td class="td1-set text-center"><a class="text-cli" href="<?php echo baseurl('pages/company-register/employee-expenses.php'); echo '?emp_id='.$EmplEncode; ?>"><?php echo $EmplName;?></a></td>
                  <td class="td1-set text-center"><a class="text-cli" href="<?php echo baseurl('pages/company-register/type-wise-expenses.php'); echo '?type_id='.$ExpTyEncode; ?>"><?php echo $exp_type_name.'  '.'<span class="text-success"> '.'('.$exp_category.')'.'</span>'; ?></a></td>
                  <td class="td1-set text-center wdt-st"><?php echo $exp_description; ?></td>
                  <td class="td1-set text-center"><a class="text-cli" href="<?php echo baseurl('pages/company-register/account-wise-expenses.php'); echo '?acc_id='.$AccEncode; ?>"><?php if ($AccNumber == '') { echo $exp_acc_num; }else{echo $AccNumber;  } ?></a></td>
                  <td class="td1-set text-center"><?php echo number_format($exp_amount); ?></td>
                  <td class="td1-set text-center">
                    <div class="dropdown">
                      <button class="btn-mac-action dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                        <?php if ($view == 1) { ?>
                        <a class="dropdown-item" onclick="viewmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#viewModal"><i class="mdi mdi-eye text-dark"></i>View</a>
                        <?php }if($edit == 1){ ?>
                        <a class="dropdown-item" onclick="editmodal('<?php echo $encrypt; ?>')" data-toggle="modal" data-target="#exampleModal"><i class="mdi mdi-pencil text-dark"></i>Edit</a>
                        <?php }if($delete == 1){ ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick="myFunction('<?php echo $invoice_id; ?>')"><i class="mdi mdi-delete text-dark"></i>Delete</a>
                        <?php } ?>
                      </div>
                    </div>
                  </td>
                </tr>
                
                
                <?php
                
                
            } 
            ?>
                </tbody>
            </table>
            
            <script>
                SetDataTable();
            </script>
            
            <?php
            
        }
        
        
        
        
    }
?>