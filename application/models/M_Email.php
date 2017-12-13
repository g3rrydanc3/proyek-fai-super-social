<?php
	class M_Email extends CI_Model {
		public function e_register_confirm($user_id, $nama, $email, $token){
			$link = site_url("user/register_confirm/").$user_id."/".$token;
			$dataemail = array(
				"nama" => $nama,
				"email" => $email,
				"link" => $link
			);

			$this->email->from('your@example.com', "Super Social");
			$this->email->to($email);
			$this->email->cc('');
			$this->email->bcc('');

			$this->email->set_mailtype("html");
			$this->email->subject('Super Social - Confirm your email');
			$this->email->message($this->load->view('email_template/register_confirm',$dataemail,TRUE));

			if ($this->email->send()) {
				return true;
			}
			else {
				return false;
				echo $this->email->print_debugger();
			}
		}

		public function e_forgot_password($user_id, $nama, $email, $token){
			$link = site_url("user/forgot_password/").$user_id."/".$token;
			$dataemail = array(
				"nama" => $nama,
				"email" => $email,
				"link" => $link
			);

			$this->email->from('your@example.com', "Super Social");
			$this->email->to($email);
			$this->email->cc('');
			$this->email->bcc('');

			$this->email->set_mailtype("html");
			$this->email->subject('Super Social - Forgot your password?');
			$this->email->message($this->load->view('email_template/forgot_password',$dataemail,TRUE));

			if ($this->email->send()) {
				return true;
			}
			else {
				return false;
				echo $this->email->print_debugger();
			}
		}
	}
?>
