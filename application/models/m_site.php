<?php 
class M_Site extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function isDefaultSiteSet()
    {
    	$this->db->where('default_site', 1);
		$query = $this->db->get('site');
		if ($query->num_rows() == 1)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}
    	
    }
	
    function get_mate_url($siteid)
    {
    	
		$this->db->select('mate_url')->from('site')->where('site_id',$siteid);
		$sql = $this->db->get();
		return $sql->row('mate_url');
    }
	
	function isValid_site_id($site_id)
	{
		$this->db->where('public_id', $site_id)->where('status', '1');
		$query = $this->db->get('site');
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else {
			return FALSE;
		}

	}
	function get_siteId($pubSiteID)
	{
		$this->db->where('public_id', $pubSiteID);
		$query = $this->db->get('site');
		if ($query->num_rows() > 0)
		{
			return $query->row('site_id');
		}
		

	}
	function get_default_private_siteId()
	{
		$this->db->where('status', '1')->where('default_site', '1')->limit(1);
		$query = $this->db->get('site');
		if ($query->num_rows() > 0)
		{
			return $query->row('site_id');
		}
		

	}
	function get_default_public_siteId()
	{
		$this->db->where('status', '1')->where('default_site', '1')->limit(1);
		$query = $this->db->get('site');
		if ($query->num_rows() > 0)
		{
			return $query->row('public_id');
		}
		

	}

	function get_site_timezone($site_id)
	{
		$this->db->where('site_id', $site_id);
		$query = $this->db->get('site');
		if ($query->num_rows() > 0)
		{
			return $query->row('timezone');
		}
	}
	function get_short_site_timezone($site_id)
	{
		$this->db->where('site_id', $site_id);
		$query = $this->db->get('site');
		if ($query->num_rows() > 0)
		{
			return $query->row('timezone_short');
		}
	}
	function get_admin_email($site_id)
	{
		$this->db->where('site_id', $site_id);
		$query = $this->db->get('site');
		if ($query->num_rows() > 0)
		{
			return $query->row('site_admin_email');
		}
	}
	
	
	
	

}