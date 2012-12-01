<fieldset>
<legend>Complaint Process History</legend>
<table width="100%" cellspacing="0" class="broom_table" summary="table">
  <thead>
    <tr>
      <th width="62" height="26" scope="col">Remarks</th>
      <th width="180" scope="col">Present Status </th>
      <th width="165" scope="col">Previous Status </th>
      <th width="166" scope="col">Present Desk </th>
      <th width="152" scope="col">Previous Desk </th>
      <th width="296" scope="col">Responsible Person </th>
      <th width="175" scope="col">Last Process Date </th>
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
      <td align="center"><img src="<?php echo site_url('assets/images/icons/balloon.png');?>" title="<strong>Remark / Note:<br /></strong><?php echo nl2br($item['remarks']); ?><br /><br /> <strong>By: <?php echo $item['varFullName']; ?><br /> Action Date: <?php echo date("d-M-Y H:i A", strtotime($item['lastUDT'])); ?></strong>" class="tooltip" /></td>
      <td><?php echo $item['present_status']; ?></td>
      <td><?php echo $item['previous_desk']; ?></td>
      <td><?php echo $item['present_desk']; ?></td>
      <td><?php echo $item['previous_desk']; ?></td>
      <td><?php echo $item['varFullName']; ?> (<?php echo $item['varDesignation']; ?>)</td>
      <td><?php echo date("d-M-Y h:i A", strtotime($item['lastUDT'])); ?> </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<!--/end .pagination-->
</fieldset>
<script type="text/javascript">
	$(".tooltip").easyTooltip();
</script>
