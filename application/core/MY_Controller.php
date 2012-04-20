<?php defined('BASEPATH') OR exit('No direct script access allowed');



class MY_Controller extends CI_Controller {

	public $stat_data = array();
	public $site_id;
	
	private $lastpolldate;
	// Constructor function
	public function __construct()
	{
		parent::__construct();
		
		/* #TODO create a function to run through all of the checklists of things to do
		before allowing site to load */
		// check for default site
		// check for site TZ
		// check for sys golive date

		$this->load->model('m_site');
		if (!$this->m_site->isDefaultSiteSet())
		{
			// ensure a default site is setup and that there is only one!
			$this->load->view('v_sitesetup');
		}
		else
		{
			// get default site ID
			$this->site_id = $this->m_site->get_default_private_siteId();
			// get long and short site TZ
			$short_tz = $this->m_site->get_short_site_timezone($this->site_id);
			$long_tz = $this->m_site->get_site_timezone($this->site_id);

			$server_TZ = $this->config->item('server_TZ');
			date_default_timezone_set($server_TZ);
			$this->load->model('m_kwh');
			$this->load->model('m_metrics');

			// get last time we talked to mate3
			$lastpolldatetime = $this->lastPollDate($this->site_id);
			// set this as the global lastpolldate vars
			$this->setLastPollDateTime($lastpolldatetime);
			// strip the date from lastpolldate vars to set for other variables.
			$this->lastpolldate = date("Y-m-d" , strtotime($lastpolldatetime));
			
			
			$this->setDefaultSiteTZ($short_tz, $long_tz);
			$this->batteryCurrentSOC($this->site_id, $this->lastpolldate);
			$this->laptopsCharged($this->site_id, $this->lastpolldate);
			$this->averageLaptopsCharged($this->site_id);
			$this->eg_kWCurrent($this->site_id, $this->lastpolldate);
			$this->eg_kWDailyHigh($this->site_id, $this->lastpolldate);
			$this->eg_kWhCumalative($this->site_id, $this->lastpolldate);
			
			$this->ah_Daily($this->site_id, $this->lastpolldate);
			$this->ah_PastWeek($this->site_id, $this->lastpolldate);
			$this->ah_PastMonth($this->site_id, $this->lastpolldate);
			$this->ah_PastYear($this->site_id, $this->lastpolldate);

			$this->rm_slider($this->site_id, $this->stat_data['cumulative_kwh']);
			$this->get_alerts($this->site_id);

			
			// load up stats into global vars array
			$this->load->vars($this->stat_data);
		}
		
	}

	// set a few default variables for the application 
	public function setDefaultSiteId($site_id)
	{
		$this->stat_data['default_site_id'] = $site_id;
	}
	public function setDefaultSiteTZ($short, $long)
	{
		$this->stat_data['site_short_TZ'] = $short;
		$this->stat_data['site_TZ'] = $long;
	}

	// setup the widget variables that are used throughout the site

	public function lastPollDate($site_id)
	{
		$pdate = $this->m_metrics->getLastPollDate($site_id);
		return $pdate;
	}
	public function setLastPollDateTime($lastpolldatetime)
	{
		$this->stat_data['last_poll_date'] = $lastpolldatetime;
	}
	public function laptopsCharged($site_id, $date)
	{
		$yesterday_kwh = $this->m_kwh->get_total_kwh_by_period($site_id, $date, "day-previous");

		$this->stat_data['laptops_charged'] = round(($yesterday_kwh[0]['kwh'] * 1000)/25.5);
	}
	public function averageLaptopsCharged($site_id)
	{
		$avgdailykwh = $this->m_kwh->get_avg_daily_kwh_generated($site_id);
		$this->stat_data['avg_laptops_charged']  = round(($avgdailykwh * 1000)/25.5);
		
	}
	// eg = Energy Generated Widget
	public function eg_kWCurrent($site_id, $date)   //PIT = Point in Time
	{
		$current = $this->m_kwh->getCurrentDailykWh($site_id, $date);
		$this->stat_data['current_daily_kwh'] = round($current*1000, 2) . "W";
		
		
	}
	public function eg_kWDailyHigh($site_id, $date)
	{
		$current = $this->m_kwh->getMaxDailykWh($site_id, $date);
		$this->stat_data['max_daily_kwh']  = round($current*1000, 2) . "W";
		
		
	}
	public function eg_kWhCumalative($site_id, $date)
	{
		$this->stat_data['cumulative_kwh'] = $this->m_kwh->getTotalkWh($site_id, $date);
	}
	public function alertsGet($site_id)
	{
		
	}

	public function batteryCurrentSOC($site_id, $date)
	{
		$result = $this->m_metrics->getBatteryVoltage($site_id, $date);

		if ($result > 0)
		{
			if($result < 12.95)
			{
				$math = (($result - 11.4)/1.5) * 100;
				$this->stat_data['batt_current_soc'] = round($math, 1);
			}
			else
			{
				$this->stat_data['batt_current_soc'] = '100';
			}
			
		}
		else
		{
			$this->stat_data['batt_current_soc'] = 0;
		}
		
		

		
	}
	public function batteryMaxSOC($site_id, $date)
	{

		$result = $this->m_metrics->getBatteryVoltage($site_id, $date);
		$math = (($result - 11.4)/1.5) * 100;
		
		$this->stat_data['batt_max_soc'] = round($math, 1);
		
	}
	public function ah_Daily($site_id, $date)
	{
		$this->stat_data['current_daily_ah'] = $this->m_metrics->getTotalAhByDay($site_id, $date);
	}
	public function ah_PastWeek($site_id, $date)
	{
		$this->stat_data['past_week_ah'] = $this->m_metrics->getTotalAhPastWeek($site_id, $date);
	}
	public function ah_PastMonth($site_id, $date)
	{
		$this->stat_data['past_month_ah'] = $this->m_metrics->getTotalAhPastMonth($site_id, $date);
	}
	public function ah_PastYear($site_id, $date)
	{
		$this->stat_data['past_year_ah'] = $this->m_metrics->getTotalAhPastYear($site_id, $date);
	}
	public function rm_slider($site_id, $kwh)
	{
		/*
		1kwh = 3412 BTU
		1 Liter = 34,003 BTU
		9.96kwh/liter
		engine/generator efficiency is 30% so
		9.96 * .3 = 3kwh/liter of diesel
		*/
		// lightbulb
		/*
		15watts for 8 hours = 120wH/day
		120 * 365 = 43.8kWH
		xkWh / 43.8 = # 15 watt CFL light bulbs which could be used 8hours day for a year
		*/
		$lightbulb = $kwh / 43.8;
		/*
		liters of diesel saved
		xkWh / 3 = # liters of diesel saved to create equivalent energy
		*/
		$diesel = $kwh / 3;
		//
		$currency = $diesel * 3.77;
		// auto emissions per litre of diesel
		// source http://www.environment.gov.au/settlements/transport/fuelguide/environment.html
		$car = 2.7 * $kwh;
		$this->stat_data['rm_lightbulb'] = round($lightbulb);
		$this->stat_data['rm_car'] = round($car);
		$this->stat_data['rm_diesel'] = round($diesel);
		$this->stat_data['rm_currency'] = round($currency);

	}
	public function get_alerts($site_id)
	{
		$this->load->model('m_alerts');
		if ($this->m_alerts->get_alerts($site_id))
		{
			$this->stat_data['alerts'] = $this->m_alerts->get_alerts($site_id);
		}
		else
		{
			$this->stat_data['alerts'] = 0;
		}
	}

	
	


}