<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>New Post</h2>
	</div>
	<div class="panel-body">
		<?php if ($this->session->flashdata('post-image-error') != null): ?>
			<div class="alert alert-danger">
				<?php echo $this->session->flashdata('post-image-error'); ?>
			</div>
		<?php endif; ?>
		<?php echo form_open_multipart("post/posts", "form-control");?>
			<div class="form-group">
				<textarea name="posts" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<label for="post-foto">
					Add Photo/Video<br>
					<small>(gif|jpg|png|mp4)</small>
				</label>
				<input id="post-foto" name="post-foto" type="file" value="Add Photo">
			</div>
			<div class="form-group">
				<button type="submit" name="btn_posts" class="btn btn-primary" value="Post">Post</button>
				<button type="submit" name="btn_posts_timed" class="btn btn-primary" value="Timed Post"><i class="fa fa-clock-o" aria-hidden="true"></i> Timed Post</button>
			</div>

		<?php echo form_close();?>
	</div>
</div>
