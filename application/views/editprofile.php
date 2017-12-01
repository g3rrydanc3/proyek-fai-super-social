<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<h1>Edit Profile</h1>
	<?php if ($this->session->flashdata('errors') != null): ?>
		<div class="alert alert-danger">
		  <?php echo $this->session->flashdata('errors'); ?>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">Profile Picture</div>
				<div class="panel-body">
					<div class="kv-avatar">
						<div class="file-loading">
							<input id="avatar-2" name="userfile" type="file" required>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Profile Music</div>
				<div class="panel-body">
					<?php if ($this->session->flashdata("uploaderror")): ?>
						<div class="alert alert-danger">
							<?php echo $this->session->flashdata("uploaderror");?>
						</div>
					<?php endif; ?>
					<?php echo form_open_multipart("profile/upload_music");?>
					<input id="upload-music" name="upload-music" type="file">
					<?php echo form_close();?>
				</div>
			</div>

		</div>
		<div class="col-sm-8">
			<?php echo form_open('profile/edit_profile_process', 'class="form-horizontal"');?>
			<div class="form-group">
				<label class="control-label col-sm-2" for="alamat"><i class="fa fa-asterisk" aria-hidden="true"></i> Alamat:</label>
				<div class="col-sm-10">
					<textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Enter alamat"><?php echo $alamat;?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="kodepos">Kode Pos:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="kodepos" name="kodepos" placeholder="Enter kode pos" value="<?php echo $kodepos;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="negara"><i class="fa fa-asterisk" aria-hidden="true"></i> Negara:</label>
				<div class="col-sm-10">
					<?php echo country_dropdown('negara', 'negara', 'form-control', $negara, array('ID'), '');?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="jabatan"><i class="fa fa-asterisk" aria-hidden="true"></i> Jabatan:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Enter jabatan" value="<?php echo $jabatan;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="perusahaan"><i class="fa fa-asterisk" aria-hidden="true"></i> Perusahaan:</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="perusahaan" name="perusahaan" placeholder="Enter perusahaan" value="<?php echo $perusahaan;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="bioperusahaan">Bio Perusahaan :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="bioperusahaan" name="bioperusahaan" placeholder="Enter bio perusahaan" value="<?php echo $bioperusahaan;?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="biouser">Bio User :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="biouser" name="biouser" placeholder="Enter bio user" value="<?php echo $biouser;?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
			    		<label><input type="checkbox" name="private" value="1" <?php if ($private == 1) {echo "checked";};?>> Private</label>
			  		</div>
		  		</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<small><i class="fa fa-asterisk" aria-hidden="true"></i> =  Harus di isi</small>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default" name="editprofile" value="Edit">Edit</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$("#avatar-2").fileinput({
    overwriteInitial: true,
    maxFileSize: 0,
    showClose: false,
    showCaption: false,
    showBrowse: false,
    browseOnZoneClick: true,
    removeLabel: '',
    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
    removeTitle: 'Cancel or reset changes',
    elErrorContainer: '#kv-avatar-errors-2',
    msgErrorClass: 'alert alert-block alert-danger',

    defaultPreviewContent:
	 <?php if ($img != null): ?>
		 '<img src="<?php echo base_url()."uploads/". $img;?>" class="img-responsive img-rounded img-center" alt="<?php echo $namadepan . ' ' . $namabelakang;?>">'
	 <?php else: ?>
		 '<div class="profile-picture-default unselectable form-group"><?php echo strtoupper($namadepan[0].$namabelakang[0]);?></div>'
	 <?php endif; ?>
	 +'<h6 class="text-muted text-center">Click to select,<br>refresh after done.</h6>',
    layoutTemplates: {main2: '{preview} {remove} {browse}'},
    allowedFileExtensions: ["jpg", "png", "gif", "csv"],
	 uploadUrl: "<?php echo site_url("profile/upload_foto");?>"
});
$('#avatar-2').on('fileuploaderror', function(event, data, msg) {
	 var form = data.form, files = data.files, extra = data.extra,
		  response = data.response, reader = data.reader;
	 console.log('File upload error');
	// get message
	alert(msg);
});
$('#avatar-2').on('fileuploaded', function(event, data, previewId, index) {
	 var form = data.form, files = data.files, extra = data.extra,
		  response = data.response, reader = data.reader;
	 console.log('File uploaded triggered');
});
$('#upload-music').fileinput({
	defaultPreviewContent: "\
	<audio controls>\
		<source src='<?php echo base_url()."uploads/". $music;?>'>\
		Your browser does not support the audio element.\
	</audio>\
	<p class='text-center text-muted'><?php echo $music_ori;?></p>",
	showCaption:false,
	showRemove:false
});
</script>
<?php $this->load->view('layout/footer.php');
