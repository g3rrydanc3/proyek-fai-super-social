<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
	<h1>Chat</h1>
	<?php echo form_open("cont");?>
	<?php echo form_hidden('chat_rooms_id', $chat_rooms_id);?>
	<?php if (isset($private)) :?>
		<?php echo form_hidden("private", "1");?>
	<?php endif;?>
		<?php if ($friends !=null) :?>
			<?php foreach ($friends as $key => $value) :?>
				<div class="checkbox">
					<label><input type="checkbox" name="friends[]" value="<?php echo $value["id"];?>"><?php echo $value["namadepan"]." ".$value["namabelakang"];?></label>
				</div>
			<?php endforeach;?>
			<button type="submit" class="btn btn-primary" name="c_adduser" value="Add User">Add User</button>
		<?php else:?>
			<div class="alert alert-warning">
				Belum ada teman.
			</div>
			<button type="submit" class="btn btn-primary" name="c_adduser" value="Add User" disabled>Add User</button>
		<?php endif;?>
	<?php echo form_close();?>
	<?php
	echo form_open("cont");
	echo form_hidden('chat_rooms_id', $chat_rooms_id);
	if (isset($private)) {
		echo form_hidden("private", "1");
	}

	if ($friends !=null) {
		foreach ($friends as $key => $value) {
			echo form_checkbox("friends[]", $value["id"], false, "id = '".$value['id']."'");
			echo "<label for = '".$value['id']."'>".$value["namadepan"]." ".$value["namabelakang"]."</label>";
			echo "<br>";
		}
		echo form_submit("c_adduser", "Add User", "class='btn btn-primary'");
	}
	else {
		echo "<small>Belum ada teman.</small><br>";
		echo form_submit("c_adduser", "Add User", "class='btn btn-primary' disabled");
	}

	echo form_close();
	?>
<?php $this->load->view('layout/footer.php');
