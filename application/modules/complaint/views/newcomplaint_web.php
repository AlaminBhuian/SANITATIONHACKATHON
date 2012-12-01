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
		
		var options = {
			type: 'POST',
			async: false,
			target: '#showMsg', 
			beforeSubmit: function() {},
			success: function(data) {}
		};	
		
		jQuery("#frmComplaintTab1").validate({
			submitHandler: function(form) {
			   jQuery(form).ajaxSubmit(options);
			}
		});
                
              
     });	
</script>
<div id="bgwrap">
  <!-- Main Content -->
  <div id="full-content">
    <div id="full-main">
      <h1><span class="bangla">শিশু তথ্য নিবন্ধন ফরম</span>(Register Child Information Form)</h1>
      <div class="pad20">
        <!-- Form -->
        <form method="post" action="<?php echo site_url();?>complaint/submit_child_information" id="frmComplaintTab1">
          <div id="showMsg" class=""></div>
           
          <fieldset>
          <legend> <span class="bangla"> শিশু তথ্য নিবন্ধন</span>(Register Child Information) </legend>
          <p>
                <label for="lf"><span class="bangla">জন্ম নিবন্ধন নম্বর </span>(Birth ID Number)</label>
                <input class="lf" name="birth_register_date" type="text" />
              </p>
              <p>
                <label for="lf"><span class="bangla">নাম </span>(Name)</label>
                <input class="lf" name="name" type="text" />
              </p>
              <p>
                <label for="lf"><span class="bangla">পিতার নাম </span>(Father's Name) </label>
                <input class="lf" name="father_name" type="text" />
              </p>
              <p>
                <label for="lf"><span class="bangla">মাতার নাম </span>(Mother's Name)</label>
                <input class="lf" name="mother_name" type="text" />
              </p>
              
              <p>
                <label for="lf"><span class="bangla">জন্ম তারিখ</span>(Date of Birth)</label>
                <input class="lf" name="date_of_birth" type="text" />
              </p>
              
              <p>
                <label for="dropdown"><span class="bangla">লিঙ্গ </span>(Sex)</label>
                <select name="sex" class="dropdown">
                  <option selected="selected">Select</option>
                  <option value="1">Male</option>
                  <option value="2">Female</option>
                  <option value="3">Other</option>
                </select>
              </p>
               <p>
                <label for="sf"><span class="bangla">ঠিকানা </span>(Address)</label>
                
                <input class="lf" name="address" type="text" />
              </p>
               <p>
              <label for="sf"><span class="bangla"> জেলা </span>(District)</label>
              <select name="permanent_district" class="dropdown" id="">
                  <option value="">Select</option>
                <?php foreach ($get_district as $row) {?>
                  <option value="<?php echo $row['district_id'];?>"><?php echo $row['district_name'];?></option>
                  <?php }?>
              </select>
            </p>
            <p>
              <label for="sf"><span class="bangla">থানা </span>(Sub-district) </label>
              <select name="permanent_sub_district" class="dropdown">
                <option>Select</option>
              </select>
            </p>
			

              <p>
                <label for="sf"><span class="bangla">সার্ভে তারিখ </span>(Survey Date)</label>
                <input class="sf datePicCal dateISO" name="survey_date" type="text" value="" />
              </p>
              <p>
				<span class="lable"><span class="bangla">শিক্ষার্থী? </span>(Is Literate?)</span>
                                <input type="radio" name="literacy" value="1"/>
                  Yes 
                  <input type="radio" name="literacy" value="0"/>
                  No
				</p>
              <p>
                <span class="lable"><span class="bangla">টিকা নেয়া হয়েছে কী? </span>(Done Vaccination?)</span>
                <input type="radio" value="1" name="is_vaccination"/>
                  Yes 
                  <input type="radio" value="0" name="is_vaccination"/>
                  No     
              </p>
             
              
              <p>
				<span class="lable"><span class="bangla">প্রতিবন্ধী কী না? </span>(Is disabled?)</span>
                                <input type="radio" name="disabled" value="0"/>
                  Yes 
                  <input type="radio" name="disabled" value="0"/>
                  No
				</p>
              <p>
				<span class="lable"><span class="bangla">পলিও আছে না? </span>(Is Polio infected?)</span>
                                <input type="radio" name="is_polio_infected" value="1"/>
                  Yes 
                  <input type="radio" name="is_polio_infected" value="0"/>
                  No
				</p>
              
             
             <p>
    <input class="button" type="submit" value="Save" />
    <input class="button" type="reset" value="Reset" />
    
  </p>
          </fieldset>
        </form>
        <!-- End of Form -->
      </div>
      <hr />
    </div>
  </div>
  <!-- End of Main Content -->
</div>