<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		if ($this->check_logged_in()) {
			redirect("profile");
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

				redirect("newsfeed");
			}
			else{
				$this->session->set_flashdata('errors', validation_errors());
				redirect("user/login");
			}
		}
		else redirect("newsfeed");
	}
	public function register(){
		if (!$this->check_logged_in()) {
			$this->load->view("register");
		}
		else redirect("profile/index");
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

				if (!$this->mydb->register($namadepan, $namabelakang, $email, $nohp, $password)) {
					echo "INSERT ERROR";
				}else{
					$id = $this->mydb->get_id($email);
					$this->session->set_userdata("_userskrng", $id);
					$this->session_refresh();
					$this->load->view("register2");
				}
			}
			else{
				$this->session->set_flashdata('errors', validation_errors());
				redirect("user/register");
			}
		}
		else redirect("newsfeed");
	}
	public function register_process2(){
		if ($this->check_logged_in()) {
			$this->form_validation->set_rules($this->rulesRegister2);

			if($this->form_validation->run()){
				$alamat = $this->input->post('alamat');
				$kodepos = $this->input->post('kodepos');
				$negara = $this->input->post('negara');
				$jabatan = $this->input->post('jabatan');
				$perusahaan = $this->input->post('perusahaan');
				$bioperusahaan = $this->input->post('bioperusahaan');
				$biouser = $this->input->post('biouser');

				if (!$this->mydb->set_editprofile($this->session->_userskrng, $alamat, $kodepos, $negara, $jabatan, $perusahaan, $bioperusahaan, $biouser)) {
					echo "UPDATE ERROR";
				}

				redirect("newsfeed");
			}
			else{
				$this->session->set_flashdata('errors', validation_errors());
				$this->load->view("register2");
			}
		}
		else redirect("user/login");
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
