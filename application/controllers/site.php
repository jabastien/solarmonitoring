<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MY_Controller {

	public $site_id;

	public function __construct()
	{
		parent::__construct();

		// get default site ID
		$this->load->model('m_site');
		$this->site_id = $this->m_site->get_default_private_siteId();
		
	}
	public function index()
	{
		$data['page'] = 'v_home';
		$data['widgets'] = array('energy-generation', 'relatable-metrics');

		$this->load->view('includes/template', $data);
	}

	public function about()
	{
		$data['page'] = 'v_about';
		$data['widgets'] = array('site-information', 'site-testimonials');
		$this->load->view('includes/template', $data);
	}
	public function affiliates()
	{
		$data['page'] = 'v_project-affiliates';
		$data['widgets'] = array('site-information', 'site-testimonials');
		$this->load->view('includes/template', $data);
	}
	public function solution()
	{
		$data['page'] = 'v_solar-solution';
		$data['widgets'] = array('DC-only', 'replication');
		$this->load->view('includes/template', $data);
	}
	public function alerts()
	{
		$data['page'] = 'v_alerts';
		$data['widgets'] = array('alerts', 'energy-generation');
		$this->load->model('m_alerts');
		$data['all_alerts'] = $this->m_alerts->get_all_alerts($this->site_id);
		$this->load->view('includes/template', $data);
	}
	public function capture_detail($date, $hour)
	{

		if (mycheckdate($date) && isset($hour) && $hour < 23)
		{
			
					$d= $date;
					$h = $hour;
			
			
		}
		else
		{
			
			$data['message'] = 'There is an error in your request';
			$data['page'] = 'v_error';
			$this->load->view('includes/template', $data);

			
		}

		$data['page'] = 'v_capture-detail';
		$data['widgets'] = array('energy-generation');
		$this->load->model('m_metrics');
		$data['detail'] = $this->m_metrics->get_capturedata_byhour($this->site_id, $date, $hour);
		$this->load->view('includes/template', $data);
	}
	/*
	public function test()
	{
		$today= getdate();
    	$year = $today['year'];
    	$month = $today['mon'];
    	$day = $today['mday'];
    	//put date request into unix form  
    	$start= mktime(0, 0, 0, $month, $day, $year);
    	$end= mktime(23, 59, 59, $month, $day, $year);
    	$siteid = 1;
    	
    	$this->db->select('timestamp, out_i*batt_v AS kw');
    	$this->db->where('site_id', $siteid);
    	$query = $this->db->get('export_data');
    	
		//$sql = "select `timestamp`, `out_i`*`batt_v` AS `kw` from export_data where `site_id`=$siteid and `timestamp` >= FROM_UNIXTIMESTAMP($start)";
		//$sql = "select timestamp, out_i as kw from export_data where site_id=$siteid and timestamp >= UNIX_TIMESTAMP($start) AND timestamp <= UNIX_TIMESTAMP($end)";
		$sql = "select timestamp, out_i*batt_v as kw from export_data where site_id=$siteid and timestamp >= $start and timestamp <= $end";
		echo $sql;
		$query = $this->db->query($sql);
		/*
		$this->db->select('timestamp, out_i*batt_v as kw');
		$this->db->from('export_data');
		$query = $this->db->get();
		
		//$result = $query->result_array();
		foreach ($query->result() as $row)
		{
			echo $row->timestamp;
			echo $row->kw;
			
		}
		
		
	}
	*/


}

