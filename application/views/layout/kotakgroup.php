<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="col-sm-6">
	<a href="<?php echo site_url("group/tentang/".$id)?>" class="no-style">
		<div class="media">
			<div class="media-left">
				<?php if ($img != null): ?>
					<img src="<?php echo base_url()."uploads/". $img;?>" class="media-object img-rounded img-center profile-picture-40" alt="<?php echo $name?>">
				<?php else: ?>
					<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-40 media-object "><?php echo strtoupper($name[0]);?></div>
				<?php endif; ?>
			</div>
			<div class="media-body">
				<h4 class="media-heading"><?php echo $name?></h4>
				<p><?php echo $description?></p>
			</div>
		</div>
	</a>
	<hr>
</div>
