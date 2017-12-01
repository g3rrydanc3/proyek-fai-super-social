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
			<?php foreach ($member as $key => $value): ?>
				<div class="media">
					<div class="media-left">
						<a href="<?php echo site_url("cont/user/".$value["id"])?>">
							<?php if ($tentang["user_img"] != null): ?>
								<img src="<?php echo base_url()."uploads/". $value["user_img"];?>" class="media-object img-rounded img-center profile-picture-40" alt="<?php echo $value["namadepan"] . ' ' . $value["namabelakang"];?>">
							<?php else: ?>
								<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-40 media-object "><?php echo strtoupper($value["namadepan"][0].$value["namabelakang"][0]);?></div>
							<?php endif; ?>
						</a>
					</div>
					<div class="media-body">
						<a href="<?php echo site_url("cont/user/".$value["id"])?>">
							<h4 class="media-heading">
								<?php echo $value["namadepan"] .' '. $value["namabelakang"]?>
								<?php if ($value["verified"]) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?>
							</h4>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php $this->load->view('layout/footer.php');
