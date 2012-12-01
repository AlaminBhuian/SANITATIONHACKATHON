<script>
    $(document).ready(function(){
        $("#add_status_path").validate();
    });
</script>

<h1>Status Path</h1>		
<hr />
<?php if($search == 0){?>
<fieldset>
    <legend><span class="bangla">Add Status Path</span></legend>
    <form action="<?php echo site_url(); ?>admin/settings/search_status_path_for_add" method="post" id="add_status_path">
        
        <p>  
            <?php echo form_error('present_status'); ?>       
            <label for="dropdown">If Complaint Present Status</label>
            <select name="present_status" class="required dropdown" style="width: 250px;">
                <option selected="selected" value="">Select</option>
                <?php foreach ($get_status as $row)
                { ?>
                    <option value="<?php echo $row['status_id']; ?>"><?php echo $row['name']; ?></option>
<?php } ?>
            </select>
        </p>

        <p>     
<?php echo form_error('present_desk'); ?>    
            <label for="dropdown">and Complaint Existing Desk</label>
            <select name="present_desk" class="required dropdown" style="width: 250px;">
                <option selected="selected" value="">Select</option>
                <?php foreach ($get_desk as $row1)
                { ?>
                    <option value="<?php echo $row1['desk_id']; ?>"><?php echo $row1['name']; ?></option>
<?php } ?>
            </select>
        </p>      

        <p>
            <label></label>
            <input class="button" type="submit" value="Set Status Path" />                      
            <a class="" href="<?php echo site_url(); ?>admin/settings/status_path" >Back</a>
        </p>
    </form>
</legend>
</fieldset>  
<h2><?php echo $this->session->flashdata('exception'); ?></h2>

    
    
    <?php } elseif($search == 1){?>
    <fieldset>
    <legend><span class="bangla"><?php if($edit == 1){echo "Edit Status Path";}else { echo "Add Status Path";}?></span></legend>
    
    <?php if($edit == 1){?>
    <form action="<?php echo site_url(); ?>admin/settings/update_status_path" method="post" id="add_status_path">
        <?php }else{?>
   <form action="<?php echo site_url(); ?>admin/settings/submit_status_path" method="post" id="add_status_path">
        <?php }?>
        
        
        <p>              
            <?php echo form_error('present_status'); ?> 
            <?php if($edit == 1){?>
            <label for="dropdown">If Complaint Present Status</label><label for="dropdown"><b>
                <?php foreach ($get_status as $row)
                {   if($row['status_id'] == $b){ echo $row['name']; ?></b>
                <input type="hidden" name="present_status" value="<?php echo $row['status_id'];?>"/>
            <?php }}?>
            </label>
            <?php }else{?>
            <label for="dropdown">If Complaint Present Status</label>
            <select name="present_status" class="required dropdown" style="width: 250px;">
                <option selected="selected" value="">Select</option>
                <?php foreach ($get_status as $row)
                { ?>
                    <option value="<?php echo $row['status_id']; ?>" <?php if($row['status_id'] == $b){?> selected="selected"<?php }?>><?php echo $row['name']; ?></option>
<?php } ?>
            </select>
<?php } ?>
        </p>

        
        
        
        
        
        <p>     
<?php echo form_error('present_desk'); ?>  
            <?php if($edit == 1){?>
            <label for="dropdown">and Complaint Existing Desk</label><label for="dropdown"><b>
             <?php foreach ($get_desk as $row1)
                {  if($row1['desk_id'] == $a){ echo $row1['name'];?></b>
                <input type="hidden" name="present_desk" value="<?php echo $row1['desk_id'];?>"/> 
                
                <?php }}?>
            </label>
            
            <?php } else{?>
            <label for="dropdown">and Complaint Existing Desk</label>
            <select name="present_desk" class="required dropdown" style="width: 250px;">
                <option selected="selected" value="">Select</option>
                <?php foreach ($get_desk as $row1)
                { ?>
                    <option value="<?php echo $row1['desk_id']; ?>" <?php if($row1['desk_id'] == $a){?> selected="selected"<?php }?>><?php echo $row1['name']; ?></option>
<?php } ?>
            </select>
<?php } ?>
        </p>

        
        
        
        
        
        <p>      
<?php echo form_error('next_status'); ?>   
            <h1>Allow Action Status</h1><br />

                <?php foreach ($get_status as $row) { ?>
            
            <p><label style="width:300px;"><input type="checkbox" class="" name="next_status[]" value="<?php echo $row['status_id'];?>"
                                                  
            <?php if($searchData != ""){
                            foreach ($searchData as $chack)
                            {
                                
                    if ($row['status_id'] == $chack['next_status_id'])
                    {?>checked="checked"<?php }}}?>                                       
                                                  
            > <?php echo $row['name']; ?></label></p>
<?php } ?>
        </p>

        <p>
            <label></label>
            <?php if($edit == 1){?>
            <input class="button" type="submit" value="Update" />          
            <?php }else{?>
            <input class="button" type="submit" value="Save" />          
                <?php }?>
            <input class="button" type="reset" value="Reset" /> 
           <?php if($edit == 1){?>
            <a class="" href="<?php echo site_url(); ?>admin/settings/status_path" >Back</a>
            <?php }else{?>
            <a class="" href="<?php echo site_url(); ?>admin/settings/add_status_path" >Back</a>
                <?php }?>
            
            
        </p>

    </form>
</legend>
</fieldset>  
<h2><?php echo $this->session->flashdata('exception'); ?></h2>





<?php }?>

