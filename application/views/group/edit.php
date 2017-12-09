<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<h1>Edit Group</h1>

	<?php if ($this->session->flashdata("msg") != null): ?>
		<div class="alert alert-info">
			<?php echo $this->session->flashdata("msg")?>
		</div>
	<?php endif; ?>

	<?php echo form_open_multipart('group/edit_process', 'class="form-horizontal"')?>
		<?php echo form_hidden("group_id", $group_id)?>
		<div class="form-group">
			<label class="control-label col-sm-2" for="name"><i class="fa fa-asterisk" aria-hidden="true"></i> Group Name:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="name" name="name" placeholder="Enter group name" value="<?php echo $tentang["name"] ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="description"><i class="fa fa-asterisk" aria-hidden="true"></i> Group Description:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="description" name="description" placeholder="Enter group description"  value="<?php echo $tentang["description"] ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="upload-foto">Group Image:</label>
			<div class="col-sm-10">
				<input id="upload-foto" name="upload-foto" type="file">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="admin"><i class="fa fa-asterisk" aria-hidden="true"></i> Group Admin:</label>
			<div class="col-sm-10">
				<?php echo form_dropdown('admin', $member, $tentang["user_id"], "id='admin' class='form-control'");?>
				<small>Setelah anda mengedit admin, anda tidak dapat mengubah group lagi.</small>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<small><i class="fa fa-asterisk" aria-hidden="true"></i> =  Harus di isi</small>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Edit Group</button>
			</div>
		</div>
	<?php echo form_close()?>
</div>

<script>
	$("#upload-foto").fileinput({showUpload: false});
</script>
<?php $this->load->view('layout/footer.php');
