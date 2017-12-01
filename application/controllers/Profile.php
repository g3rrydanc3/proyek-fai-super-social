<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		if ($this->check_logged_in()) {
			$config['base_url'] = site_url("profile/index");
			$config['total_rows'] = $this->mydb->count_userposts($this->session->_userskrng);
			$config['per_page'] = 7;
			$config['uri_segment'] = 3;
			$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();

			$data += $this->mydb->get_userposts($this->session->_userskrng, $this->session->_userskrng, $config["per_page"],$page);
			$data += $this->datapost = $this->mydb->get_userdata($this->session->_userskrng);
			$data["skill"] = $this->mydb->get_skill($this->session->_userskrng, 3);
			$data["controller"] = "post";

			$this->load->view('profile', $data);
		}
		else redirect("cont/login");
	}
	public function edit_profile(){
		if ($this->check_logged_in()) {
			$data = $this->datapost = $this->mydb->get_userdata($this->session->_userskrng);
			$this->load->view('editprofile', $data);
		}
		else redirect("cont/login");
	}
	public function edit_profile_process(){
		$this->form_validation->set_rules($this->rulesRegister2);

		if($this->form_validation->run()){
			$id = $this->session->_userskrng;
			$alamat = $this->input->post('alamat');
			$kodepos = $this->input->post('kodepos');
			$negara = $this->input->post('negara');
			$jabatan = $this->input->post('jabatan');
			$perusahaan = $this->input->post('perusahaan');
			$bioperusahaan = $this->input->post('bioperusahaan');
			$biouser = $this->input->post('biouser');
			$private = $this->input->post('private');

			if (!$this->mydb->set_editprofile($id, $alamat, $kodepos, $negara, $jabatan, $perusahaan, $bioperusahaan, $biouser, $private)) {
				echo "UPDATE ERROR";
			}

			redirect("profile/index");
		}
		else{
			$this->session->set_flashdata('errors', validation_errors());
			redirect("profile/edit_profile");
		}
	}
	public function edit_account(){
		if ($this->check_logged_in()) {
			$data = $this->datapost = $this->mydb->get_userdata($this->session->_userskrng);
			$this->load->view('editaccount', $data);
		}
		else redirect("cont/login");
	}
	public function edit_account_process(){
		$this->form_validation->set_rules($this->ruleseditaccount);
		$this->form_validation->set_message('regex_match', '{field} harus terdapat huruf kecil, huruf kapital, angka, dan simbol');
		$this->form_validation->set_message('alphamatches', 'Konfirmasi {field} tidak cocok');

		if($this->form_validation->run()){
			$id = $this->session->_userskrng;
			$namadepan = $this->input->post('namadepan');
			$namabelakang = $this->input->post('namabelakang');
			$email = strtolower($this->input->post('email'));
			$nohp = $this->input->post('nohp');
			$password = $this->input->post('password');

			if (!$this->mydb->set_editaccount($id, $namadepan, $namabelakang, $email, $nohp, $password)) {
				echo "UPDATE ERROR";
			}

			redirect("profile/index");
		}
		else{
			$this->session->set_flashdata('errors', validation_errors());
			redirect("profile/edit_account");
		}
	}
	public function edit_account_process_password(){
		$password = $this->input->post("password");
		$password2 = $this->input->post("password2");

		$this->form_validation->set_rules($this->rulesgantipassword);

		if($this->form_validation->run()){
			$this->mydb->change_password($this->session->_userskrng, $password);
			$this->session->set_flashdata("msg", "<b>Sukses</b>, penggantian password berhasil");
			redirect(site_url());
		}
		else {
			$this->session->set_flashdata('errors_password', validation_errors());
			redirect("profile/edit_account");
		}
	}
	public function upload_foto(){
		if (empty($_FILES['userfile'])) {
			echo json_encode(['error'=>'No files found for upload.']);
			return;
		}
		if(!$this->upload->do_upload('userfile')){
			$this->session->set_flashdata("uploaderror", $this->upload->display_errors());
			echo json_encode(array('error' => $this->upload->display_errors()));
		}
		else{
			$filename = $this->upload->data()["file_name"];
			$this->mydb->set_editprofilepicture($this->session->_userskrng, $filename);
			echo json_encode(array());
		}
		//redirect("profile/index");
	}
	public function upload_music(){
		$config['upload_path']          = './uploads/';
		$config['overwrite']           = true;
		$config['encrypt_name']           = true;
		$config['allowed_types'] = 'ogg|mp3|wav';
		$this->upload->initialize($config);
		if (empty($_FILES['upload-music'])) {
			return;
		}
		if(!$this->upload->do_upload('upload-music')){
			$this->session->set_flashdata("uploaderror", $this->upload->display_errors());
		}
		else{
			$filename = $this->upload->data()["file_name"];
			$filenameori = $this->upload->data()["orig_name"];
			$this->mydb->set_editprofilemusic($this->session->_userskrng, $filename, $filenameori);
		}
		redirect("profile/edit_profile");
	}
}
?>
