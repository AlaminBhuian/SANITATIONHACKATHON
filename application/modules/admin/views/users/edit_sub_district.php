
<script>
  $(document).ready(function(){
    $("#edit_sub_distirct").validate(
{
            rules: {
                short_order: {                    
                    sub_district_name: 45
                }
            }
        }

);
  });
  </script>
  <h1>Upazilla/Thana</h1>		
                <hr /> 
                <?php echo validation_errors(); ?>
<fieldset>
    <legend>Edit Upazilla/Thana</legend>
<form action="<?php echo site_url();?>admin/settings/submit_edit_sub_district" method="post" id="edit_sub_distirct"> 
    

<p>        <?php foreach($edit_sub_dis as $sub_dis){?>
                <label for="dropdown">District/Zilla</label>
                <select name="district" class="required dropdown" style="width: 250px;">
                    <option selected="selected" value="">Select</option>
                  <?php foreach ($get_district as $row) {?>
                  <option value="<?php echo $row['district_id'];?>" <?php if ($row['district_id']===$sub_dis['district_id']) {?>selected="selected"<?php }?>><?php echo $row['district_name'];?></option>
                  <?php }?>
                </select>
              </p>
              
              
              <p>
                <label for="lf">Upazilla/Thana</label>
                <input class="required lf" maxlength="45" name="sub_district_name" type="text" value="<?php echo $sub_dis['sub_district_name'];?>" />
              </p>
              <?php }?>
                  <p>
                      <label></label>
                      <input type="hidden" name="sub_district_id" value="<?php echo $sub_dis['sub_district_id'];?>"/>
                <input class="button" type="submit" value="Update" />
                <input class="button" type="reset" value="Reset" />
                <a class="" href="<?php echo site_url(); ?>admin/settings/add_sub_district" >Back</a>
                
              
              </p>
               
</form>
</fieldset>
                
                <h2><?php echo $this->session->flashdata('exception');?></h2>
            