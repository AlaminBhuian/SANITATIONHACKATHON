<form name="frmComplaintTab" id="frmComplaintTab" method="post" action="<?php echo site_url('complaint/saveComplainant');?>">
  <!-- Fieldset -->
  <fieldset>
  <legend><span class="bangla">অভিযোগকারীর বিবরণ </span> (Information about the complainant ) </legend>
  <p>
    <label><strong>Tracking No:</strong></label>
    <strong><?php echo $complaintInfo->traking_number;?></strong>
  <p>
  <p>
    <label><span class="bangla">অভিযোগকারী </span>(Complainant)<span class="red"> *</span></label>
    <select name="complainant" class="required dropdown" style="width:370px;">
      <option value="">Select</option>
      <?php  
	  	foreach($complaintType as $item){ 
	  		if($item['id'] == $complaintInfo->complainant_id) {
	  ?>
      <option value="<?php echo $item['id'];?>" selected="selected"><?php echo $item['varName'];?></option>
      <?php } else { ?>
      <option value="<?php echo $item['id'];?>"><?php echo $item['varName'];?></option>
      <?php }} ?>
    </select>
  </p>
  <p>
    <label> <span class="bangla">নাম </span> (Name) <span class="red">*</span></label>
    <input id="complaint_name" name="complaint_name" type="text" class="required lf" value="<?php echo $complaintInfo->complaint_name;?>" maxlength="120" />
  <p>
  <p>
    <label><span class="bangla">লিঙ্গ </span>(Sex)</label>
    <select id="complaint_sex" name="sex" class="required dropdown" style="width:250px;">
      <option value="others">Select</option>
      <option value="male" <?php if($complaintInfo->sex=='male'){?> selected="selected"<?php }?>>Male</option>
      <option value="female" <?php if ($complaintInfo->sex=='female') {?>selected="selected"<?php }?>>Female</option>
      <option value="others" <?php if ($complaintInfo->sex=='others') {?>selected="selected"  <?php }?>>Others</option>
    </select>
  </p>
  <p>
    <label><span class="bangla">পিতার নাম </span>(Father's Name)</label>
    <input class="lf" id="complaint_fother_name" name="father_name" type="text" value="<?php echo $complaintInfo->father_name;?>"/>
  </p>
  <p>
    <label><span class="bangla">মাতার নাম </span>(Mother's Name)</label>
    <input class="lf" id="complaint_mother_name" name="mother_name" type="text" value="<?php echo $complaintInfo->mother_name;?>" />
  </p>
  <p>
    <label><span class="bangla">স্বামী/স্ত্রীর নাম </span>(Spouse's Name)</label>
    <input class="lf" id="complaint_spouse_name" name="spouse_name" type="text" value="<?php echo $complaintInfo->spouse_name;?>"/>
  </p>
  <p>
  <table width="100%" border="0">
    <tr>
      <td width="50%"><h2><span class="bangla">স্থায়ী ঠিকানা </span>(Permanent Address)</h2>
        <div class="inpcol">
          <p>
            <label style="width:345px;"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label>
            <input id="complaint_permanent_village" name="permanent_village" type="text" class="sf" style="width:378px;" value="<?php echo $complaintInfo->permanent_village;?>" maxlength="255" />
          </p>
          <p>
            <label style="width:145px;"><span class="bangla"> জেলা </span>(District)</label>
            <select id="complaint_permanent_district" name="permanent_district" class="dropdown" style="width:240px;">
              <option value="0">Select</option>
              <?php  
				foreach($districtList as $item){ 
					if($item['district_id'] == $complaintInfo->permanent_district) {
			  ?>
              <option value="<?php echo $item['district_id'];?>" selected="selected"><?php echo $item['district_name'];?></option>
              <?php } else { ?>
              <option value="<?php echo $item['district_id'];?>"><?php echo $item['district_name'];?></option>
              <?php }} ?>
            </select>
          </p>
          <p>
            <label style="width:145px;" align="left"><span class="bangla">থানা</span>(Thana/Upazilla)</label>
            <span>
                <select id="complaint_permanent_sub_district" name="permanent_sub_district" class="dropdown" id="sub_district"  style="width:240px;">
              <option value="0">Select</option>
              <?php  
				foreach($permanentSubDistricts as $item) { 
					if($item['sub_district_id'] == $complaintInfo->permanent_sub_district) {
			  ?>
              <option value="<?php echo $item['sub_district_id'];?>" selected="selected"><?php echo $item['sub_district_name'];?></option>
              <?php } else { ?>
              <option value="<?php echo $item['sub_district_id'];?>"><?php echo $item['sub_district_name'];?></option>
              <?php }} ?>
            </select>
          </span>
            </p>
          <p>
            <label style="width:145px;"><span class="bangla">ফোন </span>(Ph./Mobile)</label>
            <input class="sf" id="complaint_permanent_phone" name="permanent_phone" type="text" value="<?php echo $complaintInfo->permanent_phone;?>" style="width:230px;"/>
          </p>
          <p>
            <label style="width:145px;"><span class="bangla">ফ্যাক্স </span>(FAX)</label>
            <input class="sf" id="complaint_permanent_fax" name="permanent_fax" type="text" value="<?php echo $complaintInfo->permanent_fax;?>" style="width:230px;"/>
          </p>
          <p>
            <label style="width:145px;"><span class="bangla">ইমেইল </span>(E-mail)</label>
            <input class="sf email" id="complaint_permanent_email" name="permanent_email" type="text" value="<?php echo $complaintInfo->permanent_email;?>" style="width:230px;"/>
          <p> 
        </div></td>
      <td><h2><span class="bangla">বর্তমান ঠিকানা </span>(Present Address)</h2>
        <div class="inpcol">
          <p>
            <label style="width:345px;"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)<span class="red"> *</span></label>
            <input id="complaint_present_village" name="present_village" type="text" class="sf required" style="width:378px;" value="<?php echo $complaintInfo->present_address;?>" maxlength="225" />
          </p>
          <p>
            <label style="width:145px;"><span class="bangla"> জেলা </span>(District)</label>
            <select id="complaint_present_district" name="present_district" class="dropdown" style="width:240px;">
              <option value="0">Select</option>
              <?php  
				foreach($districtList as $item){ 
					if($item['district_id'] == $complaintInfo->present_district) {
			  ?>
              <option value="<?php echo $item['district_id'];?>" selected="selected"><?php echo $item['district_name'];?></option>
              <?php } else { ?>
              <option value="<?php echo $item['district_id'];?>"><?php echo $item['district_name'];?></option>
              <?php }} ?>
            </select>
          </p>
          <p>
            <label style="width:145px;"><span class="bangla">থানা </span>(Thana/Upazilla)</label>
            <select id="complaint_present_sub_district" name="present_sub_district" class="dropdown" id="sub_district" style="width:240px;">
              <option value="0">Select</option>
              <?php  
				foreach($presentSubDistricts as $item) { 
					if($item['sub_district_id'] == $complaintInfo->present_sub_district) {
			  ?>
              <option value="<?php echo $item['sub_district_id'];?>" selected="selected"><?php echo $item['sub_district_name'];?></option>
              <?php } else { ?>
              <option value="<?php echo $item['sub_district_id'];?>"><?php echo $item['sub_district_name'];?></option>
              <?php }} ?>
            </select>
          </p>
          <p>
            <label style="width:145px;"><span class="bangla">ফোন </span>(Ph./Mobile)</label>
            <input id="complaint_present_phone" class="sf" name="present_phone" type="text" value="<?php echo $complaintInfo->present_phone;?>" style="width:230px;" />
          </p>
          <p>
            <label style="width:145px;"> <span class="bangla">ফ্যাক্স </span>(FAX) </label>
            <input class="sf" id="complaint_present_fax" name="present_fax" type="text" value="<?php echo $complaintInfo->present_fax; ?>" style="width:230px;"/>
          </p>
          <p>
            <label style="width:145px;"> <span class="bangla">ইমেইল </span>(E-mail) </label>
            <input class="sf email" id="complaint_present_email" name="present_email" type="text" value="<?php echo $complaintInfo->present_email; ?>" style="width:230px;"/>
          <p> 
        </div></td>
    </tr>
  </table>
  </p>
  
  
  <?php if(modules::run('auth/haveEditPermission', $complaintInfo->complaint_id)) { ?>
  <p>
    <input class="button" type="submit" value="Save" />
    <input class="button" type="reset" value="Reset" />
    <input type="hidden" name="complaint_id" value="<?php echo $complaintInfo->complaint_id; ?>"/>
  </p>
  <?php } ?>
  </fieldset>
  <!-- End of fieldset -->
</form>
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.relatedselects.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {	
			
		$("#frmComplaintTab").relatedSelects({
			onChangeLoad: '<?php echo site_url('complaint/datasupplier/') ?>',
			loadingMessage: 'Please wait',
			selects: ['permanent_district', 'permanent_sub_district']
		});
                
         $("#frmComplaintTab").relatedSelects({
			onChangeLoad: '<?php echo site_url('complaint/datasupplier2/') ?>',
			loadingMessage: 'Please wait',
			selects: ['present_district', 'present_sub_district']
		});	
		
		var options = {
			type: 'POST',
			async: false,
			target: '#showMsg', 
			beforeSubmit: function() {},
			success: function(data) {}
		};	
		
		jQuery("#frmComplaintTab").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		});

		
   });
</script>
