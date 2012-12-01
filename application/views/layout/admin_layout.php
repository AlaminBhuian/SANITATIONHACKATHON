<?php $this->load->view('header'); ?>
<div id="bgwrap">
  <div id="content">
    <div id="main"> <?php echo $content_for_layout; ?> </div>
  </div>
 
  <?php $this->load->view('sidebar-left-settings'); ?>
 
</div>
<?php $this->load->view('footer'); ?>

