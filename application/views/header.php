<!DOCTYPE html>
<html>
<head>
<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
 <?php if($pageTitle) echo "$pageTitle | "?>
Sanitation Hackathon 2012</title>
<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
<link type="text/css" href="assets/css/layout.css" rel="stylesheet" />
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.metadata.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.validate.js'); ?>"></script>
<script type="text/javascript" src="assets/js/easyTooltip.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>
</head>
<body>
<!-- Container -->
<div id="container">
<div id="header">
  <!-- Top -->
  <div id="top">
    <!-- Logo -->
    <div class="logo"> <a href="<?php echo base_url(); ?>complaint/dashboard" class="tooltip"><img height="60" width="550" src="assets/assets/servear.jpg" alt="Sanitation Hackathon 2012" /></a></div>
    <!-- End of Logo -->
    <!-- Meta information -->
    <div class="meta">
      <p>Welcome, <?php echo $this->session->userdata('sess_nhrc_user_name'); ?>!</p>
      <ul>
        <li><a href="<?php echo site_url('users/signout');?>" class="tooltip"><span class="ui-icon ui-icon-power"></span>Logout</a></li>
        <li><a href="<?php echo site_url('users/account/');?>" title="Update your account and change password" class="tooltip"><span class="ui-icon ui-icon-person"></span>My account</a></li>
      </ul>
    </div>
    <!-- End of Meta information -->
  </div>
  <!-- End of Top-->
  <!-- The navigation bar -->
  <div id="navbar">
    <ul class="nav">
      <li><a href="<?php echo site_url('complaint/dashboard');?>">Dashboard</a></li>
      <?php 
		 if(modules::run('auth/havePermission', 'SETTINGS')) { 
		?>
      <li><a href="<?php echo site_url('admin/settings');?>">Settings</a></li>
      
      <?php } 
		 if(modules::run('auth/havePermission', 'REPORT')) { 
		?>
      <li> <a href="<?php echo site_url('reports');?>">Reports</a></li>
      <?php } ?>
    </ul>
  </div>
  <!-- End of navigation bar" -->
  <!-- Search bar -->
  <div id="search">
    <form action="<?php echo site_url('complaint/find/searchTracking/'); ?>" method="post" name="frmSearchTracking" target="_blank" id="frmSearchTracking">
      <p>
        <input type="submit" value="" class="but" />
        <input name="txtTrackingNo" type="text" id="txtTrackingNo" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;" value="Search Using Tracking No." maxlength="30" />
      </p>
    </form>
  </div>
  <!-- End of Search bar -->
</div>
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.form.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){	 
		var options = {
			type: 'POST',
			async: false,			
			beforeSubmit: function() {},
			success: function(data) {
				var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
				if(numberRegex.test(data)) {
				   window.open('<?php echo site_url('complaint/complaintentry/'); ?>/' + data);
				}
				else
				{
					alert('No Such Complaint Found. Please Provide Correct Tracking No.');
				}
			}
		};
		
		//Validation
		jQuery("#frmSearchTracking").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		});
	});		
</script>
