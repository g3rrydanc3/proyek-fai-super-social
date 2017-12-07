<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view("layout/header");?>

<div class="container wrapper">
	<div class="row">
		<div class="col-sm-3">
			<?php $this->load->view("admin/sidebar")?>
		</div>
		<div class="col-sm-9">
			<?php if (isset($charts['post'])) echo $charts['post']; ?>
			<?php if (isset($charts['private'])) echo $charts['private']; ?>
			<?php if (isset($charts['reportuser'])) echo $charts['reportuser']; ?>
		</div>
	</div>
</div>

<?php $this->load->view("layout/footer");?>
