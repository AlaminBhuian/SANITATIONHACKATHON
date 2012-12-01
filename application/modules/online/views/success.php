<div id="bgwrap">
  <div id="full-content">
    <div id="full-main">
      <h1>Complaint Submission &amp; Acknowledgement</h1>
      <div class="pad20">
        <?php if ($this->session->flashdata('message')) : ?>
        <div class="msg-success"><?php echo $this->session->flashdata('message'); ?> </div>
        <?php endif; 
			if(is_object($complaintInfo)):	
		?>
        <div class="msg-success"> Complaint Submitted Successfully <br />
          <br />
          <ul>
            <li><span class="bangla">অভীযোগকারী নাম </span>(Complainant Name): <strong><?php echo $complaintInfo->complaint_name; ?></strong></li>
            <li><span class="bangla">ফোন </span>(Phone/Mobile): <strong><?php echo $complaintInfo->present_phone; ?></strong></li>
            <li>Tracking Number: <strong><?php echo $complaintInfo->traking_number; ?></strong></li>
          </ul>
        </div>
        <?php endif; ?>
        <div >
          <hr/>
          <ul class="dash">
            <li> <a href="<?php echo site_url('complaint/newcomplaint');?>" title="Add new complaint" class="tooltip"> <img src="assets/assets/icons/8_48x48.png" alt="" /> <span>New complaint</span> </a> </li>
            <li> <a href="<?php echo site_url('complaint/acknowledgement');?>/<?php echo $complaintInfo->complaint_id; ?>" title="Print Acknowledgement" class="tooltip" target="_blank"><img src="assets/assets/icons/9_48x48.png" alt="" /> <span>Acknowledgement</span></a> </li>
          </ul>
          <hr />
        </div>
      </div>
    </div>
  </div>
  <hr />
</div>