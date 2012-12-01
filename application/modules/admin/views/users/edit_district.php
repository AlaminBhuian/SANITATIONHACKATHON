<script>
    $(document).ready(function(){
        $("#edit_district").validate(
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
<fieldset>
    <legend>Edit District/Zilla</legend>
             
    <form action="<?php echo site_url(); ?>admin/settings/submit_edit_district" method="post" id="edit_district">
        <p>
            <?php echo form_error('district_name'); ?> 
            <label for="sf">District/Zilla</label>
            <?php foreach ($edit_district as $row)
            {
                ?>

            <input class="required lf" maxlength="45" name="district_name" type="text" value="<?php echo $row['district_name'] ?>" />
                <input type="hidden" name="district_id" value="<?php echo $row['district_id'] ?>"/>
<?php } ?>
        </p>
        <p>
            <label></label>
            <input class="button" type="submit" value="Update" />
            <input class="button" type="reset" value="Reset" />

        </p>
    </form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>