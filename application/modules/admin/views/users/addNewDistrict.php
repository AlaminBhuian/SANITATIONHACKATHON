<script>
    $(document).ready(function(){
        $("#add_district").validate(
            {
                rules: 
                {
                    district_name: {                    
                    maxlength: 45
                }
                }
            }    

);
    });
</script>
<h1>District/Zilla</h1>		
<hr /> 
<?php echo validation_errors(); ?>
<fieldset>
    <legend>Add District/Zilla</legend>

 
<form action="<?php echo site_url(); ?>admin/settings/submit_district" method="post" id="add_district">
    <p>
        <label for="lf">District/Zilla</label>
        <input class="required lf" maxlength="45" name="district_name" type="text" value="<?php echo set_value('district_name'); ?>" />
        
    </p>

    <p>
        <label></label>
        <input class="button" type="submit" value="Save" />          
        <input class="button" type="reset" value="Reset" /> 
        <a href="<?php echo base_url(); ?>admin/settings/add_district" />Back</a> 
    </p>

</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>
</form>