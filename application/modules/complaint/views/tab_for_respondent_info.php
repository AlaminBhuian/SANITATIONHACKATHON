<form name="frmRespondentTab" id="frmRespondentTab" method="post" action="<?php echo site_url('complaint/submit_respondent_information'); ?>">
    <?php
    $i = 5000;
    foreach ($respondent as $respondentItem):
        ?>
        <fieldset>
            <legend> <span class="bangla">অভিযুক্ত ব্যক্তি/ব্যক্তিগন/প্রতিষ্ঠানের তথ্য </span>(Information About Respondent Person(s)/Organization(s))</legend>
            <p>
                <label><span class="bangla">অভিযুক্ত </span>(Respondent Type)</label>
                <select name="rbtRespondentType[]" class="dropdown" id="rbtRespondentType" style="width:200px;">
                    <option value="0" selected="selected">Select</option>
                    <option value="person" <?php
    if ($respondentItem['respondent_type'] == 'person')
    {
            ?> selected="selected" <?php } ?>>Person</option>
                    <option value="organization"  <?php
                        if ($respondentItem['respondent_type'] == 'organization')
                        {
            ?> selected="selected" <?php } ?>>Organization</option>
                </select>
            </p>
            <p>
                <label><span class="bangla">নাম </span>(Name)<span class="red">*</span></label>
                <input name="respondent_name[]" type="text" class="lf required" value="<?php echo $respondentItem['respondent_name']; ?>" maxlength="150"/>
            </p>
            <p>
                <label for="dropdown"><span class="bangla">পদবী </span>(Designation)</label>
                <input name="respondent_designation[]" type="text" class="lf" id="respondent_designation" value="<?php echo $respondentItem['respondent_designation']; ?>" maxlength="120"/>
            </p>
            <p>
                <label><span class="bangla">পিতার নাম </span>(Father's Name)</label>
                <input name="father_name[]" type="text" class="lf" id="father_name" value="<?php echo $respondentItem['respondent_father_name']; ?>" maxlength="150"/>
            </p>
            <p>
                <label><span class="bangla">মাতার নাম </span>(Mother's Name)</label>
                <input name="mother_name[]" type="text" class="lf" id="mother_name" value="<?php echo $respondentItem['respondent_mother_name']; ?>" maxlength="150"/>
            </p>
            <p>
                <label><span class="bangla">স্বামী/স্ত্রীর নাম </span>(Spouse's Name)</label>
                <input name="spouse_name[]" type="text" class="lf" id="spouse_name" value="<?php echo $respondentItem['respondent_spouse_name']; ?>" maxlength="150"/>
            </p>
            <p><span class="bangla">শৃঙ্খলা বাহিনীর কোন সদস্যের বিরুদ্ধে অভিযোগ কিনা? </span> <br />
                ( Is this a complaint against any member of the disciplined force?)
                <select name="deciplin_force[]" class="dropdown" id="deciplin_force" style="width:200px;">
                    <option value="0" selected="selected">Select</option>
                    <option value="yes" <?php
                        if ($respondentItem['respondent_member_decipline_force'] == 'yes')
                        {
            ?> selected="selected" <?php } ?>>Yes</option>
                    <option value="no" <?php
                        if ($respondentItem['respondent_member_decipline_force'] == 'no')
                        {
            ?> selected="selected" <?php } ?>>No</option>
                </select>   
            </p>
            <div id="divForceYes">
                <p>
                    <label style="width:300px">Select Type of Disciplined Force</label>
                    <select name="decipline_force_member_yes[]" class="dropdown" id="decipline_force_member_yes" style="width:340px;">
                        <option value="0" selected="selected">Select</option>
                        <?php
                        foreach ($desciplinedForce as $item)
                        {
                            if ($item['id'] == $respondentItem['decipline_force_member_yes'])
                            {
                                ?>
                                <option value="<?php echo $item['id']; ?>" selected="selected"><?php echo $item['varName']; ?></option>
                                <?php
                            } else
                            {
                                ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo $item['varName']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </p>
            </div>
            <div id="divForceNo">
                <p>
                    <label style="width:300px">or, Select Against Type</label>
                    <select name="respondent_member_decipline_no[]" class="dropdown" id="respondent_member_decipline_no" style="width:340px;">
                        <option value="0" selected="selected">Select</option>
                        <?php
                        foreach ($againstRespondentType as $item)
                        {
                            if ($item['id'] == $respondentItem['respondent_member_decipline_no'])
                            {
                                ?>
                                <option value="<?php echo $item['id']; ?>" selected="selected"><?php echo $item['varName']; ?></option>
                                <?php
                            } else
                            {
                                ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo $item['varName']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </p>
            </div>
            <p>
                <label style="width:300px">or, Other Type</label>
                <input name="others_respondent[]" type="text" class="lf" id="others_respondent" maxlength="150" value="<?php echo $respondentItem['others_respondent']; ?>"/>
            </p>
            <table width="100%" border="0">
                <tr>
                    <td width="50%"><div class="inpcol">
                            <h2><span class="bangla">স্থায়ী ঠিকানা </span>(Permanent Address)</h2>
                            <p>
                                <label><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label>
                                <input name="respondent_permanent_village[]" type="text" class="sf" id="respondent_permanent_village" style="width:175px;" value="<?php echo $respondentItem['respondent_permanent_village']; ?>" maxlength="120"/>
                            </p>
                            <p>
                                <label><span class="bangla"> জেলা </span>(District)</label>           
                                <select name="permanent_district[]" id="permanent_district<?php echo $i++; ?>" class="dropdown" style="width:185px;">
                                    <option value="0">Select</option>
                                    <?php
                                    foreach ($get_district as $row)
                                    {
                                        ?>
                                        <option value="<?php echo $row['district_id']; ?>" <?php
                                if ($respondentItem['permanent_district'] == $row['district_id'])
                                {
                                            ?> selected="selected" <?php } ?>><?php echo $row['district_name']; ?></option>
                                            <?php } ?>
                                </select>
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
                            </p>
                            <p>
                                <label><span class="bangla">থানা </span>(Thana/Upazilla)</label>         
                                <select id="permanent_sub_district<?php echo $i++; ?>" name="permanent_sub_district[]" class="dropdown" style="width:185px;">
                                    <option value="0">Select</option>
                                    <?php $upazillas = modules::run('complaint/getUpazilla', $respondentItem['permanent_district']); ?>
                                    <?php foreach ($upazillas as $entry): ?>
                                        <?php
                                        if ($entry['sub_district_id'] == $respondentItem['permanent_sub_district'])
                                        {
                                            ?>
                                            <option value="<?php echo $entry['sub_district_id']; ?>" selected ="selected"><?php echo $entry['sub_district_name']; ?></option>
                                            <?php
                                        } else
                                        {
                                            ?>
                                            <option value="<?php echo $entry['sub_district_id']; ?>"><?php echo $entry['sub_district_name']; ?></option>
                                        <?php } endforeach; ?>
                                </select>

                            </p>
                            <p>
                                <label><span class="bangla">ফোন </span>(Phone/Mobile)</label>
                                <input name="respondent_permanent_phone[]" type="text" class="sf" id="respondent_permanent_phone" style="width:175px;"  value="<?php echo $respondentItem['respondent_permanent_phone']; ?>" maxlength="30"/>
                            </p>
                            <p>
                                <label><span class="bangla">ফ্যাক্স </span>(FAX)</label>
                                <input name="respondent_permanent_fax[]" type="text" class="sf" id="respondent_permanent_fax" style="width:175px;" value="<?php echo $respondentItem['respondent_permanent_fax']; ?>" maxlength="30"/>
                            </p>
                            <p>
                                <label><span class="bangla">ইমেইল </span>(E-mail)</label>
                                <input name="respondent_permanent_email[]" type="text" class="sf email" id="respondent_permanent_email" style="width:175px;" value="<?php echo $respondentItem['respondent_permanent_email']; ?>" maxlength="120"/>
                            </p>
                            <p> </p>
                        </div></td>
                    <td><div class="inpcol">
                            <h2><span class="bangla">বর্তমান ঠিকানা </span>(Present Address)</h2>
                            <p>
                                <label><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label>
                                <input name="respondent_present_village[]" type="text" class="sf" id="respondent_present_village" style="width:175px;" value="<?php echo $respondentItem['respondent_present_village']; ?>" maxlength="120"/>
                            </p>
                            <p>
                                <label><span class="bangla"> জেলা </span>(District)</label>          
                                <select name="present_district[]" class="dropdown" style="width:185px;" id="present_district<?php echo $i++; ?>">
                                    <option value="0">Select</option>
                                    <?php
                                    foreach ($get_district as $row)
                                    {
                                        ?>
                                        <option value="<?php echo $row['district_id']; ?>" <?php
                                if ($respondentItem['present_district'] == $row['district_id'])
                                {
                                            ?> selected="selected" <?php } ?>><?php echo $row['district_name']; ?></option>
                                            <?php } ?>
                                </select>
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
                            </p>
                            <p>
                                <label><span class="bangla">থানা </span>(Thana/Upazilla)</label>          

                                <select id="present_sub_district<?php echo $i++; ?>" name="present_sub_district[]" class="dropdown" style="width:185px;">
                                    <option value="0">Select</option>
                                    <?php $upazillas = modules::run('complaint/getUpazilla', $respondentItem['present_district']); ?>
                                    <?php foreach ($upazillas as $entry): ?>
                                        <?php
                                        if ($entry['sub_district_id'] == $respondentItem['present_sub_district'])
                                        {
                                            ?>
                                            <option value="<?php echo $entry['sub_district_id']; ?>" selected ="selected"><?php echo $entry['sub_district_name']; ?></option>
                                            <?php
                                        } else
                                        {
                                            ?>
                                            <option value="<?php echo $entry['sub_district_id']; ?>"><?php echo $entry['sub_district_name']; ?></option>
                                        <?php } endforeach; ?>
                                </select>

                            </p>
                            <p>
                                <label><span class="bangla">ফোন </span>(Phone/Mobile)</label>
                                <input class="sf" name="respondent_present_phone[]" type="text" value="<?php echo $respondentItem['respondent_present_phone']; ?>" style="width:175px;"/>
                            </p>
                            <p>
                                <label><span class="bangla">ফ্যাক্স </span>(FAX)</label>
                                <input class="sf" name="respondent_present_fax[]" type="text" value="<?php echo $respondentItem['respondent_present_fax']; ?>" style="width:175px;"/>
                            </p>
                            <p>
                                <label><span class="bangla">ইমেইল </span>(E-mail)</label>
                                <input class="sf email" name="respondent_present_email[]" type="text" value="<?php echo $respondentItem['respondent_present_email']; ?>" style="width:175px;"/>
                            </p>         
                        </div></td>
                </tr>
            </table>
            <?php
            if (modules::run('auth/haveEditPermission', $complaintInfo->complaint_id))
            {
                ?>
                <div style="font-size:16px;text-align:right;"><a class="remRespondent" rel="<?php echo $respondentItem['respondent_id']; ?>" href="#rem">[-] Remove</a></div>
            <?php } ?>
        </fieldset>
    <?php endforeach; ?>

    <?php
    if (modules::run('auth/haveEditPermission', $complaintInfo->complaint_id))
    {
        ?>
        <?php
        if (count($respondent) > 0)
        {
            ?>
            <div style="font-size:16px;text-align:right;"><a href="#addEQU" id="addEQU" class="btn">+ Add More Response</a></div>
            <div id="duplicateQuablock" style="display:none;">
                <?php
            }
        }
        ?>

        <!-- Fieldset -->
        <fieldset id="blockRespond">
            <legend> <span class="bangla">অভিযুক্ত ব্যক্তি/ব্যক্তিগন/প্রতিষ্ঠানের তথ্য </span>(Information About Respondent Person(s)/Organization(s))</legend>
            <p>
                <label><span class="bangla">অভিযুক্ত </span>(Respondent Type)</label>
                <select name="rbtRespondentType[]" class="dropdown" id="rbtRespondentType" style="width:200px;">
                    <option value="0" selected="selected">Select</option>
                    <option value="person">Person</option>
                    <option value="organization">Organization</option>
                </select>
            </p>
            <p>
                <label><span class="bangla">নাম </span>(Name)<span class="red">*</span></label>
                <input name="respondent_name[]" type="text" class="lf required" maxlength="150"/>
            </p>
            <p>
                <label for="dropdown"><span class="bangla">পদবী </span>(Designation)</label>
                <input name="respondent_designation[]" type="text" class="lf" id="respondent_designation" maxlength="120"/>
            </p>
            <p>
                <label><span class="bangla">পিতার নাম </span>(Father's Name)</label>
                <input name="father_name[]" type="text" class="lf" id="father_name" maxlength="150"/>
            </p>
            <p>
                <label><span class="bangla">মাতার নাম </span>(Mother's Name)</label>
                <input name="mother_name[]" type="text" class="lf" id="mother_name" maxlength="150"/>
            </p>
            <p>
                <label><span class="bangla">স্বামী/স্ত্রীর নাম </span>(Spouse's Name)</label>
                <input name="spouse_name[]" type="text" class="lf" id="spouse_name" maxlength="150"/>
            </p>
            <p><span class="bangla">শৃঙ্খলা বাহিনীর কোন সদস্যের বিরুদ্ধে অভিযোগ কিনা? </span> <br />
                ( Is this a complaint against any member of the disciplined force?)
                <select name="deciplin_force[]" class="dropdown" id="deciplin_force" style="width:200px;">
                    <option value="0" selected="selected">Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>    
            </p>
            <div id="divForceYes">
                <p>
                    <label style="width:300px">Select Type of Disciplined Force</label>
                    <select name="decipline_force_member_yes[]" class="dropdown" id="decipline_force_member_yes" style="width:340px;">
                        <option value="0" selected="selected">Select</option>
                        <?php
                        foreach ($desciplinedForce as $item)
                        {
                            if ($item['id'] == $decipline_force_member_yes)
                            {
                                ?>
                                <option value="<?php echo $item['id']; ?>" selected="selected"><?php echo $item['varName']; ?></option>
                                <?php
                            } else
                            {
                                ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo $item['varName']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </p>
            </div>
            <div id="divForceNo">
                <p>
                    <label style="width:300px">or, Select Against Type</label>
                    <select name="respondent_member_decipline_no[]" class="dropdown" id="respondent_member_decipline_no" style="width:340px;">
                        <option value="0" selected="selected">Select</option>
                        <?php
                        foreach ($againstRespondentType as $item)
                        {
                            if ($item['id'] == $respondent_member_decipline_no)
                            {
                                ?>
                                <option value="<?php echo $item['id']; ?>" selected="selected"><?php echo $item['varName']; ?></option>
                                <?php
                            } else
                            {
                                ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo $item['varName']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </p>
            </div>
            <p>
                <label style="width:300px">or, Other Type</label>
                <input name="others_respondent[]" type="text" class="lf" id="others_respondent" maxlength="150"/>
            </p>
            <table width="100%" border="0">
                <tr>
                    <td width="50%"><div class="inpcol">
                            <h2><span class="bangla">স্থায়ী ঠিকানা </span>(Permanent Address)</h2>
                            <p>
                                <label><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label>
                                <input name="respondent_permanent_village[]" type="text" class="sf" id="respondent_permanent_village" style="width:175px;" maxlength="120"/>
                            </p>
                            <p>
                                <label><span class="bangla"> জেলা </span>(District)</label>				
                                <select id="permanent_district" name="permanent_district[]" class="dropdown" style="width:185px;">
                                    <option value="0">Select</option>
                                    <?php
                                    foreach ($get_district as $row)
                                    {
                                        ?>
                                        <option value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
                                    <?php } ?>
                                </select>

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
                            </p>
                            <p>
                                <label><span class="bangla">থানা </span>(Thana/Upazilla)</label>

                                <select id="permanent_sub_district" name="permanent_sub_district[]" class="dropdown" style="width:185px;">
                                    <option value="0">Select</option>
                                </select>
                            </p>
                            <p>
                                <label><span class="bangla">ফোন </span>(Phone/Mobile)</label>
                                <input name="respondent_permanent_phone[]" type="text" class="sf" id="respondent_permanent_phone" style="width:175px;" maxlength="30"/>
                            </p>
                            <p>
                                <label><span class="bangla">ফ্যাক্স </span>(FAX)</label>
                                <input name="respondent_permanent_fax[]" type="text" class="sf" id="respondent_permanent_fax" style="width:175px;" maxlength="30"/>
                            </p>
                            <p>
                                <label><span class="bangla">ইমেইল </span>(E-mail)</label>
                                <input name="respondent_permanent_email[]" type="text" class="sf email" id="respondent_permanent_email" style="width:175px;" maxlength="120"/>
                            </p>
                            <p> </p>
                        </div></td>
                    <td><div class="inpcol">
                            <h2><span class="bangla">বর্তমান ঠিকানা </span>(Present Address)</h2>
                            <p>
                                <label><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)</label>
                                <input name="respondent_present_village[]" type="text" class="sf" id="respondent_present_village" style="width:175px;" maxlength="120"/>
                            </p>
                            <p>
                                <label><span class="bangla"> জেলা </span>(District)</label>				
                                <select id="present_district" name="present_district[]" class="dropdown" style="width:185px;">
                                    <option value="0">Select</option>
                                    <?php
                                    foreach ($get_district as $row)
                                    {
                                        ?>
                                        <option value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
                                    <?php } ?>
                                </select>

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

                            </p>
                            <p>
                                <label><span class="bangla">থানা </span>(Thana/Upazilla)</label>
                                <select id="present_sub_district" name="present_sub_district[]" class="dropdown" style="width:185px;">
                                    <option value="0">Select</option>
                                </select>
                            </p>
                            <p>
                                <label><span class="bangla">ফোন </span>(Phone/Mobile)</label>
                                <input class="sf" name="respondent_present_phone[]" type="text" style="width:175px;"/>
                            </p>
                            <p>
                                <label><span class="bangla">ফ্যাক্স </span>(FAX)</label>
                                <input class="sf" name="respondent_present_fax[]" type="text" style="width:175px;"/>
                            </p>
                            <p>
                                <label><span class="bangla">ইমেইল </span>(E-mail)</label>
                                <input class="sf email" name="respondent_present_email[]" type="text" style="width:175px;"/>
                            </p>
                            <p> </p>
                        </div></td>
                </tr>
            </table>
            <?php
            if (modules::run('auth/haveEditPermission', $complaintInfo->complaint_id))
            {
                ?>
                <div style="font-size:16px;text-align:right;"><a id="minus2" href="">[-] Remove</a> <a id="plus2" href="">[+] Add More Respondent</a></span></div>
            <?php } ?>
        </fieldset>  
        <?php
        if (count($respondent) > 0)
        {
            ?>
        </div>
    <?php } ?>

    <?php
    if (modules::run('auth/haveEditPermission', $complaintInfo->complaint_id))
    {
        ?>
        <p>
        <div id="tempMsg"></div>
        <input class="button" type="submit" value="Save" />
        <input class="button" type="reset" value="Reset" />
        <input type="hidden" name="complaint_id" value="<?php echo $complaintInfo->complaint_id; ?>"/>
    </p>


    <script type="text/javascript" src="<?php echo site_url('assets/js/jquery-dynamic-form.js'); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {		
                		
            var options = {
                type: 'POST',
                async: false,
                target: '#showMsg', 
                beforeSubmit: function() {},
                success: function(data) {}
            };	
                		
            jQuery("#frmRespondentTab").validate({
                submitHandler: function(form) {
                    jQuery(form).ajaxSubmit(options);
                }
            });

            $("#blockRespond").dynamicForm("#plus2", "#minus2", {limit:10});
                		
            $("#addEQU").click(function() {
                $('#duplicateQuablock').toggle();    
                return false;
            });
                		
                		
            $("a.remRespondent").click(function() { 
                if(confirm('Are you sure you want to delete respondent data? You have to save this data after remove this data'))
                {
                    $(this).closest('fieldset').fadeTo(400, 0, function () { 
                        $(this).slideUp(100);
                        $(this).remove();
                    });
                    $("#tempMsg").html('* You have to save this data for apply changes').addClass('red').wrap('<p>');
                				
                    return false;
                } else {
                    return false;
                }
            });
                                
            $('#rbtRespondentType').change(function() {
                            
                if($('#rbtRespondentType').val()== "organization")
                {  
                    $("#father_name").attr("disabled", "disabled"); 
                    $("#mother_name").attr("disabled", "disabled"); 
                    $("#spouse_name").attr("disabled", "disabled"); 
                    $("#respondent_designation").attr("disabled", "disabled"); 
                        
                }
                else
                {
                    $("#father_name").removeAttr("disabled");
                    $("#mother_name").removeAttr("disabled");
                    $("#spouse_name").removeAttr("disabled");
                    $("#respondent_designation").removeAttr("disabled");
                }
            });
                
                
                
            $('#deciplin_force').change(function() {                         
                if($('#deciplin_force').val()== "yes")
                {                         
                    $("#respondent_member_decipline_no").attr("disabled", "disabled"); 
                    $("#decipline_force_member_yes").removeAttr("disabled");
                }
                else
                {
                    $("#decipline_force_member_yes").attr("disabled", "disabled"); 
                    $("#respondent_member_decipline_no").removeAttr("disabled"); 
                }
            });
                                
        });
    </script>
<?php } ?>
<!-- End of fieldset -->
</form>
