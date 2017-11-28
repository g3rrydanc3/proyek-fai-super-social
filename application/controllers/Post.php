<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post extends MY_Controller {
	private $referrer;
	public function __construct(){
		parent::__construct();

		if ($this->agent->referrer() != null) {
			$this->referrer = $this->agent->referrer();
		}
		else {
			$this->referrer = site_url();
		}

		if (!$this->check_logged_in()) {
			redirect(site_url());
		}
	}
	
	public function report() {
		$id_post = $this->input->post('id_post');
		if ($this->input->post('report') != "") {
			$reason = $this->input->post('report');
			$user_id_reporter = $this->session->userdata('_userskrng');
			$query = $this->mydb->get_post_by_id($id_post);
			$user_id_reported = $query->user_id;
			$this->mydb->insert_report($user_id_reporter, $user_id_reported, $reason);
			$this->session->set_flashdata('pesan', 'Terimakasih, report Anda akan kami proses.');
			redirect($this->default_page);
		}else {
			$this->reportpost($id_post);
		}
	}
	
	public function reportpost($idpost) {
		$data['id_post'] = $idpost;
		$this->load->view('report_post', $data);
	}
	
	public function index(){
		redirect($this->referrer);
	}
	
	public function posts(){
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png|mp4';
		$config['overwrite']           = true;
		$config['encrypt_name']           = true;
		$this->upload->initialize($config);

		if ($this->input->post("btn_posts")) {
			$posts = $this->input->post('posts');
			if ($_FILES["post-foto"]["name"] != "") {
				if(!$this->upload->do_upload('post-foto')){
					$this->session->set_flashdata("post-image-error", $this->upload->display_errors());
					echo $this->upload->display_errors();
				}
				else{
					$filename = $this->upload->data()["file_name"];
					$this->mydb->insert_posts($this->session->_userskrng, $posts, $filename);
				}
			}
			else {
				$this->mydb->insert_posts($this->session->_userskrng, $posts);
			}
		}
		else if ($this->input->post("btn_posts_timed")) {
			$posts = $this->input->post('posts');
			if ($_FILES["post-foto"]["name"] != "") {
				if(!$this->upload->do_upload('post-foto')){
					$this->session->set_flashdata("post-image-error", $this->upload->display_errors());
					echo $this->upload->display_errors();
				}
				else{
					$filename = $this->upload->data()["file_name"];
					$this->mydb->insert_posts_timed($this->session->_userskrng, $posts, $filename);
				}
			}
			else {
				$this->mydb->insert_posts_timed($this->session->_userskrng, $posts);
			}
		}
		redirect($this->referrer);
	}
	public function delpost($posts_id = null){
		if ($posts_id == null) {
			$posts_id = $this->input->post('posts_id');
		}
		$this->mydb->delete_posts($posts_id);
		redirect($this->referrer);
	}
	public function like(){
		$friend_id = $this->input->post('friend_id');
		$posts_id = $this->input->post('posts_id');
		if($this->input->post('like') == "Like"){
			$this->mydb->insert_likes($posts_id, $this->session->_userskrng);
		}
		else{
			$this->mydb->delete_likes($posts_id, $this->session->_userskrng);
		}
		redirect($this->referrer);
	}
	public function addcomment(){
		$friend_id = $this->input->post('friend_id');
		$posts_id = $this->input->post('posts_id');
		$comment = $this->input->post('comment');
		if ($this->upload->do_upload('upload-foto')){
			$filename = $this->upload->data()["file_name"];

			$this->mydb->insert_comments($posts_id, $this->session->_userskrng, $comment, $filename);
		}
		else {
			$this->mydb->insert_comments($posts_id, $this->session->_userskrng, $comment);
		}
		redirect($this->referrer);
	}
	public function delcomment($comments_id = null){
		if ($comments_id == null) {
			$comments_id = $this->input->post('comments_id');
		}
		$this->mydb->delete_comments($comments_id);
		redirect($this->referrer);
	}
	public function sharepost(){
		$posts_id = $this->input->post('posts_id');
		$friend_id = $this->input->post('friend_id');
		$posts = $this->mydb->get_post_from_id($posts_id) . "<br><br>" .
		"Shared from @" .$this->mydb->get_userdata($friend_id)["namadepan"];
		$this->mydb->insert_posts($this->session->_userskrng, $posts);
		redirect($this->referrer);
	}
	public function addcommentreply(){
		$comment_id = $this->input->post('comment_id');
		$commentreply = $this->input->post('commentreply');
		$this->mydb->insert_commentsreply($comment_id, $this->session->_userskrng, $commentreply);
		redirect($this->referrer);
	}
}
?>
