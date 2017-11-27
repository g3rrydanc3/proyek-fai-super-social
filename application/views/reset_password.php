<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
<?php if ($this->session->flashdata("errors")): ?>
	<div class="alert alert-danger">
	  <?php echo $this->session->flashdata("errors"); ?>
	</div>
<?php endif; ?>
<h2>Reset Password</h2>

<?php echo form_open('user/forgot_password_process', 'class="form-horizontal"');?>
	<?php echo form_hidden('user_id', $user_id) ?>
	<?php echo form_hidden('token', $token) ?>
	<div class="form-group">
		<label class="control-label col-sm-2" for="password"><i class="fa fa-asterisk" aria-hidden="true"></i> Password</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="password" name="password" placeholder="Enter password" data-toggle="tooltip" data-html="true" title="password must have at least 6 characters<br>a number<br>an uppercase character<br>a lowercase character<br>a symbol">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="password2"><i class="fa fa-asterisk" aria-hidden="true"></i> Konfirmasi Password:</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="password2" name="password2" placeholder="Enter konfirmasi password">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-primary btn-block" name="editaccount" value="Register">Edit</button>
		</div>
	</div>
<?php echo form_close();?>
</div>
<?php $this->load->view('layout/footer.php');
