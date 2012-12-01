<html>
<head>
<base href="<?php echo base_url(); ?>" />
<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $complaintInfo->complaint_name; ?> - Complaint Detail's</title>
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
	font-size:12px;
}
.bangla {
	font-size:14px;
	font-family:SolaimanLipi, SutonnyOMJ, TonnyBanglaOMJ, Vrinda;
}

p {
	font:12px Verdana, Arial, Helvetica, sans-serif;
	line-height:155%;
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
		<img src="<?php echo site_url('assets/images/login/nhrc-logo.png'); ?>" alt="NHRC" align="left">	
		<h3>
			National Human Rights Commission, Bangladesh<br>
			Complaint Management System<br>
			Complaint Information
		</h3>
		</td>
  </tr>
  <tr>
    <td colspan="2"></td>
    </tr>
  
    
    
    <tr>
        <td width="26%"> 
            <label><span class="bangla">অভিযোগকারীর নাম</span> 
            (Complainant Name)</label>      </td>
        <td width="74%">
            <?php echo $complaintInfo->complaint_name; ?>    </td> 
    </tr>
    <tr>
        <td width="26%">
            <label><span class="bangla">লিঙ্গ </span>(Sex)</label>      </td>
         <td width="74%">
            <label><?php echo $complaintInfo->sex; ?></label>      </td>
    </tr>      
         
    
    <tr>
        <td width="26%">
            <label><span class="bangla">ঠিকানা </span> (Address)</label>      </td>
         <td width="74%">
            <label><?php echo nl2br($complaintInfo->present_address); ?></label>      </td>   
    </tr>     
          
    <tr>
        <td width="26%">
            <label><span class="bangla">ফোন </span>(Phone/Mobile)</label>      </td>
        <td width="74%">
          <label><?php echo $complaintInfo->present_phone; ?></label>      </td>    
    </tr>
    
    <tr>
        <td width="26%">
            <label><span class="bangla">ফ্যাক্স </span>(FAX)</label>      </td>
        <td width="74%">
            <label><?php echo $complaintInfo->present_fax; ?></label>      </td>    
    </tr>
    <tr>
        <td width="26%">
            <label><span class="bangla">ইমেইল </span>(E-mail)</label>      </td>
        <td width="74%">
            <label><?php echo $complaintInfo->present_email; ?></label>      </td>   
    </tr>
    <tr>
       <td width="26%">
            <label><span class="bangla"> ঘটনার সংক্ষিপ্ত বর্ণনা </span><br>
            (Summarized Description of the Incident)</label>      </td>
       <td width="74%">
            <label><?php echo nl2br($complaintInfo->description); ?></label>      </td>
    </tr>
    
    <tr>
        <td></td>
        <td></td>
    </tr>
    
  <tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <td width="50%"><table width="100%" border="0" cellpadding="0" cellspacing="10">
          <tr>
            <td>Signature: __________________________</td>
          </tr>
          <tr>
            <td>Full Name: __________________________</td>
          </tr>
          <tr>
            <td>Date: ______________________________</td>
          </tr>
        </table></td>
        <td align="center" valign="bottom"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>(Stamp of NHRC)</p></td>
      </tr>
    </table></td>
    </tr>
</table>

</body>
</html>

