<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
	<?php if ($this->session->flashdata('goodbye') != null): ?>
		<div class="alert alert-success">
		  <?php echo $this->session->flashdata('goodbye'); ?>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('errors') != null): ?>
		<div class="alert alert-danger">
		  <?php echo $this->session->flashdata('errors'); ?>
		</div>
	<?php endif; ?>
	<?php echo form_open('cont/login_process', 'class="form-horizontal"');?>
		<h1 class="form-signin-heading">Login</h1>
		<div class="form-group">
			<label class="control-label col-sm-2" for="email">Email / Phone Number:</label>
			<div class="col-sm-10">
			<input type="email" class="form-control" id="email" name="emailhp" placeholder="Enter email / phone number">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="pwd">Password:</label>
			<div class="col-sm-10">
			<input type="password" class="form-control" id="pwd" name="password" placeholder="Enter password">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-primary" name="l_login" value="Login">Login</button>
			<a href="<?php echo site_url("cont/register");?>"<button type="submit" class="btn btn-info">Register</button></a>
			</div>
		</div>
	<?php echo form_close();?>

<?php $this->load->view('layout/footer.php');
