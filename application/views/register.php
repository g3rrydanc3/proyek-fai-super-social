<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<?php if ($this->session->flashdata('errors') != null): ?>
		<div class="alert alert-danger">
		  <?php echo $this->session->flashdata('errors'); ?>
		</div>
	<?php endif; ?>
	<?php echo form_open('user/register_process', 'class="form-horizontal"');?>
		<h1 class="form-signin-heading">Register</h1>
		<div class="form-group">
			<label class="control-label col-sm-2" for="namadepan"><i class="fa fa-asterisk" aria-hidden="true"></i> Nama Depan:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="namadepan" name="namadepan" placeholder="Enter nama depan">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="namabelakang"><i class="fa fa-asterisk" aria-hidden="true"></i> Nama Belakang</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="" name="namabelakang" placeholder="Enter nama belakang">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="email"><i class="fa fa-asterisk" aria-hidden="true"></i> Email:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="nohp"><i class="fa fa-asterisk" aria-hidden="true"></i> Nomor handphone</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="nohp" name="nohp" placeholder="Enter nomor handphone">
			</div>
		</div>
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
				<small><i class="fa fa-asterisk" aria-hidden="true"></i> =  Harus di isi</small>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default" name="r_register" value="Register">Register</button>
			</div>
		</div>
	<?php echo form_close();?>
</div>
<?php $this->load->view('layout/footer.php');
