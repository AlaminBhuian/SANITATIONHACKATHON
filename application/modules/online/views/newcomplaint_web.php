<!-- Header -->

<!-- End of Header -->
<!-- Background wrapper -->
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.relatedselects.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {		
        $("#frmComplaintTab1").relatedSelects({
            onChangeLoad: '<?php echo site_url('complaint/datasupplier/') ?>',
            loadingMessage: 'Please wait',
            selects: ['permanent_district', 'permanent_sub_district']
        });
                
        $("#frmComplaintTab1").relatedSelects({
            onChangeLoad: '<?php echo site_url('complaint/datasupplier2/') ?>',
            loadingMessage: 'Please wait',
            selects: ['present_district', 'present_sub_district']
        });
    });	
</script>

<script>
    $(document).ready(function(){
        $("#frmWebComplaintTab").validate();
    });
</script>
<div id="bgwrap">
    <!-- Main Content -->
    <div id="full-content">
        <div id="full-main">
            <h1><span class="bangla">অভিযোগ দায়ের ফরম</span>(Complaint Form)</h1>
            <div class="pad20">
                <h2><?php echo $this->session->flashdata('exception'); ?></h2>
                <!-- Form -->
                <form method="post" name="frmWebComplaintTab" id="frmWebComplaintTab" action="<?php echo site_url(); ?>online/submit_web_complaint">
                    <?php echo validation_errors(); ?>


                    <!-- Fieldset -->
                    <fieldset>
                        <legend><span class="bangla">অভিযোগকারীর বিবরণ</span>(Complainant's Info) </legend>

                        <p><label class="lf"><span class="bangla">অভিযোগকারী </span>(Complainant)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="complainant" class="dropdown required">
                                <option selected="selected" value="">Select</option>
                                <?php
                                foreach ($get_complaint as $complaint_data)
                                {
                                    if ($complaint_data['intBasicCategoryId'] == 4)
                                    {
                                        ?>
                                        <option  value="<?php echo $complaint_data['id']; ?>" ><?php echo $complaint_data['varName']; ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </p>

                        <p>
                            <label for="lf"><span class="bangla">নাম </span>(Name)<span style="color: red;">*</span></label>
                            <input class="lf required" name="complaint_name" type="text" value="<?php echo set_value('complaint_name'); ?>" />
                        </p>
                        <p>
                            <label for="lf"><span class="bangla">পিতার নাম </span>(Father/Spouse's Name)</label>
                            <input class="lf" name="complaint_father_name" type="text" value="<?php echo set_value('complaint_father_name'); ?>"/>
                        </p>
                        <p>
                            <label for="lf"><span class="bangla">মাতার নাম </span>(Mother's Name)</label>
                            <input class="lf" name="complaint_mother_name" type="text" value="<?php echo set_value('complaint_mother_name'); ?>"/>
                        </p>
                        <p>
                            <label for="dropdown"><span class="bangla">লিঙ্গ </span>(Sex)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="complaint_sex" class="dropdown required">
                                <option selected="selected" value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Other</option>
                            </select>
                        </p>
                        <p>
                        <h2><span class="bangla">যোগাযোগের ঠিকানা </span>(Contact  Address)</h2>
                        <p>
                            <label for="sf"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড </span> (Village/Moholla/Road No.)<span style="color: red;">*</span></label>
                            <input class="lf required" name="complaint_village" type="text" value="<?php echo set_value('complaint_village'); ?>"/>
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">জেলা</span>(District)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="complaint_district" class="dropdown required" >
                                <option value="">Select</option>
                                <?php
                                foreach ($get_district as $row)
                                {
                                    ?>
                                    <option value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
                                <?php } ?>                
                            </select>
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">থানা</span>(Sub-district)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="complaint_sub_district" class="dropdown required">
                                <option value="">Select</option>
                            </select>
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">ফোন </span>(Phone/Mobile)<span style="color: red;">*</span></label>
                            <input class="lf required" name="complaint_phone" type="text" value="<?php echo set_value('complaint_phone'); ?>" />
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">ফ্যাক্স </span>(FAX)</label>
                            <input class="lf" name="complaint_fax" type="text" value="<?php echo set_value('complaint_fax'); ?>"/>
                        </p>
                        <p>
                            <label for="lf"><span class="bangla">ইমেইল </span>(E-mail)</label>
                            <input class="lf" name="complaint_email" type="text" value="<?php echo set_value('complaint_email'); ?>"/>
                        <p>

                        </p>
                    </fieldset>
                    <fieldset>
                        <legend> <span class="bangla"> ক্ষতিগ্রস্ত ব্যক্তি সংক্রান্ত তথ্য </span>(Information About the Victim) </legend>
                        <p>
                            <label for="lf"><span class="bangla">ক্ষতিগ্রস্ত ব্যক্তির নাম </span>(Name)<span style="color: red;">*</span></label>
                            <input class="lf required" name="victims_name" type="text" value="<?php echo set_value('victims_name'); ?>">
                        </p>
                        <p>
                            <label for="lf"><span class="bangla">পিতার নাম </span>(Father's Name)</label>
                            <input class="lf" name="victims_father_name" type="text" value="<?php echo set_value('victims_father_name'); ?>"/>
                        </p>
                        <p>
                            <label for="lf"><span class="bangla">মাতার নাম </span>(Mother's Name)</label>
                            <input class="lf" name="victims_mother_name" type="text" value="<?php echo set_value('victims_mother_name'); ?>"/>
                        </p>

                        <p>
                            <label for="lf"><span class="bangla">স্বামী/স্ত্রীর নাম </span>(Spouse's Name)</label>
                            <input class="lf" name="victims_spouse_name" type="text" value="<?php echo set_value('victims_spouse_name'); ?>" />
                        </p>

                        <p>
                            <label for="dropdown"><span class="bangla">লিঙ্গ </span>(Sex)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="victims_sex" class="dropdown required">
                                <option selected="selected">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Other</option>
                            </select>
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">বয়স </span>(Age)<span style="color: red;">*</span></label>

                            <input class="lf required" name="victims_age" type="text" value="<?php echo set_value('victims_age'); ?>"/>
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">ধর্ম </span>(Religion)</label>                           
                            <select name="victims_religion" class="dropdown" style="width: 250px;">
                                <option selected="selected" value="0">Select</option>
                                <?php foreach ($religionList as $religion)
                                { ?>
                                    <option value="<?php echo $religion['id']; ?>"><?php echo $religion['varName']; ?></option>
<?php } ?>
                            </select>
                        </p>
                        <p>
                            <span class="lable"><span class="bangla">আপনি কি কোনো আদিবাসী সম্প্রদায়ের একজন সদস্য? </span>(Are you a member of any indigenous community?)</span>
                            <input type="radio" name="victims_community" value="yes"/>
                            Yes 
                            <input type="radio" name="victims_community" value="no" checked="checked"/>
                            No     
                        </p>


                        <p>
                            <span class="lable"><span class="bangla">প্রতিবন্ধী কী না? </span>(Is the victim disabled?)</span>
                            <input type="radio" name="victims_disabled" value="yes"/>
                            Yes 
                            <input type="radio" name="victims_disabled" value="no" checked="checked"/>
                            No
                        </p>



                        <h2><span class="bangla">যোগাযোগের ঠিকানা </span>(Contact  Address)</h2>

                        <label for="sf"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড</span>(Village/Moholla/Road No.)</label>
                        <input class="lf" name="victims_village" type="text" value="<?php echo set_value('victims_village'); ?>"/>
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">জেলা</span>(District)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="present_district" class="dropdown required">
                                <option value="">Select</option>
                                <?php
                                foreach ($get_district as $row)
                                {
                                    ?>
                                    <option value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
<?php } ?>
                            </select>
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">থানা</span>(Sub-district)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="present_sub_district" class="dropdown required" id="sub_district">
                                <option value="">Select</option>

                            </select>
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">ফোন </span>(Phone/Mobile)</label>
                            <input class="lf" name="victims_phone" type="text" value="<?php echo set_value('victims_phone'); ?>"/>
                        </p>
                        <p>
                            <label for="sf"><span class="bangla">ফ্যাক্স </span>(FAX)</label>
                            <input class="lf" name="victims_fax" type="text" value="<?php echo set_value('victims_fax'); ?>" />
                        </p>
                        <p>
                            <label for="lf"><span class="bangla">ইমেইল </span>(E-mail)</label>
                            <input class="lf" name="victims_email" type="text" value="<?php echo set_value('victims_email'); ?>" />
                        <p>

                        </p>


                    </fieldset>
                    <fieldset>
                        <legend><span class="bangla">ঘটনাস্থলের বিবরণ </span>(Incident Details) </legend>
                        <p>
                            <label for="sf"><span class="bangla">তারিখ </span>(Date)<span style="color: red;">*</span></label>
                            <input class="sf datePicCal required" name="incident_date" type="text" value="<?php echo set_value('incident_date'); ?>"/>
                            <span class="bangla">সময় </span>(Time)
                            <select name="selTimeHr" class="dropdown" id="selTimeHr" style="width:60px;">
                                <option value="0">Hr</option>
                                <?php
                                for ($i = 1; $i <= 12; $i++)
                                {
                                    ?>
                                    <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <select name="selTimeMin" class="dropdown" id="selTimeMin" style="width:60px;">
                                <option value="0">Min</option>
                                <?php
                                for ($i = 0; $i < 60; $i++)
                                {
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                            </select>
                            <select name="selTimeAMPM" class="dropdown" id="selTimeAMPM" style="width:60px;">
                                <option value="PM" >PM</option>
                                <option value="AM" >AM</option>
                            </select>
                        </p>               

                        <h2><span class="bangla">ঘটনাস্থল </span>(Place of Occurrence)</h2>

                        <p>
                            <label for="lf"><span class="bangla">গ্রাম  </span>(Village)<span style="color: red;">*</span></label>
                            <input class="lf required"  name="incident_village" type="text" value="<?php echo set_value('incident_village'); ?>"/>
                        </p>

                        <p>
                            <label for="lf"><span class="bangla"> জেলা </span>(District)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="incident_district" class="dropdown required">
                                <option value="">Select</option>
                                <?php
                                foreach ($get_district as $row)
                                {
                                    ?>
                                    <option value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
<?php } ?>
                            </select>
                        </p>
                        <p>
                            <label for="lf"><span class="bangla">থানা </span>(Sub-district)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="incident_sub_district" class="dropdown required">
                                <option value="">Select</option>
                            </select>
                        </p>



                        <p>
                            <strong><span class="bangla">ঘটনার সংক্ষিপ্ত বিবরণ </span>(Brief summary of Facts)<span style="color: red;">*</span></strong><br>

                            <!-- WYSIWYG editor -->
                            <textarea cols="80" rows="5" style="min-height: 50px;" class="wysiwyg required" name="incident_summary" ><?php echo set_value('incident_summary'); ?></textarea>
                            <!-- End of WYSIWYG editor -->    
                        </p>  
                        <p> <span class="bangla">কোন থানা বা আদালতে অভিযোগ দায়ের করা হয়েছে কি না? </span> (Has the complaint been filed with any thana or Court?)
                            <input type="radio" name="incident_case" value="yes"/>Yes <input type="radio" name="incident_case" value="no" checked="checked"/>No                  
                        </p>
                    </fieldset>

                    <fieldset>
                        <legend> <span class="bangla">যার বিরুদ্ধে অভিযোগ </span>(Respondent)</legend>
                        <p>
                            <label for="lf"><span class="bangla">নাম </span>(Name)<span style="color: red;">*</span></label>
                            <input class="lf required" name="respondent_name" type="text" value="<?php echo set_value('respondent_name'); ?>"/>
                        </p>
                        <p>
                            <label for="lf"><span class="bangla">পদবী </span>(Designation)</label>
                            <input class="lf" name="respondent_designation" type="text" value="<?php echo set_value('respondent_designation'); ?>"/>
                        </p>

                        <h2><span class="bangla">ঠিকানা </span>(Address)</h2>

                        <p>
                            <label for="lf"><span class="bangla">গ্রাম/এলাকা/ওয়ার্ড</span> <span style="color: red;">*</span></label>
                            <input class="lf required" name="respondent_village" type="text" value="<?php echo set_value('respondent_village'); ?>" />
                        </p>


                        <p>
                            <label  for="lf"><span class="bangla"> জেলা </span>(District)<span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="respondent_district" class="dropdown required">
                                <option value="">Select</option>
                                <?php
                                foreach ($get_district as $row)
                                {
                                    ?>
                                    <option value="<?php echo $row['district_id']; ?>"><?php echo $row['district_name']; ?></option>
<?php } ?>
                            </select>
                        </p>
                        <p>
                            <label for="lf" ><span class="bangla">থানা </span>(Sub-district) <span style="color: red;">*</span></label>
                            <select style="width:250px;"  name="respondent_sub_district" class="dropdown required">
                                <option value="">Select</option>
                            </select>
                        </p>


                        <p>
                            <label for="lf" ><span class="bangla">ফোন </span>(Phone)</label>
                            <input class="lf" name="respondent_phone" type="text" value="<?php echo set_value('respondent_phone'); ?>"/>
                        </p>

                        <p>
                            <label for="lf" ><span class="bangla">ইমেইল </span>(E-mail)</label>
                            <input class="lf" name="respondent_email" type="text" value="<?php echo set_value('respondent_email'); ?>"/>
                        </p>


                        <p>
                            <label for="lf">Captcha<span style="color: red;"></span></label>
                            <label><?php echo form_error('captcha'); ?> <?php echo $captcha['image']; ?></label>
                        </p>
                        <p>
                            <label for="lf">Enter The Captcha<span style="color: red;">*</span></label>
                            <input class="lf required" name="captcha" type="text" value="" />
                            <input type="hidden" name="captcha_word" value="<?php echo $captcha['word']; ?>">
                        </p>    
                    </fieldset>

                    <p>
                        <input class="button" type="submit" value="Submit complaint" />
                        <input class="button" type="reset" value="Reset" />

                    </p>

                    <!-- End of fieldset -->
                </form>
                <!-- End of Form -->
            </div>
            <hr />
        </div>
    </div>
    <!-- End of Main Content -->
</div>
<!-- End of bgwrap -->
<!-- Footer -->

<!-- End of Footer -->
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.relatedselects.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {	
			
        $("#frmWebComplaintTab").relatedSelects({
            onChangeLoad: '<?php echo site_url('online/datasupplier3/'); ?>',
            loadingMessage: 'Please wait',
            selects: ['incident_district', 'incident_sub_district']
        });
                
        $("#frmWebComplaintTab").relatedSelects({
            onChangeLoad: '<?php echo site_url('online/datasupplier2/'); ?>',
            loadingMessage: 'Please wait',
            selects: ['present_district', 'present_sub_district']
        });	
                
        $("#frmWebComplaintTab").relatedSelects({
            onChangeLoad: '<?php echo site_url('online/datasupplier/'); ?>',
            loadingMessage: 'Please wait',
            selects: ['complaint_district', 'complaint_sub_district']
        });
        $("#frmWebComplaintTab").relatedSelects({
            onChangeLoad: '<?php echo site_url('online/datasupplier4/'); ?>',
            loadingMessage: 'Please wait',
            selects: ['respondent_district', 'respondent_sub_district']
        });        
		

		
    });
</script>
