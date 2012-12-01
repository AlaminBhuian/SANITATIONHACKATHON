<script>
  $(document).ready(function(){
    $("#add_category").validate();
  });
  </script> 
<h1>Add Category</span> !</h1>		
                <hr /> 

<fieldset>
    <legend><span class="bangla">Add Category</span></legend>
<h2<h2><?php echo $this->session->flashdata('exception1');?></h2>
<form action="<?php echo site_url();?>admin/settings/submit_setup_besic_data" method="post" id="add_category">
<p>
            <label for="lf"><span class="bangla">Add Category Name</label>
            <input class="required sf" name="category" type="text" />
            <?php echo form_error('category'); ?>
</p>

<p>
            <input class="button" type="submit" value="Save" />          
</p>
</form>
    
</fieldset>