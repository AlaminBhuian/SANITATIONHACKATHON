
<script>
    $(document).ready(function(){
        $("#submit_edit_desk_path").validate();
    });
</script>
<h1>Desk Path</h1>		
<hr />
<div class="common_reservations">
    <form action="<?php echo site_url(); ?>admin/settings/submit_edit_desk_path" method="post" id="submit_edit_desk_path" >
        <input type="hidden" name="status_id" value="<?php echo $a; ?>">
        <input type="hidden" name="present_desk_id" value="<?php echo $b; ?>">
        <input type="hidden" name="pre_next_desk_id" value="<?php echo $c; ?>">
        <table>
            <tr>          
                <th>Present Desk</th>
                <th>Present Status</th>
                <th>Next Desk</th>           
            </tr>       
            <tr>           
                <td>
                    <?php
                    foreach ($get_desk as $row1)
                    {
                        if ($row1['desk_id'] == $b)
                        {
                            ?>
                            <label><?php echo $row1['name']; ?></label>
                        <?php }
                    } ?>
                </td>

                <td>
                        <?php foreach ($get_status as $row)
                        {
                            if ($row['status_id'] == $a)
                            {
                                ?>
                            <label><?php echo $row['name']; ?>
                       <?php }
                        } ?>   	  
                </td>

                <td>
                    <select name="next_desk_id" class="required dropdown">
                        <option selected="selected" value="">Select</option>
<?php foreach ($get_desk as $row)
{ ?>
                            <option value="<?php echo $row['desk_id']; ?>" <?php if ($row['desk_id'] === $c)
    { ?>selected="selected"<?php } ?>><?php echo $row['name']; ?></option>
<?php } ?>
                    </select>
                </td>			
            </tr>
            <tr >
                <td colspan="4">

                    <input class="button" type="submit" value="Update" />  
                    <input class="button" type="reset" value="Reset"  />
                    <a class="" href="<?php echo site_url(); ?>admin/settings/desk_path" >Back</a>
                </td>
            </tr>


        </table>
    </form>
</div>
<h2><?php echo $this->session->flashdata('exception1'); ?></h2>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>