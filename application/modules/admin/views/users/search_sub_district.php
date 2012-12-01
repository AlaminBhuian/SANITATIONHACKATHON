<script>
  $(document).ready(function(){
    $("#search_sub_distirct").validate();
  });
  </script> 
  <h1>Upazilla/Thana</h1>		
<hr /> 


<a class="add-link" href="<?php echo site_url(); ?>admin/settings/add_new_sub_district" >Add</a>
<div style="clear: both;"></div>
<br>
<fieldset>
<legend>Find Upazilla/Thana</legend>

<form action="<?php echo site_url(); ?>admin/settings/search_sub_district" method="post" id="search_sub_distirct">
  <p> <?php echo validation_errors(); ?>
    <label for="dropdown">District/Zilla</label>
    <select name="district" class="dropdown" style="width: 250px;">
      <option selected="selected" value="">Select</option>
      <?php foreach ($get_district as $row)  {  ?>
      <option value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
      <?php } ?>
    </select>
    <input name="submit" type="submit" class="button" value="Find" />
    <input name="submit" type="reset" class="button" value="Reset" />
  </p>
</form>
</fieldset>

<h2><?php echo $this->session->flashdata('exception'); ?></h2>

<fieldset>
<legend>Upazilla/Thana List</legend>
<table cellspacing="0" summary="table" class="broom_table" width="100%">
  <thead>
        <tr>
            <th>District/Zilla</th>
            <th>Upazilla/Thana</th>
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
                <td><?php echo $row['district_name']; ?></td>
                <td><?php echo $row['sub_district_name']; ?></td>
                <td><a href="<?php echo site_url('admin/settings/edit_sub_district/' . $row['sub_district_id']); ?>" class="table_edit">Edit</a>                    
                <a class="actionHand table_delete"  href="#delRec" rel="<?php echo $row['sub_district_id']; ?>"> <img src="assets/images/icon/cross.png" alt="Delete" width="16" height="15" border="0" /></a>
                </td>
            </tr>
<?php } ?>

    </table>
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
			$.get("admin/settings/delete_sub_district/"+id);
			return false;
		} else {
			return false;
		}		 
	 });
	  		
});		
</script>