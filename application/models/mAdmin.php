<?php
	class mAdmin extends CI_Model {
		public function __construct(){
			parent::__construct();
		}

		public function get_all_user(){
			$query = $this->db->select()
			->from("user u")
			->order_by("id")
			->get();
			return $query->result_array();
		}
		public function get_user_data($user_id){
			$query = $this->db->select()
			->from("user u")
			->where("id", $user_id)
			->get();
			return $query->result_array()[0];
		}
		public function update_user($postarray){
			$id = $postarray['id'];
			unset($postarray['id']);
			$this->db->where('id', $id)->update('user', $postarray);
		}

		public function get_all_group(){
			$query = $this->db->select("*, u.id as user_id, g.id as group_id")
			->from("group g")
			->join('user u', 'g.user_id = u.id')
			->order_by("g.id")
			->get();
			return $query->result_array();
		}
		public function get_group_data($group_id){
			$query = $this->db->select("*, u.id as user_id, g.id as group_id")
			->from("group g")
			->join('user u', 'g.user_id = u.id')
			->where("g.id", $group_id)
			->order_by("g.id")
			->get();
			return $query->result_array()[0];
		}
		public function update_group($postarray){
			$group_id = $postarray['group_id'];
			unset($postarray['group_id']);
			$this->db->where('id', $group_id)->update('group', $postarray);
		}

		public function get_all_report_not_done(){
			$query = $this->db->select("r.id, r.datetime, r.done, r.reason")
			->select("u1.id as u1_id, u1.namadepan as u1_namadepan, u1.namabelakang as u1_namabelakang, u1.img as u1_img, u1.verified as u1_verified")
			->select("u2.id as u2_id, u2.namadepan as u2_namadepan, u2.namabelakang as u2_namabelakang, u2.img as u2_img, u2.verified as u2_verified")
			->select("p.id as posts_id, p.isi as p_isi, p.datetime as p_datetime, p.timed as p_timed, p.img as p_img")
			->from("report r")
			->join('user u1', 'r.user_id_reporter = u1.id')
			->join('user u2', 'r.user_id_reported = u2.id')
			->join('posts p', 'r.posts_id = p.id', 'left')
			->where("r.done", "0")
			->order_by("r.id")
			->get();
			return $query->result_array();
		}
		public function get_all_report_done(){
			$query = $this->db->select("r.id, r.datetime, r.done, r.reason")
			->select("u1.id as u1_id, u1.namadepan as u1_namadepan, u1.namabelakang as u1_namabelakang, u1.img as u1_img, u1.verified as u1_verified")
			->select("u2.id as u2_id, u2.namadepan as u2_namadepan, u2.namabelakang as u2_namabelakang, u2.img as u2_img, u2.verified as u2_verified")
			->select("p.id as posts_id, p.isi as p_isi, p.datetime as p_datetime, p.timed as p_timed, p.img as p_img")
			->from("report r")
			->join('user u1', 'r.user_id_reporter = u1.id')
			->join('user u2', 'r.user_id_reported = u2.id')
			->join('posts p', 'r.posts_id = p.id', 'left')
			->where("r.done", "1")
			->order_by("r.id")
			->get();
			return $query->result_array();
		}
		public function report_done($report_id){
			$data = array(
				"done" => 1
			);
			$this->db->where("id", $report_id)->update("report", $data);

			$query = $this->db->select("*")->where("id", $report_id)->get("report");
			$result = $query->row();

			$user_data_reported = $this->mydb->get_userdata($result->user_id_reported);
			$msg = "We reviewed your report of <a href='".site_url("cont/user/").$user_data_reported['id']."'>".$user_data_reported['namadepan']." ".$user_data_reported['namabelakang']."</a>'s profile.";

			$this->mydb->insert_notification($result->user_id_reporter, $msg);
		}

		public function get_report_posts(){
			$query = $this->db->select("count(*) as count, DATE_FORMAT(datetime, '%d-%m-%Y') as datetime ")
			->from("posts p")
			->group_by("datetime")
			->get();

			return $query->result();
		}
		public function get_report_private(){
			$query = $this->db->select("count(*) as count, private")
			->from("user u")
			->group_by("private")
			->get();

			return $query->result();
		}
		public function get_report_reportuser_monthly(){
			$query = $this->db->select("count(*) as count, DATE_FORMAT(datetime, '%d-%m-%Y') as datetime")
			->from("report u")
			->group_by("month(datetime)")
			->get();

			return $query->result();
		}

	}
?>
