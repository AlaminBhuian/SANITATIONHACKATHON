<script>
  $(document).ready(function(){
    $("#add_sub_district").validate(
        {
            rules: {
                sub_district_name: {                    
                    maxlength: 45
                }
            }
        }


);
  });
  </script>
<h1>Upazilla/Thana</h1>		
                <hr /> 

                <fieldset>
    <legend><span class="bangla">Add Upazilla/Thana</span></legend>
<h2><?php echo $this->session->flashdata('exception');?></h2>
<form action="<?php echo site_url();?>admin/settings/submit_sub_district" method="post" id="add_sub_district"> 
    
<?php echo validation_errors(); ?>
<p>        
    <label for="dropdown">District/Zilla</label>
                <select name="district" class="required dropdown" style="width: 250px;">
                    <option selected="selected" value="">Select</option>
                  <?php foreach ($get_district as $row) {?>
                  <option value="<?php echo $row['district_id'];?>"><?php echo $row['district_name'];?></option>
                  <?php }?>
                </select>
              </p>
              
              
              <p>
                  <label for="lf">Upazilla/Thana</label>
                  <input maxlength="45" class="required lf" name="sub_district_name" type="text" />
              </p>
              <p>
                  <label></label>
                <input class="button" type="submit" value="Save" />
                <input class="button" type="reset" value="Reset" />
                <a class="" href="<?php echo site_url(); ?>admin/settings/add_sub_district" >Back</a>
              </p>
               
</form> 
                </fieldset>
                
                
