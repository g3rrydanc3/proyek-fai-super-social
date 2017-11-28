<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	protected $default_page = "newsfeed";
	protected $default_page_not_logged_in = "user/login";
	public $pesan = "";
	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->chat_count_refresh();
	}
	protected $rulesRegister1 = array(
		array(
			'field' => 'namadepan',
			'label' => 'Nama Depan',
			'rules' => 'required|alpha'
		),
		array(
			'field' => 'namabelakang',
			'label' => 'Nama Belakang',
			'rules' => 'required|alpha'
		),
		array(
			'field' => 'email',
			'label' => 'E-mail',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'nohp',
			'label' => 'No HP',
			'rules' => 'required|numeric'
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|min_length[6]|regex_match["^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]"]'
		),
		array(
			'field' => 'password2',
			'label' => 'Konfirmasi Password',
			'rules' => 'required|matches[password]'
		)
	);
	protected $rulesRegister2 = array(
		array(
			'field' => 'alamat',
			'label' => 'Alamat',
			'rules' => 'required'
		),
		array(
			'field' => 'kodepos',
			'label' => 'Kode Pos',
			'rules' => 'numeric'
		),
		array(
			'field' => 'negara',
			'label' => 'Negara',
			'rules' => 'required'
		),
		array(
			'field' => 'jabatan',
			'label' => 'Jabatan',
			'rules' => 'required'
		),
		array(
			'field' => 'perusahaan',
			'label' => 'Perusahaan',
			'rules' => 'required'
		),
		array(
			'field' => 'bioperusahaan',
			'label' => 'Bio Perusahaan',
			'rules' => ''
		),
		array(
			'field' => 'biouser',
			'label' => 'Bio User',
			'rules' => ''
		)
	);
	protected $rulesgantipassword = array(
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|min_length[6]|regex_match["^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]"]'
		),
		array(
			'field' => 'password2',
			'label' => 'Konfirmasi Password',
			'rules' => 'required|matches[password]'
		)
	);
	protected $ruleseditaccount= array(
		array(
			'field' => 'namadepan',
			'label' => 'Nama Depan',
			'rules' => 'required|alpha'
		),
		array(
			'field' => 'namabelakang',
			'label' => 'Nama Belakang',
			'rules' => 'required|alpha'
		),
		array(
			'field' => 'email',
			'label' => 'E-mail',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'nohp',
			'label' => 'No HP',
			'rules' => 'required|numeric'
		)
	);

	protected function session_refresh(){
		if ($this->session->userdata('_userskrng')) {
			$id = $this->session->userdata('_userskrng');
			$this->session->set_userdata("name", $this->mydb->get_userdata($id)["namadepan"] . " ". $this->mydb->get_userdata($id)["namabelakang"]);
			$this->chat_count_refresh();
		}
	}
	protected function chat_count_refresh(){
		if ($this->session->userdata('_userskrng')) {
			$this->session->set_userdata("unread_chat", $this->mydb->get_chat_notification($this->session->_userskrng));
		}
	}
	protected function check_logged_in(){
		if ($this->session->_userskrng && $this->session->_userskrng != null) {
			return true;
		}
		else {
			return false;
		}
	}
}
?>
