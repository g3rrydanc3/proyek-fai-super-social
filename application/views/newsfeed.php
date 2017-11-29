<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<h1>News Feed</h1>

	<?php if ($this->session->flashdata("msg") != null): ?>
		<div class="alert alert-info">
			<?php echo $this->session->flashdata("msg")?>
		</div>
	<?php endif; ?>

<?php $this->load->view("layout/post_new");?>

<?php $this->load->view("layout/post");?>

	<script>
	$("#post-foto").fileinput({showCaption: false,
		maxFileCount: 1,
		showClose: false,
		showUpload: false
	});
	</script>
</div>
<?php $this->load->view('layout/footer.php');
