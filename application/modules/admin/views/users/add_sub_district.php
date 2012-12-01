<script>
  $(document).ready(function(){
    $("#search_sub_distirct").validate();
  });
  </script> 

<h1>Upazilla/Thana</h1>
<hr />
<a class="add-link" href="<?php echo site_url(); ?>admin/settings/add_new_sub_district" >Add</a>
<div style="clear: both;"></div>
<br>
<fieldset>
<legend>Find Upazilla/Thana</legend>
<form action="<?php echo site_url(); ?>admin/settings/search_sub_district" method="post" id="search_sub_distirct">
  <p> <?php echo validation_errors(); ?>
    <label for="dropdown">District/Zilla</label>
    <select name="district" class="dropdown" style="width: 250px;">
      <option selected="selected" value="">Select</option>
      <?php foreach ($get_district as $row)  {  ?>
      <option value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
      <?php } ?>
    </select>
    <input name="submit" type="submit" class="button" value="Find" />
    <input type="reset" class="button" value="Reset" />
  </p>
</form>
</fieldset>

<h2><?php echo $this->session->flashdata('exception'); ?></h2>