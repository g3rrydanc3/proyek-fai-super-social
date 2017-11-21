<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
	<h1>News Feed</h1>

<?php $this->load->view("layout/post_new");?>

<?php $this->load->view("layout/post");?>

	<script>
	$("#post-foto").fileinput({showCaption: false,
		maxFileCount: 1,
		showClose: false,
		showUpload: false
	});
	</script>

<?php $this->load->view('layout/footer.php');
