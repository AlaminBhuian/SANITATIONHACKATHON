<h1>User Account</h1>
<hr />
<p> <a class="add-link" href="<?php echo base_url();?>admin/settings/add_user" />Add</a> </p>
<div style="clear: both;"></div>
<fieldset>
<legend>Find User</legend>
<form action="<?php echo base_url('admin/settings/search_user');?>" method="post" >
<p>
    <label for="sf">Full Name</label>
    <input type="search" class="required lf" name="search">
  </p>
  <p>
    <label for="dropdown">Select desk</label>
    <select name="desk" class="required dropdown" style="width: 250px;">
      <option selected="selected" value="">Select</option>
      <?php foreach ($get_desk as $row1) {?>
      <option value="<?php echo $row1['desk_id'];?>"><?php echo $row1['name'];?></option>
      <?php }?>
    </select>
  </p>
  <p>
    <label for="dropdown">Select Status</label>
    <select name="status" class="required dropdown" style="width: 250px;">
        <option selected="selected" value="">Select</option>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
      
    </select>
  </p>
  <p>
      <label></label>
    <input name="submit" type="submit"  class="button" value="Find" />
    <input name="Reset" type="reset"  class="button" />
  </p>  
</form>
</fieldset>

<h2><?php echo $this->session->flashdata('exception');?></h2>

