<?php if(count($indListData) > 0){ ?>
<fieldset>
        <legend>Complaints List</legend>     
          <table cellspacing="0" summary="table" class="broom_table">
            <thead>
              <tr>
                <th width="93" scope="col">Tracking # </th>
                <th width="121" scope="col">Received Date </th>
                <th width="187" scope="col">Complainant Name </th>
                <th width="125" scope="col">Previous Status </th>
                <th width="133" scope="col">Present Status </th>
                <th width="124" scope="col">Previous Desk </th>
                <th width="140" scope="col">Last Deal By </th>
                <th width="141" scope="col">Last Process Date </th>
                <th width="87" scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
			<?php 
				$i=0;
				foreach($indListData as $item): 
				if(($i % 2) == 0) { $alt = "odd"; } else { $alt = "even"; }
				$i++;
			?>
	       <tr class="<?php echo $alt;?>">
                <td><a href="<?php echo site_url('complaint/complaintentry/');?>/<?php echo $item['complaint_id']; ?>"><?php echo $item['traking_number']; ?></a></td>
                <td><?php echo date("d-M-Y H:i A", strtotime($item['complaint_received_date'])); ?></td>
                <td><a href="<?php echo site_url('complaint/complaintentry/');?>/<?php echo $item['complaint_id']; ?>"><?php echo $item['complaint_name']; ?></a></td>
                <td><?php echo $item['previous_status']; ?></td>
                <td><?php echo $item['present_status']; ?></td>
                <td><?php echo $item['previous_desk']; ?></td>
                <td><?php echo $item['varFullName']; ?> (<?php echo $item['varDesignation']; ?>)</td>
                <td><?php echo date("d-M-Y h:i A", strtotime($item['last_udt'])); ?></td>
                <td>
				<a href="<?php echo site_url('complaint/complaintentry/');?>/<?php echo $item['complaint_id']; ?>" class="table_process" title="Process &amp; View Complaint">Process</a>
				<a href="<?php echo site_url('complaint/acknowledgement/');?>/<?php echo $item['complaint_id']; ?>" class="table_ack" title="Acknowledgement" target="_blank">Acknowledgement</a>
				<a href="<?php echo site_url('complaint/printDetail/');?>/<?php echo $item['complaint_id']; ?>" class="table_print" title="Print Complaint" target="_blank">Print Complaint</a>				
				</td>
              </tr>			  
		   <?php endforeach; ?> 
            </tbody>

          </table>
		  <?php if(isset($paging)) { ?>
	          <div class="pagination"> <?php echo $paging; ?>  <?php echo $rowFrom; ?>-<?php echo $page; ?> out of <?php echo $totalRows; ?> </div>
  		  <?php } ?>
          <!--/end .pagination-->       
        </fieldset>
<script type="text/javascript">
	$(document).ready(function() {	 
		var options = { 
				target:"#divIndividualView",
				beforeSend: function() {
					//$('#divIndividualView').empty();
					$('#divIndividualView').append("<span id='divAjaxLoading'>Loading, Please Wait ...</span>");
				 } 		
		}; 	
		
	  $(".ajaxLink").ajaxLink(options);		
	});		
</script>
<?php } else { ?>		
	<div class="information">No Such Complaint in Your Desk</div>
<?php }  ?>		