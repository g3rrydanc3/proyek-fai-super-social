<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<h1>Chat Room</h1>
	<?php
	echo form_open("cont", 'class="form-mention"') .
		form_hidden('chat_rooms_id', $chat_rooms_id).
		form_hidden("private", "1");

	echo form_submit("c_adduserview", "Add user", "class='btn btn-primary'");
	echo form_submit("c_endchat", "End chat", "class='btn btn-primary'");
	echo form_close();
	?>

	<table class="table">
		<?php $chatotherpeople = false;?>
			<?php foreach ($chat as $key => $value): ?>
				<tr>
				<?php if ($value["user_id"] == $this->session->_userskrng): ?>
					<td class="rowblue td-50">
							<?php echo $value["namadepan"]." ".$value["namabelakang"]." (".$value["datetime"].")"; ?>
							<?php echo form_open("cont", 'class="form-mention"') .
								form_hidden('message_id', $value["id"]) .
								form_hidden('chat_rooms_id', $chat_rooms_id).
								form_submit("c_delchat", "X", "class='btn btn-primary'") .
								form_hidden("private", "1") .
								form_close();
							?>
							<br>
							<?php echo $value["msg"]; ?>
					</td>
				<?php else: ?>
					<?php $chatotherpeople = true;?>
					<td></td>
					<td class="rowgray td-50">
						<?php echo $value["namadepan"]." ".$value["namabelakang"]." (".$value["datetime"].")"; ?>
						<?php echo form_open("cont", 'class="form-mention"') .
							form_hidden('message_id', $value["id"]).
							form_hidden('chat_rooms_id', $chat_rooms_id).
							form_submit("c_delchat", "X", "class='btn btn-primary'") .
							form_hidden("private", "1") .
							form_close();?>
						<br>
						<?php echo $value["msg"]; ?>
					</td>
				<?php endif; ?>
				</tr>
			<?php endforeach; ?>
			<?php if (!$chatotherpeople): ?>
				<tr><td></td><td></td></tr>
			<?php endif; ?>
	</table>
	<?php echo form_open("cont", 'class="form-mention form-inline"') .
		form_hidden('chat_rooms_id', $chat_rooms_id).
		form_input("msg", "", "class='form-control'") .
		form_hidden("private", "1") .
		form_submit("c_sendchat", "Send", "class='btn btn-primary'");?>
</div>
<?php $this->load->view('layout/footer.php');
