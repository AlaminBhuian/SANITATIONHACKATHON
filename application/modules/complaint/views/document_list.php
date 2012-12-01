<fieldset>
<legend>Uploaded Document</legend>
<table cellspacing="0" summary="table" class="broom_table">
  <thead>
    <tr>
      <th>Note</th>
      <th>File Title </th>
      <th>File Name </th>
      <th>File Size </th>
      <th>Upload Date </th>
      <th align="center">Download</th>
    </tr>
  </thead>
  <tbody>
    <?php 
		$i=0;
		foreach($getDocuments as $item): 
		if(($i % 2) == 0) { $alt = "odd"; } else { $alt = "even"; }
		$i++;	
	?>
    <tr class="<?php echo $alt;?>" style="height:30px">
      <td align="center"><img src="<?php echo site_url('assets/images/icons/balloon.png');?>" title="<?php echo nl2br( $item['varDocumentDesc']); ?>" class="tooltip" /></td>
      <td><?php echo $item['varDocumentTitle']; ?></a></td>
      <td><?php echo $item['varFileName']; ?></td>
      <td><?php echo $item['varFileSize']; ?> KB </td>
      <td><?php echo date("d-M-Y H:i A", strtotime($item['dtInsertDT'])); ?></td>
      <td align="center">
	  	<a href="<?php echo site_url('complaint/download/'); ?>/<?php echo $item['id']; ?>/<?php echo $complaint_id; ?>" class="table_download" title="Download / View">Download/View</a>
		<?php if(modules::run('auth/haveEditPermission', $complaint_id)) { ?>
		<a href="<?php echo site_url('complaint/deleteDocument/'); ?>/<?php echo $item['id']; ?>/<?php echo $complaint_id; ?>" class="rmdoc ajaxLink table_delete" title="Remove">Delete</a>
		  <?php } ?>
	   </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</fieldset>

<script type="text/javascript" src="<?php echo site_url('assets/js/jquery-ajaxLink.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {	 
		var options = { 
				target:"#divUpdatedDocumentList",
				beforeSend: function() {
					//$('#divIndividualView').empty();
					$('#divUpdatedDocumentList').append("<span id='divAjaxLoading'>Loading, Please Wait ...</span>");
				},
				success: function() {
					return false;
				}
		}; 	
		$(".ajaxLink").ajaxLink(options);	  		
		
//		$(".rmdoc").click(function() { 
//			if(confirm('Are you sure you want to delete this document?'))
//			{				
//				return true;
//			} else {
//				return false;
//			}
//		});

	  $(".tooltip").easyTooltip();
	});		
</script>
