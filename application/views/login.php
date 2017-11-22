<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
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
	<?php echo form_open('user/login_process');?>
			<div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3>Please Log in</h3>
                    </div>
                    <div class="panel-body">
                       <div class="form-group">
                           <input class="form-control input-lg" placeholder="E-mail / No HP" name="emailhp" type="email" autofocus>
                       </div>
                       <div class="form-group">
                           <input class="form-control input-lg" placeholder="Password" name="password" type="password" value="">
                       </div>
                       <!-- Change this to a button or input when using this as a form -->
                       <button type="submit" name="l_login" class="btn btn-lg btn-success btn-block">Login</button>
                       <a href="<?php echo site_url("user/register");?>"<button type="submit" class="btn btn-info btn-block btn-lg">Register</button></a>
                    </div>
                </div>
            </div>
        </div>
	<?php echo form_close();?>

<?php $this->load->view('layout/footer.php');
