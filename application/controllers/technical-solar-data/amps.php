<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Amps extends MY_Controller {

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
		
		redirect('/technical-solar-data/amps/day');


	}
	public function day($date = null)
	{
		
		
		if (mycheckdate($date))
		{
			$day= $date;
			$api_url = "api/amps/day/date/" . $day . "/siteID/" . $this->sitePubID; 
			$today = "false";
		}
		else
		{
			// default to today()
			$day = date("Y-m-d"); 
			$api_url = "api/amps/day/date/" . $day . "/siteID/" . $this->sitePubID; 
			$today = "true";

			
		}

		$this->load->model('m_amps');
		
		$data['out_amps'] = $this->m_amps->get_amp_detail($this->site_id, $day, 'day');
		
		$data['period'] = 'day';
		$data['page'] = 'solardata/v_amps';
		$data['chartdatelabel'] = myDateInterval($day, 'day');
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillAmps(data, 'hour', $today);",
							"complete" => "buildBigChart('Amps', 'day', 2); addlinetochart('d2', 'Volts', 'Volts');");
		$data['widgets'] = array('alerts', 'peak-power', 'battery-history');
		$this->load->view('includes/template', $data);


		
	}
	
	public function week($date = null)
	{
		if (mycheckdate($date))
		{
			$day= $date;
			$api_url = "api/amps/week/date/" . $day . "/siteID/" . $this->sitePubID; 
		}
		else
		{
			// default to today()
			$day = date("Y-m-d"); 
			$api_url = "api/amps/week/date/" . $day . "/siteID/" . $this->sitePubID; 

			
		}

		$this->load->model('m_amps');
		
		$data['out_amps'] = $this->m_amps->get_amp_detail($this->site_id, $day, 'week');
		
		$data['period'] = 'week';
		$data['page'] = 'solardata/v_amps';
		$data['chartdatelabel'] = myDateInterval($day, 'week');
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillAmps(data, 'week');",
							"complete" => "buildBigChart('Amps', 'week', 2); addlinetochart('d2', 'Volts', 'Volts');");
		$data['widgets'] = array('alerts', 'peak-power', 'battery-history');
		$this->load->view('includes/template', $data);
		

	}
	
	public function month($date= null)
	{
		if (mycheckdate($date))
		{
			$day= $date;
			$api_url = "api/amps/month/date/" . $day . "/siteID/" . $this->sitePubID; 
		}
		else
		{
			// default to today()
			$day = date("Y-m-d"); 
			$api_url = "api/amps/month/date/" . $day . "/siteID/" . $this->sitePubID; 

			
		}

		$this->load->model('m_amps');
		
		$data['out_amps'] = $this->m_amps->get_amp_detail($this->site_id, $day, 'month');
		
		$data['period'] = 'month';
		$data['page'] = 'solardata/v_amps';
		$data['chartdatelabel'] = myDateInterval($day, 'month');
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillAmps(data, 'month');",
							"complete" => "buildBigChart('Amps', 'month', 2); addlinetochart('d2', 'Volts', 'Volts');");
		$data['widgets'] = array('alerts', 'peak-power', 'battery-history');
		$this->load->view('includes/template', $data);
		
	}
	public function year($date= null)
	{
		if (mycheckdate($date))
		{
			$day= $date;
			$api_url = "api/amps/year/date/" . $day . "/siteID/" . $this->sitePubID; 
		}
		else
		{
			// default to today()
			$day = date("Y-m-d"); 
			$api_url = "api/amps/year/date/" . $day . "/siteID/" . $this->sitePubID; 

			
		}

		$this->load->model('m_amps');
		
		$data['out_amps'] = $this->m_amps->get_amp_detail($this->site_id, $day, 'year');
		
		$data['period'] = 'year';
		$data['page'] = 'solardata/v_amps';
		$data['chartdatelabel'] = myDateInterval($day, 'year');
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillAmps(data, 'year');",
							"complete" => "buildBigChart('Amps', 'year', 2); addlinetochart('d2', 'Volts', 'Volts');");
		$data['widgets'] = array('alerts', 'peak-power', 'battery-history');
		$this->load->view('includes/template', $data);
		
	}
	public function since_inception()
	{
		
		
		$day = date("Y-m-d"); 
		$api_url = "api/amps/since_inception/siteID/" . $this->sitePubID; 


		$this->load->model('m_amps');
		
		$data['out_amps'] = $this->m_amps->get_amp_detail($this->site_id, $day, 'inception');
		
		$data['period'] = 'inception';
		$data['page'] = 'solardata/v_amps';
		$data['chartdatelabel'] = myDateInterval($day, 'inception');
		$data['api']= array("url" => $api_url, 
							"success" => "grabAndFillAmps(data, 'inception');",
							"complete" => "buildBigChart('Amps', 'inception', 2); addlinetochart('d2', 'Volts', 'Volts');");
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

	



}

