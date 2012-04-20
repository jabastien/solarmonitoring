<?php 
class M_Metrics extends CI_Model {

	private $server_TZ;
	private $site_TZ;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        // get the timezone of the server.
        $this->server_TZ = $this->config->item('server_TZ');

        // get the default site's timezone from our helper library  
        $this->site_TZ = getDefaultSiteTZ();

    }
    
    function get_capturedata_byhour($site_id, $date, $hour)
    {

          
        $sql = "select CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ') as created_date, capture_id, port, out_i, in_i, batt_v, in_v, out_kwh, out_ah 
        from export_data where site_id=$site_id and DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = '$date' and HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = $hour order by created_date desc";
        $query = $this->db->query($sql);
        

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


	/* widget functions */


	function getBatteryVoltage($site_id, $date)
	{
		$sql = "select batt_v from battery_voltage_by_timestamp where site_id=$site_id and DATE(created_date) = '$date' order by created_date desc limit 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			return $query->row('batt_v');
		}
		else
		{
			return 0;
		}
	}
	function getTotalAhByDay($site_id, $date)
	{
		$sql = "select sum(accumulatedah) as amphours from dailyahgeneration_by_port where site_id=$site_id and DATE(created_date)='" .  $date . "' GROUP BY created_date, site_id limit 1";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			return $query->row('amphours');
		}
		else
		{
			return 0;
		}
	}
	function getTotalAhPastWeek($site_id, $date)
	{
		$sql = "select sum(accumulatedah) as amphours from dailyahgeneration_by_port where site_id=$site_id and created_date <= '$date' AND created_date >= DATE_SUB('$date', INTERVAL 7 DAY) GROUP BY site_id";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			return $query->row('amphours');
		}
		else
		{
			return 0;
		}
	}
	function getTotalAhPastMonth($site_id, $date)
	{
		
		$sql = "select sum(accumulatedah) as amphours from dailyahgeneration_by_port where site_id=$site_id and created_date <= '$date' AND created_date >= DATE_SUB('$date', INTERVAL 30 DAY) GROUP BY site_id";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			return $query->row('amphours');
		}
		else
		{
			return 0;
		}
	}
	function getTotalAhPastYear($site_id, $date)
	{
		$sql = "select sum(accumulatedah) as amphours from dailyahgeneration_by_port where site_id=$site_id and created_date <= '$date' AND created_date >= DATE_SUB('$date', INTERVAL 365 DAY) GROUP BY site_id";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			return $query->row('amphours');
		}
		else
		{
			return 0;
		}
	}


	function getLastPollDate($site_id)
	{
		$sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%Y-%m-%d %l:%i %p') as 'localtime' from total_kw_by_timestamp where site_id=$site_id order by created_date desc limit 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			return $query->row('localtime');
		}
		else
		{
			return 0;
		}
	}

	/* end widget functions */
	
	

}