
<script>
  $(document).ready(function(){
    $("#submit_edit_status_path").validate();
  });
  </script>
  <h1>Status Path</h1>
<hr />
  <fieldset>
      <legend>Edit Status Path</legend>
<div class="common_reservations">
<form action="<?php echo site_url();?>admin/settings/submit_edit_status_path" method="post" id="submit_edit_status_path" >
<input type="hidden" name="present_status_id" value="<?php echo $a;?>">
<input type="hidden" name="present_desk_id" value="<?php echo $b;?>">
<input type="hidden" name="pre_next_status_id" value="<?php echo $c;?>">
    <table>
        <tr>
          
            <th>Present Status</th>
			<th>Present Desk</th>
			<th>Next Status</th>
           
        </tr>
        
        
       
        <tr>
            <td>
					<?php foreach ($get_status as $row) {
					if($row['status_id']==$a){?>
						<label><?php echo $row['name'];?>
					<?php } }?>   	  
			</td>
            <td>
				<?php foreach ($get_desk as $row1) {
				if($row1['desk_id']==$b){
				?>
					<label><?php echo $row1['name'];?></label>
				<?php }}?>
			</td>
			<td>
				<select name="next_status" class="required dropdown">
       			<option selected="selected" value="">Select</option>
				<?php foreach ($get_status as $row) {?>
					<option value="<?php echo $row['status_id'];?>" <?php if ($row['status_id']===$c) {?>selected="selected"<?php }?>><?php echo $row['name'];?></option>
				<?php }?>
		  		</select>
			</td>
			
        </tr>
		 <tr >
          <td colspan="3"><input class="button" type="submit" value="Update" />
          <input class="button" type="reset" value="Reset" />
          <a class="" href="<?php echo site_url(); ?>admin/settings/status_path" >Back</a>
          </td>     
           
        </tr>
       
        
    </table>
	</form>
    </div>
</fieldset>
  
  <h2><?php echo $this->session->flashdata('exception'); ?></h2>