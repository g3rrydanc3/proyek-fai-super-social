<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>

	<?php if ($this->session->flashdata("msg") != null): ?>
		<div class="alert alert-info">
			<?php echo $this->session->flashdata("msg")?>
		</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-sm-4">
			<?php $this->load->view("group/sidebar");?>
		</div>

		<div class="col-sm-8">
			<?php $this->load->view("group/tab");?>
			<h2><small>Deskripsi</small></h2>
			<p><?php echo $tentang["description"]?></p>
			<h2><small>Dibuat tanggal</small></h2>
			<p><?php echo $tentang["datetime"]?></p>
			<h2><small>Dibuat oleh</small></h2>

			<div class="media">
				<div class="media-left">
					<a href="<?php echo site_url("cont/user/".$tentang["user_id"])?>">
						<?php if ($tentang["user_img"] != null): ?>
							<img src="<?php echo base_url()."uploads/". $tentang["user_img"];?>" class="media-object img-rounded img-center profile-picture-40" alt="<?php echo $tentang["namadepan"] . ' ' . $tentang["namabelakang"];?>">
						<?php else: ?>
							<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-40 media-object "><?php echo strtoupper($tentang["namadepan"][0].$tentang["namabelakang"][0]);?></div>
						<?php endif; ?>
					</a>
				</div>
				<div class="media-body">
					<a href="<?php echo site_url("cont/user/".$tentang["user_id"])?>">
						<h4 class="media-heading">
							<?php echo $tentang["namadepan"] .' '. $tentang["namabelakang"]?>
							<?php if ($tentang["verified"]) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?>
						</h4>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('layout/footer.php');
