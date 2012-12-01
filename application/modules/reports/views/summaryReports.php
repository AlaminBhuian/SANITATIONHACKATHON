<table width="70%" border="0" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="rpt-table" align="center">
  <tr bgcolor="EEEEE6">
    <th width="64%">&nbsp;</th>
    <th class="last" width="36%">Total</th>
  </tr>
  <tr class="odd">
    <td>Total Complaint </td>
    <td class="last"><div align="right"><?php echo $getTotal; ?></div></td>
  </tr>
  <tr class="even">
    <td>Received Today </td>
    <td class="last"><div align="right"><?php echo $today; ?></div></td>
  </tr>
  <tr class="odd">
    <td>Long Pending(more then 3 months) </td>
    <td class="last">
      <div align="right"><?php echo $threeMonth; ?>    </div></td>
  </tr>
  <tr class="even">
    <td>Long Pending(more then 6 months)</td>
    <td class="last"><div align="right"><?php echo $sixMonth; ?></div></td>
  </tr>
  <tr class="odd">
    <td>Long Pending(more then 12 months)</td>
    <td class="last"><div align="right"><?php echo $twelveMonth; ?></div></td>
  </tr>
  <tr class="even">
    <td>Response Pending Ministry of Homes </td>
    <td class="last"><div align="right"><?php echo $response_ministryhomes; ?></div></td>
  </tr>
  <tr class="odd">
    <td>Complaint Resolved </td>
    <td class="last"><div align="right"><?php echo $resolved; ?></div></td>
  </tr>
  <tr class="even">
    <td>Complaint Referred to NGO </td>
    <td class="last"><div align="right"><?php echo $referdngo; ?></div></td>
  </tr>
  <tr class="odd">
    <td>Complaints Received to NGO </td>
    <td class="last"><div align="right"><?php echo $receivedToNgo; ?></div></td>
  </tr>
</table>
