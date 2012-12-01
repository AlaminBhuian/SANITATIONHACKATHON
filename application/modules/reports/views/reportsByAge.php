<table width="40%" border="0" cellpadding="5" cellspacing="0" class="rpt-table" style="margin-left:15px;">
  <?php if($dateFrom!="" or $dateTO!=""){?>
    <tr>
    <th width="24%" align="right" bgcolor="#EEEEE6"> Date: </th>
    <th width="27%" class="last"><?php if($dateFrom!=""){ echo $dateFrom;} ?> &nbsp;<?php if($dateTO != "" && $dateFrom != ""){echo "To";} ?> &nbsp; <?php if($dateTO!="") { echo $dateTO;} ?> </th>
  </tr>
  <?php }?>
  
  
  <?php if($ageTotal == 0){
      $ageTotal = 1;
  }
?>
</table>
<br>
<a href="<?php echo base_url();?>reports/view_chart" >View Chart</a>
<table width="98%" border="0" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="rpt-table" align="center">
  <tr bgcolor="#DEE1E7" align="right">
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>District</strong></th>
    <th width="9%" align="center" bgcolor="#EEEEE6"><strong>Sub District</strong></th>
    <th width="9%" align="center" bgcolor="#EEEEE6"><strong>Total Childt</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class=""><strong>Total Disabled</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class="last"><strong>Percentage</strong><strong> (%) </strong></th>
  </tr>
  <tr class="odd">
      <td align="right">Narail</td>
        <td align="right">Lohagora</td>
        <td align="right" class="">16</td>
        <td align="right" class="">14</td>
        <td align="right" class="last">95%</td>
  </tr>
  <tr class="odd">
      <td align="right">Narail</td>
        <td align="right">Narail Sador</td>
        <td align="right" class="">25</td>
        <td align="right" class="">14</td>
        <td align="right" class="last">60%</td>
  </tr>
  <tr class="odd">
      <td align="right">Narail</td>
        <td align="right">Kalia</td>
        <td align="right" class="">16</td>
        <td align="right" class="">14</td>
        <td align="right" class="last">95%</td>
  </tr>
  <tr class="odd">
      <td align="right">Narail</td>
        <td align="right">Lohagora</td>
        <td align="right" class="">16</td>
        <td align="right" class="">14</td>
        <td align="right" class="last">95%</td>
  </tr>
  <tr class="odd">
      <td align="right">Narail</td>
        <td align="right">Lohagora</td>
        <td align="right" class="">16</td>
        <td align="right" class="">14</td>
        <td align="right" class="last">95%</td>
  </tr>
  <tr bgcolor="#DEE1E7" align="right">
    <td align="right" bgcolor="#EEEEE6"><strong>TOTAL:</strong></td>
    <td align="right" bgcolor="#EEEEE6">&nbsp;</td>
    <td align="right" bgcolor="#EEEEE6" class="">&nbsp;</td>
    <td align="right" bgcolor="#EEEEE6" class="">&nbsp;</td>
    <td align="right" bgcolor="#EEEEE6" class="last">&nbsp;</td>
  </tr>
</table>




