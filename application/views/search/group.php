<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<h1>Search</h1>
	<?php $this->load->view("search/tab");?>
	<?php echo form_open("search/group")?>
	<div id="custom-search-input">
		<div class="input-group col-md-12">
			<input type="text" class="form-control input" placeholder="Search group" name="group" value="<?php echo $group?>">
			<span class="input-group-btn">
				<button class="btn btn-info btn" type="submit">
					<i class="glyphicon glyphicon-search"></i>
				</button>
			</span>
		</div>
	</div>
	<?php echo form_close()?>
<?php if (isset($result)): ?>
	<div style="margin-bottom:10px;"></div>
	<?php if (count($result) > 0): ?>
		<?php foreach ($result as $key => $value): ?>
			<?php $this->load->view("layout/kotakgroup.php", $value)?>
		<?php endforeach; ?>
	<?php else: ?>
		<div class="alert alert-info">
			Tidak ada group yang ditemukan.
		</div>
	<?php endif; ?>

<?php endif; ?>


</div>
<?php $this->load->view('layout/footer.php');?>
