<div id="main">
  <h1>Reports</span></h1>
  <hr />
  <form action="<?php echo site_url('reports/showReports'); ?>" method="post" name="frmReport" target="_blank" id="frmReport" >
    <fieldset>
    <legend>Generate Report</legend>
    <p> <h2>Report Date From <span style="font-size:10px;">(dd-mm-yyyy)</span>: 
      <input name="date_from" type="text" class="sf datePicCal dateISO" id="date_to" value="" maxlength="11" style="width:75px;"/>
      <strong>To:</strong>
      <input name="date_to"  type="text" class="sf datePicCal dateISo" id="date_form" value="" maxlength="11" style="width:75px;"/></h2>
    </p><br />

    <p>
    <h2>Select Report Type </h2><hr />
	  
	  <h2><label style="width:auto;"><input type="radio" name="rbtReport" value="placeOfComplaint">Vaccination</label></h2>
	  <h2><label style="width:auto;"><input type="radio" name="rbtReport" value="categoryOfViolation">Birth Rate</label></h2>
	  <h2><label style="width:auto;"><input type="radio" name="rbtReport" value="age">Disabled Rate</label></h2>
	  <h2><label style="width:auto;"><input type="radio" name="rbtReport" value="gender">Literacy Rate</label></h2>	  
    </p>
    <p>
      <input class="button" type="submit" value="Show Report" />
      <input class="button" type="reset" value="Reset" />
    </p>
    </fieldset>
  </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#frmReport").validate();
    });
</script>
