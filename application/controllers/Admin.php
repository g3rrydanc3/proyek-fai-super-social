<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if (!$this->session->is_admin) {
			redirect($this->default_page_not_logged_in);
		}
		$this->load->model("madmin");
	}
	public function index(){
		$this->load->view("admin/home");
	}
	public function user($user = null){
		if ($user == null) {
			$data["user"] = $this->madmin->get_all_user();
			$this->load->view("admin/user", $data);
		}
		else {
			$data["user_data"] = $this->madmin->get_user_data($user);
			$this->load->view("admin/user_data",$data);
		}
	}
	public function user_data_process(){
		$rulesEditUser = array(
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
		$this->form_validation->set_rules($rulesEditUser);

		if($this->form_validation->run()){
			$this->madmin->update_user($this->input->post());
			$this->session->set_flashdata('msg', "Update user berhasil.");
		}
		else{
			$this->session->set_flashdata('errors', validation_errors());
		}
		redirect($this->agent->referrer());
	}

	public function group($group_id = null){
		if ($group_id == null) {
			$data["group"] = $this->madmin->get_all_group();
			$this->load->view("admin/group", $data);
		}
		else {
			$data["group_data"] = $this->madmin->get_group_data($group_id);
			$this->load->view("admin/group_data", $data);
		}

	}
	public function group_data_process(){
		$rulesEditGroup = array(
			array(
				'field' => 'group_id',
				'label' => 'ID Group',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'user_id',
				'label' => 'ID User',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'name',
				'label' => 'Nama',
				'rules' => 'required'
			),
			array(
				'field' => 'datetime',
				'label' => 'Tanggal pembuatan',
				'rules' => 'required'
			),
		);
		$this->form_validation->set_rules($rulesEditGroup);

		if($this->form_validation->run()){
			$this->madmin->update_group($this->input->post());
			$this->session->set_flashdata('msg', "Update group berhasil.");
		}
		else{
			$this->session->set_flashdata('errors', validation_errors());
		}
		redirect($this->agent->referrer());
	}
	public function reported_user(){
		$data["reported_user"] = $this->madmin->get_all_report_not_done();
		$data["reported_user_done"] = $this->madmin->get_all_report_done();
		$this->load->view("admin/reported_user", $data);
	}
	public function reported_user_process($group_id){
		$this->madmin->report_done($group_id);
		$this->session->set_flashdata("msg", "Report sudah selesai!");
		redirect("admin/reported_user");
	}
	public function report(){
		$this->load->helper("date_dropdown");

		$this->load->view("admin/report");
	}




	public function chart_post($year, $month){
		$this->load->library('highcharts');

		$data_chart_post['x_labels'] 	= 'datetime'; // optionnal, set axis categories from result row
		$data_chart_post['series'] 	= array('Jumlah Post'); // set values to create series, values are result rows
		$data_chart_post['data']		= $this->madmin->get_report_posts($year, $month);

		$this->highcharts->render_to("chart_post");
		$this->highcharts->set_title('POST USER', date('F', mktime(0, 0, 0, $month, 10)) . " ". $year); // set chart title: title, subtitle(optional)
		$this->highcharts->set_axis_titles('Tanggal', 'Jumlah Post'); // axis titles: x axis,  y axis
		$this->highcharts->from_result($data_chart_post)->add(); // first graph: add() register the graph

		echo $this->highcharts->render();
	}
	public function chart_private(){
		$this->load->library('highcharts');

		$this->highcharts->render_to("chart_private");
		$data_chart_private['series'] 	= array('Private User', 'Not Private User'); // set values to create series, values are result rows
		$data_chart_private['data']		= $this->madmin->get_report_private();

		$this->highcharts->set_type('column'); // drauwing type
		$this->highcharts->set_title('PRIVATE USER'); // set chart title: title, subtitle(optional)
		$this->highcharts->set_axis_titles('','Jumlah User'); // axis titles: x axis,  y axis
		$this->highcharts->from_result($data_chart_private)->add(); // first graph: add() register the graph

		echo $this->highcharts->render();
	}
	public function chart_reportuser($year){
		$this->load->library('highcharts');

		$data_chart_post['x_labels'] 	= 'datetime'; // optionnal, set axis categories from result row
		$data_chart_post['series'] 	= array('Jumlah Report'); // set values to create series, values are result rows
		$data_chart_post['data']		= $this->madmin->get_report_reportuser_yearly($year);

		$this->highcharts->render_to("chart_report_user");
		$this->highcharts->set_title('REPORT USER', $year); // set chart title: title, subtitle(optional)
		$this->highcharts->set_axis_titles('Bulan', 'Jumlah Post'); // axis titles: x axis,  y axis
		$this->highcharts->from_result($data_chart_post)->add(); // first graph: add() register the graph

		echo $this->highcharts->render();
	}
}
?>
