<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view("layout/header");?>

<div class="container wrapper">
	<div class="row">
		<div class="col-sm-3">
			<?php $this->load->view("admin/sidebar")?>
		</div>
		<div class="col-sm-9">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>ID</th><th></th><th>Nama </th><th>Email</th><th>No HP</th><th>Negara</th><th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($user as $key => $value): ?>
							<tr>
								<td class="td-fit"><?php echo $value["id"]?></td>
								<td class="td-fit">
									<?php if ($value["img"] != null): ?>
										<img src="<?php echo base_url()."uploads/". $value["img"];?>" class="media-object img-rounded img-center profile-picture-40" alt="<?php echo $value["namadepan"] . ' ' . $value["namabelakang"];?>">
									<?php else: ?>
										<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-40 media-object "><?php echo strtoupper($value["namadepan"][0].$value["namabelakang"][0]);?></div>
									<?php endif; ?>
								</td>
								<td>
									<a href="<?php echo site_url("cont/user/".$value['id'])?>">
										<?php echo $value["namadepan"] ." ". $value["namabelakang"]?>
										<?php if ($value["verified"]) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?>
									</a>
								</td>
								<td><?php echo $value["email"]?></td>
								<td><?php echo $value["nohp"]?></td>
								<td><?php echo $value["negara"]?></td>
								<td class="td-fit"><a href="<?php echo site_url("admin/user/").$value["id"] ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view("layout/footer");?>
