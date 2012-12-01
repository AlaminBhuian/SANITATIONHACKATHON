<html>
<head>
<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php if($reportTitle) echo "$reportTitle | "?>
Survey Reports</title>
<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
<link href="<?php echo site_url('assets/css/print.css'); ?>" rel="stylesheet" type="text/css">
</head>
<body>
<table align="center" width="100%" height="52" border="0" cellpadding="5" cellspacing="0">
  <tr align="left">
    <td width="52%"><div align="center">
      <h2 style="font-size:16px"><?php echo $reportTitle; ?>
    </h2>
    </div></td>
    <td width="5%" align="right" valign="top"></td>
    <td width="43%">
	<h3 style="font-size:14px;">Hackathon</h3> 
	  </td>
  </tr>
</table>
<hr align="center" color="#EFEFEF" width="100%">
<?php echo $content_for_layout; ?>
</body>
</html>
