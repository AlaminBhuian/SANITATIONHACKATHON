<table width="40%" border="0" cellpadding="5" cellspacing="0" class="rpt-table" style="margin-left:15px;">
  <?php if($dateFrom!="" or $dateTO!=""){?>
    <tr>
    <th width="24%" align="right" bgcolor="#EEEEE6"> Date: </th>
    <th width="27%" class="last"><?php if($dateFrom!=""){ echo $dateFrom;} ?> &nbsp; <?php if($dateTO != "" && $dateFrom != ""){echo "To";} ?>&nbsp; <?php if($dateTO!="") { echo $dateTO;} ?> </th>
  </tr>
  <?php }?> 
  
</table>
<br>
<a href="<?php echo base_url();?>reports/view_chart" >View Chart</a>
<table width="98%" border="0" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="rpt-table" align="center">
  <tr bgcolor="#DEE1E7" align="right">
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>District name</strong></th>
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>Sub District Name</strong></th>
    <th width="9%" align="center" bgcolor="#EEEEE6"><strong>Total</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class="last"><strong>Vaccination</strong></th>
  </tr>
  <?php 
  
  $total =0;
 $m=0;
 $i = 0;
  foreach($placeOfcomplaint as $item){
     
	foreach($placeOfcomplaint2 as $item2){
      ?>
 <tr class="">
     <td align="left" style="text-transform: capitalize;">&nbsp;<?php echo $item['district_name']; ?></td>
     <td align="left" style="text-transform: capitalize;">&nbsp;<?php echo $item['sub_district_name']; ?></td>
     <td align="right"><?php echo $item['total_child']; ?></td>
        <td align="right" class="last"><?php echo $item2['total_vaccination']; ?></td>
  </tr>
      <?php }}?>   
  
  <tr bgcolor="#DEE1E7" align="right">
    <td align="left" bgcolor="#EEEEE6"><strong></strong></td>
    <td align="right" bgcolor="#EEEEE6"><strong></strong></td>
    <td align="right" bgcolor="#EEEEE6">&nbsp;</td>
    <td align="right" bgcolor="#EEEEE6" class="last">&nbsp;</td>
  </tr>
</table>


