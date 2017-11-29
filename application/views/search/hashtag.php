<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<h1>Search</h1>
	<?php $this->load->view("search/tab");?>
	<?php echo form_open("search/hashtag")?>
	<div id="custom-search-input">
		<div class="input-group col-md-12">
			<input type="text" class="form-control input" placeholder="Search hastag" name="hashtag" value="<?php echo $hashtag?>">
			<span class="input-group-btn">
				<button class="btn btn-info btn" type="submit">
					<i class="glyphicon glyphicon-search"></i>
				</button>
			</span>
		</div>
	</div>
	<?php echo form_close()?>
<?php if (isset($hashtag)): ?>
	<?php $this->load->view("layout/post")?>
<?php endif; ?>


</div>
<?php $this->load->view('layout/footer.php');?>
