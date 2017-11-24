<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<h1>Chat</h1>
	<?php if ($this->session->flashdata('errors') != null): ?>
		<div class="alert alert-danger">
		  <?php echo $this->session->flashdata('errors'); ?>
		</div>
	<?php endif; ?>
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">
					<a data-toggle="collapse" href="#collapse1">Tambah Chat</a>
				</h2>
			</div>
			<div id="collapse1" class="panel-collapse collapse">
				<div class="panel-body">
					<small>Asumsi yang ditampilkan hanya yang sudah berteman</small>
					<?php echo form_open("cont");?>
						<?php if ($friends !=null) :?>
							<div class="row">
								<?php foreach ($friends as $key => $value) :?>
									<div class="col-md-2 col-sm-3">
										<div class="checkbox">
											<label>
												<?php if ($value["img"] != null): ?>
													<img src="<?php echo base_url()."uploads/". $value["img"];?>" class="img-rounded img-center  img-small img-zoom" alt="<?php echo $value["namadepan"] . ' ' . $value["namabelakang"];?>">
												<?php else: ?>
													<div class="profile-picture-default profile-picture-default-small unselectable form-group"><?php echo strtoupper($value["namadepan"][0].$value["namabelakang"][0]);?></div>
												<?php endif; ?>
												<input type="checkbox" name="friends[]" value="<?php echo $value["id"];?>"><?php echo $value["namadepan"]." ".$value["namabelakang"];?>
											</label>
										</div>
									</div>
								<?php endforeach;?>
							</div>
							<button type="submit" class="btn btn-primary" name="c_newroom" value="Create new room">Create new room</button>
							<!--<<button type="submit" class="btn btn-primary" name="c_newprivateroom" value="Create new room">Create new private room</button>-->
						<?php else:?>
							<div class="alert alert-warning">
								Belum ada teman.
							</div>
							<button type="submit" class="btn btn-primary" name="c_newroom" value="Create new room" disabled>Create new room</button>
							<!--<button type="submit" class="btn btn-primary" name="c_newprivateroom" value="Create new room" disabled>Create new private room</button>-->
						<?php endif;?>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>


	<?php foreach ($chat as $key => $value): ?>
		<a href="<?php echo site_url("cont/chat_room/").$value["id"]?>" class="no-style">
			<div class="media">
				<div class="media-left">
					<div class="img-wrapper-small">
						<?php $count = count($value["participant"]);?>
						<?php if ($count == 1): ?>
							<?php if ($value["participant"][0]["img"] != null): ?>
								<img src="<?php echo base_url()."uploads/". $value["participant"][0]["img"];?>" class="img-rounded img-center profile-picture-50" alt="<?php echo $value["participant"][0]["namadepan"] . ' ' . $value["participant"][0]["namabelakang"];?>">
							<?php else: ?>
								<div class="profile-picture-default profile-picture-default-small unselectable form-group profile-picture-50"><?php echo strtoupper($value["participant"][0]["namadepan"][0].$value["participant"][0]["namabelakang"][0]);?></div>
							<?php endif; ?>
						<?php else: ?>
							<img src="<?php echo base_url()."asset/img/chat_group.png";?>" class="img-rounded img-center profile-picture-50" alt="Group Chat">
						<?php endif; ?>
						<?php if ($value["read"] == "0"): ?>
							<span class="badge badge-notify">&nbsp;</span>
						<?php endif;?>
					</div>
				</div>
				<div class="media-body">
					<h4 class="media-heading">
						<?php if ($count == 1): ?>
							<?php echo $value["participant"][0]["namadepan"]." ".$value["participant"][0]["namabelakang"];?>
						<?php else: ?>
							<?php for ($i=0; $i< $count; $i++):
								if ($i < $count-1):
								echo $value["participant"][$i]["namadepan"]." ".$value["participant"][$i]["namabelakang"].", ";
									else:
								echo $value["participant"][$i]["namadepan"]." ".$value["participant"][$i]["namabelakang"];
								endif;
							endfor; ?>
						<?php endif;?>
					</h4>
					<p><?php echo $value['last_msg_time']; ?></p>
					<p>
						<?php if ($value['last_msg'] != null) {
							echo "Last message : ".$value['last_msg_namadepan']." ".$value['last_msg_namabelakang']." : ".$value['last_msg'];
						}
						else {
							echo "<small>Tidak ada chat.</small>";
						}
						?>
					</p>
				</div>
			</div>
		</a>
		<hr>
	<?php endforeach; ?>


<?php echo $links;?>
</div>
<?php $this->load->view('layout/footer.php');
