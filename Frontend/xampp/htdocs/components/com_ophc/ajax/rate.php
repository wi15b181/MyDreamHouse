<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');
?>

<?php 
if(isset($_GET['refId']) && !empty($_GET['refId'])){
	if(isset($_GET['rating']) && !empty($_GET['rating'])){
		if(isset($_GET['type']) && !empty($_GET['type'])){
			saveRating($_GET['refId'], $_GET['rating'],$_GET['type']);
		}
	}
}
?>