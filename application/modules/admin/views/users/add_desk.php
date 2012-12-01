<script>
    $(document).ready(function(){
        $("#add_desk").validate(
{
            rules: {
                desk_name: {                    
                    maxlength: 95
                }
            }
        }    

);
    });
</script>
<h1> Desk</h1>
<hr />
<fieldset>
    <legend>Add Desk</legend> 

    <form action="<?php echo site_url(); ?>admin/settings/submit_new_desk" method="post" id="add_desk">
        <?php echo validation_errors(); ?>
        <p>
            <label for="lf">Title </label>
            <input class="required lf" maxlength="95" name="desk_name" type="text" />
        </p>
        <p>
            <label for="lf">Status</label>
            <select class="required dropdown" name="status" style="width: 250px;">
                <option value="">Select</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </p>
        <p>
            <label></label>
            <input name="submit" type="submit" class="button" value="Save" />
            <input name="reset" type="reset" class="button" id="reset" />
        </p>
    </form>
</fieldset>



<fieldset>
    <legend>Desk List</legend>
    <table cellspacing="0" summary="table" class="broom_table" width="100%">
        <thead>
            <tr>
                
                <th width="50%">Title </th>
                <th width="24%">Status</th>
                <th width="21%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($get_desk as $key => $row)
            {
                if (($i % 2) == 0)
                {
                    $alt = "odd";
                } else
                {
                    $alt = "even";
                }
                $i++;
                if($row['desk_id']!=1){
                ?>
                <tr class="<?php echo $alt; ?>" style="height:30px;">
                    
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><a href="<?php echo site_url('admin/settings/edit_desk/' . $row['desk_id']); ?>" class="table_edit">Edit</a> 
                        <a class="actionHand table_delete"  href="#delRec" rel="<?php echo $row['desk_id']; ?>"> <img src="assets/images/icon/cross.png" alt="Delete" width="16" height="15" border="0" /></a>
                    </td>
                </tr>
<?php } }?>
        </tbody>
    </table>
    <div style="text-align: left;">
        <div class="pagination"> <?php echo $paginet; ?></div>
    </div>
</fieldset>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>
<script type="text/javascript">
    $(document).ready(function(){	 	 	 
        $("a.table_delete").click(function(e) {	 
            if(confirm('Are you sure you want to delete this record?'))
            {
                var id = $(this).attr("rel");
                e.preventDefault();
                $(this).closest('tr').remove();
                $.get("admin/settings/delete_desk/"+id);
                return false;
            } else {
                return false;
            }		 
        });
	  		
    });		
</script>
