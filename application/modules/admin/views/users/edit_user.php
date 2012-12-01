<script>
    $(document).ready(function(){
        $("#submit_edit_user").validate(
{
            rules: {
                user_name:{                    
                    maxlength: 55
                },                
                password:{                    
                    maxlength: 55
                },                
                full_name:{                    
                    maxlength: 55
                },                
                Address:{                    
                    maxlength: 490
                },                
                mobile:{                    
                    maxlength: 40
                },                
                email:{                    
                    maxlength: 100                    
                },                
                designation:{                    
                    maxlength: 55
                },                
                department:{                    
                    maxlength: 55
                } 
                
            }
        }    
);
    });
</script>

<h1>User Account</h1>		
<hr /> 

<fieldset>
    <legend><span class="bangla">Edit User</span></legend>

    <form action="<?php echo base_url(); ?>admin/settings/submit_edit_user" method="post" id="submit_edit_user">
        <?php
        foreach ($get_single_user as $data)
        {
            ?>


            <p>
                <label> <span>User Name</span> <span style="color: red;">*</span></label>
                <label><?php echo $data['varUserName']; ?></label>
                <input type="hidden" name="varUserName" value="<?php echo $data['varUserName']; ?>">
            </p>

            <p>
                <label> <span>Full Name</span> <span style="color: red;">*</span> </label>
                <input class="required lf" name="full_name" type="text" value="<?php echo $data['varFullName']; ?>" />
            </p> 
            <p>
                <label> <span>Password</span> <span style="color: red;">*</span> </label>
                <input class="lf" name="password" type="password" value="" />
            </p>

            <p>
                <label> <span>Address</span> </label>
                <input class="lf" name="address" type="text" value="<?php echo $data['varAddress']; ?>" />
            </p>

            <p>
                <label> <span>Mobile</span> </label>
                <input class="lf" name="mobile" type="text" value="<?php echo $data['varMoblie']; ?>" />
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>"

            </p>

            <p>
                <label> <span>Email</span> </label>
                <input class="lf" name="email" type="text" value="<?php echo $data['varEmail']; ?>" />
            </p>

            <p>
                <label> <span>Designation</span> </label>
                <input class="lf" name="designation" type="text" value="<?php echo $data['varDesignation']; ?>" />
            </p>

            <p>
                <label> <span>Desk</span> <span style="color: red;">*</span></label>



                <select name="desk" class="required dropdown" style="width: 250px;">
                    <option selected="selected" value="">Select</option>
                    <?php
                    foreach ($get_desk as $row1)
                    {
                        ?>
                        <option value="<?php echo $row1['desk_id']; ?>" <?php
                        if ($row1['desk_id'] === $data['intDeskID'])
                        {
                            ?>selected="selected"<?php } ?>><?php echo $row1['name']; ?></option>
    <?php } ?>
                </select>
            </p>
            <p>
                <label> <span>Status</span> </label>
                <select name="enmStatus" class="dropdown" style="width: 250px;">
                    
                    <option  value="active" <?php if ($data['enmStatus'] === 'active')
    { ?>selected="selected"<?php } ?>>Active</option>
                    <option  value="inactive" <?php if ($data['enmStatus'] === 'inactive')
    { ?>selected="selected"<?php } ?>>Inactive</option>
                </select>
            </p>      

            <p>
                <label> <span>Department</span> </label>
                <input class="lf" name="department" type="text" value="<?php echo $data['varDepartment']; ?>" />
            </p>
<?php } ?>
        <p>
            <label></label>
            <input class="button" type="submit" value="Update" />          
            <input class="button" type="reset" value="Reset" />  
            <a  href="<?php echo base_url();?>admin/settings/user_list" />Back</a> 
        </p>
    </form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>

