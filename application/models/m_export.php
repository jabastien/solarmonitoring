<?php 
class M_Export extends CI_Model {

	public $site_id = "";
	private $mate_timestamp = "";
	private $bvolts = "";
	private $insert_timestamp;

    function __construct()
    {
       parent::__construct();
        
        
    }
    
	
    function dump_export($siteid, $rootObj, $rawobj)
    {
    	$this->site_id= $siteid;
    	$this->bvolts = $rootObj->Sys_Batt_V;
    	// check battery level and email admin if too low.
    	$this->verifyBattLevel($this->bvolts, $this->site_id);

    	$this->mate_timestamp = $rootObj->Sys_Time;
    	$this->insert_timestamp = date('Y-m-d H:i:s');
    	
    	// uncomment below line to write JSON object to file -- set folder permissions!	
    	// $this->write_json_to_file($this->insert_timestamp, $rawobj);

    	if ($this->write_export())
    	{
    		$ports = $this->check_site_ports($this->site_id);
    		foreach ($ports as $k => $v)
    		{
    			$portnum = $v-1;
    			$json_port_data = $rootObj->ports[$portnum];
				if (!$this->write_export_data($json_port_data))
				{
					log_message('error', 'in loop write_export failed');
				}
    	
    		}
    		
    	}
    	
    	

    }
	
	private function check_site_ports($site_id)
	{
		// how many ports to poll
		
		$this->db->select('system_port');
		$this->db->where('site_id', $site_id);
		$query = $this->db->get('device')->result_array();
		$p = array();
		foreach ($query as $row)
		{
			$p[] = $row['system_port'];
		}
		return($p);
		
	}
	private function write_export()
    {
    	
		$new_export= array(
			'site_id' => $this->site_id,
			'mate_sys_time' => $this->mate_timestamp,
			'sys_batt_v' => $this->bvolts,
			'created_date' => $this->insert_timestamp
					
		);

		$this->db->insert('export', $new_export);
		
		if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		else{
			return FALSE;
			log_message('error', 'write_export failed');
		}
		
		
    }
	private function write_export_data($json)
    {
    	
		$new_export_data = array(
			'mate_sys_time' => $this->mate_timestamp,
			'site_id' => $this->site_id,
			'port' => $json->Port,
			'out_i' => $json->Out_I,
			'in_i' => $json->In_I,
			'batt_v' => $json->Batt_V,
			'in_v' => $json->In_V,
			'out_kwh' => $json->Out_kWh,
			'out_ah' => $json->Out_AH,
			'cc_mode' => $json->CC_mode,
			'error' => implode(",",$json->Error),
			'created_date' => $this->insert_timestamp
			
		);

		$this->db->insert('export_data', $new_export_data);
		
		if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		else{
			return FALSE;
			log_message('error', 'write_export_data failed');
		}
		
		
    }
    private function write_json_to_file($timestamp, $jsonObj)
	{
		
			// may want to allow this logging to be on/off.  Each file is about 1kb.
			$this->load->helper('file');
			
			if ( ! write_file('./application/logs/raw_json_files/' . $timestamp . '.txt', $jsonObj))
			{
			     log_message('error', "Cannot write txt  file, check permissions");
			     return false;
			}
			else
			{
			     return true;
			}

		
		
	}
	private function verifyBattLevel($bvoltage, $site_id)
	{
		if ($bvoltage < 11.6)
		{
			// currently, all i can do is log it
			log_message('error', "battery low, email is NOT setup in m_export");
			
			/*
			//get site admin email address
			$ci =& get_instance();
			$ci->load->model('m_site');
			$a_email = $ci->m_site->get_admin_email($site_id); 
					
			// prep email
			$this->load->library('email');
			$this->email->initialize(array(
			'protocol' => 'smtp',
			'smtp_host' => '',
			'smtp_user' => '',
			'smtp_pass' => '',
			'smtp_port' => 587,
			'crlf' => "\r\n",
			'newline' => "\r\n"
			));
			$this->email->from('someone@somplace.com', 'Site Admin');
			$this->email->to($a_email);
			$this->email->subject('Message from Solar Monitoring');
			$this->email->message('This alert serves to notify you that the Battery voltage is too low, measured at : ' . $bvoltage . ' Volts.   FYI');
						
			if (!$this->email->send())
			{
				
				log_message('error', "email could not send");
			}
			*/
			
		}
	}
	
	

}