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
			<a href="<?php echo site_url("group/index/".$value["id"])?>" class="no-style">
				<div class="media">
					<div class="media-left">
						<?php if ($value["img"] != null): ?>
							<img src="<?php echo base_url()."uploads/". $value["img"];?>" class="media-object img-rounded img-center profile-picture-40" alt="<?php echo $value["name"]?>">
						<?php else: ?>
							<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-40 media-object "><?php echo strtoupper($value["name"][0]);?></div>
						<?php endif; ?>
					</div>
					<div class="media-body">
						<h4 class="media-heading"><?php echo $value["name"]?></h4>
						<p><?php echo $value["description"]?></p>
					</div>
				</div>
			</a>
			<hr>
		<?php endforeach; ?>
	<?php else: ?>
		<div class="alert alert-info">
			Tidak ada group yang ditemukan.
		</div>
	<?php endif; ?>

<?php endif; ?>


</div>
<?php $this->load->view('layout/footer.php');?>
