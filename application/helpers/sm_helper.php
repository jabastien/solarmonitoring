<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('mycheckdate'))
{
    function mycheckdate($date)
	{
		if (!is_null($date))
		{
			$qday = date_parse($date);
			$year = $qday['year'];
			$month = $qday['month'];
			$day = $qday['day'];
			if (checkdate($month, $day, $year))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}

	} 
	function prettyDate($date)
	{
		$qday = date_parse($date);
		$month = $qday['month'];
		$day = $qday['day'];
		$pdate = $month . '/' . $day;
		return $pdate;

	}
	function prettyDateWithYear($date)
	{
		$qday = date_parse($date);
		$month = $qday['month'];
		$day = $qday['day'];
		$y = $qday['year'];
		$pdate = $month . '/' . $day . '/' . $y;
		return $pdate;

	}
	function myDateInterval($date, $int)
	{
		switch($int)
		{
			case 'day':
			return prettyDateWithYear($date);
			break;

			case 'week':
			$d = strtotime($date);
			$startdate = strtotime("-7 day", $d);
			$startdate = date('Y-m-d', $startdate);
			$enddate = strtotime("-1 day", $d);
			$enddate = date('Y-m-d', $enddate);
			$out = prettyDateWithYear($startdate) . " - " . prettyDateWithYear($enddate);
			return $out;
			break;

			case 'month':
			$d = strtotime($date);
			$startdate = strtotime("-30 day", $d);
			$startdate = date('Y-m-d', $startdate);
			$enddate = strtotime("-1 day", $d);
			$enddate = date('Y-m-d', $enddate);
			$out = prettyDateWithYear($startdate) . " - " . prettyDateWithYear($enddate);
			return $out;
			break;

			case 'year':
			$CI =& get_instance();
			$golivedate= $CI->config->item('system_golivedate');
			$d = strtotime($date);
			$yearago = strtotime("-365 day", $d);

			if(strtotime($golivedate) > $yearago) 
			{
				$startdate = $golivedate;
			}
			else
			{
				$startdate = date('Y-m-d', $yearago);
			}
			
			$enddate = strtotime("-1 day", $d);
			$enddate = date('Y-m-d', $enddate);
			$out = prettyDateWithYear($startdate) . " - " . prettyDateWithYear($enddate);
			return $out;
			break;

			case 'inception':
			$CI =& get_instance();
			$startdate= $CI->config->item('system_golivedate');
			$d = strtotime($date);
			$enddate = strtotime("-1 day", $d);
			$enddate = date('Y-m-d', $enddate);
			
			$out = prettyDateWithYear($startdate) . " - " . prettyDateWithYear($enddate);
			return $out;
			break;

			default:
			$out = "No interval defined";
			return $out;
			break;

		}
		
				
	}
	function mygetyear($date)
	{
		$qday = date_parse($date);
		$year = $qday['year'];
		return $year;
	}
	function mygetmonth($date)
	{
		$qday = date_parse($date);
		$month = $qday['month'];
		return $month;
	}
	function rangeIntervalFrom24($h) 
	{
		
		if($h > 12) {
		$h = $h - 12;
		$e = $h+1;
		$h = $h . ':00 - ' . $e . ':00 PM';
		}
		else
		{
			if ($h < 12)
			{
				$e = $h+1;
				$h = $h . ':00 - ' . $e  . ':00 AM';
			}
			if ($h == 11)
			{
				$h = '11:00 AM - noon';
			}
			if ($h == 12)
			{
				$h = 'noon - 1:00 PM';
			}

			
		}
		return $h;
	} 
	function activepage($currentpage)
	{
		$CI =& get_instance();
		$page = $CI->uri->segment(2, 0);
		if ($currentpage == $page)
			{ return true;}
	}
	function classactive($in, $on)
	{
		if ($in == $on)
			{return true;
			}
	}
	function firstDayOfMonth($uts=null) 
	{ 
    $today = is_null($uts) ? getDate() : getDate($uts); 
    $first_day = getdate(mktime(0,0,0,$today['mon'],1,$today['year'])); 
    return $first_day[0]; 
	}

	function getDefaultSiteTZ()
	{
		$CI =& get_instance();
		$CI->load->model('m_site');
		$site = $CI->m_site->get_default_private_siteId();
		$tz = $CI->m_site->get_site_timezone($site);
		return $tz;
	}
	function force_download($filename = '', $data = '')
    {

        if ($filename == '' OR $data == '')
        {
            return FALSE;
        }

        // Try to determine if the filename includes a file extension.
        // We need it in order to set the MIME type
        if (FALSE === strpos($filename, '.'))
        {
            return FALSE;
        }

        // Grab the file extension
        $x = explode('.', $filename);
        $extension = end($x);

        // Load the mime types
        @include(APPPATH.'config/mimes'.EXT);

        // Set a default mime if we can't find it
        if ( ! isset($mimes[$extension]))
        {
            $mime = 'application/octet-stream';
        }
        else
        {
            $mime = (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
        }

        // Generate the server headers
        if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
        {
            header('Content-Type: "'.$mime.'"');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header("Content-Transfer-Encoding: binary");
            header('Pragma: public');
            header("Content-Length: ".strlen($data));
        }
        else
        {
            header('Content-Type: "'.$mime.'"');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header("Content-Transfer-Encoding: binary");
            header('Expires: 0');
            header('Pragma: no-cache');
            header("Content-Length: ".strlen($data));
        }

        exit($data);
    }
}

