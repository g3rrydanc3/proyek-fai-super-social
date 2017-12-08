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

		public function get_report_posts($year, $month){
			$subquery = "
				SELECT 1 AS Date UNION ALL
				SELECT 2 UNION ALL
				SELECT 3 UNION ALL
				SELECT 4 UNION ALL
				SELECT 5 UNION ALL
				SELECT 6 UNION ALL
				SELECT 7 UNION ALL
				SELECT 8 UNION ALL
				SELECT 9 UNION ALL
				SELECT 10 UNION ALL
				SELECT 11 UNION ALL
				SELECT 12 UNION ALL
				SELECT 13 UNION ALL
				SELECT 14 UNION ALL
				SELECT 15 UNION ALL
				SELECT 16 UNION ALL
				SELECT 17 UNION ALL
				SELECT 18 UNION ALL
				SELECT 19 UNION ALL
				SELECT 20 UNION ALL
				SELECT 21 UNION ALL
				SELECT 22 UNION ALL
				SELECT 23 UNION ALL
				SELECT 24 UNION ALL
				SELECT 25 UNION ALL
				SELECT 26 UNION ALL
				SELECT 27 UNION ALL
				SELECT 28 UNION ALL
				SELECT 29 UNION ALL
				SELECT 30 UNION ALL
				SELECT 31
			";
			$query = $this->db->select("count(`id`) AS 'Jumlah Post', md.date as datetime")
				->from("($subquery) as md")
				->join("posts p", "md.date = day(p.datetime)
					and month(p.datetime) = $month
					and year(p.datetime) = $year"
					, "left")
				->where("md.date <= day(LAST_DAY('$year-$month-01'))")
				->group_by("md.date")
				->get();

			return $query->result();
		}
		public function get_report_private(){
			$subqueryprivate = $this->db->select("count(*)")
				->from("user u")
				->where("private = 1")
				->group_by("private")
				->get_compiled_select();

			$subquerynotprivate = $this->db->select("count(*)")
				->from("user u")
				->where("private = 0")
				->group_by("private")
				->get_compiled_select();

			$query = $this->db->select("($subqueryprivate) as 'Private User', ($subquerynotprivate) as 'Not Private User'")
				->get();

			return $query->result();
		}
		public function get_report_reportuser_yearly($year){
			$subquery = "
				SELECT 1 AS month UNION ALL
				SELECT 2 UNION ALL
				SELECT 3 UNION ALL
				SELECT 4 UNION ALL
				SELECT 5 UNION ALL
				SELECT 6 UNION ALL
				SELECT 7 UNION ALL
				SELECT 8 UNION ALL
				SELECT 9 UNION ALL
				SELECT 10 UNION ALL
				SELECT 11 UNION ALL
				SELECT 12
			";
			$query = $this->db->select("count(`id`) AS 'Jumlah Report', md.month as datetime")
				->from("($subquery) as md")
				->join("report r", "md.month = month(r.datetime)
					and year(r.datetime) = $year"
					, "left")
				->group_by("md.month")
				->get();

			return $query->result();
		}

	}
?>
