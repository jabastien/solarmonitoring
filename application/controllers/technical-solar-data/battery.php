<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Battery extends MY_Controller {

	private $sitePubID;
	private $siteID;

	function __construct()
    {
       parent::__construct();
       $this->load->model('m_site');
	 	$this->sitePubID = $this->m_site->get_default_public_siteId();
		$this->siteID = $this->m_site->get_siteId($this->sitePubID);
        
    }
	public function index()
	{
		
		redirect('/technical-solar-data/battery/day');


	}
	public function day($date = null)
	{
		
		
		if (mycheckdate($date))
		{
			$day= $date;
			$api_url = "api/battery/day/date/" . $day . "/siteID/" . $this->sitePubID; 
			$today = "false";
		}
		else
		{
			// default to today()
			$day = date("Y-m-d"); 
			$api_url = "api/battery/day/date/" . $day . "/siteID/" . $this->sitePubID; 
			$today = "true";

			
		}

		$this->load->model('m_battery');
		$data['battery'] = $this->m_battery->get_battery_detail($this->site_id, $day, 'day');
		$data['period'] = 'day';
		$data['page'] = 'solardata/v_battery';
		$data['chartdatelabel'] = myDateInterval($day, 'day');
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillBattery(data, 'hour', $today);",
							"complete" => "buildBigChart('Volts', 'day', 2);");
		$data['widgets'] = array('alerts', 'peak-power', 'battery-history');
		$this->load->view('includes/template', $data);


		
	}
	public function week($date = null)
	{
		if (mycheckdate($date))
		{
			$day= $date;
			$api_url = "api/battery/week/date/" . $day . "/siteID/" . $this->sitePubID; 
		}
		else
		{
			// default to today()
			$day = date("Y-m-d"); 
			$api_url = "api/battery/week/date/" . $day . "/siteID/" . $this->sitePubID; 

			
		}

		$this->load->model('m_battery');
		$data['battery'] = $this->m_battery->get_battery_detail($this->site_id, $day, 'week');
		$data['page'] = 'solardata/v_battery';
		$data['chartdatelabel'] = myDateInterval($day, 'week');
		$data['period'] = 'week';
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillBattery(data, 'day');",
							"complete" => "buildBigChart('Volts', 'week', 2);");
		$data['widgets'] = array('alerts', 'peak-power', 'battery-history');
		$this->load->view('includes/template', $data);
		

	}
	public function month($date= null)
	{
		if (mycheckdate($date))
		{
			$day= $date;
			$api_url = "api/battery/month/date/" . $day . "/siteID/" . $this->sitePubID; 
			
		
			
		}
		else
		{
			// default to today()
			$day = date("Y-m-d"); 
			$api_url = "api/battery/month/date/" . $day . "/siteID/" . $this->sitePubID; 

			
		}

		$this->load->model('m_battery');
		$data['battery'] = $this->m_battery->get_battery_detail($this->site_id, $day, 'month');
		$data['period'] = 'month';
		$data['page'] = 'solardata/v_battery';
		$data['chartdatelabel'] = myDateInterval($day, 'month');
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillBattery(data, 'day');",
							"complete" => "buildBigChart('Volts', 'month', 2);");
		$data['widgets'] = array('alerts', 'peak-power', 'battery-history');
		$this->load->view('includes/template', $data);
		
	}
	public function year($date = null)
	{
		if (mycheckdate($date))
		{
			$api_url = "api/battery/year/date/" . $day . "/siteID/" . $this->sitePubID; 
		}
		else
		{
			// default to today()
			$day = date("Y-m-d"); 
			$api_url = "api/battery/year/date/" . $day . "/siteID/" . $this->sitePubID; 

			
		}

		$this->load->model('m_battery');
		$data['battery'] = $this->m_battery->get_battery_detail($this->site_id, $day, 'year');
		$data['period'] = 'year';
		$data['page'] = 'solardata/v_battery';
		$data['chartdatelabel'] = myDateInterval($day, 'year');
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillBattery(data, 'year');",
							"complete" => "buildBigChart('Volts', 'year', 2);");
		$data['widgets'] = array('alerts', 'peak-power', 'battery-history');
		$this->load->view('includes/template', $data);
		
	}

	public function since_inception($date = null)
	{
		$day = date("Y-m-d"); 
		$api_url = "api/battery/since_inception/siteID/" . $this->sitePubID; 

		$this->load->model('m_battery');
		$data['battery'] = $this->m_battery->get_battery_detail($this->site_id, $day, 'inception');
		$data['period'] = 'inception';
		$data['page'] = 'solardata/v_battery';
		$data['chartdatelabel'] = myDateInterval($day, 'inception');
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillBattery(data, 'inception');",
							"complete" => "buildBigChart('Volts', 'inception', 2);");
		$data['widgets'] = array('alerts', 'peak-power', 'battery-history');
		$this->load->view('includes/template', $data);
		
	}

	public function download()
	{
		$this->load->dbutil();
		$query = $this->db->query("select created_date, port, out_i as out_current, in_i as in_current, batt_v as battery_voltage, 
			in_v as pv_voltage, out_kwh, out_ah from export_data where site_id=$this->siteID");

				//write csv data
		$data = $this->dbutil->csv_from_result($query);
		//create random file name
		$name = 'data_'.date('d-m-y-s').'.csv';
		$this->load->helper('file');
		if ( ! write_file('./csv/'.$name, $data))
		{
		     echo 'Unable to write the CSV file';
		}
		else
		{
		    //perform download
		    $file = file_get_contents("./csv/".$name); // Read the file's contents
		    $filename = 'solar_data_'.date('d-m-y').'.csv';
		    force_download($filename, $file);
		}

	}


	private function firstDayOfMonth($uts=null) 
	{ 
    $today = is_null($uts) ? getDate() : getDate($uts); 
    $first_day = getdate(mktime(0,0,0,$today['mon'],1,$today['year'])); 
    return $first_day[0]; 
	}

	/*
		private function myprepdate($date)
	{
			$qday = date_parse($date);
			$d = array();
			$d['year'] = $qday['year'];
    		$d['month'] = $qday['month'];
    		$d['day'] = $qday['day'];
    		return $d;
	}
	public function solardata()
	{
		$tab = 'kwh';
		if ($tab == 'kwh')
		{
			// fix this later
			$siteid = 1;
			$this->load->model('m_metrics');
			$data['kwh'] = $this->m_metrics->get_day_kwh($siteid);
		}
		
		$data['page'] = 'v_solar-data';
		$data['include'] = 'js/solar-data.js';
		$this->load->view('includes/template', $data);
	}

	
	
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

