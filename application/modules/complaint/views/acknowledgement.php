<html>
<head>
<base href="<?php echo base_url(); ?>" />
<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $complaintInfo->complaint_name; ?> - Complaint Acknowledgement</title>
<style type="text/css">
body {
    background: none repeat scroll 0 0 #FFFFFF;
    color: #303030;
    font: 12px Verdana,Tahoma,Arial,sans-serif;
    margin: 0;
    padding: 0;
}
table {
    border-collapse: collapse;
    margin: 10px;
    padding: 0;
    width: 97%;
}
table td {
    padding: 6px;
	vertical-align:top;
	width:25%
}

p {
	font:13px Verdana, Arial, Helvetica, sans-serif;
	line-height:160%;
}

h2 {
	font-size:18px;
}

</style>
<script type="text/javascript">
	window.print();
</script>
</head>
<body>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" style="border:1px dashed #666666;">   
  <tr>
    <td colspan="2" align="center">
		<img src="<?php echo site_url('assets/images/login/nhrc-logo.png'); ?>" alt="NHRC">	</td>
  </tr>
  <tr>
    <td colspan="2"><h2 align="center">Acknowledgement of Receipt</h2></td>
    </tr>
  <tr>
    <td colspan="2"><p class="style1">&nbsp;</p>
	<p>Thank you for visiting NHRC. You have completed 1st step of complaint.</p>
	<p>
		Your <strong>Tracking No: <?php echo $complaintInfo->traking_number; ?></strong><br>
		(<strong><?php echo $complaintInfo->complaint_name; ?></strong>) Dated <strong><?php echo date("d-m-Y H:i A", strtotime($complaintInfo->complaint_received_date)); ?></strong><br>
		Please visit  <strong>http://www.nhrc.org.bd/compaint</strong> for track your complaint.
	</p>	
    <p class="style1">&nbsp;</p></td>
    </tr>
  <tr>
    <td width="45%"><table width="100%" border="0" cellpadding="0" cellspacing="10">
      <tr>
        <td>Signature: __________________________</td>
      </tr>
      <tr>
        <td>Full Name: <?php echo $this->session->userdata('sess_nhrc_user_name'); ?></td>
      </tr>
      <tr>
        <td>Designation: <?php echo $this->session->userdata('sess_nhrc_user_desg'); ?></td>
      </tr>
    </table>
</td>
    <td width="55%" align="center" valign="bottom"><p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>(Stamp of NHRC)</p></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
