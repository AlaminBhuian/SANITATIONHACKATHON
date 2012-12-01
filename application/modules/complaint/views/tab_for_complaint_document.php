<?php if(modules::run('auth/haveEditPermission', $complaintInfo->complaint_id)) { ?>
<fieldset>
<legend><span class="bangla">সংযুক্ত কাগজপত্র </span> (Complaints Supporting Documents)</legend>
<form action="<?php echo site_url('complaint/uploadDocument');?>" method="post" enctype="multipart/form-data" name="frmComplaintDocument" id="frmComplaintDocument">
  <!-- Fieldset -->
  <p><label>Document Title <span class="red"> *</span></label>
    <input class="required lf" name="document_title" type="text" />
  </p>
  <p>
    <label>Document Notes</label>
    <!-- WYSIWYG editor -->
    <textarea class="wysiwyg" name="document_other_note" style="width:450px;height:50px;" ></textarea>
    <!-- End of WYSIWYG editor -->
  </p>
  <p> <label>Upload Document <span class="red"> *</span></label>
    <input name="userfile" type="file" class="required" size="50"/>
    (pdf,doc,xls,jpg,gif, audio,video)
  </p>
  
  <p>
  <label></label>
    <input class="button" type="submit" value="Save &amp; Upload" />
    <input class="button" type="reset" value="Reset" />
    <input type="hidden" name="complaint_id" value="<?php echo $complaintInfo->complaint_id; ?>"/>
  </p>
</form>
</fieldset>

<script type="text/javascript">

    $(document).ready(function() {	
 		var options = {
			type: 'POST',
			async: false,
			target: '#showMsg', 
			beforeSubmit: function() {},
			success: function(data) {},
			beforeSend: function() {
				//$('#divToDocUpload').html('beforeSend');
				$('#showMsg').append("<div id='divAjaxPro1'>Checking File, please wait ...</div>");
			},
			uploadProgress: function(event, position, total, percentComplete) {
				//$('#divToDocUpload').html('uploadProgress');
				$("#divAjaxPro1").remove();			
				$('#showMsg').append("<div id='divAjaxPro2'>File Upload Progress, please wait ...</div>");
			},
			complete: function(xhr) {
				$("#divAjaxPro2").remove();		
				$('#showMsg').html(xhr.responseText);
				$("#frmComplaintDocument").resetForm();
				// ajax update doc table
				$.ajax({
				  url: '<?php echo site_url('complaint/showDocList/'); ?>/<?php echo $complaintInfo->complaint_id; ?>',
				  success: function(data) {
					$('#divUpdatedDocumentList').html(data);
				  }
				});						
			}
		};	
		
		jQuery("#frmComplaintDocument").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		});
	 
	 	var defaultmessagedisplay = 10000;    
    	setTimeout(function() { $('.msg-success').hide('slow'); }, defaultmessagedisplay); 

		
   });
</script>
  <?php } ?>

<div id="divUpdatedDocumentList">
	<?php $this->load->view('complaint/document_list'); ?>
</div>

