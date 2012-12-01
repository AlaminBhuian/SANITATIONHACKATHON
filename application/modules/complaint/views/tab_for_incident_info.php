<form name="frmIncidentTab" id="frmIncidentTab" method="post" action="<?php echo site_url('complaint/submit_incident_information');?>">
  <!-- Fieldset -->
  <fieldset>
      <legend> <span class="bangla">মানবাধিকার লঙ্ঘনের সংক্ষিপ্ত বিবরণ </span>(Information about the Incident)</legend>
  <p>
    <label for="sf"><span class="bangla">তারিখ </span>(Date) dd-mm-yyyy<span class="red">*</span></label>
    <input class="sf datePicCal dateISO required" name="incident_date" type="text" value="<?php echo $incident_date;?>" />
    <span class="bangla">সময় </span>(Time)
    
    <select name="selTimeHr" class="dropdown" id="selTimeHr" style="width:60px;">
      <option value="0">Hr</option>
      <?php for($i=1;$i<=12;$i++) {?>
      <option value="<?php echo $i;?>" <?php if($i == $selTimeHr) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
      <?php }?>
    </select>
    <select name="selTimeMin" class="dropdown" id="selTimeMin" style="width:60px;">
      <option value="0">Min</option>
      <?php for($i=0;$i<60;$i++) {?>
      <option value="<?php echo $i;?>" <?php if($i == $selTimeMin) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
      <?php }?>
    </select>
    <select name="selTimeAMPM" class="dropdown" id="selTimeAMPM" style="width:60px;">
      <option value="PM" <?php if($selTimeAMPM == 'PM') { ?> selected="selected" <?php } ?>>PM</option>
      <option value="AM" <?php if($selTimeAMPM == 'AM') { ?> selected="selected" <?php } ?>>AM</option>
    </select>
        
  </p>
  <p>
  <h2><span class="bangla">ঘটনাস্থল </span>(Place of Occurrence)</h2>
  <p>
    <label for="lf"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span><br />
    (Village/Area/Ward)</label>
    <input class="lf" name="incident_address" type="text" value="<?php echo $incident_address;?>"/>
  </p>
  <p>
    <label for="sf"><span class="bangla"> জেলা </span>(District)</label>
    <select name="permanent_district" class="dropdown" style="width:370px;">
      <option value="0">Select</option>
      <?php foreach ($get_district as $row) {?>
      <option value="<?php echo $row['district_id'];?>" <?php if( $permanent_district==$row['district_id']){?> selected="selected" <?php }?>><?php echo $row['district_name'];?></option>
      <?php }?>
    </select>
  </p>
  <p>
    <label for="sf"><span class="bangla">থানা </span>(Thana/Upazilla)</label>
    <select name="permanent_sub_district" class="dropdown" style="width:370px;">
      <option value="0">Select</option>
      <?php if($sub_district_info) { ?>
      <option value="<?php echo $sub_district_info[0]['sub_district_id'];?>"  selected="selected" ><?php echo $sub_district_info[0]['sub_district_name'];?></option>
      <?php } ?>
    </select>
  </p>
  </p>
  <p>
  <p> <strong><span class="bangla">ঘটনার বিবরণঃ </span>(Description of the occurrence)</strong> <br />
    Describe the events that you want to complaint about. Tell what happened who did it and where it happened. Put in as much detail us you can and explain why you think it happened. </p>
  <!-- WYSIWYG editor -->
  <textarea  class="wysiwyg" name="incident_description" style="width:600px;height:150px;"><?php echo $incident_description;?></textarea>
  <!-- End of WYSIWYG editor -->
  </p>
  <p> <span class="bangla">বর্ণিত অভিযোগের বিষয়ে কোন আদালতে মামলা হয়েছে কী না? </span>(Has the said case been lodged before any court?)
    <label style="width:60px;">
    <input type="radio" name="case_court" value="yes" <?php if($case_court == 'yes'){?> checked="checked"<?php }?>/>
    Yes</label>
    <label style="width:60px;">
    <input name="case_court" type="radio" value="no" <?php if($case_court == 'no'){?> checked="checked" <?php } if($case_court == '') { ?> checked="checked"<?php } ?>/>
    No</label>
  </p>
  <p>
  <p> <strong><span class="bangla"> যে প্রতিকার প্রার্থনা করা হয়েছে </span>(The Desired Remedy)</strong> <br />
    What kind of outcome do you want to resolve your complaint?</p>
  <!-- WYSIWYG editor -->
  <textarea class="wysiwyg" name="incident_desired_remedy" style="width:600px;height:150px;"><?php echo $incident_desired_remedy;?></textarea>
  <!-- End of WYSIWYG editor -->
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
		$("#frmIncidentTab").relatedSelects({
				onChangeLoad: '<?php echo site_url('complaint/datasupplier/') ?>',
				loadingMessage: 'Please wait',
				selects: ['permanent_district', 'permanent_sub_district']
		});
		
		$(".datePicCal").bind("focus click", function(e){	
			var pickerOpts = {
				dateFormat:"dd-mm-yy",
				showOn: "button",
				buttonImage: "assets/images/icons/calendar.png",
				buttonImageOnly: true
			};
			$(this).datepicker(pickerOpts);
		});	
		
		var options = {
			type: 'POST',
			async: false,
			target: '#showMsg', 
			beforeSubmit: function() {},
			success: function(data) {}
		};	
		
		jQuery("#frmIncidentTab").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		});
                
  });

</script>
