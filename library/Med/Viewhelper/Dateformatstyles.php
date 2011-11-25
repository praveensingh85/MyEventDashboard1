<?php
class Med_Viewhelper_Dateformatstyles 
{
    function datestyle($date)
    {
        if (strlen($date) >= 10) {
		   if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
			return '';
		   }
		   $mktime	= mktime(0,	0, 0, substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
		   return date("j/M/Y", $mktime);
	     } else {
		return $s;
	    }
    }
	
	 
	 function time_style($time)
{
 if (strlen($time) >= 5) {
 return date("g:i A", strtotime($time));
 } else {
  return $s='';
 }
}
// set currency of login user
function datetimestyle($date)
    {
        if (strlen($date) >= 10) {
		   if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
			return '';
		   }
		   $mktime	= mktime(0,	0, 0, substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
		   return date("d-M-Y", $mktime);
	     } else {
		return $s;
	    }
    }
}