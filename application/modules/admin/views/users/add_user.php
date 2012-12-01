<script>
    $(document).ready(function(){
        $("#submit_user_entry").validate(
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
                Department:{                    
                    maxlength: 55
                } 
                
            }
        }
        
);
    });
</script>

<h1>User Account</h1>		
<hr /> 
<?php if (validation_errors()) : ?>
        <div class="msg-error"> <?php echo validation_errors(); ?> </div>
        <?php endif; ?>
<fieldset>
    <legend><span class="bangla">Add New User</span></legend>
   
    <form action="<?php echo base_url(); ?>admin/settings/submit_user_entry" method="post" id="submit_user_entry">


        <p>
            <label> <span>User Name</span> <span style="color: red;">*</span></label>
            <input class="required lf" name="user_name" type="text" value="<?php echo set_value('user_name'); ?>" maxlength="60"/>
        </p>

        <p>
            <label> <span>Password </span> <span style="color: red;">*</span></label>
            <input class="required lf" name="password" type="password" value="" maxlength="60" />
        </p>

        <p>
            <label> <span>Full Name</span> <span style="color: red;">*</span> </label>
            <input class="required lf" name="full_name" type="text" value="<?php echo set_value('full_name'); ?>" maxlength="100"/>
        </p> 

        <p>
            <label> <span>Address</span> </label>
            <input class="lf" name="address" type="text" value="<?php echo set_value('address'); ?>" maxlength="500"/>
        </p>

        <p>
            <label> <span>Mobile</span> </label>
            <input class="lf number" name="mobile" type="text" value="<?php echo set_value('mobile'); ?>" maxlength="40"/>
        </p>

        <p>
            <label> <span>Email</span> </label>
            <input class="lf email" name="email" type="text" value="<?php echo set_value('email'); ?>" maxlength="100"/>
        </p>

        <p>
            <label> <span>Designation</span> </label>
            <input class="lf" name="designation" type="text" value="<?php echo set_value('designation'); ?>" maxlength="60"/>
        </p>

        <p>
            <label> <span>Desk</span> <span style="color: red;">*</span></label>



            <select name="desk" class="required dropdown" style="width: 250px;">
                <option selected="selected" value="">Select</option>
                <?php
                foreach ($get_desk as $row1)
                {
                    ?>
                    <option value="<?php echo $row1['desk_id']; ?>"><?php echo $row1['name']; ?></option>
<?php } ?>
            </select>
        </p>

        <p>
            <label> <span>Status</span> </label>
            <select name="enmStatus" class="dropdown" style="width: 250px;">
                <option selected="selected" value="active">Active</option>
                <option  value="inactive">Inactive</option>
            </select>
        </p>

        <p>
            <label> <span>Department</span> </label>
            <input class="lf" name="department" type="text" value="<?php echo set_value('department'); ?>" maxlength="60"/>
        </p>
        <p>
            <label></label>
            <input class="button" type="submit" value="Save" >
            <input class="button" type="reset" value="Reset" >
            <a href="<?php echo base_url();?>admin/settings/user_list" />Back</a>
                   
        </p>
    </form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>

 