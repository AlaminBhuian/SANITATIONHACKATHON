<div class="checklist">
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<label><strong>Select Reasons</strong></label>
<?php foreach($statusReasons as $item): ?>
	 <tr><td style="vertical-align:middle;"><label style="width:auto;vertical-align:sub"><input name="chkStatusReasons[]" type="checkbox" value="<?php echo $item['reason_remarks_id']; ?>" /><?php echo $item['name']; ?></label>
	<?php if($item['is_value'] == 'yes') { ?>
	 <input name="txtReasonValue_<?php echo $item['reason_remarks_id']; ?>" type="text" class="sf" value="" maxlength="1000" />
	 <?php } ?>
	 </td></tr>
<?php endforeach; ?>
</table>
</div>