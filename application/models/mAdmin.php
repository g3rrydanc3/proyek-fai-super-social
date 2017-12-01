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

	}
?>
