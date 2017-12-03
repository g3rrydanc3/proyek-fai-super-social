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
			<?php echo form_open('admin/user_data_process', 'class="form-horizontal"');?>
				<?php echo form_hidden("id", $user_data["id"])?>
				<h1 class="form-signin-heading">Edit User "<?php echo $user_data["namadepan"]. ' '. $user_data["namabelakang"]?>"</h1>
				<div class="form-group">
					<label class="control-label col-sm-2" for="id"><i class="fa fa-asterisk" aria-hidden="true"></i> ID:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="id" disabled value="<?php echo $user_data["id"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="namadepan"><i class="fa fa-asterisk" aria-hidden="true"></i> Nama Depan:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="namadepan" name="namadepan" placeholder="Enter nama depan" value="<?php echo $user_data["namadepan"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="namabelakang"><i class="fa fa-asterisk" aria-hidden="true"></i> Nama Belakang</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="" name="namabelakang" placeholder="Enter nama belakang" value="<?php echo $user_data["namabelakang"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="email"><i class="fa fa-asterisk" aria-hidden="true"></i> Email:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $user_data["email"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="nohp"><i class="fa fa-asterisk" aria-hidden="true"></i> Nomor handphone</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="nohp" name="nohp" placeholder="Enter nomor handphone" value="<?php echo $user_data["nohp"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="password"><i class="fa fa-asterisk" aria-hidden="true"></i> Password</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="password" name="password" placeholder="Enter password" value="<?php echo $user_data["password"];?>" data-toggle="tooltip" data-html="true" title="password must have at least 6 characters<br>a number<br>an uppercase character<br>a lowercase character<br>a symbol">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="alamat"><i class="fa fa-asterisk" aria-hidden="true"></i> Alamat:</label>
					<div class="col-sm-10">
						<textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Enter alamat"><?php echo $user_data["alamat"];?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="kodepos">Kode Pos:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="kodepos" name="kodepos" placeholder="Enter kode pos" value="<?php echo $user_data["kodepos"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="negara"><i class="fa fa-asterisk" aria-hidden="true"></i> Negara:</label>
					<div class="col-sm-10">
							<?php echo country_dropdown('negara', 'negara', 'form-control', $user_data['negara'], array('ID'), '');?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="jabatan"><i class="fa fa-asterisk" aria-hidden="true"></i> Jabatan:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Enter jabatan" value="<?php echo $user_data["jabatan"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="perusahaan"><i class="fa fa-asterisk" aria-hidden="true"></i> Perusahaan:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="perusahaan" name="perusahaan" placeholder="Enter perusahaan" value="<?php echo $user_data["perusahaan"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="bioperusahaan">Bio Perusahaan :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="bioperusahaan" name="bioperusahaan" placeholder="Enter bio perusahaan" value="<?php echo $user_data["bioperusahaan"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="biouser">Bio User :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="biouser" name="biouser" placeholder="Enter bio user" value="<?php echo $user_data["biouser"];?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label><input type="checkbox" name="private" value="1" <?php if ($user_data["private"] == 1) {echo "checked";};?>> Private</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="img">Profile Picture :</label>
					<div class="col-sm-10">
						<?php if ($user_data["img"] != null): ?>
							<img src="<?php echo base_url()."uploads/". $user_data["img"];?>" class="media-object img-rounded img-center profile-picture-40" alt="<?php echo $user_data["namadepan"] . ' ' . $user_data["namabelakang"];?>">
						<?php else: ?>
							<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-40 media-object "><?php echo strtoupper($user_data["namadepan"][0].$user_data["namabelakang"][0]);?></div>
						<?php endif; ?>
						<input type="text" class="form-control" id="img" name="img" placeholder="Enter profile picture" value="<?php echo $user_data["img"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="music">Music :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="music" name="music" placeholder="Enter music" value="<?php echo $user_data["music"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="music_ori">Music Filename Original :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="music_ori" name="music_ori" placeholder="Enter music filename original" value="<?php echo $user_data["music_ori"];?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label><input type="checkbox" name="verified" value="1" <?php if ($user_data["verified"] == 1) {echo "checked";};?>> Verified</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="code_password">Code Forget Password :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="code_password" name="code_password" placeholder="Enter code forget password" value="<?php echo $user_data["code_password"];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="code_activation">Code Activation :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="code_activation" name="code_activation" placeholder="Enter code activation" value="<?php echo $user_data["code_activation"];?>">
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
