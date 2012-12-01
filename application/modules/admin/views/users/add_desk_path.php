

<script>
    $(document).ready(function(){
        $("#filter_desk").validate();
    });
</script>
<h1>Desk Path</h1>		
<hr /> 

<a class="add-link" href="<?php echo site_url(); ?>admin/settings/add_desk_path">Add</a>
<div style="clear: both;"></div><br>

<fieldset>
    <legend><span class="bangla">Find Desk Path</span></legend>

            <form action="<?php echo site_url(); ?>admin/settings/search_desk_path" method="post" id="filter_desk">


                <p>     
                    <?php echo form_error('present_desk_search'); ?>    
                    <label for="dropdown">Present Desk</label>
                    <select name="present_desk_search" class="dropdown" style="width: 250px;">
                        <option selected="selected" value="">Select</option>
                        <?php foreach ($get_desk as $row1)
                        { ?>
                            <option value="<?php echo $row1['desk_id']; ?>"><?php echo $row1['name']; ?></option>
<?php } ?>
                    </select>
                </p>

                <p>  
<?php echo form_error('present_status_search'); ?>       
                    <label for="dropdown">Present Status</label>
                    <select name="present_status_search" class="dropdown" style="width: 250px;">
                        <option selected="selected" value="">Select</option>
                        <?php foreach ($get_status as $row)
                        { ?>
                            <option value="<?php echo $row['status_id']; ?>"><?php echo $row['name']; ?></option>
<?php } ?>
                    </select>
                </p>
                <p>
                    <label></label>
                    <input class="button" type="submit" value="Find"  />          
                    <input class="button" type="reset" value="Reset"  />  
                    
                </p>
            </form>
            </legend>
            </fieldset>

    <h2><?php echo $this->session->flashdata('exception1'); ?></h2>
       <h2><?php echo $this->session->flashdata('exception'); ?></h2>