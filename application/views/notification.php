<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
	<h1>Friend Request</h1>
	<?php if (count($friends_request) != 0): ?>
		<table class="table table-striped">
			<tr><th>Nama</th><th>Waktu</th><th>Action</th></tr>
			<?php foreach ($friends_request as $key => $value): ?>
				<tr>
					<td>
						<?php echo $value['namadepan'] . " " . $value['namabelakang'];?>
					</td>
					<td>
						<?php echo $value['datetime'];?>
					</td>
					<td>
						<?php echo form_open('cont') .
						form_hidden('friend_id', $value['user_id1']) .
						form_submit('n_acceptfriend', 'Accept') . form_submit('n_removefriend', 'Decline');?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		Tidak ada Friend Request.
	<?php endif; ?>

	<h1>Chat</h1>
	<?php if ($chat != 0): ?>
		Ada <?php echo $chat; ?> room belum terbaca.
	<?php else: ?>
		Tidak ada notification chat.
	<?php endif; ?>

	<h1>Notification</h1>
	<?php if (count($notification)): ?>
		<table class="table table-striped">
			<tr><th class="td-fit">Tanggal</th><th>Notification</th></tr>
			<?php foreach ($notification as $key => $value): ?>
				<tr><td class="td-fit"><?php echo $value['datetime'];?></td>
					<td><?php echo $value['msg'];?></td></tr>
			<?php endforeach; ?>
		</table>
		<?php echo $links;?>
	<?php else: ?>
		Tidak ada Notification.
	<?php endif; ?>

<?php $this->load->view('layout/footer.php');
