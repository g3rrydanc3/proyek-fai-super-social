<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if (!$this->session->is_admin) {
			redirect($this->default_page_not_logged_in);
		}
		$this->load->model("madmin");
	}
	public function index(){
		$this->load->view("admin/home");
	}
	public function user($user = null){
		if ($user == null) {
			$data["user"] = $this->madmin->get_all_user();
			$this->load->view("admin/user", $data);
		}
		else {
			$data["user_data"] = $this->madmin->get_user_data($user);
			$this->load->view("admin/user_data",$data);
		}
	}
	public function user_post($user = null){
		if (!$user == null) {
			//$data;
			$this->load->view("admin/user_post");
		}
		else{
			show_404();
		}
	}
	public function user_data_process(){
		$rulesEditUser = array(
			array(
				'field' => 'namadepan',
				'label' => 'Nama Depan',
				'rules' => 'required|alpha'
			),
			array(
				'field' => 'namabelakang',
				'label' => 'Nama Belakang',
				'rules' => 'required|alpha'
			),
			array(
				'field' => 'email',
				'label' => 'E-mail',
				'rules' => 'required|valid_email'
			),
			array(
				'field' => 'nohp',
				'label' => 'No HP',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|min_length[6]|regex_match["^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]"]'
			),
			array(
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules' => 'required'
			),
			array(
				'field' => 'kodepos',
				'label' => 'Kode Pos',
				'rules' => 'numeric'
			),
			array(
				'field' => 'negara',
				'label' => 'Negara',
				'rules' => 'required'
			),
			array(
				'field' => 'jabatan',
				'label' => 'Jabatan',
				'rules' => 'required'
			),
			array(
				'field' => 'perusahaan',
				'label' => 'Perusahaan',
				'rules' => 'required'
			),
			array(
				'field' => 'bioperusahaan',
				'label' => 'Bio Perusahaan',
				'rules' => ''
			),
			array(
				'field' => 'biouser',
				'label' => 'Bio User',
				'rules' => ''
			)
		);
		$this->form_validation->set_rules($rulesEditUser);

		if($this->form_validation->run()){
			$this->madmin->update_user($this->input->post());
			$this->session->set_flashdata('msg', "Update user berhasil.");
		}
		else{
			$this->session->set_flashdata('errors', validation_errors());
		}
		redirect($this->agent->referrer());
	}

	public function group(){
		$this->load->view("admin/group");
	}
	public function reported_user(){
		$this->load->view("admin/reported_user");
	}
	public function report(){
		$this->load->view("admin/report");
	}
}
?>
