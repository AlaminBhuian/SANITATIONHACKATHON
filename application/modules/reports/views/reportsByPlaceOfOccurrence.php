 <table width="40%" border="0" cellpadding="5" cellspacing="0" class="rpt-table" style="margin-left:15px;">
  <?php if($dateFrom!="" or $dateTO!=""){?>
    <tr>
    <th width="24%" align="right" bgcolor="#EEEEE6"> Date: </th>
    <th width="27%" class="last"><?php if($dateFrom!=""){ echo $dateFrom;} ?> &nbsp; <?php if($dateTO != "" && $dateFrom != ""){echo "To";} ?>&nbsp; <?php if($dateTO!="") { echo $dateTO;} ?> </th>
  </tr>
  <?php }?> 
  
</table>
<br>
<?php if($totaldata>0){?>
<table width="98%" border="0" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="rpt-table" align="center">
  <tr bgcolor="#DEE1E7" align="right">
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>District</strong></th>
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>Upazilla/Thana</strong></th>
    <th width="9%" align="center" bgcolor="#EEEEE6"><strong>Total</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class="last"><strong>Percentage</strong><strong> (%) </strong></th>
  </tr>
  <?php 
  
  $total =0;
 $m=0;
 $i=0;
  foreach($placeOfincident as $item){
      if (($i % 2) == 0)
    {
        $alt = "odd";
    } else
    {
        $alt = "even";
    }
    $i++;
      ?>
 <tr class="<?php echo $alt ?>">
     <td align="left" style="text-transform: capitalize;">&nbsp;<?php echo $item['district_name']; ?></td>
     <td align="left" style="text-transform: capitalize;">&nbsp;<a <?php if($item['total_placeOf_occurrence']>0){?>href="<?php echo site_url('reports/getDetailsByPlaceOfOccurrence/'.$item['sub_district_id'].'/'.$dateFrom.'/'.$dateTO);}?>" target="blank"><?php echo $item['sub_district_name']; ?></a></td>
     <td align="right">&nbsp;<a <?php if($item['total_placeOf_occurrence']>0){?>href="<?php echo site_url('reports/getDetailsByPlaceOfOccurrence/'.$item['sub_district_id'].'/'.$dateFrom.'/'.$dateTO);}?>" target="blank"><?php echo $item['total_placeOf_occurrence']; $total += $item['total_placeOf_occurrence']; ?></a></td>
        <td align="right" class="last">&nbsp;<?php echo round($k =(($item['total_placeOf_occurrence']*100)/$totaldata),2);$m += $k; ?>%</td>
  </tr>
      <?php }?>   
  
  <tr bgcolor="#DEE1E7" align="right">
      <td align="left" bgcolor="#EEEEE6"><strong>&nbsp;</strong></td>
    <td align="right" bgcolor="#EEEEE6"><strong>&nbsp;TOTAL:</strong></td>
    <td align="right" bgcolor="#EEEEE6">&nbsp;<?php echo $total; ?></td>
    <td align="right" bgcolor="#EEEEE6" class="last">&nbsp;<?php echo round($m , 2);?>%</td>
  </tr>
</table>
<?php }?>

<?php if($totaldata <= 0){?>
<div class="information">
	<p> No Such Information</p>
</div>

<?php }?>
