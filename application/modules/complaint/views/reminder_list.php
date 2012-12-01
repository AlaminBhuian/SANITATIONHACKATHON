<?php 
if(count($reminderList) > 0) {
	foreach($reminderList as $item): ?>
	<div class="message alert close">
		<h2>Alert!</h2>
		<p><?php echo nl2br($item['varRemindText']); ?></p><br />

		<p>
			Set by: <strong><?php echo $item['varFullName']." (". $item['varDesignation'] .") - ".$item['desk_name']; ?></strong> for <strong><?php echo strtoupper($item['enmRemindTo']); ?></strong><br />
			Alert Time: <strong><?php echo date("d-M-Y h:i A", strtotime($item['dtStartRemindDT'])); ?></strong>
			<?php if($item['dtEndRemindDT']) { ?>
				- End Time: <strong><?php echo date("d-M-Y h:i A", strtotime($item['dtEndRemindDT'])); ?></strong>                           
			<?php } ?>
                                <?php      if($item['intUserID'] == $this->session->userdata('sess_nhrc_user_id')) { ?>
					- <a class="remReminder" rel="<?php echo $item['id'];?>" href="#rem">[x] Remove Alert</a> <?php } ?>
			
		<?php 
			if(isset($complaint_id)) {
				if(modules::run('auth/haveEditPermission', $complaint_id)) { ?>
				<?php if($item['intUserID'] == $this->session->userdata('sess_nhrc_user_id')) { ?>
					- <a class="remReminder" rel="<?php echo $item['id'];?>" href="#rem">[x] Remove Alert</a>
		<?php }}} ?>	
		</p>
	</div>
<?php endforeach; } ?>

<script type="text/javascript">
    $(document).ready(function() {		
 		
		$("a.remReminder").click(function() { 
			if(confirm('Are you sure you want to remove this reminder.'))
			{
				$(this).closest('div').fadeTo(400, 0, function () { 
					$(this).slideUp(400);
				});
				
				var id = $(this).attr("rel");
				$.get("<?php echo site_url('complaint/reminder/removeReminder/'); ?>/"+id);
				
				return false;
			} else {
				return false;
			}
		});


   });
</script>
