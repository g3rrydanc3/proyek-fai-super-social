<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h1><?php echo $tentang["name"]?></h1>
		<h2><small>Group</small></h2>
	</div>
	<div class="panel-body">
		<?php if ($tentang["group_img"] != null): ?>
			<img src="<?php echo base_url()."uploads/". $tentang["group_img"];?>" class="img-responsive img-rounded img-center img-zoom" alt="<?php echo $tentang["name"]?>">
		<?php else: ?>
			<div class="profile-picture-default unselectable form-group"><?php echo strtoupper($tentang["name"][0]);?></div>
		<?php endif; ?>
		<div style="padding-bottom:15px;"></div>
		<?php if (!$is_user_member): ?>
			<?php echo form_open("group/join") ?>
			<center>
				<?php echo form_hidden("group_id", $group_id)?>
				<button type="submit" class="btn btn-success btn-block" name="join" value="1">Join Group</button>
			</center>
			<?php echo form_close(); ?>
		<?php else: ?>
			<?php echo form_open("group/leave", 'onsubmit="return confirm(\'Do you really want to leave group?\');"') ?>
			<center>
				<?php echo form_hidden("group_id", $group_id)?>
				<button type="submit" class="btn btn-danger btn-block" name="leave" value="1" >Leave Group</button>
			</center>
			<?php echo form_close(); ?>
		<?php endif; ?>

		<?php if ($is_user_admin): ?>
			<center>
				<a href="<?php echo site_url("group/edit/".$group_id)?>">
					<button type="button" class="btn btn-info btn-block">Edit Group</button>
				</a>
			</center>
		<?php endif; ?>

	</div>
</div>
