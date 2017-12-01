<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Group extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index($group_id = null){
		if (!$group_id == null) {
			if ($this->check_logged_in()) {
				redirect("group/tentang/". $group_id);
			}
			else redirect("cont/login");
		}
		else {
			show_404();
		}
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
			$this->mydb->join_group($this->session->_userskrng, $group_id);
			$this->session->set_flashdata("msg", "Berhasil masuk grup.");
			redirect($this->agent->referrer());
		}
	}

	public function leave(){
		if ($this->input->post("leave")) {
			$group_id = $this->input->post("group_id");
			$this->mydb->leave_group($this->session->_userskrng, $group_id);
			$this->session->set_flashdata("msg", "Berhasil keluar grup.");
			redirect($this->agent->referrer());
		}
	}
}
?>
