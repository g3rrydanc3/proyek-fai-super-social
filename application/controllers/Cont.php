<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cont extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		if (!$this->session->userdata('_userskrng')) {
			redirect($this->default_page);
		}
		else {
			//-----------------------------------------------------
			//EDIT PROFILE
			//-----------------------------------------------------
			if($this->input->post('editprofile')){
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
					$data = $this->datapost = $this->mydb->get_userdata($this->session->_userskrng);
					$this->load->view('editprofile', $data);
				}
			}
			else if($this->input->post('editaccount')){
				$this->form_validation->set_rules($this->rulesRegister1);
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
					$data = $this->datapost = $this->mydb->get_userdata($this->session->_userskrng);
					$this->load->view('editaccount', $data);
				}
			}
			//-----------------------------------------------------
			//EXPLORE
			//-----------------------------------------------------
			else if($this->input->post('e_addfriend')){
				$friend_id = $this->input->post('friend_id');
				$this->mydb->request_friend($this->session->_userskrng, $friend_id);

				redirect("cont/explore");
			}
			else if($this->input->post('e_removefriend')){
				$friend_id = $this->input->post('friend_id');
				$this->mydb->remove_friend($this->session->_userskrng, $friend_id);

				redirect("cont/explore");
			}
			else if($this->input->post('e_acceptfriend')){
				$friend_id = $this->input->post('friend_id');
				$this->mydb->accept_friend($this->session->_userskrng, $friend_id);

				redirect("cont/explore");
			}
			//-----------------------------------------------------
			//PROFILE GUEST
			//-----------------------------------------------------
			else if($this->input->post('profileuser')){
				$friend_id = $this->input->post('friend_id');
				redirect("cont/user/". $friend_id);
			}
			else if($this->input->post('pg_addfriend')){
				$friend_id = $this->input->post('friend_id');
				$this->mydb->request_friend($this->session->_userskrng, $friend_id);

				redirect("cont/user/". $friend_id);
			}
			else if($this->input->post('pg_removefriend')){
				$friend_id = $this->input->post('friend_id');
				$this->mydb->remove_friend($this->session->_userskrng, $friend_id);

				redirect("cont/user/". $friend_id);
			}
			else if($this->input->post('pg_acceptfriend')){
				$friend_id = $this->input->post('friend_id');
				$this->mydb->accept_friend($this->session->_userskrng, $friend_id);

				redirect("cont/user/". $friend_id);
			}
			else if($this->input->post('pg_like')){
				$friend_id = $this->input->post('friend_id');
				$posts_id = $this->input->post('posts_id');
				if($this->input->post('pg_like') == "Like"){
					$this->mydb->insert_likes($posts_id, $this->session->_userskrng);
				}
				else{
					$this->mydb->delete_likes($posts_id, $this->session->_userskrng);
				}

				redirect("cont/user/". $friend_id);
			}
			else if($this->input->post('pg_addcomment')){
				$friend_id = $this->input->post('friend_id');
				$posts_id = $this->input->post('posts_id');
				$comment = $this->input->post('comment');
				$this->mydb->insert_comments($posts_id, $this->session->_userskrng, $comment);

				redirect("cont/user/". $friend_id);
			}
			else if($this->input->post('pg_delcomment')){
				$friend_id = $this->input->post('friend_id');
				$comments_id = $this->input->post('comments_id');
				$this->mydb->delete_comments($comments_id);

				redirect("cont/user/". $friend_id);

			}
			else if($this->input->post('pg_allskill')){
				$friend_id = $this->input->post("friend_id");

				redirect("cont/skilluser/" . $friend_id);
			}
			else if($this->input->post('pg_endorse')){
				$friend_id = $this->input->post('friend_id');
				$skill_id = $this->input->post('skill_id');

				if($this->input->post('pg_endorse') == "Endorse"){
					$this->mydb->add_endorse($skill_id, $this->session->_userskrng);
				}
				else{
					$this->mydb->delete_endorse($skill_id, $this->session->_userskrng);
				}

				redirect("cont/skilluser/" . $friend_id);
			}
			else if($this->input->post('pg_sendmessage')){
				$friend_id = $this->input->post("friend_id");
				$user_id_array = array($this->session->_userskrng, $friend_id);

				$chat_rooms_id = $this->mydb->check_room($user_id_array)[0]["chat_rooms_id"];
				if (is_null($chat_rooms_id)) {
					$chat_rooms_id = $this->mydb->add_newroom($user_id_array);
				}
				redirect("cont/chat_room/". $chat_rooms_id);
			}
			//-----------------------------------------------------
			//NOTIFICATION
			//-----------------------------------------------------
			else if($this->input->post('n_removefriend')){
				$friend_id = $this->input->post('friend_id');
				$this->mydb->remove_friend($this->session->_userskrng, $friend_id);

				redirect("cont/notification");
			}
			else if($this->input->post('n_acceptfriend')){
				$friend_id = $this->input->post('friend_id');
				$this->mydb->accept_friend($this->session->_userskrng, $friend_id);

				redirect("cont/notification");
			}
			//-----------------------------------------------------
			//CHAT
			//-----------------------------------------------------
			else if($this->input->post('c_room')){
				$chat_rooms_id = $this->input->post("chat_rooms_id");
				if (!$this->mydb->check_room_private($chat_rooms_id)) {
					redirect("cont/chat_room/". $chat_rooms_id);
				}
				else {
					redirect("cont/chat_room_private/". $chat_rooms_id);
				}
			}
			else if($this->input->post('c_newroom')){
				$friends = $this->input->post("friends");
				if (!is_null($friends)) {
					array_push($friends, $this->session->_userskrng);

					$chat_rooms_id = $this->mydb->add_newroom($friends);
					redirect("cont/chat_room/". $chat_rooms_id);
				}
				else {
					$this->session->set_flashdata("errors", "Pilih teman dulu !");
					redirect("cont/chat");
				}
			}
			else if($this->input->post('c_sendchat')){
				$chat_rooms_id = $this->input->post("chat_rooms_id");
				$msg = $this->input->post('msg');
				if ($this->upload->do_upload('upload-foto')){
					$filename = $this->upload->data()["file_name"];
					$this->mydb->insert_chat($msg, $chat_rooms_id, $this->session->_userskrng, $filename);
				}
				else {
					$this->mydb->insert_chat($msg, $chat_rooms_id, $this->session->_userskrng);
				}

				if ($this->input->post('private')) {
					redirect("cont/chat_room_private/". $chat_rooms_id);
				}
				else {
					redirect("cont/chat_room/". $chat_rooms_id);
				}
			}
			else if($this->input->post('c_delchat')){
				$chat_rooms_id = $this->input->post("chat_rooms_id");
				$message_id = $this->input->post("message_id");
				$this->mydb->insert_message_deleted($message_id, $this->session->_userskrng);

				if ($this->input->post('private')) {
					redirect("cont/chat_room_private/". $chat_rooms_id);
				}
				else {
					redirect("cont/chat_room/". $chat_rooms_id);
				}
			}
			else if($this->input->post('c_adduserview')){
				$chat_rooms_id = $this->input->post("chat_rooms_id");

				$data['friends'] = $this->mydb->get_friendlistname_notinroom($chat_rooms_id, $this->session->_userskrng);
				$data['chat_rooms_id'] = $chat_rooms_id;
				if ($this->input->post('private')) {
					$data['private'] = "1";
				}
				$this->load->view('chat_adduser', $data);
			}
			else if($this->input->post('c_adduser')){
				$adduser = $this->input->post("friends");
				$chat_rooms_id = $this->input->post("chat_rooms_id");

				foreach ($adduser as $key => $value) {
					$this->mydb->add_user_tochatroom($chat_rooms_id, $value);
				}

				if ($this->input->post('private')) {
					redirect("cont/chat_room_private/". $chat_rooms_id);
				}
				else {
					redirect("cont/chat_room/". $chat_rooms_id);
				}
			}
			else if($this->input->post('c_endchat')){
				$chat_rooms_id = $this->input->post("chat_rooms_id");
				if (!$this->mydb->update_room_deleted($chat_rooms_id, $this->session->_userskrng)) {
					echo "UPDATE ERROR";
				}

				redirect("cont/chat");
			}
			else if($this->input->post('c_newprivateroom')){
				$friends = $this->input->post("friends");
				if (!is_null($friends)) {
					array_push($friends, $this->session->_userskrng);

					$chat_rooms_id = $this->mydb->add_newprivateroom($friends);
					redirect("cont/chat_room/". $chat_rooms_id);
				}
				else {
					$this->session->set_flashdata("errors", "Pilih teman dulu !");
					redirect("cont/chat");
				}
			}
			//-----------------------------------------------------
			//SKILL
			//-----------------------------------------------------
			else if($this->input->post('as_delete')){
				$id = $this->input->post('skill_id');
				$this->mydb->delete_skill($id);

				redirect("cont/skill");
			}
			else if($this->input->post('as_add')){
				$skill = $this->mydb->get_skill($this->session->_userskrng);
				if (count($skill) <5) {
					$namaskill = $this->input->post("namaskill");
					$this->mydb->add_skill($this->session->_userskrng, $namaskill);
				}
				else {
					$this->session->set_flashdata("error_maxskill", "Maksimal skill adalah 5. Tidak bisa tambah skill lagi.");
				}

				redirect("cont/skill");
			}
			else{
				redirect($this->default_page);
			}
		}
	}

	public function explore($keyword = null){
		if ($this->check_logged_in()) {
			$this->load->view("explore", array("keyword" => $keyword));
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function explore_data(){
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

			$this->load->view("exploredata", $data);
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function user($friend_id){
		if ($this->check_logged_in()) {
			if ($friend_id == $this->session->_userskrng) {
				redirect("profile");
			}
			else {
				$this->mydb->insert_notification_seeprofile($this->session->_userskrng, $friend_id);

				$config['base_url'] = site_url("cont/user/".$friend_id);
				$config['total_rows'] = $this->mydb->count_userposts($friend_id);
				$config['per_page'] = 7;
				$config['uri_segment'] = 4;
				$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
				$this->pagination->initialize($config);
				$data['links'] = $this->pagination->create_links();

				$data += $this->mydb->get_userdata($friend_id);
				$data += $this->mydb->get_userposts($friend_id, $this->session->_userskrng, $config["per_page"],$page);

				$data['friend_id'] = $friend_id;
				$data['friends_requested'] = $this->mydb->get_friends_requested($this->session->_userskrng);
				$data['friends_request'] = $this->mydb->get_friends_request($this->session->_userskrng);
				$data['friends'] = $this->mydb->get_friends($this->session->_userskrng);
				$data['user'] = $this->mydb->get_userdata($this->session->_userskrng);
				$data["skill"] = $this->mydb->get_skill($friend_id, 3);

				$this->load->view("profileguest", $data);
			}
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function skill(){
		if ($this->check_logged_in()) {
			$data["skill"] = $this->mydb->get_skill($this->session->_userskrng);
			$this->load->view('skill', $data);
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function skilluser($friend_id){
		if ($this->check_logged_in()) {
			$data = $this->mydb->get_userdata($friend_id);
			$data["skill"] = $this->mydb->get_skill($friend_id);
			$data['friend_id'] = $friend_id;
			$this->load->view('skillguest', $data);
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function notification(){
		if ($this->check_logged_in()) {
			$config['base_url'] = site_url("cont/notification");
			$config['total_rows'] = $this->mydb->count_notification($this->session->_userskrng);
			$config['per_page'] = 10;
			$config['uri_segment'] = 3;
			$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();

			$data['friends_request'] = $this->mydb->get_friends_request($this->session->_userskrng);
			$data['notification'] = $this->mydb->get_notification($this->session->_userskrng, $config["per_page"], $page);
			$data['chat'] = $this->mydb->get_chat_notification($this->session->_userskrng);

			$this->load->view('notification', $data);
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function chat(){
		if ($this->check_logged_in()) {
			$config['base_url'] = site_url("cont/chat");
			$config['total_rows'] = $this->mydb->count_all_chat_rooms($this->session->_userskrng);
			$config['per_page'] = 6;
			$config['uri_segment'] = 3;
			$page = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) : 0;
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();

			$data['friends'] = $this->mydb->get_friendslistname($this->session->_userskrng);
			$data["chat"] = $this->mydb->get_all_chat_rooms($this->session->_userskrng, $config["per_page"], $page);

			$this->load->view('chat', $data);
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function chat_room($chat_rooms_id){
		if ($this->check_logged_in()) {
			if ($this->mydb->check_room_accessible($this->session->_userskrng, $chat_rooms_id)) {
				$this->mydb->update_room_read($chat_rooms_id, $this->session->_userskrng);
				$data["chat"] = $this->mydb->get_chat($chat_rooms_id, $this->session->_userskrng);
				$data["chat_rooms_id"] = $chat_rooms_id;
				$data["chat_rooms_participant"] = $this->mydb->get_participant($chat_rooms_id ,$this->session->_userskrng);
				$this->load->view('chat_room', $data);
			}
			else {
				redirect("cont/chat");
			}
		}
		else redirect($this->default_page_not_logged_in);
	}
	public function chat_room_private($chat_rooms_id){
		if ($this->check_logged_in()) {
			if ($this->mydb->check_room_private_accessible($this->session->_userskrng, $chat_rooms_id)) {
				$this->mydb->update_room_read($chat_rooms_id, $this->session->_userskrng);
				$this->datapost["chat"] = $this->mydb->get_chat_private($chat_rooms_id, $this->session->_userskrng);
				$this->datapost["chat_rooms_id"] = $chat_rooms_id;
				$this->load->view('chat_room_private', $this->datapost);
			}
			else {
				redirect("cont/chat");
			}
		}
		else{
			redirect($this->default_page_not_logged_in);
		}
	}

}
