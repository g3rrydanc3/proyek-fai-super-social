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
		else redirect("profile/index");
	}
}
?>
