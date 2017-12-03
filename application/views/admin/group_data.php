<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view("layout/header");?>

<div class="container wrapper">
	<div class="row">
		<div class="col-sm-3">
			<?php $this->load->view("admin/sidebar")?>
		</div>
		<div class="col-sm-9">
			<?php if ($this->session->flashdata("errors") != null): ?>
				<div class="container alert alert-danger" style="margin-top:20px;">
					<?php echo $this->session->flashdata("errors")?>
				</div>
			<?php endif; ?>

			<?php if ($this->session->flashdata("msg") != null): ?>
				<div class="container alert alert-info" style="margin-top:20px;">
					<?php echo $this->session->flashdata("msg")?>
				</div>
			<?php endif; ?>
			<?php echo form_open('admin/group_data_process', 'class="form-horizontal"');?>
				<?php echo form_hidden("group_id", $group_data["group_id"])?>
				<h1 class="form-signin-heading">Edit Group "<?php echo $group_data["name"]?>"</h1>
				<div class="form-group">
					<label class="control-label col-sm-2" for="id"><i class="fa fa-asterisk" aria-hidden="true"></i> ID:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="id" disabled value="<?php echo $group_data["group_id"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="user_id"><i class="fa fa-asterisk" aria-hidden="true"></i> ID User yang membuat:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $group_data["user_id"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="name"><i class="fa fa-asterisk" aria-hidden="true"></i> Nama:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="name" name="name" value="<?php echo $group_data["name"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="description">Deskripsi:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="description" name="description" value="<?php echo $group_data["description"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="img">Image:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="img" name="img" value="<?php echo $group_data["img"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="datetime"><i class="fa fa-asterisk" aria-hidden="true"></i> Tanggal pembuatan:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="datetime" name="datetime" value="<?php echo $group_data["datetime"];?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<small><i class="fa fa-asterisk" aria-hidden="true"></i> =  Harus di isi</small>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default" value="Register">Edit</button>
					</div>
				</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>

<?php $this->load->view("layout/footer");?>
