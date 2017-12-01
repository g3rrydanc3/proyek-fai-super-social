<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<ul class="nav nav-pills nav-stacked" style="border-right:1px solid rgba(0,0,0,0.1);">
	<li class="<?php if($this->uri->segment(2)=="index"){echo 'active';}?>"><a href="<?php echo site_url("admin/index")?>"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
	<li class="<?php if($this->uri->segment(2)=="user"){echo 'active';}?>"><a href="<?php echo site_url("admin/user")?>"><i class="fa fa-user" aria-hidden="true"></i> User</a></li>
	<li class="<?php if($this->uri->segment(2)=="group"){echo 'active';}?>"><a href="<?php echo site_url("admin/group")?>"><i class="fa fa-users" aria-hidden="true"></i> Group</a></li>
	<li class="<?php if($this->uri->segment(2)=="reported_user"){echo 'active';}?>"><a href="<?php echo site_url("admin/reported_user")?>"><i class="fa fa-flag" aria-hidden="true"></i> Reported User</a></li>
	<li class="<?php if($this->uri->segment(2)=="report"){echo 'active';}?>"><a href="<?php echo site_url("admin/report")?>"><i class="fa fa-line-chart" aria-hidden="true"></i> Report</a></li>
</ul>
