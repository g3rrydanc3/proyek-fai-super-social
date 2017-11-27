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
	public function edit_account(){
		if ($this->check_logged_in()) {
			$data = $this->datapost = $this->mydb->get_userdata($this->session->_userskrng);
			$this->load->view('editaccount', $data);
		}
		else redirect("cont/login");
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
