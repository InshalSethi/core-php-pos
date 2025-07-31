<?php
    include '../../include/config_new.php';
    include '../../include/functions.php';
    include '../../include/MysqliDb.php';
    include '../../include/config.php';
    include '../../include/permission.php';
    
    if($_POST['action']){

    	$action=$_POST['action'];
        $authkey=$_POST['authkey'];
        
        if( $action == 'trial_search' &&  $authkey == 'dabdsjjI81sa' ){

            ?>
            <div class="trial">
                <?php  
                  $ac_tp = 1;
                  $AccTypeData = $db->get("account_type");
                  foreach ($AccTypeData as $AccType) {
                    $AccTypeId = $AccType['id'];
                    $AccTypeName = $AccType['name'];
                ?>
                <div class="col-md-12">
                  <h3 class="acc-typ"><?php echo 'Type - '.$ac_tp.' : '.$AccTypeName; ?></h3>
                  <div class="row">
                    <?php 
                      $ac_grp = 1;
                      $db->where("acc_type_id",$AccTypeId);
                      $AccGroupData = $db->get("account_group");
                      foreach ($AccGroupData as $AccGroup) {
                        $AccGroupId = $AccGroup['id'];
                        $AccGroupName = $AccGroup['account_group_name']; 

                    ?>
                    <div class="col-md-12">
                      <h4 class="acc-grp"><?php echo 'Group - '.$ac_grp.' : '.$AccGroupName; ?></h4>
                      <div class="row">
                        <?php
                          $db->where("acc_group",$AccGroupId);
                          $ChartAccData = $db->get("chart_accounts");
                          foreach ($ChartAccData as $ChartAcc) {
                            $ChartAccId = $ChartAcc['chrt_id'];
                            $ChartAccName = $ChartAcc['account_name'];

                            if( $_POST['date_from'] != '' &&  $_POST['date_to'] != '' ){
                
				                $date_from=$_POST['date_from'];
				                $date_to=$_POST['date_to'];
				                $db->where('created_at', Array ($date_from, $date_to ), 'BETWEEN');
				            }

                            $db->where("chrt_id",$ChartAccId);
                            $JournalMetaData = $db->get("journal_meta");

                            $Debit = 0;
                            $Credit = 0;
                            foreach ($JournalMetaData as $JournalMeta) {

                              $Debit += $JournalMeta['debit'];
                              $Credit += $JournalMeta['credit'];
                            }

                        ?>
                        <div class="col-md-12">
                          <div class="chrt-dv">
                            <div class="table-responsive">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td class="st-td"><?php echo $ChartAccName; ?></td>
                                    <td class="text-center st-td"><?php echo number_format($Debit); ?></td>
                                    <td class="text-center st-td"><?php echo number_format($Credit); ?></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                    <?php $ac_grp++; } ?>
                  </div>
                </div>
                <?php $ac_tp++; } ?>
                <div class="col-md-12">
                  <h3 class="total-end">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                          	if( $_POST['date_from'] != '' &&  $_POST['date_to'] != '' ){
                
				                $date_from=$_POST['date_from'];
				                $date_to=$_POST['date_to'];
				                $db->where('created_at', Array ($date_from, $date_to ), 'BETWEEN');
				            }

                            $JMetaTotal = $db->get("journal_meta");

                            $TotalDebit = 0;
                            $TotalCredit = 0;
                            foreach ($JMetaTotal as $JMeta) {

                              $TotalDebit += $JMeta['debit'];
                              $TotalCredit += $JMeta['credit'];
                            }  
                          ?>
                          <tr>
                            <td class="st-td td-bg">Total</td>
                            <td class="text-center st-td td-bg"><?php echo number_format($TotalDebit); ?></td>
                            <td class="text-center st-td td-bg"><?php echo number_format($TotalCredit); ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </h3>
                </div>
          	</div>
<?php
        }
    }
?>