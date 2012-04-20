<?php 
class M_Kwh extends CI_Model {

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

    function get_total_kwh_by_period($site_id, $date, $period) // for chart
    {
        switch($period)
        {

            //default to week
            case 'day':
            
            $sql = "select b.hour, IFNULL(round(avg(a.kw),3),0.00) as kWh from number b LEFT OUTER JOIN total_kw_by_timestamp a ON b.hour = HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) 
            and a.site_id=$site_id AND DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'))='" .  $date . "' GROUP BY b.hour";
            
            break;

            case 'day-previous':
            $sql = "select created_date as date, IFNULL(round(sum(accumulatedkwh), 1),0.00) as kwh 
                from dailykwhgeneration_by_port where site_id=$site_id and DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) = DATE_SUB('$date', INTERVAL 1 DAY) group by created_date 
                LIMIT 1";

            break;
            case 'week':
            /*
            $sql = "select DATE_FORMAT(created_date, '%Y-%m-%d') as date, round(sum(accumulatedkwh), 1) as kwh 
                from dailykwhgeneration where site_id=$site_id and created_date <= '$date' AND created_date >= DATE_SUB('$date', INTERVAL 7 DAY) group by created_date 
                ORDER BY created_date asc LIMIT 7";
                */
            $sql = "select DATE_FORMAT(b.fulldate, '%c/%e')as date, IFNULL(round(sum(a.accumulatedkwh), 1),0.00) as kwh 
                                    from dailykwhgeneration_by_port a RIGHT JOIN datedim b ON DATE(a.created_date) =b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= DATE_SUB('$date', INTERVAL 7 DAY) group by b.fulldate limit 7";
            break;

            case 'month':
            /*
            $qday = date_parse($date);
            $year = $qday['year'];
            $month = $qday['month'];
            $from = $year . "-" . $month . "-01"; 

            $sql = "select DATE_FORMAT(created_date, '%m-%d') as date, round(sum(accumulatedkwh), 1) as kwh 
                from dailykwhgeneration_by_port where site_id=$site_id and created_date >= '$from' AND created_date <= DATE_ADD('$from', INTERVAL 1 MONTH) group by created_date 
                ORDER BY created_date asc LIMIT 31";
            */
            $sql = "select DATE_FORMAT(b.fulldate, '%c/%e')as date, IFNULL(round(sum(a.accumulatedkwh), 1),0.00) as kwh 
                                    from dailykwhgeneration_by_port a RIGHT JOIN datedim b ON DATE(a.created_date) =b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= DATE_SUB('$date', INTERVAL 30 DAY) group by b.fulldate limit 30";
            break;

            case 'year':
            /*
            $qday = date_parse($date);
            $year = $qday['year'];
            $month = $qday['month'];
            $from = $year . "-01-01"; 
            $to = $year . "-12-31"; 
            $sql = "select DATE_FORMAT(created_date, '%m-%y') as month, round(sum(accumulatedkwh), 1) as kwh 
                from dailykwhgeneration_by_port where site_id=$site_id and created_date >= '$from' AND created_date <= '$to' group by month
                ORDER BY month asc LIMIT 12";
                */
            $sql = "select DATE_FORMAT(b.fulldate, '%c/%e')as date, IFNULL(round(sum(a.accumulatedkwh), 1),0.00) as kwh 
                                    from dailykwhgeneration_by_port a RIGHT JOIN datedim b ON DATE(a.created_date) =b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= DATE_SUB('$date', INTERVAL 365 DAY) and b.fulldate >= '2012-03-03' group by b.fulldate limit 365";

            break;

            case 'inception':
            /*
            $sql = "select DATE_FORMAT(created_date, '%m-%y') as month, round(sum(accumulatedkwh), 1) as kwh 
                from dailykwhgeneration_by_port where site_id=$site_id group by month
                ORDER BY month asc";
                */
            $sql = "select DATE_FORMAT(b.fulldate, '%c/%e')as date, IFNULL(round(sum(a.accumulatedkwh), 1),0.00) as kwh 
                                    from dailykwhgeneration_by_port a RIGHT JOIN datedim b ON DATE(a.created_date) =b.fulldate
                     and a.site_id=$site_id where b.fulldate <= '$date' AND b.fulldate >= '2012-03-03' group by b.fulldate";    
            break;


            //default to current day
            case 'default':
            $sql = "select b.hour, IFNULL(round(avg(a.kw)),0.00) as wH from number b LEFT OUTER JOIN total_kw_by_timestamp a ON b.hour = HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) 
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

    function get_kwh_detail($site_id, $date, $period) // for tableview 
    {
        switch($period)
        {

            //default to week
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
            /*
            $qday = date_parse($date);
            $year = $qday['year'];
            $month = $qday['month'];
            $from = $year . "-" . $month . "-01"; 
            $sql = "select DATE(created_date) as date, round(avg(batt_v), 1) as batt_v, round(max(out_ah), 1) as out_ah, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and 
                    created_date >= '$from' AND created_date <= DATE_ADD('$from', INTERVAL 1 MONTH) group by date order by created_date desc limit 31";
            */
            $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day, round(avg(batt_v), 1) as batt_v, round(max(out_ah), 1) as out_ah, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' AND 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= DATE_SUB('$date', INTERVAL 30 DAY) group by date order by day desc limit 30";
            break;

            case 'year':
            /*
            $qday = date_parse($date);
            $year = $qday['year'];
            $from = $year . "-01-01"; 
            $to = $year . "-12-31"; 

            $sql = "select MONTH(created_date) as month, MONTHNAME(created_date) as monthname,YEAR(created_date) as year, round(sum(accumulatedkwh), 1) as out_kwh 
                from dailykwhgeneration_by_port where site_id=$site_id and created_date >= '$from' AND created_date <= '$to' group by month, monthname, year
                ORDER BY month asc, year asc LIMIT 12";
            */
                $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day, round(avg(batt_v), 1) as batt_v, round(max(out_ah), 1) as out_ah, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' AND 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) >= DATE_SUB('$date', INTERVAL 365 DAY) group by date order by day desc limit 365";
            
            break;

            case 'inception':
            /*
            $sql = "select MONTH(created_date) as month, MONTHNAME(created_date) as monthname, YEAR(created_date) as year, round(sum(accumulatedkwh), 1) as out_kwh 
                from dailykwhgeneration_by_port where site_id=$site_id group by month, monthname, year
                ORDER BY month asc, year asc";
                */
            $sql = "select DATE_FORMAT(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'), '%c/%e/%y') as date, DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) as day, round(avg(batt_v), 1) as batt_v, round(max(out_ah), 1) as out_ah, 
                    round(max(out_kwh), 1) as out_kwh from consolidatedexport where site_id=$site_id and 
                    DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) <= '$date' group by date order by day desc";   
            break;
            case 'default':
            //day
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
    function get_avg_daily_kwh_generated($site_id)
    {
        $sql = "select round(avg(max_kwh),1) as avgkwh from (select max(out_kwh) as max_kwh from consolidatedexport where site_id=$site_id group by date(created_date)) as alias";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            return $query->row('avgkwh');
        }
        else
        {
            return 0;
        }
    }
    function get_kwh_by_hour($site_id, $date)
    {
        
        $sql = "select b.hour, IFNULL(round(avg(a.kw)),0) as wH from number b LEFT OUTER JOIN total_kw_by_timestamp a ON b.hour = HOUR(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ')) 
            and a.site_id=$site_id AND DATE(CONVERT_TZ(created_date, '$this->server_TZ', '$this->site_TZ'))='" .  $date . "' GROUP BY b.hour";
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
    function getCurrentDailykWh($site_id, $date)
    {
        $sql = "select kw from total_kw_by_timestamp where site_id=$site_id and DATE(created_date) = '$date' order by created_date desc limit 1";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            return $query->row('kw');
        }
        else
        {
            return 0;
        }
    }
    function getMaxDailykWh($site_id, $date)
    {
        $sql = "select kw from total_kw_by_timestamp where site_id=$site_id and DATE(created_date) ='$date' order by kw desc limit 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            return $query->row('kw');
        }
        else
        {
            return 0;
        }
    }
    function getTotalkWh($site_id, $date)
    {
        $sql = "select round(sum(accumulatedkwh), 1) as kwh from dailykwhgeneration_by_port where site_id=$site_id and created_date <=curdate() group by site_id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
            return $query->row('kwh');
        }
        else
        {
            return 0;
        }
    }
}