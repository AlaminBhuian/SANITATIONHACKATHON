<div id="bgwrap">
  <!-- Main Content -->
  <div id="full-content">
    <div id="full-main">
      <h1>Find Complaint</h1>
      <div class="pad20">
        <!-- Form -->
        <form action="<?php echo site_url('complaint/find/showFindComplaint/');?>" method="post" name="frmFilterSearch" id="frmFilterSearch">
          <!-- Fieldset -->
          <fieldset>
          <legend>Search Complaint</legend>
          <p>
            <span class="lable">Complaint Name </span>
            <input name="complaintName" type="text" class="lf" id="complaintName" value="" maxlength="50" style="width:205px;"/>
            <span class="lable">Victim's Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <input name="victimsName" type="text" class="lf" id="victimsName" value="" maxlength="50" style="width:205px;"/>
          </p>
          <p>
            <span class="lable">Complaint Type &nbsp;</span>
            <select name="selCompalintType" class="dropdown" id="selCompalintType" style="width:215px;">
              <option value="">Select</option>
              <?php  foreach($complaintType as $item){ ?>
	              <option value="<?php echo $item['id'];?>"><?php echo $item['varName'];?></option>
              <?php }?>
            </select>
            <span class="lable">Received Date From</span>
            <input name="txtDateFrom" type="text" class="sf datePicCal dateISO" id="txtDateFrom" value="" maxlength="10" style="width:80px;"/>
            To
            <input name="txtDateTo" type="text" class="sf datePicCal dateISO" id="txtDateTo" value="" maxlength="10" style="width:80px;" />
          </p>
		  <p>
            <span class="lable">Complaint Status </span>
            <select name="selCompalintStatus" class="dropdown" id="selCompalintStatus" style="width:215px;">
              <option value="">Select</option>
              <?php  foreach($complaintStatus as $item){ ?>
	              <option value="<?php echo $item['status_id'];?>"><?php echo $item['name'];?></option>
              <?php }?>
            </select>   
			<span class="lable">Assigned Desk &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <select name="selCompalintPresentDesk" class="dropdown" id="selCompalintPresentDesk" style="width:220px;">
              <option value="">Select</option>
              <?php  foreach($complaintDesk as $item){ ?>
	              <option value="<?php echo $item['desk_id'];?>"><?php echo $item['name'];?></option>
              <?php }?>
            </select>         
            <input class="button" type="submit" value="Find Complaint" />
            <input class="button" type="reset" value="Reset" />
          </p>
          </fieldset>
          <!-- End of fieldset -->
        </form>
        <!-- End of Form -->
       <div id="divIndividualView"></div>

      </div>
      <hr />
    </div>
  </div>
  <!-- End of Main Content -->
</div>
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery-ajaxLink.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){	 
		var options = {
			type: 'POST',
			async: false,
			target: '#divIndividualView', 
			beforeSubmit: function() {},
			success: function(data) {}
		};
		
		//Validation
		jQuery("#frmFilterSearch").validate({
			submitHandler: function(form) {
			   $('#divIndividualView').append("<div class='ajaxLoading'>Loading, please wait ...</div>");
			   jQuery(form).ajaxSubmit(options);
			   $("#ajaxLoading").remove();
			}
		});
	});		
</script>
		