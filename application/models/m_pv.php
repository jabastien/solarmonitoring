<?php 
class M_Pv extends CI_Model {

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
        $this->golivedate = $this->config->item('system_golivedate');

    }
    function get_avg_pv_by_period($site_id, $date, $period)  // used for charts
    {
        switch($period)
        {

            case 'day':
             
            $sql = "select b.hour, IFNULL(round(avg(a.in_current), 1),0.00) as in_current, IFNULL(round(avg(a.in_voltage), 1),0.00) as in_voltage from 
            number b LEFT OUTER JOIN consolidatedexport a ON b.hour = HOUR(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ'))
            and a.site_id=$site_id AND DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'))='" .  $date . "' GROUP BY b.hour";
            break;

            case 'week':
           
            $sql = "select DATE_FORMAT(b.fulldate, '%c/%e') as date, IFNULL(round(avg(a.in_current), 1),0) as in_current, IFNULL(round(avg(a.in_voltage), 1),0.00) as in_voltage
                                    from consolidatedexport a RIGHT JOIN datedim b ON DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= DATE_SUB('$date', INTERVAL 7 DAY) group by b.fulldate limit 7";
            break;

            case 'month':
            $sql = "select DATE_FORMAT(b.fulldate, '%c/%e') as date, IFNULL(round(avg(a.in_current), 1),0) as in_current, IFNULL(round(avg(a.in_voltage), 1),0.00) as in_voltage
                                    from consolidatedexport a RIGHT JOIN datedim b ON DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= DATE_SUB('$date', INTERVAL 30 DAY) group by b.fulldate limit 30";
                
            break;

            case 'year':

             $sql = "select DATE_FORMAT(b.fulldate, '%c/%e') as date, IFNULL(round(avg(a.in_current), 1),0) as in_current, IFNULL(round(avg(a.in_voltage), 1),0.00) as in_voltage
                                    from consolidatedexport a RIGHT JOIN datedim b ON DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= DATE_SUB('$date', INTERVAL 365 DAY) and
                    b.fulldate >= '$this->golivedate' group by b.fulldate limit 365";
                
            break;

            case 'inception':

             $sql = "select DATE_FORMAT(b.fulldate, '%c/%e') as date, IFNULL(round(avg(a.in_current), 1),0) as in_current, IFNULL(round(avg(a.in_voltage), 1),0.00) as in_voltage
                                    from consolidatedexport a RIGHT JOIN datedim b ON DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= '$this->golivedate' group by b.fulldate";
                
            break;

            //default to day
            case 'default':
            $sql = "select b.hour, IFNULL(round(avg(a.in_current), 1),0.00) as in_current, IFNULL(round(avg(a.in_voltage), 1),0.00) as in_voltage from 
            number b LEFT OUTER JOIN consolidatedexport a ON b.hour = HOUR(CONVERT_TZ(a.created_date, '$this->server_TZ', '$this->site_TZ'))
            and a.site_id=$site_id AND DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'))='" .  $date . "' GROUP BY b.hour";
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
    function get_pv_detail($site_id, $date, $period)  // used for the period detail
    {
        switch($period)
        {

            //default to week
            case 'day':
            $sql = "select DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as date, HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as hour,
                  round(avg(in_current), 1) as in_current, round(avg(in_voltage), 1) as in_voltage 
                  from consolidatedexport where site_id=$site_id and DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = '" . $date . "' 
                    and HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) BETWEEN 6 AND 20 group by HOUR(created_date)";
            break;

            case 'week':
             $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day,
                    round(avg(in_current), 1) as in_current, round(avg(in_voltage), 1) as in_voltage
                    from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' AND 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= DATE_SUB('$date', INTERVAL 7 DAY) group by date order by day desc limit 7";
                    
            break;
            
            case 'month':
             $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day,
                    round(avg(in_current), 1) as in_current, round(avg(in_voltage), 1) as in_voltage
                    from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' AND 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= DATE_SUB('$date', INTERVAL 30 DAY) group by date order by day desc limit 30";

            break;

            case 'year':
             $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day,
                    round(avg(in_current), 1) as in_current, round(avg(in_voltage), 1) as in_voltage
                    from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' AND 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= DATE_SUB('$date', INTERVAL 365 DAY) and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= '$this->golivedate' group by date order by day desc limit 365";
            break;

            case 'inception':
           $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day,
                    round(avg(in_current), 1) as in_current, round(avg(in_voltage), 1) as in_voltage
                    from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' AND 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= '$this->golivedate' group by date order by day desc limit 365";
            break;
            
            case 'default':
             $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as hour,
                  round(avg(in_current), 1) as in_current, round(avg(in_voltage), 1) as in_voltage 
                  from consolidatedexport where site_id=$site_id and DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = '" . $date . "' 
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