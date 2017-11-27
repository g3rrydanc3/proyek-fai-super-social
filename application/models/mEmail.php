<?php
	class mEmail extends CI_Model {
		public function forgot_password($user_id){
			$userdata = $this->mydb->get_userdata($user_id);
		}

		public function register_confirm($user_id, $nama, $email, $token){
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
				echo "email sent.";
			}
			else {
				echo $this->email->print_debugger();
			}
		}
	}
?>
