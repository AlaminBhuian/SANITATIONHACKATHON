<div id="bgwrap">
  <div id="full-content">
    <div id="full-main">
      <h1>Complaint Entry &amp; Process </h1>
      <div class="pad20">
        <?php if (validation_errors()) : ?>
        <div class="msg-error"> <?php echo validation_errors(); ?> </div>
        <?php endif; ?>
        <?php if (isset($errMsg)) : ?>
        <div class="msg-error"><?php echo $errMsg; ?> </div>
        <?php endif; ?>
        <form action="<?php echo site_url('complaint/saveNewComplaint');?>" method="post" name="frmNewComplaint" id="frmNewComplaint">
          <fieldset>
          <legend><span class="bangla">অভিযোগকারীর বিবরণ </span>(Information about the complainant) </legend>
          <p>
            <label><span class="bangla">অভিযোগকারী</span>(Complainant)<span class="red"> *</span></label>
            <select name="complainant" class="required dropdown" style="width:370px;">
              <option value="">Select</option>
              <?php  foreach($get_complaint as $item){ ?>
              <option value="<?php echo $item['id'];?>" <?php echo set_select('complainant', $item['id']); ?>><?php echo $item['varName'];?></option>
              <?php }?>
            </select>
          </p>
          <p>
            <label><span class="bangla">নাম</span> (Name)<span class="red"> *</span></label>
            <input name="complaint_name" type="text" class="required lf" maxlength="200" value="<?php echo set_value('complaint_name'); ?>" />
          <p>
          <p>
            <label><span class="bangla">লিঙ্গ </span>(Sex)<span class="red"> *</span></label>
            <select name="sex" class="required dropdown">
              <option selected="selected" value="others">Select</option>
              <option value="male" <?php echo set_select('sex', 'male'); ?>>Male</option>
              <option value="female" <?php echo set_select('sex', 'female'); ?>>Female</option>
              <option value="others" <?php echo set_select('sex', 'others'); ?>>Others</option>
            </select>
          </p>
          <p>
          <h2><span class="bangla">যোগাযোগের ঠিকানা </span>(Contact Information)</h2>
          <p>
            <label><span class="bangla">ঠিকানা </span> (Address)<span class="red"> *</span></label>
            <textarea name="address" rows="3" class="required lf" style="height:40px; width:360px;"><?php echo set_value('address'); ?></textarea>
          </p>
          <p>
            <label><span class="bangla">ফোন </span>(Phone/Mobile)</label>
            <input name="phone" type="text" class="lf" value="<?php echo set_value('phone'); ?>" maxlength="60" />
          </p>
          <p>
            <label><span class="bangla">ফ্যাক্স </span>(FAX)</label>
            <input name="fax" type="text" class="lf" value="<?php echo set_value('fax'); ?>" maxlength="60" />
          </p>
          <p>
            <label><span class="bangla">ইমেইল </span>(E-mail)</label>
            <input name="email" type="text" class="email lf" value="<?php echo set_value('email'); ?>" maxlength="150" />
          <p>
          <p>
            <label><span class="bangla"> ঘটনার সংক্ষিপ্ত বর্ণনা </span>(Summarized Description of the Incident)<span class="red"> *</span></label>
            <textarea class="required wysiwyg" name="description" style="width:600px;height:70px;"><?php echo set_value('description'); ?></textarea>
          </p>
          <p>
            <input class="button" type="submit" value="Submit Complaint" />
            <input class="button" type="reset" value="Clear" />
          </p>
          </fieldset>
        </form>
      </div>
    </div>
    <hr />
  </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
	   $('#frmNewComplaint').validate();
  });
</script>
