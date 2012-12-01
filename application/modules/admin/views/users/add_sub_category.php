<script>
    $(document).ready(function(){
        $("#add_sub_category").validate({
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
    <legend><span class="bangla">Add Sub Category</span></legend>


    <form action="<?php echo site_url(); ?>admin/settings/submit_setup_besic_sub_data" method="post" id="add_sub_category"> 
        <?php echo form_error('dropdown_category'); ?>   
        <?php echo form_error('sub_category'); ?>

        <p>        
            <label for="dropdown">Category<span style="color: red;">*</span></label>
            <select name="dropdown_category" class="required dropdown" style="width: 250px;">
                <option selected="selected" value="<?php echo set_value('dropdown_category'); ?>">Select</option>
                <?php
                foreach ($get_besic_data as $row)
                {
                    ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['varCategoryName']; ?></option>
<?php } ?>
            </select>
        </p>


        <p>
            <label for="lf">Sub Category<span style="color: red;">*</span></label>
            <input class="required lf" name="sub_category" type="text" value="<?php echo set_value('sub_category'); ?>"/>
        </p>
        <p>
            <label for="lf">Sort Order</label>
            <input class="number" style="width: 235px;" name="short_order" maxlength="9" type="text" value="<?php echo set_value('short_order'); ?>" />
            <span> 0 - 9</span>
        </p>
        <p>        
            <label for="dropdown">Status<span style="color: red;">*</span></label>
            <select name="enustatus" class="required dropdown" style="width: 250px;">
                <option selected="selected" value="<?php echo set_value('enustatus'); ?>">Select</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </p>
        <p>
            <label></label>
            <input class="button" type="submit" value="Save" />
            <input class="button" type="reset" value="Reset" />
            <a  href="<?php echo base_url(); ?>admin/settings/setup_besic_data" />Back</a> 
        </p>
    </form> 
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>