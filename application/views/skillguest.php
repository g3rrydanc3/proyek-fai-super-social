<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
	<h1><?php echo $namadepan.' '. $namabelakang;?>'s Skill</h1>
	<?php if (count($skill) > 0): ?>
		<table class="table">
			<tr>
				<th>Nama Skill</th><th>Jumlah Endorse</th><th>Action</th>
			</tr>
			<?php foreach ($skill as $key => $value): ?>
				<!--MODAL-->
				<div id="myModal<?php echo $value["id"];?>" class="modal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"onclick="closeModal('<?php echo $value["id"];?>')">&times;</button>
							</div>
							<div class="modal-body">
								<p>
									<?php if ($value["jumlahendorse"] != "0") :?>
										<ul class="list-group">
										<?php foreach ($value["endorse"] as $key1 => $value1) :?>
											<li class="list-group-item"><?php echo $value1['namadepan'] . ' ' . $value1['namabelakang'];?></li>
										<?php endforeach;?>
										</ul>
									<?php else :?>
										Tidak ada endorse
									<?php endif;?>
								</p>
							</div>
						</div>
					</div>
				</div>
				<!--END OF MODAL-->

				<tr>
					<td><?php echo "<a href='#' onclick='showModal(" . $value["id"] . ")'>". $value["nama"] . "</a>"; ?></td>
					<td><?php echo $value["jumlahendorse"]; ?></td>
					<td>
						<?php
							echo form_open("cont");
							echo form_hidden('skill_id', $value["id"]);
							echo form_hidden('friend_id', $friend_id);
							if (!in_array_r($this->session->_userskrng, $value["endorse"])) {
								echo form_submit("pg_endorse", "Endorse", "class='btn btn-primary'");
							}
							else{
								echo form_submit("pg_endorse", "Unendorse", "class='btn btn-primary'");
							}
							echo form_close();
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		Belum ada skill.
	<?php endif; ?>

<?php $this->load->view('layout/footer.php');
