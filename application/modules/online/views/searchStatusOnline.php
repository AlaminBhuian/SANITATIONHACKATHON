<script>
    $(document).ready(function(){
        $("#frmWebComplaintSearch").validate();
    });
</script>

<div id="bgwrap">
    <!-- Main Content -->
    <div id="full-content">
        <div id="full-main">
            <fieldset>
                <legend><span class="bangla"></span>Track Your Complaint</legend>
                <form id="frmWebComplaintSearch" name="frmWebComplaintSearch" action="<?php echo base_url(); ?>online/searchResult" method="post">
                    <p>
                        <label for="lf">Complaint Tracking Number<span style="color: red;">*</span></label>
                        <input class="lf required" name="tracking_number" type="text" value="<?php echo set_value('tracking_number'); ?>" />
                    </p>                    
                    <p>
                        <label for="lf">Captcha <span style="color: red;"></span></label>
                        <label><?php echo form_error('captcha'); ?> <?php echo $captcha['image']; ?> 
</label>
                    </p>
                    <p>
                        <label for="lf">Enter The Captcha<span style="color: red;">*</span></label>
                        <input class="lf required" name="captcha" type="text" value="" />
                        <input type="hidden" name="captcha_word" value="<?php echo $captcha['word'];?>">
                    </p>

                    <p>
                        <input class="button" type="submit" value="Search" />


                    </p>
                </form>
            </fieldset>
            <h2><?php echo $this->session->flashdata('exception');?></h2>
        </div>
    </div>
</div>
