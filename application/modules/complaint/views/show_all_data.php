
<style type="text/css" >
.common_reservations{
    font-family:arial, verdana;
    text-align:center;
}
.common_reservations table{
    
    width:100%;
      text-align:center;
}

.common_reservations table th{
    padding:10px;
    background-color:#D1D6CC;
	  text-align:center;
}
.common_reservations table td{
    padding:10px 5px;
    text-transform:capitalize;
  text-align:center;
}
.common_reservations table tr:nth-child(odd){
    background: #f1f1f1;

}
.common_reservations table tr:nth-child(even){
    background-color:#F7F7F7;
}

</style>
<div class="common_reservations">
<table width="98%" border="0" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="common_reservations" align="center">
  <tr bgcolor="#DEE1E7" align="right">
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>Name</strong></th>    
    <th width="9%" align="center" bgcolor="#EEEEE6"><strong>Father Name</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class=""><strong>Mother Name</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class="last"><strong>Date of Birth</strong></th>
    
    <th width="7%" align="center" bgcolor="#EEEEE6" class=""><strong>Address</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class="last"><strong>Survay Date</strong></th>
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>Polio Affected</strong></th>    
    <th width="9%" align="center" bgcolor="#EEEEE6"><strong>Disabled</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class=""><strong>Literacy</strong></th>
    <th width="7%" align="center" bgcolor="#EEEEE6" class="last"><strong>Illeteracy Reason</strong></th>
    <th width="19%" align="center" bgcolor="#EEEEE6"><strong>Sex</strong></th>    
  </tr>
  <?php 
  
  foreach($complaintInfo as $item){ ?>
  
  
 <tr class="odd">
     <td align="left" style="text-transform: capitalize;"><?php echo $item['name'];?></td> 
     <td align="left" style="text-transform: capitalize;"><?php echo $item['father_name'];?></td>
     <td align="left" style="text-transform: capitalize;"><?php echo $item['mother_name'];?></td>
     <td align="left" style="text-transform: capitalize;"><?php echo $item['date_of_birth'];?></td>
     
     <td align="left" style="text-transform: capitalize;"><?php echo $item['address'];?></td>
     <td align="left" style="text-transform: capitalize;"><?php echo $item['survay_date'];?></td>
     <td align="left" style="text-transform: capitalize;"><?php echo $item['is_polio'];?></td>
     <td align="left" style="text-transform: capitalize;"><?php echo $item['is_disable'];?></td>
     <td align="left" style="text-transform: capitalize;"><?php echo $item['literacy'];?></td>
     <td align="left" style="text-transform: capitalize;"><?php echo $item['literacy_reason'];?></td>
     <td align="left" style="text-transform: capitalize;"><?php echo $item['sex'];?></td>
  
     
  </tr>
  <?php } ?>
</table>
</div>
