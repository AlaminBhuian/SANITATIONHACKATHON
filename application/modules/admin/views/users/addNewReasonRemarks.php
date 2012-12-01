<script>
  $(document).ready(function(){
    $("#add_reason_remarks").validate(
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

<h1>Status Reason</h1>
<hr />
<?php echo form_error('reason_status'); ?> <?php echo form_error('reason'); ?>
<fieldset>
<legend><span class="bangla">Add Status Reason</span></legend>
<form action="<?php echo site_url(); ?>admin/settings/submit_reason_remarks" method="post" id="add_reason_remarks">
  
  
  <p>
    <label for="dropdown">Status Name</label>
    <select name="reason_status" class="required dropdown" style="width:350px;">
      <option selected="selected" value="">Select</option>
      <?php foreach ($get_status as $row)
                { ?>
      <option value="<?php echo $row['status_id']; ?>"><?php echo $row['name']; ?></option>
      <?php } ?>
    </select>
  </p>
  <p>
    <label for="lf">Status Reason</label>
    <input class="required lf" name="reason" type="text" maxlength="75"/>
  </p>
  <p> <label>Allow Value</label>
      <label style="width:70px;"><input type="radio" name="is_value" value="yes"  />Yes</label>
    <label style="width:70px;"><input type="radio" name="is_value" value="no" checked="checked"/>No</label>
 </p>	
  <p>
      <label></label>
    <input class="button" type="submit" value="Save" />
    <input class="button" type="reset" value="Reset" />
    <a class="" href="<?php echo site_url(); ?>admin/settings/reason_remarks" >Back</a>
  </p>
</form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>