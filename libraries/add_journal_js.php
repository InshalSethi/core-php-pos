<script type="text/javascript">
  var id=2;
    function addmore(){

      $('#myTable tr.grand-total').before('<tr class="del"><td class="set-td-padding bg-white text-center"><a onclick="remove()" class="badge badge-danger" href="#"><i class="mdi mdi-minus"></i></a></td><td class="set-td-padding bg-white text-center"><div class="form-group row"><div class="col-sm-12"><select name="chrt_acc[]" class="form-control chrt_acc" required value=""><option value="">Select Any</option><?php 
                                          $db->where("status",'1');
                                          $AccGroupData = $db->get("account_group");
                                          foreach ($AccGroupData as $AccGroup) {
                                            $accGroupId = $AccGroup['id'];
                                            $accGroupName = $AccGroup['account_group_name'];
                                        ?><optgroup label="<?php echo $accGroupName; ?>"><?php 
                                            $db->where("acc_group",$accGroupId);
                                            $db->where("status",'1');
                                            $chartAccData = $db->get("chart_accounts");
                                            foreach ($chartAccData as $chartAcc) {
                                              $ChartID = $chartAcc['chrt_id'];
                                              $ChartName = $chartAcc['account_name'];
                                          ?><option value="<?php echo $ChartID; ?>"><?php echo $ChartName; ?></option><?php } ?></optgroup><?php } ?></select></div></div></td><td class="set-td-padding bg-white text-center"><div class="form-group row"><div class="col-sm-12"><input type="text" name="remarks[]" class="form-control remarks" value="" placeholder="Write Remarks"/></div></div></td><td class="set-td-padding bg-white text-center"><div class="form-group row"><div class="col-sm-12"><input type="text" name="debit[]" class="form-control debit" value="0" Placeholder="Enter Debit"/></div></div></td><td class="set-td-padding bg-white text-center"><div class="form-group row"><div class="col-sm-12"><input type="text" name="credit[]" class="form-control credit" value="0" Placeholder="Enter Credit" autocomplete="off"/></div></div></td></tr>');
      calculation(id);
        
        id++;
        
    }
    function remove(){
      $('.del').last().remove(); 
        id--;
    }

    function calculation(new_id){

      $(".debit").keyup(function(){

            var sum_debit = 0;
            var sum_credit = 0;

            $(".debit").each(function(){
                sum_debit += +$(this).val();
            });

            $(".total_debit").val(sum_debit);

            $(".credit").each(function(){
                sum_credit += +$(this).val();
            });

            $(".total_credit").val(sum_credit);

            // var totalDebit = $(".total_debit").val();

            if(sum_debit == sum_credit){

              $(".total_credit").css("background", "#00b20094");
              $(".total_debit").css("background", "#00b20094");

            }else{
              $(".total_debit").css("background", "#ff5454");
              $(".total_credit").css("background", "#ff5454");
            }

      });

      $(".credit").keyup(function(){

            var sum_debit = 0;
            var sum_credit = 0;

            $(".debit").each(function(){
                sum_debit += +$(this).val();
            });

            $(".total_debit").val(sum_debit);

            $(".credit").each(function(){
                sum_credit += +$(this).val();
            });

            $(".total_credit").val(sum_credit);

            // var totalDebit = $(".total_debit").val();

            if(sum_debit == sum_credit){

              $(".total_credit").css("background", "#00b20094");
              $(".total_debit").css("background", "#00b20094");

            }else{
              $(".total_debit").css("background", "#ff5454");
              $(".total_credit").css("background", "#ff5454");
            }
          
      });

      }
</script>