<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if (count($posts) > 0): ?>
<table border='1' class='table table-bordered table-striped'>
	<?php for ($i = 0; $i<count($posts); $i++) : ?>
		<!--MODAL-->
		<div id="myModal<?php echo $i;?>" class="modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"onclick="closeModal('<?php echo $i;?>')">&times;</button>
					</div>
					<div class="modal-body">
						<p>
							<?php if (count($likes[$i]) != 0) :?>
								<ul class="list-group">
								<?php foreach ($likes[$i] as $key1 => $value1) :?>
										<li class="list-group-item"><?php echo $value1['namadepan'] . ' ' . $value1['namabelakang'];?> <?php if ($value1['verified']) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?></li>
								<?php endforeach;?>
								</ul>
							<?php else :?>
								Tidak ada likes
							<?php endif;?>
						</p>
					</div>
				</div>
			</div>
		</div>
		<!--END OF MODAL-->
		<tr>
			<td class="td-fit">
				<b><?php echo $posts[$i]["namadepan"]." ".$posts[$i]["namabelakang"];?>  <?php if ($verified) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?></b><br>
				<small><?php echo $posts[$i]['datetime']?></small>
				<br>
				<a href='#' onclick='showModal(<?php echo $i;?>)'>
					<?php echo $posts[$i]['likes'];?> Like
				</a>
				<br>
				<?php echo form_open('post/like');?>
				<?php echo form_hidden('friend_id', $posts[$i]['user_id']);?>
				<?php echo form_hidden('posts_id', $posts[$i]['id']);?>
				<?php if (!in_array_r($this->session->_userskrng, $likes[$i])) :?>
					<button type="submit" name="like" value="Like" class="btn-like">Like <span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span></button>
				<?php else: ?>
					<button type="submit" name="like" value="Unlike" class="btn-unlike">Unlike <span><i class="fa fa-thumbs-up" aria-hidden="true"></i></span></button>
				<?php endif; ?>
				<?php echo form_close();?>
			</td>
			<td>
				<p><?php echo $posts[$i]['isi'];?></p>
				<?php if ($posts[$i]["img"] != null): ?>
					<img src="<?php echo base_url("uploads/").$posts[$i]["img"];?>" class="img-responsive img-zoom">
				<?php endif; ?>
			</td>
			<td class="td-fit">
					<?php if ($posts[$i]["user_id"] == $this->session->_userskrng): ?>
							<?php echo form_open("post/delpost", 'onsubmit="return confirm(\'Do you really want to delete post?\');"');?>
							<?php echo form_hidden("posts_id", $posts[$i]['id']);?>
							<button type="submit" class="btn-delpost" name="delpost" value="X" data-toggle="modal" data-target="#confirm-submit"><i class="fa fa-times" aria-hidden="true"></i></button>
							<?php echo form_close();?>
					<?php endif; ?>
					<?php
						$date1=date_create($posts[$i]['datetime']);
						$date2=date_create(date("Y-m-d H:i:s", time() - 119));
						$diff=date_diff($date1,$date2);
						$minute = $diff->format("%i") * 60;
						$second = $minute + $diff->format("%s");
					?>
					<?php if ($posts[$i]['timed'] == "1"): ?>
						Countdown :<div id='countdown<?php echo $i;?>'></div>
						<script>new Countdown(<?php echo $second;?>, 'countdown<?php echo $i;?>').start();</script>
					<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td colspan = 3>
				<center><?php echo $totalcommentsperpost[$i];?> Comments</center>
				<table border='1' class='table table-bordered'>
					<?php foreach ($comments[$i] as $key1 => $value1):?>
						<tr>
							<td class="td-fit">
								<p><b><?php echo $value1['namadepan'] ." ". $value1['namabelakang'];?>  <?php if ($value1['verified']) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?></b></p>
								<p><small><?php echo $value1['datetime'];?></small></p>
							</td>
							<td>
								<p><?php echo $value1['isi'];?></p>
								<?php if ($value1["img"] != null): ?>
									<img src="<?php echo base_url("uploads/").$value1["img"];?>" class="img-responsive img-zoom">
								<?php endif; ?>
							</td>
							<td class="td-fit">
								<?php if ($this->session->_userskrng == $value1['user_id']):?>
									<?php echo form_open("post/delcomment", 'onsubmit="return confirm(\'Do you really want to delete comment?\');"');?>
									<?php echo form_hidden("comments_id", $value1['id']);?>
									<button type="submit" class="btn-delpost" name="delcomment" value="X"><i class="fa fa-times" aria-hidden="true"></i></button>
									<?php echo form_close();?>
								<?php endif;?>
							</td>
						</tr>
					<?php endforeach;?>
						<td><b><?php echo $this->session->name;?> <?php if ($verified) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?></b></td>
						<td colspan = 2>
							<?php echo form_open_multipart("post/addcomment");?>
							<?php echo form_hidden("posts_id", $posts[$i]['id']);?>
							<div class="divupload-foto form-group">
								<input class="upload-foto" name="upload-foto" type="file">
							</div>
							<div class="row">
								<div class="col-xs-9">
									<?php echo form_input("comment", "", "class='form-control'");?>
								</div>
								<div class="col-xs-3">
									<div class="btn-group">
										<button type="submit" class="btn btn-primary" name="addcomment" value="Add Comment">Add Comment</button>
										<button type="button" class="btn btn-default btn-upload"><i class="fa fa-paperclip" aria-hidden="true"></i></button>
									</div>
								</div>
							</div>
							<?php echo form_close();?>
						</td>
					</tr>
				</table>
			</td>
		</tr>

	<?php	endfor;?>
</table>
<?php echo $links;?>
<?php else: ?>
	<p><span class="label label-default">Anda belum pernah post.</span></p>
<?php endif; ?>

<script>
$(document).ready(function(){
	$(".divupload-foto").hide();
	$(".upload-foto").fileinput({showUpload: false});

	$(".btn-upload").click(function(){
		$(this).parents("td").find(".divupload-foto").toggle("fast");
	});
});
</script>
