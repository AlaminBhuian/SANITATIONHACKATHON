<h1>Status Reason</h1>		
<hr /> 

<a class="add-link" href="<?php echo site_url(); ?>admin/settings/add_reason_remarks">Add</a>
<div style="clear: both;"></div>
<br>
<fieldset>
<legend>Find Status Reason</legend>
<form action="<?php echo site_url(); ?>admin/settings/search_reason_remarks" method="post" name="reason_remarks" id="reason_remarks">
  <br/>
  <?php echo form_error('reason_status'); ?> <?php echo form_error('reason'); ?>
  <p>
    <label for="dropdown">Status </label>
    <select name="reason_status" class="dropdown" style="width:250px;">
      <option selected="selected" value="">Select</option>
      <?php foreach ($get_status as $row)
                {
                    ?>
      <option value="<?php echo $row['status_id']; ?>"><?php echo $row['name']; ?></option>
      <?php } ?>
    </select>
  </p>
  <p>
    <label for="lf">Status Reason</label>
    <input class="lf" name="reason" type="text" />
  </p>
  <p>
      <label></label>
    <input class="button" type="submit" value="Find" />
    <input name="Reset" type="reset" class="button" />
  </p>
</form>
</fieldset>

<h2><?php echo $this->session->flashdata('exception'); ?></h2>

<fieldset>
<legend>Status Reason List</legend>
  <table cellspacing="0" summary="table" class="broom_table" width="100%">
  <thead>
        <tr>
            
            <th>Status</th>
            <th>Status Reason</th>
            <th>Action</th>
        </tr>


       
             </thead>
  <tbody>
    <?php 
		$i=0;
		if($search_data!=""){ foreach ($search_data as $key => $row)
        {
		if(($i % 2) == 0) { $alt = "odd"; } else { $alt = "even"; }
		$i++;	
	?>
    <tr class="<?php echo $alt;?>" style="height:30px;">
        
        
                <td><?php echo $row['statusName']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><a href="<?php echo site_url('admin/settings/edit_reason_remarks/' . $row['reason_remarks_id']); ?>" class="table_edit">Edit</a>                    
                    <a class="actionHand table_delete"  href="#delRec" rel="<?php echo $row['reason_remarks_id']; ?>"> <img src="assets/images/icon/cross.png" alt="Delete" width="16" height="15" border="0" /></a>
                </td>
            </tr>
<?php } }?>
</tbody>
    </table>
<div style="text-align: left;">
  <div class="pagination"> <?php echo $paginet;?></div>
</div>

</fieldset>

<script type="text/javascript">
$(document).ready(function(){	 	 	 
 	 $("a.table_delete").click(function(e) {	 
		if(confirm('Are you sure you want to delete this record?'))
		{
			var id = $(this).attr("rel");
			e.preventDefault();
			$(this).closest('tr').remove();
			$.get("admin/settings/delete_reason_remarks/"+id);
			return false;
		} else {
			return false;
		}		 
	 });
	  		
});		
</script>