<script>
  $(document).ready(function(){
    $("#reason_remarks").validate();
  });
</script>

<h1>Status Reason</h1>
<hr />
<a class="add-link" href="<?php echo site_url(); ?>admin/settings/add_reason_remarks">Add</a>
<div style="clear: both;"></div>
<br>
<fieldset>
<legend>Find Status Reason</legend>
<form action="<?php echo site_url(); ?>admin/settings/search_reason_remarks" method="post" name="reason_remarks" id="reason_remarks">
  <br/>
  <?php echo form_error('reason_status'); ?> <?php echo form_error('reason'); ?>
  <p>
    <label for="dropdown">Status </label>
    <select name="reason_status" class="dropdown" style="width:250px;">
      <option selected="selected" value="">Select</option>
      <?php foreach ($get_status as $row)
                {
                    ?>
      <option value="<?php echo $row['status_id']; ?>"><?php echo $row['name']; ?></option>
      <?php } ?>
    </select>
  </p>
  <p>
    <label for="lf">Status Reason</label>
    <input class="lf" name="reason" type="text" />
  </p>
  <p>
      <label></label>
    <input class="button" type="submit" value="Find" />
    <input name="Reset" type="reset" class="button" />
  </p>
</form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>


