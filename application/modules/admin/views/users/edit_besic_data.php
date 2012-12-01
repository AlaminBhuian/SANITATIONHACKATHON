<script>
    $(document).ready(function(){
        $("#submit_edit_sub_category").validate(
{
            rules: {
                short_order: {                    
                    maxlength: 9
                },
                sub_category: {                    
                    maxlength: 95
                }
            }
        }    
);
    });
</script>
<h1>Basic Data</h1>		
<hr />

<?php echo validation_errors(); ?>
<fieldset>
    <legend><span class="bangla">Edit Basic Data</span></legend>
    

    <form action="<?php echo site_url(); ?>admin/settings/submit_edit_setup_besic_sub_data" method="post" id="submit_edit_sub_category"> 
        <?php echo form_error('dropdown_category'); ?>   
        <?php echo form_error('sub_category'); ?>
        <?php foreach ($edit_besic_data as $row)
        {
            ?>


            <p>      
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
                <label for="dropdown">Category<span style="color: red;">*</span></label>
                <select name="dropdown_category" class="required dropdown" style="width: 250px;">
                    <option selected="selected" value="">Select</option>
                    <?php foreach ($get_besic_data as $row1)
                    {
                        ?>
                        <option value="<?php echo $row1['id']; ?>" <?php if ($row['intBasicCategoryId'] === $row1['id'])
                        {
                            ?>selected="selected"<?php } ?>><?php echo $row1['varCategoryName']; ?></option>
    <?php } ?>
                </select>
            </p>

            <p>
                <label for="lf">Sub Category<span style="color: red;">*</span></label>
                <input class="required lf" maxlength="95" name="sub_category" type="text" value="<?php echo $row['varName'] ?>" />
            </p>



            <p>
                <label for="lf">Sort Order</label>
                <input class="required lf number" maxlength="9" name="short_order" type="text" value="<?php echo $row['sortOrder'] ?>" />
                <span>0 to 9</span>
            </p>
            <p>        
                <label for="dropdown">Status<span style="color: red;">*</span></label>
                <select name="enustatus" class="required dropdown" style="width: 250px;">
                    <option selected="selected" value="">Select</option>
                    <option value="active" <?php if ($row['enuStatus'] === 'active')
    {
        ?>selected="selected"<?php } ?>>Active</option>
                    <option value="inactive" <?php if ($row['enuStatus'] === 'inactive')
    {
        ?>selected="selected"<?php } ?>>Inactive</option>

                </select>
            </p>

<?php } ?>

        <p>
            <label></label>
            <input class="button" type="submit" value="Update" />
            <input class="button" type="reset" value="Reset" />
        <a href="<?php echo base_url(); ?>admin/settings/setup_besic_data" />Back</a> 
        </p>
    </form> 
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>