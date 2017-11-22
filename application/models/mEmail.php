<?php
	class mEmail extends CI_Model {
		public function forgot_password($user_id){
			$userdata = $this->mydb->get_userdata($user_id);
		}

		public function register_confirm(){
			$msg = "

			";
			$this->email->from('your@example.com', 'Your Name');
			$this->email->to('suryagerry@outlook.com');
			$this->email->cc('');
			$this->email->bcc('');

			$this->email->set_mailtype("html");
			$this->email->subject('Super Social - Confirm your email');
			$this->email->message($msg);

			if ($this->email->send()) {
				echo "email sent.";
			}
			else {
				echo $this->email->print_debugger();
			}
		}
	}
?>
