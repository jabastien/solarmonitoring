<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH. 'libraries/REST_Controller.php');  
class Pv extends REST_Controller {

	// public site ID that query is for
	public $sitePubId;
	private $site_id;

	// specific date that is queried or calculated as start date
	private $day;
	

	function __construct()
    {
       parent::__construct();

       // make sure a siteID was submitted

       if ($this->get('siteID'))
		{
			$this->sitePubId = $this->get('siteID');

			// ensure pub ID is a real one  
			$this->load->model('m_site');
			if ($this->m_site->isValid_site_id($this->sitePubId))
			{
				$this->site_id = $this->m_site->get_siteId($this->sitePubId);
				if ($this->get('date'))
				{
					if (mycheckdate($this->get('date')))
					{
						$this->day = $this->get('date');
					}
					else
					{
						$this->day = date("Y-m-d");
					}
					
				}
				else
				{
					$this->day = date("Y-m-d");
				}
				
				// last thing to do.. load model.. 
				$this->load->model('m_pv');
			}
			else
			{
				$this->response(array('status' => false, 'error_message' => 'no Such Site registered here'), 404);
			}
				
		
		}
		else
		{
			$this->response(array('status' => false, 'error_message' => 'no site submitted'), 404);
		}
       
               
    }
	
	public function index_get()
	{
		
		redirect('/api/pv/day');
		
	
	}
	
	public function day_get()
	{
		$pv = $this->m_pv->get_avg_pv_by_period($this->site_id, $this->day, 'day');
		if (!$pv == FALSE)
		{

			$this->response($pv);
		}
		else
		{
			$this->response(array('status' => false, 'error_message' => 'no Results found'), 404);
		}
		

	}
	public function week_get()
	{
		$pv = $this->m_pv->get_avg_pv_by_period($this->site_id, $this->day, 'week');
		if (!$pv == FALSE)
		{
			$this->response($pv);
		}
		else
		{
			$this->response(array('status' => false, 'error_message' => 'no Results found'), 404);
		}
		

	}
	public function month_get()
	{
		$pv = $this->m_pv->get_avg_pv_by_period($this->site_id, $this->day, 'month');
		if (!$pv == FALSE)
		{
			$this->response($pv);
		}
		else
		{
			$this->response(array('status' => false, 'error_message' => 'no Results found'), 404);
		}

	}
	public function year_get()
	{
		$pv = $this->m_pv->get_avg_pv_by_period($this->site_id, $this->day, 'year');
		if (!$pv == FALSE)
		{
			$this->response($pv);
		}
		else
		{
			$this->response(array('status' => false, 'error_message' => 'no Results found'), 404);
		}

	}
	public function since_inception_get()
	{
		$pv = $this->m_pv->get_avg_pv_by_period($this->site_id, $this->day, 'inception');
		if (!$pv == FALSE)
		{
			$this->response($pv);
		}
		else
		{
			$this->response(array('status' => false, 'error_message' => 'no Results found'), 404);
		}

	}
	

}
