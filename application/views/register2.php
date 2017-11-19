<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<?php if ($this->session->flashdata('errors') != null): ?>
	<div class="alert alert-danger">
	  <?php echo $this->session->flashdata('errors'); ?>
	</div>
<?php endif; ?>
<?php echo form_open('cont/register_process', 'class="form-horizontal"');?>
	<h1 class="form-signin-heading">Register</h1>
	<div class="form-group">
		<label class="control-label col-sm-2" for="alamat"><i class="fa fa-asterisk" aria-hidden="true"></i> Alamat:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="alamat" name="alamat" placeholder="Enter alamat">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="kodepos">Kode Pos:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="kodepos" name="kodepos" placeholder="Enter kode pos">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="negara"><i class="fa fa-asterisk" aria-hidden="true"></i> Negara:</label>
		<div class="col-sm-10">
			<?php
				$options = array(
					'Afghanistan'         => 'Afghanistan',
					'Albania'           => 'Albania',
					'Indonesia'         => 'Indonesia'
				);
				echo form_dropdown('negara', $options, 'afghanistan', 'class="form-control" id="negara"');
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="jabatan"><i class="fa fa-asterisk" aria-hidden="true"></i> Jabatan:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Enter jabatan">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="perusahaan"><i class="fa fa-asterisk" aria-hidden="true"></i> Perusahaan:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="perusahaan" name="perusahaan" placeholder="Enter perusahaan">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="bioperusahaan">Bio Perusahaan :</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="bioperusahaan" name="bioperusahaan" placeholder="Enter bio perusahaan">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="biouser">Bio User :</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="biouser" name="biouser" placeholder="Enter bio user">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<small><i class="fa fa-asterisk" aria-hidden="true"></i> =  Harus di isi</small>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-default" name="r2_register" value="Register">Register</button>
		</div>
	</div>
<?php echo form_close();?>

<?php $this->load->view('layout/footer.php');?>
