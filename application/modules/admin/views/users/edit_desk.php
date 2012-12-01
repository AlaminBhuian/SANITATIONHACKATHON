<script>
    $(document).ready(function(){
        $("#edit_desk").validate(
{
            rules: {
                desk_name: {                    
                    maxlength: 95
                }
            }
        }    
    

);
    });
</script>
<h1>Desk</h1>		
<hr /> 

<fieldset>
    <legend>Edit Desk</legend>
    

    <form action="<?php echo site_url(); ?>admin/settings/submit_edit_desk" method="post" id="edit_desk">
        <?php echo validation_errors(); ?>
        <?php foreach ($edit_desk as $row)
        { ?>


            <p>
                <label for="lf">Title</label>
                <input class="required lf" maxlength="95" name="desk_name" type="text" value="<?php echo $row['name']; ?>" />

                <input type="hidden" name="desk_id" value="<?php echo $row['desk_id']; ?>"/>
            </p>
            <p>     
                <label for="lf">Status</label>
                <select class="required dropdown" name="status" style="width: 250px;">
                    <option value="">Select</option>
                    <option value="active" <?php if ($row['status'] === 'Active')
            { ?>selected="selected"<?php } ?>>Active</option>
                    <option value="inactive" <?php if ($row['status'] === 'Inactive')
            { ?>selected="selected"<?php } ?>>Inactive</option>                
                </select>

            </p>   
<?php } ?>
        <p>
            <label></label>
            <input name="Submit" type="submit" class="button" value="Update" />          
            <input name="Submit2" type="reset" class="button" value="Reset" />
            <a class="" href="<?php echo site_url(); ?>admin/settings/add_desk" >Back</a>
        </p>
    </form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>