
<script>
    $(document).ready(function(){
        $("#search_status").validate();
    });
</script>
<h1>Status</h1>		
<hr /> 
<a class="add-link" href="<?php echo site_url(); ?>admin/settings/addnewstatus" >Add</a>
<div style="clear: both;"></div>
<h2><?php echo $this->session->flashdata('exception'); ?></h2>
<fieldset>
<legend><span class="bangla">Find Status</span></legend>
<form action="<?php echo site_url(); ?>admin/settings/search_status" method="post" id="search_status">
  <p>
    <label>Status</label>
    <input class="lf" name="search" type="text" />
    <?php echo form_error('status'); ?> 
    <input name="submit" type="submit" class="button" value="Find" />
    <input name="submit" type="reset" class="button" value="Reset" />
    
  </p>
 </form>
</fieldset>

<fieldset>
<legend>Status List</legend>
<table cellspacing="0" summary="table" class="broom_table" width="100%">
  <thead>
        <tr>
            
            <th>Status</th>
            <th>Action</th>
        </tr>
</thead>
  <tbody>
    <?php 
		$i=0;
		foreach($search_data as $row){
		if(($i % 2) == 0) { $alt = "odd"; } else { $alt = "even"; }
		$i++;	
	?>
    <tr class="<?php echo $alt;?>" style="height:30px;">
                
                <td><?php echo $row['name']; ?></td>
                <td><a href="<?php echo site_url('admin/settings/edit_status/' . $row['status_id']); ?>" class="table_edit">Edit</a>                    
                    <a class="actionHand table_delete"  href="#delRec" rel="<?php echo $row['status_id']; ?>"> <img src="assets/images/icon/cross.png" alt="Delete" width="16" height="15" border="0" /></a>
                </td>
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
			var id = $(this).attr("rel");
			e.preventDefault();
			$(this).closest('tr').remove();
			$.get("admin/settings/delete_status/"+id);
			return false;
		} else {
			return false;
		}		 
	 });
	  		
});		
</script>