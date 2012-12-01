<div id="main">  
<div id="showMsg"></div> 
<div id="divUpdatedReminder">
<form action="<?php echo site_url('complaint/reminder/saveReminder');?>" method="post"  name="frmReminder" id="frmReminder">
  <fieldset id="blockReminder">
  <legend>Set Reminder</legend>
  <p>
    <label>Reminder Note<span class="red"> *</span></label>
    <textarea name="txtReminderNote[]" class="wysiwyg required" style="width:450px;height:50px;" ></textarea>
  </p>
  <p>
    <label for="sf">Alert Date (dd-mm-yyyy)<span class="red"> *</span></label>
    <input name="txtAlertDT[]" type="text" class="sf datePicCal dateISO required" value="" maxlength="10" style="width:70px;"/>
    <span class="bangla">সময় </span>(Time)
    <select name="selAlertTimeHr[]" class="dropdown" id="selAlertTimeHr" style="width:60px;">
      <option value="0">Hr</option>
      <?php for($i=1;$i<=12;$i++) {?>
      <option value="<?php echo $i;?>"><?php echo $i;?></option>
      <?php }?>
    </select>
    <select name="selAlertTimeMin[]" class="dropdown" id="selAlertTimeMin" style="width:60px;">
      <option value="0">Min</option>
      <?php for($i=0;$i<60;$i++) {?>
      <option value="<?php echo $i;?>"><?php echo $i;?></option>
      <?php }?>
    </select>
    <select name="selAlertTimeAMPM[]" class="dropdown" id="selAlertTimeAMPM" style="width:60px;">
      <option value="AM" selected="selected">AM</option>
      <option value="PM">PM</option>
    </select>
  </p>
  <p>
    <label for="sf">Ends Date (dd-mm-yyyy)</label>
    <input name="txtEndDate[]" type="text" class="sf datePicCal dateISO" id="selEndDate" value="" maxlength="10" style="width:70px;" />
    <span class="bangla">সময় </span>(Time)
    <select name="selEndTimeHr[]" class="dropdown" id="selEndTimeHr" style="width:60px;">
      <option value="0">Hr</option>
      <?php for($i=1;$i<=12;$i++) {?>
      <option value="<?php echo $i;?>"><?php echo $i;?></option>
      <?php }?>
    </select>
    <select name="selEndTimeMin[]" class="dropdown" id="selEndTimeMin" style="width:60px;">
      <option value="0">Min</option>
      <?php for($i=0;$i<60;$i++) {?>
      <option value="<?php echo $i;?>"><?php echo $i;?></option>
      <?php }?>
    </select>
    <select name="selEndTimeAMPM[]" class="dropdown" id="selEndTimeAMPM" style="width:60px;">
      <option value="AM">AM</option>
      <option value="PM">PM</option>
    </select>
  </p>
  <p>
    <label>Remind To &nbsp;</label>
    <select name="selRemindTo[]" class="dropdown" id="selRemindTo" style="width:270px;">
      <option value="self">Self Reminder</option>
      <option value="all">Alert to All Users</option>
      <option value="desk">Remind to Present Desk User</option>
    </select>
  </p>
  <div style="font-size:16px;text-align:right;"><a id="removeMore" href="">[-] Remove</a> <a id="addMore" href="">[+] Add More Reminder</a></span></div>
  </fieldset>
  <p>
    <label></label>
    <input class="button" type="submit" value="Set Reminder" />
    <input class="button" type="reset" value="Reset" />
    <input type="hidden" name="complaint_id" value="<?php echo $complaint_id; ?>"/>
  </p>
</form>
<?php 
	if(isset($reminderList) && count($reminderList) > 0 )
	{
		$this->load->view('reminder_list'); 
	}	
?>

<script type="text/javascript" src="<?php echo site_url('assets/js/jquery-dynamic-form.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {				 
		
		$(".datePicCal").bind("focus click", function(e){	
			var pickerOpts = {
				dateFormat:"dd-mm-yy",
				showOn: "button",
				buttonImage: "assets/images/icons/cal.gif",
				buttonImageOnly: true
			};
			$(this).datepicker(pickerOpts);
		});	
		
		var options = {
			type: 'POST',
			async: false,
			target: '#showMsg', 
			beforeSubmit: function() {},
			success: function(data) {
				<?php 
					if(isset($reminderList) && count($reminderList) > 0 )
					{
				?>	
					$.ajax({
					  url: '<?php echo site_url('complaint/reminder/add/'); ?>/<?php echo $complaint_id; ?>',
					  success: function(data) {
						$('#divUpdatedReminder').html(data);
					  }
					});	
				<?php }	else { ?>
					$('#frmReminder').resetForm();
				<?php }	?>			
			}
		};	
		
		jQuery("#frmReminder").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		});
		
		$("#blockReminder").dynamicForm("#addMore", "#removeMore", {limit:10});
                
  });

</script>
</div>
</div>