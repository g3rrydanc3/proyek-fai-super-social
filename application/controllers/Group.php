<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Group extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		if ($this->check_logged_in()) {
			$data["group"] = $this->mydb->get_group($this->session->_userskrng);
			$data["browsegroup"] = $this->mydb->get_group_browse($this->session->_userskrng);
			$this->load->view('group/home', $data);
		}
		else redirect("cont/login");
	}
	public function tentang($group_id = null){
		if (!$group_id == null) {
			if ($this->check_logged_in()) {
				$data["tentang"] = $this->mydb->get_group_tentang($group_id);
				$data["group_id"] = $group_id;
				$data["is_user_member"] = $this->mydb->is_user_member($group_id, $this->session->_userskrng);
				$this->load->view('group/tentang', $data);
			}
			else redirect("cont/login");

		}
		else {
			show_404();
		}
	}
	public function diskusi($group_id = null){
		if (!$group_id == null) {
			if ($this->check_logged_in()) {
				$data["tentang"] = $this->mydb->get_group_tentang($group_id);
				$data["group_id"] = $group_id;
				$data["is_user_member"] = $this->mydb->is_user_member($group_id, $this->session->_userskrng);
				$data += $this->mydb->get_group_posts($group_id);
				$data["links"] = null;
				$data["controller"] = "group_post";

				$this->load->view('group/diskusi', $data);
			}
			else redirect("cont/login");
		}
		else {
			show_404();
		}
	}
	public function member($group_id = null){
		if (!$group_id == null) {
			if ($this->check_logged_in()) {
				$data["tentang"] = $this->mydb->get_group_tentang($group_id);
				$data["group_id"] = $group_id;
				$data["is_user_member"] = $this->mydb->is_user_member($group_id, $this->session->_userskrng);

				$data["member"] = $this->mydb->get_group_member($group_id);
				$this->load->view('group/member', $data);
			}
			else redirect("cont/login");
		}
		else {
			show_404();
		}
	}
	public function join(){
		if ($this->input->post("join")) {
			$group_id = $this->input->post("group_id");
			$this->mydb->join_group($group_id, $this->session->_userskrng);
			$this->session->set_flashdata("msg", "Berhasil masuk grup.");
			redirect($this->agent->referrer());
		}
	}
	public function leave(){
		if ($this->input->post("leave")) {
			$group_id = $this->input->post("group_id");
			$this->mydb->leave_group($group_id, $this->session->_userskrng);
			$this->session->set_flashdata("msg", "Berhasil keluar grup.");
			redirect($this->agent->referrer());
		}
	}
	public function create(){
		$this->load->view("group/create");
	}
	public function create_process(){
		$name = $this->input->post("name");
		$description = $this->input->post("description");

		$this->form_validation->set_rules('name', 'Group name', 'required');
		$this->form_validation->set_rules('description', 'Group description', 'required');

		if ($this->form_validation->run()){
			if ($_FILES["upload-foto"]["name"] != "") {
				if(!$this->upload->do_upload('upload-foto')){
					$this->session->set_flashdata("msg", $this->upload->display_errors());
					$this->session->set_flashdata("data_post", array("name" => $name, "description" => $description));
					echo $this->upload->display_errors();
					redirect("group/create");
				}
				else{
					$filename = $this->upload->data()["file_name"];
					$group_id = $this->mydb->create_group($name, $description, $this->session->_userskrng, $filename);
					redirect("group/tentang/".$group_id);
				}
			}
			else {
				$group_id = $this->mydb->create_group($name, $description, $this->session->_userskrng);
				redirect("group/tentang/".$group_id);
			}
		}
		else {
			$this->session->set_flashdata("msg", validation_errors());
			$this->session->set_flashdata("data_post", array("name" => $name, "description" => $description));
			redirect("group/create");
		}
	}
}
?>
