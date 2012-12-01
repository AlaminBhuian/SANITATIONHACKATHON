
<style>
   .bangla{
	font-size:16px;	
	font-family:SolaimanLipi, SutonnyOMJ, TonnyBanglaOMJ, Vrinda;
}
table {
	width:100%;
	clear:both;
	font-size:13px;
	padding:1px;
	margin-bottom:10px;
        
}
h2 {
    font-weight: bold;
    text-align: left;
}
table td {
	padding:3px 4px;
	margin:1px 0;
        font-size: 12px;
        vertical-align: top;
}

.addressTable td {
border: 1px solid #ffffff;
background-color:#F3F8F7;
}
fieldset {
	padding:0 20px 10px 20px;
	margin-bottom:15px;
}

fieldset legend {
	font-size:16px;
	padding:5px 10px 10px 0;
    font-family:Tahoma,Arial,sans-serif;
	font-weight:normal;
}
table th {
	padding:7px 9px;
	margin:1px 0;
        font-size: 12px;
}
/* End of Tables */
    
    
</style>
<script type="text/javascript">
window.print();
</script>


<fieldset>
    <legend><span class="bangla">অভিযোগকারীর বিবরণ </span> (Information about the complainant ) </legend>
	<div class="addressTable">
    <table width="100%">
        <tr>

          <td width="33%"><label><strong>Tracking No:</strong></label></td>
            <td width="67%"><strong><?php echo $complaintInfo->traking_number; ?></strong></td>
        </tr>
        <tr>
          <td width="33%"> <label><span class="bangla">অভিযোগকারী </span>(Complainant)</label></td>
            <td width="67%"><label for="lf">
                    <?php
                    foreach ($complaintType as $item)
                    {
                        if ($item['id'] == $complaintInfo->complainant_id)
                        {
                            echo $item['varName'];
                        }
                    }
                    ?></label>
          </td>
        </tr>
        <tr>
          <td width="33%"><label> <span class="bangla">নাম </span> (Name) </label></td>
            <td width="67%"><label for="lf"><?php echo $complaintInfo->complaint_name; ?></label></td>
        </tr>
        <tr>
          <td width="33%"><label><span class="bangla">লিঙ্গ </span>(Sex)</label></td>
            <td width="67%"><label for="lf" style="text-transform: capitalize;"><?php echo $complaintInfo->sex; ?></label></td>
        </tr>
        <tr>
          <td width="33%"><label><span class="bangla">পিতার নাম </span>(Father's Name)</label></td>
            <td width="67%"><label for="lf"><?php echo $complaintInfo->father_name; ?></label></td>
        </tr>
        <tr>
          <td width="33%"><label><span class="bangla">মাতার নাম </span>(Mother's Name)</label></td>
            <td width="67%"><label for="lf"><?php echo $complaintInfo->mother_name; ?></label></td>
        </tr>
        <tr>
          <td width="33%">  <label><span class="bangla">স্বামী/স্ত্রীর নাম </span>(Spouse's Name)</label></td>
            <td width="67%"><label for="lf"><?php echo $complaintInfo->spouse_name; ?></label></td>
        </tr>
</table>
</div>
<div class="addressTable">
		<table width="100%">
        <tr>
            <td colspan="2" style="text-align: left;"><h2><span class="bangla">স্থায়ী ঠিকানা </span>(Permanent Address)</h2></td>
			<td colspan="2" style="text-align: left;"><h2><span class="bangla">বর্তমান ঠিকানা </span>(Present Address)</h2></td>            
        </tr>

        <tr>
          <td width="20%"><label style="width:345px;"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label></td>
          <td width="29%"><label for="lf"><?php echo $complaintInfo->permanent_village; ?></label></td>
		  <td width="20%"><label style="width:345px;"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label></td>
          <td width="31%"><label for="lf"><?php echo $complaintInfo->present_address; ?></label></td>
        </tr>
        <tr>
          <td width="20%"><label style="width:145px;"><span class="bangla"> জেলা </span>(District)</label></td>
            <td width="29%">     <?php
                    foreach ($districtList as $item)
                    {
                        if ($item['district_id'] == $complaintInfo->permanent_district)
                        {
                            echo $item['district_name'];
                        }
                    }
                    ?>            </td>
					
		  <td width="20%"> <label style="width:145px;"><span class="bangla"> জেলা </span>(District)</label></td>
            <td width="31%"> 
<?php
foreach ($districtList as $item)
{
    if ($item['district_id'] == $complaintInfo->present_district)
    {
        echo $item['district_name'];
    }
}
?>            </td>
        </tr>
        <tr>
          <td width="20%"><label style="width:145px;" align="left"><span class="bangla">থানা</span>(Thana)</label></td>
            <td width="29%">
                <?php
                foreach ($permanentSubDistricts as $item)
                {
                    if ($item['sub_district_id'] == $complaintInfo->permanent_sub_district)
                    {
                        echo $item['sub_district_name'];
                    }
                }
                ?>            </td>
				
		  <td width="20%"><label style="width:145px;"><span class="bangla">থানা </span>(Thana)</label></td>

            <td width="31%"><?php
                foreach ($presentSubDistricts as $item)
                {
                    if ($item['sub_district_id'] == $complaintInfo->present_sub_district)
                    {
                        echo $item['sub_district_name'];
                    }
                }
?>            </td>
        </tr>
        <tr>
          <td width="20%">  <label style="width:145px;"><span class="bangla">ফোন </span>(Ph./Mobile)</label></td>
          <td width="29%"> <label for="lf"><?php echo $complaintInfo->permanent_phone; ?></label></td>
		  <td width="20%"><label style="width:145px;"><span class="bangla">ফোন </span>(Ph./Mobile)</label></td>
          <td width="31%"><label for="lf"><?php echo $complaintInfo->present_phone; ?></label></td>
        </tr>
        <tr>
          <td width="20%"><label style="width:145px;"><span class="bangla">ফ্যাক্স </span>(FAX)</label></td>
          <td width="29%"><label for="lf"><?php echo $complaintInfo->permanent_fax; ?></label></td>
		  <td width="20%"><label style="width:145px;"> <span class="bangla">ফ্যাক্স </span>(FAX) </label></td>
          <td width="31%"><label for="lf"><?php echo $complaintInfo->present_fax; ?></label></td>
        </tr>
        <tr>
          <td width="20%"><label style="width:145px;"><span class="bangla">ইমেইল </span>(E-mail)</label></td>
          <td width="29%"><label for="lf"><?php echo $complaintInfo->permanent_email; ?></label></td>
		  <td width="20%"><label style="width:145px;"> <span class="bangla">ইমেইল </span>(E-mail) </label></td>
          <td width="31%"><label for="lf"><?php echo $complaintInfo->present_email; ?></label></td>
        </tr>
        
    </table>
	</div>
</fieldset>
<!--end complaint information-->


<!--Start victims information-->
<?php if($victimInformation){?>
<fieldset>
    <legend> <span class="bangla"> ক্ষতিগ্রস্ত ব্যক্তি সংক্রান্ত তথ্য </span>(Information About the Victim)</legend>
		<div class="addressTable">
                    
    <table width="100%">  
        <tr>
          <td ><label><span class="bangla">ক্ষতিগ্রস্ত ব্যক্তির নাম </span>(Victim's Name)</label></td>
          <td width="67%"><label for="lf"><?php echo $victims_name; ?></label></td>
        </tr>
        <tr>
          <td ><label><span class="bangla">পিতার নাম </span>(Father's Name) </label></td>
          <td width="67%"><label for="lf"><?php echo $victims_father_name; ?></label></td>
        </tr>
        <tr>
          <td ><label><span class="bangla">মাতার নাম </span>(Mother's Name) </label></td>
          <td width="67%"><label for="lf"><?php echo $victims_mother_name; ?></label></td>
        </tr>
        <tr>
          <td ><label><span class="bangla">স্বামী/স্ত্রীর নাম </span>(Spouse's Name) </label></td>
          <td width="67%"><label for="lf"><?php echo $victims_spouse_name; ?></label></td>
        </tr>
        <tr>
          <td ><label for="dropdown"><span class="bangla">লিঙ্গ </span>(Sex)</label></td>
        <td width="67%">  <label for="lf" style="text-transform: capitalize;"> <?php echo $victims_sex; ?></label>        </tr>
        <tr>
          <td > <label><span class="bangla">বয়স </span>(Age)</label></td>
          <td width="67%"><label for="lf"><?php echo $victims_age; ?></label></td>
        </tr>
        <tr>
          <td c><label><span class="bangla">ধর্ম </span>(Religion)</label></td>

            <td width="67%"> <label for="lf"> <?php foreach ($religionList as $religion)
                {
                if($victims_religion == $religion['id'] ){
                    echo $religion['varName']; }?>
<?php } ?>
          </label></td>
        </tr>
        <tr>
          <td ><label><span class="bangla">ক্ষতিগ্রস্ত ব্যক্তির সংখ্যা </span>(Number of Victims)</label></td>
          <td width="67%"><label for="lf"><?php echo $victims_number; ?></label></td>
        </tr>
        <tr> <td ><span class="lable"><span class="bangla">আপনি কি কোনো আদিবাসী সম্প্রদায়ের একজন সদস্য? <br />
        </span>(Are you a member of any indigenous Community?)</span></td>
            <td width="67%">  
                
                     <?php echo $victims_indigenous_community; ?>          </td>
        </tr>
        <tr> <td height="30" ><span class="lable"><span class="bangla">প্রতিবন্ধী কী না? </span>(Is the victim disabled?)</span></td>
            <td width="67%"><label style="width:65px;">
          <?php echo $disabled; ?> </label></td>
        </tr>
</table>
</div>
		<div class="addressTable">
         <table width="100%" >  
        <tr>
          <td colspan="2" ><h2><span class="bangla">&#2488;&#2509;&#2469;&#2494;&#2479;&#2492;&#2496; &#2464;&#2495;&#2453;&#2494;&#2472;&#2494; </span>(Permanent Address)</h2></td>
          <td colspan="2" ><h2><span class="bangla">&#2476;&#2480;&#2509;&#2468;&#2478;&#2494;&#2472; &#2464;&#2495;&#2453;&#2494;&#2472;&#2494; </span>(Present Address)</h2></td>
        </tr>
        <tr>
          <td ><label><span class="bangla">&#2455;&#2509;&#2480;&#2494;&#2478;/&#2447;&#2482;&#2494;&#2453;&#2494;/&#2451;&#2479;&#2492;&#2494;&#2480;&#2509;&#2465; </span> (Village/Moholla/Road No.)</label></td>
          <td ><label for="lf"><?php echo $victims_permanent_village; ?></label></td>
          <td ><label><span class="bangla">&#2455;&#2509;&#2480;&#2494;&#2478;/&#2447;&#2482;&#2494;&#2453;&#2494;/&#2451;&#2479;&#2492;&#2494;&#2480;&#2509;&#2465; </span> (Village/Moholla/Road No.)</label></td>
          <td width="31%" ><label for="lf"><?php echo $victims_present_village; ?></label></td>
        </tr>
        <tr>
          <td ><label><span class="bangla"> &#2460;&#2503;&#2482;&#2494; </span>(District)</label></td>
          <td  ><?php foreach ($get_district as $row)
{
    if ($permanent_district == $row['district_id'])
    {
        echo $row['district_name'];
    }
} ?></td>
          <td ><label><span class="bangla"> &#2460;&#2503;&#2482;&#2494; </span>(District)</label></td>
          <td ><?php foreach ($get_district as $row)
{  if ($present_district == $row['district_id'])
    { echo $row['district_name']; } } ?></td>
        </tr>
        <tr>
          <td ><label><span class="bangla">&#2469;&#2494;&#2472;&#2494; </span>(Thana)</label></td>
          <td ><?php
foreach ($permanentSubDistricts as $item)
{
    if ($item['sub_district_id'] == $permanent_sub_district)
    {
        echo $item['sub_district_name'];
    }
}
?>
    </td>
          <td ><label><span class="bangla">&#2469;&#2494;&#2472;&#2494; </span>(Thana)</label></td>
          <td ><?php
        foreach ($presentSubDistricts as $item)
        {
            if ($item['sub_district_id'] == $present_sub_district)
            {
                echo $item['sub_district_name']; }} ?></td>
        </tr>
        <tr>
          <td ><label><span class="bangla">&#2475;&#2507;&#2472; </span>(Phone/Mobile)</label></td>
          <td ><label for="lf"><?php echo $victims_permanent_phone; ?></label></td>
          <td ><label><span class="bangla">&#2475;&#2507;&#2472; </span>(Phone/Mobile)</label></td>
          <td ><label for="lf"><?php echo $victims_present_phone; ?></label></td>
        </tr>
        <tr>
          <td ><label><span class="bangla">&#2475;&#2509;&#2479;&#2494;&#2453;&#2509;&#2488; </span>(FAX)</label></td>
          <td ><label for="lf"><?php echo $victims_permanent_fax; ?></label></td>
          <td ><label><span class="bangla">&#2475;&#2509;&#2479;&#2494;&#2453;&#2509;&#2488; </span>(FAX)</label></td>
          <td ><label for="lf"><?php echo $victims_present_fax; ?></label></td>
        </tr>
        <tr>
          <td width="20%" ><label><span class="bangla">&#2439;&#2478;&#2503;&#2439;&#2482; </span>(E-mail)</label>        </td>
          <td width="26%" ><label for="lf"><?php echo $victims_permanent_email; ?></label></td>
          <td width="23%" ><label><span class="bangla">&#2439;&#2478;&#2503;&#2439;&#2482; </span>(E-mail)</label></td>
          <td ><label for="lf"><?php echo $victims_present_email; ?></label></td>
        </tr>
		 </table>  
</div>
	<div class="addressTable">
		  <table width="100%">  
      <tr>
    <td  ><label style="width:345px;"><span class="bangla">অভিযোগ গ্রহণের ধরন </span>(Method Of Delivery)</label></td>
    <td width="67%">
<?php
if (isset($methodOfComplaint))
{
    foreach ($methodOfComplaint as $item):
         if (in_array($item['id'], $selMethodOfDel))
        {   echo $item['varName'].',';} ?>
    <?php endforeach;
} ?>    </td>
    </tr>


<tr>
    <td ><label> Number Of Attachment Pages </label></td>
    <td width="67%"><label for="lf"><?php echo $complaintInfo->attachment_page_number; ?></label></td>
</tr>
<tr>
    <td  colspan="2"><strong><span class="bangla"> ঘটনার সংক্ষিপ্ত বর্ণনা </span>(Summarized Description of the Incident)</strong></td>    
</tr>  
<tr>
    <td colspan="2"><p style="text-align: justify;"><?php echo nl2br($complaintInfo->description); ?></p></td>
</tr>
</table>
</div>
   
</fieldset>
 <?php }?>
<!--End Victims Information-->



<!--Start Complaint analysis-->
<?php if($analysisData){ ?>
 <fieldset>
    <legend>Complaint Analysis</legend>
		<div class="addressTable">
    <table  widdth="100%">
    <tr>
        <td width="34%"><span class="bangla"> অভিযোগটি কি মানবাধিকারের লঙ্ঘন? </span>(Is this complaint a human rights violation ?)</td>
    <td width="66%">
    <?php echo  $human_rights_violation;?>    </td>
  </tr>
  <tr>
    <td width="34%"><span><span class="bangla">কোন ধরনের মানবাধিকার লঙ্ঘন ?</span>(What kind of Human Rights violation?)</span></td>
 
    <td width="66%">    <?php foreach($getAnalysisHRViolationList as $hrviolationItem): ?>  
      <?php  
			foreach($getVolutionList as $item){ 
				if($item['id'] == $hrviolationItem['hrviolation_id']) {
		   echo $item['varName'].','; }} ?>    
  <?php endforeach; ?></td>
  </tr>
  
  <tr>
      <td colspan="2"><strong><span class="bangla">চিহ্নিত অভিযোগ </span>(Identified category) </strong></td>    
  </tr>
  <tr>
      <td colspan="2"><p style="text-align: justify;"><?php echo nl2br($identified_category);?></p></td>
  </tr>
  
  <tr> 
     <td width="34%"><span class="bangla">লঙ্ঘিত অধিকারটি কি বাংলাদেশ সংবিধানে স্বীকৃত </span>(Is the violated Right covered in the  Constitution)?</td>
    <td width="66%"><label>
     <?php echo $violet_constitution;?>
    </label></td>
  </tr>
 </table> 
 </div>
</fieldset>
<?php }?>
<!--End Complaint analysis-->


<!--Start respondent Information-->
<?php if($respondent){ ?>
<fieldset>
  <legend> <span class="bangla">অভিযুক্ত ব্যক্তি/ব্যক্তিগন/প্রতিষ্ঠানের তথ্য </span>(Information About Respondent Person(s)/Organization(s))</legend>
  <?php 
   $i=5000;
  foreach($respondent as $respondentItem): ?>
  	<div class="addressTable">
  <table width="100%">
  <tr>
    <td width="34%"><label><span class="bangla">অভিযুক্ত </span>(Respondent Type)</label></td>
    <td width="66%"> <?php echo $respondentItem['respondent_type'];?></td>
  </tr>
  <tr>
    <td width="34%"><label><span class="bangla">নাম </span>(Name)</label></td>
    <td width="66%"><?php echo $respondentItem['respondent_name'];?></td>
  </tr>
  <tr>
    <td width="34%"><label for="dropdown"><span class="bangla">পদবী </span>(Designation)</label></td>
    <td width="66%"><?php echo $respondentItem['respondent_designation'];?></td>
  </tr>
  <tr>
    <td width="34%"><label><span class="bangla">পিতার নাম </span>(Father's Name)</label></td>
    <td width="66%"><?php echo $respondentItem['respondent_father_name'];?></td>
  </tr>
  <tr>
    <td width="34%"><label><span class="bangla">মাতার নাম </span>(Mother's Name)</label></td>
    <td width="66%"><?php echo $respondentItem['respondent_mother_name'];?></td>
  </tr>
  <tr>
    <td width="34%"><label><span class="bangla">স্বামী/স্ত্রীর নাম </span>(Spouse's Name)</label></td>
    <td width="66%"><?php echo $respondentItem['respondent_spouse_name'];?></td>
  </tr>
  <tr>
  <td width="34%"><span class="bangla">শৃঙ্খলা বাহিনীর কোন সদস্যের বিরুদ্ধে অভিযোগ কিনা? </span>( Is this a complaint against any member of the disciplined force?)</td>
    <td width="66%"><?php echo $respondentItem['respondent_member_decipline_force']; ?> </td>
  </tr>
  <tr>
    <td width="34%"><label style="width:300px">Select Type of Disciplined Force</label></td>
      <td width="66%">
        <?php  
	  	foreach($desciplinedForce as $item){ 
	  		if($item['id'] == $respondentItem['decipline_force_member_yes']) {
	   echo $item['varName'];}} ?>    </td>
    </tr>
    <tr>
     <td width="34%"> <label style="width:300px">or, Select Against Type</label></td>
     
     <td width="66%"> 
        <?php  
	  	foreach($againstRespondentType as $item){ 
	  		if($item['id'] == $respondentItem['respondent_member_decipline_no']) {
	   echo $item['varName'];}} ?>      </td>
    </tr>

  <tr>
    <td width="34%"><label style="width:300px">or, Other Type</label></td>
    <td width="66%"><?php echo $respondentItem['others_respondent'];?></td>
  </tr>
  </table>
  </div>
  	<div class="addressTable">
		  <table width="100%">
    <tr>
        <td  colspan="2"><h2><span class="bangla">স্থায়ী ঠিকানা </span>(Permanent Address)</h2> </td>
		<td colspan="2"><h2><span class="bangla">বর্তমান ঠিকানা </span>(Present Address)</h2></td>
        </tr>
        <tr>    
          <td width="15%"><label><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label></td>
            <td width="31%"><?php echo $respondentItem['respondent_permanent_village'];?></td>
		  <td width="19%"><label><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড  </span> (Village/Moholla/Road No.)</label></td>
            <td width="35%"><?php echo $respondentItem['respondent_present_village'];?></td>
          </tr>
          <tr>
           <td width="15%"> <label><span class="bangla"> জেলা </span>(District)</label></td>           
	  <td width="31%">
              <?php foreach ($get_district as $row) {
              if( $respondentItem['permanent_district'] == $row['district_id']){ echo $row['district_name'];}}?>            </td>
			<script>
					$(function()
					{
						$("select[name*='permanent_district']").change(function(){
						var Q = $(this).attr("id");
						var D = eval(Q.substring(18))+1;
						if(isNaN(D)) {	// price
							var strID = "permanent_sub_district";
						} else {
							var strID = "permanent_sub_district"+D;
					
						}
					
						var V= $(this).val();
						$("#"+strID).val(V);
					
						$.ajax({
						url: "complaint/getUpazillaLoad/" + $(this).val(),
						async: false,
						type: 'POST',
						dataType: 'json',
						success: function(data)
					
						  {
							  $("#"+strID).empty();
							  $("#"+strID).append("<option value='0'>Select</option>");
							  $.each(data.upazillas, function(){ // Loop json data
								  $("#"+strID).append("<option value='" + this['sub_district_id'] + "'>" + this['sub_district_name'] + "</option>");
							  });
						}
						});
					  });
					});
			</script>
			<td width="19%"><label><span class="bangla"> জেলা </span>(District)</label></td>
            
			
            <td width="35%">  <?php foreach ($get_district as $row) { if($respondentItem['present_district'] == $row['district_id']){echo $row['district_name'];}}?></td>
            
			<script>
					$(function()
					{
						$("select[name*='present_district']").change(function(){
						var Q = $(this).attr("id");
						var D = eval(Q.substring(16))+1;
						if(isNaN(D)) {	// price
							var strID = "present_sub_district";
						} else {
							var strID = "present_sub_district"+D;
					
						}
					
						var V= $(this).val();
						$("#"+strID).val(V);
					
						$.ajax({
						url: "complaint/getUpazillaLoad/" + $(this).val(),
						async: false,
						type: 'POST',
						dataType: 'json',
						success: function(data)
						  {
							  $("#"+strID).empty();
							  $("#"+strID).append("<option value='0'>Select</option>");
							  $.each(data.upazillas, function(){ // Loop json data
								  $("#"+strID).append("<option value='" + this['sub_district_id'] + "'>" + this['sub_district_name'] + "</option>");
							  });
						}
						});
					  });
					});
			</script>
         </tr>
          <tr>
           <td width="15%"> <label><span class="bangla">থানা </span>(Thana)</label> </td>        
			<td width="31%">
			<?php $upazillas = modules::run('complaint/getUpazilla', $respondentItem['permanent_district']); ?>
				<?php if($upazillas){foreach($upazillas as $entry): ?>
				<?php if($entry['sub_district_id'] ==  $respondentItem['permanent_sub_district']) { echo $entry['sub_district_name']; } endforeach; }?></td>
		  <td width="19%"><label><span class="bangla">থানা</span>(Thana)</label></td>
		<td width="35%">	
			
			<?php $upazillas = modules::run('complaint/getUpazilla', $respondentItem['present_district']); ?>
				<?php if($upazillas){foreach($upazillas as $entry): ?>
				<?php if($entry['sub_district_id'] ==  $respondentItem['present_sub_district']) {  echo $entry['sub_district_name'];} endforeach;} ?>		  </td>
	  
          </tr>
          <tr>
            <td width="15%"><label><span class="bangla">ফোন </span>(Phone/Mobile)</label></td>
            <td width="31%"><?php echo $respondentItem['respondent_permanent_phone'];?></td>
			<td width="19%"><label><span class="bangla">ফোন </span>(Phone/Mobile)</label></td>
            <td width="35%"><?php echo $respondentItem['respondent_present_phone'];?></td>
          </tr>
          <tr>
            <td width="15%"><label><span class="bangla">ফ্যাক্স </span>(FAX)</label></td>
            <td width="31%"><?php echo $respondentItem['respondent_permanent_fax'];?></td>
			<td width="19%"><label><span class="bangla">ফ্যাক্স </span>(FAX)</label></td>
            <td width="35%"><?php echo $respondentItem['respondent_present_fax'];?></td>
          </tr>
          <tr>
            <td width="15%"><label><span class="bangla">ইমেইল </span>(E-mail)</label></td>
            <td width="31%"><?php echo $respondentItem['respondent_permanent_email'];?></td>
			<td width="19%"> <label><span class="bangla">ইমেইল </span>(E-mail)</label></td>
            <td width="35%"><?php echo $respondentItem['respondent_present_email'];?></td>
          </tr>
		  
                 
        
  </table>   
  </div>
         <?php endforeach; ?>
  </fieldset>
<?php }?>
<!--End respondent information-->


<!--Start Incident Information-->
<?php if ($incident_info) {?>
<fieldset>
  <legend> <span class="bangla">মানবাধিকার লঙ্ঘনের সংক্ষিপ্ত বিবরণ </span>(Information about the Incident)</legend>
  	<div class="addressTable">
  <table width="100%">
  <tr>
   <td width="34%"> <label for="sf"><span class="bangla">তারিখ </span>(Date) dd-mm-yyyy</label></td>
   <td width="66%"><label for="lf"><?php echo $incident_date." (".$selTimeHr.':'.$selTimeMin." ".$selTimeAMPM.")";?> </label></td>
  </tr>
  <tr>
      <td colspan="2"><h2><span class="bangla">ঘটনাস্থল </span>(Place of Occurrence)</h2></td>
	  
  </tr>
  <tr>
    <td width="34%"><label for="lf"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span>(Village/Area/Ward)</label></td>
    <td width="66%"><label for="lf"><?php echo $incident_address;?></label></td>
  </tr>
  <tr>
    <td width="34%"><label for="sf"><span class="bangla"> জেলা </span>(District)</label></td>
    <td width="66%">
      <?php foreach ($get_district as $row) { if( $permanent_district==$row['district_id']){ echo $row['district_name'];}}?></td>
  
  </tr>
 <tr>
    <td width="34%"><label for="sf"><span class="bangla">থানা </span>(Thana)</label></td>
    <td width="66%">
      <?php if($sub_district_info) {  echo $sub_district_info[0]['sub_district_name'];?>
      <?php } ?>    </td>
  </tr>
  
  
  <tr> 
      <td colspan="2"><strong><span class="bangla">ঘটনার বিবরণঃ </span>(Description of the occurrence)</strong></td>  
  </tr>
  <tr> 
      <td colspan="2"><p style="text-align: justify;"><?php echo nl2br($incident_description);?></p></td>
  </tr>
  <tr> <td width="34%"> <span class="bangla">বর্ণিত অভিযোগের বিষয়ে কোন আদালতে মামলা হয়েছে কী না? </span>(Has the said case been lodged before any court?)</td>
  <td width="66%">  
     <?php echo $case_court; ?></td>
  </tr>
  <tr>
      <td colspan="2"><strong><span class="bangla"> যে প্রতিকার প্রার্থনা করা হয়েছে </span>(The Desired Remedy)</strong></td>
  </tr>
  <tr>
      <td colspan="2"><p style="text-align: justify;"><?php echo nl2br($incident_desired_remedy);?></p></td>
  </tr>
  </table>
  </div>
  </fieldset>
<?php }?>
<!--end Incident Information-->


<!--Start complaint document-->
<?php if($getDocuments){?>
 <fieldset>
<legend>Uploaded Document</legend>
	<div class="addressTable">
<table cellspacing="0" summary="table"  border="0" width="100%">

    <tr align="left">
      <td><strong>Note</strong></td>
      <td><strong>File Title </strong></td>
      <td><strong>File Name </strong></td>
      <td><strong>File Size </strong></td>
      <td><strong>Upload Date </strong></td>
    </tr>
 

    <?php 
		
		foreach($getDocuments as $item):		
	?>
    <tr  style="height:30px">
      <td ><?php echo nl2br( $item['varDocumentDesc']); ?></td>
      <td><?php echo $item['varDocumentTitle']; ?></a></td>
      <td><?php echo $item['varFileName']; ?></td>
      <td><?php echo $item['varFileSize']; ?> KB </td>
      <td><?php echo date("d-M-Y H:i A", strtotime($item['dtInsertDT'])); ?></td>      
    </tr>
    <?php endforeach; ?>
</table>
</div>
</fieldset>
<?php }?>
<!--End complaint document-->