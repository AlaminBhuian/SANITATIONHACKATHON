<form action="<?php echo site_url('users/login'); ?>" method="POST" name="frmUserLogin" id="frmUserLogin">
  <p class="main">
    <label>User Name: </label>
    <input name="txtUserName" id="txtUserName" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;" value="login user name" maxlength="30" minlength="3" class="input required"/>
    <label>Password: </label>
    <input name="txtPassword" type="password" id="txtPassword" onFocus="if(this.value==this.defaultValue)this.value='';" onBlur="if(this.value=='')this.value=this.defaultValue;" value="amiya" maxlength="30" minlength="5" class="input required"/>
  </p>
  <p class="space">
    <input value="Login" class="login" type="submit" />
  </p>
</form>
<br />
<?php if(validation_errors()) { ?>
<div class="msg-error"><?php echo validation_errors(); ?></div>
<?php } ?>
<?php if(isset($msg)) { ?>
<div class="msg-error"><?php echo $msg; ?></div>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#frmUserLogin").validate();
	 });
</script>
