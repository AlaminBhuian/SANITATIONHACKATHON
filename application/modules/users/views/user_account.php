<div id="main">

<script>
    $(document).ready(function(){
        $("#submit_edit_user").validate();
    });
</script>

    <h1>Edit User</span> !</h1>		
    <hr /> 

    <fieldset>
        <legend><span class="bangla">Edit User</span></legend>
        
        <form action="<?php echo base_url(); ?>users/users/submitEditUser" method="post" id="submit_edit_user">
            <?php
            foreach ($search_data as $data)
            {
                ?>


                <p>
                    <label> <span>User Name</span> <span style="color: red;">*</span></label>
                    <label class="required lf"  /><?php echo $data['varUserName']; ?></label>
                </p>

                <p>
                    <label> <span>Full Name</span> <span style="color: red;">*</span> </label>
                    <input class="required lf" name="full_name" type="text" value="<?php echo $data['varFullName']; ?>" />
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
                    <label class="sf">   <?php
            foreach ($get_desk as $row1)
            {
                    ?>
                            <?php
                            if ($row1['desk_id'] === $data['intDeskID'])
                            {
                                echo $row1['name'];
                            }
                            ?></option>
                        <?php } ?></label>
                    </select>
                </p>


                <p>
                    <label> <span>Department</span> </label>
                    <input class="lf" name="department" type="text" value="<?php echo $data['varDepartment']; ?>" />
                </p>
            <?php } ?>
            <p>
                <input class="button" type="submit" value="Update" />          
                <input class="button" type="reset" value="Reset" />          
            </p>
        </form>
    </fieldset>
<h2><?php echo $this->session->flashdata('exception1'); ?></h2>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>    
<br/>

    <script>
        $(document).ready(function(){
            $("#change_password").validate(
            );
        });
    </script>

   <?php echo validation_errors(); ?>
    <fieldset>
        <legend><span class="bangla">Change Password</span></legend>
        
        <form action="<?php echo base_url(); ?>users/users/change_passowrd" method="post" id="change_password">
            <p>
                <label> <span>Current Password</span> </label>
                <input class="required lf" name="current_password" type="password" value="" />
            </p>

            <p>
                <label> <span>New Password</span> </label>
                <input class="required lf" name="new_password" id="new_password" type="password" value="" />
            </p>

            <p>
                <label> <span>Re-type New Password</span> </label>
                <input class="required lf" name="re_new_password" id="re_new_password" type="password" value="" />
            </p>

            <p>
                <input class="button" type="submit" value="Update" id="submit"/>          
                <input class="button" type="reset" value="Reset" />
            </p>
        </form>
    </fieldset>

</div>
