<script>
    $(document).ready(function(){
        $("#search_besic_data").validate();
    });
</script>

<h1>Basic Data</h1>
<hr />

<a class="add-link" href="<?php echo site_url(); ?>admin/settings/add_sub_category">Add</a>
<div style="clear: both;"></div>
<br>
<?php echo validation_errors(); ?>
<fieldset>
<legend>Find Basic Data</legend>
<form action="<?php echo site_url(); ?>admin/settings/search_besic_data" method="post" id="search_besic_data">
  <p>
    <label for="lf">Category</label>
    <select name="category" class="dropdown" style="width: 250px;">
      <option selected="selected" value="">Select</option>
      <?php
            foreach ($get_besic_data as $row)
            {
                ?>
      <option value="<?php echo $row['id']; ?>"><?php echo $row['varCategoryName']; ?></option>
      <?php } ?>
    </select>
    <input name="submit" type="submit" class="button" value="Find" />
    <input name="submit" type="reset" class="button" value="Reset" />
  </p>
</form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>

