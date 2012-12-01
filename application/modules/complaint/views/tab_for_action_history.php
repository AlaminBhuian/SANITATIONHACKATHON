<div id="showHistory"> 
<?php 	
if(count($statusList) > 0) { ?>
<fieldset>
<legend>My Action</legend>
<form name="frmComplaintProcess" id="frmComplaintProcess" method="post" action="<?php echo site_url('complaint/saveComplaintProcess');?>">
  <p>
    <label>Process Status <span class="red"> *</span></label>
    <select name="selCompalintStatus" class="required dropdown" id="selCompalintStatus" style="width:460px;">
      <option selected="selected" value="">Select</option>
      <?php foreach($statusList as $item): ?>
      <option value="<?php echo $item['status_id']; ?>"><?php echo $item['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </p>
  <div id="reasons"> </div>
  
  <?php if(count($deskList) > 0) { ?>
  <p>
    <label>Forward to Desk <span class="red"> *</span></label>
    <select name="selDesk" class="required dropdown" id="selDesk" style="width:460px;">
      <?php foreach($deskList as $item): ?>
      <option value="<?php echo $item['desk_id']; ?>"><?php echo $item['name']; ?></option>
      <?php endforeach; ?>
    </select>
   </p>
  <?php } ?>
  
  <?php if(count($statusList) > 0 && count($deskList) == 0) { ?>
	<input type="hidden" value="<?php echo $complaintInfo->present_desk; ?>" name="selDesk" />
  <?php } ?>
  <p>
    <label>Remarks / Notes <span class="red"> *</span></label>
    <textarea name="txtRemarks" id="txtRemarks" style="width:450px;height:70px;" class="required"></textarea>
  </p>
  <p>
  <label>&nbsp;</label>
    <input class="button" type="submit" value="Apply" />
    <input class="button" type="reset" value="Clear" />
    <input name="hidCompalintID" type="hidden" id="hidCompalintID" value="<?php echo $complaintInfo->complaint_id; ?>"/>
    <input name="hidPresentStatus" type="hidden" id="hidPresentStatus" value="<?php echo $complaintInfo->present_status; ?>"/>
  </p>
</form>
</fieldset>
<script type="text/javascript">
    $("#selCompalintStatus").change(function () {
		  $.get('<?php echo site_url('complaint/getReasonsList/'); ?>/' + $(this).val(), function(data) {
			  $('#reasons').html(data);
		  });
      });
	  
	$(document).ready(function() {		
		var options = {
			type: 'POST',
			async: false,
			target: '#showHistory', 
			beforeSubmit: function() {},
			success: function(data) {}
		};	
		
		jQuery("#frmComplaintProcess").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		});                
  	});
  
</script>
<?php } ?>


	<?php $this->load->view('complaint/compalint_history'); ?>
</div>




