<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<div class="form-group">
		<?php
		echo form_open("cont", 'class="form-mention"') .
			form_hidden('chat_rooms_id', $chat_rooms_id);

		echo form_submit("c_adduserview", "Add user", "class='btn btn-primary'");
		echo form_submit("c_endchat", "End chat", "class='btn btn-primary'");
		echo form_close();
		?>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
			<table>
				<tr>
					<td style="padding: 0 20px;">
						<div class="img-wrapper">
							<?php $count = count($chat_rooms_participant);?>
							<?php if ($count == 1): ?>
								<?php if ($chat_rooms_participant[0]["img"] != null): ?>
									<img src="<?php echo base_url()."uploads/". $chat_rooms_participant[0]["img"];?>" class="img-rounded img-center img-small img-zoom" alt="<?php echo $chat_rooms_participant[0]["namadepan"] . ' ' . $chat_rooms_participant[0]["namabelakang"];?>">
								<?php else: ?>
									<div class="profile-picture-default profile-picture-default-small unselectable form-group"><?php echo strtoupper($chat_rooms_participant[0]["namadepan"][0].$chat_rooms_participant[0]["namabelakang"][0]);?></div>
								<?php endif; ?>
							<?php else: ?>
								<img src="<?php echo base_url()."asset/img/chat_group.png";?>" class="img-rounded img-center img-small img-zoom" alt="Group Chat">
							<?php endif; ?>
						</div>
					</td>
					<td>
						<p>
							<?php if ($count == 1): ?>
								<?php echo $chat_rooms_participant[0]["namadepan"]." ".$chat_rooms_participant[0]["namabelakang"];?>
							<?php else: ?>
								<?php for ($i=0; $i< $count; $i++):
									if ($i < $count-1):
									echo $chat_rooms_participant[$i]["namadepan"]." ".$chat_rooms_participant[$i]["namabelakang"].", ";
										else:
									echo $chat_rooms_participant[$i]["namadepan"]." ".$chat_rooms_participant[$i]["namabelakang"];
									endif;
								endfor; ?>
							<?php endif;?>
						</p>
					</td>
				</tr>
			</table>
		</div>
	</div>


	<div class="panel panel-primary">
		<div class="panel-heading">
			<span class="glyphicon glyphicon-comment"></span> Chat
		</div>
		<div class="panel-body">
			<ul class="chat">
				<?php foreach ($chat as $key => $value): ?>
					<?php if ($value["user_id"] == $this->session->_userskrng): ?>
						<li class="left clearfix bg-info">
							<span class="chat-img pull-left">
								<div class="img-wrapper">
									<?php if ($value["img"] != null): ?>
										<img src="<?php echo base_url()."uploads/". $value["img"];?>" class="img-rounded img-center  img-small img-zoom" alt="<?php echo $value["namadepan"] . ' ' . $value["namabelakang"];?>">
									<?php else: ?>
										<div class="profile-picture-default profile-picture-default-small unselectable form-group"><?php echo strtoupper($chat_rooms_participant[0]["namadepan"][0].$chat_rooms_participant[0]["namabelakang"][0]);?></div>
									<?php endif; ?>
								</div>
							</span>
							<div class="chat-body clearfix">
								<div class="header">
									<strong class="primary-font"><?php echo $value["namadepan"]." ".$value["namabelakang"];?></strong>
									<small class="text-muted">
										<span class="glyphicon glyphicon-time"></span>
										<?php echo $value["datetime"];?>
									</small>
									<div class="pull-right">
										<?php echo form_open("cont", 'class="form-mention" onsubmit="return confirm(\'Do you really want to delete chat?\');"') .
											form_hidden('message_id', $value["id"]) .
											form_hidden('chat_rooms_id', $chat_rooms_id);?>
											<button type="submit" class="btn btn-link" name="c_delchat" value="1"><span aria-hidden="true">&times;</span></button>
										<?php echo form_close();?>
									</div>
								</div>
								<p style="margin-left:40px;">
									<?php if ($value["chat_img"] != null): ?>
										<img src="<?php echo base_url("uploads/").$value["chat_img"];?>" class="img-responsive img-zoom">
									<?php endif; ?>
									<?php echo $value["msg"]; ?>
								</p>
							</div>
						</li>
					<?php else: ?>
						<li class="right clearfix bg-gray">
							<div class="pull-right">
								<?php echo form_open("cont", 'class="form-mention" onsubmit="return confirm(\'Do you really want to delete chat?\');"') .
									form_hidden('message_id', $value["id"]) .
									form_hidden('chat_rooms_id', $chat_rooms_id);?>
									<button type="submit" class="btn btn-link" name="c_delchat" value="1"><span aria-hidden="true">&times;</span></button>
								<?php echo form_close();?>
							</div>
							<span class="chat-img pull-right">
								<div class="img-wrapper">
									<?php if ($value["img"] != null): ?>
										<img src="<?php echo base_url()."uploads/". $value["img"];?>" class="img-rounded img-center  img-small img-zoom" alt="<?php echo $value["namadepan"] . ' ' . $value["namabelakang"];?>">
									<?php else: ?>
										<div class="profile-picture-default profile-picture-default-small unselectable form-group"><?php echo strtoupper($chat_rooms_participant[0]["namadepan"][0].$chat_rooms_participant[0]["namabelakang"][0]);?></div>
									<?php endif; ?>
								</div>
							</span>
							<div class="chat-body clearfix">
								<div class="header">
									<p class="text-right">
										<small class=" text-muted">
											<?php echo $value["datetime"];?>
											<span class="glyphicon glyphicon-time"></span>
										</small>
										<strong class="text-right primary-font"><?php echo $value["namadepan"]." ".$value["namabelakang"];?></strong>
									</p>
								</div>
								<p class="text-right" style="margin-left:40px;">
									<?php if ($value["chat_img"] != null): ?>
										<img src="<?php echo base_url("uploads/").$value["chat_img"];?>" class="img-responsive img-zoom">
									<?php endif; ?>
									<?php echo $value["msg"]; ?>
								</p>
							</div>
						</li>
					<?php endif;?>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="panel-footer">
			<?php echo form_open_multipart("cont");?>
			<?php echo form_hidden('chat_rooms_id', $chat_rooms_id);?>
			<div id="divupload-foto" class="form-group">
				<input id="upload-foto" name="upload-foto" type="file">
			</div>
			<div class="input-group" class="form-group">
				<input id="btn-input" type="text" name="msg" class="form-control" placeholder="Type your message here..." />
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submit" name="c_sendchat" value="1" id="btn-chat">
						Send
					</button>
					<button class="btn btn-default" type="button" id="btn-upload">
						<i class="fa fa-paperclip" aria-hidden="true"></i>
					</button>
				</span>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$("#divupload-foto").hide();
	$("#upload-foto").fileinput({showUpload: false});

	$("#btn-upload").click(function(){
		$("#divupload-foto").toggle("fast");
	});
});
</script>
<?php $this->load->view('layout/footer.php');
