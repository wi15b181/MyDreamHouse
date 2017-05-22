<?php
defined('_JEXEC') or die('Restricted access');

include(JPATH_COMPONENT_SITE.'/inc/dbutil.php');
?>

<?php 
if(isset($_GET['packageId']) && !empty($_GET['packageId'])){
	saveSale($_GET);
	echo updateCustomerPackage($_GET);
}
?>