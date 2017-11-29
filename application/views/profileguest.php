<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');

$bolehlihat = true;
if (!in_array_r($friend_id, $friends)) {
	if ($private) {
		$bolehlihat = false;
	}
}
if ($blocked) {
	$bolehlihat = false;
}
?>
<div class='container wrapper'>
	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1><?php echo $namadepan.' '. $namabelakang;?>'s Profile</h1>
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
						<li class="list-group-item"><span class="label label-default">Total Like :</span> <?php echo $totallikes;?></li>
						<li class="list-group-item"><span class="label label-default">Total Comment :</span> <?php echo $totalcomments;?></li>
					</ul>
					<?php echo form_open("cont");?>
					<?php	echo form_hidden('friend_id', $friend_id);?>
					<center>
							<?php if (!$blocked): ?>
								<div class="btn-group-vertical btn-block">
								<?php if (!$block): ?>
									<?php if (in_array_r($friend_id, $friends_requested)):?>
										<button class="btn btn-block btn-success" disabled>Requested</button>
									<?php elseif (in_array_r($friend_id, $friends)):?>
										<button type="submit" class="btn btn-success" name="pg_sendmessage" value="Send Message">Send Message</button>
										<button type="submit" class="btn btn-warning" name="pg_removefriend" value="Remove Friend">Remove Friend</button>
									<?php else:?>
										<button type="submit" class="btn btn-success" name="pg_addfriend" value="Add Friend">Add Friend</button>
									<?php endif;?>
									<button type="submit" class="btn btn-danger" name="pg_blockfriend" value="Add Friend">Block This Person</button>
								<?php else: ?>
									<button type="submit" class="btn btn-danger" name="pg_removefriend" value="Add Friend">Unblock This Person</button>
								<?php endif; ?>
								</div>
							<?php endif; ?>
						<button type="submit" class="btn btn-info btn-block" name="pg_reportfriend" value="Add Friend">Report This Person</button>
					</center>
					<?php echo form_close();?>
				</div>
			</div>
			<?php if ($bolehlihat): ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2><?php echo $namadepan.' '. $namabelakang;?>'s Skill</h2>
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
						<a href="<?php echo site_url("cont/skilluser/").$friend_id;?>"><button class="btn btn-primary">See all Skill</button></a>
					</div>
				</div>
			<?php endif;?>
		</div>
		<?php if ($bolehlihat): ?>
			<div class="col-sm-8">
				<h2><?php echo $namadepan.' '. $namabelakang;?>'s Post</h2>
				<?php $this->load->view('layout/post.php');?>
			</div>
		<?php else: ?>
			<h2>Profile ini private</h2>
			Berteman untuk melihat profile
		<?php endif; ?>
</div>
<?php $this->load->view('layout/footer.php');
