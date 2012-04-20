<?php 
class M_Alerts extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	
    
    function get_alerts($siteid)
    {
    	
		$this->db->select('detail, created_date, level')->from('alerts')->where('site_id',$siteid)->where('status', 1)->order_by('created_date', 'desc')->limit(3);
          
		$query = $this->db->get();
		

        if ($query->num_rows() > 0)
        {   
            
            $results = $query->result_array();
            
            return $results;
        }   
        else
        {
            return FALSE;
        }
    }
    function get_all_alerts($siteid)
    {
        
        $this->db->select('detail, created_date, level')->from('alerts')->where('site_id',$siteid)->where('status', 1)->order_by('created_date', 'desc');
          
        $query = $this->db->get();
        

        if ($query->num_rows() > 0)
        {   
            
            $results = $query->result_array();
            
            return $results;
        }   
        else
        {
            return FALSE;
        }
    }
 
    function add_alert($site_id, $level, $detail)
    {
            $new_alert_data = array(
            
            'site_id' => $site_id,
            'level' => $level,
            'detail' => $detail, 
            'status' => 1,
            'created_date' => date('Y-m-d H:i:s'),
        );


        $result = $this->db->insert('alerts', $new_alert_data);
        if ($result)
        { 
            return TRUE;    
        }
        else 
        { return FALSE; }  
    }
}