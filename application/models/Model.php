<?php
	class Model extends CI_Model {
		public function __construct(){
			parent::__construct();
			$this->load->database();
		}
		//-----------------------------------------------------
		//USERDATA
		//-----------------------------------------------------
		public function get_id($emailhp){
			//$this->db->select('id')->from('user')->where('email', $emailhp)->or_where('nohp', $emailhp)->limit(1);
			$this->db->select('id')->from('user')->where('email', $emailhp)->limit(1);
			$subquery = $this->db->get_compiled_select();
			$query = $this->db->select("ifnull(($subquery), '-1') as id")->get();
			return $query->row_array()['id'];
		}
		public function get_id_from_email(){
			$this->db->select('id')->from('user')->where('email', $emailhp)->limit(1);
			$subquery = $this->db->get_compiled_select();
			$query = $this->db->select("ifnull(($subquery), '-1') as id")->get();
			return $query->row_array()['id'];
		}
		public function get_account_activated($email){
			$data = array(
				'active' => 1,
				'email' => $email
			);
			$ada = $this->db->where($data)->count_all_results("user");
			return boolval($ada);
		}
		public function request_forgot_password($email){
			$token = getToken(20);
			$data = array("code_password" => $token);
			$this->db->where("email", $email)->update("user", $data);
			if ($this->db->affected_rows() >= 1) {
				$user_id = $this->get_id($email);
				if ($user_id != -1) {
					$userdata = $this->get_userdata($user_id);
					$nama = $userdata["namadepan"] ." ". $userdata["namabelakang"];
					$this->mEmail->e_forgot_password($user_id, $nama, $email, $token);
				}
			}
		}
		public function forgot_password_check($user_id = null, $token = null){
			if ($token == null) {
				return false;
			}
			else {
				$data = array(
					"id" => $user_id,
					"code_password" => $token
				);
				$ada = $this->db->where($data)->count_all_results("user");
				return boolval($ada);
			}
		}
		public function get_password($id){
			$query = $this->db->select('password')->from('user')->where('id', $id)->get();
			return $query->row_array()['password'];
		}
		public function change_password($user_id, $password){
			$data = array("password" => $password);
			$this->db->where("id", $user_id)->update("user", $data);
		}
		public function delete_token_confirmation($user_id){
			$data = array("code_activation" => "");
			$this->db->where("id", $user_id)->update("user", $data);
		}
		public function delete_token_password($user_id){
			$data = array("code_password" => "");
			$this->db->where("id", $user_id)->update("user", $data);
		}
		public function get_userdata($id){
			$query = $this->db->select('*')->from('user')->where('id', $id)->get();
			$userdata = $query->row_array();

			$subquery = $this->db->select('id')->from('posts')->where('user_id',$id)->get_compiled_select();

			$query = $this->db->select("count(*)")->from("likes l")->where("posts_id in ($subquery)")->get();
			$userdata['totallikes'] = $query->row_array()['count(*)'];

			$query = $this->db->select("count(*)")->from("comments c")->where("posts_id in ($subquery)")->get();
			$userdata['totalcomments'] = $query->row_array()['count(*)'];

			return $userdata;
		}
		public function register($namadepan, $namabelakang, $email, $nohp, $password){
			$data = array(
				'namadepan' => $namadepan,
				'namabelakang' => $namabelakang,
				'email' => $email,
				'nohp' => $nohp,
				'password' => $password,
				'active' => 0,
				'code_activation' => getToken(20)
			);
			$this->db->insert('user', $data);
			$user_id = $this->db->insert_id();
			if ($this->mEmail->e_register_confirm($user_id, $namadepan." "."$namabelakang", $email, $data["code_activation"])) {
				return true;
			}
		}
		public function register_check($user_id = null, $token = null){
			if ($token == null) {
				return false;
			}
			else {
				$data = array(
					"id" => $user_id,
					"code_activation" => $token,
					"active" => 0
				);
				$ada = $this->db->where($data)->count_all_results("user");
				return boolval($ada);
			}
		}
		public function register_confirm($user_id, $token){
			if ($this->register_check($user_id, $token)) {
				$data = array("active" => 1);
				$this->db->where("id", $user_id)->update("user", $data);
				return true;
			}
			else {
				return false;
			}
		}
		public function get_id_from_namadepan($namadepan){
			$this->db->select('id')->from('user')->where('namadepan', $namadepan)->limit(1);
			$subquery = $this->db->get_compiled_select();
			$query = $this->db->select("ifnull(($subquery), '-1') as id")->get();
			return $query->row_array()['id'];
		}
		//-----------------------------------------------------
		//PROFILE
		//-----------------------------------------------------
		public function set_editaccount($id, $namadepan, $namabelakang, $email, $nohp, $password){
			$data = array(
				'namadepan' => $namadepan,
				'namabelakang' => $namabelakang,
				'email' => $email,
				'nohp' => $nohp,
				'password' => $password
			);
			$this->db->where('id', $id);
			$this->db->update('user', $data);
			return $this->db->affected_rows();
		}
		public function set_editprofile($id, $alamat, $kodepos, $negara, $jabatan, $perusahaan, $bioperusahaan, $biouser, $private = "0"){
			$data = array(
				'alamat' => $alamat,
				'kodepos' => $kodepos,
				'negara' => $negara,
				'jabatan' => $jabatan,
				'perusahaan' => $perusahaan,
				'bioperusahaan' => $bioperusahaan,
				'biouser' => $biouser,
				'private' => $private
			);
			$this->db->where('id', $id);
			$this->db->update('user', $data);
			return $this->db->affected_rows();
		}
		public function set_editprofilepicture($id, $filename){
			$data = array(
				'img' => $filename
			);
			$this->db->where('id', $id);
			$this->db->update('user', $data);
			return $this->db->affected_rows();
		}
		public function set_editprofilemusic($id, $filename, $filenameori){
			$data = array(
				'music' => $filename,
				'music_ori' => $filenameori
			);
			$this->db->where('id', $id);
			$this->db->update('user', $data);
			return $this->db->affected_rows();
		}
		public function count_userposts($id){
			$now = date("Y-m-d H:i:s", time() - 120);
			return $this->db
					->from("posts p")
					->where("p.user_id = ", $id)
					->group_start()
						->group_start()
							->where("p.timed = 0")
						->group_end()
						->or_group_start()
							->where("p.timed = 1")
							->where("p.datetime >", $now)
						->group_end()
					->group_end()
					->order_by("datetime desc")
					->count_all_results();
		}
		public function get_userposts($id, $_userskrng, $limit = 0, $start = 0){
			$now = date("Y-m-d H:i:s", time() - 120);
			$subquery = $this->db->select("count(l.posts_id)")->from("likes l")->where("l.posts_id = p.id")->get_compiled_select();
			$namadepan = $this->db->select("namadepan")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$namabelakang = $this->db->select("namabelakang")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$img = $this->db->select("img")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$verified = $this->db->select("verified")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$query = $this->db->select("p.id, p.isi, p.datetime, p.timed, p.img, p.user_id,($subquery) as likes, ($namadepan) as namadepan, ($namabelakang) as namabelakang, ($img) as user_img, ($verified) as verified")
					->from("posts p")
					->where("p.user_id = ", $id)
					->group_start()
						->group_start()
							->where("p.timed = 0")
						->group_end()
						->or_group_start()
							->where("p.timed = 1")
							->where("p.datetime >", $now)
						->group_end()
					->group_end()
					->order_by("datetime desc")
					->limit($limit,$start)->get();

			$posts = $query->result_array();

			$comments = array();
			$likes = array();
			$totalcommentsperpost = array();
			for ($i=0; $i < count($posts); $i++) {
				$query = $this->db->select("count(*) as count")->from("comments")->where("posts_id", $posts[$i]['id'])->get();
				array_push($totalcommentsperpost, $query->row_array()['count']);

				$query = $this->db->select("c.id, c.isi, c.datetime, u.id as user_id, u.namadepan, u.namabelakang, u.verified, u.img as user_img")
				->from("comments c, user u")
				->where("c.user_id = u.id")->where("posts_id", $posts[$i]['id'])->order_by("c.datetime")->get();
				$comment = $query->result_array();
				for ($j=0; $j < count($comment); $j++) {
					$query1 = $this->db->from("comments_reply cr, user u")->where("cr.comments_id", $comment[$j]["id"])->where("u.id = cr.user_id")->get();
					$comment[$j]['reply'] = $query1->result_array();
				}
				array_push($comments, $comment);


				$query = $this->db->select("u.id, u.namadepan, u.namabelakang, u.verified, u.img, l.type")
				->from("user u, likes l")
				->where("u.id = l.user_id")->where("l.posts_id", $posts[$i]['id'])->get();
				array_push($likes, $query->result_array());

				//CEK MENTION
				$posts[$i]["isi"] = $this->return_post_with_mention($posts[$i]["isi"], $_userskrng);
				$posts[$i]["isi"] = $this->return_post_with_hashtag($posts[$i]["isi"]);
			}

			$ret['posts'] = $posts;
			$ret['comments'] = $comments;
			$ret['likes'] = $likes;
			$ret['totalcommentsperpost'] = $totalcommentsperpost;
			return $ret;
		}
		public function get_post_by_id($id) {
			$query = $this->db->query("select * from posts where id = '$id'");
			return $query->row();
		}
		public function insert_posts($id, $isi, $img = null){
			$this->notification_post_mention($isi, $id);
			$data = array(
				"user_id" => $id,
				"isi" => $isi,
				"datetime" => date("Y-m-d H:i:s"),
				"timed" => 0,
				"img" => $img
			);
			$query = $this->db->insert("posts", $data);
			return $this->db->affected_rows();
		}
		public function insert_posts_timed($id, $isi, $img){
			$this->notification_post_mention($isi, $id);
			$data = array(
				"user_id" => $id,
				"isi" => $isi,
				"datetime" => date("Y-m-d H:i:s"),
				"timed" => 1,
				"img" => $img
			);
			$query = $this->db->insert("posts", $data);
			return $this->db->affected_rows();
		}
		public function delete_posts($posts_id){
			$query = $this->db->where('posts_id = ',$posts_id)->delete('comments');
			$query = $this->db->where('posts_id = ',$posts_id)->delete('likes');
			$query = $this->db->where('id = ',$posts_id)->delete('posts');
			return $this->db->affected_rows();
		}
		public function insert_likes($posts_id, $user_id, $type){
			$data = array(
				"posts_id" => $posts_id,
				"user_id" => $user_id,
				"type" => $type
			);
			$query = $this->db->insert("likes", $data);
			$query = $this->db->select("user_id")->from("posts")->where("id", $posts_id)->get();
			$postowner = $query->row_array()['user_id'];
			if ($postowner != $user_id) {
				$this->insert_notification_like($user_id, $postowner);
			}

			return $this->db->affected_rows();
		}
		public function delete_likes($posts_id, $user_id){
			$query = $this->db->where("posts_id",$posts_id)->where("user_id", $user_id)->delete("likes");
			return $this->db->affected_rows();
		}
		public function insert_comments($posts_id, $user_id, $isi, $img = null){
			$data = array(
				"posts_id" => $posts_id,
				"user_id" => $user_id,
				"isi" => $isi,
				"datetime" => date("Y-m-d H:i:s"),
			);
			$query = $this->db->insert("comments", $data);
			$query = $this->db->select("user_id")->from("posts")->where("id", $posts_id)->get();
			$postowner = $query->row_array()['user_id'];
			if ($postowner != $user_id) {
				$this->insert_notification_comment($user_id, $postowner);
			}
			return $this->db->affected_rows();
		}
		public function delete_comments($comments_id){
			$query = $this->db->where("id", $comments_id)->delete("comments");
			return $this->db->affected_rows();
		}
		public function insert_commentsreply($comments_id, $user_id, $isi){
			$data = array(
				"comments_id" => $comments_id,
				"user_id" => $user_id,
				"isi" => $isi,
				"datetime" => date("Y-m-d H:i:s"),
			);
			$query = $this->db->insert("comments_reply", $data);
			$query = $this->db->select("user_id")->from("comments")->where("id", $comments_id)->get();
			$postowner = $query->row_array()['user_id'];
			if ($postowner != $user_id) {
				$this->insert_notification_commentreply($user_id, $postowner);
			}
			return $this->db->affected_rows();
		}
		public function delete_commentsreply($comments_id){
			$query = $this->db->where("id", $comments_id)->delete("comments");
			return $this->db->affected_rows();
		}
		//-----------------------------------------------------
		//FRIENDS
		//-----------------------------------------------------
		public function count_explore($id, $keyword = null){
			$subqueryblocked = $this->db->select("f.user_id1")->from("friends f")->where("f.user_id2", $id)->get()->result_array();
			$blocked = array();
			foreach ($subqueryblocked as $key => $value) {
				array_push($blocked, $value["user_id1"]);
			}

			$this->db->from("user u")
				->where("u.id not like ",$id);
			if ($blocked != null) {
				$this->db->where_not_in("u.id", $blocked);
			}
			if ($keyword != null) {
				$this->db->like("u.namadepan",$keyword)
				->or_like("u.namabelakang",$keyword);
			}
			return $this->db->count_all_results();
		}
		public function get_explore($id, $limit = 0, $page = 0, $keyword = null, $sortby = null, $sort = null){
			$now = date("Y-m-d H:i:s", time() - 120);
			$subquery1 = $this->db->select("p.id")->from("posts p")->where("p.user_id = u.id")->order_by("datetime desc")
			->group_start()->group_start()->where("p.timed = 0")->group_end()->or_group_start()->where("p.timed = 1")->where("p.datetime >", $now)->group_end()->group_end()
			->limit(1)->get_compiled_select();
			$subquery2 = $this->db->select("p.isi")->from("posts p")->where("p.user_id = u.id")->order_by("datetime desc")
			->group_start()->group_start()->where("p.timed = 0")->group_end()->or_group_start()->where("p.timed = 1")->where("p.datetime >", $now)->group_end()->group_end()
			->limit(1)->get_compiled_select();
			$subquery3 = $this->db->select("p.datetime")->from("posts p")->where("p.user_id = u.id")->order_by("datetime desc")
			->group_start()->group_start()->where("p.timed = 0")->group_end()->or_group_start()->where("p.timed = 1")->where("p.datetime >", $now)->group_end()->group_end()
			->limit(1)->get_compiled_select();
			$subquery4 = $this->db->select("count(*)")->from("likes l")->from("posts p")->where("l.posts_id = p.id")->where("p.user_id = u.id")->get_compiled_select();
			$subquerycomment = $this->db->select("count(*)")->from("comments c, posts p")->where("c.posts_id = p.id")
			->group_start()->group_start()->where("p.timed = 0")->group_end()->or_group_start()->where("p.timed = 1")->where("p.datetime >", $now)->group_end()->group_end()
			->where("p.user_id = u.id")->get_compiled_select();
			$subquerypost = $this->db->select("count(*)")->from("posts p")->where("p.user_id = u.id")
			->group_start()->group_start()->where("p.timed = 0")->group_end()->or_group_start()->where("p.timed = 1")->where("p.datetime >", $now)->group_end()->group_end()
			->group_by("p.user_id")->get_compiled_select();

			$subqueryblocked = $this->db->select("f.user_id1")->from("friends f")->where("f.user_id2", $id)->get()->result_array();
			$blocked = array();
			foreach ($subqueryblocked as $key => $value) {
				array_push($blocked, $value["user_id1"]);
			}

			$this->db->select("u.id, u.namadepan, u.namabelakang, u.img, ($subquery1) as p_id,($subquery2) as p_isi,($subquery3) as p_datetime,($subquery4) as likes, ($subquerycomment) as comments, ($subquerypost) as posts")
				->from("user u")
				->where("u.id not like ",$id);
				if ($blocked != null) {
					$this->db->where_not_in("u.id", $blocked);
				}
			$this->db->limit($limit, $page);

				if ($keyword != null) {
					$this->db->like("u.namadepan",$keyword)
					->or_like("u.namabelakang",$keyword);
				}

				if ($sortby == null && $sort == null) {
					$this->db->order_by("likes desc");
				}
				else {
					$this->db->order_by("$sortby $sort");
				}
			$query = $this->db->get();
			//$query = $this->db->get_compiled_select();
			//echo $query;
			return $query->result_array();
		}
		public function request_friend($id, $friend_id){
			$data = array(
				"user_id1" => $id,
				"user_id2" => $friend_id,
				"status" => "request",
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->insert("friends", $data);
			return $this->db->affected_rows();
		}
		public function get_friends_requested($id){
			$query = $this->db->select("f.user_id2")
			->from("user u")->from("friends f")
			->where("u.id", $id)->where("f.user_id1 = u.id")->where("status", "request")->get();
			return $query->result_array();
		}
		public function get_friends_request($id){
			$subquery1 = $this->db->select("namadepan")->from("user us")->where("f.user_id1 = us.id")->get_compiled_select();
			$subquery2 = $this->db->select("namabelakang")->from("user us")->where("f.user_id1 = us.id")->get_compiled_select();
			$query = $this->db->select("($subquery1)as namadepan, ($subquery2) as namabelakang, f.user_id1, f.datetime")
			->from("user u, friends f")
			->where("u.id", ($id))->where("f.user_id2 = u.id")->where("status", "request")
			->order_by("datetime")->get();
			return $query->result_array();
		}
		public function get_friends($id){
			$query = $this->db->select("f.user_id1 ,f.user_id2")
			->from("user u, friends f")
			->where("u.id", $id)->where("(f.user_id1 = u.id or f.user_id2 = u.id)")->where("status", "friend")->get();
			return $query->result_array();
		}
		public function get_friends_clean($id){
			$friendsraw = $this->get_friends($id);
			$friends = array();
			foreach ($friendsraw as $key => $friend) {
				$user_id = $friend["user_id1"];
				if ($friend["user_id1"] == $id) {
					$user_id = $friend["user_id2"];
				}
				array_push($friends, $user_id);
			}
			return $friends;
		}
		public function remove_friend($id, $friend_id){
			$query = $this->db->select("count(*)")->from("friends")->where("status", "request")
			->where('((user_id1 = '.$this->db->escape($id).' and user_id2 = '.$this->db->escape($friend_id).') or (user_id1 = '.$this->db->escape($friend_id).' and user_id2 = '.$this->db->escape($id).'))')
			->get();
			if ($query->row_array()['count(*)'] == 1) {
				$this->insert_notification_decline_friend_request($id, $friend_id);
			}
			$query = $this->db->where('user_id1', $id)->where('user_id2', $friend_id)->delete("friends");
			$query = $this->db->where('user_id1', $friend_id)->where('user_id2', $id)->delete("friends");
			return true;
		}
		public function accept_friend($id, $friend_id){
			$data = array(
				"status" => "friend",
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->where("user_id1", $friend_id)->where("user_id2", $id)->update("friends", $data);
			$this->insert_notification_accepted_friend_request($id, $friend_id);
			return $this->db->affected_rows();
		}

		public function check_block($id, $user_id2){
			$this->db->from("friends f")
			->where("f.user_id1", $id)
			->where("f.user_id2", $user_id2)
			->where("status", "blocked");
			return boolval($this->db->count_all_results());
		}
		public function check_blocked($id, $user_id2){
			$this->db->from("friends f")
			->where("f.user_id2", $id)
			->where("f.user_id1", $user_id2)
			->where("status", "blocked");
			return boolval($this->db->count_all_results());
		}
		public function block_friend($id, $friend_id){
			$data = array(
				"status" => "blocked",
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->where("user_id1", $id)->where("user_id2", $friend_id)->update("friends", $data);
			if ($this->db->affected_rows() == 0) {
				$data["user_id1"] = $id;
				$data["user_id2"] = $friend_id;
				$query = $this->db->insert("friends", $data);
			}
		}

		//-----------------------------------------------------
		//NEWSFEED
		//-----------------------------------------------------
		public function count_newsfeed($id){
			$now = date("Y-m-d H:i:s", time() - 120);
			$friendlistraw = $this->get_friends($id);
			$friendlist = array();
			array_push($friendlist, $id);
			foreach ($friendlistraw as $key => $value) {
				$friend = $value['user_id1'];
				if ($value['user_id1'] == $id) {
					$friend = $value['user_id2'];
				}
				array_push($friendlist, $friend);
			}

			$this->db
			->from("posts p")
			->group_start()
				->group_start()
					->where("p.timed = 0")
				->group_end()
				->or_group_start()
					->where("p.timed = 1")
					->where("p.datetime >", $now)
				->group_end()
			->group_end()
			->order_by("datetime desc");
			for ($i=0; $i < count($friendlist); $i++) {
					$this->db->or_where("p.user_id", $friendlist[$i]);
			}
			return $this->db->count_all_results();
		}
		public function get_newsfeed($id, $limit = 0, $start = 0){
			$now = date("Y-m-d H:i:s", time() - 120);
			$friendlistraw = $this->get_friends($id);
			$friendlist = array();
			array_push($friendlist, $id);
			foreach ($friendlistraw as $key => $value) {
				$friend = $value['user_id1'];
				if ($value['user_id1'] == $id) {
					$friend = $value['user_id2'];
				}
				array_push($friendlist, $friend);
			}

			$subquerystr = $this->db->select("count(l.posts_id)")->from("likes l")->where("l.posts_id = p.id")->get_compiled_select();
			$namadepan = $this->db->select("namadepan")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$namabelakang = $this->db->select("namabelakang")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$img = $this->db->select("img")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$verified = $this->db->select("verified")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$this->db->select("p.id, p.isi, p.datetime, p.img, p.timed,($subquerystr) as likes, ($namadepan) as namadepan, ($namabelakang) as namabelakang, p.user_id, ($img) as user_img, ($verified) as verified")
			->from("posts p")
			->group_start()
				->group_start()
					->where("p.timed = 0")
				->group_end()
				->or_group_start()
					->where("p.timed = 1")
					->where("p.datetime >", $now)
				->group_end()
			->group_end()
			->group_start();
			for ($i=0; $i < count($friendlist); $i++) {
					$this->db->or_where("p.user_id", $friendlist[$i]);
			}
			$this->db->group_end();
			$this->db->order_by("datetime desc")
			->limit($limit, $start);
			$query = $this->db->get();
			$posts = $query->result_array();

			for ($i=0; $i < count($posts); $i++) {
				$posts[$i]["isi"] = $this->return_post_with_mention($posts[$i]["isi"], $id);
				$posts[$i]["isi"] = $this->return_post_with_hashtag($posts[$i]["isi"]);
			}

			$comments = array();
			$likes = array();
			$totalcommentsperpost = array();
			foreach ($posts as $key => $value) {
				$query = $this->db->select("count(*) as count")->from("comments")->where("posts_id",$value['id'])->get();
				array_push($totalcommentsperpost, $query->row_array()['count']);

				$query = $this->db->select("c.id, c.isi, c.datetime, u.id as user_id, u.namadepan, u.namabelakang, u.verified, u.img as user_img")
				->from("comments c, user u")
				->where("c.user_id = u.id")->where("posts_id", $value['id'])->order_by ("c.datetime")->get();
				$comment = $query->result_array();
				for ($j=0; $j < count($comment); $j++) {
					$query1 = $this->db->from("comments_reply cr, user u")->where("cr.comments_id", $comment[$j]["id"])->where("u.id = cr.user_id")->get();
					$comment[$j]['reply'] = $query1->result_array();
				}
				array_push($comments, $comment);

				$query = $this->db->select("u.id, u.namadepan, u.namabelakang, u.verified, u.img, l.type")
				->from("user u, likes l")
				->where("u.id = l.user_id")->where("l.posts_id", $value['id'])->get();
				array_push($likes, $query->result_array());
			}

			$ret['posts'] = $posts;
			$ret['comments'] = $comments;
			$ret['likes'] = $likes;
			$ret['totalcommentsperpost'] = $totalcommentsperpost;
			return $ret;
		}
		public function get_post_from_id($posts_id){
			$query = $this->db->select("isi")->where("id", $posts_id)->get("posts");
			return $query->result_array()[0]["isi"];
		}
		//-----------------------------------------------------
		//NOTIFICATION
		//-----------------------------------------------------
		public function insert_notification_accepted_friend_request($id, $friend_id){
			$datasendiri = $this->get_userdata($id);
			$nama = $datasendiri['namadepan']." ".$datasendiri['namabelakang'];
			$msg = "<b>$nama</b> accepted your friend request.";
			$data = array(
				"user_id" => $friend_id,
				"msg" => $msg,
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->insert("notification", $data);
		}
		public function insert_notification_decline_friend_request($id, $friend_id){
			$datasendiri = $this->get_userdata($id);
			$nama = $datasendiri['namadepan']." ".$datasendiri['namabelakang'];
			$msg = "<b>$nama</b> decline your friend request.";
			$data = array(
				"user_id" => $friend_id,
				"msg" => $msg,
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->insert("notification", $data);
		}
		public function insert_notification_like($id, $friend_id){
			$datasendiri = $this->get_userdata($id);
			$nama = $datasendiri['namadepan']." ".$datasendiri['namabelakang'];
			$msg = "<b>$nama</b> liked your post.";
			$data = array(
				"user_id" => $friend_id,
				"msg" => $msg,
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->insert("notification", $data);		}
		public function insert_notification_comment($id, $friend_id){
			$datasendiri = $this->get_userdata($id);
			$nama = $datasendiri['namadepan']." ".$datasendiri['namabelakang'];
			$msg = "<b>$nama</b> commented your post.";
			$data = array(
				"user_id" => $friend_id,
				"msg" => $msg,
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->insert("notification", $data);
		}
		public function insert_notification_commentreply($id, $friend_id){
			$datasendiri = $this->get_userdata($id);
			$nama = $datasendiri['namadepan']." ".$datasendiri['namabelakang'];
			$msg = "<b>$nama</b> replied to your comment.";
			$data = array(
				"user_id" => $friend_id,
				"msg" => $msg,
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->insert("notification", $data);
		}
		public function insert_notification_seeprofile($id, $friend_id){
			$datasendiri = $this->get_userdata($id);
			$nama = $datasendiri['namadepan']." ".$datasendiri['namabelakang'];
			$msg = "<b>$nama</b> saw your profile.";
			$data = array(
				"user_id" => $friend_id,
				"msg" => $msg,
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->insert("notification", $data);
		}
		public function insert_notification_mention($id, $friend_id){
			$datasendiri = $this->get_userdata($id);
			$nama = $datasendiri['namadepan']." ".$datasendiri['namabelakang'];
			$msg = form_open('cont', 'class = form-mention') .
			form_hidden('_userskrng', $friend_id) .
			form_hidden('friend_id', $id) .
			"<input type='submit' name='profileuser' class='btn-mention' value='<b>$nama</b> mention you.'>".
			form_close();
			$data = array(
				"user_id" => $friend_id,
				"msg" => $msg,
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->insert("notification", $data);
		}
		public function insert_notification($user_id, $msg){
			$data = array(
				"user_id" => $user_id,
				"msg" => $msg,
				"datetime" => date("Y-m-d H:i:s")
			);
			$query = $this->db->insert("notification", $data);
		}
		public function count_notification($id){
			return $this->db->select("*")->from("notification")->where("user_id", $id)->count_all_results();
		}
		public function get_notification($id, $limit = 0, $page = 0){
			$query = $this->db->select("*")->from("notification")->where("user_id", $id)
			->limit($limit, $page)->get();
			return $query->result_array();
		}
		public function get_chat_notification($id){
			$this->db->from('chat_rooms_participant')
			->where("read", "0")
			->where("user_id", $id)
			->where("deleted", "0");
			return $this->db->count_all_results();
		}
		//-----------------------------------------------------
		//SKILL
		//-----------------------------------------------------
		public function get_skill($id, $limit = null){
			$subquery = $this->db->select("count(*)")->from("skill_endorse e")->where("e.skill_id  = s.id")->get_compiled_select();
			$this->db->select("s.id, s.nama, ($subquery) as jumlahendorse")
			->from("skill s")
			->where("s.user_id", $id)
			->order_by("jumlahendorse desc");
			if ($limit != null) {
				$this->db->limit($limit);
			}
			$query = $this->db->get();
			$data = $query->result_array();

			for ($i=0; $i < count($data); $i++) {
				$query = $this->db->select("u.id")->select("u.namadepan")->select("u.namabelakang")
				->from("skill_endorse e, user u")
				->where("e.user_id = u.id")->where("e.skill_id", $data[$i]["id"])->get();
				$data[$i]["endorse"] = $query->result_array();
			}

			return $data;
		}
		public function delete_skill($id){
			$this->db->where("skill_id", $id)->delete("skill_endorse");
			$this->db->where("id", $id)->delete("skill");
			return $this->db->affected_rows();
		}
		public function add_skill($user_id, $namaskill){
			$data = array(
				"user_id" => $user_id,
				"nama" => $namaskill
			);
			$this->db->insert("skill", $data);
			return $this->db->affected_rows();
		}
		public function add_endorse($skill_id, $user_id){
			$data = array(
				"skill_id" => $skill_id,
				"user_id" => $user_id
			);
			$this->db->insert("skill_endorse", $data);
			return $this->db->affected_rows();
		}
		public function delete_endorse($skill_id, $user_id){
			$data = array(
				"skill_id" => $skill_id,
				"user_id" => $user_id
			);
			$this->db->where($data)->delete("skill_endorse");
			return $this->db->affected_rows();
		}
		//-----------------------------------------------------
		//CHAT ROOM
		//-----------------------------------------------------
		public function count_all_chat_rooms($user_id){
			return $this->db
			->FROM("chat_rooms r")->from("chat_rooms_participant p")
			->WHERE("p.chat_rooms_id = r.id")->where("p.user_id", $user_id)
			->where("p.deleted", "0")->count_all_results();
		}
		public function get_all_chat_rooms($user_id, $limit, $start){
			$subquery = $this->db->select("message_id")->from("message_deleted d")->where ("d.user_id", $user_id)->get_compiled_select();
			$last_msg_namadepan = $this->db->select('concat(u.namadepan)')
			->from("message m")->from("user u")
			->where("m.id > p.message_id_last")
			->WHERE("m.chat_rooms_id = r.id")->where("u.id = m.user_id")
			->where("m.id not in ($subquery)")
			->ORDER_by("datetime desc")
			->limit(1)->get_compiled_select();
			$last_msg_namabelakang = $this->db->select('concat(u.namabelakang)')
			->from("message m")->from("user u")
			->where("m.id > p.message_id_last")
			->WHERE("m.chat_rooms_id = r.id")->where("u.id = m.user_id")
			->where("m.id not in ($subquery)")
			->ORDER_by("datetime desc")
			->limit(1)->get_compiled_select();
			$last_msg_time = $this->db->select("datetime")
			->from("message m")
			->where("m.id > p.message_id_last")
			->WHERE("m.chat_rooms_id = r.id")
			->where("m.id not in ($subquery)")
			->ORDER_by("datetime desc")
			->limit(1)->get_compiled_select();
			$last_msg = $this->db->select("msg")
			->from("message m")
			->where("m.id > p.message_id_last")
			->WHERE("m.chat_rooms_id = r.id")
			->where("m.id not in ($subquery)")
			->ORDER_by("datetime desc")
			->limit(1)->get_compiled_select();

			$query = $this->db->SELECT("r.id, r.private, p.read, ($last_msg_namadepan) as last_msg_namadepan, ($last_msg_namabelakang) as last_msg_namabelakang, ($last_msg_time) as last_msg_time, ($last_msg) as last_msg")
			->FROM("chat_rooms r")->from("chat_rooms_participant p")
			->WHERE("p.chat_rooms_id = r.id")->where("p.user_id", $user_id)
			->where("p.deleted", "0")
			->order_by("last_msg_time desc")
			->limit($limit, $start)->get();
			$data = $query->result_array();

			for ($i=0; $i < count($data); $i++) {
				$query = $this->db->select('u.id, u.namadepan, u.namabelakang, u.img')
				->from("chat_rooms_participant p")->from("user u")
				->where("p.deleted", "0")
				->where("u.id !=", $user_id)
				->where("chat_rooms_id", $data[$i]["id"])
				->where("u.id = p.user_id")
				->get();
				$data[$i]["participant"] = $query->result_array();
			}

			return $data;
		}
		public function get_participant($rooms_id, $user_id){
			$query = $this->db->select("u.id, u.namadepan, u.namabelakang, u.img")
				->from("user u")->from("chat_rooms_participant p")->from("chat_rooms r")
				->where("p.chat_rooms_id = r.id")
				->where("p.user_id = u.id")
				->where("r.id", $rooms_id)
				->where("u.id !=", $user_id)
				->get();
			return $query->result_array();
		}
		public function get_friendslistname($id){
			$query = $this->db->select("f.user_id1 ,f.user_id2")
			->from("user u, friends f")
			->where("u.id", $id)->where("(f.user_id1 = u.id or f.user_id2 = u.id)")->where("status", "friend")->get();
			$data = $query->result_array();

			$friendlistid = array();
			foreach ($data as $key => $value) {
				if ($value["user_id1"] != $id) {
					array_push($friendlistid, $value["user_id1"]);
				}else {
					array_push($friendlistid, $value["user_id2"]);
				}
			}

			if ($friendlistid != null) {
				$this->db->select("id, namadepan, namabelakang, img")
				->from("user")->where_in("id", $friendlistid);
				$query = $this->db->get();
				return $query->result_array();
			}
			else {
				return null;
			}

		}
		public function update_room_read($chat_rooms_id, $user_id){
			$data = array(
				"chat_rooms_id" => $chat_rooms_id,
				"user_id" => $user_id
			);
			$dataupdate = array("read" => "1");
			$this->db->where($data)->update("chat_rooms_participant", $dataupdate);
		}
		public function update_room_unread($chat_rooms_id){
			$data = array("chat_rooms_id" => $chat_rooms_id);
			$dataupdate = array("read" => "0");
			$this->db->where($data)->update("chat_rooms_participant", $dataupdate);
		}
		public function update_room_deleted($chat_rooms_id, $user_id){
			$data = array("chat_rooms_id" => $chat_rooms_id, "user_id" => $user_id);
			var_dump($data);
			$dataupdate = array("deleted" => "1");
			$this->db->where($data)->update("chat_rooms_participant", $dataupdate);
			return $this->db->affected_rows();
		}
		public function get_friendlistname_notinroom($chat_rooms_id, $user_id){
			$query = $this->db->select("f.user_id1 ,f.user_id2")
			->from("user u, friends f")
			->where("u.id", $user_id)->where("(f.user_id1 = u.id or f.user_id2 = u.id)")->where("status", "friend")->get();
			$data = $query->result_array();

			$friendlistid = array();
			foreach ($data as $key => $value) {
				if ($value["user_id1"] != $user_id) {
					array_push($friendlistid, $value["user_id1"]);
				}else {
					array_push($friendlistid, $value["user_id2"]);
				}
			}

			$subquery = $this->db->select("user_id")->where("chat_rooms_id", $chat_rooms_id)->get_compiled_select("chat_rooms_participant");

			if ($friendlistid != null) {
				$this->db->select("id, namadepan, namabelakang")
				->from("user")->where_in("id", $friendlistid)->where("id not in ($subquery)");
				$query = $this->db->get();
				return $query->result_array();
			}
			else {
				return null;
			}
		}
		public function add_user_tochatroom($chat_rooms_id, $user_id){
			$query = $this->db->select("id")
			->from("message m")
			->where("chat_rooms_id", $chat_rooms_id)
			->ORDER_by("datetime desc")
			->limit(1)->get();

			$message_id_last = $query->result_array()[0]["id"];

			$data = array(
				"chat_rooms_id" => $chat_rooms_id,
				"user_id" => $user_id,
				"read" => 1,
				"deleted" => 0,
				"message_id_last" => $message_id_last
			);

			$this->db->insert("chat_rooms_participant", $data);
		}
		public function add_newroom($user_id){
			$this->db->set("id", null)->set("private",0)->insert("chat_rooms");
			$id = $this->db->insert_id();
			foreach ($user_id as $key => $value) {
				$data = array(
					"chat_rooms_id" => $id,
					"user_id" => $value,
					"read" => 0,
					"deleted" => 0,
					"message_id_last" => 0
				);
				$this->db->insert("chat_rooms_participant", $data);
			}
			return $id;
		}
		public function add_newprivateroom($user_id){
			$this->db->set("id", null)->set("private", 1)->insert("chat_rooms");
			$id = $this->db->insert_id();
			foreach ($user_id as $key => $value) {
				$data = array(
					"chat_rooms_id" => $id,
					"user_id" => $value,
					"read" => 0,
					"deleted" => 0,
					"message_id_last" => 0
				);
				$this->db->insert("chat_rooms_participant", $data);
			}
			return $id;
		}
		public function check_room($user_id_array){
			$subquery = $this->db->select("chat_rooms_id")
			->from("chat_rooms_participant")
			->group_by("chat_rooms_id")
			->having("count(chat_rooms_id)", 2)
			->get_compiled_select();

			$query = $this->db->select("chat_rooms_id as chat_rooms_id2, user_id as user_id2")
			->from("chat_rooms_participant")
			->where("chat_rooms_id in ($subquery)")
			->where_in("user_id", $user_id_array)
			->get_compiled_select();

			$query1 = $this->db->select("chat_rooms_id2 as chat_rooms_id")
			->from("($query) as subquery2")
			->group_by("chat_rooms_id2")
			->having("count(chat_rooms_id2)", 2)
			->limit(1)->order_by("chat_rooms_id")->get();
			return $query1->result_array();
		}
		public function check_room_private($chat_rooms_id){
			return $this->db->where("id", $chat_rooms_id)->where("private", 1)->count_all_results('chat_rooms');
		}
		public function check_room_accessible($user_id, $chat_rooms_id){
			return $this->db
			->where("p.user_id", $user_id)->where("r.id", $chat_rooms_id)->where("private", 0)
			->where("p.chat_rooms_id = r.id")
			->from("chat_rooms r")->from("chat_rooms_participant p")
			->count_all_results();
		}
		public function check_room_private_accessible($user_id, $chat_rooms_id){
			return $this->db
			->where("p.user_id", $user_id)->where("r.id", $chat_rooms_id)->where("private", 1)
			->where("p.chat_rooms_id = r.id")
			->from("chat_rooms r")->from("chat_rooms_participant p")
			->count_all_results();
		}
		//-----------------------------------------------------
		//CHAT
		//-----------------------------------------------------
		public function get_chat($chat_rooms_id, $user_id){
			$subquerynamadepan = $this->db->select("u.namadepan")
			->from("user u")
			->where("id = m.user_id")->get_compiled_select();
			$subquerynamabelakang = $this->db->select("u.namabelakang")
			->from("user u")
			->where("id = m.user_id")->get_compiled_select();
			$subqueryimg = $this->db->select("u.img")
			->from("user u")
			->where("id = m.user_id")->get_compiled_select();
			$subquery = $this->db->select("message_id")->from("message_deleted d")->where ("d.user_id", $user_id)->get_compiled_select();
			$subquery1 = $this->db->select("p.message_id_last")->from("chat_rooms_participant p")->where("p.chat_rooms_id", $chat_rooms_id)->where("p.user_id", $user_id)->get_compiled_select();

			$query = $this->db->select("m.id, m.msg ,m.datetime, m.user_id, m.img as chat_img, ($subquerynamadepan) as namadepan, ($subquerynamabelakang) as namabelakang, ($subqueryimg) as img")
			->from("message m")
			->where("m.chat_rooms_id", $chat_rooms_id)
			->where("m.id not in ($subquery)")
			->where("m.id > ($subquery1)")
			->order_by("datetime")
			->get();
			return $query->result_array();
		}
		public function get_chat_private($chat_rooms_id, $user_id){
			$now = date("Y-m-d H:i:s", time() - 30);
			$subquerynamadepan = $this->db->select("u.namadepan")
			->from("user u")
			->where("id = m.user_id")->get_compiled_select();
			$subquerynamabelakang = $this->db->select("u.namabelakang")
			->from("user u")
			->where("id = m.user_id")->get_compiled_select();
			$subqueryimg = $this->db->select("u.img")
			->from("user u")
			->where("id = m.user_id")->get_compiled_select();
			$subquery = $this->db->select("message_id")->from("message_deleted d")->where ("d.user_id", $user_id)->get_compiled_select();
			$subquery1 = $this->db->select("p.message_id_last")->from("chat_rooms_participant p")->where("p.chat_rooms_id", $chat_rooms_id)->where("p.user_id", $user_id)->get_compiled_select();

			$query = $this->db->select("m.id, m.msg ,m.datetime, m.user_id, m.img, ($subquerynamadepan) as namadepan, ($subquerynamabelakang) as namabelakang, ($subqueryimg) as img")
			->from("message m")
			->where("m.chat_rooms_id", $chat_rooms_id)
			->where("m.id not in ($subquery)")
			->where("m.id > ($subquery1)")
			->where("datetime >=", $now)
			->order_by("datetime desc")
			->get();
			return $query->result_array();
		}
		public function insert_chat($msg, $chat_rooms_id, $user_id, $img = null){
			$data = array(
				"chat_rooms_id" => $chat_rooms_id,
				"user_id" => $user_id,
				"msg" => $msg,
				"datetime" => date("Y-m-d H:i:s"),
				"img" => $img
			);
			$this->db->insert("message", $data);
			$this->update_room_unread($chat_rooms_id);
		}
		public function insert_message_deleted($message_id, $user_id){
			$data = array(
				"message_id" => $message_id,
				"user_id" => $user_id
			);
			$this->db->insert("message_deleted", $data);
		}

		public function get_post_from_hashtag($hashtag, $_userskrng, $limit = 0, $start = 0){
			$hashtag = "#" . "$hashtag";

			$now = date("Y-m-d H:i:s", time() - 120);
			$subquery = $this->db->select("count(l.posts_id)")->from("likes l")->where("l.posts_id = p.id")->get_compiled_select();
			$namadepan = $this->db->select("namadepan")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$namabelakang = $this->db->select("namabelakang")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$img = $this->db->select("img")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$verified = $this->db->select("verified")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$query = $this->db->select("p.id, p.isi, p.datetime, p.timed, p.img, p.user_id,($subquery) as likes, ($namadepan) as namadepan, ($namabelakang) as namabelakang, ($img) as user_img, ($verified) as verified")
					->from("posts p")
					->like("p.isi", $hashtag)
					->group_start()
						->group_start()
							->where("p.timed = 0")
						->group_end()
						->or_group_start()
							->where("p.timed = 1")
							->where("p.datetime >", $now)
						->group_end()
					->group_end()
					->order_by("datetime desc")
					->limit($limit,$start)->get();

			$posts = $query->result_array();

			$comments = array();
			$likes = array();
			$totalcommentsperpost = array();
			for ($i=0; $i < count($posts); $i++) {
				$query = $this->db->select("count(*) as count")->from("comments")->where("posts_id", $posts[$i]['id'])->get();
				array_push($totalcommentsperpost, $query->row_array()['count']);

				$query = $this->db->select("c.id, c.isi, c.datetime, u.id as user_id, u.namadepan, u.namabelakang, u.verified, u.img as user_img")
				->from("comments c, user u")
				->where("c.user_id = u.id")->where("posts_id", $posts[$i]['id'])->order_by("c.datetime")->get();
				$comment = $query->result_array();
				for ($j=0; $j < count($comment); $j++) {
					$query1 = $this->db->from("comments_reply cr, user u")->where("cr.comments_id", $comment[$j]["id"])->where("u.id = cr.user_id")->get();
					$comment[$j]['reply'] = $query1->result_array();
				}
				array_push($comments, $comment);


				$query = $this->db->select("u.id, u.namadepan, u.namabelakang, u.verified")
				->from("user u, likes l")
				->where("u.id = l.user_id")->where("l.posts_id", $posts[$i]['id'])->get();
				array_push($likes, $query->result_array());

				//CEK MENTION
				$posts[$i]["isi"] = $this->return_post_with_mention($posts[$i]["isi"], $_userskrng);
				$posts[$i]["isi"] = $this->return_post_with_hashtag($posts[$i]["isi"]);
			}

			$ret['posts'] = $posts;
			$ret['comments'] = $comments;
			$ret['likes'] = $likes;
			$ret['totalcommentsperpost'] = $totalcommentsperpost;
			return $ret;
		}

		public function return_post_with_mention($post, $_userskrng){
			$temp = array();
			$tempend = array();
			$found = false;
			for ($j=0; $j < strlen($post); $j++) {
				if (!$found) {
					if ($post[$j] == "@") {
						array_push($temp, $j);
						$found = true;
					}
				}
				else{
					if ($post[$j] == " " || $post[$j] == "," || $post[$j] == "." || $post[$j] == "<") {
						array_push($tempend, $j - 1);
						$found = false;
					}
					else if (strlen($post) <= $j + 1) {
						array_push($tempend, $j);
						$found = false;
					}
				}
			}
			for ($j=0; $j <= count($temp); $j++) {
				$startpos = array_pop($temp);
				$lastpos = array_pop($tempend)+1;
				$namadepan = substr($post, $startpos+1, $lastpos-$startpos-1);
				$idguestprofile = $this->get_id_from_namadepan($namadepan);
				if ($idguestprofile != -1) {

					$closingtag = "</a>";
					$post = substr_replace($post, $closingtag , $lastpos, 0);
					$openingtag = "<a href='".site_url('cont/user/'.$idguestprofile)."'>";
					$post = substr_replace($post, $openingtag , $startpos, 0);
				}
			}
			return $post;
		}
		public function notification_post_mention($post, $_userskrng){
			$temp = array();
			$tempend = array();
			$found = false;
			for ($j=0; $j < strlen($post); $j++) {
				if (!$found) {
					if ($post[$j] == "@") {
						array_push($temp, $j);
						$found = true;
					}
				}
				else{
					if ($post[$j] == " " || $post[$j] == "," || $post[$j] == "." || $post[$j] == "<") {
						array_push($tempend, $j - 1);
						$found = false;
					}
					else if (strlen($post) <= $j + 1) {
						array_push($tempend, $j);
						$found = false;
					}
				}
			}
			for ($j=0; $j < count($temp); $j++) {
				$startpos = array_values(array_slice($temp, -1))[0];
				$lastpos = array_values(array_slice($tempend, -1))[0]+1;
				$namadepan = substr($post, $startpos+1, $lastpos-$startpos);
				$idguestprofile = $this->get_id_from_namadepan($namadepan);
				if ($idguestprofile != -1) {
					if ($_userskrng != $idguestprofile) {
						$this->insert_notification_mention($_userskrng, $idguestprofile);
					}
				}
			}
		}
		public function return_post_with_hashtag($post){
			return preg_replace('/(?:^|\s)#(\w+)/', ' <a href="'.site_url("search/hashtag").'/$1">#$1</a>', $post);
		}

		public function insert_report($user_id_reporter, $user_id_reported, $posts_id, $reason) {
			$data = array("user_id_reporter" => $user_id_reporter,
						  "user_id_reported" => $user_id_reported,
						  "posts_id" => $posts_id,
						  "reason" => $reason,
						  "done" => 0,
						  "datetime" => date("Y-m-d H:i:s")
					);
			$this->db->insert("report", $data);
			return $this->db->affected_rows();
		}

		public function is_user_member($group_id, $user_id){
			$this->db->from("group_member")
			->where("user_id", $user_id)
			->where("group_id", $group_id);
			return boolval($this->db->count_all_results());
		}
		public function join_group($group_id, $user_id){
			$data = array(
				"group_id" => $group_id,
				"user_id" => $user_id
			);
			$this->db->insert("group_member", $data);
		}
		public function leave_group($group_id, $user_id){
			$data = array(
				"group_id" => $group_id,
				"user_id" => $user_id
			);
			$this->db->where($data)->delete("group_member");
		}
		public function get_group_tentang($group_id){
			$query = $this->db->select("g.id, g.user_id, g.name, g.description, g.img as group_img, g.datetime, u.namadepan, u.namabelakang, u.img as user_img, u.verified")
			->from("user u, group g")
			->where("g.id", $group_id)
			->where("u.id = g.user_id")
			->get();
			return $query->result_array()[0];
		}
		public function get_group_member($group_id){
			$query = $this->db->select("u.id, u.namadepan, u.namabelakang, u.img, u.verified")
			->from("user u, group_member m")
			->where("u.id = m.user_id")
			->where("m.group_id", $group_id)
			->get();
			return $query->result_array();
		}

		public function get_group_posts($group_id, $limit = 0, $start = 0){
			$now = date("Y-m-d H:i:s", time() - 120);
			$subquery = $this->db->select("count(l.posts_group_id)")->from("likes_group l")->where("l.posts_group_id = p.id")->get_compiled_select();
			$namadepan = $this->db->select("namadepan")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$namabelakang = $this->db->select("namabelakang")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$img = $this->db->select("img")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$verified = $this->db->select("verified")->from("user u")->where("u.id = p.user_id")->get_compiled_select();
			$query = $this->db->select("p.id, p.isi, p.datetime, p.img, p.timed, p.user_id,($subquery) as likes, ($namadepan) as namadepan, ($namabelakang) as namabelakang, ($img) as user_img, ($verified) as verified")
					->from("posts_group p")
					->where("p.group_id = ", $group_id)
					->group_start()
						->group_start()
							->where("p.timed = 0")
						->group_end()
						->or_group_start()
							->where("p.timed = 1")
							->where("p.datetime >", $now)
						->group_end()
					->group_end()
					->order_by("datetime desc")
					->limit($limit,$start)->get();

			$posts = $query->result_array();

			$comments = array();
			$likes = array();
			$totalcommentsperpost = array();
			for ($i=0; $i < count($posts); $i++) {
				$query = $this->db->select("count(*) as count")->from("comments_group")->where("posts_group_id", $posts[$i]['id'])->get();
				array_push($totalcommentsperpost, $query->row_array()['count']);

				$query = $this->db->select("c.id, c.isi, c.datetime, u.id as user_id, u.namadepan, u.namabelakang, u.verified, u.img as user_img")
				->from("comments_group c, user u")
				->where("c.user_id = u.id")->where("posts_group_id", $posts[$i]['id'])->order_by("c.datetime")->get();
				$comment = $query->result_array();
				for ($j=0; $j < count($comment); $j++) {
					$query1 = $this->db->select("cr.id, cr.user_id, cr.comments_group_id, cr.isi, cr.datetime, u.namadepan, u.namabelakang, u.img, u.verified")
					->from("comments_group_reply cr, user u")->where("cr.comments_group_id", $comment[$j]["id"])->where("u.id = cr.user_id")->get();
					$comment[$j]['reply'] = $query1->result_array();
				}
				array_push($comments, $comment);


				$query = $this->db->select("u.id, u.namadepan, u.namabelakang, u.verified, u.img, l.type")
				->from("user u, likes_group l")
				->where("u.id = l.user_id")->where("l.posts_group_id", $posts[$i]['id'])->get();
				array_push($likes, $query->result_array());

				//CEK MENTION
				$posts[$i]["isi"] = $this->return_post_with_mention($posts[$i]["isi"], $this->session->_userskrng);
				$posts[$i]["isi"] = $this->return_post_with_hashtag($posts[$i]["isi"]);
			}

			$ret['posts'] = $posts;
			$ret['comments'] = $comments;
			$ret['likes'] = $likes;
			$ret['totalcommentsperpost'] = $totalcommentsperpost;
			return $ret;
		}
		public function get_post_group_by_id($id) {
			$query = $this->db->query("select * from posts_group where id = '$id'");
			return $query->row();
		}
		public function insert_posts_group($id, $isi, $img = null, $group_id){
			$data = array(
				"user_id" => $id,
				"isi" => $isi,
				"datetime" => date("Y-m-d H:i:s"),
				"timed" => 0,
				"img" => $img,
				"group_id" =>$group_id
			);
			$query = $this->db->insert("posts_group", $data);
			return $this->db->affected_rows();
		}
		public function insert_posts_group_timed($id, $isi, $img = null, $group_id){
			$data = array(
				"user_id" => $id,
				"isi" => $isi,
				"datetime" => date("Y-m-d H:i:s"),
				"timed" => 1,
				"img" => $img,
				"group_id" =>$group_id
			);
			$query = $this->db->insert("posts_group", $data);
			return $this->db->affected_rows();
		}
		public function delete_posts_group($posts_id){
			$query = $this->db->where('posts_group_id = ',$posts_id)->delete('comments_group');
			$query = $this->db->where('posts_group_id = ',$posts_id)->delete('likes_group');
			$query = $this->db->where('id = ',$posts_id)->delete('posts_group');
			return $this->db->affected_rows();
		}
		public function insert_likes_group($posts_id, $user_id, $type){
			$data = array(
				"posts_group_id" => $posts_id,
				"user_id" => $user_id,
				"type" => $type
			);
			$query = $this->db->insert("likes_group", $data);
			$query = $this->db->select("user_id")->from("posts_group")->where("id", $posts_id)->get();
			$postowner = $query->row_array()['user_id'];
			if ($postowner != $user_id) {
				$this->insert_notification_like($user_id, $postowner);
			}

			return $this->db->affected_rows();
		}
		public function delete_likes_group($posts_id, $user_id){
			$query = $this->db->where("posts_group_id",$posts_id)->where("user_id", $user_id)->delete("likes_group");
			return $this->db->affected_rows();
		}
		public function insert_comments_group($posts_id, $user_id, $isi, $img = null){
			$data = array(
				"posts_group_id" => $posts_id,
				"user_id" => $user_id,
				"isi" => $isi,
				"datetime" => date("Y-m-d H:i:s"),
			);
			$query = $this->db->insert("comments_group", $data);
			$query = $this->db->select("user_id")->from("posts_group")->where("id", $posts_id)->get();
			$postowner = $query->row_array()['user_id'];
			if ($postowner != $user_id) {
				$this->insert_notification_comment($user_id, $postowner);
			}
			return $this->db->affected_rows();
		}
		public function delete_comments_group($comments_id){
			$query = $this->db->where("id", $comments_id)->delete("comments_group");
			return $this->db->affected_rows();
		}
		public function insert_commentsreply_group($comments_id, $user_id, $isi){
			$data = array(
				"comments_group_id" => $comments_id,
				"user_id" => $user_id,
				"isi" => $isi,
				"datetime" => date("Y-m-d H:i:s"),
			);
			$query = $this->db->insert("comments_group_reply", $data);
			$query = $this->db->select("user_id")->from("comments_group")->where("id", $comments_id)->get();
			$postowner = $query->row_array()['user_id'];
			if ($postowner != $user_id) {
				$this->insert_notification_commentreply($user_id, $postowner);
			}
			return $this->db->affected_rows();
		}
		public function delete_commentsreply_group($comments_id){
			$query = $this->db->where("id", $comments_id)->delete("comments_group_reply");
			return $this->db->affected_rows();
		}
		public function get_group_from_search($search){
			$query = $this->db->like("name", $search)->get("group");
			return $query->result_array();
		}
	}
?>
