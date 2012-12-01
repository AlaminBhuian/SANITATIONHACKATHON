<script type="text/javascript">
           jQuery(document).ready(function(){	
	 
	
	$(".datePicCal").bind("focus click", function(e){	
		var pickerOpts = {
			dateFormat:"yy-mm-dd",
			showOn: "button",
			buttonImage: "assets/images/icons/calendar.png",
			buttonImageOnly: true
		};
		$(this).datepicker(pickerOpts);
	});

	 
	
}); 
        </script>

<script type="text/javascript">
function showUser(date_to,date_form)//,tender_no,tender_date_from,tender_date_to,closing_date_from,closing_date_to,last_sell_date_from,last_sell_date_to
				  
{
  document.getElementById("txtHint").innerHTML='Please Wait....';
reqParams = "&date_to=" + encodeURIComponent(date_to) + "&date_form=" + encodeURIComponent(date_form);
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }

  
var url=base_url+"admin/main/search_complaint_data";
			xmlhttp.open("POST",url);
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp.send(reqParams);

}


</script>

<!-- Main Content -->
  <div id="full-content">
    <div id="full-main">
      <h1>Find Complaint</h1>
      <div class="pad20">
        <!-- Form -->
        <form  >
          <!-- Fieldset -->
          <fieldset>
          <legend>Filter Complaint</legend>
           <p>
            <span class="lable" style="width:80px;"><strong>By date</strong></span>
            <input class="sf datePicCal" name="sf" type="text" value="" name="date_to" id="date_to"/>
            To
            <input class="sf datePicCal" name="sf" type="text" value="" name="date_from" id="date_form"/>
          </p>
          <p>
          <label for="dropdown" style="width:70px;"><strong>By type</strong></label>
          <select  class="dropdown">
            <option selected="selected" value="">Select</option>
            <option>Individual, acting in his/her own interest</option>
            <option>Other person or entity acting on behalf of victim</option>
            <option>Evidence of permission or request of victim</option>
          </select>
          </p>
          
          <p>
          <label for="dropdown" style="width:70px;"><strong>By Status</strong></label>
          <select  class="dropdown">
              <option selected="selected" value="">Select</option>
            <option>Received</option>
            <option>Jurisdiction declined</option>
            <option>Withdrawn or lapsed</option>
            <option>Upheld after investigation</option>
            <option>Complaint Settled</option>
            
          </select>
          </p>
          <p>
          <input class="button" type="submit" value="Find" onclick="showUser(document.getElementById('date_to').value,
document.getElementById('date_from').value)"/>
          <input class="button" type="reset" value="Reset" />
          </p>
          </fieldset>
          <!-- End of fieldset -->
        </form>
        <!-- End of Form -->
        <fieldset>
        <legend>Complaints List</legend>     
        <table cellspacing="0" summary="table" class="broom_table" id="txtHint">
            <thead>
              <tr>
                <th width="75" scope="col">Tracking # </th>
                <th width="103" scope="col">Received Date </th>
                <th width="122" scope="col">Complainant Name </th>
                <th width="89" scope="col">Previous Status </th>
                <th width="91" scope="col">Present Status </th>
                <th width="178" scope="col">Present Desk </th>
                <th width="150" scope="col">Last Process Date </th>
                <th width="131" scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($get_info as $row)
                { ?>
              <tr class="odd">
                <td><a href="<?php echo site_url('complaint/complaintentry/'.$row['complaint_id']);?>"><?php echo $row['traking_number'];?></a></td>
                <td><?php echo $row['complaint_received_date'];?></td>
                <td><a href="<?php echo site_url('complaint/complaintentry/'.$row['complaint_id']);?>"><?php echo $row['complaint_name'];?></a></td>
                <td>Received</td>
                <td>On Hold</td>
                <td>AD - Md. Zahid Hossain</td>
                <td>15-Nov-2011 11:20AM</td>
                <td><a href="<?php echo site_url('complaint/complaintentry/'.$row['complaint_id']);?>" class="table_dtentry" title="Data Entry">Data Entry</a> <a href="<?php echo site_url();?>complaint/complaintentry" class="table_process">Process</a> <a href="#" class="table_comment">comment</a> </td>
              </tr>
              <?php }?>
            </tbody>
          </table>
          <div class="pagination"> <?php echo $paginet; ?></div>
          <!--/end .pagination-->       
        </fieldset>
      </div>
      <hr />
    </div>
  </div>
  <!-- End of Main Content -->