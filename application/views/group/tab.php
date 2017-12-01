<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="nav nav-tabs" style="margin-bottom: 1.25rem;">
	<li class="<?php if($this->uri->segment(2)=="tentang"){echo 'active';}?>"><a href="<?php echo site_url("group/tentang/".$group_id)?>">Tentang</a></li>
	<li class="<?php if($this->uri->segment(2)=="diskusi"){echo 'active';}?>"><a href="<?php echo site_url("group/diskusi/".$group_id)?>">Diskusi</a></li>
	<li class="<?php if($this->uri->segment(2)=="member"){echo 'active';}?>"><a href="<?php echo site_url("group/member/".$group_id)?>">Member</a></li>
</ul>
