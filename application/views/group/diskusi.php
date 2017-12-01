<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>

	<?php if ($this->session->flashdata("msg") != null): ?>
		<div class="alert alert-info">
			<?php echo $this->session->flashdata("msg")?>
		</div>
	<?php endif; ?>
	
	<div class="row">
		<div class="col-sm-4">
			<?php $this->load->view("group/sidebar");?>
		</div>

		<div class="col-sm-8">
			<?php $this->load->view("group/tab");?>
			<?php if (!$is_user_member): ?>
				<div class="alert alert-warning">
					Anda harus menjadi member di group untuk bisa melihat diskusi.
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php $this->load->view('layout/footer.php');
