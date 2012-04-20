<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Solardata extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function index()
	{
				
		$data['page'] = 'v_solar-data';
		$data['include'] = 'js/solar-data.js';
		$data['widgets'] = array('energy-generation', 'relatable-metrics');
		$this->load->model('m_site');
		$pubID = $this->m_site->get_default_public_siteId();
		$day = date("Y-m-d"); 
		$today = 'true';
			
		$api_url = "api/kwh/day/date/" . $day . "/siteID/" . $pubID; 

		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillKwh(data, 'hour', $today);",
								"complete" => "buildBigChart('kWh', 'day', 2);");
							//"success" => "kwh_day_success");
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

