<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<h1>Create Group</h1>

	<?php if ($this->session->flashdata("msg") != null): ?>
		<div class="alert alert-info">
			<?php echo $this->session->flashdata("msg")?>
		</div>
	<?php endif; ?>

	<?php echo form_open_multipart('group/create_process', 'class="form-horizontal"')?>
		<div class="form-group">
			<label class="control-label col-sm-2" for="email"><i class="fa fa-asterisk" aria-hidden="true"></i> Group Name:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="name" name="name" placeholder="Enter group name" value="<?php if(isset($this->session->flashdata("data_post")["name"])) echo $this->session->flashdata("data_post")["name"] ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="email"><i class="fa fa-asterisk" aria-hidden="true"></i> Group description:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="description" name="description" placeholder="Enter group description"  value="<?php if(isset($this->session->flashdata("data_post")["description"])) echo $this->session->flashdata("data_post")["description"] ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="email">Group description:</label>
			<div class="col-sm-10">
				<input id="upload-foto" name="upload-foto" type="file">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<small><i class="fa fa-asterisk" aria-hidden="true"></i> =  Harus di isi</small>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Create Group</button>
			</div>
		</div>
	<?php echo form_close()?>
</div>

<script>
	$("#upload-foto").fileinput({showUpload: false});
</script>
<?php $this->load->view('layout/footer.php');
