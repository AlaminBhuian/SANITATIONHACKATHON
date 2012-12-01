<style type="text/css">

    .link-color a{
        color: black;
    }
</style>

<table width="40%" border="0" cellpadding="5" cellspacing="0" class="rpt-table" style="margin-left:15px;">
    <?php if ($dateFrom != "" or $dateTO != "")
    {
        ?>
        <tr>
            <th width="24%" align="right" bgcolor="#EEEEE6"> Date: </th>
            <th width="27%" class="last"><?php
    if ($dateFrom != "")
    {
        echo date_time_format($dateFrom, 'dmy', 'ymd');
    }
        ?> &nbsp;<?php if ($dateTO != "" && $dateFrom != "")
            {
                echo "To";
            } ?> &nbsp; <?php
            if ($dateTO != "")
            {
                echo date_time_format($dateTO, 'dmy', 'ymd');
            }
            ?> </th>
        </tr>
<?php } ?>  
</table>
<br>

<table width="96%" border="0" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="rpt-table" align="center">
    <tr bgcolor="#DEE1E7" align="right">
        <th width="" align="center" bgcolor="#EEEEE6"><strong>#</strong></th>        
        <th width="" align="center" bgcolor="#EEEEE6"><strong>Tracking Number</strong></th>
        <th width="" align="center" bgcolor="#EEEEE6"><strong>Complaint Name</strong></th>
        <th width="" align="center" bgcolor="#EEEEE6"><strong>Operate By</strong></th>
        <th width="" align="center" bgcolor="#EEEEE6"><strong>Complaint Received Date</strong></th>
        <th width="" align="center" bgcolor="#EEEEE6"><strong>Victim's Name</strong></th>
        <th width="" align="center" bgcolor="#EEEEE6"><strong>Victim's Age</strong></th>
        <th width="" align="center" bgcolor="#EEEEE6"><strong>Victim's Sex</strong></th>
        <th width="" align="center" bgcolor="#EEEEE6" class="last"><strong>Present Status</strong></th>


    </tr>
    <?php
    $i = 0;
    foreach ($Details as $item)
    {
        if (($i % 2) == 0)
        {
            $alt = "odd";
        } else
        {
            $alt = "even";
        }
        $i++;
        ?>
    <tr class="<?php echo $alt ?>" style="text-transform: capitalize;">
            <td align="right">&nbsp;<?php echo $i; ?></td>            
            <td align="middle">&nbsp;<?php echo $item['traking_number']; ?></td>
            <td align="left"><?php echo $item['complaint_name']; ?>&nbsp;</td>
            <td align="left"><?php echo $item['varFullName']; ?>&nbsp;</td>
            <td align="middle">&nbsp;<?php echo date("d-M-Y h:i A", strtotime($item['complaint_received_date'])); ?></td>
            <td align="left"><?php echo $item['victims_name']; ?>&nbsp;</td>
            <td align="right">&nbsp;<?php echo $item['victims_age']; ?></td>
            <td align="middle"><?php if($item['victims_sex']!='StillNotKnown'){ echo $item['victims_sex'];}else{ echo 'Still Not Known';}; ?>&nbsp;</td>
            <td align="left" class="last"><?php echo $item['present_status']; ?>&nbsp;</td>
        </tr>
<?php } ?> 
</table>
