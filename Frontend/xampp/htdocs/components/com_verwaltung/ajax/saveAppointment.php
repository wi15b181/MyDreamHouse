<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');
?>

<?php 
if(isset($_GET['packageId']) && !empty($_GET['packageId'])){
	if(isset($_GET['day']) && !empty($_GET['day'])){		
		if(isset($_GET['time']) && !empty($_GET['time'])){	
			echo saveAppointment($_GET['packageId'], $_GET['day'], $_GET['time']);
		}
	}
}
?>