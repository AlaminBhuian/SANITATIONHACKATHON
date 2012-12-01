<script>
    $(document).ready(function(){
        $("#search_status").validate();
    });
</script>

<h1>Status</h1>
<hr />
<a class="add-link" href="<?php echo site_url(); ?>admin/settings/addnewstatus" >Add</a>
<div style="clear: both;"></div>
<br>
<fieldset>
<legend><span class="bangla">Find Status</span></legend>
<form action="<?php echo site_url(); ?>admin/settings/search_status" method="post" id="search_status">
  <p>
    <label>Status </label>
    <input class="lf" name="search" type="text" />
    <?php echo form_error('status'); ?> 
    <input name="submit" type="submit" class="button" value="Find" />
    <input type="reset" class="button" value="Reset" />
    
  </p>
 </form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>