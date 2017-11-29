<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if (!$this->session->is_admin) {
			redirect($this->default_page_not_logged_in);
		}
	}
	public function index(){
		$this->load->view("admin/dashboard");
	}
}
?>
