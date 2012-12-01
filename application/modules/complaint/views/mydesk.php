<div id="bgwrap">
  <!-- Main Content -->
  <div id="full-content">
    <div id="full-main">
      <h1>My Desk</h1>
      <div class="pad20">
        <!-- Form -->
        <form action="<?php echo site_url('complaint/find/showComplaint/');?>" method="post" name="frmFilterSearch" id="frmFilterSearch">
          <!-- Fieldset -->
          <fieldset>
          <legend>Filter Complaint</legend>
          <p>
            <span class="lable">Complaint Type</span>
            <select name="selCompalintType" class="dropdown" id="selCompalintType" style="width:270px;">
              <option value="">Select</option>
              <?php  foreach($complaintType as $item){ ?>
	              <option value="<?php echo $item['id'];?>"><?php echo $item['varName'];?></option>
              <?php }?>
            </select>
            <span class="lable">Assign Date From</span>
            <input name="txtDateFrom" type="text" class="sf datePicCal dateISO" id="txtDateFrom" value="" maxlength="10" style="width:80px;"/>
            To
            <input name="txtDateTo" type="text" class="sf datePicCal dateISO" id="txtDateTo" value="" maxlength="10" style="width:80px;" />
            <input class="button" type="submit" value="Filter" />
            <input class="button" type="reset" value="Reset" />
          </p>
          </fieldset>
          <!-- End of fieldset -->
        </form>
        <!-- End of Form -->
       <div id="divIndividualView">
	      <?php $this->load->view('mydesk_list'); ?>
	   </div>

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
		