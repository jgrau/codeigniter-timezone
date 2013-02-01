<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Timezone library
 *
 * @package default
 * @author Jonas Grau
 */
class Timezone
{
	var $gmt_timezone = 'Europe/London';
	var $timezones = array(
							'-12' 	=> 'UM12',
							'-11' 	=> 'UM11',
							'-10'	=> 'UM10',
							'-9'	=> 'UM9',
							'-8'	=> 'UM8',
							'-7'	=> 'UM7',
							'-6'	=> 'UM6',
							'-5'	=> 'UM5',
							'-4'	=> 'UM4',
							'-3.5' 	=> 'UM25',
							'-3' 	=> 'UM3',
							'-2' 	=> 'UM2',
							'-1' 	=> 'UM1',
							'0'		=> 'UTC',
							'1'		=> 'UP1',
							'2'		=> 'UP2',
							'3.5' 	=> 'UP25', 
							'3' 	=> 'UP3',
							'4.5' 	=> 'UP35', 
							'4' 	=> 'UP4',
							'4.5' 	=> 'UP45', 
							'5' 	=> 'UP5',
							'6' 	=> 'UP6',
							'7' 	=> 'UP7',
							'8'		=> 'UP8',
							'9.5'	=> 'UP85', 
							'9'		=> 'UP9',
							'10' 	=> 'UP10',
							'11' 	=> 'UP11',
							'12' 	=> 'UP11',
						);
	
	function __construct()
	{	
		include_once(APPPATH."timezone/geoipcity.inc");
		include_once(APPPATH."timezone/geoipregionvars.php");
		include_once(APPPATH."timezone/tz.php");
		
	}
	
	function get_country_code_by_ip($ip)
	{
		$gi = geoip_open(APPPATH."timezone/GeoLiteCity.dat",GEOIP_STANDARD);
		$record = geoip_record_by_addr($gi,$ip);
		geoip_close($gi);
		
		if ($record) 
		{
			return $record->country_code;
		}
		
		return false;
	}
	
	function get_region_by_ip($ip)
	{
		$gi = geoip_open(APPPATH."timezone/GeoLiteCity.dat",GEOIP_STANDARD);
		$record = geoip_record_by_addr($gi,$ip);
		geoip_close($gi);
		
		return $record->region;
	}
	
	function get_time_zone($cc, $rc)
	{
		return get_time_zone($cc, $rc);
	}
	
	function get_timezone_offset($from_tz, $to_tz)
	{
		return get_timezone_offset($from_tz, $to_tz)/(60*60);
	}
	
	function get_timezone_offset_by_ip($ip)
	{
		$gi = geoip_open(APPPATH."timezone/GeoLiteCity.dat",GEOIP_STANDARD);
		$record = geoip_record_by_addr($gi,$ip);
		geoip_close($gi);
		
		if ($record) 
		{
			$local_timezone = $this->get_time_zone($record->country_code, $record->region);
			
			if ($local_timezone) 
			{
				$gmt_timezone = $this->gmt_timezone;

				return $this->get_timezone_offset($gmt_timezone, $local_timezone);
			}
		}
		
		return false;
	}
	
	function get_timezone_by_ip($ip)
	{
		return $this->timezones[$this->get_timezone_offset_by_ip($ip)];
	}
}

/* End of file Timezone.php */
/* Location: ./system/application/libraries/Timezone.php */