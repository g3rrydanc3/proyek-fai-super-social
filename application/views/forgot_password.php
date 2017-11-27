<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
	<?php if ($this->session->flashdata('goodbye') != null): ?>
		<div class="alert alert-success">
		  <?php echo $this->session->flashdata('goodbye'); ?>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('errors') != null): ?>
		<div class="alert alert-danger">
		  <?php echo $this->session->flashdata('errors'); ?>
		</div>
	<?php endif; ?>
	<?php echo form_open('user/forgot_password_email');?>
			<div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3>Forgot Password</h3>
                    </div>
                    <div class="panel-body">
                       <div class="form-group">
                           <input class="form-control input-lg" placeholder="E-mail" name="email" type="email" autofocus>
                       </div>
                       <!-- Change this to a button or input when using this as a form -->
                       <button type="submit" class="btn btn-lg btn-success btn-block">Reset Password</button>
                    </div>
                </div>
            </div>
        </div>
	<?php echo form_close();?>
</div>
<?php $this->load->view('layout/footer.php');
