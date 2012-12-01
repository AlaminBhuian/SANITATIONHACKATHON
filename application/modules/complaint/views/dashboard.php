<div id="main">
  <h1>Welcome, <span> <?php echo $this->session->userdata('sess_nhrc_user_name'); ?></span>!</h1>
  <p>What would you like to do today?</p>
  <div class="pad20">
    <ul class="dash">
      <?php 
		 if(modules::run('auth/havePermission', 'REPORT')) { 
		?>
      <li> <a href="<?php echo site_url('reports');?>" title="Generate Reports" class="tooltip"> <img src="assets/assets/icons/4_48x48.png" alt="" /> <span>Reports</span> </a> </li>
	  <?php } ?>
    </ul>
  </div>
  <hr />  
  <div id="divAutoDashboardReminder"> Auto Remainder </div>
</div>
<script type="text/javascript">

function updateDashboardReminder()
{
	$.ajax({
		  url: '<?php echo site_url('complaint/reminder/dashboardReminderList/'); ?>',
		  success: function(data) {
			$('#divAutoDashboardReminder').html(data);
		  }
	});	

	setTimeout("updateDashboardReminder()", 1000*60*5);
}	

updateDashboardReminder();

</script>