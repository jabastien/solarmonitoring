<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datalogger extends MY_Controller {

	public $site_id;

	public function index()
	{
		
			
	}


	public function collector($sitePubId)
	{
		// site id you want to capture is passed in as param
		$this->load->model('m_site');
		// ensure pub ID is a real one  
		if ($this->m_site->isValid_site_id($sitePubId))
		{
			$this->site_id = $this->m_site->get_siteId($sitePubId);

			
			$url = $this->m_site->get_mate_url($this->site_id);
			if ($this->isValidURL($url))
			{
				
				$obj = $this->query_the_mate3($url);
				if ($obj === FALSE)
				{
					$this->load->model('m_alerts');
					$this->m_alerts->add_alert($this->site_id, 'high', 'could not communicate to mate3');
				}
				else
				{
					$rootObj = json_decode($obj);
					$this->load->model('m_export');
					// write to the export table
					$this->m_export->dump_export($this->site_id, $rootObj, $obj);
				}
				
				
				
			}
			else{
				log_message('error', "mate3 URL invalid");
			}
		
			

		}
		else{
			log_message('error', "invalid site id. Redirect");
		}
		
		

	}
	private function query_the_mate3($url)
	{
		
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$json_data = curl_exec($ch);
		
		if ($json_data === false)
		{
			
			log_message('error', "curl error: " . curl_error($ch));
			return FALSE;
		}
		else
		{
			
			// cleanup a few unneeded pieces.
			$json_data = substr($json_data, 0, -1); 
			// remove this string '{"devstatus": '
			$json_data = substr($json_data, 13); 
			
			return $json_data;
		}

		curl_close($ch);
		
		
		
		
	
	}

	private function dump_export_data($tstamp, $obj)
	{
		// mysql needs this extra prep.
		$json_data = json_encode(json_decode($obj, true));
		$this->load->model('m_raw');
			
			if ($this->m_raw->add_one($tstamp, $json_data))
			{
				return true;

			}
			else
			{
				return false;
			}
	}

	private function isValidURL($url)
	{
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}





	
}
