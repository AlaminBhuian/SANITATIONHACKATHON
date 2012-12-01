<div id="sidebar">
  <!-- Sortable Dialogs -->
  <h2>Dashboard</h2>
  <div class="sort">
    <div class="box ui-widget ui-widget-content ui-corner-all portlet">
      <div class="portlet-header">Complaint Submitted</div>
      <div class="portlet-content">
        <p><b>Today:</b> <?php $todaysComplaint = modules::run('complaint/dashboard/showTotalSubmission', 'today'); echo $todaysComplaint->totalComplaint; ?></p>
        <p><b>Last 7 Days:</b> <?php $lastweekComplaint = modules::run('complaint/dashboard/showTotalSubmission', 'lastweek'); echo $lastweekComplaint->totalComplaint; ?></p>
        <p><b>Last 30 Days:</b> <?php $lastmonthComplaint = modules::run('complaint/dashboard/showTotalSubmission', 'lastmonth'); echo $lastmonthComplaint->totalComplaint; ?></p>
      </div>
    </div>
    <div class="box ui-widget ui-widget-content ui-corner-all portlet">
      <div class="portlet-header">My Desk Status</div>
      <div class="portlet-content">
	   <?php 
	   		$mydeskList = modules::run('complaint/dashboard/getTotalMyDeskComplaint'); 
		   		if(is_array($mydeskList) && count($mydeskList) >0)	{
					foreach($mydeskList as $myItem):
	   ?>
	    	    <p><b><?php echo $myItem['name']; ?>:</b> <?php echo $myItem['totalComplaint']; ?></p>
		<?php endforeach; } ?>
      </div>
    </div>
    <div class="box ui-widget ui-widget-content ui-corner-all portlet">
      <div class="portlet-header">Last Log</div>
      <div class="portlet-content">
        <p><b>Last Login: </b><?php echo date("d-M-Y h:i:s A", strtotime($this->session->userdata('sess_nhrc_last_login'))); ?></p>
      </div>
    </div>
  </div>
  <!-- End of Sortable Dialogs -->
</div>
