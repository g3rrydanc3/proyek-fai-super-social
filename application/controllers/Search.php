<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		redirect("search/user");
	}

	public function user($keyword = null){
		if ($this->check_logged_in()) {
			$this->load->view("search/user", array("keyword" => $keyword));
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function user_data(){
		if ($this->check_logged_in()) {
			$config['base_url'] = site_url("cont/explore");
			$config['total_rows'] = $this->mydb->count_explore($this->session->_userskrng, $this->input->get("keyword"));
			$config['per_page'] = 8;
			$config['uri_segment'] = 3;
			$config['enable_query_strings'] = true;
			$config['page_query_string'] = TRUE;
			$config['cur_tag_open'] = '<li><a href="#">';
			$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();

			$data += $this->mydb->get_userposts($this->session->_userskrng, $this->session->_userskrng);
			$data['dataexplore'] = $this->mydb->get_explore($this->session->_userskrng, $config["per_page"],$page, $this->input->get("keyword"), $this->input->get("sortby"), $this->input->get("sort"));
			$data['friends_requested'] = $this->mydb->get_friends_requested($this->session->_userskrng);
			$data['friends_request'] = $this->mydb->get_friends_request($this->session->_userskrng);
			$data['friends'] = $this->mydb->get_friends($this->session->_userskrng);

			$this->load->view("search/user_data", $data);
		}
		else redirect($this->default_page_not_logged_in);
	}

	public function hashtag($hashtag = null){
		if ($this->input->post("hashtag")) {
			redirect("search/hashtag/".$this->input->post("hashtag"));
		}
		$data = array(
			"hashtag" => $hashtag
		);
		if ($hashtag != null) {
			$data += $this->mydb->get_post_from_hashtag($hashtag, $this->session->_userskrng);
			$data["links"] = null;
		}

		$this->load->view("search/hashtag", $data);
	}
	public function group($group = null){
		if ($this->input->post("group")) {
			redirect("search/group/".$this->input->post("group"));
		}
		$data = array(
			"group" => $group
		);
		if ($group != null) {
			$data["result"]= $this->mydb->get_group_from_search($group);
			$data["links"] = null;
		}

		$this->load->view("search/group", $data);
	}
}
?>
