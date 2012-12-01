<form action="<?php echo site_url('complaint/submit_complaint_analysis');?>" method="post" name="frmAnalysisTab" id="frmAnalysisTab">
    <fieldset>
    <legend>Complaint Analysis</legend>
  <p> <span class="bangla"> অভিযোগটি কি মানবাধিকারের লঙ্ঘন? </span>(Is this complaint a human rights violation ?)
    <label style="width:60px">
    <input name="human_rights_violation" type="radio" value="yes"  <?php if($human_rights_violation == 'yes'){?> checked="checked" <?php } if($human_rights_violation == '') { ?> checked="checked"<?php } ?>/>
    Yes</label>
    <label style="width:60px">
    <input name="human_rights_violation" type="radio" value="no" <?php if($human_rights_violation == 'no'){?> checked="checked"<?php }?>/>
    No</label>
  </p>
  <p> <span><span class="bangla">কোন ধরনের মানবাধিকার লঙ্ঘন ?</span>(What kind of Human Rights violation?)</span>
    <?php foreach($getAnalysisHRViolationList as $hrviolationItem): ?>
  <p>
    <select name="type_of_violation[]" class="dropdown" id="type_of_violation" style="width:400px;" >
      <option value="0" selected="selected">Select</option>
      <?php  
			foreach($getVolutionList as $item){ 
				if($item['id'] == $hrviolationItem['hrviolation_id']) {
		  ?>
      <option value="<?php echo $item['id'];?>" selected="selected"><?php echo $item['varName'];?></option>
      <?php } else { ?>
      <option value="<?php echo $item['id'];?>"><?php echo $item['varName'];?></option>
      <?php }} ?>
    </select>
	<?php if(modules::run('auth/haveEditPermission', $complaintInfo->complaint_id)) { ?>
    	<a class="removeHRV" rel="<?php echo $hrviolationItem['hrviolation_id']; ?>" href="#remove">[-] Remove</a></p>
	<?php } ?>	
  <?php endforeach; ?>
  
  <?php if(modules::run('auth/haveEditPermission', $complaintInfo->complaint_id)) { ?>
  <div id="blockHRVio">
    <p>
      <select name="type_of_violation[]" class="dropdown" id="type_of_violation" style="width:400px;">
        <option value="0" selected="selected">Select</option>
        <?php  
	  	foreach($getVolutionList as $item){ 
	  		if($item['id'] == $type_of_violation) {
	  ?>
        <option value="<?php echo $item['id'];?>" selected="selected"><?php echo $item['varName'];?></option>
        <?php } else { ?>
        <option value="<?php echo $item['id'];?>"><?php echo $item['varName'];?></option>
        <?php }} ?>
      </select>
      <a id="removeMoreAna" href="">[-] Remove</a> <a id="addMoreAna" href="">[+] Addition</a></p>
  </div>
  <?php } ?>
  </p>
  <p>
  <p> <span class="bangla">চিহ্নিত অভিযোগ </span>(Identified category) <br />
    <textarea name="identified_category" style="width:600px;height:150px;" class="wysiwyg"><?php echo $identified_category;?></textarea>
  </p>
  <p> <span class="bangla">লঙ্ঘিত অধিকারটি কি বাংলাদেশ সংবিধানে স্বীকৃত </span>(Is the violated Right covered in the  Constitution)?
    <label style="width:60px">
    <input type="radio" name="violet_constitution" value="yes" <?php if($violet_constitution=='yes'){?>checked="checked"<?php }?>/>
    Yes</label>
    <label style="width:60px">
    <input name="violet_constitution" type="radio" value="no" <?php if($violet_constitution==''){?>checked="checked"<?php }?> <?php if($violet_constitution=='no'){?>checked="checked"<?php }?>/>
    No</label>
  </p>
  <?php if(modules::run('auth/haveEditPermission', $complaintInfo->complaint_id)) { ?>
  <p>
    <input class="button" type="submit" value="Save" />
    <input class="button" type="reset" value="Reset" />
    <input type="hidden" name="complaint_id" value="<?php  echo $complaintInfo->complaint_id; ?>"/>
  </p>
  </fieldset>
  <script type="text/javascript" src="<?php echo site_url('assets/js/jquery-dynamic-form.js'); ?>"></script>
  <script type="text/javascript">
  $(document).ready(function() {		
		var options = {
			type: 'POST',
			async: false,
			target: '#showMsg', 
			beforeSubmit: function() {},
			success: function(data) {}
		};	
		
		jQuery("#frmAnalysisTab").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		}); 
		
		$("#blockHRVio").dynamicForm("#addMoreAna", "#removeMoreAna", {limit:10});     
		
		$("a.removeHRV").click(function() { 
			if(confirm('Are you sure you want to remove Kind of Human Rights Violation Info?'))
			{
				$(this).closest('p').fadeTo(400, 0, function () { 
					$(this).slideUp(100);
					$(this).remove();
				});
				
				var id = $(this).attr("rel");
				$.get("<?php echo site_url("complaint/removeHRVType/$complaintInfo->complaint_id/"); ?>/"+id);
				
				return false;
			} else {
				return false;
			}
		});          
  });

</script>
  <?php } ?>
</form>
