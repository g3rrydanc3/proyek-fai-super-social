<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
<div class="row">
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h1>Profile</h1>
			</div>
			<div class="panel-body">
				<?php if ($img != null): ?>
					<img src="<?php echo base_url()."uploads/". $img;?>" class="img-responsive img-rounded img-center img-zoom" alt="<?php echo $namadepan . ' ' . $namabelakang;?>">
				<?php else: ?>
					<div class="profile-picture-default unselectable form-group"><?php echo strtoupper($namadepan[0].$namabelakang[0]);?></div>
				<?php endif; ?>
				<?php if ($music !=null): ?>
					<audio controls autoplay>
						<source src='<?php echo base_url()."uploads/". $music;?>'>
					</audio>
				<?php endif; ?>

				<ul class="list-group">
					<li class="list-group-item"><span class="label label-default">Nama :</span> <?php echo $namadepan . ' ' . $namabelakang;?> <?php if ($verified) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?></li>
					<li class="list-group-item"><span class="label label-default">Email :</span> <?php echo $email;?></li>
					<li class="list-group-item"><span class="label label-default">No HP :</span> <?php echo $nohp;?></li>
					<li class="list-group-item"><span class="label label-default">Jabatan :</span> <?php echo $jabatan;?></li>
					<li class="list-group-item"><span class="label label-default">Perusahaan :</span> <?php echo $perusahaan;?></li>
					<li class="list-group-item"><span class="label label-default">Bio Perusahaan :</span> <?php echo $bioperusahaan;?></li>
					<li class="list-group-item"><span class="label label-default">Bio User :</span> <?php echo $biouser;?></li>
					<li class="list-group-item"><span class="label label-default">Total Like :</span> <?php echo $totallikes;?></li>
					<li class="list-group-item"><span class="label label-default">Total Comment :</span> <?php echo $totalcomments;?></li>
				</ul>
				<a href="<?php echo site_url("profile/edit_profile");?>"><button class="btn btn-primary">Edit Profile</button></a>
				<a href="<?php echo site_url("profile/edit_account");?>"><button class="btn btn-primary">Edit Account</button></a>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Skill</h2>
			</div>
			<div class="panel-body">
				<?php if (count($skill) > 0): ?>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Nama Skill</th><th>Jumlah Endorse</th>
							</tr>
						</thead>
						<?php foreach ($skill as $key => $value): ?>
							<tr>
								<td><?php echo $value["nama"]; ?></td>
								<td><?php echo $value["jumlahendorse"]; ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php else: ?>
					<p><span class="label label-default">Belum ada skill.</span></p>
				<?php endif; ?>
				<a href="<?php echo site_url("cont/skill");?>"<button type="button" class="btn btn-primary">Add / see all Skill</button></a>
			</div>
		</div>
	</div>

	<div class="col-sm-8">
		<?php $this->load->view("layout/post_new");?>

		<h2>My Post</h2>
		<?php $this->load->view("layout/post");?>
	</div>
</div>
</div>

<?php $this->load->view('layout/footer.php');
