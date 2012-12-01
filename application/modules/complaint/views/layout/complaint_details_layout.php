<html>
<head>

<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php if($pageTitle) echo "$pageTitle | "?>
NHRC : Complaint Management System</title>
<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
<link href="<?php echo site_url('assets/css/print.css'); ?>" rel="stylesheet" type="text/css">

</head>
<body>
<table align="center" width="100%" height="52" border="0" cellpadding="5" cellspacing="0">
  <tr align="left">
    <td width="52%" align="center"><div align="center">
      <h2 style="font-size:16px">Complaint Details
    </h2>
    </div></td>
    <td width="5%" align="right" valign="top"><img src="assets/images/login/nhrc-logo.png" alt="nhrc"></td>
    <td width="43%">
	<h3 style="font-size:14px;">National Human Rights Commission, Bangladesh<br>
      Complaint Management System</h3> 
	  </td>
  </tr>
</table>
<hr align="center" color="#EFEFEF" width="100%">
<?php echo $content_for_layout; ?>
</body>
</html>
