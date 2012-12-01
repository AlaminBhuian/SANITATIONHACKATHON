<script>
    $(document).ready(function(){
        $("#edit_status").validate(
        {
            rules: {
                name: {                    
                    maxlength: 75
                }
            }
        }

        );
    });
</script>
<h1>Status</h1>		
<hr />
<?php echo validation_errors(); ?>
<fieldset>
    <legend><span class="bangla">Edit Status</span></legend>

    <form action="<?php echo site_url(); ?>admin/settings/submit_edit_status" method="post" id="edit_status">
        <?php foreach ($edit_status as $row)
        {
            ?>


            <p>
    <?php echo form_error('name'); ?>
                <label for="lf">Status</label>

                <input class="required lf" name="name" type="text" value="<?php echo $row['name'] ?>" maxlength="75" />
                <input type="hidden" name="status_id" value="<?php echo $row['status_id'] ?>"/>


            </p>
            <p>
                <label for="lf">Current Status</label>
                <select name="enmstatus" class="required dropdown" style="width: 250px;">
                    <option selected="selected" value="Active">Select</option>            
                    <option value="Active" <?php if ($row['status'] === 'Active')
    {
        ?>selected="selected"<?php } ?>>Active</option>
                    <option value="Inactive" <?php if ($row['status'] === 'Inactive')
                        {
                            ?>selected="selected"<?php } ?>>Inactive</option>               
                </select>
            </p>

            <p>
                <label for="lf">Mode</label>
                <select name="mode" class="required dropdown" style="width: 250px;">
                    <option selected="selected" value="">Select</option>            
                    <option value="Close" <?php if ($row['mode'] === 'Close')
                        {
                            ?>selected="selected"<?php } ?>>Close</option>
                    <option value="Halt" <?php if ($row['mode'] === 'Halt')
                        {
        ?>selected="selected"<?php } ?>>Halt</option>
                    <option value="Initiate" <?php if ($row['mode'] === 'Initiate')
                    {
                        ?>selected="selected"<?php } ?>>Initiate</option>
                    <option value="Process" <?php if ($row['mode'] === 'Process')
                    {
                        ?>selected="selected"<?php } ?>>Process</option>
                </select>

            </p>

<?php } ?>
        <p>
            <label></label>
            <input type="submit" class="button" value="Update" />          
            <input type="reset" class="button" value="Reset" /> 
            <a class="" href="<?php echo site_url(); ?>admin/settings/complaint_status" >Back</a>
        </p>
    </form>

</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>
