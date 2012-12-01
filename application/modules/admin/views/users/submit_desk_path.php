<script>
    $(document).ready(function(){
        $("#add_desk_path").validate();        
    });
</script>

<h1>Desk Path</h1>		
<hr />
<?php if ($searchPage == 0)
{ ?>
    <fieldset>
        <legend><span class="bangla">Set Desk Path</span></legend>
        <form action="<?php echo site_url(); ?>admin/settings/search_desk_path_for_add" method="post" id="add_desk_path">

            <p>     
    <?php echo form_error('present_desk'); ?>    
                <label for="dropdown">If Complaint Existing Desk</label>
                <select name="present_desk" class="required dropdown" style="width: 250px;">
                    <option selected="selected" value="">Select</option>
                    <?php foreach ($get_desk as $row1)
                    {
                        ?>
                        <option value="<?php echo $row1['desk_id']; ?>"><?php echo $row1['name']; ?></option>
    <?php } ?>
                </select>
            </p>	

            <p>  
    <?php echo form_error('present_status'); ?>       

                <label for="dropdown">and Complaint Present Status</label>
                <select name="present_status" class="required dropdown" style="width: 250px;">
                    <option selected="selected" value="">Select</option>
                    <?php foreach ($get_status as $row)
                    {
                        ?>
                        <option value="<?php echo $row['status_id']; ?>"><?php echo $row['name']; ?></option>
    <?php } ?>
                </select>
            </p>
            <p>
                <label></label>
                <input class="button" type="submit" value="Set Desk Path" />             
                <a class="" href="<?php echo site_url(); ?>admin/settings/desk_path" >Back</a>
            </p>

        </form>
    </legend>
    </fieldset> 
    <h2><?php echo $this->session->flashdata('exception'); ?></h2>

    <?php } elseif ($searchPage == 1)
    { ?>

    <fieldset>
        <legend><span class="bangla"><?php if ($edit == 1)
    {
        echo "Edit Desk Path";
    } else
    {
        echo "Add Desk Path";
    } ?></span></legend>
                            <?php if ($edit == 1)
                            { ?>
            <form action="<?php echo site_url(); ?>admin/settings/update_desk_path" method="post" id="add_desk_path"><?php } else
                    { ?>
                <form action="<?php echo site_url(); ?>admin/settings/submit_desk_path" method="post" id="add_desk_path">
                    <?php } ?>

                <p>     
    <?php if ($edit == 1)
    { ?> 
                        <label for="dropdown">If Complaint Existing Desk</label>
                        <label for="dropdown"><b>
                            <?php
                            foreach ($get_desk as $row1)
                            {
                                if ($row1['desk_id'] == $a)
                                {
                                    echo $row1['name'];
                                    ?></b> 
                                    <input type="hidden" name="present_desk" value="<?php echo $row1['desk_id']; ?>"/>
            <?php }
        } ?>
                        </label>

                    <?php } else
                    { ?>
                                <?php echo form_error('present_desk'); ?>    
                        <label for="dropdown">If Complaint Existing Desk</label>
                        <select name="present_desk" class="required dropdown" style="width: 250px;">
                            <option selected="selected" value="">Select</option>
                            <?php foreach ($get_desk as $row1)
                            {
                                ?>
                                <option value="<?php echo $row1['desk_id']; ?>" <?php if ($row1['desk_id'] == $a)
                { ?> selected="selected"<?php } ?>><?php echo $row1['name']; ?></option>
        <?php } ?>
                        </select>
    <?php } ?>
                </p>	





                <p>  
    <?php echo form_error('present_status'); ?>       
    <?php if ($edit == 1)
    { ?> 
                        <label for="dropdown">and Complaint Present Status</label><label for="dropdown"><b>
        <?php foreach ($get_status as $row)
        {
            ?> 
                            <?php if ($row['status_id'] == $b)
                            {
                                echo $row['name']; ?>
                                        <input type="hidden" name="present_status" value="<?php echo $row['status_id']; ?>"/></b>
            <?php }
        } ?>
                        </label>
    <?php } else
    { ?>


                        <label for="dropdown">and Complaint Present Status</label>
                        <select name="present_status" class="required dropdown" style="width: 250px;">
                            <option selected="selected" value="">Select</option>
                                    <?php foreach ($get_status as $row)
                                    {
                                        ?>
                                <option value="<?php echo $row['status_id']; ?>" <?php if ($row['status_id'] == $b)
                            { ?> selected="selected"<?php } ?>><?php echo $row['name']; ?></option>
                                              <?php } ?>
                        </select>
    <?php } ?>
                </p>






                <p>     
    <?php echo form_error('next_desk'); ?>    
                <h1>Next Action/Follow Up Desk</h1>

                <table>
                    <tr>   
                        <th>Next Desk</th>
                        <th>Sort Order(0-9)</th>
                    </tr>
                    <?php foreach ($get_desk as $row1)
                    { 
                        $sort=0;
                        ?>
                        <tr>
                            <td><label><input type="checkbox" class="" name="next_desk[]" value="<?php echo $row1['desk_id']; ?>"
                                <?php if(in_array($row1['desk_id'], $saveDesk)) { ?>checked="checked" 
                                       <?php  $sort = $saveSort[$row1['desk_id']];
                                            
                                
                                } ?>> <?php echo $row1['name']; ?></label></td>
                            <td><input type="text" class="number" value="<?php echo $sort; ?>" maxlength="9" name="sort_order_<?php echo $row1['desk_id']; ?>"></td>

                        </tr>

                    <?php } ?>
                </table>         

                </p>



                <p>
                    <label></label>
    <?php if ($edit == 1)
    { ?>
                        <input class="button" type="submit" value="Update" /> 
    <?php } else
    { ?>
                        <input class="button" type="submit" value="Save" /> 
    <?php } ?>
                    <input class="button" type="reset" value="Reset"  />

    <?php if ($edit == 1)
    { ?>
                        <a class="" href="<?php echo site_url(); ?>admin/settings/desk_path" >Back</a>
    <?php } else
    { ?>
                        <a class="" href="<?php echo site_url(); ?>admin/settings/add_desk_path" >Back</a>
    <?php } ?>

                </p>

            </form>
            </legend>
    </fieldset> 
    <h2><?php echo $this->session->flashdata('exception'); ?></h2>
<?php } ?>
