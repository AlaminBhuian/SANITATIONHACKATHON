<?php echo validation_errors('<div class="msg-error">', '</div>'); ?>

<div id="bgwrap">
  <!-- Main Content -->
  <div id="full-content">
    <div id="full-main">
        <h1>Complaint Details &amp; Process <span><a href="<?php echo site_url('complaint/printComplaint/');?>/<?php echo $id; ?>" class="table_print" title="Print Total Complaint" target="_blank"><img src="assets/images/icons/icon_printer.gif"></a>	</span></h1>
	  <div id="showMsg"></div>
      <div id="tabs" class="tabs-view" >
        <ul>
          <li><a href="<?php echo site_url('complaint/tab_complaint/'.$id)?>">Complainant's Info</a></li>
          <li><a href="<?php echo site_url('complaint/tab_victim_info/'.$id)?>">Victim's Info</a></li>
		  <li><a href="<?php echo site_url('complaint/tab_analysis/'.$id)?>">Analysis</a></li>
          <li><a href="<?php echo site_url('complaint/tab_respondent_info/'.$id)?>">Respondent's Info</a></li>
          <li><a href="<?php echo site_url('complaint/tab_incident_info/'.$id)?>">Incident Info</a></li>
          <li><a href="<?php echo site_url('complaint/tab_complaint_document/'.$id)?>">Documents</a></li>          
		  <li><a href="<?php echo site_url('complaint/reminder/add/'.$id)?>">Reminder</a></li>
          <li><a href="<?php echo site_url('complaint/tab_action_history/'.$id)?>">Action &amp; History</a></li>
        </ul>
      </div>
  	  <div id="tabLoad"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
 $(function() {
	var tabOpts = {
	   select: function() { 	   
			$('#tabLoad').append("<div class='ajaxLoading'>Loading, please wait ...</div>");			
		},
		show: function() { 
		   	$("#tabLoad").remove(); 
		}
	};
	$("#tabs").tabs(tabOpts);
	
	$("#tabs li a").click(
		function () {
			$("#showMsg").empty();
			return false;
		}
	);
            
	
});


</script>
