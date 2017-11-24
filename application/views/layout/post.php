<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if (count($posts) > 0): ?>
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


		<div class="panel panel-default">
			<div class="panel-body">
				<section class="post-heading">
					<div class="row">
						<div class="col-xs-11">
							<div class="media">
								<div class="media-left">
									<a href="<?php echo site_url("cont/user/").$posts[$i]['user_id']?>" class="no-style">
										<?php if ($posts[$i]["user_img"] != null): ?>
											<img src="<?php echo base_url()."uploads/". $posts[$i]["user_img"];?>" class="media-object img-rounded img-center profile-picture-40" alt="<?php echo $posts[$i]["namadepan"] . ' ' . $posts[$i]["namabelakang"];?>">
										<?php else: ?>
											<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-40 media-object "><?php echo strtoupper($posts[$i]["namadepan"][0].$posts[$i]["namabelakang"][0]);?></div>
										<?php endif; ?>
									</a>
								</div>
								<div class="media-body">
									<a href="<?php echo site_url("cont/user/").$posts[$i]['user_id']?>" class="anchor-username">
										<h4 class="media-heading">
											<?php echo $posts[$i]["namadepan"]." ".$posts[$i]["namabelakang"];?>  <?php if ($verified) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?></b>
										</h4>
									</a>
									<span class="anchor-time">
										<?php echo $posts[$i]['datetime']?>
										<?php
											$date1=date_create($posts[$i]['datetime']);
											$date2=date_create(date("Y-m-d H:i:s", time() - 119));
											$diff=date_diff($date1,$date2);
											$minute = $diff->format("%i") * 60;
											$second = $minute + $diff->format("%s");
										?>
										<?php if ($posts[$i]['timed'] == "1"): ?>
											| Time Left : <div id='countdown<?php echo $i;?>' style="display:inline;"></div>
											<script>new Countdown(<?php echo $second;?>, 'countdown<?php echo $i;?>').start();</script>
										<?php endif; ?>
									</span>
								</div>
							</div>
						</div>
						<div class="col-xs-1 dropdown">
							<button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown">
								<i class="glyphicon glyphicon-chevron-down"></i>
							</button>
							<ul class="dropdown-menu">
								<?php if ($posts[$i]["user_id"] == $this->session->_userskrng): ?>
									<li><a href="<?php echo site_url("post/delpost/").$posts[$i]['id']?>" onclick="return confirm(\'Do you really want to delete post?\');">Delete Post</a></li>
								<?php endif; ?>
								<?php if ($posts[$i]["user_id"] != $this->session->_userskrng): ?>
									<li><a href="<?php echo site_url("post/reportpost/").$posts[$i]['id']?>" onclick="return confirm(\'Do you really want to report post?\');">Report Post</a></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				</section>
				<section class="post-body">
					<?php if ($posts[$i]["img"] != null): ?>
						<img src="<?php echo base_url("uploads/").$posts[$i]["img"];?>" class="img-responsive img-zoom">
					<?php endif; ?>
					<p><?php echo $posts[$i]['isi'];?></p>
				</section>
				<hr class="hr-slim">
				<section class="post-footer">
					<div class="row">
						<div class="col-xs-8">
							<div class="post-footer-option">
								<ul class="list-unstyled">
									<?php echo form_open('post/like');?>
										<?php echo form_hidden('friend_id', $posts[$i]['user_id']);?>
										<?php echo form_hidden('posts_id', $posts[$i]['id']);?>
										<?php if (!in_array_r($this->session->_userskrng, $likes[$i])) :?>
											<li><button type="submit" name="like" value="Like" class="btn-like"><span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span> Like</button></li>
										<?php else: ?>
											<li><button type="submit" name="like" value="Unlike" class="btn-unlike"><span><i class="fa fa-thumbs-up" aria-hidden="true"></i></span> Unlike</button></li>
										<?php endif; ?>
									<?php echo form_close();?>
									<!--<li><a href="#"><i class="glyphicon glyphicon-comment"></i> Comment</a></li>-->
									<?php echo form_open('post/sharepost');?>
										<?php echo form_hidden('friend_id', $posts[$i]['user_id']);?>
										<?php echo form_hidden('posts_id', $posts[$i]['id']);?>
										<li><button type="submit" class="btn-like"><i class="glyphicon glyphicon-share-alt"></i> Share</button></li>
									<?php echo form_close();?>
								</ul>
							</div>
						</div>
						<div class="col-xs-4 text-right">
							<a class="no-jump" href='#' onclick='showModal(<?php echo $i;?>)'>
								<?php echo $posts[$i]['likes'];?> Like
							</a>
							&nbsp;<?php echo $totalcommentsperpost[$i];?> Comments
						</div>
					</div>
					<div class="post-footer-comment-wrapper">
						<div class="comment">
							<div class="media">
								<div class="media-left">
									<a href="<?php echo site_url("profile")?>" class="no-style">
										<?php if ($img != null): ?>
											<img src="<?php echo base_url()."uploads/". $img;?>" class="media-object img-rounded img-center profile-picture-32" alt="<?php echo $namadepan . ' ' . $namabelakang;?>">
										<?php else: ?>
											<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-32 media-object "><?php echo strtoupper($namadepan[0].$namabelakang[0]);?></div>
										<?php endif; ?>
									</a>
								</div>
								<div class="media-body">
									<?php echo form_open_multipart("post/addcomment");?>
									<?php echo form_hidden("posts_id", $posts[$i]['id']);?>
									<div class="divupload-foto">
										<input class="upload-foto" name="upload-foto" type="file">
									</div>
									<div class="input-group" class="form-group">
										<input type="text" name="comment" class="form-control" placeholder="Type your message here..." />
										<span class="input-group-btn">
											<button class="btn btn-primary" type="submit" name="addcomment" value="1" id="btn-chat">Send</button>
											<button class="btn btn-default btn-upload" type="button" class="btn-upload">
												<i class="fa fa-paperclip" aria-hidden="true"></i>
											</button>
										</span>
									</div>
									<?php echo form_close();?>
								</div>
							</div>
							<?php foreach ($comments[$i] as $key1 => $value1):?>
								<div class="media">
									<div class="media-left">
										<a href="<?php echo site_url("cont/user/").$value1['user_id']?>" class="no-style">
											<?php if ($posts[$i]["user_img"] != null): ?>
												<img src="<?php echo base_url()."uploads/". $value1["user_img"];?>" class="media-object img-rounded img-center profile-picture-32" alt="<?php echo $value1["namadepan"] . ' ' . $value1["namabelakang"];?>">
											<?php else: ?>
												<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-32 media-object"><?php echo strtoupper($value1["namadepan"][0].$value1["namabelakang"][0]);?></div>
											<?php endif; ?>
										</a>
									</div>
									<div class="media-body">
										<div class="row">
											<div class="col-xs-11">
												<a href="<?php echo site_url("cont/user/").$value1['user_id']?>" class="anchor-username"><h5 class="media-heading"><b><?php echo $value1['namadepan'] ." ". $value1['namabelakang'];?>  <?php if ($value1['verified']) echo '<i class="fa fa-check-circle text-primary" aria-hidden="true"></i>'; ?></b></h5></a>
											</div>
											<div class="col-xs-1">
												<a href="<?php echo site_url("post/delcomment/").$value1['id']?>" onclick="return confirm(\'Do you really want to delete comment?\');"><i class="fa fa-times" aria-hidden="true"></i></a>
											</div>
										</div>

										<p class="anchor-time"><?php echo $value1['datetime'];?></p>
										<p>
											<?php if ($value1["img"] != null): ?>
												<img src="<?php echo base_url("uploads/").$value1["img"];?>" class="img-responsive img-zoom">
											<?php endif; ?>
											<?php echo $value1['isi'];?>
										</p>
									</div>
								</div>
								<hr class="hr-slim">
							<?php endforeach;?>

						</div>
					</div>
				</section>
			</div>
		</div>

	<?php	endfor;?>
<?php echo $links;?>
<?php else: ?>
	<p><span class="label label-default">Anda belum pernah post.</span></p>
<?php endif; ?>

<script>
$(document).ready(function(){
	$(".divupload-foto").hide();
	$(".upload-foto").fileinput({showUpload: false});

	$(".btn-upload").click(function(){
		$(this).parents("div").find(".divupload-foto").toggle("fast");
	});
});

</script>
