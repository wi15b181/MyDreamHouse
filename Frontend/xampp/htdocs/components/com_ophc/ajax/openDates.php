<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');
?>

<?php 
if(isset($_GET['beraterId']) && !empty($_GET['beraterId'])){
	if(isset($_GET['date']) && !empty($_GET['date'])){		
		
		var_dump($_GET);
		
		$blockedDates = getOpenDatesForDayAndConsultant($_GET['date'], $_GET['beraterId']);
		
		$blockedHours = array();
		foreach ($blockedDates as $blockedDate){
			$start = ltrim($blockedDate->starttime,'0');
			$end = ltrim($blockedDate->endtime,'0');
			for($i = $start; $i <= $end && $i <= 24; $i++){
				if(!in_array($i, $blockedHours)){
					array_push($blockedHours, $i);
				}
			}
		}
		
		for ($i = 8; $i <= 18; $i++){
			if(!in_array($i, $blockedHours)){
				echo '<option value="'.sprintf('%02d', $i).'">'.sprintf('%02d', $i).":00 - ".sprintf('%02d', $i+1).':00</option>';
			}
		}
	}
}
?>