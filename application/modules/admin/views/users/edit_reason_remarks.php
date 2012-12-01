<script>
  $(document).ready(function(){
    $("#edit_reason_remarks").validate(
        {
            rules: {
                reason: {                    
                    maxlength: 75
                }
            }
        }
    );
  });
  </script>
<h1>Status Reason</h1><hr />

<fieldset>
<legend>Edit Status Reason</legend>
<form action="<?php echo site_url();?>admin/settings/submit_edit_reason_remarks" method="post" id="edit_reason_remarks">
  <?php echo form_error('reason_status'); ?> <?php echo form_error('reason'); ?>
  <?php foreach ($edit_reason as $reason) {?>

  <p>
    <label for="dropdown">Status</label>
    <select name="reason_status" class="required dropdown" style="width:350px;">
      <option selected="selected" value="">Select</option>
      <?php foreach ($get_status as $row) {?>
      <option value="<?php echo $row['status_id'];?>" <?php if ($row['status_id']===$reason['status_id']) {?>selected="selected"<?php }?>><?php echo $row['name'];?></option>
      <?php }?>
    </select>
    <input type="hidden" name="reason_remarks_id" value="<?php echo $reason['reason_remarks_id']; ?>" />
              </p>
  <p>
    <label for="lf">Status Reason</label>
    <input class="required lf" name="reason" type="text" maxlength="75"m value="<?php echo $reason['name'];?>" />
  </p>
    <p><label>Allow Value</label>
    <label style="width:70px;"><input type="radio" name="is_value" value="yes" <?php if ($reason['is_value'] =='yes'){?>checked="checked"<?php }?>/>
    Yes</label>
    <label style="width:70px;"><input type="radio" name="is_value" value="no" <?php if ($reason['is_value'] =='no'){?>checked="checked"<?php }?>/>
    No</label>
	</p>

  <?php }?>
  <p>
      <label></label>
    <input class="button" type="submit" value="Update" />
    <input class="button" type="reset" value="Reset" />
    <a class="" href="<?php echo site_url(); ?>admin/settings/reason_remarks" >Back</a>
  </p>
</form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception');?></h2>