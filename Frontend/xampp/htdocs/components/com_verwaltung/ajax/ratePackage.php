<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');
?>

<?php 
if(isset($_GET['packageId']) && !empty($_GET['packageId'])){
	if(isset($_GET['rating']) && !empty($_GET['rating'])){
		saveRatingForPackage($_GET['packageId'], $_GET['rating']);
	}
}
?>