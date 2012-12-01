<table width="40%" border="0" cellpadding="5" cellspacing="0" class="rpt-table" style="margin-left:15px;">
  <?php if($dateFrom!="" or $dateTO!=""){?>
    <tr>
    <th width="24%" align="right" bgcolor="#EEEEE6"> Date: </th>
    <th width="27%" class="last"><?php if($dateFrom!=""){ echo $dateFrom;} ?> &nbsp; &nbsp; <?php if($dateTO!="") { echo $dateTO;} ?> </th>
  </tr>
  <?php }?> 
  
</table>
<br>
<a href="<?php echo base_url();?>reports/view_chart" >View Chart</a>
<table width="98%" border="0" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="rpt-table" align="center">
  <tr bgcolor="#DEE1E7" align="right">
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>District</strong></th>
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>Sub District</strong></th>
    <th width="9%" align="center" bgcolor="#EEEEE6"><strong>Total Child</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class="last"><strong>Percentage</strong><strong> (%) </strong></th>
  </tr>
 
 <tr>
     	<td align="left" style="text-transform: capitalize;">Rajshahi</td>
     	<td align="right">Godagari</td>
        <td align="right" class="">165</td>
        <td align="right" class="last">15</td>
  </tr>
  
  <tr>
     	<td align="left" style="text-transform: capitalize;">Rajshahi</td>
     	<td align="right">Bhaga</td>
        <td align="right" class="">165</td>
        <td align="right" class="last">15</td>
  </tr>
  
  <tr>
     	<td align="left" style="text-transform: capitalize;">Rajshahi</td>
     	<td align="right">Baghmara</td>
        <td align="right" class="">165</td>
        <td align="right" class="last">15</td>
  </tr>
  
  <tr>
     	<td align="left" style="text-transform: capitalize;">Rajshahi</td>
     	<td align="right">Mahonpur</td>
        <td align="right" class="">165</td>
        <td align="right" class="last">15</td>
  </tr>
  <tr>
     	<td align="left" style="text-transform: capitalize;">Rajshahi</td>
     	<td align="right">Puthia</td>
        <td align="right" class="">165</td>
        <td align="right" class="last">15</td>
  </tr>
  
  <tr bgcolor="#DEE1E7" align="right">
    <td align="right" bgcolor="#EEEEE6"><strong>TOTAL:</strong></td>
    <td align="right" bgcolor="#EEEEE6">&nbsp;</td>
    <td align="right" bgcolor="#EEEEE6" class="">&nbsp;</td>
    <td align="right" bgcolor="#EEEEE6" class="last">&nbsp;</td>
  </tr>
</table>
