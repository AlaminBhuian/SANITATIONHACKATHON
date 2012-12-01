<table width="40%" border="0" cellpadding="5" cellspacing="0" class="rpt-table" style="margin-left:15px;">
  <?php if($dateFrom!="" or $dateTO!=""){?>
    <tr>
    <th width="24%" align="right" bgcolor="#EEEEE6"> Date: </th>
    <th width="27%" class="last"><?php if($dateFrom!=""){ echo $dateFrom;} ?> &nbsp; <?php if($dateTO != "" && $dateFrom != ""){echo "To";} ?>&nbsp; <?php if($dateTO!="") { echo $dateTO;} ?> </th>
  </tr> 
</table>
<br>
<?php } if ($getAllEthnicity> 0){?>
<table width="98%" border="0" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="rpt-table" align="center">
  <tr bgcolor="#DEE1E7" align="right">
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>Ethnicity</strong></th>
    <th width="9%" align="center" bgcolor="#EEEEE6"><strong>Total</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class="last"><strong>Percentage</strong><strong> (%) </strong></th>
  </tr>
  
  <tr class="odd">
     <td align="left" style="text-transform: capitalize;"><a <?php $community= 'yes'; if($ethnicityYes>0){?>href="<?php echo site_url('reports/getDetailsByEthnicity/'.$community.'/'.$dateFrom.'/'.$dateTO);}?>" target="blank">Indigenous</a></td>
        <td align="right"><a <?php $community= 'yes'; if($ethnicityYes>0){?>href="<?php echo site_url('reports/getDetailsByEthnicity/'.$community.'/'.$dateFrom.'/'.$dateTO);}?>" target="blank"><?php echo $ethnicityYes; ?></td>
        <td align="right" class="last"><?php echo round($yes = (($ethnicityYes*100)/$getAllEthnicity),2); ?>%</td>
  </tr>
  
  <tr class="even">
      <td align="left" style="text-transform: capitalize;"><a <?php $community= 'no'; if($ethnicityNo>0){?>href="<?php echo site_url('reports/getDetailsByEthnicity/'.$community.'/'.$dateFrom.'/'.$dateTO);}?>" target="blank">Others</a></td>
     <td align="right"><a <?php $community= 'no'; if($ethnicityNo>0){?>href="<?php echo site_url('reports/getDetailsByEthnicity/'.$community.'/'.$dateFrom.'/'.$dateTO);}?>" target="blank"><?php echo $ethnicityNo; ?></a></td>
        <td align="right" class="last"><?php echo round($no = (($ethnicityNo*100)/$getAllEthnicity),2); ?>%</td>
  </tr>
        
  
  <tr bgcolor="#DEE1E7" align="right">
    <td align="Right" bgcolor="#EEEEE6"><strong>TOTAL:</strong></td>
    <td align="right" bgcolor="#EEEEE6"><?php echo $ethnicityYes + $ethnicityNo; ?></td>
    <td align="right" bgcolor="#EEEEE6" class="last"><?php echo $yes + $no;?>%</td>
  </tr>
</table>
<?php }?>

<?php if($getAllEthnicity <= 0){?>
<div class="information">
	<p> No Such Information</p>
</div>

<?php }?>