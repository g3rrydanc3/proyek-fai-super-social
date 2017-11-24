<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if (count($dataexplore) > 0): ?>
	<div class="row">
		<?php $count = 0?>
		<?php foreach ($dataexplore as $key => $value): ?>
				<div class="row col-sm-6">
					<div class="col-md-3">
						<?php if ($value["img"] != null): ?>
							<img src="<?php echo base_url()."uploads/". $value["img"];?>" class="img-responsive img-rounded img-center img-zoom img-small" alt="<?php echo $value["namadepan"] . ' ' . $value["namabelakang"];?>">
						<?php else: ?>
							<div class="profile-picture-default profile-picture-default-small unselectable form-group"><?php echo strtoupper($value["namadepan"][0].$value["namabelakang"][0]);?></div>
						<?php endif; ?>
					</div>
					<div class="col-md-4">
						<?php echo form_open('cont');?>
						<?php echo form_hidden('friend_id', $value['id']);?>
						<?php echo form_submit('profileuser', $value['namadepan'] . ' ' . $value['namabelakang'], "class='btn btn-link'");?>
						<br>
						<?php
							if (in_array_r($value['id'], $friends_requested)) {
								echo form_submit('', 'Requested', 'class="btn btn-primary" disabled');
							}
							else if (in_array_r($value['id'], $friends_request)) {
								echo form_submit('e_acceptfriend', 'Accept', "class='btn btn-primary'");
								echo form_submit('e_removefriend', 'Decline', "class='btn btn-danger'");
							}
							else if (in_array_r($value['id'], $friends)) {
								echo form_submit('e_removefriend', 'Remove Friend', "class='btn btn-danger'");
							}
							else {
								echo form_submit('e_addfriend', 'Add Friend', "class='btn btn-primary'");
							}
						?>
						<?php echo form_close();?>
					</div>
					<div class="col-md-5">
						<p>Total Likes : <?php echo $value['likes'];?></p>
						<?php if ($value['p_isi'] == null): ?>
							Tidak ada post
						<?php else: ?>
							<small><?php echo $value['p_datetime'];?></small>
							<br>
							<?php echo $value['p_isi'];?>
						<?php endif; ?>
					</div>
				</div>

				<?php if ($count % 2 == 1): ?>
					<div class="clearfix"></div>
					<hr>
				<?php endif; ?>
				<?php $count++?>
		<?php endforeach; ?>
	</div>
	<?php echo $links;?>
<?php else: ?>
	<div class="alert alert-warning">
		User lain tidak ditemukan.
	</div>
<?php endif; ?>
