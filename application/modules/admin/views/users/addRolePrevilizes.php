<script>
  $(document).ready(function(){
    $("#add_role_previlizes").validate();
  });
</script>

<h1>Role Privileges!</h1>
<hr />
<fieldset>
<legend><span class="bangla">Add Role Privileges </span></legend>
<form action="<?php echo site_url();?>admin/settings/submitAddRolePrevilizes" method="post" id="add_role_previlizes">
  <p> <?php echo form_error('desk'); ?>
    <label for="dropdown">Desk</label>
    <select name="desk" class="required dropdown" style="width:250px;">
      <option selected="selected" value="">Select</option>
      <?php foreach ($get_desk as $row1)
            {
          if($row1['desk_id']!=1){
          ?>
      <option value="<?php echo $row1['desk_id']; ?>"><?php echo $row1['name']; ?></option>
      <?php }} ?>
    </select>
  </p>
  <h2>List of Roles</h2>
  <?php foreach ($get_role as $row)
    { ?>
  <h3>
    <input type="checkbox" class="checkbox required" name="role[]" value="<?php echo $row['id'] ?>">
    <?php echo $row['varRole'] ?></h3>
  <br/>
  <?php } ?>
  <p>
    <input class="button" type="submit" value="Save"  />
    <input class="button" type="reset" value="Reset"  />
    <a class="" href="<?php echo site_url(); ?>admin/settings/role_previlizes" >Back</a>
  </p>
</form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>