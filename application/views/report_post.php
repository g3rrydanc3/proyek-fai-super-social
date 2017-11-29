<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	$this->load->view('layout/header.php');
?>
	<div class='container wrapper'>
		<h1>Apa yang sedang terjadi?</h1>
		<?php echo form_open('Post/report_process', 'form-inline');?>
			<?php echo form_hidden('post_id', $post_id);?>
			<div class="radio">
				<label><input type="radio" name="report" value="Ini mengganggu atau tidak menarik.">Ini mengganggu atau tidak menarik.</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="report" value="Menurut saya ini tidak seharusnya ada di SuperSocial.">Menurut saya ini tidak seharusnya ada di SuperSocial.</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="report" value="Ini adalah spam.">Ini adalah spam.</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="report" id='other' value="Other">Lainnya <input type="text" name="other_reason" class="form-control" disabled></label>
			</div>
			<div class="form-group">
				<button type="submit" name="lanjut" value="1" class="btn btn-primary">Lanjutkan</button>
			</div>
		<?php echo form_close();?>
	</div>
	<script>
		$(document).ready(function () {
			$("input[name='report']").change(function() {
				if ($("#other").prop("checked")){
					$('input:text[name="other_reason"]').prop('disabled', false);
				}
				else {
					$('input:text[name="other_reason"]').prop('disabled', true);
				}
			});
		});
	</script>
<?php $this->load->view('layout/footer.php');?>
