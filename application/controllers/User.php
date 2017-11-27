<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		if ($this->check_logged_in()) {
			redirect($this->default_page);
		}
		else {
			$this->load->view("home");
		}
	}
	public function login(){
		if (!$this->check_logged_in()) {
			$this->load->view('login');
		}
		else redirect("newsfeed");
	}
	public function login_process(){
		if (!$this->check_logged_in()) {
			$emailhp = $this->input->post('emailhp');
			$password = $this->input->post('password');

			$id = $this->mydb->get_id($emailhp);

			$rules = array(
				array(
					'field' => 'emailhp',
					'label' => 'Email / No HP',
					'rules' => 'required|callback_emailhp_check[' . $id . ']'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|callback_password_check[' . $id . ']'
				)
			);
			$this->form_validation->set_rules($rules);

			if($this->form_validation->run()){
				$this->session->set_userdata("_userskrng", $id);
				$this->session_refresh();

				redirect($this->default_page);
			}
			else{
				$this->session->set_flashdata('errors', validation_errors());
				redirect("user/login");
			}
		}
		else redirect($this->default_page);
	}
	public function register(){
		if (!$this->check_logged_in()) {
			$this->load->view("register");
		}
		else redirect($this->default_page);
	}
	public function register_process(){
		if (!$this->check_logged_in()) {
			$this->form_validation->set_rules($this->rulesRegister1);
			$this->form_validation->set_message('regex_match', '{field} harus terdapat huruf kecil, huruf kapital, angka, dan simbol');
			$this->form_validation->set_message('alphamatches', 'Konfirmasi {field} tidak cocok');

			$this->session->set_flashdata('errors', validation_errors());

			if($this->form_validation->run()){
				$namadepan = $this->input->post('namadepan');
				$namabelakang = $this->input->post('namabelakang');
				$email = strtolower($this->input->post('email'));
				$nohp = $this->input->post('nohp');
				$password = $this->input->post('password');

				if ($this->mydb->register($namadepan, $namabelakang, $email, $nohp, $password)) {
					echo "email sent";
				}
			}
			else{
				$this->session->set_flashdata('errors', validation_errors());
				redirect("user/register");
			}
		}
		else redirect($this->default_page);
	}
	public function register_confirm($user_id, $token){
		if ($this->mydb->register_check($user_id, $token)) {
			$data = array(
				"user_id" => $user_id,
				"token" => $token
			);
			$this->load->view("register2", $data);
		}
		else {
			show_404();
		}
	}
	public function register_process2(){
		$user_id = $this->input->post("user_id");
		$token = $this->input->post("token");
		if ($this->mydb->register_check($user_id, $token)) {

			$this->form_validation->set_rules($this->rulesRegister2);

			if($this->form_validation->run()){
				$alamat = $this->input->post('alamat');
				$kodepos = $this->input->post('kodepos');
				$negara = $this->input->post('negara');
				$jabatan = $this->input->post('jabatan');
				$perusahaan = $this->input->post('perusahaan');
				$bioperusahaan = $this->input->post('bioperusahaan');
				$biouser = $this->input->post('biouser');

				if ($this->mydb->set_editprofile($user_id, $alamat, $kodepos, $negara, $jabatan, $perusahaan, $bioperusahaan, $biouser)) {
					$this->mydb->register_confirm($user_id, $token);
					$this->session->set_userdata("_userskrng", $user_id);
					$this->session_refresh();

					redirect($this->default_page);
				}
				else{
					show_404();
				}
			}
			else{
				$this->session->set_flashdata('errors', validation_errors());
				redirect("user/register_confirm/".$user_id."/".$token);
			}
		}
		else show_404();
	}
	public function logout(){
		if ($this->check_logged_in()) {
			$this->session->set_flashdata("goodbye", $this->session->name." berhasil logout!");
			$this->session->unset_userdata("_userskrng");
			$this->session->unset_userdata("name");

			redirect("user");
		}
		else redirect("user/login");
	}
	public function forgot_password(){
		$this->load->view("forgot_password");
	}
	public function forgot_password_process(){
		$email = $this->input->post("email");
		$id = $this->mydb->get_id_from_email($email);
		if ($id != -1) {
			$this->memail->forgot_password($id);
		}
		$this->session->set_flashdata("msg", '<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  <strong>Sukses!</strong> Email terkirim. Cek email untuk reset password.
		</div>');
		redirect("user");
	}



	//-------------------------
	//FORM VALIDATION FALLBACK
	//-------------------------
	public function emailhp_check($str, $id){
		if ($id == -1) {
			$this->form_validation->set_message('emailhp_check', 'Email/No HP tidak terdaftar');
			return false;
		}
		else {
			return true;
		}
	}
	public function password_check($str, $id){
		$password = $this->mydb->get_password($id);
		if ($id == -1) {
			$this->form_validation->set_message('password_check', '');
			return false;
		}
		else if ($str == $password) {
			return true;
		}
		else {
			$this->form_validation->set_message('password_check', 'Password Salah');
			return false;
		}
	}
}
?>
