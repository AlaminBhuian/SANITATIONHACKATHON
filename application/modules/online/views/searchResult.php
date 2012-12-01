
<script type="text/javascript">
    $("#selCompalintStatus").change(function () {
		  $.get('<?php echo site_url('complaint/getReasonsList/'); ?>/' + $(this).val(), function(data) {
			  $('#reasons').html(data);
		  });
      });
	  
	$(document).ready(function() {		
		var options = {
			type: 'POST',
			async: false,
			target: '#showHistory', 
			beforeSubmit: function() {},
			success: function(data) {}
		};	
		
		jQuery("#frmComplaintProcess").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		});                
  	});
  
</script>
<style type="text/css">
    .common_table{
    -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
	border-collapse: collapse;
	border-color: #CCCCCC -moz-use-text-color #CCCCCC #CCCCCC;
	border-style: solid none solid solid;
	border-width: 1px medium 1px 1px;
	font-size: 11px;
	margin: 0;
	padding-left: 15px;    
    }
    
    .common_table td,th{
        padding-left: 10px
    }
    
    
</style>
<fieldset>
<legend>Complaint Information</legend>
<table width="100%" border="" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="common_table" align="center">
  <tr bgcolor="#DEE1E7" align="right" style="height:30px;">        
      <th hight="" align="left" bgcolor="#EEEEE6"><span class="bangla">নাম </span>
(Name)</th>
        
      <td width="66%" align="left" style="background-color: #ffffff;"><?php echo $complaintInfo[0]['name']; ?></td>
  </tr>  
  <tr style="height:30px; width: 90px;">
    <th hight="" align="left" bgcolor="#EEEEE6"><span class="bangla">লিঙ্গ </span>
(Sex)</th>
  
     <td align="left"><?php echo $complaintInfo[0]['sex']; ?></td>
  </tr>  
  <tr style="height:30px; width: 90px;">
    <th hight="" align="left" bgcolor="#EEEEE6"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span>
(Village/Moholla/Road No.)</th>   
  
     <td align="left"><?php echo $complaintInfo[0]['address']; ?></td>
  </tr>    
    <tr style="height:30px; width: 90px;">
    <th hight="" align="left" bgcolor="#EEEEE6" ><span class="bangla"> জেলা </span>
(District)</th>
  
     <td align="left"><?php echo $complaintInfo[0]['district']; ?></td>
  </tr>   
    <tr style="height:30px; width: 90px;">
    <th hight="" align="left" bgcolor="#EEEEE6"><span class="bangla">থানা </span>
(Sub-district)</th>
  
     <td align="left"><?php echo $complaintInfo[0]['sub_district']; ?></td>
  </tr>
    
    <tr style="height:30px; width: 90px;">
    <th width="34%" align="left" bgcolor="#EEEEE6"><span class="bangla">ফোন </span>
(Phone/Mobile)</th>
    
     <td align="left"><?php echo $complaintInfo[0]['phone']; ?></td>
  </tr>
    <tr style="height:30px; width: 90px;">
    <th width="34%" align="left" bgcolor="#EEEEE6" class="last"><span class="bangla">অভিযোগ গ্রহনের তারিখ </span>/Submit Date</th>
  
     <td align="left" class="last"><?php echo date("d-M-Y h:i A", strtotime($complaintInfo[0]['date'])); ?></td>
  </tr>
         
</table>

</fieldset>
	<fieldset>
<legend>Complaint Process History</legend>
<table width="100%" cellspacing="0" class="broom_table" summary="table">
  <thead>
    <tr>
      
      <th width="180" scope="col">Present Status </th>
      <th width="165" scope="col">Previous Status </th>
      <th width="166" scope="col">Present Desk </th>
      <th width="152" scope="col">Previous Desk </th>
      <th width="296" scope="col">Deal By</th>
      <th width="175" scope="col">Last Process Date </th>
      <th width="62" height="26" scope="col">Remarks</th>
    </tr>
  </thead>
  <tbody>
	<?php 
		$i=0;
		foreach($complaintHistory as $item):
		if(($i % 2) == 0) { $alt = "odd"; } else { $alt = "even"; }
		$i++;
	?>
    <tr class="<?php echo $alt;?>" style="height:30px">      
      <td><?php echo $item['present_status']; ?></td>
      <td><?php echo $item['previous_desk']; ?></td>
      <td><?php echo $item['present_desk']; ?></td>
      <td><?php echo $item['previous_desk']; ?></td>
      <td><?php echo $item['varFullName']; ?>(<?php echo $item['varDesignation']; ?>)</td>
      <td><?php echo date("d-M-Y h:i A", strtotime($item['lastUDT'])); ?> </td>
      <td align="left"><?php echo nl2br($item['remarks']); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<!--/end .pagination-->
</fieldset>
<script type="text/javascript">
	$(".tooltip").easyTooltip();
</script>
