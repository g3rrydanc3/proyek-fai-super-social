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
					'label' => 'Email',
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
				if ($this->mydb->get_account_activated($emailhp)) {
					$this->session->set_userdata("_userskrng", $id);
					$this->session_refresh();

					redirect($this->default_page);
				}
				else {
					$this->session->set_flashdata('errors', "Akun ini belum melakukan konfirmasi email.");
					redirect("user/login");
				}
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

			$namadepan = $this->input->post('namadepan');
			$namabelakang = $this->input->post('namabelakang');
			$email = strtolower($this->input->post('email'));
			$nohp = $this->input->post('nohp');
			$password = $this->input->post('password');

			if ($this->mydb->get_id($email) != -1) {
				$this->session->set_flashdata('errors', "Email sudah dipakai.");
				redirect("user/register");
			}
			else if($this->form_validation->run()){
				if ($this->mydb->register($namadepan, $namabelakang, $email, $nohp, $password)) {
					$this->session->set_flashdata("msg", "<b>Sukses</b>, proses registrasi berhasil. Email konfirmasi anda sudah di kirim.");
				}
				else {
					$this->session->set_flashdata("msg", "<b>Gagal</b>.");
				}
				redirect(site_url());
			}
			else{
				$this->session->set_flashdata('errors', validation_errors());
				redirect("user/register");
			}
		}
		else redirect($this->default_page);
	}
	public function register_confirm($user_id = null, $token = null){
		if (!$this->check_logged_in()) {
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
		} else redirect($this->default_page);
	}
	public function register_process2(){
		$user_id = $this->input->post("user_id");
		$token = $this->input->post("token");
		if ($user_id != null || $token != null) {
			show_404();
		}
		else if ($this->mydb->register_check($user_id, $token)) {

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

					$this->mydb->delete_token_confirmation($user_id);

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
	public function forgot_password($user_id = null, $token = null){
		if (!$this->check_logged_in()) {
			if ($this->mydb->forgot_password_check($user_id, $token)) {
				$data = array(
					"user_id" => $user_id,
					"token" => $token
				);
				$this->load->view("reset_password", $data);
			}
			else if ($user_id != null || $token != null) {
				show_404();
			}
			else {
				$this->load->view("forgot_password");
			}
		}
		else redirect("newsfeed");
	}
	public function forgot_password_email(){
		$email = $this->input->post("email");
		$this->mydb->request_forgot_password($email);
		$this->session->set_flashdata("msg", '<strong>Sukses!</strong> Email terkirim. Cek email untuk reset password.');
		redirect("user");
	}
	public function forgot_password_process(){
		$user_id = $this->input->post("user_id");
		$token = $this->input->post("token");
		$password = $this->input->post("password");
		$password2 = $this->input->post("password2");

		$this->form_validation->set_rules($this->rulesgantipassword);

		if($this->form_validation->run()){
			$this->mydb->change_password($user_id, $password);
			$this->mydb->delete_token_password($user_id);
			$this->session->set_flashdata("msg", "<b>Sukses</b>, penggantian password berhasil, silahkan login.");
			redirect(site_url());
		}
		else {
			$this->session->set_flashdata('errors', validation_errors());
			redirect("user/forgot_password/".$user_id."/".$token);
		}
	}
	public function reportuser($user_id){
		if ($this->check_logged_in()) {
			$data['user_id'] = $user_id;
			$this->load->view('report_user', $data);
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function report_process() {
		if ($this->check_logged_in()) {
			$reason = $this->input->post('report');
			$user_id_reporter = $this->session->userdata('_userskrng');
			$other_reason = $this->input->post('other_reason');
			if ($reason == "Other") {
				$reason = $other_reason;
			}

			$user_id_reported = $this->input->post("user_id");

			$this->mydb->insert_report($user_id_reporter, $user_id_reported, null, $reason);
			$this->session->set_flashdata('msg', 'Terimakasih, report Anda akan kami proses.');
			redirect($this->default_page);
		}
		else redirect($this->default_page_not_logged_in);
	}



	//-------------------------
	//FORM VALIDATION FALLBACK
	//-------------------------
	public function emailhp_check($str, $id){
		if ($id == -1) {
			$this->form_validation->set_message('emailhp_check', 'Email tidak terdaftar');
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
