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

	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#yourgroup">Your Group</a></li>
		<li><a data-toggle="tab" href="#browsegroup">Browse Group</a></li>
		<li class="pull-right">
			<a href="<?php echo site_url("group/create")?>">
				<i class="fa fa-plus" aria-hidden="true"></i> Create Group
			</a>
		</li>
	</ul>

	<div class="tab-content">
		<div id="yourgroup" class="tab-pane fade in active">
			<h3>Your Group</h3>
			<?php if (count($group) > 0): ?>
				<?php foreach ($group as $key => $value): ?>
					<?php $this->load->view("layout/kotakgroup", $value)?>
				<?php endforeach; ?>
				<?php else: ?>
					<div class="alert alert-info">
						<p>Anda belum punya grup</p>
					</div>
			<?php endif; ?>

		</div>
		<div id="browsegroup" class="tab-pane fade">
			<h3>Browse Group</h3>
			<?php if (count($browsegroup) > 0): ?>
				<?php foreach ($browsegroup as $key => $value): ?>
					<?php $this->load->view("layout/kotakgroup", $value)?>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="alert alert-info">
					<p>Tidak ada grup lagi, Cek lagi nanti</p>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php $this->load->view('layout/footer.php');
