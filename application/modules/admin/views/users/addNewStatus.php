<script>
    $(document).ready(function(){
        $("#add_status").validate(
        {
            rules: {
                status: {                    
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
    <legend><span class="bangla">Add Status</span></legend>

    <form action="<?php echo site_url(); ?>admin/settings/submit_add_status" method="post" id="add_status">
        <p>
            <label for="lf">Status</span></label>
            <input class="required lf" name="status" maxlength="75" type="text" />
            <?php echo form_error('status'); ?>
        </p>
        <p>
            <label for="lf">Current Status</label>
            <select name="enmstatus" class="required dropdown" style="width: 250px;">
                <option selected="selected" value="Active">Select</option>            
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>               
            </select>
        </p>
         <p>
            <label for="lf">Mode</label>
            <select name="mode" class="required dropdown" style="width: 250px;">
                <option selected="selected" value="">Select</option>            
                <option value="Close">Close</option>
                <option value="Halt">Halt</option>
                <option value="Initiate">Initiate</option>
                <option value="Process">Process</option>
            </select>

        </p>

        <p>
            <label></label>
            <input class="button" type="submit" value="Save" /> 
            <input type="reset" class="button" value="Reset" />
            <a class="" href="<?php echo site_url(); ?>admin/settings/complaint_status" >Back</a>
        </p>
    </form>

</fieldset>

<h2><?php echo $this->session->flashdata('exception'); ?></h2>