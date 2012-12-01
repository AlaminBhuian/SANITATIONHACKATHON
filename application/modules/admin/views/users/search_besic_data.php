<script>
    $(document).ready(function(){
        $("#search_besic_data").validate();
    });
</script>

<h1>Basic Data</h1>
<hr />
<a class="add-link" href="<?php echo site_url(); ?>admin/settings/add_sub_category">Add</a>
<div style="clear: both;"></div>
<br>
<fieldset>
<legend>Find Basic Data</legend>
<form action="<?php echo site_url(); ?>admin/settings/search_besic_data" method="post" id="search_besic_data">
  <p>
    <label for="lf">Category</label>
    <select name="category" class="dropdown" style="width: 250px;">
      <option selected="selected" value="">Select</option>
      <?php
            foreach ($get_besic_data as $row)
            {
                ?>
      <option value="<?php echo $row['id']; ?>"><?php echo $row['varCategoryName']; ?></option>
      <?php } ?>
    </select>
    <input name="submit" type="submit" class="button" value="Find" />
    <input name="submit" type="reset" class="button" value="Reset" />
  </p>
</form>
</fieldset>
<fieldset>
<legend>Basic Data List</legend>
<table cellspacing="0" summary="table" class="broom_table" width="100%">
  <thead>
    <tr>
      <th>Category</th>
      <th>Sub Category</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php 
		$i=0;
		 foreach ($search_data as $row)   {
		if(($i % 2) == 0) { $alt = "odd"; } else { $alt = "even"; }
		$i++;	
	?>
    <tr class="<?php echo $alt;?>" style="height:30px;">
      <td><?php echo $row['varCategoryName']; ?></td>
      <td><?php echo $row['varName']; ?></td>
      <td><?php echo $row['enuStatus']; ?></td>
      <td><a href="<?php echo site_url('admin/settings/edit_besic_data/' . $row['besic_id']); ?>" class="table_edit">Edit</a> 
          <a class="actionHand table_delete"  href="#delRec" rel="<?php echo $row['besic_id']; ?>"> <img src="assets/images/icon/cross.png" alt="Delete" width="16" height="15" border="0" /></a></td>
    </tr>
  <?php }?>
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
			$.get("admin/settings/delete_besic_data/"+id);
			return false;
		} else {
			return false;
		}		 
	 });
	  		
});		
</script> 
