<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view("layout/header");?>

<div class="container wrapper">
	<div class="row">
		<div class="col-sm-3">
			<?php $this->load->view("admin/sidebar")?>
		</div>
		<div class="col-sm-9">
			<?php if ($this->session->flashdata("msg") != null): ?>
				<div class="container alert alert-info" style="margin-top:20px;">
					<?php echo $this->session->flashdata("msg")?>
				</div>
			<?php endif; ?>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>ID</th><th></th><th>Reporter</th><th></th><th>Reported</th><th>Post(if any)</th><th>Reason</th><th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($reported_user as $key => $value): ?>
							<tr>
								<td class="td-fit"><?php echo $value["id"]?></td>
								<td class="td-fit">
									<?php if ($value["u1_img"] != null): ?>
										<img src="<?php echo base_url()."uploads/". $value["u1_img"];?>" class="media-object img-rounded img-center profile-picture-40" alt="<?php echo $value["u1_namadepan"] . ' ' . $value["u1_namabelakang"];?>">
									<?php else: ?>
										<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-40 media-object "><?php echo strtoupper($value["u1_namadepan"][0].$value["u1_namabelakang"][0]);?></div>
									<?php endif; ?>
								</td>
								<td>
									<a href="<?php echo site_url("cont/user/".$value['u1_id'])?>">
										<?php echo $value["u1_namadepan"] ." ". $value["u1_namabelakang"]?>
										<?php if ($value["u1_verified"]) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?>
									</a>
								</td>
								<td class="td-fit">
									<?php if ($value["u2_img"] != null): ?>
										<img src="<?php echo base_url()."uploads/". $value["u2_img"];?>" class="media-object img-rounded img-center profile-picture-40" alt="<?php echo $value["u2_namadepan"] . ' ' . $value["u2_namabelakang"];?>">
									<?php else: ?>
										<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-40 media-object "><?php echo strtoupper($value["u2_namadepan"][0].$value["u2_namabelakang"][0]);?></div>
									<?php endif; ?>
								</td>
								<td>
									<a href="<?php echo site_url("cont/user/".$value['u2_id'])?>">
										<?php echo $value["u2_namadepan"] ." ". $value["u2_namabelakang"]?>
										<?php if ($value["u2_verified"]) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?>
									</a>
								</td>
								<td>
									<small class="text-muted"><?php echo $value["p_datetime"]?> <?php if($value["p_timed"]) echo "(Timed)"?></small>
									<?php if ($value["p_img"] != null): ?>
										<?php if (substr($value["p_img"], -3) == "mp4"): ?>
											<video width="320" height="240" controls>
												<source src="<?php echo base_url("uploads/").$value["p_img"];?>">
												Your browser does not support the video tag.
											</video>
										<?php else: ?>
											<img src="<?php echo base_url("uploads/").$value["p_img"];?>" class="img-responsive img-zoom">
										<?php endif; ?>
									<?php endif; ?>
									<p><?php echo $value["p_isi"]?></p>
								</td>
								<td><?php echo $value["reason"]?></td>
								<td class="td-fit"><a href="<?php echo site_url("admin/reported_user_process/").$value["id"] ?>"><i class="fa fa-check" aria-hidden="true"></i></a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view("layout/footer");?>
