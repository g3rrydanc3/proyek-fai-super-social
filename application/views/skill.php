<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
	<h1>Skill</h1>
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
						?>
						<button type="submit" class="btn-delpost" name="as_delete" value="X"><i class="fa fa-times" aria-hidden="true"></i></button>
						<?php echo form_close();?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		Belum ada skill.
	<?php endif; ?>

	<h2>Add Skill</h2>

	<?php if ($this->session->flashdata("error_maxskill") != null): ?>
		<div class="alert alert-danger">
		  <?php echo $this->session->flashdata("error_maxskill"); ?>
		</div>
	<?php endif; ?>

	<?php	echo form_open("cont", "class='form-horizontal'");?>
		<div class="form-group">
			<label class="control-label col-sm-2" for="namaskill">Nama skill:</label>
			<div class="col-sm-10">
				<input type="namaskill" class="form-control" id="namaskill" name="namaskill" placeholder="Enter nama skill">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary" name="as_add" value="Add skill">Add skill</button>
			</div>
		</div>
	<?php echo form_close();?>

<?php $this->load->view('layout/footer.php');
