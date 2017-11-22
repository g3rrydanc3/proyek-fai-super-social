<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Newsfeed extends MY_Controller {
	private $referrer;
	public function __construct(){
		parent::__construct();
		if (!$this->check_logged_in()) {
			redirect($this->default_page);
		}
	}
	public function index(){
		$config['base_url'] = site_url("cont/newsfeed");
		$config['total_rows'] = $this->mydb->count_newsfeed($this->session->_userskrng);
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();

		$data += $this->datapost = $this->mydb->get_userdata($this->session->_userskrng) + $this->mydb->get_newsfeed($this->session->_userskrng, $config["per_page"], $page);
		$this->load->view('newsfeed', $data);
	}
}
?>
