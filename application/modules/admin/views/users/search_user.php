<h1>User Account</h1>
<hr />
<p> <a class="add-link" href="<?php echo base_url();?>admin/settings/add_user" />Add</a> </p>
<div style="clear: both;"></div>
<fieldset>
<legend>Find User</legend>
<form action="<?php echo base_url('admin/settings/search_user');?>" method="post" >
<p>
    <label for="sf">Full Name</label>
    <input type="search" class="required lf" name="search">
  </p>
  <p>
    <label for="dropdown">Select desk</label>
    <select name="desk" class="required dropdown" style="width: 250px;">
      <option selected="selected" value="">Select</option>
      <?php foreach ($get_desk as $row1) {?>
      <option value="<?php echo $row1['desk_id'];?>"><?php echo $row1['name'];?></option>
      <?php }?>
    </select>
  </p>
  <p>
    <label for="dropdown">Select Status</label>
    <select name="status" class="required dropdown" style="width: 250px;">
      <option selected="selected" value="">Select</option>
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
      
    </select>
  </p>
  <p>
      <label></label>
    <input name="submit" type="submit"  class="button" value="Find" />
    <input name="Reset" type="reset"  class="button" />
  </p>  
</form>
</fieldset>
     <h2><?php echo $this->session->flashdata('exception1'); ?></h2>
     <fieldset>
<legend>User List</legend>
  <table cellspacing="0" summary="table" class="broom_table" width="100%">
  <thead>
            
            <th>User Name</th>
            <th>Full Name</th>
            <th>Designation</th>
            <th>action</th>
        </thead>
  <tbody>
    <?php 
		$i=0;
		foreach($search_data as $row){
		if(($i % 2) == 0) { $alt = "odd"; } else { $alt = "even"; }
		$i++;	
	?>
    <tr class="<?php echo $alt;?>" style="height:30px;">
           
                
                <td><?php echo $row['varUserName']; ?></td>
                <td><?php echo $row['varFullName']; ?></td>
                <td><?php echo $row['varDesignation']; ?></td>
                <td><a href="<?php echo site_url('admin/settings/edit_user/' . $row['id']); ?>" class="table_edit">Edit</a>
                 <?php if($row['varUserName']!= 'admin'){ ?>   
                <a class="actionHand table_delete"  href="#delRec" rel="<?php echo $row['id']; ?>"> <img src="assets/images/icon/cross.png" alt="Delete" width="16" height="15" border="0" /></a>
                <?php }?>
                </td>
            </tr>
<?php } ?>

    </tbody>
</table>
    
<script type="text/javascript">
$(document).ready(function(){	 	 	 
 	 $("a.table_delete").click(function(e) {	 
		if(confirm('Are you sure you want to delete this record?'))
		{
			var id = $(this).attr("rel");
			e.preventDefault();
			$(this).closest('tr').remove();
			$.get("admin/settings/delete_user/"+id);
			return false;
		} else {
			return false;
		}		 
	 });
	  		
});		
</script>
