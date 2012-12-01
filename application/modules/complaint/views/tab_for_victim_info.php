<form name="frmVictimInfoTab" id="frmVictimInfoTab" method="post" action="<?php echo site_url('complaint/submit_victim_information');?>">
  <fieldset>
      <legend> <span class="bangla"> ক্ষতিগ্রস্ত ব্যক্তি সংক্রান্ত তথ্য </span>(Information About the Victim)
          <?php if(modules::run('auth/haveEditPermission', $complaintInfo->complaint_id)) { ?>
          <input type="checkbox" id="chkSameAs"><span style="font-size: 12px;color:#990033">Victim Info Same as Complainant info</span>
          <?php }?>
      </legend>
  <p>       
    <label><span class="bangla">ক্ষতিগ্রস্ত ব্যক্তির নাম </span>(Victim's Name)</label>
    <input id="victims_name" name="victims_name" type="text" class="lf" value="<?php echo $victims_name;?>" maxlength="150" />
  </p>
  <p>
    <label><span class="bangla">পিতার নাম </span>(Father's Name) </label>
    <input id="victims_father_name" name="victims_father_name" type="text" class="lf" value="<?php echo $victims_father_name;?>" maxlength="150"/>
  </p>
  <p>
    <label><span class="bangla">মাতার নাম </span>(Mother's Name) </label>
    <input id="victims_mother_name" name="victims_mother_name" type="text" class="lf" value="<?php echo $victims_mother_name;?>" maxlength="150"/>
  </p>
  <p>
    <label><span class="bangla">স্বামী/স্ত্রীর নাম </span>(Spouse's Name) </label>
    <input id="victims_spouse_name" name="victims_spouse_name" type="text" class="lf" value="<?php echo $victims_spouse_name;?>" maxlength="150"/>
  </p>
  <p>
    <label for="dropdown"><span class="bangla">লিঙ্গ </span>(Sex)</label>
    <select id="victims_sex" name="victims_sex" class="dropdown" style="width: 250px;">
        <option selected="selected" value="others">Select</option>
      <option value="male" <?php if($victims_sex=='male'){?> selected="selected"<?php }?>>Male</option>
      <option value="female" <?php if ($victims_sex=='female') {?>selected="selected"<?php }?>>Female</option>
      <option value="others" <?php if ($victims_sex=='others') {?>selected="selected"  <?php }?>>Others</option>
    </select>
  </p>
  <p>
    <label><span class="bangla">বয়স </span>(Age)</label>
    <input name="victims_age" type="text" class="sf digits" value="<?php echo $victims_age;?>" maxlength="3" />
  </p>
  <p>
    <label><span class="bangla">ধর্ম </span>(Religion)</label>
     
    <select name="victims_religion" class="dropdown" style="width: 250px;">
        <option selected="selected" value="0">Select</option>
      <?php foreach ($religionList as $religion) {?>
              <option value="<?php echo $religion['id'];?>" <?php if( $victims_religion==$religion['id']){?> selected="selected" <?php }?>><?php echo $religion['varName'];?></option>
              <?php }?>
            </select>
  </p>
  <p>
    <label><span class="bangla">ক্ষতিগ্রস্ত ব্যক্তির সংখ্যা </span>(Number of Victims)</label>
    <input name="victims_number" type="text" class="sf digits" value="<?php echo $victims_number;?>" maxlength="10"/>
  </p>
  <p> <span class="lable"><span class="bangla">আপনি কি কোনো আদিবাসী সম্প্রদায়ের একজন সদস্য? </span>(Are you a member of any indigenous Community?)</span>
    <label style="width:65px;">
    <input type="radio" name="victims_indigenous_community" value="yes" <?php if($victims_indigenous_community=='yes'){?>checked="checked" <?php }?> />
    Yes</label>
    <label style="width:65px;">
    <input name="victims_indigenous_community" type="radio" value="no" <?php if($victims_indigenous_community=='no'){?>checked="checked" <?php }?> 
	<?php if($victims_indigenous_community==''){?>checked="checked" <?php }?> />
    No</label>	
  </p>
  <p> <span class="lable"><span class="bangla">প্রতিবন্ধী কী না? </span>(Is the victim disabled?)</span>
    <label style="width:65px;">
    <input type="radio" name="disabled" value="yes"<?php if($disabled=='yes'){?>checked="checked" <?php }?>/>
    Yes</label>
    <label style="width:65px;">
    <input name="disabled" type="radio" value="no" checked="checked" <?php if($disabled=='no'){?>checked="checked" <?php }?> <?php if($disabled==''){?>checked="checked" <?php }?> />
    No</label>
  </p>
  <p>
  <table width="100%" border="0">
    <tr>
      <td width="50%"><div class="inpcol">
          <h2><span class="bangla">স্থায়ী ঠিকানা </span>(Permanent Address)</h2>
          <p>
            <label><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label>
            <input id="victims_permanent_village" name="victims_permanent_village" type="text" class="sf" style="width:175px;" value="<?php echo $victims_permanent_village;?>" maxlength="150"/>
          </p>
          <p>
            <label><span class="bangla"> জেলা </span>(District)</label>
            <select id="victims_permanent_district" name="permanent_district" class="dropdown" style="width:175px;">
                <option id="select_per_dis" value="0">Select</option>
              <?php foreach ($get_district as $row) {?>
              <option value="<?php echo $row['district_id'];?>" <?php if( $permanent_district==$row['district_id']){?> selected="selected" <?php }?>><?php echo $row['district_name'];?></option>
              <?php }?>
            </select>
          </p>
          <p>
            <label><span class="bangla">থানা </span>(Thana/Upazilla)</label>
            <select id="victims_permanent_sub_district" name="permanent_sub_district" class="dropdown" id="sub_district" style="width:175px;">
              <option id="select_per_sub_dis" value="0">Select</option>
              <?php  
				foreach($permanentSubDistricts as $item) { 
					if($item['sub_district_id'] == $permanent_sub_district) {
			  ?>
              <option value="<?php echo $item['sub_district_id'];?>" selected="selected"><?php echo $item['sub_district_name'];?></option>
              <?php } else { ?>
              <option value="<?php echo $item['sub_district_id'];?>"><?php echo $item['sub_district_name'];?></option>
              <?php }} ?>
            </select>
          </p>
          <p>
            <label><span class="bangla">ফোন </span>(Phone/Mobile)</label>
            <input id="victims_permanent_phone" name="victims_permanent_phone" type="text" class="sf" style="width:175px;" value="<?php echo $victims_permanent_phone;?>" maxlength="30"/>
          </p>
          <p>
            <label><span class="bangla">ফ্যাক্স </span>(FAX)</label>
            <input id="victims_permanent_fax" name="victims_permanent_fax" type="text" class="sf" style="width:175px;" value="<?php echo $victims_permanent_fax;?>" maxlength="30"/>
          </p>
          <p>
            <label><span class="bangla">ইমেইল </span>(E-mail)</label>
            <input id="victims_permanent_email" name="victims_permanent_email" type="text" class="sf email" style="width:175px;" value="<?php echo $victims_permanent_email;?>" maxlength="120"/>
          </p> 
      </div></td>
      <td><div class="inpcol">
          <h2><span class="bangla">বর্তমান ঠিকানা </span>(Present Address)</h2>
          <p>
            <label><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label>
            <input id="victims_present_village" name="victims_present_village" type="text" class="sf" style="width:175px;" value="<?php echo $victims_present_village;?>" maxlength="120"/>
          </p>
          <p>
            <label><span class="bangla"> জেলা </span>(District)</label>
            <select id="victims_present_district" name="present_district" class="dropdown" style="width:175px;">
              <option id="select_pre_dis" value="0">Select</option>
              <?php foreach ($get_district as $row) {?>
              <option value="<?php echo $row['district_id'];?>" <?php if( $present_district==$row['district_id']){?> selected="selected" <?php }?>><?php echo $row['district_name'];?></option>
              <?php }?>
            </select>
          </p>
          <p>
            <label><span class="bangla">থানা </span>(Thana/Upazilla)</label>
            <select id="victims_present_sub_district" name="present_sub_district" class="dropdown" style="width:175px;">
              <option id="select_pre_sub_dis" value="0">Select</option>
              <?php  
				foreach($presentSubDistricts as $item) { 
					if($item['sub_district_id'] == $present_sub_district) {
			  ?>
              <option value="<?php echo $item['sub_district_id'];?>" selected="selected"><?php echo $item['sub_district_name'];?></option>
              <?php } else { ?>
              <option value="<?php echo $item['sub_district_id'];?>"><?php echo $item['sub_district_name'];?></option>
              <?php }} ?>
            </select>
          </p>
          <p>
            <label><span class="bangla">ফোন </span>(Phone/Mobile)</label>
            <input id="victims_present_phone" name="victims_present_phone" type="text" class="sf" style="width:175px;" value="<?php echo $victims_present_phone;?>" maxlength="30"/>
          </p>
          <p>
            <label><span class="bangla">ফ্যাক্স </span>(FAX)</label>
            <input id="victims_present_fax" name="victims_present_fax" type="text" class="sf" style="width:175px;" value="<?php echo $victims_present_fax;?>" maxlength="30"/>
          </p>
          <p>
            <label><span class="bangla">ইমেইল </span>(E-mail)</label>
            <input id="victims_present_email" name="victims_present_email" type="text" class="sf email" style="width:175px;" value="<?php echo $victims_present_email;?>" maxlength="120"/>
          
          </p> 
      </div>
      
      
      </td>
    </tr>
  </table>
  </p>
  <p>
    <label style="width:345px;"><span class="bangla">অভিযোগ গ্রহণের ধরন </span>(Method Of Delivery)</label>
  </p>
  <div class="inpcol" >
    <p>
      <?php 
		  if(isset($methodOfComplaint)) {
			  foreach($methodOfComplaint as $item):
	   ?>
      <label>
      <input name="chkMethodOfDel[]" type="checkbox" value="<?php echo $item['id']; ?>" <?php if(in_array($item['id'], $selMethodOfDel)) {?> checked="checked" <?php } ?> />
      <?php echo $item['varName']; ?></label>
      <?php endforeach; } ?>
  </p>
  </div>
  
  <p>
    <label> Number Of Attachment Pages </label>
    <input class="sf" name="attachment_page_number" type="text" value="<?php echo $complaintInfo->attachment_page_number; ?>" />
  </p>
  <p>
    <label><span class="bangla"> ঘটনার সংক্ষিপ্ত বর্ণনা </span>(Summarized Description of the Incident)<span class="red"> *</span></label>
    <textarea class="required wysiwyg" name="description" style="width:600px;height:150px;"><?php echo $complaintInfo->description; ?></textarea>
  </p>
  
  
  <?php if(modules::run('auth/haveEditPermission', $complaintInfo->complaint_id)) { ?>
  <p>
    <input class="button" type="submit" value="Save" />
    <input class="button" type="reset" value="Reset" />
    <input type="hidden" name="complaint_id" value="<?php  echo $complaintInfo->complaint_id; ?>"/>
  </p>
  <?php } ?>
  </fieldset>
  <!-- End of fieldset -->
</form>
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.relatedselects.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {

            $("#chkSameAs").click(function() {
	var satisfied = $('#chkSameAs:checked').val();
    if (satisfied != undefined) {
		$('#victims_name').val($('#complaint_name').val());							
		$('#victims_father_name').val($('#complaint_fother_name').val());							
		$('#victims_mother_name').val($('#complaint_mother_name').val());							
		$('#victims_spouse_name').val($('#complaint_spouse_name').val());							
									
		$('#victims_sex').html('<option value="" selected="selected">'+$('#complaint_sex').html()+'</option>');
		$('#victims_permanent_village').val($('#complaint_permanent_village').val());
                $('#victims_permanent_district').html('<option value="" selected="selected">'+$('#complaint_permanent_district').html()+'</option>');
                $('#victims_permanent_sub_district').html('<option value="" selected="selected">'+$('#complaint_permanent_sub_district').html()+'</option>');
                $('#victims_present_district').html('<option value="" selected="selected">'+$('#complaint_present_district').html()+'</option>');
                $('#victims_present_sub_district').html('<option value="" selected="selected">'+$('#complaint_present_sub_district').html()+'</option>');
                
                $('#victims_permanent_phone').val($('#complaint_permanent_phone').val());
                $('#victims_permanent_fax').val($('#complaint_permanent_fax').val());
                $('#victims_permanent_email').val($('#complaint_permanent_email').val());
                $('#victims_present_village').val($('#complaint_present_village').val());
                $('#victims_present_phone').val($('#complaint_present_phone').val());
                $('#victims_present_fax').val($('#complaint_present_fax').val());
                $('#victims_present_email').val($('#complaint_present_email').val());
	} else {
		$('#victims_name').val('');	
		$('#victims_father_name').val('');	
		$('#victims_mother_name').val('');	
		$('#victims_spouse_name').val('');
               // $('#victims_sex').attr('disabled', 'disabled');
		$('#victims_permanent_village').val('');
                $('#select_per_sub_dis').attr('selected', true);
                $('#select_per_dis').attr('selected', true);
                $('#select_pre_dis').attr('selected', true);
                $('#select_pre_sub_dis').attr('selected', true);
                $('#victims_permanent_phone').val('');
                $('#victims_permanent_fax').val('');
                $('#victims_permanent_email').val('');
                $('#victims_present_village').val('');
                $('#victims_present_phone').val('');
                $('#victims_present_fax').val('');
                $('#victims_present_email').val('');
                
	}
    }); 

				
		$("#frmVictimInfoTab").relatedSelects({
			onChangeLoad: '<?php echo site_url('complaint/datasupplier/') ?>',
			loadingMessage: 'Please wait',
			selects: ['permanent_district', 'permanent_sub_district']
		});
                
         $("#frmVictimInfoTab").relatedSelects({
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
		
		jQuery("#frmVictimInfoTab").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		});
				
   });
</script>
