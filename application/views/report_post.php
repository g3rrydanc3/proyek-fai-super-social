<?php $this->load->view('layout/header.php'); 
	echo "<div class='container wrapper'>";
		echo "<h4>Apa yang sedang terjadi?</h4>";
		echo form_open('Post/report');
			echo form_hidden('id_post', $id_post);
			echo form_radio('report', 'Ini mengganggu atau tidak menarik')."Ini mengganggu atau tidak menarik";
			echo "<br>";
			echo form_radio('report', 'Menurut saya ini tidak seharusnya ada di Facebook')."Menurut saya ini tidak seharusnya ada di Facebook";
			echo "<br>";
			echo form_radio('report', 'Ini adalah spam')."Ini adalah spam";
			echo "<br><br>";
			echo form_submit('lanjut', 'Lanjutkan', "class = 'btn btn-primary'");
		echo form_close();
	echo "</div>";
	$this->load->view('layout/footer.php');
?>