<script>
    $(document).ready(function(){
        $("#search_role_previlizes").validate();
    });
</script>
<script>
    $(document).ready(function(){
        $("#edit_roleprevilizes").validate();
    });
</script>

<?php
if ($search_data == "")
{
    ?>
    <h1>Role Privileges</h1>		
    <hr />

    <div style="clear: both;"></div>
    <fieldset>
        <legend><span class="bangla">Find Role Privileges </span></legend>

        <form action="<?php echo site_url(); ?>admin/settings/searchRolePrevilizes" method="post" id="search_role_previlizes">
            <p>     
                <?php echo form_error('desk'); ?>    
                <label for="dropdown">Desk</label>
                <select name="desk" class="required dropdown" style="width:250px;">
                    <option selected="selected" value="">Select</option>
                    <?php
                    foreach ($get_desk as $row1)
                    {
                        if ($row1['desk_id'] != 1)
                        {
                            ?>
                            <option value="<?php echo $row1['desk_id']; ?>"><?php echo $row1['name']; ?></option>
                        <?php }
                    }
                    ?>
                </select>
                <input name="submit" type="submit" class="button" value="Find"  />
                <input type="reset" class="button" value="Reset" />
            </p>



        </form>
    </fieldset>


    <?php
} else
{
    ?>

    <h1>Role Privileges</h1>		
    <hr />   
    <div style="clear: both;"></div>
    <fieldset>
        <legend><span class="bangla">Find Role Privileges </span></legend>

        <form action="<?php echo site_url(); ?>admin/settings/searchRolePrevilizes" method="post" id="search_role_previlizes">
            <p>     
    <?php echo form_error('desk'); ?>    
                <label for="dropdown">Desk</label>
                <select name="desk" class="required dropdown" style="width:250px;">
                    <option selected="selected" value="">Select</option>
                    <?php
                    foreach ($get_desk as $row1)
                    {
                        if ($row1['desk_id'] != 1)
                        {
                            ?>
                            <option value="<?php echo $row1['desk_id']; ?>"><?php echo $row1['name']; ?></option>
                        <?php }
                    }
                    ?>
                </select>
                <input name="submit" type="submit" class="button" value="Find"  />
                <input name="submit" type="reset" class="button" value="Reset" />
            </p>
        </form>
    </fieldset>

    <fieldset>
        <legend><span class="bangla">Assign Role Privileges</span></legend>
        <form action="<?php echo site_url(); ?>admin/settings/submitAddRolePrevilizes" method="post" id="edit_roleprevilizes">
            <p>     
                <?php echo form_error('desk'); ?>    
                <label style="font-size: 14px;">Desk</label>

                
            <label style="text-align: left;"><b>
                    <?php
                foreach ($get_desk as $row1)
                {
                    
                        if ($row1['desk_id'] === $desk)
                        {
                            echo $row1['name'];
                            ?> 
                            <input type="hidden" name="desk" value="<?php echo $row1['desk_id']; ?>"/>
        <?php }}?></b>
                </label>
                
                

              </p>
            <p>
                <?php
                foreach ($get_role as $row)
                {
                    ?>

                <h2> <input class="" type="checkbox" class="checkbox" name="role[]" value="<?php echo $row['id'] ?>"

                            <?php
                            foreach ($search_data as $chack)
                            {
                                ?>  <?php
                    if ($row['id'] == $chack['intRoleID'])
                    {
                                    ?>checked="checked"<?php
                }
            }
            ?>

                            ><?php echo $row['varRoleName'] ?></h2>


    <?php } ?>
            </p>
            <p>
                <input name="submit2" type="submit" class="button" value="Save"/>
                <input class="button" type="reset" value="Reset">
                <a class="" href="<?php echo site_url(); ?>admin/settings/role_previlizes" >Back</a>
            </p>
        </form>
    </fieldset>                 

<?php }
?>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>


