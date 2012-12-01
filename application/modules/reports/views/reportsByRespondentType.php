<table width="40%" border="0" cellpadding="5" cellspacing="0" class="rpt-table" style="margin-left:15px;">
    <?php if ($dateFrom != "" or $dateTO != "")
    {
        ?>
        <tr>
            <th width="24%" align="right" bgcolor="#EEEEE6"> Date: </th>
            <th width="27%" class="last"><?php
    if ($dateFrom != "")
    {
        echo $dateFrom;
    }
        ?> &nbsp; <?php if($dateTO != "" && $dateFrom != ""){echo "To";} ?>&nbsp; <?php
            if ($dateTO != "")
            {
                echo $dateTO;
            }
            ?> </th>
        </tr>
<?php } $total = $countFource + $countNonFource; ?> 

</table>
<br>
<?php if($total>0){?>
<table width="98%" border="0" cellpadding="5" cellspacing="0" bordercolor="#F2F2F2" class="rpt-table" align="center">
    <tr bgcolor="#DEE1E7" align="right">
        <th width="19%" align="center" bgcolor="#EEEEE6"><strong>Respondent Type</strong></th>
        <th width="9%" align="center" bgcolor="#EEEEE6"><strong>Total</strong></th>
        <th width="7%" align="center" bgcolor="#EEEEE6" class="last"><strong>Percentage</strong><strong> (%) </strong></th>
    </tr>
<?php
$i = 0;
$fource = 0;
$nonFource = 0;
foreach ($DeciplineForce as $item)
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
 <tr class="<?php echo $alt ?>">
            <td align="left" style="text-transform: capitalize;"><a <?php if($item['total_respondent']>0){?>href="<?php echo site_url('reports/getDetailsByRespondentTypeYes/'.$item['id'].'/'.$dateFrom.'/'.$dateTO);}?>" target="blank"><?php echo $item['varName']; ?></a></td>
            <td align="right"><a <?php if($item['total_respondent']>0){?>href="<?php echo site_url('reports/getDetailsByRespondentTypeYes/'.$item['id'].'/'.$dateFrom.'/'.$dateTO);}?>" target="blank"><?php echo $item['total_respondent']; ?></a></td>
            <td align="right" class="last"><?php echo round($f = (($item['total_respondent'] * 100 / $total)),2); $fource += $f; ?>%</td>
        </tr>
    <?php } ?>  

<?php
$i = 0;
foreach ($NonDeciplineForce as $item)
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
 <tr class="<?php echo $alt ?>">
            <td align="left" style="text-transform: capitalize;"><a <?php if($item['total_respondent']>0){?>href="<?php echo site_url('reports/getDetailsByRespondentTypeNo/'.$item['id'].'/'.$dateFrom.'/'.$dateTO);}?>" target="blank"><?php echo $item['varName']; ?></a></td>
            <td align="right"><a <?php if($item['total_respondent']>0){?>href="<?php echo site_url('reports/getDetailsByRespondentTypeNo/'.$item['id'].'/'.$dateFrom.'/'.$dateTO);}?>" target="blank"><?php echo $item['total_respondent']; ?></a></td>
            <td align="right" class="last"><?php echo round($nf = (($item['total_respondent'] * 100 / $total)),2); $nonFource += $nf ?>%</td>
        </tr>
<?php } ?>  

    <tr bgcolor="#DEE1E7" align="right">
        <td align="right" bgcolor="#EEEEE6"><strong>TOTAL:</strong></td>
        <td align="right" bgcolor="#EEEEE6"><?php echo $total; ?></td>
        <td align="right" bgcolor="#EEEEE6" class="last"><?php echo round(($fource + $nonFource), 2); ?>%</td>
    </tr>
</table>
<?php }?>
<?php if($total <= 0){?>
<div class="information">
	<p> No Such Information</p>
</div>

<?php }?>