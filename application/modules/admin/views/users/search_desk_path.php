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
                <?php
                foreach ($get_desk as $row1)
                {
                    ?>
                    <option value="<?php echo $row1['desk_id']; ?>"><?php echo $row1['name']; ?></option>
<?php } ?>
            </select>
        </p>

        <p>  
<?php echo form_error('present_status_search'); ?>       
            <label for="dropdown">Present Status</label>
            <select name="present_status_search" class="dropdown" style="width: 250px;">
                <option selected="selected" value="">Select</option>
                <?php
                foreach ($get_status as $row)
                {
                    ?>
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
<fieldset>
    <legend>Desk Path  List</legend>
    <table cellspacing="0" summary="table" class="broom_table" width="100%">
        <thead>
            <tr>

                <th>Present Desk</th>
                <th>Present Status</th>
                <th>Next Desk</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $i = 0;
            foreach ($search_data as $row)
            {
                if (($i % 2) == 0)
                {
                    $alt = "odd";
                } else
                {
                    $alt = "even";
                }
                $i++;
                ?>
                <tr class="<?php echo $alt; ?>" style="height:30px;">

                    <td><?php echo $row['present_desk']; ?></td>
                    <td><?php echo $row['present_status']; ?></td>
                    <td><?php echo $row['next_desk']; ?></td>
                    <td><a class="table_edit" href="<?php echo site_url('admin/settings/searchDeskPathForEdit/' . $row['status_id'] . '/' . $row['present_desk_id']); ?>">Edit</a> 
                        <a class="actionHand table_delete"  href="#delRec" presentStatus="<?php echo $row['status_id']; ?>" presentDesk="<?php echo $row['present_desk_id']; ?>" nextDesk="<?php echo $row['next_desk_id']; ?>" > <img src="assets/images/icon/cross.png" alt="Delete" width="16" height="15" border="0" /></a>
                </tr>
<?php } ?>
        </tbody>
    </table>
    <div style="text-align: left;">
        <div class="pagination"> <?php echo $paginet; ?></div>
    </div>
</fieldset>
<script type="text/javascript">
    $(document).ready(function(){	 	 	 
        $("a.table_delete").click(function(e) {	 
            if(confirm('Are you sure you want to delete this record?'))
            {
                var id = $(this).attr("presentStatus");
                var id2 = $(this).attr("presentDesk");
                var id3 = $(this).attr("nextDesk");
                        
                e.preventDefault();
                $(this).closest('tr').remove();
                $.get("admin/settings/delete_desk_path/"+id+"/"+id2+"/"+id3);
                return false;
            } else {
                return false;
            }		 
        });
	  		
    });		
</script>

