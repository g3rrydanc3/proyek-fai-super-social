<ul class="nav nav-tabs" style="margin-bottom: 1.25rem;">
	<li class="<?php if($this->uri->segment(2)=="user"){echo 'active';}?>"><a href="<?php echo site_url("search/user")?>">User</a></li>
	<li class="<?php if($this->uri->segment(2)=="group"){echo 'active';}?>"><a href="<?php echo site_url("search/group")?>">Group</a></li>
	<li class="<?php if($this->uri->segment(2)=="hashtag"){echo 'active';}?>"><a href="<?php echo site_url("search/hashtag")?>">Hashtag</a></li>
</ul>
