<?php 
class M_Battery extends CI_Model {

	private $server_TZ;
	private $site_TZ;
    private $golivedate;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        // get the timezone of the server.
        $this->server_TZ = $this->config->item('server_TZ');

        // get the default site's timezone from our helper library  
        $this->site_TZ = getDefaultSiteTZ();
        $this->golivedate = $this->config->item('system_golivedate');

    }

    function get_avg_battery_by_period($site_id, $date, $period)  // used in creating the charts
    {
        switch($period)
        {

            case 'day':

             $sql = "select b.hour, IFNULL(round(avg(a.sys_batt_v), 1),0.00) as batt_v 
                                    from number b LEFT OUTER JOIN export a
                                    ON b.hour =  HOUR(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ')) and a.site_id=$site_id 
                                    and DATE(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ')) = '$date' group by b.hour";
            break;
            case 'day-previous':
            $sql = "";
            break;

            case 'week':
           
            $sql = "select DATE_FORMAT(b.fulldate, '%c/%e') as date, IFNULL(round(avg(a.sys_batt_v), 1),0) as batt_v 
                                    from export a RIGHT JOIN datedim b ON DATE(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ')) = b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= DATE_SUB('$date', INTERVAL 7 DAY) group by b.fulldate limit 7";
            break;

            case 'month':
            

            $sql = "select DATE_FORMAT(b.fulldate, '%c/%e') as date, IFNULL(round(avg(a.sys_batt_v), 1),0) as batt_v 
                                    from export a RIGHT JOIN datedim b ON DATE(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ')) = b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= DATE_SUB('$date', INTERVAL 30 DAY) group by b.fulldate limit 30";
                
            break;

            case 'year':
         
            $sql = "select DATE_FORMAT(b.fulldate, '%c/%e') as date, IFNULL(round(avg(a.sys_batt_v), 1),0) as batt_v 
                                    from export a RIGHT JOIN datedim b ON DATE(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ')) = b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= DATE_SUB('$date', INTERVAL 365 DAY) and
                     b.fulldate >= '$this->golivedate' group by b.fulldate limit 365";
            break;

            case 'inception':

             $sql = "select DATE_FORMAT(b.fulldate, '%c/%e') as date, IFNULL(round(avg(a.sys_batt_v), 1),0) as batt_v 
                                    from export a RIGHT JOIN datedim b ON DATE(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ')) = b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= '$this->golivedate' group by b.fulldate";
              
            break;

            //default to day
            case 'default':
            $sql = "select b.hour, IFNULL(round(avg(a.sys_batt_v), 1),0.00) as batt_v 
                                    from number b LEFT OUTER JOIN export a
                                    ON b.hour =  HOUR(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ')) and a.site_id=$site_id 
                                    and DATE(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ')) = '$date' group by b.hour";
            break;
        }
        
        
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
    function get_battery_detail($site_id, $date, $period)  // used for the period detail
    {
        switch($period)
        {

            
            case 'day':
            $sql = "select DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as date, HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as hour,  round(avg(batt_v), 1) as batt_v, round(avg(out_current), 1) as out_current, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = '" . $date . "' 
                    and HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) BETWEEN 6 AND 20 group by HOUR(created_date)";
            break;

            case 'week':
            $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day, round(avg(batt_v), 1) as batt_v, round(max(out_ah), 1) as out_ah, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' AND 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= DATE_SUB('$date', INTERVAL 7 DAY) group by date order by day desc limit 7";
            break;

            case 'month':
            
            $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day, round(avg(batt_v), 1) as batt_v, round(max(out_ah), 1) as out_ah, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' AND 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= DATE_SUB('$date', INTERVAL 30 DAY) group by date order by day desc limit 30";
            break;

            case 'year':
           
                $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day, round(avg(batt_v), 1) as batt_v, round(max(out_ah), 1) as out_ah, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' AND 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= DATE_SUB('$date', INTERVAL 365 DAY) group by date order by day desc limit 365";
            
            break;

            case 'inception':
            
            $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day, round(avg(batt_v), 1) as batt_v, round(max(out_ah), 1) as out_ah, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' group by date order by day desc";   
            break;

            case 'default':
            
            $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day, HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as hour,  round(avg(batt_v), 1) as batt_v, round(avg(out_current), 1) as out_current, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = '" . $date . "' 
                    and HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) BETWEEN 6 AND 20 group by HOUR(created_date)";
            break;

        }   
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



}