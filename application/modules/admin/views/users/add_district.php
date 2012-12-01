<script>
    $(document).ready(function(){
        $("#searchDistrict").validate();
    });
</script>

<h1> District/Zilla</h1>
<hr />
<a class="add-link" href="<?php echo site_url(); ?>admin/settings/addNewDistrict">Add</a>
<div style="clear: both;"></div>
<br>
<fieldset>
<legend>Find District/Zilla</legend>
<form action="<?php echo site_url(); ?>admin/settings/searchDistrict" method="post" id="searchDistrict">
  <p>
    <label for="lf">District/Zilla</label>
    <input class="lf" name="district_name" type="text" />
    <?php echo validation_errors(); ?>
    <input type="submit" class="button" value="Find" />
    <input type="reset" class="button" value="Reset" />
  </p>
</form>
</fieldset>
<h2><?php echo $this->session->flashdata('exception');?></h2>
<?php if($data==1){?>
<fieldset>
<legend>District/Zilla List</legend>
  <h2><?php echo $this->session->flashdata('exception'); ?></h2>
<table cellspacing="0" summary="table" class="broom_table" width="100%">
<thead>
    <tr>
      
      <th width="74%">District/Zilla</th>
      <th width="20%">Action</th>
    </tr>
    </thead>
  <tbody>
    <?php 
		$i=0;
		foreach($get_district as $row){
		if(($i % 2) == 0) { $alt = "odd"; } else { $alt = "even"; }
		$i++;	
	?>
    <tr class="<?php echo $alt;?>" style="height:30px;">	
      
      <td><?php echo $row['district_name']; ?></td>
      <td><a class="table_edit" href="<?php echo site_url('admin/settings/edit_district/' . $row['district_id']); ?>">Edit</a> 
          <a class="actionHand table_delete"  href="#delRec" rel="<?php echo $row['district_id']; ?>"> <img src="assets/images/icon/cross.png" alt="Delete" width="16" height="15" border="0" /></a>
      </td>
    </tr>
    <?php } ?>
	</tbody>
  </table>

    <div style="text-align: left;">
        
  <div class="pagination"> <?php echo $paginet; ?></div>
</div>

</fieldset>
<?php } ?>

<script type="text/javascript">
$(document).ready(function(){	 	 	 
 	 $("a.table_delete").click(function(e) {	 
		if(confirm('Are you sure you want to delete this record?'))
		{
			var id = $(this).attr("rel");
			e.preventDefault();
			$(this).closest('tr').remove();
			$.get("admin/settings/delete_district/"+id);
			return false;
		} else {
			return false;
		}		 
	 });
	  		
});		
</script> 