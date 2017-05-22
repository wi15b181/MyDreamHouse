<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');
?>

<?php 
if(isset($_GET['terminId']) && !empty($_GET['terminId'])){
	saveSalesMessage($_GET);
}
?>