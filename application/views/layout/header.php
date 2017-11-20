<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Super Social</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/fileinput.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/bootstrap-footer.css">
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/metisMenu.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/morris.css">
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/sb-admin-2.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>asset/css/bootstrap-post.css">
	<link rel="stylesheet" href="<?php echo base_url('asset/css/style.css');?>">

	<script type="text/javascript" src="<?php echo base_url('asset/js/jquery-3.2.1.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/js/fileinput.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/js/metisMenu.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/js/morris.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/js/raphael.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/js/sb-admin-2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('asset/js/script.js');?>"></script>

</head>
<body>
	<!--ZOOM MODAL-->
	<div class='modal fade' id='enlargeImageModal' tabindex='-1' role='dialog' aria-labelledby='enlargeImageModal' aria-hidden='true'>\
	    <div class='modal-dialog modal-lg' role='document'>\
	      <div class='modal-content'>\
	        <div class='modal-header'>\
	          <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>\
	        </div>\
	        <div class='modal-body'>\
	          <img src='' class='enlargeImageModalSource' style='width: 100%;'>\
	        </div>\
	      </div>\
	    </div>\
	</div>
	<!--END OF ZOOM MODAL-->
	<!--CONFIRM MODAL-->

	<!--END OF CONFIRM MODAL-->

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Super Social</a>
			</div>
			<?php if ($this->session->_userskrng && $this->session->_userskrng != null): ?>
				<ul class="nav navbar-nav">
					<li class="<?php if($this->uri->segment(2)=="newsfeed"){echo 'active';}?>"><a href="<?php echo site_url("cont/newsfeed");?>">News Feed</a></li>
					<li class="<?php if($this->uri->segment(2)=="explore"){echo 'active';}?>"><a href="<?php echo site_url("cont/explore");?>">Explore</a></li>
					<li class="<?php if($this->uri->segment(2)=="notification"){echo 'active';}?>"><a href="<?php echo site_url("cont/notification");?>">Notification</a></li>
					<li class="<?php if($this->uri->segment(1)=="profile"){echo 'active';}?>"><a href="<?php echo site_url("profile");?>"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
					<li class="<?php if($this->uri->segment(2)=="chat"){echo 'active';}?>"><a href="<?php echo site_url("cont/chat");?>">Chat</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
			      <li><a href="<?php echo site_url("cont/logout");?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			      <li><a><?php echo "Hello, ".$this->session->name;?></a></li>
			    </ul>
			<?php else: ?>
				<ul class="nav navbar-nav">
					<li class="<?php if($this->uri->segment(2)=="login"){echo 'active';}?>"><a href="<?php echo site_url("cont/login");?>">Login</a></li>
					<li class="<?php if($this->uri->segment(2)=="register"){echo 'active';}?>"><a href="<?php echo site_url("cont/register");?>">Register</a></li>
				</ul>
			<?php endif; ?>
		</div>
	</nav>
<div class='container wrapper'>
